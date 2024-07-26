<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreOldDataOneWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:old-data-one-week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store old data of 1 week into Redis cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $fromdateOneWeek = Carbon::now()->subWeek()->startOfDay()->format('Y-m-d'); // 1 minggu lalu dari jam 00:00
        $todateOneWeek = Carbon::now()->subDay()->endOfDay()->format('Y-m-d'); // Kemarin sampai jam 23:59
        $redisKeyOneWeek = 'OneWeek';
        Redis::del($redisKeyOneWeek);
        $newRequest = new Request([
            'getdate' => 'OneWeek',
            'fromdate' => $fromdateOneWeek,
            'todate' => $todateOneWeek,
        ]);
        $data = app()->call('App\Http\Controllers\DashboardController@oldData', ['request' => $newRequest]);
        Redis::setex($redisKeyOneWeek, 86400, json_encode($data));
        $this->info('Data stored in Redis successfully.');

        return 0;
    }
}
