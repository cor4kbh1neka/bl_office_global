<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\DepoWdController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositdsController;
use App\Http\Controllers\ManualdsController;
use App\Http\Controllers\HistorycoindsController;
use App\Http\Controllers\MemberlistdsController;
use App\Http\Controllers\HistorytransaksidsController;
use App\Http\Controllers\HistorygamedsController;
use App\Http\Controllers\OutstandingdsController;
use App\Http\Controllers\ReportdsController;
use App\Http\Controllers\ReferraldsController;
use App\Http\Controllers\BankdsController;
use App\Http\Controllers\MemodsController;
use App\Http\Controllers\AgentdsController;
use App\Http\Controllers\AnalyticsdsController;
use App\Http\Controllers\ContentdsController;
use App\Http\Controllers\ApksettingdsController;
use App\Http\Controllers\MemotouserdsController;
use App\Http\Controllers\NotifikasidsController;
use App\Http\Controllers\Menu2Controller;
use App\Http\Controllers\PersentasedsController;
use App\Http\Controllers\BonusdsController;
use App\Http\Controllers\MaintenancedsController;
use App\Http\Controllers\BonussettingdsController;
use App\Models\Xdpwd;
use App\Models\Outstanding;
use App\Models\DepoWd;
use App\Models\Notes;



// Route::group(['middleware' => ['allowedIP']], function () {

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('memberlistds');
    }
    abort(404);
});

/* Dashboard */
Route::get('/dashboard', function () {
    return view('layouts.index', [
        'title' => 'dashboard',
        'totalnote' => 0
    ]);
})->middleware('auth');
// Route::get('/dashboard', [DepositdsController::class, 'index'])->name('depositds')->middleware(['deposit']);

/* Login & Logout */
Route::get('/S0oDv1Ch4nG3T1', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/S0oDv1Ch4nG3T1', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->Middleware('auth');


/* Middleware */
Route::middleware(['auth'])->group(function () {
    /* Loader */
    Route::get('/codetest', function () {
        return view('layouts.loader');
    })->name('codetest');

    /* Top Nav */
    Route::get('/topnav', function () {
        $totalnote = Notes::count();
        return view('layouts.top_nav', ['totalnote' => $totalnote]);
    })->name('topnav');

    /* Side Nav */
    Route::get('/sidenav', function () {
        return view('layouts.side_nav');
    })->name('sidenav');

    /* Notes */
    Route::get('/notes', [NotesController::class, 'index']);
    Route::get('/notes/add', [NotesController::class, 'create']);
    Route::get('/notes/edit/{id}', [NotesController::class, 'edit']);
    Route::post('/notes/store', [NotesController::class, 'store']);
    Route::post('/notes/update', [NotesController::class, 'update']);
    Route::delete('/notes/delete', [NotesController::class, 'destroy']);
    Route::get('/notes/view/{id}', [NotesController::class, 'views']);

    /* Profile */
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/profile/update/', [UserController::class, 'updateProfile']);

    /*-- User --*/
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/add', [UserController::class, 'create']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::delete('/user/delete', [UserController::class, 'destroy']);
    Route::get('/user/view/{id}', [UserController::class, 'views']);

    /*-- Agents --*/
    Route::get('/agents', [AgentsController::class, 'index']);
    Route::get('/agents/add', [AgentsController::class, 'create']);
    Route::get('/agents/edit/{id}', [AgentsController::class, 'edit']);
    Route::post('/agents/store', [AgentsController::class, 'store']);
    Route::post('/agents/update', [AgentsController::class, 'update']);
    Route::delete('/agents/delete', [AgentsController::class, 'destroy']);
    Route::get('/agents/view/{id}', [AgentsController::class, 'views']);

    /*-- Analyticsds --*/
    Route::get('/analyticsds', [AnalyticsdsController::class, 'index']);
    Route::post('/analyticsds', [AnalyticsdsController::class, 'editMetaTag']);

    Route::get('/analyticsds/sitemap', [AnalyticsdsController::class, 'sitemap']);
    Route::get('/analyticsds/sitemap/create', [AnalyticsdsController::class, 'createSitemap']);
    Route::post('/analyticsds/sitemap', [AnalyticsdsController::class, 'storeSitemap']);
    Route::put('/analyticsds/sitemap/{urpage}', [AnalyticsdsController::class, 'updateSitemap']);
    Route::delete('/analyticsds/sitemap/{urpage}', [AnalyticsdsController::class, 'deleteSitemap']);

    /*-- Contentds --*/
    Route::prefix('contentds')->group(function () {
        Route::get('/', [ContentdsController::class, 'index']);
        Route::put('/{id}', [ContentdsController::class, 'generalUpdate']);

        Route::get('/promo', [ContentdsController::class, 'promo']);
        Route::get('/promo/add', [ContentdsController::class, 'promoadd']);
        Route::post('/promo', [ContentdsController::class, 'promostore']);
        Route::get('/promo/{id}/edit', [ContentdsController::class, 'promoedit']);
        Route::put('/promo/{id}', [ContentdsController::class, 'promoupdate']);
        Route::post('/promo/edit', [ContentdsController::class, 'promourutan']);
        Route::delete('/promo/{id}', [ContentdsController::class, 'promodelete']);

        Route::get('/slider', [ContentdsController::class, 'slider']);
        Route::get('/slider/{id}/edit', [ContentdsController::class, 'sliderEdit']);
        Route::put('/slider/{id}', [ContentdsController::class, 'sliderUpdate']);

        Route::get('/link', [ContentdsController::class, 'link']);
        Route::get('/link/{id}/edit', [ContentdsController::class, 'linkEdit']);
        Route::put('/link/{id}', [ContentdsController::class, 'linkUpdate']);

        Route::get('/socialmedia', [ContentdsController::class, 'socialmedia']);
        Route::get('/socialmedia/{id}/edit', [ContentdsController::class, 'socialmediaedit']);
        Route::put('/socialmedia/{id}', [ContentdsController::class, 'socialmediaupdate']);

        Route::get('/maintenance', [ContentdsController::class, 'statusMaintenance']);
        Route::get('/maintenance/{status}/edit', [ContentdsController::class, 'statusMaintenanceEdit']);
        Route::put('/maintenance/{status}', [ContentdsController::class, 'statusMaintenanceUpdate']);
    });
    /*-- Players --*/
    Route::get('/players', [PlayersController::class, 'index']);
    Route::get('/players/add', [PlayersController::class, 'create']);
    Route::get('/players/edit/{id}', [PlayersController::class, 'edit']);
    Route::post('/players/store', [PlayersController::class, 'store']);
    Route::post('/players/update', [PlayersController::class, 'update']);
    Route::delete('/players/delete', [PlayersController::class, 'destroy']);
    Route::get('/players/view/{id}', [PlayersController::class, 'views']);

    /*-- Transactions --*/
    Route::get('/transactions', [TransactionsController::class, 'index']);

    /*-- Settings --*/
    // Route::get('/settings', [SettingsController::class, 'index']);
    // Route::get('/settings/add', [SettingsController::class, 'create']);
    // Route::get('/settings/edit/{id}', [SettingsController::class, 'edit']);
    // Route::post('/settings/store', [SettingsController::class, 'store']);
    // Route::post('/settings/update', [SettingsController::class, 'update']);
    // Route::delete('/settings/delete', [SettingsController::class, 'destroy']);
    // Route::get('/settings/view/{id}', [SettingsController::class, 'views']);

    /*-- Deposit --*/
    Route::get('/deposit', [DepoWdController::class, 'indexdeposit']);
    Route::get('/history/{jenis?}', [DepoWdController::class, 'indexhistory'])->name('history');
    Route::get('/withdrawal', [DepoWdController::class, 'indexwithdrawal']);
    Route::post('/reject/{jenis}', [DepoWdController::class, 'reject']);
    Route::post('/approve/{jenis}', [DepoWdController::class, 'approve']);
    Route::get('/manual', [DepoWdController::class, 'indexmanual']);
    Route::post('/manual/add', [DepoWdController::class, 'storemanual']);

    /*-- Member --*/
    Route::get('/member', [MemberController::class, 'index']);
    Route::get('/member/add', [MemberController::class, 'create']);
    Route::get('/member/edit/{id}', [MemberController::class, 'edit']);
    Route::post('/member/store', [MemberController::class, 'store']);
    Route::post('/member/updatemember', [MemberController::class, 'updateMember']);
    Route::post('/member/updatepassword', [MemberController::class, 'updatePassword']);
    Route::post('/member/updateplayer', [MemberController::class, 'updatePlayer']);

    /*-- APK --*/
    Route::get('/setting', [SettingsController::class, 'indexsetting']);
    Route::get('/event', [SettingsController::class, 'indexevent']);
    Route::get('/notice', [SettingsController::class, 'indexnotice']);

    /*-- Dashboard --*/
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*-- Despositds & Withdrawtds --*/
    Route::get('/depositds', [DepositdsController::class, 'index'])->name('depositds')->middleware(['deposit']);
    Route::get('/withdrawds', [DepositdsController::class, 'index'])->name('withdrawds')->middleware('withdraw');
    Route::get('/getDataHistory/{username}/{jenis}', [DepositdsController::class, 'getDataHistory'])->middleware(['deposit', 'withdraw']);
    Route::get('/getbalance/{username}', [DepoWdController::class, 'getBalancePlayer'])->middleware(['deposit', 'withdraw']);
    Route::get('/datacountwdp', [DepoWdController::class, 'getCountDataDPW'])->middleware(['deposit', 'withdraw']);


    // /*-- Withdrawds --*/
    // Route::get('/withdrawds', [WithdrawdsController::class, 'index']);

    /*-- Manualds --*/
    Route::get('/manualds', [ManualdsController::class, 'index'])->name('manualds')->middleware('manual_transaction');

    /*-- Historyds --*/
    Route::get('/historycoinds', [HistorycoindsController::class, 'index'])->middleware('history_coin');
    Route::get('/historycoinds/export/', [HistorycoindsController::class, 'export']);

    /*-- Historytransaksids --*/
    Route::middleware('history_transaction')->group(function () {
        Route::get('/historytransaksids', [HistorytransaksidsController::class, 'index']);
        Route::get('/historytransaksids/transaksilama', [HistorytransaksidsController::class, 'transaksilama']);
        Route::get('/historytransaksids/export', [HistorytransaksidsController::class, 'export']);
    });
    /*-- Memberlistds --*/
    Route::middleware('member_list')->group(function () {
        Route::get('/memberlistds', [MemberlistdsController::class, 'index'])->name('memberlistds');
        Route::get('/memberlistds/edit/{id}', [MemberlistdsController::class, 'update']);
        Route::post('/memberlistds/updateuser/{id}', [MemberlistdsController::class, 'updateUser']);
        Route::post('/memberlistds/updatepassword/{id}', [MemberlistdsController::class, 'updatePassowrd']);
        Route::post('/memberlistds/updateinfomember/{id}', [MemberlistdsController::class, 'updateMember']);
        Route::get('/memberlistds/winloseyear/{username}', [MemberlistdsController::class, 'winloseyear']);
        Route::get('/memberlistds/winlosemonth/{username}/{year}', [MemberlistdsController::class, 'winlosemonth']);
        Route::get('/memberlistds/winloseday/{username}/{year}/{month}', [MemberlistdsController::class, 'winloseday']);
        Route::get('/memberlistds/history/{username}', [MemberlistdsController::class, 'historybank']);
        Route::get('/seamless/addmember', [MemberlistdsController::class, 'addmember']);
        Route::post('/memberlistds/store', [MemberlistdsController::class, 'store']);
        Route::get('/memberlistds/export', [MemberlistdsController::class, 'export']);
    });
    /*-- Historygameds --*/
    Route::middleware('history_game')->group(function () {
        Route::get('/historygameds', [HistorygamedsController::class, 'index']);
        Route::get('/historygameds/detail/{invoice}/{portfolio}', [HistorygamedsController::class, 'detail']);
        Route::get('/historygameds/export', [HistorygamedsController::class, 'export']);
    });
    /*-- Outstandingds --*/
    Route::get('/outstandingds/{username?}', [OutstandingdsController::class, 'index'])->middleware('member_outstanding');
    Route::get('/outstandingdsexport', [OutstandingdsController::class, 'export'])->middleware('member_outstanding');

    /*-- Reportds --*/
    Route::middleware('report')->group(function () {
        Route::get('/reportds', [ReportdsController::class, 'index']);
        Route::get('/reportds/winlosematch', [ReportdsController::class, 'winlosematch']);
        Route::get('/reportds/memberstatement', [ReportdsController::class, 'memberstatement']);
        Route::get('/reportds/export', [ReportdsController::class, 'export']);
    });
    /*-- Referralds --*/
    Route::middleware('referral')->group(function () {
        Route::get('/referralds', [ReferraldsController::class, 'index']);
        Route::get('/referralds/downline/{upline}/{jenis}/{total}/{total_referral}/{total_downline}', [ReferraldsController::class, 'downlinedetail']);
        Route::get('/referralds/bonusreferral', [ReferraldsController::class, 'bonusreferral']);
        Route::get('/referralds/export', [ReferraldsController::class, 'export']);
    });
    /*-- Bankds --*/
    Route::middleware('bank')->group(function () {
        Route::get('/bankds', [BankdsController::class, 'index'])->name('bankds');
        Route::post('/storemaster', [BankdsController::class, 'storemaster']);
        Route::post('/storegroupbank', [BankdsController::class, 'storegroupbank']);
        Route::post('/changestatusbank/{jenis?}', [BankdsController::class, 'changeStatusBank']);
        Route::get('/bankds/setbankmaster/{bank}', [BankdsController::class, 'setbankmaster']);
        Route::get('/bankds/addbankmaster', [BankdsController::class, 'addbankmaster']);
        Route::get('/bankds/setgroupbank/{namagroup}', [BankdsController::class, 'setgroupbank']);
        Route::post('/updategroupbank/{namagroup}', [BankdsController::class, 'updategroupbank']);
        Route::get('/bankds/addgroupbank', [BankdsController::class, 'addgroupbank']);
        Route::get('/bankds/setbank/{id}/{groupbank}', [BankdsController::class, 'setbank'])->name('bankds.setbank');
        Route::post('/bankds/updatelistbank/{jenis?}', [BankdsController::class, 'updatelistbank']);
        Route::post('/bankds/updatedetailbank', [BankdsController::class, 'updatedetailbank']);
        Route::delete('/bankds/deletelistbank/{id}/{groupbank}', [BankdsController::class, 'deletelistbank']);
        Route::get('/bankds/addbank', [BankdsController::class, 'addbank']);
        Route::post('/storebank', [BankdsController::class, 'storebank']);
        Route::post('/updatesetbank/{bank}', [BankdsController::class, 'updatesetbank']);
        Route::get('/bankds/listmaster', [BankdsController::class, 'listmaster'])->name('listmaster');
        Route::delete('/deletelistmaster/{id}', [BankdsController::class, 'deletelistmaster']);
        Route::get('/bankds/listgroup', [BankdsController::class, 'listgroup'])->name('listgroup');
        Route::post('/updatelistgroup/{jenis}', [BankdsController::class, 'updatelistgroup']);
        Route::delete('/deletelistgroup/{group}', [BankdsController::class, 'deletelistgroup'])->name('deletelistgroup');
        Route::get('/bankds/listbank/{group}/{groupwd}', [BankdsController::class, 'listbank']);
        Route::get('/getGroupBank/{bank}/{jenis}', [BankdsController::class, 'getGroupBank']);
        Route::get('/bankds/xdata', [BankdsController::class, 'xdata']);
    });

    Route::middleware('refeerral_bonus')->group(function () {
        Route::get('/bonussettingds', [BonussettingdsController::class, 'index'])->name('bonussettingds');
        Route::post('/bonussettingds/update', [BonussettingdsController::class, 'update']);
    });

    /*-- Memods --*/
    Route::middleware('memo')->group(function () {
        Route::get('/memods', [MemodsController::class, 'index']);
        Route::get('/memods/viewinbox', [MemodsController::class, 'viewinbox']);
        Route::get('/memods/readinbox', [MemodsController::class, 'readinbox']);
        Route::get('/memods/archiveinbox', [MemodsController::class, 'archiveinbox']);
        Route::get('/memods/delivered', [MemodsController::class, 'delivered']);
        Route::get('/memods/readdelivered/{id}', [MemodsController::class, 'readdelivered']);
        Route::delete('/deletememods/{id}', [MemodsController::class, 'delete']);
        Route::post('/storememo', [MemodsController::class, 'storememo']);
    });
    /*-- Agentds --*/
    Route::middleware('agent')->group(function () {
        Route::get('/agentds', [AgentdsController::class, 'index']);
        Route::get('/agentds/create', [AgentdsController::class, 'create']);
        Route::post('/agentds/store', [AgentdsController::class, 'store']);
        Route::get('/agentds/agentinfo', [AgentdsController::class, 'agentinfo']);
        Route::get('/agentds/agentupdate/{id}', [AgentdsController::class, 'agentupdate']);
        Route::post('/agentds/update', [AgentdsController::class, 'update']);
        Route::get('/agentds/access', [AgentdsController::class, 'access']);
        Route::get('/agentds/accessupdate/{id}', [AgentdsController::class, 'accessupdate']);
        Route::get('/agentds/accessadd', [AgentdsController::class, 'accessadd']);
        Route::post('/agentds/accessadd/store', [AgentdsController::class, 'store_access']);
        Route::delete('/agentds/accessdelete/{id}', [AgentdsController::class, 'destroy_access']);
        Route::post('/agentds/accessupdate/update', [AgentdsController::class, 'update_access']);
        Route::post('/agentds/storesetting', [AgentdsController::class, 'storesetting']);
    });
    /*-- Eventds --*/
    // Route::get('/eventds', [EventdsController::class, 'index']);

    /*-- Apksettingds --*/
    Route::middleware('apk_setting')->group(function () {
        Route::get('/apksettingds', [ApksettingdsController::class, 'index']);
        Route::get('/apksettingds/setting', [ApksettingdsController::class, 'apksetting']);
        Route::get('/apksettingds/event', [ApksettingdsController::class, 'apkevent']);
        Route::get('/apksettingds/event/add', [ApksettingdsController::class, 'apkeventadd']);
        Route::get('/apksettingds/event/edit', [ApksettingdsController::class, 'apkeventedit']);
    });
    /*-- Memotouserds --*/
    Route::middleware('memo')->group(function () {
        Route::get('/memotouserds', [MemotouserdsController::class, 'index']);
        Route::get('/memotouserds/delivered', [MemotouserdsController::class, 'delivered']);
        Route::get('/memotouserds/read', [MemotouserdsController::class, 'deliveredread']);
    });
    /*-- Notifikasids --*/

    Route::get('/notifikasids', [NotifikasidsController::class, 'index']);
    Route::get('/notifikasids/read', [NotifikasidsController::class, 'readinformasi']);

    /*-- Persentase Referral --*/
    Route::get('/persentaseds', [PersentasedsController::class, 'index']);




    /*-- MENU 2 --*/
    // Route::get('/menu2', [Menu2Controller::class, 'index']);
    // Route::get('/menu2/add', [Menu2Controller::class, 'create']);


    /*-- GET NOTIFICATION --*/
    Route::get('/getNotifikasi', [DepoWdController::class, 'getNotifikasi']);
    Route::get('/updateNotifikasi/{id}', [DepoWdController::class, 'updateNotifikasi']);

    /*-- Bonusds --*/
    Route::middleware('cashback_rollingan')->group(function () {
        Route::get('/bonuslistds', [BonusdsController::class, 'indexlist']);
        Route::get('/bonusds', [BonusdsController::class, 'index']);
        Route::get('/bonusdetailds/{listbonus_id}', [BonusdsController::class, 'indexdetail']);
        Route::post('/storebonusds/{bonus}/{gabungdari}/{gabunghingga}/{kecuali}', [BonusdsController::class, 'store']);
        Route::post('/cancelbonusds', [BonusdsController::class, 'cancel']);
        Route::get('/bonusds/export', [BonusdsController::class, 'export']);
    });

    /*-- Memotouserds --*/
    Route::get('/maintenance', [MaintenancedsController::class, 'maintenance']);
    Route::get('/test', [AgentdsController::class, 'userAndUserAccess']);
});
// });
