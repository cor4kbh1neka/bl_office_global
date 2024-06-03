<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function indexsetting()
    {
        $responseData = $this->getAllDataSettings()["data"]["masterdata"];
        return view('settings.indexsetting', [
            'title' => 'Setting',
            'data' => $responseData,
            'totalnote' => 0
        ]);
    }

    public function indexevent()
    {
        $responseData = $this->getAllDataSettings()["data"]["events"];
        return view('settings.indexevent', [
            'title' => 'Events',
            'data' => $responseData,
            'totalnote' => 0
        ]);
    }

    public function indexnotice()
    {
        $responseData = $this->getAllDataSettings()["data"]["notice"];;
        return view('settings.indexnotice', [
            'title' => 'Notices',
            'data' => $responseData,
            'totalnote' => 0
        ]);
    }

    private function getAllDataSettings()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->get(env('DOMAIN') . '/apks/settings/apkCrQQbIU5RGc9GSy9C4bn2');

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    public function create()
    {
        $modelCompany = Companys::get();
        $modelCurrency = Currencys::get();
        return view('settings.create', [
            'title' => 'Settings',
            'modelCompany' => $modelCompany,
            'modelCurrency' => $modelCurrency
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'version' => 'required',
            'home' => 'required',
            'deposit' => 'required',
            'server1' => 'required',
            'server2' => 'required',
            'server3' => 'required',
            'update' => 'required',
            'peraturan' => 'required',
            'klasemen' => 'required',
            'promosi' => 'required',
            'livescore' => 'required',
            'livechat' => 'required',
            'whatsapp1' => 'required',
            'whatsapp2' => 'required',
            'facebook' => 'required',
            'telegram' => 'required',
            'instagram' => 'required',
            'prediksi' => 'required',
            'icongif' => 'required',
            'posisi' => 'required|integer',
            'switchs' => 'required|boolean',
            'bannerurl' => 'required',
            'linkevent' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            try {

                $url = env('DOMAIN') . '/apks/settings';
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'x-customblhdrs' => env('XCUSTOMBLHDRS')
                ])->post($url, $request->all());

                if ($response->successful()) {
                    $responseData = $response->json();
                } else {
                    $statusCode = $response->status();
                    $errorMessage = $response->body();
                    $responseData = "Error: $statusCode - $errorMessage";
                }

                return $responseData;
            } catch (\Exception $e) {
                // dd($e->getMessage());
                return response()->json(['errors' => ['Terjadi kesalahan saat menyimpan data.']]);
            }
        }
    }

    function reqRegisterSetting($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post(env('BODOMAIN') . '/web-root/restricted/setting/register-setting.aspx', $req);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }
}
