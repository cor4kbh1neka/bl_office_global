<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\Xdpwd;
use App\Models\DepoWd;
use App\Models\HistoryTransaksi;
use App\Models\Outstanding;
use App\Models\Balance;
use App\Models\ListError;
use App\Models\Referral1;
use App\Models\Referral2;
use App\Models\Referral3;
use App\Models\Referral4;
use App\Models\Referral5;
use App\Models\ReferralAktif1;
use App\Models\ReferralAktif2;
use App\Models\ReferralAktif3;
use App\Models\ReferralAktif4;
use App\Models\ReferralAktif5;
use App\Models\WinlossbetDay;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use Illuminate\Support\Facades\Http;

class ApiController extends Controller

{
    public function login(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $iswap = $request->iswap;
        $device = $request->device;


        if ($device != 'd') {
            $device = 'm';
        }

        try {
            $dataLogin['Username'] = $username;
            $dataLogin['CompanyKey'] = env('COMPANY_KEY');
            $dataLogin['Portfolio'] = env('PORTFOLIO');
            $dataLogin['IsWapSports'] = $iswap;
            $dataLogin['ServerId'] = "YY-TEST";
            $getLogin = $this->requestApiLogin($dataLogin);
            if ($getLogin["url"] !== "") {
                if ($device == 'd') {
                    $getLogin["url"] = 'https://' . $getLogin["url"] .  '/welcome2.aspx?token=token&lang=en&oddstyle=ID&theme=black&oddsmode=double&device=' . $device;
                } else {
                    $getLogin["url"] = 'https://' . $getLogin["url"] .  '/welcome2.aspx?token=token&lang=en&oddstyle=ID&oddsmode=double&device=' . $device;
                }
            }

            return $getLogin;
        } catch (\Exception $e) {
            return [
                'AccountName' => $username,
                'Balance' => 0,
                'ErrorCode' => 99,
                'ErrorMessage' => 'Internal Error'
            ];;
        }
    }


    function requestApiLogin($data)
    {
        $url = env('BODOMAIN') . '/web-root/restricted/player/login.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }
        return ['url' => $responseData["url"]];
    }

    public function historyLog(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $ipaddress = $request->ipaddress;

        try {
            $member = Member::where('username', $username)->firstOrFail();
            $member->update([
                'ip_log' => $ipaddress,
                'lastlogin' => now(),
                'domain' => $request->getHost()
            ]);

            return response()->json(['message' => 'Log berhasil tersimpan!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan log.'], 500);
        }
    }

    public function register(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $ipaddress = $request->ipadress;

        $dataCore = [
            "xyusernamexxy" => $request->Username,
            "password" => $request->Password,
            "xybanknamexyy" => $request->ddBankmm,
            "xybankuserxy" => $request->ddNamarekmm,
            "xxybanknumberxy" => $request->ddNorekmm,
            "xyx11xuser_mailxxyy" => $request->ddEmailmm,
            "xynumbphonexyyy" => $request->ddPhonemm
        ];
        // dd(env('XCUSTOMBLHDRS'));
        $responseCore = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->post(env('DOMAIN') . '/users', $dataCore);

        $responseCore = $responseCore->json();

        if ($responseCore["status"] === "success") {
            $data = [
                "Username" => $request->Username,
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
                    $createMember = Member::create([
                        'username' => $request->Username,
                        'referral' => $request->Referral,
                        'bank' => $dataCore['xybanknamexyy'],
                        'namarek' => $dataCore['xybankuserxy'],
                        'norek' => $dataCore['xxybanknumberxy'],
                        'nohp' => 0,
                        'balance' => 0,
                        'ip_reg' => $ipaddress,
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
                        'username' => $request->Username,
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

                return $responseCore;
            } else {
                ListError::create([
                    'fungsi' => 'register',
                    'pesan_error' => $responseData["error"]["msg"],
                    'keterangan' => '-'
                ]);
                return response()->json([
                    'message' => $responseData["error"]["msg"] ?? 'Error tidak teridentifikasi.'
                ], 400);
            }
        } else {
            ListError::create([
                'fungsi' => 'register',
                'pesan_error' => $responseCore["message"],
                'keterangan' => '-'
            ]);
            return $responseCore;
        }
    }

    public function getRecomMatch(Request $request)
    {
        // $token = $request->bearerToken();
        // $expectedToken = env('BEARER_TOKEN');
        // if ($token !== $expectedToken) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }

        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $data = [
            "language" => 'en',
            "companyKey" => env('COMPANY_KEY'),
            "serverId" =>  env('SERVERID')
        ];

        $url = env('BODOMAIN') . '/web-root/restricted/information/get-recommend-matches.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post($url, $data);
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    public function cekuserreferral(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;

        $dataMemberAktif = MemberAktif::where('referral', $username)->first();
        if ($dataMemberAktif) {
            return response()->json(['message' => 'Referral tersedia'], 200);
        } else {
            $dataMember = Member::where('username', $username)->first();
            if ($dataMember) {
                return response()->json(['message' => 'Referral tersedia'], 200);
            } else {
                return response()->json(['message' => 'Referral tidak ditemukan'], 404);
            }
        }
    }

    public function deposit(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        try {
            // $validator = Validator::make($request->all(), [
            //     'username' => 'required|max:50',
            //     'amount' => 'required|numeric',
            //     'keterangan' => 'nullable|max:20',
            //     'bank' => 'required|max:100',
            //     'mbank' => 'required|max:100',
            //     'mnamarek' => 'required|max:150',
            //     'mnorek' => 'required|max:30',
            //     'balance' => 'required|numeric',
            //     'referral' => 'nullable',
            // ]);
            // if ($validator->fails()) {
            //     return response()->json(['errors' => $validator->errors()->all()], 400);
            // }

            // $dataMember = Member::where('username', strtolower($request->username))->first();
            // if (!$dataMember) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => 'Username tidak terdaftar'
            //     ], 400);
            // }

            $dataDepoWd = DepoWd::where('username', strtolower($request->username))->where('jenis', 'DP')->where('status', '0')->first();
            if ($dataDepoWd) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => 'Deposit anda sedang dalam proses'
                ], 400);
            }

            // $dataDepoWd = DepoWd::where('username', strtolower($request->username))->where('jenis', 'DP')->where('status', '1')->first();
            // if (!$dataDepoWd) {
            //     Member::where('username', strtolower($request->username))
            //         ->update([
            //             'status' => '9',
            //             'is_notnew' => true,
            //         ]);
            // }

            /* Request Ke Database Internal */
            $data = $request->all();
            $data["username"] = strtolower($data["username"]);
            $data["jenis"] = "DP";
            $data["txnid"] = null;
            $data["status"] = 0;
            $data["approved_by"] = null;

            DepoWd::create($data);
            Xdpwd::create($data);

            return response()->json([
                'status' => 'Success',
                'message' => 'Deposit sedang diproses'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function withdrawal(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        try {
            /* Validasi WD */
            $dataBalance = Balance::where('username', $request->username)->first();
            if ($dataBalance) {
                if ($request->amount > $dataBalance->amount) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Saldo tidak cukup'
                    ], 500);
                }
            }

            /* Request API check transaction */
            $txnid = $this->generateTxnid('W');

            /* Request Ke Database Internal */
            $data = $request->all();
            $data["username"] = strtolower($data["username"]);
            $data["keterangan"] = null;
            $data["jenis"] = "WD";
            $data["txnid"] = $txnid;
            $data["status"] = 0;
            $data["approved_by"] = null;
            $dataWD = DepoWd::create($data);

            if ($dataWD) {
                Xdpwd::create($data);
                $dataAPI = [
                    "Username" => $dataWD->username,
                    "TxnId" => $txnid,
                    "Amount" => $dataWD->amount,
                    "CompanyKey" => env('COMPANY_KEY'),
                    "ServerId" => env('SERVERID'),
                    "IsFullAmount" => false
                ];
                $resultsApi = $this->requestApi('withdraw', $dataAPI);

                $maxAttempts9720 = 10;
                $attempt9720 = 0;
                while ($resultsApi["error"]["id"] === 9720 && $attempt9720 < $maxAttempts9720) {
                    sleep(6);
                    $resultsApi = $this->requestApi('withdraw', $dataAPI);
                    $attempt9720++;
                }

                $maxAttempts4404 = 10;
                $attempt4404 = 0;
                while ($resultsApi["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
                    $txnid = $this->generateTxnid('W');
                    $data["txnId"] = $txnid;
                    $resultsApi = $this->requestApi('withdraw', $dataAPI);
                    if ($resultsApi["error"]["id"] === 0) {
                        DepoWd::where('id', $dataWD->id)->update([
                            "txnid" => $txnid
                        ]);
                    }
                    $attempt4404++;
                }

                if ($resultsApi["error"]["id"] !== 0) {
                    DepoWd::destroy($dataWD->id);

                    return response()->json([
                        'status' => 'Error',
                        'message' => $resultsApi["error"]["msg"]
                    ], 500);
                }

                if ($resultsApi["error"]["id"] === 0) {
                    $this->processBalance($dataWD->username, 'WD', $dataWD->amount);

                    return response()->json([
                        'status' => 'Success',
                        'message' => 'Withdrawal sedang diproses'
                    ]);
                }
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Withdrawal sedang diproses'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function processBalance($username, $jenis, $amount)
    {
        try {
            DB::beginTransaction();

            $balance = Balance::where('username', $username)->lockForUpdate()->first();

            if (!$balance) {
                throw new \Exception('Saldo pengguna tidak ditemukan.');
            }

            if ($jenis == 'DP') {
                $balance->amount += $amount;
            } else {
                $balance->amount -= $amount;
            }

            $balance->save();

            DB::commit();
            return [
                "status" => 'success',
                "balance" => $balance->amount
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                "status" => 'fail',
                "balance" => 0
            ];
        }
    }

    function generateTxnid($jenis)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        if ($jenis == 'D') {
            $length = 17;
        } else {
            $length = 10;
        }

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = $jenis . $randomString;
        return $randomString;
    }

    public function getHistoryDepoWd(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $data = DepoWd::where('username', $username)
            ->select('id', 'username', 'balance', 'amount', 'jenis', 'status', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();


        foreach ($data as $item) {
            if ($item['status'] == 1) {
                $item['status'] = 'accept';
            } elseif ($item['status'] == 2) {
                $item['status'] = 'cancel';
            } elseif ($item['status'] == 0) {
                $item['status'] = 'pending';
            }

            if ($item['jenis'] === 'DPM' || $item['jenis'] === 'DP') {
                $item['balance'] = $item['status'] == 'accept' ?  $item['balance'] + $item['amount'] : $item['balance'];
            } else {
                $item['balance'] = $item['status'] == 'cancel' ?  $item['balance'] : $item['balance'] - $item['amount'];
            }
        }
        return $data;
    }

    public function getLastStatusTransaction(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $jenis = $request->jenis;
        $username = $request->username;

        if ($jenis == 'DP') {
            $tipe = "Deposit";
        } else if ($jenis == 'WD') {
            $tipe = "Withdrawal";
        } else {
            return response()->json([
                'status' => 'Fail',
                'message' => 'Status transaksi tidak falid!'
            ]);
        }

        $dataLastDepo = DepoWd::where('username', $username)->where('jenis', $jenis)->orderBy('created_at', 'desc')->first();

        if ($dataLastDepo) {
            if ($dataLastDepo->status == 1) {
                return response()->json([
                    'status' => 'Success',
                    'message' => $tipe . ' berhasil diporses!'
                ]);
            } else if ($dataLastDepo->status == 2) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => $tipe . ' gagal diproses!'
                ]);
            } else if ($dataLastDepo->status == 0) {
                return response()->json([
                    'status' => 'Waitting',
                    'message' => $tipe . ' sedang diproses!'
                ]);
            }
        }

        return response()->json([
            'status' => 'None',
            'message' => 'Tidak ada status ' . $tipe . '!'
        ]);
    }

    public function getBalance(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->input('username');
        $data = $this->reqApiBalance($username);

        $results = [
            "username" => $username,
            "balance" => $data,
        ];
        return $results;
    }

    public function getTransactions()
    {
        $transactions = Transactions::select('transactions.id', 'transactions.transactionid', 'transactions.username', 'transaction_status.status', 'transaction_status.id as statusid')
            ->join('transaction_status', function ($join) {
                $join->on('transaction_status.trans_id', '=', 'transactions.id')
                    ->whereRaw('transaction_status.created_at = (SELECT MAX(created_at) FROM transaction_status WHERE trans_id = transactions.id)');
            })
            ->where('transaction_status.status', 'Running')
            ->orWhere('transaction_status.status', 'Rollback')
            ->orderByDesc('transaction_status.created_at')
            ->orderBy('transaction_status.urutan')
            ->orderByDesc('transactions.created_at')
            ->get();

        // Mengubah status jika status adalah 'Rollback'
        $transactions->map(function ($transaction) {
            if ($transaction->status === 'Rollback') {
                $transaction->status = 'Running';
            }
            return $transaction;
        });

        return $transactions;
    }

    public function getTransactionAll()
    {
        $data = Transactions::orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function getTransactionStatus()
    {
        $data = TransactionStatus::orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function getTransactionSaldo()
    {
        $data = TransactionSaldo::orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function deleteTransactions()
    {
        try {
            Transactions::query()->delete();
            TransactionStatus::query()->delete();
            TransactionSaldo::query()->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 400);
        }
    }

    public function getDataOutstanding(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        // $dataTransactions = Transactions::select('id')->get();
        // $lastStatuses = TransactionStatus::select('trans_id', DB::raw('MAX(urutan) as max_urutan'))
        //     ->whereIn('trans_id', $dataTransactions->pluck('id'))
        //     ->groupBy('trans_id');

        // $lastStatuses = TransactionStatus::select('transaction_status.trans_id', 'transaction_status.status', 'transaction_saldo.amount')
        //     ->joinSub($lastStatuses, 'last_status', function ($join) {
        //         $join->on('transaction_status.trans_id', '=', 'last_status.trans_id')
        //             ->on('transaction_status.urutan', '=', 'last_status.max_urutan');
        //     })
        //     ->join('transaction_saldo', 'transaction_saldo.transtatus_id', '=', 'transaction_status.id')
        //     ->where('transaction_status.status', 'Running')
        //     ->get();

        $lastStatuses = Outstanding::select('id AS trans_id', 'status', 'amount')->get();

        return $lastStatuses;
    }


    public function getHistoryGame(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $portfolio = $request->portfolio;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $data = [
            'username' => $username,
            'portfolio' => $portfolio,
            'startDate' => $startDate . 'T00:00:00.540Z',
            'endDate' => $endDate . 'T23:59:59.540Z',
            'companyKey' => env('COMPANY_KEY'),
            'language' => 'en',
            'serverId' => env('SERVERID')

        ];
        $apiUrl = env('BODOMAIN') . '/web-root/restricted/report/get-bet-list-by-modify-date.aspx';

        $response = Http::post($apiUrl, $data);
        $results = $response->json();

        if ($results["error"] != 0) {

            $results = $results['result'];
            foreach ($results as &$d) {
                $d['orderTime'] = Carbon::parse($d['orderTime'])->addHours(11)->toDateTimeString();
                $d['modifyDate'] = Carbon::parse($d['modifyDate'])->addHours(11)->toDateTimeString();
                $d['settleTime'] = Carbon::parse($d['settleTime'])->addHours(11)->toDateTimeString();
                $d['winLostDate'] = Carbon::parse($d['winLostDate'])->addHours(11)->toDateTimeString();
            }
        }


        return $results;
    }

    public function getHistoryGameById(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $refNos = $request->refNos;
        $portfolio = $request->portfolio;

        $data = [
            'refNos' => $refNos,
            'portfolio' => $portfolio,
            'companyKey' => env('COMPANY_KEY'),
            'language' => 'en',
            'serverId' => env('SERVERID')
        ];
        $apiUrl = env('BODOMAIN') . '/web-root/restricted/report/get-bet-list-by-refnos.aspx';

        $response = Http::post($apiUrl, $data);
        return $response->json();
    }

    private function validasiBearer(Request $request)
    {
        $token = $request->header('utilitiesgenerate');
        $expectedToken = env('UTILITIES_GENERATE');

        // return 'token header: ' . $token . ' || token env: ' . $expectedToken;

        if ($token !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        return true;
    }

    private function reqApiBalance($username)
    {
        $dataBalance = Balance::where('username', $username)->first();
        if ($dataBalance) {
            $dataBalance = $dataBalance->amount;
        } else {
            $dataBalance = 0;
        }

        return $dataBalance;
    }

    private function requestApi($endpoint, $data)
    {
        $url = env('BODOMAIN') . '/web-root/restricted/player/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    public function getApiBro(Request $request)
    {
        $data = [
            'username' => $request->username,
            'iswap' => $request->iswap,
            'device' => $request->device
        ];
        $apiUrl = env('DOMAIN') . '/prx/checkBalance';

        $response = Http::withHeaders([
            'utilitiesgenerate' => '2957984855aa91f9b11c2528bc389c97212348b9d211570911b621a285bba1aa417b0a98d78e42a2b764441795d403caf059b035ac0e2c58ba8099ff3bbac354',
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFiYW5ncG9vcmdhcyIsImlkIjoidXNlckxPQi02d2dzY2wwMFVXU2hRWkxFbCIsImV4cCI6MTcxNTYwMTA1MywiaWF0IjoxNzE1NjAwNzUzfQ.XAxwGSw2LWLmoXAK79JB2iOmMJ8QUrFhCV6gr1o1i84',

        ])->post($apiUrl, $data);
        return $response->json();
    }

    public function getDataHistoryAll()
    {
        return HistoryTransaksi::get();
    }

    public function getDataHistory(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        if ($username) {
            return [
                'status' => 'success',
                'data' => HistoryTransaksi::where('username', $username)->orderBy('created_at', 'DESC')->get()
            ];
        } else {
            return [
                'status' => 'fail',
                'message' => 'Username tidak boleh kosong'
            ];
        }
    }

    public function deleteHistoryTranskasi()
    {
        try {
            HistoryTransaksi::truncate();

            return [
                "status" => 'success',
            ];
        } catch (\Exception $e) {
            return [
                "status" => 'fail',
            ];
        }
    }


    public function getDataMember()
    {
        return Member::get();
    }

    public function getDataReferral(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;

        /* Count Referral */
        $Referral1 = Referral1::where('upline', $username)->count();
        $Referral2 = Referral2::where('upline', $username)->count();
        $Referral3 = Referral3::where('upline', $username)->count();
        $Referral4 = Referral4::where('upline', $username)->count();
        $Referral5 = Referral5::where('upline', $username)->count();
        $allCount = $Referral1 + $Referral2 + $Referral3 + $Referral4 + $Referral5;

        /* Sum Referral */
        $ReferralAktif1 = ReferralAktif1::where('upline', $username)->sum('amount');
        $ReferralAktif2 = ReferralAktif2::where('upline', $username)->sum('amount');
        $ReferralAktif3 = ReferralAktif3::where('upline', $username)->sum('amount');
        $ReferralAktif4 = ReferralAktif4::where('upline', $username)->sum('amount');
        $ReferralAktif5 = ReferralAktif5::where('upline', $username)->sum('amount');
        $allSum = $ReferralAktif1 + $ReferralAktif2 + $ReferralAktif3 + $ReferralAktif4 + $ReferralAktif5;

        /* Data Referral Member */
        $DataReferral1 = Referral1::from('referral_ae as A')
            ->leftJoin(DB::raw('(SELECT upline, downline, SUM(amount) as total_amount FROM ref_aktif_ae GROUP BY upline, downline) as B'), function ($join) {
                $join->on('A.upline', '=', 'B.upline')
                    ->on('A.downline', '=', 'B.downline');
            })
            ->select('A.*', DB::raw('COALESCE(B.total_amount, 0) as total_amount'))
            ->where('A.upline', '=', $username)
            ->get();
        $DataReferral2 = Referral2::from('referral_fj as A')
            ->leftJoin(DB::raw('(SELECT upline, downline, SUM(amount) as total_amount FROM ref_aktif_fj GROUP BY upline, downline) as B'), function ($join) {
                $join->on('A.upline', '=', 'B.upline')
                    ->on('A.downline', '=', 'B.downline');
            })
            ->select('A.*', DB::raw('COALESCE(B.total_amount, 0) as total_amount'))
            ->where('A.upline', '=', $username)
            ->get();
        $DataReferral3 = Referral3::from('referral_ko as A')
            ->leftJoin(DB::raw('(SELECT upline, downline, SUM(amount) as total_amount FROM ref_aktif_ko GROUP BY upline, downline) as B'), function ($join) {
                $join->on('A.upline', '=', 'B.upline')
                    ->on('A.downline', '=', 'B.downline');
            })
            ->select('A.*', DB::raw('COALESCE(B.total_amount, 0) as total_amount'))
            ->where('A.upline', '=', $username)
            ->get();
        $DataReferral4 = Referral4::from('referral_pt as A')
            ->leftJoin(DB::raw('(SELECT upline, downline, SUM(amount) as total_amount FROM ref_aktif_pt GROUP BY upline, downline) as B'), function ($join) {
                $join->on('A.upline', '=', 'B.upline')
                    ->on('A.downline', '=', 'B.downline');
            })
            ->select('A.*', DB::raw('COALESCE(B.total_amount, 0) as total_amount'))
            ->where('A.upline', '=', $username)
            ->get();
        $DataReferral5 = Referral5::from('referral_uz as A')
            ->leftJoin(DB::raw('(SELECT upline, downline, SUM(amount) as total_amount FROM ref_aktif_uz GROUP BY upline, downline) as B'), function ($join) {
                $join->on('A.upline', '=', 'B.upline')
                    ->on('A.downline', '=', 'B.downline');
            })
            ->select('A.*', DB::raw('COALESCE(B.total_amount, 0) as total_amount'))
            ->where('A.upline', '=', $username)
            ->get();
        $allData = $DataReferral1->union($DataReferral2)
            ->union($DataReferral3)
            ->union($DataReferral4)
            ->union($DataReferral5)->toArray();

        /* Data Komisi Referral Member */
        // $DataAktif1 = ReferralAktif1::select('upline', DB::raw('SUM(amount) as total_amount'))
        //     ->where('upline', $username)
        //     ->groupBy('upline')
        //     ->get();
        // $DataAktif2 = ReferralAktif2::select('upline', DB::raw('SUM(amount) as total_amount'))
        //     ->where('upline', $username)
        //     ->groupBy('upline')
        //     ->get();
        // $DataAktif3 = ReferralAktif3::select('upline', DB::raw('SUM(amount) as total_amount'))
        //     ->where('upline', $username)
        //     ->groupBy('upline')
        //     ->get();
        // $DataAktif4 = ReferralAktif4::select('upline', DB::raw('SUM(amount) as total_amount'))
        //     ->where('upline', $username)
        //     ->groupBy('upline')
        //     ->get();
        // $DataAktif5 = ReferralAktif5::select('upline', DB::raw('SUM(amount) as total_amount'))
        //     ->where('upline', $username)
        //     ->groupBy('upline')
        //     ->get();
        // $allDataKomisi = $DataAktif1->union($DataAktif2)->union($DataAktif3)->union($DataAktif4)->union($DataAktif5);

        return [
            'totalReferral' => $allCount,
            'totalKomisi' => $allSum,
            'dataReferral' => $allData,
            // 'dataKomisi' => $allDataKomisi
        ];
    }

    public function getWinLossBet()
    {
        return WinlossbetDay::get();
    }
}
