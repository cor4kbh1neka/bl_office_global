<?php

namespace App\Http\Controllers;

use App\Models\DepoWd;
use App\Models\Rekap;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class Menu2Controller extends Controller
{
    public function index()
    {

        $tanggal_awal_1 = date('Y-m-d 00:00:00');
        $tanggal_akhir_1 = date('Y-m-d 23:59:59');

        $dataRekapHariIni = Rekap::whereBetween('created_at', [$tanggal_awal_1, $tanggal_akhir_1])->first();
        if ($dataRekapHariIni) {
            return 'Data sudah di rekap';
        }

        $tanggal_awal = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $tanggal_akhir = date('Y-m-d 23:59:59', strtotime('-1 day'));

        $count_depo_acc = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP', 'DPM'])->where('status', 1)->count();
        $count_depo_all = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP', 'DPM'])->count();
        $count_wd_acc = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['WD', 'WDM'])->where('status', 1)->count();
        $count_Wd_all = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP', 'DPM'])->count();
        $total_depo = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP'])->where('status', 1)->sum('amount');
        $total_depo_manual = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DPM'])->where('status', 1)->sum('amount');
        $total_wd = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['WD'])->where('status', 1)->sum('amount');
        $total_wd_manual = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['WDM'])->where('status', 1)->sum('amount');

        $lastStatuses = $this->getStatusTransaction();
        $count_bet_settled = $lastStatuses->count();


        $total_bet_settled = $lastStatuses->map(function ($item) {
            return $item->amount_settle - $item->amount_deduct;
        });
        $total_bet_settled = $total_bet_settled->sum();

        $count_mo = 0;
        $count_newregis = Member::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();
        $count_newdepo = Member::where('status',  9)->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();
        $count_total_member = Member::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->count();

        Rekap::create([
            'count_depo_acc' => $count_depo_acc,
            'count_depo_all' => $count_depo_all,
            'count_wd_acc' => $count_wd_acc,
            'count_wd_all' => $count_Wd_all,
            'total_depo' => $total_depo,
            'total_depo_manual' => $total_depo_manual,
            'total_wd' => $total_wd,
            'total_wd_manual' => $total_wd_manual,
            'count_bet_settled' => $count_bet_settled,
            'total_bet_settled' => $total_bet_settled,
            'count_mo' => $count_mo,
            'count_newregis' => $count_newregis,
            'count_newdepo' => $count_newdepo,
            'count_total_member' => $count_total_member
        ]);

        return view('menu2.index', [
            'title' => 'Menu 2',
            'data' => [],
            'totalnote' => 0,
        ]);
    }

    private function getStatusTransaction()
    {
        $tanggal_awal = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $tanggal_akhir = date('Y-m-d 23:59:59', strtotime('-1 day'));

        $dataTransactions = Transactions::select('id')->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get();
        $lastStatuses = TransactionStatus::select('trans_id', DB::raw('MAX(urutan) as max_urutan'))
            ->whereIn('trans_id', $dataTransactions->pluck('id'))
            ->groupBy('trans_id');

        $lastStatuses = TransactionStatus::select('transaction_status.trans_id', 'transaction_status.status', 'first_status_saldo_amount.amount as amount_deduct', 'transaction_saldo.amount as amount_settle')
            ->joinSub($lastStatuses, 'last_status', function ($join) {
                $join->on('transaction_status.trans_id', '=', 'last_status.trans_id')
                    ->on('transaction_status.urutan', '=', 'last_status.max_urutan');
            })
            ->join('transaction_saldo', 'transaction_saldo.transtatus_id', '=', 'transaction_status.id')
            ->leftJoin('transaction_status as first_status_saldo', function ($join) {
                $join->on('first_status_saldo.trans_id', '=', 'transaction_status.trans_id')
                    ->where('first_status_saldo.urutan', '=', 1);
            })
            ->leftJoin('transaction_saldo as first_status_saldo_amount', 'first_status_saldo_amount.transtatus_id', '=', 'first_status_saldo.id')
            ->where('transaction_status.status', 'Settled')

            ->get();

        return $lastStatuses;
    }



    public function create()
    {

        return view('menu2.create', [
            'title' => 'Menu 2',
            'totalnote' => 0,
        ]);
    }
}
