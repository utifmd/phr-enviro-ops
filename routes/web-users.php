<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Users\Create;
use App\Livewire\Users\Edit;
use App\Livewire\Users\Index;
use App\Livewire\Users\Show;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::get('/users', Index::class)
        ->name('users.index');

    Route::get('/users/create', Create::class)
        ->name('users.create');

    Route::get('/users/show/{user}', Show::class)
        ->name('users.show');

    Route::get('/users/update/{user}', Edit::class)
        ->name('users.edit');

    Route::view('profile', 'profile')
        ->name('profile');
});
