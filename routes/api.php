<?php

use App\Http\Controllers\DailyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MechController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// MECH ROUTES
Route::apiResource('mechs', MechController::class);

// DAILY ROUTES
Route::apiResource('dailies', DailyController::class);