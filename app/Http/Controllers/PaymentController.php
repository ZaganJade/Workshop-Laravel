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

            if (!$userId) {
                session()->push('guest_orders', $pesanan->idpesanan);
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

            /**
             * 🔥 SANDBOX STABILITY FIX
             * Selalu buat Order ID baru dengan suffix acak setiap kali request Snap Token.
             * Ini mencegah error 2603 (Failed to process QR) yang sering terjadi di Sandbox
             * jika menggunakan kembali Order ID yang sesinya sudah kadaluarsa/error.
             */
            $orderId = 'WP-' . $pesanan->idpesanan . '-' . time() . bin2hex(random_bytes(2));

            \Log::info('Midtrans Lifecycle: Generating fresh Order ID for payment session', [
                'idpesanan' => $id,
                'order_id' => $orderId,
                'gross_amount' => $pesanan->total
            ]);

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

            // 🔥 Debug: Capture the exact URL sent to Midtrans
            $notificationUrl = url('/midtrans/callback');
            
            \Log::info('Midtrans Debug: Notification URL Sent to Midtrans', [
                'order_id' => $orderId,
                'notification_url' => $notificationUrl,
                'APP_URL' => env('APP_URL'),
                'current_request_host' => request()->getHost()
            ]);

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
                'notification_url' => $notificationUrl,
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
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
              ->header('Pragma', 'no-cache');
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
         * 🔥 ROBUSTNESS FALLBACK (DIPATIKAN/COMMENTED)
         * Jika Anda ingin mengaktifkan sinkronisasi otomatis saat user masuk ke halaman ini,
         * hapus tanda komentar di bawah ini.
         */
        /*
        if ($pesanan->payment && $pesanan->payment->status == 'menunggu') {
            try {
                $orderId = $pesanan->payment->order_id_midtrans;
                
                // Fetch status directly from Midtrans API
                $status = \Midtrans\Transaction::status($orderId);
                
                if ($status) {
                    $statusArray = json_decode(json_encode($status), true);
                    \App\Http\Controllers\MidtransController::processStatusUpdate(
                        $orderId,
                        $statusArray['transaction_status'] ?? 'pending',
                        $statusArray['fraud_status'] ?? null,
                        [
                            'transaction_id' => $statusArray['transaction_id'] ?? null,
                            'payment_type' => $statusArray['payment_type'] ?? null,
                            'bank' => $statusArray['bank'] ?? ($statusArray['va_numbers'][0]['bank'] ?? null),
                            'raw_response' => $statusArray,
                        ]
                    );
                    
                    // Refresh model and its relationships to reflect changes from Midtrans sync
                    $pesanan->refresh();
                }
            } catch (\Exception $e) {
                // If 404 or connection error, we log it but still show the page
                \Log::warning('Midtrans Sync Fallback: Failed to fetch status for ' . $id . '. Error: ' . $e->getMessage());
            }
        }
        */

        // The view will automatically handle showing Success vs Pending based on status_bayar
        return view('Feature-Merchant.payment_success', compact('pesanan'));
    }

    public function pendingOrders()
    {
        $userId = auth()->id();
        $guestOrderIds = session()->get('guest_orders', []);

        $query = Pesanan::with('payment', 'details.menu')
            ->where('status_bayar', 'menunggu');

        if ($userId) {
            $query->where(function ($q) use ($userId, $guestOrderIds) {
                $q->where('user_id', $userId)
                  ->orWhereIn('idpesanan', $guestOrderIds);
            });
        } else {
            if (empty($guestOrderIds)) {
                $pesanans = collect();
            } else {
                $query->whereIn('idpesanan', $guestOrderIds);
            }
        }

        $pesanans = isset($pesanans) ? $pesanans : $query->orderBy('created_at', 'desc')->get();

        return view('Feature-Merchant.pending_orders', compact('pesanans'));
    }
}
