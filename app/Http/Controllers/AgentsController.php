<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AgentsController extends Controller
{
    public function index()
    {
        $agents = Agents::latest()->get();
        return view('agents.index', [
            'title' => 'Agents',
            'data' => $agents,
            'totalnote' => 0,
        ]);
    }

    public function create()
    {
        $modelCompany = Companys::get();
        $modelCurrency = Currencys::get();
        return view('agents.create', [
            'title' => 'Agents',
            'modelCompany' => $modelCompany,
            'modelCurrency' => $modelCurrency,
            'totalnote' => 0,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user_agents',
            'password' => 'required',
            'currency' => 'required',
            'min' => 'required|integer',
            'max' => 'required|integer',
            'maxpermatch' => 'required|integer',
            'casinotablelimit' => 'required|integer',
            'companykey' => 'required',
            'serverid' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            try {
                $dataRegisterAgent = [
                    "Username" => env('UNIX_CODE') . $request->username,
                    "Password" => $request->password,
                    "Currency" => $request->currency,
                    "Min" => $request->min,
                    "Max" => $request->max,
                    "MaxPerMatch" => $request->maxpermatch,
                    "CasinoTableLimit" => $request->casinotablelimit,
                    "CompanyKey" => $request->companykey,
                    "ServerId" => $request->serverid
                ];
                $reqRegisterAgent = $this->reqRegisterAgent($dataRegisterAgent);
                if ($reqRegisterAgent["error"]["id"] === 0) {
                    $data = $request->all();
                    $data['id'] = Str::uuid()->toString();
                    $data['password'] = bcrypt($data['password']);

                    Agents::create($data);

                    return response()->json(['message' => 'Agent baru berhasil dibuat.',]);
                }

                return response()->json(['errors' => [$reqRegisterAgent["error"]["msg"]]], 400);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return response()->json(['errors' => ['Terjadi kesalahan saat menyimpan data.']]);
            }
        }
    }

    function reqRegisterAgent($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post(env('BODOMAIN') . '/web-root/restricted/agent/register-agent.aspx', $req);

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
