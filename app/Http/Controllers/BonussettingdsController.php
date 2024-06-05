<?php

namespace App\Http\Controllers;

use App\Models\BetSetting;
use App\Models\Bonus;
use App\Models\Persentase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BonussettingdsController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        return view('bonussettingds.index', [
            'title' => 'Referral',
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'min' => 'required|numeric|min:0',
            'max' => 'required|numeric|min:0',
            'sportsbook' => 'required|numeric|min:0|max:100',
            'virtualsports' => 'required|numeric|min:0|max:100',
            'games' => 'required|numeric|min:0|max:100',
            'seamlesgames' => 'required|numeric|min:0|max:100',
            'cashback' => 'required|numeric|min:0|max:100',
            'rollingan' => 'required|numeric|min:0|max:100',
        ]);

        $max = $request->max;
        $min = $request->min;
        $sportsbook = $request->sportsbook;
        $virtualsports = $request->virtualsports;
        $games = $request->games;
        $seamlesgames = $request->seamlesgames;
        $cashback = $request->cashback;
        $rollingan = $request->rollingan;

        //update max min bet Agent
        $updateMaxMin = $this->apiUpdateAgent($max, $min);
        if ($updateMaxMin["error"]["id"] === 0) {

            $dataBetSetting = BetSetting::where('id', 1)->first();
            $reqBetSetting = [
                'min' => $request->min,
                'max' => $request->max
            ];
            if ($dataBetSetting) {
                $dataBetSetting->update($reqBetSetting);
            } else {
                BetSetting::create($reqBetSetting);
            }

            $dataPersentaseSB = Persentase::where('jenis', 'SportsBook')->first();
            if ($dataPersentaseSB) {
                $dataPersentaseSB->update([
                    'persentase' => $request->sportsbook
                ]);
            } else {
                Persentase::create([
                    'jenis' => 'SportsBook',
                    'persentase' => $request->sportsbook
                ]);
            }

            $dataPersentaseVS = Persentase::where('jenis', 'VirtualSports')->first();
            if ($dataPersentaseVS) {
                $dataPersentaseVS->update([
                    'persentase' => $request->virtualsports
                ]);
            } else {
                Persentase::create([
                    'jenis' => 'SportsBook',
                    'persentase' => $request->virtualsports
                ]);
            }

            $dataPersentaseG = Persentase::where('jenis', 'Games')->first();
            if ($dataPersentaseG) {
                $dataPersentaseG->update([
                    'persentase' => $request->games
                ]);
            } else {
                Persentase::create([
                    'jenis' => 'SportsBook',
                    'persentase' => $request->games
                ]);
            }


            $dataPersentaseSG = Persentase::where('jenis', 'SeamlessGame')->first();
            if ($dataPersentaseSG) {
                $dataPersentaseSG->update([
                    'persentase' => $request->seamlesgames
                ]);
            } else {
                Persentase::create([
                    'jenis' => 'SportsBook',
                    'persentase' => $request->seamlesgames
                ]);
            }


            $dataSettingCashback = Bonus::where('jenis_bonus', 'cashback')->first();
            if ($dataSettingCashback) {
                $dataSettingCashback->update([
                    'persentase' => $request->cashback
                ]);
            } else {
                Bonus::create([
                    'jenis_bonus' => 'cashback',
                    'persentase' => $request->cashback
                ]);
            }





            return redirect('/agentds')->with('success', 'Aget berhasil ditambahkan.');
        }

        // // Create the user
        // $user = new User();
        // $user->name = $request->input('name');
        // $user->email = $request->input('email');
        // $user->password = bcrypt($request->input('password'));
        // $user->save();

        // Redirect back with a message
        return redirect()->back()->with('success', 'User created successfully');
    }

    function apiUpdateAgent($max, $min)
    {
        $data = [
            "Username" => "Agent_B_001",
            "Min" => $min,
            "Max" => $max,
            "MaxPerMatch" => 20000,
            "CasinoTableLimit" => 1,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];

        $url = env('BODOMAIN') . '/web-root/restricted/agent/update-agent-preset-bet-settings.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        $responseData = $response->json();

        return ['url' => $responseData["url"]];
    }
}
