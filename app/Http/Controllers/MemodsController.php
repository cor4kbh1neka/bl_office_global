<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MemodsController extends Controller
{
    public function index()
    {
        $data = [
            [
                'id' => '1',
                'nama' => 'Waantos',
                'alamat' => 'Pekanbaru',
                'notelp' => '0778007711',
                'tgllhir' => '12-09-1996',
                'tempatlahir' => 'sukajadi'
            ]
        ];

        return view('memods.index', [
            'title' => 'Memo',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function viewinbox()
    {

        return view('memods.inbox_memo', [
            'title' => 'Inbox',
            'totalnote' => 0,
        ]);
    }

    public function readinbox()
    {

        return view('memods.inbox_read', [
            'title' => 'Read Inbox',
            'totalnote' => 0,
        ]);
    }

    public function archiveinbox()
    {

        return view('memods.inbox_archive', [
            'title' => 'Archive Inbox',
            'totalnote' => 0,
        ]);
    }

    public function delivered()
    {
        $headers = [
            'Content-Type' => 'application/json',
            // 'x-customblhdrs' => env('XCUSTOMBLHDRS'), // Ganti dengan token Anda jika diperlukan
            'x-customblhdrs' => '09c90c1d6e1b82015737f88d5f5b827060a57c874babe97f965aaa68072585191ce0eab75404312f4f349ee70029404c2d8f66698b6a4da18990445d1437ff79', // Ganti dengan token Anda jika diperlukan
            // Tambahkan header lain sesuai kebutuhan
        ];

        $response = Http::withHeaders($headers)->get(env('DOMAIN') . '/memo/1');
        $results = [];
        if ($response->json()['status'] !== 'fail') {
            $results = $response->json()["data"];
        }
        $data = $this->filterAndPaginate($results, 20);
        return view('memods.delivered_memo', [
            'title' => 'Delivered',
            'totalnote' => 0,
            'data' => $data
        ]);
    }

    public function readdelivered($id)
    {
        $response = Http::get(env('DOMAIN') . '/memo');
        $results = $response->json()["data"];
        $result = collect($results)->where('idmemo', $id)->toArray();
        $result = array_values($result);

        return view('memods.delivered_read', [
            'title' => 'Delivered',
            'totalnote' => 0,
            'data' => $result[0]
        ]);
    }

    public function storememo(Request $request)
    {
        $validatedData = $request->validate([
            'statustype' => 'required',
            'statuspriority' => 'required',
            'subject' => 'required',
            'memo' => 'required',
        ]);

        $validatedData["statustype"] = intval($validatedData["statustype"]);
        $validatedData["statuspriority"] = intval($validatedData["statuspriority"]);
        $apiUrl = env('DOMAIN') . '/memo';

        $headers = [
            'Content-Type' => 'application/json',
            'x-customblhdrs' => env('XCUSTOMBLHDRS'), // Ganti dengan token Anda jika diperlukan
            // Tambahkan header lain sesuai kebutuhan
        ];


        $response = Http::withHeaders($headers)->post($apiUrl, $validatedData);
        if ($response->successful()) {
            return redirect('/memods/delivered')->with('success', 'Memo berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function delete($id)
    {
        $response = Http::delete(env('DOMAIN') . '/memo/' . $id);
        if ($response->successful()) {
            return redirect('/memods/delivered')->with('success', 'Memo berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }
    public function filterAndPaginate($data, $page)
    {
        $query = collect($data);
        $parameter = [
            'statuspriority',
            'idmemo',
        ];

        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $query = $query->filter(function ($item) use ($isiSearch) {
                    return stripos($item[$isiSearch], request($isiSearch)) !== false;
                });
            }
        }

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
    }
}
