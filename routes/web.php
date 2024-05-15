<?php

use App\Http\Controllers\malesNgodingController;
use App\Http\Controllers\UpdateTarifController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('males_ngoding/{table}',[malesNgodingController::class,'males_ngoding']);

Route::get('update_tarif_kelas1_semua',[UpdateTarifController::class,'update_tarif_jadi_kelas_1']);

Route::get('males_ngoding_fnc', function () {
    return view('function');
});

