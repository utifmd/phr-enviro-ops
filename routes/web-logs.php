<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/logs', \App\Livewire\Logs\Index::class)
        ->name('logs.index');

    Route::get('/logs/create', \App\Livewire\Logs\Create::class)
        ->name('logs.create')
        ->can(\App\Policies\UserPolicy::IS_DEV_ROLE);

    Route::get('/logs/show/{log}', \App\Livewire\Logs\Show::class)
        ->name('logs.show');

    Route::get('/logs/update/{log}', \App\Livewire\Logs\Edit::class)
        ->name('logs.edit')
        ->can(\App\Policies\UserPolicy::IS_DEV_ROLE);
});
