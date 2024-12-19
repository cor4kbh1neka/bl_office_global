<?php

namespace App\Jobs;

use App\Models\RekapDashboardDay;
use App\Models\RekapDashboardMonth;
use App\Models\RekapDashboardYear;
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

        // throw $e;
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
            $month = Carbon::now()->format('m'); 
            $year = Carbon::now()->format('Y');

            $existsToday = RekapDashboardDay::whereDate('created_at', Carbon::today())
                ->lockForUpdate() 
                ->first();

            $existsMonthly = RekapDashboardMonth::where('month', $month)
                ->where('year', $year)
                ->lockForUpdate() 
                ->first();

            $existsYearly = RekapDashboardYear::where('year', $year)
                ->lockForUpdate() 
                ->first();

            if (!$existsToday) {
                $existsToday = RekapDashboardDay::create([
                    'created_at' => Carbon::now()
                ]);
            }

            if (!$existsMonthly) {
                $existsMonthly = RekapDashboardMonth::create([
                    'month' => $month,
                    'year' => $year,
                    'created_at' => Carbon::now()
                ]);
            }

            if (!$existsYearly) {
                $existsYearly = RekapDashboardYear::create([
                    'year' => $year,
                    'created_at' => Carbon::now()
                ]);
            }

            if ($jenis == 'Settle') {
                $existsToday->increment('count_bet_settled', 1);
                $existsToday->increment('sum_bet_settled', $amountSettle);

                $existsMonthly->increment('count_bet_settled', 1);
                $existsMonthly->increment('sum_bet_settled', $amountSettle);

                $existsYearly->increment('count_bet_settled', 1);
                $existsYearly->increment('sum_bet_settled', $amountSettle);
            } else if ($jenis == 'Rollback' || $jenis == 'Cancel') {
                $existsToday->decrement('count_bet_settled', 1);
                $existsToday->decrement('sum_bet_settled', $amountSettle);

                $existsMonthly->decrement('count_bet_settled', 1);
                $existsMonthly->decrement('sum_bet_settled', $amountSettle);

                $existsYearly->decrement('count_bet_settled', 1);
                $existsYearly->decrement('sum_bet_settled', $amountSettle);
            }
        });
    }

}
