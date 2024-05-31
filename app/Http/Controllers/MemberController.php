<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::select('id', 'username', 'balance', 'ip_reg', 'ip_log', 'lastlogin', 'domain', 'lastlogin2', 'domain2', 'lastlogin3', 'domain3', DB::raw("CASE WHEN status = 0 THEN 'New Member' ELSE 'Default' END AS status"))
            ->latest()
            ->get();

        return view('member.index', [
            'title' => 'Member',
            'data' => $members,
            'totalnote' => 0,
        ]);
    }

    public function create()
    {
        return view('member.create', [
            'title' => 'Member Create',
            'totalnote' => 0,
        ]);
    }

    public function edit($id)
    {
        $dataMember = Member::where('id', $id)->first();
        $dataUser = $this->getApiDataUser($dataMember->username);
        if ($dataUser["status"] === 'success') {
            $dataUser = $dataUser["data"]["datauser"];
        }

        return view('member.update', [
            'title' => 'Member Edit',
            'dataMember' => $dataMember,
            'dataUser' => $dataUser,
            'totalnote' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'xyusernamexxy' => 'required',
            'password' => 'required',
            'xybanknamexyy' => 'required',
            'xybankuserxy' => 'required',
            'xxybanknumberxy' => 'required',
            'xyx11xuser_mailxxyy' => 'required',
            'xynumbphonexyyy' => 'required'
        ]);

        $resultReqApi = $this->reqApiRegisterMember($request->all());

        if (!is_array($resultReqApi)) {
            $resultReqApi = str_replace("Error: 400 - ", "", $resultReqApi);
            $resultReqApi = json_decode($resultReqApi, true);
        }

        if ($resultReqApi["status"] === "success") {
            $dataSeamless = [
                'Username' => $resultReqApi["data"]["addedUser"]["username"],
                'UserGroup' => 'c',
                "Agent" => env('AGENTID'),
                'CompanyKey' => env('COMPANY_KEY'),
                'ServerId' => env('SERVERID'),
            ];
            $resultReqApiSeamless = $this->reqApiRegisterMemberSeamless($dataSeamless);

            if ($resultReqApiSeamless["error"]["id"] === 0) {
                $member = new Member();
                $member->username = $request->xyusernamexxy;
                $member->balance = 0;
                $member->status = 0;
                $member->save();

                $dataMember = Member::latest()->get();
                if ($member->save()) {
                    return redirect('/member')->with([
                        'status' => "success",
                        'message' => 'User berhasil dibuat',
                        'data' => $dataMember,
                        'totalnote' => 0,
                    ]);
                } else {
                    return redirect('/member')->with([
                        'status' => "fail",
                        'message' => 'Gagal membuat user',
                        'data' => $dataMember,
                        'totalnote' => 0,
                    ]);
                }
            }

            $dataMember = Member::latest()->get();
            return redirect('/member')->with([
                'status' => "fail",
                'message' => $resultReqApi["message"],
                'data' => $dataMember,
                'totalnote' => 0,
            ]);
        }
    }

    function updateMember(Request $request)
    {
        $request->validate([
            'xybanknamexyy' => 'required',
            'xybankuserxy' => 'required',
            'group' => 'required',
            'groupwd' => 'required',
            'xxybanknumberxy' => 'required',
            'xyusernamexxy' => 'required',
        ]);

        $data = [
            'xybanknamexyy' => $request->xybanknamexyy,
            'xybankuserxy' => $request->xybankuserxy,
            'group' => $request->group,
            'groupwd' => $request->groupwd,
            'xxybanknumberxy' => $request->xxybanknumberxy,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->put('https://back-staging.bosraka.com/users/' . $request->xyusernamexxy, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            if ($responseData["status"] === 'success') {
                return redirect('/member')->with([
                    'status' => "success",
                    'message' => 'User berhasil diupdate',
                ]);
            } else {
                return redirect('/member')->with([
                    'status' => "fail",
                    'message' => 'User gagal diupdate',
                ]);
            }
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            return redirect('/member')->with([
                'status' => "error",
                'message' => "Error: $statusCode - $errorMessage",
            ]);
        }
    }

    function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:4',
            'xyusernamexxy' => 'required',
        ]);

        $data = [
            'password' => $request->password
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->put('https://back-staging.bosraka.com/users/pswdy/' . $request->xyusernamexxy, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            if ($responseData["status"] === 'success') {
                return redirect('/member')->with([
                    'status' => "success",
                    'message' => 'User berhasil diupdate',
                ]);
            } else {
                return redirect('/member')->with([
                    'status' => "fail",
                    'message' => 'User gagal diupdate',
                ]);
            }
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            return redirect('/member')->with([
                'status' => "error",
                'message' => "Error: $statusCode - $errorMessage",
            ]);
        }
    }

    function updatePlayer(Request $request)
    {
        $request->validate([
            'xyusernamexxy' => 'required',
            'min_bet' => 'required|numeric',
            'max_bet' => 'required|numeric',
        ]);

        $results = $this->reqApiUpdateMaxMinBet([
            'Username' => $request->xyusernamexxy,
            'Min' => $request->min_bet,
            'Max' => $request->max_bet,
            "MaxPerMatch" => 2000,
            "CasinoTableLimit" => 4,
            'CompanyKey' => env('COMPANY_KEY'),
            'ServerId' => env('SERVERID')
        ]);

        $members = Member::select('id', 'username', 'balance', 'ip_reg', 'ip_log', 'lastlogin', 'domain', 'lastlogin2', 'domain2', 'lastlogin3', 'domain3', DB::raw("CASE WHEN status = 0 THEN 'New Member' ELSE 'Default' END AS status"))
            ->latest()
            ->get();
        if ($results["error"]["id"] === 0) {
            Member::where('username', $request->xyusernamexxy)->update([
                'keterangan' => $request->keterangan,
                'status' => $request->status,
                'min_bet' => $request->min_bet,
                'max_bet' => $request->max_bet,
            ]);

            return redirect('/member')->with([
                'status' => "success",
                'message' => 'User berhasil diupdate',
            ]);
        } else {
            return redirect('/member')->with([
                'status' => "fail",
                'message' => 'User gagal diupdate',
            ]);
        }
    }


    private function reqApiRegisterMember($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post('https://back-staging.bosraka.com/users', $req);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    private function reqApiRegisterMemberSeamless($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post('https://ex-api-demo-yy.568win.com/web-root/restricted/player/register-player.aspx', $req);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    private function reqApiUpdateMaxMinBet($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post('https://ex-api-demo-yy.568win.com/web-root/restricted/player/update-player-bet-settings.aspx', $req);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    private function getApiDataUser($username)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->get('https://back-staging.bosraka.com/users/' . $username);

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
