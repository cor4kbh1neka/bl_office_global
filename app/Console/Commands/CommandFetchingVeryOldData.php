<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CommandFetchingVeryOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:command-fetching-very-old-data';

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
        $tgldari = Carbon::parse("2024-06-01");
        $tglsampai = Carbon::parse("2024-09-30");

        $this->getOldData($tgldari, $tglsampai);
    }

    private function getOldData($tgldari, $tglsampai)
    {
        $dates = [];

        while ($tgldari->lessThanOrEqualTo($tglsampai)) {
            $bulan = $tgldari->format('m');
            $tahun = $tgldari->format('Y');

            $bulanTgldari = $tgldari->copy();
            $bulanTglsampai = $tgldari->copy()->endOfMonth();

            if ($bulanTglsampai->greaterThan($tglsampai)) {
                $bulanTglsampai = $tglsampai;
            }

            $dates[] = [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tgldari' => $bulanTgldari->toDateString(),
                'tglsampai' => $bulanTglsampai->toDateString(),
            ];

            // Pindah ke bulan berikutnya
            $tgldari->addMonth()->startOfMonth();
        }

        $pathurl = 'https://0ld-ge4ser-www.glbwgag.com/api/olddata';
        foreach ($dates as $date) {
            $this->apiGetOldData($pathurl . '/historycoins', $date);
            $this->apiGetOldData($pathurl . '/historytransaksi', $date);
            $this->apiGetOldData($pathurl . '/refaktif', $date);
            $this->apiGetOldData($pathurl . '/refdepo', $date);
            $this->apiGetOldData($pathurl . '/winlossbet', $date);
            $this->apiGetOldData($pathurl . '/winloss', $date);
        }
    }

    private function apiGetOldData($url, $request)
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
