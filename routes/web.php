<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [\App\Http\Controllers\CommissionCalculatorController::class, 'index'])->name('commission-calculator.index');
Route::post('/calculate', [\App\Http\Controllers\CommissionCalculatorController::class, 'calculate'])->name('commission-calculator.calculate');
