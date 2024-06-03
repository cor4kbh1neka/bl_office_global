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

class MemberlistdsController extends Controller
{
    public function index()
    {
        $query = Member::query()->join('balance', 'balance.username', '=', 'member.username')
            ->select('member.*', 'balance.amount')->orderByDesc('created_at')->get();
        $data = $this->filterAndPaginate($query, 20);
        return view('memberlistds.index', [
            'title' => 'Member List',
            'data' => $data,
        ]);
    }

    public function update($id)
    {
        $data = Member::where('id', $id)->first();
        dd($data);
        if ($data) {
            $username = $data->username;
        } else {
            $username = $id;
        }

        $dataUser = $this->getApiUser($username);
        dd($dataUser);
        if (is_array($dataUser)) {
            $dataUser = $dataUser["data"]["datauser"];
        } else {
            $dataUser = [];
        }

        return view('memberlistds.update', [
            'title' => 'Edit Member',
            'data' => $data,
            'id' => $id,
            'datauser' => $dataUser,
            'totalnote' => 0,
        ]);
    }

    private function getApiUser($username)
    {
        $url = env('DOMAIN') . '/users/' . $username;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->get($url);
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

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
            'minbet' => 'required|numeric|min:0',
            'maxbet' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                Member::where('id', $id)->update([
                    'keterangan' => $request->informasiplayer,
                    'status' => $request->status,
                    'max_bet' => $request->minbet,
                    'min_bet' => $request->maxbet
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
        $raw = DepoWd::where('username', $username)->where('status', '>', 0)->orderByDesc('created_at')->get();
        $data = $this->filterAndPaginate($raw, 20);
        return view('memberlistds.history_bank', [
            'title' => 'History Bank',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username
        ]);
    }
    public function filterAndPaginate($data, $page)
    {
        $query = collect($data);
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
                $query = $query->filter(function ($item) use ($isiSearch) {
                    return stripos($item[$isiSearch], request($isiSearch)) !== false;
                });
            }
        }

        // Tambahan Filter Tanggal, comment aja klau tidak terpakai :D
        if (request('gabungdari') && request('gabunghingga')) {
            $gabungdari = request('gabungdari') . " 00:00:00";
            $gabunghingga = request('gabunghingga') . " 23:59:59";
            $query = $query->filter(function ($item) use ($gabungdari, $gabunghingga) {
                return $item['created_at'] >= $gabungdari && $item['created_at'] <= $gabunghingga;
            });
        }

        // Filter untuk strict username
        if (request('checkusername')) {
            $inputUsername = request('username');
            $query = $query->filter(function ($item) use ($inputUsername) {
                return $item['username'] === $inputUsername;
            });
        }

        $parameter = array_merge($parameter, [
            'gabungdari',
            'gabunghingga',
            'checkusername'
        ]);

        if ($page > 0) {
            $currentPage = Paginator::resolveCurrentPage();
            $perPage = $page;
            $currentPageItems = $query->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedItems = new LengthAwarePaginator(
                $currentPageItems,
                $query->count(),
                $perPage,
                $currentPage,
                ['path' => Paginator::resolveCurrentPath()]
            );
            foreach ($parameter as $isiSearch) {
                if (request($isiSearch)) {
                    $paginatedItems->appends($isiSearch, request($isiSearch));
                }
            }
            return $paginatedItems;
        } else {
            return $query->values();
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

        $data = [
            "Username" => $request->username,
            "UserGroup" => "c",
            "Agent" => env('AGENTID'),
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => "YY-TEST"
        ];

        $url = env('BODOMAIN') . '/web-root/restricted/player/register-player.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post($url, $data);

        $responseData = $response->json();
        if ($responseData["error"]["id"] === 0) {

            try {
                Member::create([
                    'username' => $request->username,
                    'referral' => $request->referral,
                    'bank' => $request->bank,
                    'namarek' => $request->namarek,
                    'norek' => $request->norek,
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
                    'username' => $request->username,
                    'balance' => 0
                ]);

                if ($request->Referral !== null && $request->Referral !== '') {
                    $dataReferral = [
                        'upline' => $request->Referral,
                        'downline' => $request->Username,
                    ];

                    if (preg_match('/^[a-e]/i', $request->Referral)) {
                        Referral1::create($dataReferral);
                    } elseif (preg_match('/^[f-j]/i', $request->Referral)) {
                        Referral2::create($dataReferral);
                    } elseif (preg_match('/^[k-o]/i', $request->Referral)) {
                        Referral3::create($dataReferral);
                    } elseif (preg_match('/^[p-t]/i', $request->Referral)) {
                        Referral4::create($dataReferral);
                    } elseif (preg_match('/^[u-z]/i', $request->Referral)) {
                        Referral5::create($dataReferral);
                    }
                }
            } catch (\Exception $e) {
                ListError::create([
                    'fungsi' => 'register',
                    'pesan_error' => $e->getMessage(),
                    'keterangan' => '-'
                ]);
            }

            return redirect('/memberlistds')->with('success', 'Tambah data member berhasil.');
        } else {
            ListError::create([
                'fungsi' => 'register',
                'pesan_error' => $responseData["error"]["msg"],
                'keterangan' => '-'
            ]);
            return redirect()->back()->with('error', 'Gagal menambahkan data member');
        }
    }

    public function export(Request $request)
    {
        $query = Member::query()->join('balance', 'balance.username', '=', 'member.username')
            ->select('member.*', 'balance.amount')->orderByDesc('created_at')->get();
        $proses = $this->filterAndPaginate($query, 20000);
        $data = $proses->getCollection();
        return Excel::download(new MemberListExport($data), 'Memberlist.xlsx');
    }
}
