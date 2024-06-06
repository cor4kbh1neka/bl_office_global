<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Agents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class PlayersController extends Controller
{
    public function index()
    {
        $query = "SELECT A.id, A.username, A.usergroup, B.username as useragent, B.companykey, B.serverid 
        FROM user_players A
        INNER JOIN user_agents B ON A.agentid = B.id";

        $results = DB::select($query);

        return view('players.index', [
            'title' => 'Players',
            'data' => $results,
            'totalnote' => 0
        ]);
    }

    public function create()
    {
        $modelAgent = Agents::get();
        return view('players.create', [
            'title' => 'Players',
            'modelAgent' => $modelAgent,
            'totalnote' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user_players',
            'password' => 'required',
            'usergroup' => 'required',
            'agentid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            try {
                $dataAgent = Agents::where('id', $request->agentid)->first();
                $dataRegisterPlayer = [
                    "Username" => env('UNIX_CODE') . $request->username,
                    "UserGroup" => $request->usergroup,
                    "Agent" => $dataAgent->username,
                    "CompanyKey" => $dataAgent->companykey,
                    "ServerId" => $dataAgent->serverid
                ];
                $reqRegisterPlayer = $this->reqRegisterPlayer($dataRegisterPlayer);

                if ($reqRegisterPlayer["error"]["id"] === 0) {
                    $data = $request->all();
                    $data['id'] = Str::uuid()->toString();
                    $data['password'] = bcrypt($data['password']);

                    Players::create($data);

                    return response()->json(['message' => 'Player baru berhasil dibuat.',]);
                }

                return response()->json(['errors' => [$reqRegisterPlayer["error"]["msg"]]], 400);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return response()->json(['errors' => ['Terjadi kesalahan saat menyimpan data.']]);
            }
        }

        return response()->json([
            'message' => 'Data berhasil disimpan.',
        ]);
    }

    function reqRegisterPlayer($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post(env('BODOMAIN') . '/web-root/restricted/player/register-player.aspx', $req);

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
