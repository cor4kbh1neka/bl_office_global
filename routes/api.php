<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ApiBolaController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\DepoWdController;
use App\Http\Controllers\ReferraldsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|3
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!s
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/Bonus', [ApiBolaController::class, 'Bonus']);
// Route::post('/Cancel', [ApiBolaController::class, 'Cancel']);
// Route::post('/Deduct', [ApiBolaController::class, 'Deduct']);
// Route::post('/GetBalance', [ApiBolaController::class, 'GetBalance']);
// Route::post('/Rollback', [ApiBolaController::class, 'Rollback']);
// Route::post('/Settle', [ApiBolaController::class, 'Settle']);
// Route::post('/GetBetStatus', [ApiBolaController::class, 'GetBetStatus']);
// Route::post('/ReturnStake', [ApiBolaController::class, 'ReturnStake']);

// Route::get('/gettransactions', [ApiController::class, 'getTransactions']);
// Route::get('/getTransactionsAll', [ApiController::class, 'getTransactionAll']);
// Route::get('/getTransactionStatus', [ApiController::class, 'getTransactionStatus']);
// Route::get('/getTransactionSaldo', [ApiController::class, 'getTransactionSaldo']);
// Route::delete('/deleteTransactions', [ApiController::class, 'deleteTransactions']);



// Route::middleware(['cors'])->group(function () {
// Route::post('/login', [ApiController::class, 'login']);
Route::post('/historylog', [ApiController::class, 'historyLog']);
// Route::post('/register', [ApiController::class, 'register']);
Route::post('/get-recommend-matches', [ApiController::class, 'getRecomMatch']);
Route::post('/cekuserreferral', [ApiController::class, 'cekuserreferral']);
// Route::post('/deposit', [ApiController::class, 'deposit']);
// Route::post('/withdrawal', [ApiController::class, 'withdrawal']);
Route::post('/getHistoryDw', [ApiController::class, 'getHistoryDepoWd']);
Route::post('/checkLastTransaction', [ApiController::class, 'getLastStatusTransaction']);
Route::post('/checkBalance', [ApiController::class, 'getBalance']);
Route::post('/getHistoryGame', [ApiController::class, 'getHistoryGame']);
Route::post('/getHistoryGameById', [ApiController::class, 'getHistoryGameById']);
Route::post('/getDataOutstanding', [ApiController::class, 'getDataOutstanding']);
Route::post('/getdatalogmember', [ApiController::class, 'getDataLogMember']);


Route::get('/getdatadashboard', [ApiController::class, 'getDataDashboard']);

Route::post('/getmaintenance', [ApiController::class, 'getMaintenance']);

// Route::get('/olddata/historycoin', [ApiController::class, 'old_historycoin']);
// Route::get('/olddata/historytransaksi', [ApiController::class, 'old_history_transaksi']);
// Route::get('/olddata/refaktif', [ApiController::class, 'old_ref_aktif']);
// Route::get('/olddata/refdepo', [ApiController::class, 'old_ref_depo']);
// Route::get('/olddata/winlossbet', [ApiController::class, 'old_winlossbet']);
// Route::get('/olddata/winloss', [ApiController::class, 'old_winloss']);

/* Cek Key */
// Route::get('/yindiktiitinyiyingmiitinyisiyi', [ApiController::class, 'redis_key']);
// Route::post('/redis/Sl3beuw.Bu_lu_kukuk/flushdb', [ApiController::class, 'flushdb']);
// Route::post('/redis/del/{key}', [ApiController::class, 'deleteKey']);
// Route::post('/redis/scan/{substring}', [ApiController::class, 'deleteKeysWithSubstring']);
// });

//composer require predis/predis
 

// /* Referral */
// Route::post('/getDataReferral', [ApiController::class, 'getDataReferral']);



// Route::post('/getApiBro', [ApiController::class, 'getApiBro']);
// Route::get('/getDataHistory', [ApiController::class, 'getDataHistoryAll']);
// Route::post('/gethistory', [ApiController::class, 'getDataHistory']);
// Route::get('/deleteHistoryTranskasi', [ApiController::class, 'deleteHistoryTranskasi']);



// Route::get('/getDataMember', [ApiController::class, 'getDataMember']);
// Route::get('/getDataDepoWd', [DepoWdController::class, 'getDataDepoWd']);
// Route::get('/getDataXdpwd', [DepoWdController::class, 'getDataXdpwd']);



// /*gapenting*/
// Route::get('/getwinlossbet', [ApiController::class, 'getWinLossBet']);

// /* Get Data Log Bank */
// Route::get('/getDataLogBank', [ApiController::class, 'getDataLogBank']);
