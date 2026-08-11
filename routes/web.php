<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Calendar\Index as Calendar;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Guests only: an already-authenticated visitor gets bounced to the calendar.
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', Login::class);

    Route::view('/register', 'auth.register')->name('register');
    // Login throttles per email/IP inside the controller; registration has no
    // such key to hang it on, so it throttles per IP at the route.
    Route::post('/register', Register::class)->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', Logout::class)->name('logout');

    Route::get('/calendar', Calendar::class)->name('calendar');
});
