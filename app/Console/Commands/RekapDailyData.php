<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\Member;
use App\Models\RekapDashboardDay;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RekapDailyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rekap-daily-data';

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
        $dataDashboard = $this->updateRekapDashboard();
    }

    private function updateRekapDashboard()
{
    DB::transaction(function () {
        $existsYesterday = RekapDashboardDay::whereDate('created_at', Carbon::yesterday())->first();

        if (!$existsYesterday) {
            $existsYesterday = RekapDashboardDay::create([
                'sum_member_balance' => Balance::sum('amount'),
                'new_total_member' => Member::count('id'),
                'created_at' => Carbon::yesterday() 
            ]);
        }

        $existsYesterday->increment('sum_member_balance', Balance::sum('amount'));
        $existsYesterday->increment('new_total_member', Member::count('id'));
    });
}
}
