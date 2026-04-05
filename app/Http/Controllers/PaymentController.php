<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $vendors = Vendor::all();
        return view('Feature-Merchant.pos', compact('vendors'));
    }

    public function getMenusByVendor($idvendor)
    {
        $menus = Menu::where('idvendor', $idvendor)->get();
        return response()->json($menus);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menus,idmenu',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $user = auth()->user();
            $userId = $user ? $user->id : null;
            $nama = $user ? ($user->username ?? $user->name) : $this->generateGuestName();

            $total = 0;
            foreach ($request->items as $item) {
                $menu = Menu::find($item['id']);
                $total += $menu->harga * $item['qty'];
            }

            $pesanan = Pesanan::create([
                'user_id' => $userId,
                'nama' => $nama,
                'total' => $total,
                'status_bayar' => 'menunggu',
            ]);

            foreach ($request->items as $item) {
                $menu = Menu::find($item['id']);
                DetailPesanan::create([
                    'idpesanan' => $pesanan->idpesanan,
                    'idmenu' => $menu->idmenu,
                    'jumlah' => $item['qty'],
                    'harga' => $menu->harga,
                    'subtotal' => $menu->harga * $item['qty'],
                ]);
            }

            return response()->json(['idpesanan' => $pesanan->idpesanan]);
        });
    }

    private function generateGuestName()
    {
        $count = Pesanan::whereNull('user_id')->count() + 1;
        return 'Guest_' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    public function getSnapToken($id)
    {
        try {
            $pesanan = Pesanan::with('details.menu', 'payment')->findOrFail($id);

            // 🔥 Lifecycle Fix: Check if user is now logged in but pesanan was guest
            if (auth()->check() && is_null($pesanan->user_id)) {
                $pesanan->update([
                    'user_id' => auth()->id(),
                    'nama' => auth()->user()->username ?? auth()->user()->name
                ]);
                \Log::info('Midtrans Lifecycle: Guest Pesanan linked to User', [
                    'idpesanan' => $id,
                    'user_id' => auth()->id()
                ]);
            }

            // 🔥 Order ID Stabilization: Use existing order_id if available to prevent Error 900
            $existingPayment = Payment::where('idpesanan', $id)
                ->where('status', 'menunggu')
                ->first();

            if ($existingPayment) {
                $orderId = $existingPayment->order_id_midtrans;
                \Log::info('Midtrans Lifecycle: Re-using existing stable Order ID', [
                    'order_id' => $orderId,
                    'gross_amount' => $pesanan->total
                ]);
            } else {
                // 🔥 Simplified Format: Single dash as recommended by Midtrans for Sandbox stability
                $orderId = 'WP-' . $pesanan->idpesanan . '-' . bin2hex(random_bytes(4));
                \Log::info('Midtrans Lifecycle: Generating new simplified Order ID', [
                    'order_id' => $orderId,
                    'gross_amount' => $pesanan->total
                ]);
            }

            // Ensure Server Key is set
            if (empty(Config::$serverKey) || Config::$serverKey == 'SB-Mid-server-xxxxxxxxxxxx') {
                return response()->json([
                    'message' => 'Midtrans Server Key belum dikonfigurasi di file .env.'
                ], 500);
            }

            $itemDetails = [];
            foreach ($pesanan->details as $detail) {
                $itemDetails[] = [
                    'id' => (string) $detail->idmenu,
                    'price' => (int) $detail->harga,
                    'quantity' => (int) $detail->jumlah,
                    'name' => substr($detail->menu->nama_menu, 0, 50),
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $pesanan->total,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => substr($pesanan->nama, 0, 20),
                    'email' => auth()->check() ? auth()->user()->email : 'guest@example.com',
                ],
                'callbacks' => [
                    'finish' => route('payment.success', ['id' => $pesanan->idpesanan]),
                    'error' => route('pos'),
                    'pending' => route('payment.success', ['id' => $pesanan->idpesanan]),
                ],
                'notification_url' => url('/midtrans/callback'),
            ];

            // Update or Create Payment record BEFORE getting Snap Token to ensure DB integrity
            Payment::updateOrCreate(
                ['idpesanan' => $pesanan->idpesanan, 'status' => 'menunggu'],
                [
                    'order_id_midtrans' => $orderId,
                    'gross_amount' => $pesanan->total,
                ]
            );

            // Snap::getSnapToken is idempotent for the same order_id in Midtrans
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'status' => 'menunggu'
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Lifecycle Error: ' . $e->getMessage(), [
                'idpesanan' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan pada Midtrans: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess($id)
    {
        $pesanan = Pesanan::with('details.menu', 'payment')->findOrFail($id);

        /**
         * 🔥 ROBUSTNESS FALLBACK
         * If the status is still 'menunggu' in our DB, we manually check Midtrans API.
         * This handles cases where the Webhook (Callback) failed to deliver.
         */
        if ($pesanan->payment && $pesanan->payment->status == 'menunggu') {
            try {
                $orderId = $pesanan->payment->order_id_midtrans;
                
                // Fetch status directly from Midtrans API
                $status = \Midtrans\Transaction::status($orderId);
                
                if ($status) {
                    \App\Http\Controllers\MidtransController::processStatusUpdate(
                        $orderId,
                        $status->transaction_status,
                        $status->fraud_status ?? null,
                        [
                            'transaction_id' => $status->transaction_id,
                            'payment_type' => $status->payment_type,
                            'bank' => $status->bank ?? ($status->va_numbers[0]->bank ?? null),
                            'raw_response' => (array) $status,
                        ]
                    );
                    
                    // Refresh model to reflect changes in the view
                    $pesanan->load('payment');
                }
            } catch (\Exception $e) {
                // If 404 or connection error, we log it but still show the page
                \Log::warning('Midtrans Sync Fallback: Failed to fetch status for ' . $id . '. Error: ' . $e->getMessage());
            }
        }

        return view('Feature-Merchant.payment_success', compact('pesanan'));
    }
}
