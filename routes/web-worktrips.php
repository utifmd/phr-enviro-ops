<?php

use App\Livewire\WorkTrips\Create;
use App\Livewire\WorkTrips\Edit;
use App\Livewire\WorkTrips\Index;
use App\Livewire\WorkTrips\Show;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/work-trips', Index::class)
        ->name('work-trips.index');

    Route::get('/work-trips/create', Create::class)
        ->name('work-trips.create');

    Route::get('/work-trips/show/{workTrip}', Show::class)
        ->name('work-trips.show');

    Route::get('/work-trips/update/{workTrip}', Edit::class)
        ->name('work-trips.edit');

    Route::get('/work-trips/requests', \App\Livewire\WorkTrips\Request\Index::class)
        ->name('work-trips.requests.index');

    Route::get('/work-trips/requests/show/{post}', \App\Livewire\WorkTrips\Request\Show::class)
        ->name('work-trips.requests.show');
});
