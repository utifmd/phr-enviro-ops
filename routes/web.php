<?php

use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*Route::get('/reports/monthly', \App\Livewire\Reports\Monthly\Index::class)
    ->can(UserPolicy::IS_USER_IS_FAC_REP)
    ->name('reports.monthly');*/

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

require __DIR__.'/web-users.php';
require __DIR__.'/web-well.php';
require __DIR__ . '/web-companies.php';
require __DIR__ . '/web-post-wo.php';
require __DIR__ . '/web-post-fac.php';
require __DIR__ . '/web-logs.php';
