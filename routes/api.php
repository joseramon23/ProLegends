<?php

use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TitlesController;
use App\Http\Controllers\TransferController;
use App\Models\Players_titles;
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

Route::controller(LeagueController::class)->group(function() {
    Route::get('leagues', 'index');
    Route::get('league/{id}', 'show');
    Route::post('league', 'store');
    Route::put('league/{id}', 'update');
    Route::delete('league/{id}', 'delete');
});

Route::controller(TransferController::class)->group(function() {
    Route::get('transfers', 'index');
    Route::get('transfers/{id}', 'show');
    Route::post('transfers', 'store');
    Route::put('transfers/{id}', 'update');
    Route::delete('transfers/{id}', 'delete');
});

Route::controller(TitlesController::class)->group(function () {
    Route::get('titles', 'index');
    Route::get('titles/{id}', 'show');
    Route::post('titles', 'store');
    Route::put('titles/{id}', 'update');
    Route::delete('titles/{id}', 'delete');
});