<?php

use App\Livewire\PostFacThreshold\Import;
use App\Livewire\PostFacReport\Create;
use App\Livewire\PostFacReport\Edit;
use App\Livewire\PostFacReport\Index;
use App\Livewire\PostFacReport\Show;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/post-fac-report', Index::class)
        ->name('post-fac-report.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-report/create', Create::class)
        ->name('post-fac-report.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-report/summary', Create::class)
        ->name('post-fac-report.summary')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-report/create/{dateParam}', Create::class)
        ->name('post-fac-report.create-by')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-report/show/{workTrip}', Show::class)
        ->name('post-fac-report.show')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-report/update/{workTrip}', Edit::class)
        ->name('post-fac-report.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-report/report', \App\Livewire\PostFacReport\Report\Index::class)
        ->name('post-fac-report.report')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::view('/post-fac-report/operational-report', 'livewire.post-fac-report.report.operational')
        ->name('post-fac-report.operational-report')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac-report/export/{date}', [
        \App\Http\Controllers\PostFacReportController::class, 'export'])
        ->name('post-fac-report.export')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


    Route::get('/post-fac-threshold', \App\Livewire\PostFacThreshold\Index::class)
        ->name('post-fac-threshold.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac-threshold/create', \App\Livewire\PostFacThreshold\Create::class)
        ->name('post-fac-threshold.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac-threshold/create/{dateParam}', \App\Livewire\PostFacThreshold\Create::class)
        ->name('post-fac-threshold.create-by')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac-threshold/show/{workTripInfo}', \App\Livewire\PostFacThreshold\Show::class)
        ->name('post-fac-threshold.show')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac-threshold/update/{workTripInfo}', \App\Livewire\PostFacThreshold\Edit::class)
        ->name('post-fac-threshold.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


    Route::get('/post-fac-report/requests', \App\Livewire\PostFacReport\Request\Index::class)
        ->name('post-fac-report.requests.index')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac-report/requests/show/{post}', \App\Livewire\PostFacReport\Request\Show::class)
        ->name('post-fac-report.requests.show')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


    Route::get('/post-fac-threshold/import', Import::class)
        ->name('post-fac-threshold.import')
        ->can(\App\Policies\UserPolicy::IS_DEV_ROLE);

    Route::get('/post-fac-report/import', \App\Livewire\PostFacReport\Import::class)
        ->name('post-fac-report.import')
        ->can(\App\Policies\UserPolicy::IS_DEV_ROLE);


    Route::get('/post-fac', \App\Livewire\PostFac\Index::class)
        ->name('post-fac.index');

    Route::get('/post-fac/create', \App\Livewire\PostFac\Create::class)
        ->name('post-fac.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW_N_DEV);

    Route::get('/post-fac/show/{workTripDetail}', \App\Livewire\PostFac\Show::class)
        ->name('post-fac.show');

    Route::get('/post-fac/update/{workTripDetail}', \App\Livewire\PostFac\Edit::class)
        ->name('post-fac.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW_N_DEV);

    Route::get('/post-fac/report', \App\Livewire\PostFac\Report\Index::class)
        ->name('post-fac.report')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);

    Route::get('/post-fac/export/{type}/{date}', [
        \App\Http\Controllers\PostFacReportController::class, 'export'])
        ->name('post-fac.export')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_FAC_REP);


    Route::get('/post-fac-in', \App\Livewire\PostFacIn\Index::class)
        ->name('post-fac-in.index');

    Route::get('/post-fac-in/create', \App\Livewire\PostFacIn\Create::class)
        ->name('post-fac-in.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-in/show/{workTripInDetail}', \App\Livewire\PostFacIn\Show::class)
        ->name('post-fac-in.show');

    Route::get('/post-fac-in/update/{workTripInDetail}', \App\Livewire\PostFacIn\Edit::class)
        ->name('post-fac-in.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW);

    Route::get('/post-fac-prod', \App\Livewire\PostFacOut\Index::class)
        ->name('post-fac-prod.index');

    Route::get('/post-fac-out', \App\Livewire\PostFacOut\Index::class)
        ->name('post-fac-out.index'); //IS_USER_IS_FAC_OPE_N_DEV

    Route::get('/post-fac-out/create', \App\Livewire\PostFacOut\Create::class)
        ->name('post-fac-out.create')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_PM_COW);

    Route::get('/post-fac-out/show/{workTripOutDetail}', \App\Livewire\PostFacOut\Show::class)
        ->name('post-fac-out.show');

    Route::get('/post-fac-out/update/{workTripOutDetail}', \App\Livewire\PostFacOut\Edit::class)
        ->name('post-fac-out.edit')
        ->can(\App\Policies\UserPolicy::IS_USER_IS_VT_CREW);

});
