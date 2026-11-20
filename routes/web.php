<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page (Executive Minimalist & Mobile-Responsive)
Route::get('/', function () {
    return view('landing');
})->name('home');

// System Health & Diagnostics (Slice 1 monitor moved here)
Route::get('/system-health', function () {
    return view('system-health');
})->name('system.health');

// Temporary Placeholders for Auth (Slice 2 CTA links)
Route::get('/login', function () {
    return view('auth.login-placeholder');
})->name('login');

Route::get('/register', function () {
    return view('auth.register-placeholder');
})->name('register');
