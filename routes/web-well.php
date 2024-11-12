<?php

use App\Livewire\WellMasters\Create;
use App\Livewire\WellMasters\Edit;
use App\Livewire\WellMasters\Import;
use App\Livewire\WellMasters\Index;
use App\Livewire\WellMasters\Show;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/well-masters', Index::class)
        ->name('well-masters.index');

    Route::get('/well-masters/create', Create::class)
        ->name('well-masters.create');

    Route::get('/well-masters/show/{wellMaster}', Show::class)
        ->name('well-masters.show');

    Route::get('/well-masters/update/{wellMaster}', Edit::class)
        ->name('well-masters.edit');

    Route::get('/well-masters/import', Import::class)
        ->name('well-masters.import');
});
