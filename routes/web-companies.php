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


    Route::get('/teams', \App\Livewire\Teams\Index::class)
        ->name('teams.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/teams/create', \App\Livewire\Teams\Create::class)
        ->name('teams.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/teams/show/{department}', \App\Livewire\Teams\Show::class)
        ->name('teams.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/teams/update/{department}', \App\Livewire\Teams\Edit::class)
        ->name('teams.edit')
        ->can(UserPolicy::IS_DEV_ROLE);


    Route::get('/man-power', \App\Livewire\ManPower\Index::class)
        ->name('man-power.index')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/man-power/create', \App\Livewire\ManPower\Create::class)
        ->name('man-power.create')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/man-power/show/{crew}', \App\Livewire\ManPower\Show::class)
        ->name('man-power.show')
        ->can(UserPolicy::IS_DEV_ROLE);

    Route::get('/man-power/update/{crew}', \App\Livewire\ManPower\Edit::class)
        ->name('man-power.edit')
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


    Route::get('/companies', \App\Livewire\Companies\Index::class)
        ->name('companies.index')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/companies/create', \App\Livewire\Companies\Create::class)
        ->name('companies.create')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/companies/show/{operator}', \App\Livewire\Companies\Show::class)
        ->name('companies.show')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/companies/update/{operator}', \App\Livewire\Companies\Edit::class)
        ->name('companies.edit')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);

});
