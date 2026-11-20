<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Landing Page (Executive Minimalist & Mobile-Responsive)
Route::get('/', function () {
    return view('landing');
})->name('home');

// System Health & Diagnostics (Slice 1 monitor)
Route::get('/system-health', function () {
    return view('system-health');
})->name('system.health');

// Guest Authentication Routes (Livewire 3)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout Action
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // User Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Placeholders for subsequent slices
    Route::get('/contacts', function () {
        return view('placeholders.contacts');
    })->name('contacts');

    Route::get('/meetings', function () {
        return view('placeholders.meetings');
    })->name('meetings');

    Route::get('/ai-settings', function () {
        return view('placeholders.ai-settings');
    })->name('ai-settings');

    Route::get('/guide', function () {
        return view('placeholders.guide');
    })->name('guide');

    Route::get('/profile', function () {
        return view('placeholders.profile');
    })->name('profile');

    // Admin Dashboard (Protected by EnsureUserHasRole middleware)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/', function () {
            $users = User::latest()->get();
            $totalUsers = $users->count();
            $activeUsers = $users->where('is_active', true)->count();
            $adminUsers = $users->where('role', 'admin')->where('is_active', true)->count();

            return view('admin.dashboard', compact('users', 'totalUsers', 'activeUsers', 'adminUsers'));
        })->name('admin.dashboard');
    });
});
