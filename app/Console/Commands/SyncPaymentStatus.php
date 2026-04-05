<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Http\Controllers\MidtransController;
use Illuminate\Console\Command;
use Midtrans\Transaction;
use Midtrans\Config;

class SyncPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:sync {order_id_midtrans? : The Midtrans Order ID (optional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually sync payment status from Midtrans API to local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure Midtrans is configured
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        $orderId = $this->argument('order_id_midtrans');

        if ($orderId) {
            $this->syncOne($orderId);
        } else {
            $this->syncAllPending();
        }
    }

    /**
     * Sync a single order by its Midtrans Order ID
     */
    private function syncOne($orderId)
    {
        $this->info("🔍 Checking status for: {$orderId}");

        try {
            $status = Transaction::status($orderId);
            
            if ($status) {
                // Reuse the same logic used by Callback and Fallback
                $success = MidtransController::processStatusUpdate(
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

                if ($success) {
                    $this->info("✅ SUCCESS: Database updated. Current status: {$status->transaction_status}");
                } else {
                    $this->error("❌ FAILED: Database sync reached, but update failed.");
                }
            }
        } catch (\Exception $e) {
            // Transaction::status throws 404 if order not found in Midtrans
            $this->error("⚠️ SKIPPED: " . $e->getMessage());
        }
    }

    /**
     * Sync all orders that are still in 'menunggu' status
     */
    private function syncAllPending()
    {
        $pendingPayments = Payment::where('status', 'menunggu')->get();
        
        if ($pendingPayments->isEmpty()) {
            $this->info("✨ No pending payments found.");
            return;
        }

        $this->info("🚀 Syncing " . $pendingPayments->count() . " pending payments...");

        foreach ($pendingPayments as $payment) {
            $this->syncOne($payment->order_id_midtrans);
        }

        $this->info("🏁 All sync jobs completed.");
    }
}
