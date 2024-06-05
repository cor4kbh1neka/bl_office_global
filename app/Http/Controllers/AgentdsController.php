<?php

namespace App\Http\Controllers;

use App\Models\BetSetting;
use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use App\Models\Persentase;
use App\Models\UserAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AgentdsController extends Controller
{
    public function index()
    {
        $data = User::paginate(20);
        return view('agentds.index', [
            'title' => 'Agent',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function create()
    {
        $dataAccess = UserAccess::get();
        return view('agentds.create', [
            'title' => 'Add New Agent',
            'totalnote' => 0,
            'dataAccess' => $dataAccess
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'divisi' => 'required',
        ]);

        $user = new User();
        $user->name = $request->username;
        $user->username = $request->username;
        $user->divisi = $request->divisi;
        $user->password = bcrypt($request->password);
        $user->image = "";
        $user->status = 1;

        $user->save();

        return redirect('/agentds')->with('success', 'Aget berhasil ditambahkan.');
    }

    public function agentupdate($id)
    {
        $data = User::where('id', $id)->first();
        $dataAccess = UserAccess::get();
        return view('agentds.agent_update', [
            'title' => 'Update Agent',
            'totalnote' => 0,
            'data' => $data,
            'dataAccess' => $dataAccess
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'divisi' => 'required',
            'newpassword' => 'nullable',
        ]);

        $user = User::findOrFail($request->id);
        if ($request->filled('newpassword')) {
            $user->password = bcrypt($request->newpassword);
        }

        $user->divisi = $request->divisi;
        $user->save();

        Cache::forget('user_access_' . $user->id);

        return redirect()->back()->with('success', 'Data Agent berhasil diupdate.');
    }

    public function agentinfo()
    {

        return view('agentds.agent_info', [
            'title' => 'Informasi Agent',
            'totalnote' => 0,
        ]);
    }

    public function access()
    {
        $data = UserAccess::get();
        return view('agentds.access', [
            'title' => 'Access Agent',
            'totalnote' => 0,
            'data' => $data
        ]);
    }

    public function accessupdate($id)
    {
        $data = UserAccess::where('id', $id)->first();
        return view('agentds.access_update', [
            'title' => 'Access Agent Update',
            'totalnote' => 0,
            'data' => $data
        ]);
    }

    public function accessadd()
    {
        return view('agentds.access_add', [
            'title' => 'Add Access Agent',
            'totalnote' => 0,
        ]);
    }

    public function store_access(Request $request)
    {

        $request->validate([
            'name_access' => 'required'
        ]);

        $user = new UserAccess();
        $user->name_access = $request->name_access;
        $user->deposit = isset($request->deposit) ? true : false;
        $user->withdraw = isset($request->withdraw) ? true : false;
        $user->manual_transaction = isset($request->manual_transaction) ? true : false;
        $user->history_coin = isset($request->history_coin) ? true : false;

        $user->member_list = isset($request->member_list) ? true : false;
        $user->member_seamless = isset($request->member_seamless) ? true : false;
        $user->referral = isset($request->referral) ? true : false;
        $user->history_game = isset($request->history_game) ? true : false;
        $user->member_outstanding = isset($request->member_outstanding) ? true : false;
        $user->history_transaction = isset($request->history_transaction) ? true : false;
        $user->cashback_rollingan = isset($request->cashback_rollingan) ? true : false;
        $user->report = isset($request->report) ? true : false;

        $user->bank = isset($request->bank) ? true : false;
        $user->refeerral_bonus = isset($request->refeerral_bonus) ? true : false;
        $user->memo = isset($request->memo) ? true : false;

        $user->agent = isset($request->agent) ? true : false;
        $user->analytic = isset($request->analytic) ? true : false;
        $user->content = isset($request->content) ? true : false;
        $user->apk_setting = isset($request->apk_setting) ? true : false;
        $user->memo_other = isset($request->memo_other) ? true : false;
        $user->save();

        return redirect('/agentds/access')->with('success', 'Access agent berhasil ditambahkan.');
    }

    public function destroy_access($id)
    {
        $data = UserAccess::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Access agent berhasil dihapus.');
    }

    public function update_access(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'name_access' => 'required'
        ]);

        $id = $request->id;
        $user = UserAccess::findOrFail($id);

        $user->name_access = $request->name_access;
        $user->deposit = isset($request->deposit) ? true : false;
        $user->withdraw = isset($request->withdraw) ? true : false;
        $user->manual_transaction = isset($request->manual_transaction) ? true : false;
        $user->history_coin = isset($request->history_coin) ? true : false;

        $user->member_list = isset($request->member_list) ? true : false;
        $user->member_seamless = isset($request->member_seamless) ? true : false;
        $user->referral = isset($request->referral) ? true : false;
        $user->history_game = isset($request->history_game) ? true : false;
        $user->member_outstanding = isset($request->member_outstanding) ? true : false;
        $user->history_transaction = isset($request->history_transaction) ? true : false;
        $user->cashback_rollingan = isset($request->cashback_rollingan) ? true : false;
        $user->report = isset($request->report) ? true : false;

        $user->bank = isset($request->bank) ? true : false;
        $user->refeerral_bonus = isset($request->refeerral_bonus) ? true : false;
        $user->memo = isset($request->memo) ? true : false;

        $user->agent = isset($request->agent) ? true : false;
        $user->analytic = isset($request->analytic) ? true : false;
        $user->content = isset($request->content) ? true : false;
        $user->apk_setting = isset($request->apk_setting) ? true : false;
        $user->memo_other = isset($request->memo_other) ? true : false;
        $user->save();

        Cache::flush();

        return redirect()->back()->with('success', 'Access agent berhasil diupdate.');
    }

    // public function storesetting(Request $request)
    // {
    //     $request->validate([
    //         'min' => 'required',
    //         'max' => 'required',
    //         'sportsbook' => 'required',
    //         'virtualsports' => 'required',
    //         'games' => 'required'
    //     ]);

    //     $dataBetSetting = BetSetting::where('id', 1)->first();
    //     $reqBetSetting = [
    //         'min' => $request->min,
    //         'max' => $request->max
    //     ];
    //     if ($dataBetSetting) {
    //         $dataBetSetting->update($reqBetSetting);
    //     } else {
    //         BetSetting::create($reqBetSetting);
    //     }

    //     $dataPersentaseSB = Persentase::where('jenis', 'SportsBook')->first();
    //     if ($dataPersentaseSB) {
    //         $dataPersentaseSB->update([
    //             'persentase' => $request->sportsbook
    //         ]);
    //     } else {
    //         Persentase::create([
    //             'jenis' => 'SportsBook',
    //             'persentase' => $request->sportsbook
    //         ]);
    //     }


    //     $dataPersentaseVS = Persentase::where('jenis', 'VirtualSports')->first();
    //     if ($dataPersentaseVS) {
    //         $dataPersentaseVS->update([
    //             'persentase' => $request->virtualsports
    //         ]);
    //     } else {
    //         Persentase::create([
    //             'jenis' => 'SportsBook',
    //             'persentase' => $request->virtualsports
    //         ]);
    //     }

    //     $dataPersentaseG = Persentase::where('jenis', 'Games')->first();
    //     if ($dataPersentaseG) {
    //         $dataPersentaseG->update([
    //             'persentase' => $request->games
    //         ]);
    //     } else {
    //         Persentase::create([
    //             'jenis' => 'SportsBook',
    //             'persentase' => $request->games
    //         ]);
    //     }



    //     $user = new User();
    //     $user->name = $request->username;
    //     $user->username = $request->username;
    //     $user->divisi = $request->divisi;
    //     $user->password = bcrypt($request->password);
    //     $user->image = "";
    //     $user->status = 1;

    //     $user->save();

    //     return redirect('/agentds')->with('success', 'Aget berhasil ditambahkan.');
    // }

    public function userAndUserAccess()
    {
        $user = auth()->user();
        $userWithAccess = User::with('userAccess')->find($user->id);
        // $userWithAccess = User::with('userAccess')->find($user->id); 
        // userAccess di atas adalah penghubung ke method userAccess di model User.php
        // Cara bacanya User yang memiliki hubungan ke model UserAccess dengan name_access yang serupa dengan divisi milik model User
        // Maka temukan ID nya si auth user dan 
        $result = $userWithAccess->toArray();
        if ($result['user_access']['deposit'] = 1) {
            dd('masuk');
        } else {
            dd('keluar');
        }

        return $result;
    }
}
