<?php

use App\Livewire\PostWoInfo\Create;
use App\Livewire\PostWoInfo\Index;
use App\Livewire\PostWoInfo\Show;
use App\Livewire\PostWoPlanTrip\Confirm;
use App\Models\PostWo;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Route::get('/image-urls', \App\Livewire\ImageUrls\Index::class)->name('image-urls.index');

    Route::get('/image-urls/create', \App\Livewire\ImageUrls\Create::class)
        ->name('image-urls.create');

    Route::get('/image-urls/show/{imageUrl}', \App\Livewire\ImageUrls\Show::class)
        ->name('image-urls.show');

    Route::get('/image-urls/update/{imageUrl}', \App\Livewire\ImageUrls\Edit::class)
        ->name('image-urls.edit');


    Route::get('/plan-orders', \App\Livewire\PostWoPlanOrder\Index::class)
        ->name('plan-orders.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-orders/create', \App\Livewire\PostWoPlanOrder\Create::class)
        ->name('plan-orders.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-orders/show/{order}', \App\Livewire\PostWoPlanOrder\Show::class)
        ->name('plan-orders.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    /*Route::get('/plan-orders/update/{order}', \App\Livewire\PostWoPlanOrder\Edit::class)
        ->name('plan-orders.edit');*/


    Route::get('/plan-trips', \App\Livewire\PostWoPlanTrip\Index::class)
        ->name('plan-trips.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-trips/confirm', Confirm::class)
        ->name('plan-trips.confirm')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    // Route::get('/plan-trips/create', \App\Livewire\TripPlans\Create::class)->name('plan-trips.create');

    Route::get('/plan-trips/show/{tripPlan}', \App\Livewire\PostWoPlanTrip\Show::class)
        ->name('plan-trips.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-trips/update/{tripPlan}', \App\Livewire\PostWoPlanTrip\Edit::class)
        ->name('plan-trips.edit')
        ->can(UserPolicy::IS_USER_IS_PLANNER);


    Route::get('/information', Index::class)
        ->name('information.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/information/create', Create::class)
        ->name('information.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/information/show/{information}', Show::class)
        ->name('information.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    /*Route::get('/information/update/{information}', Edit::class)
        ->name('information.edit');*/

    Route::get('/'. PostWo::ROUTE_NAME.'/blueprint/{post}', \App\Livewire\PostWo\Blueprint::class)
        ->name(PostWo::ROUTE_NAME.'.blueprint')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/'. PostWo::ROUTE_NAME, \App\Livewire\PostWo\Index::class)
        ->name(PostWo::ROUTE_NAME.'.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/'. PostWo::ROUTE_NAME.'/create', \App\Livewire\PostWo\Create::class)
        ->name(PostWo::ROUTE_NAME.'.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/'. PostWo::ROUTE_NAME.'/show/{post}',\App\Livewire\PostWo\Show::class)
        ->name(PostWo::ROUTE_NAME.'.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get(
        '/'. PostWo::ROUTE_NAME.'/request/index',\App\Livewire\PostWo\Request\Index::class)
        ->name(PostWo::ROUTE_NAME.'.request.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get(
        '/'. PostWo::ROUTE_NAME.'/request/create/{post}', \App\Livewire\PostWo\Request\Create::class)
        ->name(PostWo::ROUTE_NAME.'.request.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/load-request/{idsWellName?}', Index::class)
        ->name('work-request')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);
});
