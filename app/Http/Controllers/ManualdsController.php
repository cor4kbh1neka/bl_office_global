<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\DepoWd;
use App\Models\Member;

class ManualdsController extends Controller
{
    public function index()
    {
        $errorCode = session()->has('errorCode') ? session('errorCode') : 0;
        $message = session()->has('message') ? session('message') : '';

        return view('manualds.index', [
            'title' => 'Proses Manual',
            'totalnote' => 0,
            'jenis' => 'DPM',
            'errorCode' => $errorCode,
            'message' => $message
        ]);
    }
}
