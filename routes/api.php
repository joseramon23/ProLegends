<?php

use App\Http\Controllers\PlayerController;
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

Route::controller(PlayerController::class)->group(function() {
    Route::get('players', 'index');
    Route::post('players', 'store');
    Route::put('player/{id}', 'update');
    Route::delete('player/{id}', 'destroy');
});