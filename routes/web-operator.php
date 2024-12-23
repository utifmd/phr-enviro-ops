<?php

use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/activities', \App\Livewire\Activities\Index::class)
        ->name('activities.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/activities/create', \App\Livewire\Activities\Create::class)
        ->name('activities.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/activities/show/{activity}', \App\Livewire\Activities\Show::class)
        ->name('activities.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/activities/update/{activity}', \App\Livewire\Activities\Edit::class)
        ->name('activities.edit')
        ->can(UserPolicy::IS_DEV_ROLE);


    Route::get('/areas', \App\Livewire\Areas\Index::class)
        ->name('areas.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/areas/create', \App\Livewire\Areas\Create::class)
        ->name('areas.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/areas/show/{area}', \App\Livewire\Areas\Show::class)
        ->name('areas.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/areas/update/{area}', \App\Livewire\Areas\Edit::class)
        ->name('areas.edit')
        ->can(UserPolicy::IS_DEV_ROLE);


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


    Route::get('/crews', \App\Livewire\Crews\Index::class)
        ->name('crews.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/crews/create', \App\Livewire\Crews\Create::class)
        ->name('crews.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/crews/show/{crew}', \App\Livewire\Crews\Show::class)
        ->name('crews.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/crews/update/{crew}', \App\Livewire\Crews\Edit::class)
        ->name('crews.edit')
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
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/operators/create', \App\Livewire\Operators\Create::class)
        ->name('operators.create')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/operators/show/{operator}', \App\Livewire\Operators\Show::class)
        ->name('operators.show')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/operators/update/{operator}', \App\Livewire\Operators\Edit::class)
        ->name('operators.edit')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

});
