<?php

use App\Livewire\AiSettingsForm;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\ContactIndex;
use App\Livewire\ContactShow;
use App\Livewire\MeetingIndex;
use App\Livewire\MeetingWorkspace;
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // CRM Contacts Module (Slice 5)
    Route::get('/contacts', ContactIndex::class)->name('contacts');
    Route::get('/contacts/{contact}', ContactShow::class)->name('contacts.show');

    // 3 Missions & Meetings Workspace Module (Slice 6)
    Route::get('/meetings', MeetingIndex::class)->name('meetings');
    Route::get('/meetings/{meeting}', MeetingWorkspace::class)->name('meetings.show');

    Route::get('/ai-settings', AiSettingsForm::class)->name('ai-settings');

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
