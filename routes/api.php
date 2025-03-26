<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\PostFacController;
use App\Http\Controllers\PostRemarksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get(
    '/user', fn(Request $request) => $request->user())
    ->middleware('auth:sanctum');

Route::apiResource('/post-fac', PostFacController::class);
Route::apiResource('/post-remarks', PostRemarksController::class);
Route::apiResource('/logs', LogController::class);
