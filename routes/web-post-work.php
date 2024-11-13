<?php

use App\Livewire\Information\Create;
use App\Livewire\Information\Edit;
use App\Livewire\Information\Index;
use App\Livewire\Information\Show;
use App\Livewire\PlanTrips\Confirm;
use App\Livewire\Workorders\WorkRequest;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/posts', \App\Livewire\Posts\Index::class)
        ->name('posts.index');

    Route::get('/posts/create', \App\Livewire\Posts\Create::class)
        ->name('posts.create');

    Route::get('/posts/show/{post}', \App\Livewire\Posts\Show::class)
        ->name('posts.show');

    // Route::get('/posts/update/{post}', \App\Livewire\Posts\Edit::class)->name('posts.edit');

    Route::get('/plan-orders', \App\Livewire\PlanOrders\Index::class)
        ->name('plan-orders.index');

    Route::get('/plan-orders/create', \App\Livewire\PlanOrders\Create::class)
        ->name('plan-orders.create');

    Route::get('/plan-orders/show/{order}', \App\Livewire\PlanOrders\Show::class)
        ->name('plan-orders.show');

    Route::get('/plan-orders/update/{order}', \App\Livewire\PlanOrders\Edit::class)
        ->name('plan-orders.edit');


    Route::get('/plan-trips', \App\Livewire\PlanTrips\Index::class)
        ->name('plan-trips.index');

    Route::get('/plan-trips/confirm', Confirm::class)
        ->name('plan-trips.confirm');

    // Route::get('/plan-trips/create', \App\Livewire\TripPlans\Create::class)->name('plan-trips.create');

    Route::get('/plan-trips/show/{tripPlan}', \App\Livewire\PlanTrips\Show::class)
        ->name('plan-trips.show');

    Route::get('/plan-trips/update/{tripPlan}', \App\Livewire\PlanTrips\Edit::class)
        ->name('plan-trips.edit');


    Route::get('/information', Index::class)
        ->name('information.index');

    Route::get('/information/create', Create::class)
        ->name('information.create');

    Route::get('/information/show/{information}', Show::class)
        ->name('information.show');

    Route::get('/information/update/{information}', Edit::class)
        ->name('information.edit');


    // Route::get('/image-urls', \App\Livewire\ImageUrls\Index::class)->name('image-urls.index');

    Route::get('/image-urls/create', \App\Livewire\ImageUrls\Create::class)
        ->name('image-urls.create');

    Route::get('/image-urls/show/{imageUrl}', \App\Livewire\ImageUrls\Show::class)
        ->name('image-urls.show');

    Route::get('/image-urls/update/{imageUrl}', \App\Livewire\ImageUrls\Edit::class)
        ->name('image-urls.edit');


    //Route::view('/workorders', 'livewire.workorders.index')->name('workorders');

    Route::get('/workorders', \App\Livewire\Workorders\Index::class)
        ->name('workorders.index');

    // Route::view('/workorders/create', 'livewire.workorders.create')->name('workorders.create');

    Route::get('/workorders/create', \App\Livewire\Workorders\Create::class)
        ->name('workorders.create');

    Route::get('/workorders/show/{post}', \App\Livewire\Workorders\Show::class)
        ->name('workorders.show');

    //Route::view('/workorders/show', 'livewire.workorders.show')->name('workorders.show');

    Route::get('/load-request/{idsWellName?}', WorkRequest::class)
        ->name('work-request')
        ->can(UserPolicy::IS_PHR_ROLE);
});
