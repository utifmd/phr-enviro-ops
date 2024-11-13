<?php

use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/departments', \App\Livewire\Departments\Index::class)
        ->name('departments.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/departments/create', \App\Livewire\Departments\Create::class)
        ->name('departments.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/departments/show/{department}', \App\Livewire\Departments\Show::class)
        ->name('departments.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/departments/update/{department}', \App\Livewire\Departments\Edit::class)
        ->name('departments.edit')
        ->can(UserPolicy::IS_DEV_ROLE);


    Route::get('/vehicles', \App\Livewire\Vehicles\Index::class)
        ->name('vehicles.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/vehicles/create', \App\Livewire\Vehicles\Create::class)
        ->name('vehicles.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/vehicles/show/{vehicle}', \App\Livewire\Vehicles\Show::class)
        ->name('vehicles.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/vehicles/update/{vehicle}', \App\Livewire\Vehicles\Edit::class)
        ->name('vehicles.edit')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/operators', \App\Livewire\Operators\Index::class)
        ->name('operators.index')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/operators/create', \App\Livewire\Operators\Create::class)
        ->name('operators.create')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/operators/show/{operator}', \App\Livewire\Operators\Show::class)
        ->name('operators.show')
        ->can(UserPolicy::IS_PHR_ROLE);

    Route::get('/operators/update/{operator}', \App\Livewire\Operators\Edit::class)
        ->name('operators.edit')
        ->can(UserPolicy::IS_PHR_ROLE);

});
