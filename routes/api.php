<?php

use App\Http\Controllers\WorkTripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get(
    '/user', fn(Request $request) => $request->user())
    ->middleware('auth:sanctum');

Route::apiResource('/work-trips', WorkTripController::class);
