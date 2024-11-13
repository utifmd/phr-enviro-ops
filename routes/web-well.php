<?php

use App\Livewire\Posts\WorkRequest;
use App\Livewire\WellMasters\Create;
use App\Livewire\WellMasters\Edit;
use App\Livewire\WellMasters\Import;
use App\Livewire\WellMasters\Index;
use App\Livewire\WellMasters\Show;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/well-masters', Index::class)
        ->name('well-masters.index')
        ->can(UserPolicy::IS_NOT_GUEST_ROLE);

    Route::get('/well-masters/create', Create::class)
        ->name('well-masters.create')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/well-masters/show/{wellMaster}', Show::class)
        ->name('well-masters.show')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/well-masters/update/{wellMaster}', Edit::class)
        ->name('well-masters.edit')
        ->can(UserPolicy::IS_PHR_ROLE);

    /*Route::get('/export-to-excel/{datetime}', [DashboardExportController::class, 'export'])
        ->name('dashboard.export')
        ->can(UserPolicy::IS_PHR_ROLE);*/
});
