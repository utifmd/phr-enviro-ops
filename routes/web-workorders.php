<?php

use App\Livewire\Information\Create;
use App\Livewire\Information\Index;
use App\Livewire\Information\Show;
use App\Livewire\PlanTrips\Confirm;
use App\Models\WorkOrder;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/plan-orders', \App\Livewire\PlanOrders\Index::class)
        ->name('plan-orders.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-orders/create', \App\Livewire\PlanOrders\Create::class)
        ->name('plan-orders.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-orders/show/{order}', \App\Livewire\PlanOrders\Show::class)
        ->name('plan-orders.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    /*Route::get('/plan-orders/update/{order}', \App\Livewire\PlanOrders\Edit::class)
        ->name('plan-orders.edit');*/


    Route::get('/plan-trips', \App\Livewire\PlanTrips\Index::class)
        ->name('plan-trips.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-trips/confirm', Confirm::class)
        ->name('plan-trips.confirm')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    // Route::get('/plan-trips/create', \App\Livewire\TripPlans\Create::class)->name('plan-trips.create');

    Route::get('/plan-trips/show/{tripPlan}', \App\Livewire\PlanTrips\Show::class)
        ->name('plan-trips.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/plan-trips/update/{tripPlan}', \App\Livewire\PlanTrips\Edit::class)
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


    // Route::get('/image-urls', \App\Livewire\ImageUrls\Index::class)->name('image-urls.index');

    Route::get('/image-urls/create', \App\Livewire\ImageUrls\Create::class)
        ->name('image-urls.create');

    Route::get('/image-urls/show/{imageUrl}', \App\Livewire\ImageUrls\Show::class)
        ->name('image-urls.show');

    Route::get('/image-urls/update/{imageUrl}', \App\Livewire\ImageUrls\Edit::class)
        ->name('image-urls.edit');


    Route::get('/'. WorkOrder::ROUTE_NAME.'/blueprint/{post}', \App\Livewire\Workorders\Blueprint::class)
        ->name(WorkOrder::ROUTE_NAME.'.blueprint')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/'. WorkOrder::ROUTE_NAME, \App\Livewire\Workorders\Index::class)
        ->name(WorkOrder::ROUTE_NAME.'.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/'. WorkOrder::ROUTE_NAME.'/create', \App\Livewire\Workorders\Create::class)
        ->name(WorkOrder::ROUTE_NAME.'.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/'. WorkOrder::ROUTE_NAME.'/show/{post}',\App\Livewire\Workorders\Show::class)
        ->name(WorkOrder::ROUTE_NAME.'.show')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get(
        '/'. WorkOrder::ROUTE_NAME.'/request/index',\App\Livewire\Workorders\Request\Index::class)
        ->name(WorkOrder::ROUTE_NAME.'.request.index')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get(
        '/'. WorkOrder::ROUTE_NAME.'/request/create/{post}', \App\Livewire\Workorders\Request\Create::class)
        ->name(WorkOrder::ROUTE_NAME.'.request.create')
        ->can(UserPolicy::IS_USER_IS_PLANNER);

    Route::get('/load-request/{idsWellName?}', Index::class)
        ->name('work-request')
        ->can(UserPolicy::IS_USER_IS_FAC_REP);
});
