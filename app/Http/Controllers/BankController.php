<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index()
    {
        $data = $this->getAllDataSettings();
        return view('bank.index', [
            'title' => 'Setting',
            'data' => [],
            'totalnote' => 0,
            'data' => $data
        ]);
    }

    public function create()
    {
        $data = $this->getAllDataSettings();
        return view('bank.index', [
            'title' => 'Setting',
            'data' => [],
            'totalnote' => 0,
            'data' => $data
        ]);
    }

    private function getAllDataSettings()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->get(env('BODOMAIN') . '/banks/groupbank1');

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
