<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OldDataOneMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:old-data-one-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store old data of 1 month into Redis cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fromdateOneMonth = Carbon::now()->subMonth()->startOfDay()->format('Y-m-d');
        $todateOneMonth = Carbon::now()->subDay()->endOfDay()->format('Y-m-d');
        $redisKeyOneMonth = 'OneMonth';
        Redis::del($redisKeyOneMonth);
        $newRequest = new Request([
            'getdate' => 'OneMonth',
            'fromdate' => $fromdateOneMonth,
            'todate' => $todateOneMonth,
        ]);
        $data = app()->call('App\Http\Controllers\DashboardController@oldData', ['request' => $newRequest]);
        Redis::setex($redisKeyOneMonth, 86400, json_encode($data));
        $this->info('Data stored in Redis successfully.');
        return 0;
    }
}
