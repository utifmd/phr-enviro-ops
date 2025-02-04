<?php

use App\Livewire\WorkTripInfos\Import;
use App\Livewire\WorkTrips\Create;
use App\Livewire\WorkTrips\Edit;
use App\Livewire\WorkTrips\Index;
use App\Livewire\WorkTrips\Show;
use Illuminate\Support\Facades\Route;

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

    Route::get('/work-trips/report', \App\Livewire\WorkTrips\Report\Index::class)
        ->name('work-trips.report')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trip/export/{date}', [
        \App\Http\Controllers\WorkTripDetailExportController::class, 'export'])
        ->name('work-trip.export')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


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


    Route::get('/work-trip-infos/import', Import::class)
        ->name('work-trip-infos.import')
        ->can(\App\Policies\UserPolicy::IS_DEV_ROLE);

    Route::get('/work-trips/import', \App\Livewire\WorkTrips\Import::class)
        ->name('work-trips.import')
        ->can(\App\Policies\UserPolicy::IS_DEV_ROLE);


    Route::get('/work-trip-details', \App\Livewire\WorkTripDetails\Index::class)
        ->name('work-trip-details.index');

    Route::get('/work-trip-details/create', \App\Livewire\WorkTripDetails\Create::class)
        ->name('work-trip-details.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW_N_DEV);

    Route::get('/work-trip-details/show/{workTripDetail}', \App\Livewire\WorkTripDetails\Show::class)
        ->name('work-trip-details.show');

    Route::get('/work-trip-details/update/{workTripDetail}', \App\Livewire\WorkTripDetails\Edit::class)
        ->name('work-trip-details.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW_N_DEV);

    Route::get('/work-trip-details/report', \App\Livewire\WorkTripDetails\Report\Index::class)
        ->name('work-trip-details.report')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/work-trip-details/export/{type}/{date}', [
        \App\Http\Controllers\WorkTripDetailExportController::class, 'export'])
        ->name('work-trip-details.export')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


    Route::get('/work-trip-in-details', \App\Livewire\WorkTripInDetails\Index::class)
        ->name('work-trip-in-details.index');

    Route::get('/work-trip-in-details/create', \App\Livewire\WorkTripInDetails\Create::class)
        ->name('work-trip-in-details.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW);

    Route::get('/work-trip-in-details/show/{workTripInDetail}', \App\Livewire\WorkTripInDetails\Show::class)
        ->name('work-trip-in-details.show');

    Route::get('/work-trip-in-details/update/{workTripInDetail}', \App\Livewire\WorkTripInDetails\Edit::class)
        ->name('work-trip-in-details.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW);

    Route::get('/work-trip-out-details', \App\Livewire\WorkTripOutDetails\Index::class)
        ->name('work-trip-out-details.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW); //IS_USER_IS_FAC_OPE_N_DEV

    Route::get('/work-trip-out-details/create', \App\Livewire\WorkTripOutDetails\Create::class)
        ->name('work-trip-out-details.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW);

    Route::get('/work-trip-out-details/show/{workTripOutDetail}', \App\Livewire\WorkTripOutDetails\Show::class)
        ->name('work-trip-out-details.show');

    Route::get('/work-trip-out-details/update/{workTripOutDetail}', \App\Livewire\WorkTripOutDetails\Edit::class)
        ->name('work-trip-out-details.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW);

});
