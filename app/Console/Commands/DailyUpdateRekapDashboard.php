<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\Member;
use App\Models\Outstanding;
use App\Models\RekapDashboardDay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DailyUpdateRekapDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-update-rekap-dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();

        try {

            $dataOutstanding = Outstanding::select(
                'username', 
                DB::raw('SUM(amount) as totalnominalots'),
                DB::raw('COUNT(transactionid) as totalcountots')
            )
            ->groupBy('username')  
            ->get();  
        
            $totalSumNominal = $dataOutstanding->sum('totalnominalots');
            $totalCountTransaction = $dataOutstanding->count('totalcountots');


            $starDate = date('Y-m-d', strtotime('-1 day')) . ' 00:00:00';
            $endDate = date('Y-m-d', strtotime('-1 day')) . ' 23:59:59';

            if ($dataOutstanding) {
                RekapDashboardDay::whereBetween('created_at', [$starDate, $endDate])
                    ->increment('sum_cash_balance', $totalSumNominal);
                RekapDashboardDay::whereBetween('created_at', [$starDate, $endDate])
                    ->increment('sum_total_balance', $totalCountTransaction);
                RekapDashboardDay::whereBetween('created_at', [$starDate, $endDate])
                    ->increment('sum_member_balance', Balance::sum('amount'));
                RekapDashboardDay::whereBetween('created_at', [$starDate, $endDate])
                    ->increment('new_total_member', Member::count('id'));
            }

            DB::commit();
            // $this->info($dataOutstanding);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->info('gagal cocote');
            // \Log::error('Error during handle: ' . $e->getMessage());
        }
    }
}
