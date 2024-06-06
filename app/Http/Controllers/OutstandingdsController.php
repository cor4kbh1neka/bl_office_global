<?php

namespace App\Http\Controllers;

use App\Models\Outstanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MemberOutstandingExport;

class OutstandingdsController extends Controller
{
    public function index(Request $request, $userid = "")
    {
        $username = $request->input('username');

        $getDataOuts = Outstanding::get();
        $dataOuts = $getDataOuts;

        if ($username) {
            $dataOuts = $dataOuts->where('username', $username);
        }

        $dataOuts = $dataOuts->groupBy('username')->map(function ($group) {
            $totalAmount = $group->sum('amount');
            $count = $group->count();
            return [
                'username' => $group->first()['username'],
                'totalAmount' => $totalAmount,
                'count' => $count,
            ];
        })->values();
        $countOuts = $dataOuts->count();

        if ($userid != '') {
            $dataOtstandingDetail = $getDataOuts->where('username', $userid);
        } else {
            $dataOtstandingDetail = [];
        }
        $data = $this->paginate($dataOuts, 20);
        $dataOtstandingPaginate = $this->paginate2($dataOtstandingDetail, 20);
        return view('outstandingds.index', [
            'title' => 'Member Outstanding',
            'data' => $data,
            'totalnote' => 0,
            'username' => $username,
            'countOuts' => $countOuts,
            'dataouts' => $dataOtstandingPaginate
            // 'isList' => $isList
        ]);
    }

    // private function requestApi($endpoint, $data)
    // {
    //     $url = env('BODOMAIN') . '/web-root/restricted/report/' . $endpoint . '.aspx';

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json; charset=UTF-8',
    //     ])->post($url, $data);

    //     if ($response->successful()) {
    //         $responseData = $response->json();
    //     } else {
    //         // $statusCode = $response->status();
    //         // $errorMessage = $response->body();
    //         // $responseData = "Error: $statusCode - $errorMessage";
    //         $responseData = $response->json();
    //     }

    //     return $responseData;
    // }
    public function paginate($data, $page)
    {
        $query = collect($data);

        // Mengambil halaman saat ini untuk tabel pertama
        $currentPage = Paginator::resolveCurrentPage('page1'); // Menggunakan 'page1' sebagai query string parameter
        $perPage = $page;
        $currentPageItems = $query->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $query->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'pageName' => 'page1']
        );

        return $paginatedItems;
    }

    public function paginate2($data, $page)
    {
        $query = collect($data);

        // Mengambil halaman saat ini untuk tabel kedua
        $currentPage = Paginator::resolveCurrentPage('page2'); // Menggunakan 'page2' sebagai query string parameter
        $perPage = $page;
        $currentPageItems = $query->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $query->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'pageName' => 'page2']
        );

        return $paginatedItems;
    }

    public function export(Request $request)
    {
        $username = $request->username;
        $data = Outstanding::select('username', 'created_at', 'transfercode', 'gametype', 'status', 'amount')->get();

        $data = collect($data);
        return Excel::download(new MemberOutstandingExport($data), 'MemberOutstanding-' . $username . '.xlsx');
    }
}
