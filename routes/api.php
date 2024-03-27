<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\malesNgodingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('response_fnc',[malesNgodingController::class,'tes_fnc']);
Route::get('import/pasien',[ImportController::class,'pasien']);
Route::get('import/obat',[ImportController::class,'obat']); 
Route::get('import/groupsatuan',[ImportController::class,'group_satuan']); 
Route::get('import/stok',[ImportController::class,'stok']); 


