<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CommandFetchingOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:command-fetching-old-data';

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
        $pathurl = 'https://0ld-ge4ser-www.glbwgag.com/api/olddata';
        $request = [
            "fromdate" => date('Y-m-01', strtotime('first day of last month')),
            "todate" => date('Y-m-t', strtotime('first day of last month')),
            "bulan" => date('m', strtotime('first day of last month')),
            "tahun" => date('Y', strtotime('first day of last month'))
        ];

        $endpoints = [
            '/historycoins',
            '/historytransaksi',
            //     '/refaktif',
            //     '/refdepo',
            //     '/winlossbet',
            //     '/winloss'
        ];

        foreach ($endpoints as $endpoint) {
            $this->apiGetOldData($pathurl . $endpoint, $request);

            // Adding a 1-minute delay between each request
            // sleep(60);
        }

        $this->info('Success Fully.');
    }

    public function apiGetOldData($url, $request)
    {
        try {
            $response = Http::withHeaders([
                'utilitiesgenerate' => env('UTILITIES_GENERATE'),
                'Content-Type' => 'application/json',
            ])->get($url, $request);

            if ($response->successful()) {
                $data = $response->json();
                $this->info("Data berhasil di-fetch: " . json_encode($data));
            } else {
                $this->error("Gagal mengambil data, status code: " . $response->status());
            }
        } catch (\Exception $e) {
            $this->error("Terjadi kesalahan: " . $e->getMessage());
        }
    }
}
