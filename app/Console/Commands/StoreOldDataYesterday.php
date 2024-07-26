<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreOldDataYesterday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:old-data-yesterday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store old data of yesterday into Redis cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $fromdateyesterday = Carbon::now()->subDay()->startOfDay()->format('Y-m-d');
        $todateyesterday = Carbon::now()->subDay()->endOfDay()->format('Y-m-d');
        $redisKeyyesterday = 'yesterday';
        // $redisKeyyesterday = 'olddata:lastweek_' . $fromdateyesterday . '-' . $todateyesterday;
        // if (Redis::exists($redisKeyyesterday)) {
        // $data = json_decode(Redis::get($redisKeyyesterday), true);
        // } else {
        Redis::del($redisKeyyesterday);
        $newRequest = new Request([
            'getdate' => 'yesterday',
            'fromdate' => $fromdateyesterday,
            'todate' => $todateyesterday,
        ]);

        //     $data = $this->oldData($newRequest);
        //     Redis::setex($redisKeyyesterday, 86400, json_encode($data));
        // }
        // return response()->json($data);


        // $date = Carbon::now()->subDays(1)->format('Y-m-d');
        // $newRequest = new Request([
        //     'getdate' => 'yesterday',
        //     'fromdate' => $date,
        //     'todate' => $date,
        // ]);

        $data = app()->call('App\Http\Controllers\DashboardController@oldData', ['request' => $newRequest]);

        Redis::setex($redisKeyyesterday, 86400, json_encode($data));

        $this->info('Data stored in Redis successfully.');

        return 0;
    }
}
