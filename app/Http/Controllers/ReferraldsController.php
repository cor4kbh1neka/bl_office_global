<?php

namespace App\Http\Controllers;

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
use App\Models\ReferralDepo1;
use App\Models\ReferralDepo2;
use App\Models\ReferralDepo3;
use App\Models\ReferralDepo4;
use App\Models\ReferralDepo5;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReferraldsController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->getQueryString();
        $upline = $request->input('upline');
        $portfolio = $request->input('portfolio');
        $gabungdari = $request->input('gabungdari', date('Y-m-d'));
        $gabunghingga = $request->input('gabunghingga', date('Y-m-d'));

        if (isset($upline)) {
            $table = $this->determineTable($upline);

            $filterDepo = "WHERE 1=1";
            $filterAktif = "WHERE 1=1";

            if (isset($upline)) {
                $filterDepo .= " AND A1.upline = '$upline'";
                $filterAktif .= " AND A1.upline = '$upline'";
            }

            if (isset($portfolio)) {
                $filterAktif .= " AND A1.portfolio = '$portfolio'";
            }

            if (isset($gabungdari) && isset($gabunghingga)) {
                $filterDepo .= " AND A1.created_at >= '$gabungdari' AND A1.created_at <= '$gabunghingga'";
                $filterAktif .= " AND A1.created_at >= '$gabungdari' AND A1.created_at <= '$gabunghingga'";
            }

            $results = DB::table('referral' . $table . ' as A')
                ->select(
                    'A.upline',
                    DB::raw('COUNT(A.downline) as total_downline'),
                    DB::raw('COALESCE(B.total_deposit, 0) as total_depo'),
                    DB::raw('COUNT(A.downline) - COALESCE(B.total_deposit, 0) as total_nondepo'),
                    DB::raw('COALESCE(C.total_aktif, 0) as total_aktif'),
                    DB::raw('COUNT(A.downline) - COALESCE(C.total_aktif, 0) as total_nonaktif'),
                    DB::raw('COALESCE(C.total_amount_referral, 0) as total_amount_referral')
                )
                ->leftJoin(DB::raw('(SELECT A2.upline, COUNT(A2.downline) as total_deposit FROM (SELECT A1.upline, A1.downline FROM ref_depo' . $table . ' A1 ' . $filterDepo . ' GROUP BY A1.upline, A1.downline) A2 GROUP BY A2.upline) B'), 'A.upline', '=', 'B.upline')
                ->leftJoin(DB::raw('(SELECT A3.upline, COUNT(A3.downline) as total_aktif, SUM(A3.total_amount_referral) as total_amount_referral FROM (SELECT A1.upline, A1.downline, SUM(A1.amount) as total_amount_referral FROM ref_aktif' . $table . ' A1 ' . $filterAktif . ' GROUP BY A1.upline, A1.downline) A3 GROUP BY A3.upline) C'), 'A.upline', '=', 'C.upline')
                ->where('A.upline', $upline)
                ->groupBy('A.upline', 'B.total_deposit', 'C.total_aktif', 'C.total_amount_referral')
                ->get();
        } else {
            $results = [];
        }
        return view('referralds.index', [
            'title' => 'Referral',
            'data' => $results,
            'totalnote' => 0,
            'upline' => $upline,
            'portfolio' => $portfolio,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'query' => $query,
            'total_upline' => 0,
            'total_bonus' => 0
        ]);
    }

    private function determineTable($username)
    {
        $firstCharacter = strtolower($username[0]);

        if (in_array($firstCharacter, ['a', 'b', 'c', 'd', 'e'])) {
            return '_ae';
        } elseif (in_array($firstCharacter, ['f', 'g', 'h', 'i', 'j'])) {
            return '_fj';
        } elseif (in_array($firstCharacter, ['k', 'l', 'm', 'n', 'o'])) {
            return '_ko';
        } elseif (in_array($firstCharacter, ['p', 'q', 'r', 's', 't'])) {
            return '_pt';
        } elseif (in_array($firstCharacter, ['u', 'v', 'w', 'x', 'y', 'z'])) {
            return '_uz';
        }
    }


    public function index33(Request $request)
    {
        $query = $request->getQueryString();
        $upline = $request->input('upline');
        $portfolio = $request->input('portfolio');
        $gabungdari = $request->input('gabungdari', date('Y-m-d'));
        $gabunghingga = $request->input('gabunghingga', date('Y-m-d'));

        $tables = ['ae', 'fj', 'pt', 'ko', 'uz'];

        $queryParts = [];

        foreach ($tables as $table) {
            $tableQuery = DB::table("referral_$table")
                ->leftJoin("ref_depo_$table", function ($join) use ($table) {
                    $join->on("referral_$table.upline", '=', "ref_depo_$table.upline")
                        ->on("referral_$table.downline", '=', "ref_depo_$table.downline");
                })
                ->leftJoin("ref_aktif_$table", function ($join) use ($table) {
                    $join->on("referral_$table.upline", '=', "ref_aktif_$table.upline")
                        ->on("referral_$table.downline", '=', "ref_aktif_$table.downline");
                })
                ->select(
                    DB::raw("'$table' as source"),
                    "referral_$table.upline",
                    DB::raw('COALESCE(COUNT(DISTINCT referral_' . $table . '.id), 0) as total_referral'),
                    DB::raw('COALESCE(COUNT(DISTINCT ref_depo_' . $table . '.id), 0) as total_deposit'),
                    DB::raw('COALESCE(COUNT(DISTINCT referral_' . $table . '.id), 0) - COALESCE(COUNT(DISTINCT ref_depo_' . $table . '.id), 0) as total_nondeposit'),
                    DB::raw('COALESCE(COUNT(DISTINCT ref_aktif_' . $table . '.id), 0) as total_aktif'),
                    DB::raw('COALESCE(COUNT(DISTINCT referral_' . $table . '.id), 0) - COALESCE(COUNT(DISTINCT ref_aktif_' . $table . '.id), 0) as total_nonaktif'),
                    DB::raw('COALESCE(SUM(ref_aktif_' . $table . '.amount), 0) as total_amount')
                )
                ->groupBy("referral_$table.upline");

            if ($upline) {
                $tableQuery->where("referral_$table.upline", '=', $upline);
            }

            if ($portfolio) {
                $tableQuery->where("ref_aktif_$table.portfolio", '=', $portfolio);
            }

            if ($gabungdari && $gabunghingga) {
                $tableQuery->whereBetween("referral_$table.created_at", [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
                    ->orWhereBetween("ref_depo_$table.created_at", [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
                    ->orWhereBetween("ref_aktif_$table.created_at", [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"]);
            }

            $queryParts[] = $tableQuery;
        }

        $finalQuery = array_shift($queryParts);
        foreach ($queryParts as $part) {
            $finalQuery->unionAll($part);
        }

        $results = $finalQuery->get();


        // Buat query menggunakan query builder dari model pertama
        // $query = ReferralAktif1::select(
        //     'upline',
        //     DB::raw('SUM(amount) as total_amount')
        // )
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->when($portfolio != '', function ($query) use ($portfolio) {
        //         return $query->where('portfolio', $portfolio);
        //     })
        //     ->groupBy('upline');

        // // Union dengan query lain, tetap dalam bentuk query builder
        // $query = $query->union(
        //     ReferralAktif2::select(
        //         'upline',
        //         DB::raw('SUM(amount) as total_amount')
        //     )
        //         ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //         ->when($portfolio != '', function ($query) use ($portfolio) {
        //             return $query->where('portfolio', $portfolio);
        //         })
        //         ->groupBy('upline')
        // )
        //     ->union(
        //         ReferralAktif3::select(
        //             'upline',
        //             DB::raw('SUM(amount) as total_amount')
        //         )
        //             ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //             ->when($portfolio != '', function ($query) use ($portfolio) {
        //                 return $query->where('portfolio', $portfolio);
        //             })
        //             ->groupBy('upline')
        //     )
        //     ->union(
        //         ReferralAktif4::select(
        //             'upline',
        //             DB::raw('SUM(amount) as total_amount')
        //         )
        //             ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //             ->when($portfolio != '', function ($query) use ($portfolio) {
        //                 return $query->where('portfolio', $portfolio);
        //             })
        //             ->groupBy('upline')
        //     )
        //     ->union(
        //         ReferralAktif5::select(
        //             'upline',
        //             DB::raw('SUM(amount) as total_amount')
        //         )
        //             ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //             ->when($portfolio != '', function ($query) use ($portfolio) {
        //                 return $query->where('portfolio', $portfolio);
        //             })
        //             ->groupBy('upline')
        //     );
        // $unionAktif = $query->get();

        // /* Data Referral Depo */
        // $ReferralDepo1 = ReferralDepo1::select('upline', DB::raw('SUM(amount) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline', 'downline');

        // $ReferralDepo2 = ReferralDepo2::select('upline', DB::raw('SUM(amount) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline', 'downline');


        // $ReferralDepo3 = ReferralDepo3::select('upline', DB::raw('SUM(amount) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline', 'downline');


        // $ReferralDepo4 = ReferralDepo4::select('upline', DB::raw('SUM(amount) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline', 'downline');


        // $ReferralDepo5 = ReferralDepo5::select('upline', DB::raw('SUM(amount) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline', 'downline');


        // // Gabungkan query menggunakan union
        // $unionDepo = $ReferralDepo1
        //     ->union($ReferralDepo2)
        //     ->union($ReferralDepo3)
        //     ->union($ReferralDepo4)
        //     ->union($ReferralDepo5)
        //     ->get();

        // dd($unionDepo);

        // /* Data Upline Referral */
        // $Referral1 = Referral1::select('upline', DB::raw('COUNT(id) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline');

        // $Referral2 = Referral2::select('upline', DB::raw('COUNT(id) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline');

        // $Referral3 = Referral3::select('upline', DB::raw('COUNT(id) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline');

        // $Referral4 = Referral4::select('upline', DB::raw('COUNT(id) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline');

        // $Referral5 = Referral5::select('upline', DB::raw('COUNT(id) as total'))
        //     ->whereBetween('created_at', ["$gabungdari 00:00:00", "$gabunghingga 23:59:59"])
        //     ->groupBy('upline');

        // // Gabungkan query menggunakan union
        // $unionReferrals = $Referral1
        //     ->union($Referral2)
        //     ->union($Referral3)
        //     ->union($Referral4)
        //     ->union($Referral5)
        //     ->get();


        // $allQueryData = [];
        // foreach ($unionReferrals as $i => $d) {
        //     $allQueryData[$i]['upline'] = $d->upline;
        //     $allQueryData[$i]['total_referral'] = $d->total;
        //     foreach ($unionDepo as $dp) {
        //         if ($dp->upline == $d->upline) {
        //             $allQueryData[$i]['total_deposit'] = $dp->total;
        //             $allQueryData[$i]['total_nondeposit'] = $d->total - $dp->total;
        //             break;
        //         }
        //     }
        //     foreach ($unionAktif as $dp) {
        //         if ($dp->upline == $d->upline) {
        //             $allQueryData[$i]['total_aktif'] = $dp->total;
        //             $allQueryData[$i]['total_nonaktif'] = $d->total - $dp->total;
        //             $allQueryData[$i]['total_amount'] = $dp->total_amount;
        //             break;
        //         }
        //     }
        // }

        // dd($allQueryData);



        $total_upline = Referral1::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])->count()
            + Referral2::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])->count()
            + Referral3::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])->count()
            + Referral4::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])->count()
            + Referral5::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])->count();

        $total_bonus = ReferralAktif1::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
            ->whereNotNull('portfolio')
            ->sum('amount') +
            ReferralAktif2::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
            ->whereNotNull('portfolio')
            ->sum('amount') +
            ReferralAktif3::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
            ->whereNotNull('portfolio')
            ->sum('amount') +
            ReferralAktif4::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
            ->whereNotNull('portfolio')
            ->sum('amount') +
            ReferralAktif5::whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
            ->whereNotNull('portfolio')
            ->sum('amount');

        return view('referralds.index', [
            'title' => 'Referral',
            'data' => $results,
            'totalnote' => 0,
            'upline' => $upline,
            'portfolio' => $portfolio,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'query' => $query,
            'total_upline' => $total_upline,
            'total_bonus' => $total_bonus
        ]);
    }

    public function downlinedetail(Request $request, $upline, $jenis, $total, $total_referral, $total_downline)
    {
        // $allDownline = Referral1::count() + Referral2::count() + Referral3::count() + Referral4::count() + Referral5::count();
        $portfolio = $request->input('portfolio');
        $gabungdari = $request->input('gabungdari', date('Y-m-d'));
        $gabunghingga = $request->input('gabunghingga', date('Y-m-d'));

        if ($jenis == 'totaldownline') {
            $data = $this->getTotalDownline($upline, $portfolio, $gabungdari . "T00:00:00", $gabunghingga . "T23:59:59");
        } else if ($jenis == 'deposit') {
            $data = $this->getDeposit($upline, $portfolio, $gabungdari . "T00:00:00", $gabunghingga . "T23:59:59");
        } else if ($jenis == 'belumdeposit') {
            $data = $this->getBelumDeposit($upline, $portfolio, $gabungdari . "T00:00:00", $gabunghingga . "T23:59:59");
        } else if ($jenis == 'aktif') {
            $data = $this->getAktif($upline, $portfolio, $gabungdari . "T00:00:00", $gabunghingga . "T23:59:59");
        } else if ($jenis == 'tidakaktif') {
            $data = $this->getTidakAktif($upline, $portfolio, $gabungdari . "T00:00:00", $gabunghingga . "T23:59:59");
        } else if ($jenis == 'bonusreferral') {
            $data = $this->getTotalDownline($upline, $portfolio, $gabungdari . "T00:00:00", $gabunghingga . "T23:59:59");
        }

        return view('referralds.detail_downline', [
            'title' => 'Downline Detail',
            'totalnote' => 0,
            'data' => $data,
            'upline' => $upline,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'total_referral' => $total_referral,
            'total' => $total,
            'total_downline' => $total_downline,
            'countdata' => $data->count()
            // 'total_all_donwline' => $allDownline
        ]);
    }

    private function getTidakAktif($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $dataReferral = ReferralAktif1::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])->pluck('downline')->toArray();

            $data = Referral1::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $dataReferral = ReferralAktif2::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])->pluck('downline')->toArray();

            $data = Referral2::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $dataReferral = ReferralAktif3::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])->pluck('downline')->toArray();

            $data = Referral3::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $dataReferral = ReferralAktif4::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])->pluck('downline')->toArray();

            $data = Referral4::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $dataReferral = ReferralAktif5::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])->pluck('downline')->toArray();

            $data = Referral5::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        }
        return $data;
    }

    private function getAktif($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $data = ReferralAktif1::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('downline')
                ->get();
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $data = ReferralAktif2::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('downline')
                ->get();
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $data = ReferralAktif3::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('downline')
                ->get();
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $data = ReferralAktif4::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('downline')
                ->get();
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $data = ReferralAktif5::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('downline')
                ->get();
        }
        return $data;
    }

    private function getBelumDeposit($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $dataReferral = ReferralDepo1::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();

            $data = Referral1::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $dataReferral = ReferralDepo2::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();

            $data = Referral2::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $dataReferral = ReferralDepo3::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();

            $data = Referral3::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $dataReferral = ReferralDepo4::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();

            $data = Referral4::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $dataReferral = ReferralDepo5::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();

            $data = Referral5::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount_referral = 0;
                }
            }
        }
        return $data;
    }

    private function getDeposit($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $data = ReferralDepo1::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $data = ReferralDepo2::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $data = ReferralDepo3::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $data = ReferralDepo4::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $data = ReferralDepo5::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        }
        return $data;
    }

    private function getTotalDownline($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $data = ReferralAktif1::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $data = ReferralAktif2::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $data = ReferralAktif3::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $data = ReferralAktif4::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $data = ReferralAktif5::where('upline', $upline)
                ->when($portfolio != '', function ($query) use ($portfolio) {
                    return $query->where('portfolio', $portfolio);
                })
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->select('upline', 'downline', DB::raw('SUM(amount) as total_amount_referral'))
                ->groupBy('upline', 'downline')
                ->get();
        }
        return $data;
    }

    public function bonusreferral()
    {

        return view('referralds.referral_downline', [
            'title' => 'Bonus Referral',
            'totalnote' => 0,
        ]);
    }
}
