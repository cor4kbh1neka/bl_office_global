<?php

namespace App\Http\Controllers;

use App\Models\BetSetting;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BonussettingdsController extends Controller
{
    public function index(Request $request)
    {
        $dataBetSetting = BetSetting::where('id', 1)->first();
        $dataProduct = Product::get();

        return view('bonussettingds.index', [
            'title' => 'Referral & Bonus Settings',
            'dataProduct' => $dataProduct,
            'databetsetting' => $dataBetSetting
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'min' => 'required|numeric|min:0',
            'max' => 'required|numeric|min:0',
        ]);


        try {
            // Update max min betting
            $apiResponse = $this->apiUpdateAgent($validatedData['max'], $validatedData['min']);

            if ($apiResponse['error']['id'] === 0) {
                // Update bonus dan referral
                $this->updateBonusReferral($request->all());
                return redirect('/bonussettingds')->with('success', 'Setting Bonus berhasil diupdate.');
            } else {
                return redirect()->back()->with('fail', 'Setting Bonus gagal diupdate. Error dari API.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', 'Setting Bonus gagal diupdate. Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function updateBonusReferral($allrequest)
    {
        $id_products = $allrequest['id-product'];

        foreach ($id_products as $index => $id_referral) {
            $dataReferral = Product::find($id_referral);
            dd($dataReferral);
            if ($dataReferral) {
                $success = $dataReferral->update([
                    'persen_referral' => $allrequest['persen_referral'][$index],
                    'persen_bonus' => $allrequest['persen_bonus'][$index],
                    'jenis_bonus' => $allrequest['jenis_bonus'][$index],
                    'min_lose_bet' => $allrequest['min_lose_bet'][$index]
                ]);

                if ($success) {
                    // Update berhasil
                    dd($success);
                    return response()->json(['message' => 'Update berhasil'], 200);
                } else {
                    dd('gagal');
                    // Update gagal
                    return response()->json(['message' => 'Update gagal'], 500);
                }
            }
        }

        return true;
    }

    private function apiUpdateAgent($max, $min)
    {
        $data = [
            "Username" => env('AGENTID'),
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

        if ($response->successful()) {
            $responseData = $response->json();

            if ($responseData && $responseData["error"]["id"] === 0) {
                $dataBetSetting = BetSetting::where('id', 1)->first();
                $reqBetSetting = [
                    'min' => $min,
                    'max' => $max
                ];
                if ($dataBetSetting) {
                    $dataBetSetting->update($reqBetSetting);
                } else {
                    BetSetting::create($reqBetSetting);
                }
            }

            return $responseData;
        } else {
            return [
                'error' => [
                    'id' => 1,
                    'message' => 'API request failed'
                ]
            ];
        }
    }
}
