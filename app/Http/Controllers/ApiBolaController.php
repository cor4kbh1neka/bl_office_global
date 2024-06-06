<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use App\Models\ProductType;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\Xreferral;
use App\Models\Persentase;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryTransaksi;
use App\Models\ReferralAktif1;
use App\Models\ReferralAktif2;
use App\Models\ReferralAktif3;
use App\Models\ReferralAktif4;
use App\Models\ReferralAktif5;
use Illuminate\Support\Facades\Log;
use App\Jobs\AddHistoryJob;
use App\Jobs\AddOutstandingJob;
use App\Jobs\AddWinlossStakeJob;
use App\Jobs\DeleteOutstandingJob;

use Illuminate\Support\Facades\Http;

class ApiBolaController extends Controller

{
    public function GetBalance(Request $request)
    {
        if ($request->Username != '') {
            $username = explode(env('UNIX_CODE'), $request->Username);
            if (isset($username[1])) {
                $username = $username[1];
            } else {
                $username = $username[0];
            }
            $request->merge(['Username' => $username]);
        }

        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO) {
            return $validasiSBO;
        }

        $saldo = Balance::where('username', $request->Username)->first()->amount + 0;

        return [
            "AccountName" => $request->Username,
            "Balance" => $saldo,
            "ErrorCode" => 0,
            "ErrorMessage" => "No Error"
        ];
    }

    public function GetBetStatus(Request $request)
    {
        if ($request->Username != '') {
            $username = explode(env('UNIX_CODE'), $request->Username)[1];
            $request->merge(['Username' => $username]);
        }

        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO) {
            return $validasiSBO;
        }

        $dataTransaction = Transactions::where('transactionid', $request->TransactionId)->first();
        if (!$dataTransaction) {
            return $this->errorResponse($request->Username, 6);
        }

        $statusTransaction = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($statusTransaction->status == 'Rollback' || $statusTransaction->status == 'Running') {
            $status = 'Running';
        } else if ($statusTransaction->status == 'Cancel') {
            $status = 'Void';
        } else {
            $status = $statusTransaction->status;
        }


        return [
            'TransferCode' => $request->TransferCode,
            'TransactionId' => $request->TransactionId,
            "Status" => $status,
            'ErrorCode' => 0,
            'ErrorMessage' => 'No Error'
        ];
    }

    public function Deduct(Request $request)
    {
        $username = explode(env('UNIX_CODE'), $request->Username)[1];
        $request->merge(['Username' => $username]);

        $saldoMember = $this->GetBalance($request);
        if ($saldoMember["ErrorCode"] === 0) {
            $saldoMember = $saldoMember["Balance"];
        } else {
            return $saldoMember;
        }

        return $this->setTransaction($request, $saldoMember);
    }

    public function Settle(Request $request)
    {
        $username = explode(env('UNIX_CODE'), $request->Username)[1];
        $request->merge(['Username' => $username]);

        $saldoMember = $this->GetBalance($request);
        if ($saldoMember["ErrorCode"] === 0) {
            $saldoMember = $saldoMember["Balance"];
        } else {
            return $saldoMember;
        }

        $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->orderBy('created_at', 'DESC')->get();
        if ($dataTransactions->isEmpty()) {
            return $this->errorResponse($request->Username, 6);
        }

        foreach ($dataTransactions as $index => $dataTransaction) {
            $results[] = $this->setSettle($request, $dataTransaction, $index, $saldoMember);
        }

        return reset($results);
    }

    public function Cancel(Request $request)
    {
        $username = explode(env('UNIX_CODE'), $request->Username)[1];
        $request->merge(['Username' => $username]);

        $saldoMember = $this->GetBalance($request);
        if ($saldoMember["ErrorCode"] === 0) {
            $saldoMember = $saldoMember["Balance"];
        } else {
            return $saldoMember;
        }

        $dataTransaction = Transactions::where('transactionid', $request->TransactionId)->first();
        if (!$dataTransaction) {
            return $this->errorResponse($request->Username, 6);
        }
        $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($request->ProductType == 9 && $lastStatus->status == 'Settled') {
            $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->get();

            if ($dataTransactions->isEmpty()) {
                return $this->errorResponse($request->Username, 6);
            }

            foreach ($dataTransactions as $dataTransaction) {
                $results[] = $this->setCancel($request, $dataTransaction, $saldoMember);
            }
            return end($results);
        }

        return $this->setCancel($request, $dataTransaction, $saldoMember);
    }

    public function Rollback(Request $request)
    {
        $username = explode(env('UNIX_CODE'), $request->Username)[1];
        $request->merge(['Username' => $username]);

        $saldoMember = $this->GetBalance($request);
        if ($saldoMember["ErrorCode"] === 0) {
            $saldoMember = $saldoMember["Balance"];
        } else {
            return $saldoMember;
        }

        $dataTransaction = Transactions::where('transfercode', $request->TransferCode)->first();

        if (!$dataTransaction) {
            return $this->errorResponse($request->Username, 6);
        }

        if ($request->ProductType == 9) {
            $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->get();

            if ($dataTransactions->isEmpty()) {
                return $this->errorResponse($request->Username, 6);
            }

            foreach ($dataTransactions as $dataTransaction) {
                $results[] = $this->setRollback($request, $dataTransaction, $saldoMember);
            }
            return end($results);
        }

        return $this->setRollback($request, $dataTransaction, $saldoMember);
    }

    public function Bonus(Request $request)
    {
        $username = explode(env('UNIX_CODE'), $request->Username)[1];
        $request->merge(['Username' => $username]);

        $saldoMember = $saldo = Balance::where('username', $request->Username)->first()->amount + 0;

        $cekTransaction = Transactions::where('transfercode', $request->TransferCode)->first();
        if ($cekTransaction) {
            return $this->errorResponse($request->Username, 5003);
        }

        $createTransaction = $this->createTransaction($request, 'Bonus');
        $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'Running');

        if ($crteateStatusTransaction) {
            $saldoTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, '', "D", $request->Amount, 1);

            if ($saldoTransaction) {
                $porcessBalance = $this->processBalance($request->Username, 'DP', $request->Amount);
                if ($porcessBalance["status"] === 'success') {
                    /* Create Queue Job History Transkasi */
                    $saldoMember = $porcessBalance["balance"];
                    $portfolio = ProductType::where('id', $request->ProductType)->first();
                    $portfolio = $portfolio ? $portfolio->portfolio : '';

                    // HistoryTransaksi::create([
                    //     'username' => $request->Username,
                    //     'invoice' =>  '',
                    //     'refno' => $request->TransferCode,
                    //     'keterangan' => 'Bonus',
                    //     'portfolio' => $portfolio,
                    //     'status' => 'bonus',
                    //     'debit' => 0,
                    //     'kredit' => $request->Amount,
                    //     'balance' => $saldoMember
                    // ]);

                    $this->addHistoryTranskasi($request->Username, '', $request->TransferCode, 'Bonus', $portfolio, 'bonus', 0, $request->Amount, $saldoMember);
                }

                $saldo = $saldoMember;
                return response()->json([
                    "AccountName" => $request->Username,
                    'Balance' => $saldo,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }

            return $this->errorResponse($request->Username, 5003);
        }
        return $this->errorResponse($request->Username, 5003);
    }

    public function ReturnStake(Request $request)
    {
        $username = explode(env('UNIX_CODE'), $request->Username)[1];
        $request->merge(['Username' => $username]);

        $saldoMember = Balance::where('username', $request->Username)->first()->amount + 0;

        $cekTransaction = Transactions::where('transactionid', $request->TransactionId)->first();
        if (!$cekTransaction) {
            return $this->errorResponse($request->Username, 6);
        }

        $lastStatus = TransactionStatus::where('trans_id', $cekTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first()->status;

        $txnid = '';
        if ($lastStatus === 'Running') {
            $createTransaction = $cekTransaction;
            $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'ReturnStake');

            if ($crteateStatusTransaction) {
                $saldoTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $request->CurrentStake, 1);

                if ($saldoTransaction) {
                    $porcessBalance = $this->processBalance($request->Username, 'DP', $request->CurrentStake);
                    if ($porcessBalance["status"] === 'success') {
                        /* Create Queue Job History Transkasi */
                        $saldoMember = $porcessBalance["balance"];
                        $portfolio = ProductType::where('id', $request->ProductType)->first();
                        $portfolio = $portfolio ? $portfolio->portfolio : '';

                        // HistoryTransaksi::create([
                        //     'username' => $request->Username,
                        //     'invoice' =>  $txnid,
                        //     'refno' => $request->TransferCode,
                        //     'keterangan' => 'Returnstake',
                        //     'portfolio' => $portfolio,
                        //     'status' => 'returnstake',
                        //     'debit' => 0,
                        //     'kredit' => $request->CurrentStake,
                        //     'balance' => $saldoMember
                        // ]);

                        $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, 'Returnstake', $portfolio, 'returnstake', 0, $request->CurrentStake, $saldoMember);
                    }


                    $saldo = $saldoMember;
                    return response()->json([
                        "AccountName" => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }
            }
        } else if ($lastStatus === 'ReturnStake') {
            return $this->errorResponse($request->Username, 5008);
        } else if ($lastStatus === 'Cancel') {
            return $this->errorResponse($request->Username, 2002);
        }
        return $this->errorResponse($request->Username, 6);
    }



    /* ======================= OUTSTANDING ======================= */
    private function createOutstanding($data)
    {
        AddOutstandingJob::dispatch($data);
        return;
    }

    private function deleteOutstanding($transfercode)
    {
        DeleteOutstandingJob::dispatch($transfercode);
        return;
    }


    /* ====================== Validasi SBO ======================= */
    private function validasiSBO(Request $request)
    {
        if ($request->Username == '') {
            return $this->errorResponse($request->Username, 3);
        }

        $member = MemberAktif::where('Username', $request->Username)->first();
        if (!$member) {
            $member = Member::where('Username', $request->Username)->first();
            if (!$member) {
                return $this->errorResponse($request->Username, 1);
            }
        }

        if ($request->CompanyKey != env('COMPANY_KEY')) {
            return $this->errorResponse($request->Username, 4);
        }

        return;
    }

    /* ====================== Rollback ======================= */
    private function setRollback(Request $request, $dataTransaction, $saldoMember)
    {
        try {
            // $dataTransactions = Transactions::where('transactionid', $dataTransaction->transactionid)->first();
            $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
            if ($lastStatus->status === 'Cancel') {
                $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Rollback');
                return $this->rollbackTransaction($request, $dataTransaction, $crteateStatusTransaction, $saldoMember);
            } else if ($lastStatus->status === 'Settled') {
                return $this->cancelTransaction($request, $dataTransaction, $lastStatus, $saldoMember);
            } else if ($lastStatus->status === 'Rollback') {
                return $this->errorResponse($request->Username, 2003);
            } else {
                $this->errorResponse($request->Username, 6);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }

    private function rollbackTransaction(Request $request, $dataTransaction, $crteateStatusTransaction, $saldoMember)
    {
        $lastRunningStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->where('status', 'Running')->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($lastRunningStatus) {
            if ($request->ProductType == 3 || $request->ProductType == 7) {
                $totalAmount = TransactionSaldo::where('transtatus_id', $lastRunningStatus->id)->sum('amount');
            } else {
                $dataTransactions = TransactionSaldo::where('transtatus_id', $lastRunningStatus->id)->first();
                $totalAmount = $dataTransactions->amount;
            }
            $txnid = '';

            if ($crteateStatusTransaction) {
                $this->createOutstanding([
                    "transactionid" => $dataTransaction->transactionid,
                    "transfercode" => $dataTransaction->transfercode,
                    "username" => $dataTransaction->username,
                    "portfolio" => ProductType::where('id', $request->ProductType)->first()->portfolio,
                    "gametype" => ($request->ProductType == 5 || $request->ProductType == 1) ? $request->ExtraInfo['sportType'] : ProductType::where('id', $request->ProductType)->first()->productsname,
                    "status" => 'Running',
                    "amount" => $totalAmount
                ]);

                $saldoTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "W", $totalAmount, 3);

                if ($saldoTransaction) {
                    $porcessBalance = $this->processBalance($request->Username, 'WD', $totalAmount);
                    if ($porcessBalance["status"] === 'success') {
                        /* Create Queue Job History Transkasi */
                        $saldoMember = $porcessBalance['balance'];
                        $dataPortfolio = ProductType::where('id', $request->ProductType)->first();
                        $portfolio = $dataPortfolio ? $dataPortfolio->portfolio : '';

                        // HistoryTransaksi::create([
                        //     'username' => $request->Username,
                        //     'invoice' =>  $txnid,
                        //     'refno' => $request->TransferCode,
                        //     'keterangan' => $portfolio,
                        //     'portfolio' => $portfolio,
                        //     'status' => 'rollback',
                        //     'debit' => $totalAmount,
                        //     'kredit' => 0,
                        //     'balance' => $saldoMember
                        // ]);

                        $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, 'rollback', $totalAmount, 0, $saldoMember);
                    }

                    $saldo = $saldoMember;
                    return response()->json([
                        "AccountName" => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }
            }
            return 'error $saldoTransaction : ' . $saldoTransaction;
        }
    }


    /* ====================== Cancel ======================= */
    private function setCancel(Request $request, $dataTransaction, $saldoMember)
    {
        $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
        $last2ndStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
            ->where('id', '!=', $lastStatus->id)
            // ->where('created_at', '<', $lastStatus->created_at) 
            ->whereIn('status', ['Running', 'Settled', 'Rollback'])
            ->orderBy('created_at', 'DESC')
            ->orderBy('urutan', 'DESC')
            ->first();

        if ($lastStatus->status != 'Cancel') {
            if ($lastStatus->status == 'Running' || $lastStatus->status == 'Rollback') {
                $this->deleteOutstanding($request->TransferCode);
            }

            $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Cancel');

            if ($crteateStatusTransaction) {

                if ($lastStatus->status == 'Settled') {
                    $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();

                    $txnid = '';
                    if ($dataTransactions->amount > 0) {
                        $createSaldo1 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, 'W', $dataTransactions->amount, 1);
                        if ($createSaldo1) {
                            /* Process Deduct / Saldo */
                            $porcessBalance = $this->processBalance($request->Username, 'WD', $dataTransactions->amount);
                            if ($porcessBalance["status"] === 'success') {
                                $saldoMember = $porcessBalance["balance"];
                                $portfolio = ProductType::where('id', $request->ProductType)->first();
                                $portfolio = $portfolio ? $portfolio->portfolio : '';
                                /* Create Queue Job History Transkasi */
                                // HistoryTransaksi::create([
                                //     'username' => $request->Username,
                                //     'invoice' =>  $txnid,
                                //     'refno' => $request->TransferCode,
                                //     'keterangan' => $portfolio,
                                //     'portfolio' => $portfolio,
                                //     'status' => 'cancel',
                                //     'debit' => $dataTransactions->amount,
                                //     'kredit' => 0,
                                //     'balance' => $saldoMember
                                // ]);

                                $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, 'cancel', $dataTransactions->amount, 0, $saldoMember);
                                $this->addWinlossStake($request->TransferCode, $portfolio, $dataTransactions->amount, 'cancel');
                            }
                        }
                    } else {
                        $dataReferral = HistoryTransaksi::where('refno', $request->TransferCode)->where('status', 'referral')->first();
                        if ($dataReferral) {
                            $porcessBalance = $this->processBalance($dataReferral->username, 'WD', $dataReferral->kredit);
                            if ($porcessBalance["status"] === 'success') {
                                /* Create Queue Job History Transkasi */
                                $portfolio = ProductType::where('id', $request->ProductType)->first();
                                $portfolio = $portfolio ? $portfolio->portfolio : '';

                                // HistoryTransaksi::create([
                                //     'username' => $dataReferral->username,
                                //     'invoice' =>  $txnid,
                                //     'refno' => $request->TransferCode,
                                //     'keterangan' => 'Bonus',
                                //     'portfolio' => $portfolio,
                                //     'status' => 'cancel',
                                //     'debit' => $dataReferral->kredit,
                                //     'kredit' => 0,
                                //     'balance' => $porcessBalance["balance"]
                                // ]);

                                $this->addHistoryTranskasi($dataReferral->username, $txnid, $request->TransferCode, 'Bonus', $portfolio, 'cancel', $dataReferral->kredit, 0, $porcessBalance["balance"]);
                                $dataTransactionsS2 = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
                                $this->addWinlossStake($request->TransferCode, $portfolio, ($dataTransactionsS2->amount * -1), 'cancel');
                            }
                        }
                    }

                    if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                        if ($request->ProductType == 3 || $request->ProductType == 7) {
                            $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                        } else {
                            $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                            $totalAmount = $dataTransactions->amount;
                        }

                        $jenis = 'D';

                        $txnid = '';
                        $createSaldo2 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 3);
                        if ($createSaldo2) {
                            /* Process Deduct / Saldo */
                            $porcessBalance = $this->processBalance($request->Username, 'DP', $totalAmount);
                            if ($porcessBalance["status"] === 'success') {
                                $saldoMember = $porcessBalance["balance"];
                                $portfolio = ProductType::where('id', $request->ProductType)->first();
                                $portfolio = $portfolio ? $portfolio->portfolio : '';

                                /* Create Queue Job History Transkasi */
                                // HistoryTransaksi::create([
                                //     'username' => $request->Username,
                                //     'invoice' =>  $txnid,
                                //     'refno' => $request->TransferCode,
                                //     'keterangan' => $portfolio,
                                //     'portfolio' => $portfolio,
                                //     'status' => 'cancel',
                                //     'debit' => 0,
                                //     'kredit' => $totalAmount,
                                //     'balance' => $saldoMember
                                // ]);

                                $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, 'cancel', 0, $totalAmount, $saldoMember);
                            }
                        }

                        if ($request->ProductType == 9) {
                            $checkReturnStakeStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
                                ->where('id', '!=', $lastStatus->id)
                                ->where('status', 'ReturnStake')
                                ->where('created_at', '<=', $lastStatus->created_at)
                                ->where('created_at', '>=', $last2ndStatus->created_at)
                                ->orderBy('created_at', 'DESC')
                                ->orderBy('urutan', 'DESC')
                                ->first();

                            if ($checkReturnStakeStatus) {
                                $trReturnStake = TransactionSaldo::where('transtatus_id', $checkReturnStakeStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                                $jenis = 'W';
                                $txnid = '';
                                $createSaldo3 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $trReturnStake->amount, 2);
                                if ($createSaldo3) {
                                    /* Process Deduct / Saldo */
                                    $porcessBalance = $this->processBalance($request->Username, 'WD', $trReturnStake->amount);
                                    if ($porcessBalance["status"] === 'success') {
                                        $saldoMember = $porcessBalance["balance"];
                                        $portfolio = ProductType::where('id', $request->ProductType)->first();
                                        $portfolio = $portfolio ? $portfolio->portfolio : '';
                                        /* Create Queue Job History Transkasi */
                                        // HistoryTransaksi::create([
                                        //     'username' => $request->Username,
                                        //     'invoice' =>  $txnid,
                                        //     'refno' => $request->TransferCode,
                                        //     'keterangan' => 'ReturnStake',
                                        //     'portfolio' => $portfolio,
                                        //     'status' => 'cancel',
                                        //     'debit' => $trReturnStake->amount,
                                        //     'kredit' => 0,
                                        //     'balance' => $saldoMember
                                        // ]);

                                        $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, 'ReturnStake', $portfolio, 'cancel', $trReturnStake->amount, 0, $saldoMember);
                                    }
                                }
                            }
                        }
                    }
                } else if ($lastStatus->status == 'Running' || $lastStatus->status == 'Rollback') {
                    if ($request->ProductType == 3 || $request->ProductType == 7) {
                        $totalAmount = TransactionSaldo::where('transtatus_id', $lastStatus->id)->sum('amount');
                    } else {
                        $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();
                        $totalAmount = $dataTransactions->amount;
                    }

                    $jenis = 'D';
                    $txnid = '';

                    $createSaldo4 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 1);

                    if ($createSaldo4) {
                        /* Process Deduct / Saldo */
                        $porcessBalance = $this->processBalance($request->Username, 'DP', $totalAmount);
                        if ($porcessBalance["status"] === 'success') {
                            $saldoMember = $porcessBalance["balance"];
                            $portfolio = ProductType::where('id', $request->ProductType)->first();
                            $portfolio = $portfolio ? $portfolio->portfolio : '';
                            /* Create Queue Job History Transkasi */
                            // HistoryTransaksi::create([
                            //     'username' => $request->Username,
                            //     'invoice' =>  $txnid,
                            //     'refno' => $request->TransferCode,
                            //     'keterangan' => $portfolio,
                            //     'portfolio' => $portfolio,
                            //     'status' => 'cancel',
                            //     'debit' => 0,
                            //     'kredit' => $totalAmount,
                            //     'balance' => $saldoMember
                            // ]);

                            $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, 'cancel', 0, $totalAmount, $saldoMember);
                        }
                    }
                } else if ($lastStatus->status == 'ReturnStake') {
                    if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                        if ($request->ProductType == 3 || $request->ProductType == 7) {
                            $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                        } else {
                            $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                            $totalAmount = $dataTransactions->amount;
                        }

                        if ($request->ProductType == 9) {
                            $checkReturnStakeStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
                                ->where('id', '!=', $lastStatus->id)
                                ->where('status', 'ReturnStake')
                                ->where('created_at', '<', $lastStatus->created_at)
                                ->where('created_at', '>', $last2ndStatus->created_at)
                                ->orderBy('created_at', 'DESC')
                                ->orderBy('urutan', 'DESC')
                                ->first();
                            $trReturnStake = TransactionSaldo::where('transtatus_id', $checkReturnStakeStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
                            if ($checkReturnStakeStatus) {
                                $jenis = 'W';
                                $txnid = '';
                                $createSaldo5 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $trReturnStake->amount, 1);

                                if ($createSaldo5) {
                                    $porcessBalance = $this->processBalance($request->Username, 'WD', $trReturnStake->amount);
                                    if ($porcessBalance["status"] === 'success') {
                                        $saldoMember = $porcessBalance["balance"];
                                        $portfolio = ProductType::where('id', $request->ProductType)->first();
                                        $portfolio = $portfolio ? $portfolio->portfolio : '';
                                        /* Create Queue Job History Transkasi */
                                        // HistoryTransaksi::create([
                                        //     'username' => $request->Username,
                                        //     'invoice' =>  $txnid,
                                        //     'refno' => $request->TransferCode,
                                        //     'keterangan' => $portfolio,
                                        //     'portfolio' => $portfolio,
                                        //     'status' => 'cancel',
                                        //     'debit' => $trReturnStake->amount,
                                        //     'kredit' => 0,
                                        //     'balance' => $saldoMember
                                        // ]);

                                        $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, 'cancel', $trReturnStake->amount, 0, $saldoMember);
                                    }
                                }
                            }
                        }

                        $jenis = 'D';

                        $txnid = '';
                        $createSaldo6 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 2);
                        if ($createSaldo6) {
                            $porcessBalance = $this->processBalance($request->Username, 'DP', $totalAmount);
                            if ($porcessBalance["status"] === 'success') {
                                $saldoMember = $porcessBalance["balance"];
                                $portfolio = ProductType::where('id', $request->ProductType)->first();
                                $portfolio = $portfolio ? $portfolio->portfolio : '';
                                /* Create Queue Job History Transkasi */
                                // HistoryTransaksi::create([
                                //     'username' => $request->Username,
                                //     'invoice' =>  $txnid,
                                //     'refno' => $request->TransferCode,
                                //     'keterangan' => 'ReturnStake',
                                //     'portfolio' => $portfolio,
                                //     'status' => 'cancel',
                                //     'debit' => 0,
                                //     'kredit' => $totalAmount,
                                //     'balance' => $saldoMember
                                // ]);

                                $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, 'ReturnStake', $portfolio, 'cancel', 0, $totalAmount, $saldoMember);
                            }
                        }
                    }
                }
            }

            $saldo = $saldoMember;
            return response()->json([
                "AccountName" => $request->Username,
                'Balance' => $saldo,
                'ErrorCode' => 0,
                'ErrorMessage' => 'No Error'
            ])->header('Content-Type', 'application/json; charset=UTF-8');
        } else {
            return $this->errorResponse($request->Username, 2002);
        }
    }

    private function cancelTransaction(Request $request, $dataTransaction, $lastStatus, $saldoMember)
    {
        $last2ndStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
            ->where('id', '!=', $lastStatus->id)
            ->whereIn('status', ['Running', 'Rollback'])
            ->orderBy('created_at', 'DESC')
            ->orderBy('urutan', 'DESC')
            ->first();

        $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Rollback');
        if ($crteateStatusTransaction) {
            $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();

            $createSaldo1 = $this->createSaldoTransaction($crteateStatusTransaction->id, '', 'W', $dataTransactions->amount, 1);

            if ($createSaldo1 && $dataTransactions->amount > 0) {
                $porcessBalance = $this->processBalance($request->Username, 'WD', $dataTransactions->amount);
                if ($porcessBalance["status"] === 'success') {
                    $saldoMember = $porcessBalance["balance"];
                    $portfolio = ProductType::where('id', $request->ProductType)->first();
                    $portfolio = $portfolio ? $portfolio->portfolio : '';
                    /* Create Queue Job History Transkasi */
                    // HistoryTransaksi::create([
                    //     'username' => $request->Username,
                    //     'invoice' =>  '',
                    //     'refno' => $request->TransferCode,
                    //     'keterangan' => $portfolio,
                    //     'portfolio' => $portfolio,
                    //     'status' => 'cancel',
                    //     'debit' => $dataTransactions->amount,
                    //     'kredit' => 0,
                    //     'balance' => $saldoMember
                    // ]);

                    $this->addHistoryTranskasi($request->Username, '', $request->TransferCode, $portfolio, $portfolio, 'cancel', $dataTransactions->amount, 0, $saldoMember);
                    $this->addWinlossStake($request->TransferCode, $portfolio, ($dataTransactions->amount * -1), 'rollback');
                }
            } else {
                /* Cancel Referral */
                $dataHistory = HistoryTransaksi::where('refno', $request->TransferCode)->where('status', 'referral')->first();
                if ($dataHistory) {
                    $porcessBalance = $this->processBalance($dataHistory->username, 'WD', $dataHistory->kredit);
                    if ($porcessBalance["status"] === 'success') {

                        /* Create Queue Job History Transkasi */
                        $saldoMember = $porcessBalance["balance"];
                        $portfolio = ProductType::where('id', $request->ProductType)->first();
                        $portfolio = $portfolio ? $portfolio->portfolio : '';

                        // HistoryTransaksi::create([
                        //     'username' => $dataHistory->username,
                        //     'invoice' =>  '',
                        //     'refno' => $request->TransferCode,
                        //     'portfolio' => $portfolio,
                        //     'keterangan' => 'Bonus',
                        //     'status' => 'cancel',
                        //     'debit' => $dataHistory->kredit,
                        //     'kredit' => 0,
                        //     'kredit' => $saldoMember
                        // ]);

                        $this->addHistoryTranskasi($dataHistory->username, '', $request->TransferCode, 'Bonus', $portfolio, 'cancel', $dataHistory->kredit, 0, $saldoMember);

                        /* Win Loss */
                        $dataTransactionsS2 = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
                        $this->addWinlossStake($request->TransferCode, $portfolio, ($dataTransactionsS2->amount * -1), 'rollback');
                    }
                }
            }

            if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                if ($request->ProductType == 3 || $request->ProductType == 7) {
                    $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                } else {
                    $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                    $totalAmount = $dataTransactions->amount;
                }

                $jenis = 'D';
                $txnid = '';
                $createSaldo2 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 2);

                if ($createSaldo2) {
                    $porcessBalance = $this->processBalance($request->Username, 'DP', $totalAmount);
                    if ($porcessBalance["status"] === 'success') {
                        $saldoMember = $porcessBalance["balance"];
                        $portfolio = ProductType::where('id', $request->ProductType)->first();
                        $portfolio = $portfolio ? $portfolio->portfolio : '';

                        // HistoryTransaksi::create([
                        //     'username' => $request->Username,
                        //     'invoice' =>  $txnid,
                        //     'refno' => $request->TransferCode,
                        //     'keterangan' => $portfolio,
                        //     'portfolio' => $portfolio,
                        //     'status' => 'rollback',
                        //     'debit' => 0,
                        //     'kredit' => $totalAmount,
                        //     'balance' => $saldoMember
                        // ]);

                        $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, 'rollback', 0, $totalAmount, $saldoMember);
                    }
                    /* Create Queue Job History Transkasi */
                }
            }
            return $this->rollbackTransaction($request, $dataTransaction, $crteateStatusTransaction, $saldoMember);
        }
    }

    /* ====================== Settle ======================= */
    private function setSettle(Request $request, $dataTransaction, $index, $saldoMember)
    {
        $dataStatusTransaction = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($dataStatusTransaction->status == 'Running' || $dataStatusTransaction->status == 'Rollback' || $dataStatusTransaction->status == 'ReturnStake') {
            $txnid = '';

            $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Settled');
            if ($crteateStatusTransaction) {
                $this->deleteOutstanding($request->TransferCode);

                $WinLoss = $index == 0 ? $request->WinLoss : 0;
                $saldoTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $WinLoss, 1);
                if ($saldoTransaction) {

                    // $checkXtrans = Xtrans::where('username', $request->Username)->whereDate('created_at', '=', date('Y-m-d'))->first();
                    $portfolio = ProductType::where('id', $request->ProductType)->first();
                    $portfolio = $portfolio ? $portfolio->portfolio : '';

                    if ($WinLoss > 0) {
                        // if ($checkXtrans) {
                        //     $checkXtrans->update([
                        //         'sum_winloss' => $checkXtrans->sum_winloss + $WinLoss
                        //     ]);
                        // } else {
                        //     // 'id', 'bank', 'groupbank', 'username', 'count_dp', 'count_wd', 'sum_dp',  'sum_wd', 'sum_winloss'
                        //     // Xtrans::create([
                        //     //     'bank' => '-',
                        //     //     'groupbank' => '-',
                        //     //     'username' => '-',
                        //     //     'count_dp' => '-',
                        //     //     'count_wd' => '-',
                        //     //     'sum_dp' => '-',
                        //     //     'sum_wd' => '-',
                        //     //     'sum_winloss' => ''
                        //     // ]);
                        // }

                        /* Process Deduct / Saldo */
                        $porcessBalance = $this->processBalance($request->Username, 'DP', $WinLoss);
                        if ($porcessBalance["status"] === 'success') {
                            /* Create History Transaksi */
                            $saldoMember = $porcessBalance["balance"];

                            // HistoryTransaksi::create([
                            //     'username' => $request->Username,
                            //     'invoice' =>  $txnid,
                            //     'refno' => $request->TransferCode,
                            //     'keterangan' => $portfolio,
                            //     'portfolio' => $portfolio,
                            //     'status' => $request->IsCashOut === true ? 'cashout' : 'menang',
                            //     'debit' => 0,
                            //     'kredit' => $WinLoss,
                            //     'balance' => $saldoMember
                            // ]);

                            $this->addHistoryTranskasi($request->Username, $txnid, $request->TransferCode, $portfolio, $portfolio, $request->IsCashOut === true ? 'cashout' : 'menang', 0, $WinLoss, $saldoMember);
                            $this->addWinlossStake($request->TransferCode, $portfolio, $WinLoss, 'settle');
                        }
                    } else {
                        $WinLoss = TransactionSaldo::where('transtatus_id', $dataStatusTransaction->id)->orderBy('urutan', 'asc')->first()->amount;
                        $this->addWinlossStake($request->TransferCode, $portfolio, ($WinLoss * -1), 'settle');
                        /* Referral */
                        $this->execReferral($request, $WinLoss);
                    }

                    // if ($request->IsCashOut !== true) {
                    /* Winloss Bet Rekap */

                    // }

                    $saldo = $saldoMember;
                    return [
                        "AccountName" => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ];
                }
            }
        } else if ($dataStatusTransaction->status == 'Cancel') {
            $WinLoss = $index == 0 ? $request->WinLoss : 0;
            return $this->errorResponse($request->Username, 2002);
        } else {
            $WinLoss = $index == 0 ? $request->WinLoss : 0;
            return $this->errorResponse($request->Username, 2001);
        }
    }

    private function execReferral(Request $request, $amount)
    {
        $dataAktif = MemberAktif::where('username', $request->Username)->first();
        if (!$dataAktif) {
            $dataAktif = Member::where('username', $request->Username)->first();
        }

        if ($dataAktif) {
            if ($dataAktif->referral !== '' && $dataAktif->referral !== null) {
                $portfolio = ProductType::where('id', $request->ProductType)->first();
                $portfolio = $portfolio ? $portfolio->portfolio : 'SportsBook';

                $persentase = Persentase::where('jenis', $portfolio)->first();
                $persentase = $persentase ? $persentase->persentase : 0;

                $referralAmount = $amount * $persentase / 100;
                if ($referralAmount > 0) {
                    $depositReferral = $this->processBalance($dataAktif->referral, 'DP', $referralAmount);
                    if ($depositReferral["status"] === "success") {

                        if ($dataAktif->referral !== null && $dataAktif->referral !== '') {
                            $dataReferral = [
                                'upline' => $dataAktif->referral,
                                'downline' => $request->Username,
                                'portfolio' => $portfolio,
                                'amount' => $referralAmount
                            ];

                            if (preg_match('/^[a-e]/i', $dataAktif->referral)) {
                                $refAktif = ReferralAktif1::where('downline', $request->Username)->whereDate('created_at', date('Y-m-d'))->first();
                                if ($refAktif) {

                                    $refAktif->increment('amount', $referralAmount);
                                } else {
                                    ReferralAktif1::create($dataReferral);
                                }
                            } elseif (preg_match('/^[f-j]/i', $dataAktif->referral)) {
                                $refAktif = ReferralAktif2::where('downline', $request->Username)->whereDate('created_at', date('Y-m-d'))->first();
                                if ($refAktif) {

                                    $refAktif->increment('amount', $referralAmount);
                                } else {
                                    ReferralAktif2::create($dataReferral);
                                }
                            } elseif (preg_match('/^[k-o]/i', $dataAktif->referral)) {
                                $refAktif = ReferralAktif3::where('downline', $request->Username)->whereDate('created_at', date('Y-m-d'))->first();
                                if ($refAktif) {

                                    $refAktif->increment('amount', $referralAmount);
                                } else {
                                    ReferralAktif3::create($dataReferral);
                                }
                            } elseif (preg_match('/^[p-t]/i', $dataAktif->referral)) {
                                $refAktif = ReferralAktif4::where('downline', $request->Username)->whereDate('created_at', date('Y-m-d'))->first();
                                if ($refAktif) {

                                    $refAktif->increment('amount', $referralAmount);
                                } else {
                                    ReferralAktif4::create($dataReferral);
                                }
                            } elseif (preg_match('/^[u-z]/i', $dataAktif->referral)) {
                                $refAktif = ReferralAktif5::where('downline', $request->Username)->whereDate('created_at', date('Y-m-d'))->first();
                                if ($refAktif) {

                                    $refAktif->increment('amount', $referralAmount);
                                } else {
                                    ReferralAktif5::create($dataReferral);
                                }
                            }
                        }

                        /* Create History Transaksi */
                        $saldoMember = Balance::where('username', $dataAktif->referral)->first()->amount;
                        // HistoryTransaksi::create([
                        //     'username' => $dataAktif->referral,
                        //     'invoice' =>  '',
                        //     'refno' => $request->TransferCode,
                        //     'keterangan' => 'Bonus',
                        //     'portfolio' => $portfolio,
                        //     'status' => 'referral',
                        //     'debit' => 0,
                        //     'kredit' => $referralAmount,
                        //     'balance' => $saldoMember
                        // ]);

                        $this->addHistoryTranskasi($dataAktif->referral, '', $request->TransferCode, 'Bonus', $portfolio, 'referral', 0, $referralAmount, $saldoMember);
                    }
                }
            }
        }
    }

    /* ====================== Deduct ======================= */
    private function saldoBerjalan(Request $request)
    {
        $allsaldoTransaction = $this->getAllTransactions($request);

        $dataAllTransactionsWD = $allsaldoTransaction->where('jenis', 'W')->sum('amount');
        $dataAllTransactionsDP = $allsaldoTransaction->where('jenis', 'D')->sum('amount');

        $saldoBerjalan = $dataAllTransactionsDP  - $dataAllTransactionsWD;

        return $saldoBerjalan;
    }

    // private function requestWitdraw9720(Request $request, $txnid)
    // {
    //     set_time_limit(60);
    //     sleep(4.5);
    //     $addTransactions = $this->withdraw($request, $txnid);

    //     if ($addTransactions["error"]["id"] === 9720) {
    //         sleep(1.5);
    //         $addTransactions = $this->withdraw($request, $txnid);
    //         return $addTransactions;
    //     }

    //     return $addTransactions;
    // }

    private function setTransaction(Request $request, $saldoMember)
    {
        // Log::info('Informasi Request:', [
        //     'parameters' => $request->all()
        // ]);

        $cekTransaction = Transactions::where('transactionid', $request->TransactionId)->first();

        if ($cekTransaction) {
            if ($request->ProductType == 3 || $request->ProductType == 7) {
                $cekLastStatus = TransactionStatus::where('trans_id', $cekTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                if ($cekLastStatus->status == 'Running') {
                    $totalTransaction = TransactionSaldo::where('transtatus_id', $cekLastStatus->id)->sum('amount');
                    if (!($request->Amount > $totalTransaction)) {
                        return $this->errorResponse($request->Username, 7);
                    }
                } else {
                    return $this->errorResponse($request->Username, 5003);
                }

                $dataTransactions = TransactionSaldo::where('transtatus_id', $cekLastStatus->id)->first();
                $saldoMember = $saldoMember + $dataTransactions->amount;
            } else {
                return $this->errorResponse($request->Username, 5003);
            }
        }

        if ($saldoMember < $request->Amount) {
            return $this->errorResponse($request->Username, 5);
        }

        if (($request->ProductType == 3 || $request->ProductType == 7) && $cekTransaction) {
            $createTransaction = $cekTransaction;
            $crteateStatusTransaction = $cekLastStatus;
        } else {
            $createTransaction = $this->createTransaction($request, 'Betting');
            $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'Running');
        }

        if ($crteateStatusTransaction) {
            if ($request->ProductType == 3 && $cekTransaction || $request->ProductType == 7 && $cekTransaction) {
                $amount = $request->Amount - $dataTransactions->amount;
                $saldoTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, '-', "W", $amount, 1);
            } else {
                $amount = $request->Amount;
                $saldoTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, '-', "W", $amount, 1);
            }

            if ($saldoTransaction) {
                /* Process Deduct / Saldo */
                $porcessBalance = $this->processBalance($request->Username, 'WD', $amount);
                if ($porcessBalance["status"] === 'success') {
                    /* Create Queue Job History Transkasi */
                    $saldoMember = $porcessBalance["balance"];
                    $dataPortfolio = ProductType::where('id', $request->ProductType)->first();
                    $portfolio = $dataPortfolio ? $dataPortfolio->portfolio : '';

                    // HistoryTransaksi::create([
                    //     'username' => $request->Username,
                    //     'invoice' =>  '',
                    //     'refno' => $request->TransferCode,
                    //     'keterangan' => $portfolio,
                    //     'portfolio' => $portfolio,
                    //     'status' => 'pemasangan',
                    //     'debit' => $request->Amount,
                    //     'kredit' => 0,
                    //     'balance' => $saldoMember
                    // ]);

                    $this->addHistoryTranskasi($request->Username, '', $request->TransferCode, $portfolio, $portfolio, 'pemasangan', $request->Amount, 0, $saldoMember);

                    /* Create Outstanding */
                    $this->createOutstanding([
                        "transactionid" => $request->TransactionId,
                        "transfercode" => $request->TransferCode,
                        "username" => $request->Username,
                        "portfolio" => ProductType::where('id', $request->ProductType)->first()->portfolio,
                        "gametype" => isset($request->ExtraInfo['sportType']) ? $request->ExtraInfo['sportType'] : ProductType::where('id', $request->ProductType)->first()->productsname,
                        "status" => 'Running',
                        "amount" => $amount
                    ]);

                    $saldo = $saldoMember;
                    return [
                        "AccountName" => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ];
                }
            }
        }
    }

    private function createTransaction(Request $request, $type)
    {
        $createTransaction = Transactions::create([
            "transactionid" => $request->TransactionId,
            "transfercode" => $request->TransferCode,
            "username" => $request->Username,
            "type" => $type,
            "status" => 0
        ]);

        return $createTransaction;
    }

    private function updateTranStatus($trans_id, $status)
    {
        $results = TransactionStatus::create([
            "trans_id" => $trans_id,
            "status" => $status
        ]);
        return $results;
    }

    private function createSaldoTransaction($transtatus_id, $txnid, $jenis, $amount, $urutan)
    {
        $results = TransactionSaldo::create([
            "transtatus_id" => $transtatus_id,
            "txnid" => $txnid,
            "jenis" => $jenis,
            "amount" => $amount,
            "urutan" => $urutan
        ]);

        return $results;
    }

    private function getAllTransactions(Request $request)
    {
        $username = $request->Username;
        $transactions = Transactions::where('username', $username)->get();
        $saldoTransactions = collect();

        foreach ($transactions as $transaction) {
            $transactions = $transaction->transactionstatus->flatMap(function ($status) {
                return $status->transactionsaldo;
            });

            $saldoTransactions = $saldoTransactions->concat($transactions);
        }
        return $saldoTransactions;
    }

    /* ====================== Process Balance ======================= */
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
                "balance" => 0,
                "message" => $e->getMessage()
            ];
        }
    }



















    function requestApi($endpoint, $data)
    {
        $url = env('BODOMAIN') . '/web-root/restricted/player/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        $responseData = $response->json();

        return $responseData;
    }

    private function errorResponse($username, $errorCode)
    {
        if ($errorCode == '0') {
            $errorMessage = 'No Error';
        } else if ($errorCode == '1') {
            $errorMessage = 'Member not exist';
        } else if ($errorCode == '2') {
            $errorMessage = 'Invalid Ip';
        } else if ($errorCode == '3') {
            $errorMessage = 'Username empty';
        } else if ($errorCode == '4') {
            $errorMessage = 'CompanyKey Error';
        } else if ($errorCode == '5') {
            $errorMessage = 'Not enough balance';
        } else if ($errorCode == '6') {
            $errorMessage = 'Bet not exists';
        } else if ($errorCode == '7') {
            $errorMessage = 'Internal Error';
        } else if ($errorCode == '2001') {
            $errorMessage = 'Bet Already Settled';
        } else if ($errorCode == '2002') {
            $errorMessage = 'Bet Already Canceled';
        } else if ($errorCode == '2003') {
            $errorMessage = 'Bet Already Rollback';
        } else if ($errorCode == '5003') {
            $errorMessage = 'Bet With Same RefNo Exists';
        } else if ($errorCode == '5008') {
            $errorMessage = 'Bet Already Returned Stake';
        } else if ($errorCode == '9720') {
            $errorMessage = 'Withdraw request so frequent';
        } else {
            $errorMessage = 'Internal Error';
        }

        return [
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ];
    }

    private function addWinlossStake($transfercode, $portfolio, $amount, $jenis)
    {
        $winlossData = [
            'transfercode' => $transfercode,
            'portfolio' => $portfolio,
            'amount' => $amount,
            'jenis' => $jenis
        ];

        AddWinlossStakeJob::dispatch($winlossData);
    }

    // private function getApi($refNos, $portfolio)
    // {
    //     $data = [
    //         'refNos' => $refNos,
    //         'portfolio' => $portfolio,
    //         'companyKey' => env('COMPANY_KEY'),
    //         'language' => 'en',
    //         'serverId' => env('SERVERID')
    //     ];
    //     $apiUrl = env('BODOMAIN') . '/web-root/restricted/report/get-bet-list-by-refnos.aspx';

    //     $response = Http::post($apiUrl, $data);
    //     return $response->json();
    // }

    // private function cancelWinlossStake($transfercode, $portfolio)
    // {
    //     $winlossData = [
    //         'transfercode' => '4668995',
    //         'portfolio' => $portfolio
    //     ];
    //     CancelWinlossStakeJob::dispatch($winlossData);
    //     return;
    // }

    private function addHistoryTranskasi($username, $txnid, $refno, $keterangan, $portfolio, $status, $debit, $kredit, $balance)
    {
        $historyData = [
            'username' => $username,
            'invoice' =>  $txnid,
            'refno' => $refno,
            'keterangan' => $keterangan,
            'portfolio' => $portfolio,
            'status' => $status,
            'debit' => $debit,
            'kredit' => $kredit,
            'balance' => $balance
        ];

        AddHistoryJob::dispatch($historyData);

        return;
    }
}
