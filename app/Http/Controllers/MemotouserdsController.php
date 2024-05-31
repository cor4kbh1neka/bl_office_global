<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MemotouserdsController extends Controller
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
        return view('memotouserds.index', [
            'title' => 'Memo To User',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function delivered()
    {
        return view('memotouserds.delivered_memo', [
            'title' => 'Memo To User',
            'totalnote' => 0,
        ]);
    }

    public function deliveredread()
    {
        return view('memotouserds.delivered_read', [
            'title' => 'Memo To User',
            'totalnote' => 0,
        ]);
    }
}
