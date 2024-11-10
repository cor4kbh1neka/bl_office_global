<?php

namespace App\Jobs;

use App\Models\RekapDashboardDay;
use App\Models\TransactionSaldo;
use App\Models\TransactionStatus;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessRekapDashboardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data; 
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
        $trans_id = $this->data['trans_id'];
        $jenis = $this->data['jenis'];
        $amount = $this->data['amount'];

        $this->updateRekapDashboard($trans_id, $jenis, $amount);
    } catch (\Exception $e) {
        Log::error('ProcessRekapDashboardJob failed: ' . $e->getMessage(), [
            'data' => $this->data,
            'trace' => $e->getTraceAsString()
        ]);

        throw $e;
    }
    }

    private function updateRekapDashboard($trans_id, $jenis, $amount)
    {
        $transactionStatus = TransactionStatus::where('trans_id', $trans_id)->where('urutan', 1)->first();

        if (!$transactionStatus) {
            return; 
        }

        $transtatus_id = $transactionStatus->id;
        $transactionSaldo = TransactionSaldo::where('transtatus_id', $transtatus_id)->where('urutan', 1)->first();

        if (!$transactionSaldo) {
            return; 
        }

        $amountBetting = $transactionSaldo->amount;

        if ($amount < $amountBetting) {
            return;
        }
        
        $amountSettle = $amount - $amountBetting;

        DB::transaction(function () use ($amountSettle, $jenis) {
            $existsToday = RekapDashboardDay::whereDate('created_at', Carbon::today())->first();

            if (!$existsToday) {
                $existsToday = RekapDashboardDay::create([
                    'created_at' => Carbon::now()
                ]);
            }
            if($jenis == 'Settle') {
                $existsToday->increment('count_bet_settled', 1);
                $existsToday->increment('sum_bet_settled', $amountSettle);
            } else if ($jenis == 'Rollback') {
                $existsToday->decrement('count_bet_settled', 1);
                $existsToday->decrement('sum_bet_settled', $amountSettle);
            } else if ($jenis == 'Cancel') {
                $existsToday->decrement('count_bet_settled', 1);
                $existsToday->decrement('sum_bet_settled', $amountSettle);
            }
        });
    }
}
