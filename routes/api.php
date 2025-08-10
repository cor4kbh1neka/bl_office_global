<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/historylog', [ApiController::class, 'historyLog']);
Route::post('/get-recommend-matches', [ApiController::class, 'getRecomMatch']);
Route::post('/cekuserreferral', [ApiController::class, 'cekuserreferral']);
Route::post('/getHistoryDw', [ApiController::class, 'getHistoryDepoWd']);
Route::post('/checkLastTransaction', [ApiController::class, 'getLastStatusTransaction']);
Route::post('/checkBalance', [ApiController::class, 'getBalance']);
Route::post('/getHistoryGame', [ApiController::class, 'getHistoryGame']);
Route::post('/getHistoryGameById', [ApiController::class, 'getHistoryGameById']);
Route::post('/getDataOutstanding', [ApiController::class, 'getDataOutstanding']);
Route::post('/getdatalogmember', [ApiController::class, 'getDataLogMember']);
Route::get('/getdatadashboard', [ApiController::class, 'getDataDashboard']);
Route::post('/getmaintenance', [ApiController::class, 'getMaintenance']);
Route::get('/olddata/historycoins', [ApiController::class, 'old_historycoin']);
Route::get('/olddata/historytransaksi', [ApiController::class, 'old_history_transaksi']);
