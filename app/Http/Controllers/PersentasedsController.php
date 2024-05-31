<?php

namespace App\Http\Controllers;

use App\Models\Persentase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PersentasedsController extends Controller
{
    public function index()
    {
        $data = Persentase::get();
        return view('persentaseds.index', [
            'title' => 'User Management',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
}
