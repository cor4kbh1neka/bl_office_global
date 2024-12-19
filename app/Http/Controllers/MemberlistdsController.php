<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Member;
use App\Models\DepoWd;
use App\Models\ListError;
use App\Models\Referral1;
use App\Models\Referral2;
use App\Models\Referral3;
use App\Models\Referral4;
use App\Models\Referral5;
use App\Models\winlossDay;
use App\Models\winlossMonth;
use App\Models\winlossYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MemberListExport;
use Illuminate\Support\Facades\DB;

class MemberlistdsController extends Controller
{
    public function index(Request $request)
    {
        $totalMember = Member::query()->join('balance', 'balance.username', '=', 'member.username')
        ->where('amount', '>', '0')->count('member.username');
        $totalBalance = Member::join('balance', 'balance.username', '=', 'member.username')
            ->sum('balance.amount');
        $data = $this->filterAndPaginate(20);

        $gabungdari = isset($request->gabungdari) ? $request->gabungdari : date('Y-m-d', strtotime(date('Y-m-d') . ' -30 days'));
        $gabunghingga = isset($request->gabunghingga) ? $request->gabunghingga : date('Y-m-d');

        return view('memberlistds.index', [
            'title' => 'Member List',
            'data' => $data,
            'totalMember' => $totalMember,
            'totalBalance' => $totalBalance,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga
        ]);
    }

    public function update($id)
    {
        $data = Member::where('id', $id)->first();
        if (!$data) {
            $data = Member::where('username', $id)->first();
        }

        $username = $data->username;

        $dataUser = $this->getApiUser($username);
        if ($dataUser["status"] === 'success') {
            $dataUser = $dataUser["data"]["datauser"];
        } else {
            $dataUser = [];
        }

        $dataGroupDp = $this->getApiDataGroupBank()["groupdp"];
        $dataGroupWd = $this->getApiDataGroupBank()["groupwd"];

        return view('memberlistds.update', [
            'title' => 'Edit Member',
            'data' => $data,
            'id' => $id,
            'datauser' => $dataUser,
            'dataGroupDp' => $dataGroupDp,
            'dataGroupWd' => $dataGroupWd,
            'totalnote' => 0,
        ]);
    }

    private function getApiDataGroupBank()
    {

        $url = env('DOMAIN') . '/banks/group';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS'),
        ])->get($url);
        $response = $response->json();
        $groupdp = [];
        $groupwd = [];
        if ($response['status'] == 'success') {
            foreach ($response['data'] as $i => $d) {
                if ($i != 'nongroup' && $i != 'nongroupwd') {
                    if ($d['grouptype'] == 1) {
                        $groupdp[] = $i;
                    } else {
                        $groupwd[] = $i;
                    };
                }
            }
        }

        $data = [
            'groupdp' => $groupdp,
            'groupwd' => $groupwd
        ];

        return $data;
    }

    private function getApiUser($username)
    {
        $url = env('DOMAIN') . '/users/' . $username;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->get($url);

        $responseData = $response->json();
        return $responseData;
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'xybanknamexyy' => 'required',
            'xybankuserxy' => 'required',
            'group' => 'required',
            'groupwd' => 'required',
            'xxybanknumberxy' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $data = [
                    "xybanknamexyy" => $request->xybanknamexyy,
                    "xybankuserxy" => $request->xybankuserxy,
                    "group" => $request->group,
                    "groupwd" => $request->groupwd,
                    "xxybanknumberxy" => $request->xxybanknumberxy,
                ];
                $updateUser = $this->reqApiUpdateUser($data, $request->xyusernamexxy);

                if ($updateUser["status"] === 'success') {

                    $this->updateIsVerif($request->xyusernamexxy, $request->isverified);
                    Member::where('username', $request->xyusernamexxy)->update([
                        'bank' => $request->xybanknamexyy,
                        'namarek' => $request->xybankuserxy,
                        'norek' => $request->xxybanknumberxy
                    ]);

                    return redirect('/memberlistds/edit/' . $id)->with('success', 'Update data member berhasil.');
                }

                return redirect()->back()->with('error', $updateUser["status"]);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    private function updateIsVerif($username, $isverified)
    {

        $url = env('DOMAIN') . '/users/vip/' . $username;
        $data = [
            "is_verified" => $isverified == 1 ? true : false
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->put($url, $data);

        $responseData = $response->json();
        return $responseData;
    }

    public function updatePassowrd(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'xyusernamexxy' => 'required',
                'changepassword' => 'required',
                'repassword' => 'required|same:changepassword',
            ],
            [
                'repassword.same' => 'Konfirmasi password harus sama dengan password.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $data = [
                    "password" => $request->changepassword,
                ];

                $updateUser = $this->reqApiUpdatePassword($data, $request->xyusernamexxy);

                if ($updateUser["status"] === 'success') {
                    return redirect('/memberlistds/edit/' . $id)->with('success', 'Update password berhasil.');
                }

                return redirect()->back()->with('error', $updateUser["status"]);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    public function updateMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $dataMember = Member::where('id', $id)->first();
                if (!$dataMember) {
                    $dataMember = Member::where('username', $id)->first();
                }

                $dataMember->update([
                    'keterangan' => $request->informasiplayer,
                    'status' => $request->status,
                    'max_bet' => 0,
                    'min_bet' => 0
                ]);

                return redirect('/memberlistds/edit/' . $id)->with('success', 'Update informasi member berhasil.');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    private function reqApiUpdateUser($data, $username)
    {
        $url = env('DOMAIN') . '/users/' . $username;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->put($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            // $responseData = "Error: $statusCode - $errorMessage";
            $responseData = $response->json();
        }

        return $responseData;
    }

    private function reqApiUpdatePassword($data, $username)
    {
        $url = env('DOMAIN') . '/users/pswdy/' . $username;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->put($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            // $responseData = "Error: $statusCode - $errorMessage";
            $responseData = $response->json();
        }

        return $responseData;
    }

    public function winloseyear($username)
    {
        $data = winlossYear::where('username', $username)->get();
        return view('memberlistds.winlose_year', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username
        ]);
    }

    public function winlosemonth($username, $year)
    {
        $data = winlossMonth::where('username', $username)->where('year', $year)->get();
        return view('memberlistds.winlose_month', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username,
            'year' => $year
        ]);
    }

    public function winloseday($username, $year, $month)
    {
        $data = winlossDay::where('username', $username)->where('year', $year)->where('month', $month)->get();
        return view('memberlistds.winlose_day', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
            'username' => $username,
            'data' => $data,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function historybank($username)
    {
        $raw = DepoWd::where('username', $username)->where('status', '>', 0)->orderByDesc('created_at');
        $data = $this->filterAndPaginate(20, $raw);
        return view('memberlistds.history_bank', [
            'title' => 'History Bank',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username
        ]);
    }
    
    public function filterAndPaginate($page, $query="", $jenis="")
    {
        if($query == "") {
            $query = Member::query()->join('balance', 'balance.username', '=', 'member.username');

            if($jenis !== "export") {
                $query->select('member.*', 'balance.amount');
            } else {
                $query->select(
                    'member.username', 
                    'member.referral',
                    DB::raw("CONCAT(member.bank, ', ', member.namarek, ', ', member.norek) as bank"),
                    'balance.amount as balance',
                    DB::raw("
                        CASE 
                            WHEN member.status = 9 THEN 'NEW MEMBER'
                            WHEN member.status = 1 THEN 'DEFAULT'
                            WHEN member.status = 2 THEN 'VVIP'
                            WHEN member.status = 3 THEN 'BANDAR'
                            WHEN member.status = 4 THEN 'WARNING'
                            WHEN member.status = 5 THEN 'SUSPEND'
                            ELSE 'UNKNOWN'
                        END as status_label
                    "),
                    'member.keterangan as informasi',
                    'member.created_at as tglgabung',
                    'member.lastlogin'
                );
            }
            
            $query->orderByDesc('member.created_at');

            $parameter = [
                'username',
                'norek',
                'namarek',
                'bank',
                'nohp',
                'referral',
                'status',
            ];

            foreach ($parameter as $isiSearch) {
                if (request($isiSearch)) {
                    $query = $query->where(function ($subQuery) use ($isiSearch) {
                        $subQuery->where($isiSearch, 'LIKE', '%' . request($isiSearch) . '%');
                    });
                }
            }

            if (request('gabungdari') && request('gabunghingga')) {
                $gabungdari = request('gabungdari') . " 00:00:00";
                $gabunghingga = request('gabunghingga') . " 23:59:59";

                $query = $query->whereBetween('member.created_at', [$gabungdari, $gabunghingga]);
            }

            if (request('checkusername')) {
                $inputUsername = request('username');
                $query = $query->where('username', '=', $inputUsername);
            }
        }

        if ($page > 0) {
            $currentPage = Paginator::resolveCurrentPage();
            $perPage = $page;

            $paginatedItems = $query->paginate($perPage);

            if($query == "")
            foreach ($parameter as $isiSearch) {
                if (request($isiSearch)) {
                    $paginatedItems->appends($isiSearch, request($isiSearch));
                }
            }

            return $paginatedItems;
        } else {
            return $query->get();
        }
    }


    public function addmember()
    {
        return view('memberlistds.create', [
            'title' => 'Add Member',
            'totalnote' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $username = $request->username;
        $cekDataCoreUser = $this->getApiUser($username);
        if ($cekDataCoreUser["status"] === 'success') {
            $bank = $cekDataCoreUser["data"]["datauser"]["xybanknamexyy"];
            $namarek = $cekDataCoreUser["data"]["datauser"]["xybankuserxy"];
            $rek = $cekDataCoreUser["data"]["datauser"]["xxybanknumberxy"];

            $dataapi = [
                "Username" => env('UNIX_CODE') . $username,
                "CompanyKey" => env('COMPANY_KEY'),
                "ServerId" => env('SERVERID')
            ];
            $urlapi = env('BODOMAIN') . '/web-root/restricted/player/get-player-balance.aspx';
            $responseapi = Http::withHeaders([
                'Content-Type' => 'application/json; charset=UTF-8'
            ])->post($urlapi, $dataapi);
            $responseapi = $responseapi->json();
            if ($responseapi["error"]["id"] !== 0) {
                $createUserSeamless = $this->createUser($username, $bank, $namarek, $rek);
                if ($createUserSeamless["status"] == 'success') {
                    return redirect('seamless/addmember')->with('success', 'Data seamless berhasil ditambahkan.');
                } else {
                    return redirect()->back()->with('error', $createUserSeamless["message"]);
                }
            } else {
                return redirect()->back()->with('error', 'Member seamless sudah terdaftar');
            }
        } else {
            return redirect()->back()->with('error', 'Member tidak terdaftar');
        }
    }

    private function createUser($username, $bank, $namarek, $rek)
    {
        $data = [
            "Username" => env('UNIX_CODE') . $username,
            "UserGroup" => "c",
            "Agent" => env('AGENTID'),
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => "YY-TEST"
        ];

        $url = env('BODOMAIN') . '/web-root/restricted/player/register-player.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->post($url, $data);

        $responseData = $response->json();
        if ($responseData["error"]["id"] === 0) {
            try {
                Member::create([
                    'username' => $username,
                    'referral' => '',
                    'bank' => $bank,
                    'namarek' => $namarek,
                    'norek' => $rek,
                    'nohp' => 0,
                    'balance' => 0,
                    'ip_reg' => null,
                    'ip_log' => null,
                    'lastlogin' => null,
                    'domain' => null,
                    'lastlogin2' => null,
                    'domain2' => null,
                    'lastlogin3' => null,
                    'domain3' => null,
                    'status' => 0
                ]);

                Balance::create([
                    'username' => $username,
                    'balance' => 0
                ]);
            } catch (\Exception $e) {
                ListError::create([
                    'fungsi' => 'register',
                    'pesan_error' => $e->getMessage(),
                    'keterangan' => '-'
                ]);
            }

            return [
                'status' => 'success',
                'message' => 'Data member berhasil ditambahkan',
            ];
        } else {
            ListError::create([
                'fungsi' => 'register',
                'pesan_error' => $responseData["error"]["msg"],
                'keterangan' => '-'
            ]);
            return [
                'status' => 'fail',
                'message' => 'Data member gagal ditambahkan',
            ];
        }
    }
    public function export(Request $request)
    {
        // $query = Member::query()->join('balance', 'balance.username', '=', 'member.username')
        //     ->select('member.*', 'balance.amount')->orderByDesc('created_at')->get();

        // $query = Member::query()->join('balance', 'balance.username', '=', 'member.username')
        //     ->select(
        //         'member.username',
        //         'member.referral',
        //         DB::raw("CONCAT(member.bank, ', ', member.namarek, ', ', member.norek) as bank"),
        //         'balance.amount as balance',
        //         DB::raw("
        //         CASE 
        //             WHEN member.status = 9 THEN 'NEW MEMBER'
        //             WHEN member.status = 1 THEN 'DEFAULT'
        //             WHEN member.status = 2 THEN 'VVIP'
        //             WHEN member.status = 3 THEN 'BANDAR'
        //             WHEN member.status = 4 THEN 'WARNING'
        //             WHEN member.status = 5 THEN 'SUSPEND'
        //             ELSE 'UNKNOWN'
        //         END as status_label
        //         "),
        //         'member.keterangan as informasi',
        //         'member.created_at as tglgabung',
        //         'member.lastlogin'
        //     )->when(request('gabungdari') && request('gabunghingga'), function ($query) {
        //         $query->whereBetween('member.created_at', [request('gabungdari'), request('gabunghingga')]);
        //     })->orderByDesc('member.created_at')->get();
        $proses = $this->filterAndPaginate(999999999999999, '', 'export' );
        $data = $proses->getCollection();
        return Excel::download(new MemberListExport($data), 'Memberlist.xlsx');
    }

    public function updateStatus(Request $request)
    {
        $username = $request->input('username');
        $status = $request->input('status');

        $member = Member::where('username', $username)->first();
        if ($member) {
            $data = [
                "Username" => env('UNIX_CODE') . $username,
                "Status" => "Active",
                "CompanyKey" => env('COMPANY_KEY'),
                "ServerId" => env('SERVERID')
            ];

            $url = env('BODOMAIN') . '/web-root/restricted/player/update-player-status.aspx';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json; charset=UTF-8'
            ])->post($url, $data);

            $responseData = $response->json();
            if ($responseData["error"]["id"] === 0) {
                $member->update([
                    'status' => $status
                ]);

                return response()->json(['success' => true, 'message' => 'Pemain telah dinonaktifkan.']);
            } else {
                return response()->json(['success' => false, 'message' => $responseData["error"]["msg"]], 400);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Pemain tidak ditemukan.'], 404);
        }
    }

    public function historylog($username)
    {
        $data = [
            'username' => $username,
        ];

        $apiUrl = env('GETDOMAIN') . '/api/getdatalogmember';
        try {
            $response = Http::withHeaders([
                'utilitiesgenerate' => env('UTILITIES_GENERATE2')
            ])->post($apiUrl, $data);

            if ($response->successful()) {
                $results = $response->json();
            } else {
                $results = null;
            }
        } catch (\Exception $e) {

            $results = null;
        }

        // $results = [
        //     [
        //         "username" => "jakartacity",
        //         "jenis" => "login",
        //         "ipaddress" => "10.01.01.01",
        //         "updated_at" => "2021-01-20 17:50:33"
        //     ],
        //     [
        //         "username" => "jakartacity",
        //         "jenis" => "ubah password",
        //         "ipaddress" => "10.01.01.01",
        //         "updated_at" => "2021-01-20 17:50:33"
        //     ],
        // ];

        return view('memberlistds.historylog', [
            'title' => 'Aktifitas Akun',
            'totalnote' => 0,
            'data' => $results,
            'username' => $username
        ]);
    }
}
