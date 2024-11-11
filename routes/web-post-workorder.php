<?php

use App\Livewire\Information\Create;
use App\Livewire\Information\Edit;
use App\Livewire\Information\Index;
use App\Livewire\Information\Show;
use App\Livewire\TripPlans\Confirm;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/posts', \App\Livewire\Posts\Index::class)
        ->name('posts.index');

    // Route::get('/posts/create', \App\Livewire\Posts\Create::class)->name('posts.create');

    Route::get('/posts/show/{post}', \App\Livewire\Posts\Show::class)
        ->name('posts.show');

    // Route::get('/posts/update/{post}', \App\Livewire\Posts\Edit::class)->name('posts.edit');


    Route::get('/orders', \App\Livewire\Orders\Index::class)
        ->name('orders.index');

    Route::get('/orders/create', \App\Livewire\Orders\Create::class)
        ->name('orders.create');

    Route::get('/orders/show/{order}', \App\Livewire\Orders\Show::class)
        ->name('orders.show');

    Route::get('/orders/update/{order}', \App\Livewire\Orders\Edit::class)
        ->name('orders.edit');


    Route::get('/trip-plans', \App\Livewire\TripPlans\Index::class)
        ->name('trip-plans.index');

    Route::get('/trip-plans/confirm', Confirm::class)
        ->name('trip-plans.confirm');

    // Route::get('/trip-plans/create', \App\Livewire\TripPlans\Create::class)->name('trip-plans.create');

    Route::get('/trip-plans/show/{tripPlan}', \App\Livewire\TripPlans\Show::class)
        ->name('trip-plans.show');

    Route::get('/trip-plans/update/{tripPlan}', \App\Livewire\TripPlans\Edit::class)
        ->name('trip-plans.edit');


    Route::get('/information', Index::class)
        ->name('information.index');

    Route::get('/information/create', Create::class)
        ->name('information.create');

    Route::get('/information/show/{information}', Show::class)
        ->name('information.show');

    Route::get('/information/update/{information}', Edit::class)
        ->name('information.edit');


    /*Route::get('/image-urls', \App\Livewire\ImageUrls\Index::class)
        ->name('image-urls.index');

    Route::get('/image-urls/create', \App\Livewire\ImageUrls\Create::class)
        ->name('image-urls.create');

    Route::get('/image-urls/show/{imageUrl}', \App\Livewire\ImageUrls\Show::class)
        ->name('image-urls.show');

    Route::get('/image-urls/update/{imageUrl}', \App\Livewire\ImageUrls\Edit::class)
        ->name('image-urls.edit');


    Route::view('/workorders', 'livewire.workorders.index')
        ->name('workorders');

    // Route::view('/workorders/create', 'livewire.workorders.create')->name('workorders.create');

    Route::get('/workorders/create', \App\Livewire\Workorders\Create::class)
        ->name('workorders.create');

    Route::get('/workorders/show/{post}', \App\Livewire\Workorders\Show::class)
        ->name('workorders.show');*/

    //Route::view('/workorders/show', 'livewire.workorders.show')->name('workorders.show');
});
