<?php

namespace App\Http\Controllers;

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

    public function create(Request $request)
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
