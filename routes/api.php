<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\WorkTripController;
use App\Http\Controllers\WorkTripNoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get(
    '/user', fn(Request $request) => $request->user())
    ->middleware('auth:sanctum');

Route::apiResource('/work-trips', WorkTripController::class);
Route::apiResource('/work-trip-notes', WorkTripNoteController::class);
Route::apiResource('/logs', LogController::class);
