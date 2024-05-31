<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\BonusPengecualian;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\WinlossbetDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class MaintenancedsController extends Controller
{
    public function index()
    {
        $data = [];
        return view('maintenance.indexlist', [
            'title' => 'List Cashback dan Rollingan',
            'data' => $data
        ]);
    }
}
