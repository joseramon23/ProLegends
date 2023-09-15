<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeanController;
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
    Route::get('player/{id}', 'show');
    Route::post('player', 'store');
    Route::put('player/{id}', 'update');
    Route::delete('player/{id}', 'destroy');
});

Route::controller(TeamController::class)->group(function() {
    Route::get('teams', 'index');
    Route::get('team/{id}', 'show');
    Route::post('team', 'store');
    Route::put('team/{id}', 'update');
    Route::delete('team/{id}', 'destroy');
});