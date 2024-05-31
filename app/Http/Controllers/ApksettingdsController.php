<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApksettingdsController extends Controller
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
        return view('apksettingds.index', [
            'title' => 'Apk Setting',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function apksetting()
    {
        return view('apksettingds.setting', [
            'title' => 'Apk Setting',
            'totalnote' => 0,
        ]);
    }

    public function apkevent()
    {
        return view('apksettingds.event', [
            'title' => 'Apk Setting',
            'totalnote' => 0,
        ]);
    }

    public function apkeventadd()
    {
        return view('apksettingds.event_add', [
            'title' => 'Apk Setting',
            'totalnote' => 0,
        ]);
    }

    public function apkeventedit()
    {
        return view('apksettingds.event_edit', [
            'title' => 'Apk Setting',
            'totalnote' => 0,
        ]);
    }
}
