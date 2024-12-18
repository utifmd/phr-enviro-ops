<?php

use App\Livewire\WorkTrips\Create;
use App\Livewire\WorkTrips\Edit;
use App\Livewire\WorkTrips\Index;
use App\Livewire\WorkTrips\Show;
use Illuminate\Support\Facades\Route;
/*
 * 1. worktrip set must in this day, or
 * 2. set worktrip yesterday but also date for post and notes is correct
 * */
Route::middleware('auth')->group(function () {
    Route::get('/work-trips', Index::class)
        ->name('work-trips.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/work-trips/create', Create::class)
        ->name('work-trips.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/work-trips/create/{dateParam}', Create::class)
        ->name('work-trips.create-by')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/work-trips/show/{workTrip}', Show::class)
        ->name('work-trips.show')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/work-trips/update/{workTrip}', Edit::class)
        ->name('work-trips.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/work-trip-infos', \App\Livewire\WorkTripInfos\Index::class)
        ->name('work-trip-infos.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trip-infos/create', \App\Livewire\WorkTripInfos\Create::class)
        ->name('work-trip-infos.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trip-infos/create/{dateParam}', \App\Livewire\WorkTripInfos\Create::class)
        ->name('work-trip-infos.create-by')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trip-infos/show/{workTripInfo}', \App\Livewire\WorkTripInfos\Show::class)
        ->name('work-trip-infos.show')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trip-infos/update/{workTripInfo}', \App\Livewire\WorkTripInfos\Edit::class)
        ->name('work-trip-infos.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


    Route::get('/work-trips/requests', \App\Livewire\WorkTrips\Request\Index::class)
        ->name('work-trips.requests.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trips/requests/show/{post}', \App\Livewire\WorkTrips\Request\Show::class)
        ->name('work-trips.requests.show')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

});
