<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WinlossbetDay;
use App\Models\WinlossbetMonth;
use App\Models\WinlossbetYear;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AddWinlossStakeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     */
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
            $username = $this->data['username'];
            // Log::info('username:', ['username' => $username]);
            $transfercode = $this->data['transfercode'];
            $portfolio = $this->data['portfolio'];
            $amountWL = $this->data['amount'];
            $amount = $this->data['amount_bet'];
            $jenis = $this->data['jenis'];

            // Log::info('cc:', ['data' => $this->data]);
            // if($portfolio == 'SportsBook' || $portfolio == 'VirtualSports') {
            //     $response = $this->getApi($transfercode, $portfolio);
            //     if ($response["error"]["id"] === 0) {
            //         $results = $response["result"][0];
            //         $results['username'] = $this->convertUsername($results['username']);
            //         $username = $results['username'];
            //         $amount = $results['stake'];
            //         $responseWL = $this->createWinLoseStake($username, $portfolio, $amount, $amountWL, $jenis);
            //     }
            // } else {
            $username = $this->convertUsername($username);
            $responseWL = $this->createWinLoseStake($username, $portfolio, $amount, $amountWL, $jenis);
            // }

            // Log::info('cc:', ['data' => $responseWL]);
        } catch (\Exception $e) {
            Log::error('Failed to process AddWinlossStakeJob: ' . $e->getMessage());
        }
    }

    // private function getApi($refNos, $portfolio)
    // {
    //     $data = [
    //         'refNos' => $refNos,
    //         'portfolio' => $portfolio,
    //         'companyKey' => env('COMPANY_KEY'),
    //         'language' => 'en',
    //         'serverId' => env('SERVERID')
    //     ];
    //     $apiUrl = env('BODOMAIN') . '/web-root/restricted/report/get-bet-list-by-refnos.aspx';
    //     $response = Http::post($apiUrl, $data);
    //     return $response->json();
    // }

    private function createWinLoseStake($username, $portfolio, $amount, $amountWL, $jenis)
    {
        if ($amountWL > 0) {
            $amountWL = $amountWL - $amount;
        }

        /* Winloss Bet Day */
        $winlossbet_day = WinlossbetDay::where('username', $username)
            ->where('portfolio', $portfolio)
            ->where('day', date('d'))
            ->where('month', date('m'))
            ->where('year', date('Y'))->first();

        if ($winlossbet_day) {
            if ($jenis == 'settle') {
                $winlossbet_day->increment('stake', $amount);
                $winlossbet_day->increment('winloss', $amountWL);
            } else if ($jenis == 'cancel' || $jenis == 'rollback') {
                $winlossbet_day->decrement('stake', $amount);
                $winlossbet_day->decrement('winloss', $amountWL);
            }
        } else {
            $winlossbet_day = WinlossbetDay::create([
                'username' => $username,
                'portfolio' => $portfolio,
                'day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'),
                'stake' => $amount,
                'winloss' => $amountWL
            ]);
        }

        return $winlossbet_day;

        /* Winloss Bet Month */
        $winlossbet_month = WinlossbetMonth::where('username', $username)
            ->where('portfolio', $portfolio)
            ->where('month', date('m'))
            ->where('year', date('Y'))->first();

        if ($winlossbet_month) {
            if ($jenis == 'settle') {
                $winlossbet_month->increment('stake', $amount);
                $winlossbet_month->increment('winloss', $amountWL);
            } else if ($jenis == 'cancel' || $jenis == 'rollback') {
                $winlossbet_month->decrement('stake', $amount);
                $winlossbet_month->decrement('winloss', $amountWL);
            }
        } else {
            $winlossbet_month = WinlossbetMonth::create([
                'username' => $username,
                'portfolio' => $portfolio,
                'month' => date('m'),
                'year' => date('Y'),
                'stake' => $amount,
                'winloss' => $amountWL
            ]);
        }

        /* Winloss Bet Year */
        $winlossbet_year = WinlossbetYear::where('username', $username)
            ->where('portfolio', $portfolio)
            ->where('year', date('Y'))->first();

        if ($winlossbet_year) {
            if ($jenis == 'settle') {
                $winlossbet_year->increment('stake', $amount);
                $winlossbet_year->increment('winloss', $amountWL);
            } else if ($jenis == 'cancel' || $jenis == 'rollback') {
                $winlossbet_year->decrement('stake', $amount);
                $winlossbet_year->decrement('winloss', $amountWL);
            }
        } else {
            WinlossbetYear::create([
                'username' => $username,
                'portfolio' => $portfolio,
                'year' => date('Y'),
                'stake' => $amount,
                'winloss' => $amountWL
            ]);
        }
    }

    private function convertUsername($username)
    {
        $username = explode(env('UNIX_CODE'), $username);
        if (isset($username[1])) {
            $username = $username[1];
        } else {
            $username = $username[0];
        }

        return $username;
    }
}
