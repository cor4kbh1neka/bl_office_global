<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NotifikasidsController extends Controller
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
        return view('notifikasids.index', [
            'title' => 'Notifikasi',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function readinformasi()
    {
        return view('notifikasids.read', [
            'title' => 'Notifikasi',
            'totalnote' => 0,
        ]);
    }
}
