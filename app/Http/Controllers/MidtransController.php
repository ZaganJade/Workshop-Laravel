<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    /**
     * Handle Midtrans Payment Notification (Webhook)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {
        // 1. ENSURE WEBHOOK ALWAYS LOGS INCOMING REQUEST CLEARLY
        Log::info('Midtrans Webhook: Raw Notification Received', [
            'order_id' => $request->input('order_id'),
            'transaction_status' => $request->input('transaction_status'),
            'payload' => $request->all()
        ]);

        // 2. IMPROVE SIGNATURE VALIDATION ROBUSTNESS
        $orderId = (string) $request->input('order_id');
        $statusCode = (string) $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $signatureKey = $request->input('signature_key');

        // Handle gross_amount format safely (string vs decimal)
        $signature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($signature !== $signatureKey) {
            // Attempt with normalized decimal format (Midtrans often sends .00)
            $grossAmountFixed = number_format((float)$grossAmount, 2, '.', '');
            $signatureFixed = hash("sha512", $orderId . $statusCode . $grossAmountFixed . $serverKey);
            
            if ($signatureFixed === $signatureKey) {
                $signature = $signatureFixed;
            }
        }

        if ($signature !== $signatureKey) {
            Log::error('Midtrans Webhook: Invalid Signature Challenge', [
                'order_id' => $orderId,
                'received' => $signatureKey,
                'calculated_raw' => hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey),
                'calculated_decimal' => hash("sha512", $orderId . $statusCode . number_format((float)$grossAmount, 2, '.', '') . $serverKey)
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('Midtrans Webhook: Signature Validated', ['order_id' => $orderId]);

        // 3. PROCESS UPDATE
        $success = self::processStatusUpdate(
            $orderId, 
            $request->input('transaction_status'), 
            $request->input('fraud_status'),
            [
                'transaction_id' => $request->input('transaction_id'),
                'payment_type' => $request->input('payment_type'),
                'bank' => $request->input('bank'),
                'raw_response' => $request->all()
            ]
        );

        if ($success) {
            return response()->json(['message' => 'Notification handled successfully']);
        }

        return response()->json(['message' => 'Failed to update database'], 500);
    }

    /**
     * Reusable logic to sync Midtrans status to local Database.
     * Can be called by Webhook, Success Page Fallback, or CLI.
     */
    public static function processStatusUpdate($orderId, $transactionStatus, $fraudStatus, $extraData = [])
    {
        $payment = Payment::where('order_id_midtrans', $orderId)->first();
        if (!$payment) {
            Log::error('Midtrans Processor: Payment Record Not Found', ['order_id' => $orderId]);
            return false;
        }

        $pesanan = Pesanan::where('idpesanan', $payment->idpesanan)->first();
        if (!$pesanan) {
            Log::error('Midtrans Processor: Pesanan Record Not Found', ['idpesanan' => $payment->idpesanan]);
            return false;
        }

        // Logic Mapping
        $localPaymentStatus = 'menunggu';
        $localPesananStatus = 'menunggu';

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            if ($transactionStatus == 'capture' && $fraudStatus == 'challenge') {
                $localPaymentStatus = 'menunggu';
                $localPesananStatus = 'menunggu';
            } else {
                $localPaymentStatus = 'berhasil';
                $localPesananStatus = 'lunas';
            }
        } elseif ($transactionStatus == 'pending') {
            $localPaymentStatus = 'menunggu';
            $localPesananStatus = 'menunggu';
        } elseif ($transactionStatus == 'expire') {
            $localPaymentStatus = 'kadaluarsa';
            $localPesananStatus = 'kadaluarsa';
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
            $localPaymentStatus = 'dibatalkan';
            $localPesananStatus = 'menunggu';
        }

        Log::info('Midtrans Processor: Mapping Result', [
            'order_id' => $orderId,
            'midtrans_status' => $transactionStatus,
            'mapped_payment' => $localPaymentStatus,
            'mapped_pesanan' => $localPesananStatus
        ]);

        try {
            DB::beginTransaction();

            $payment->update([
                'status' => $localPaymentStatus,
                'transaction_id' => $extraData['transaction_id'] ?? $payment->transaction_id,
                'payment_type' => $extraData['payment_type'] ?? $payment->payment_type,
                'bank' => $extraData['bank'] ?? $payment->bank,
                'raw_response' => $extraData['raw_response'] ?? $payment->raw_response,
            ]);

            $pesananData = ['status_bayar' => $localPesananStatus];
            if ($localPesananStatus == 'lunas') {
                $pesananData['paid_at'] = now();
            }
            $pesanan->update($pesananData);

            DB::commit();

            Log::info('Midtrans Processor: Database Synchronized', ['order_id' => $orderId]);
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Processor: Database Transaction Failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
