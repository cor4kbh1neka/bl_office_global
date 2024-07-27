<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Http\Request;


class StoreHistoryCoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:old-data-coin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store old data of yesterday into Redis cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $fromdateyesterday = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d');

        $todatelastmonth = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');

        // $fromdateyesterday = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');

        // $todatelastmonth = Carbon::now()->subDay(1)->endOfDay()->format('Y-m-d');
        $redisKeyOldCoin = 'olddatacoins';


        // Memeriksa apakah ada data di Redis
        if (Redis::exists($redisKeyOldCoin)) {
            $existingData = json_decode(Redis::get($redisKeyOldCoin), true);
        } else {
            $existingData = [];
        }


        $newRequest = new Request([
            'getdate' => 'olddatacoins',
            'fromdate' => $fromdateyesterday,
            'todate' => $todatelastmonth,
        ]);

        $data = app()->call('App\Http\Controllers\ApiController@old_datahistorycoin', ['request' => $newRequest]);
        $combinedData = array_merge($existingData, $data->toArray());


        Redis::setex($redisKeyOldCoin, 86400, json_encode($combinedData));

        $this->info('Data stored in Redis successfully.');
        return;
    }
}
