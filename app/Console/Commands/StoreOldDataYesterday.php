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
        $date = Carbon::now()->subDays(1)->format('Y-m-d');
        $newRequest = new Request([
            'getdate' => 'yesterday',
            'fromdate' => $date,
            'todate' => $date,
        ]);

        $data = app()->call('App\Http\Controllers\DashboardController@oldData', ['request' => $newRequest]);

        Redis::setex('yesterday', 86400, json_encode($data));

        $this->info('Data stored in Redis successfully.');

        return 0;
    }
}
