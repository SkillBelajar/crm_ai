<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MindControl CRM' }} &mdash; Pendengar &amp; Pengendali</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Theme Initialization -->
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body 
    x-data="{
        darkMode: localStorage.getItem('theme') !== 'light',
        sidebarOpen: false,
        userDropdown: false,
        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }"
    class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-indigo-500 selection:text-white flex flex-col transition-colors duration-200">

    <div class="flex h-screen overflow-hidden">
        <!-- MOBILE SIDEBAR OVERLAY & DRAWER -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-40 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"></div>

        <aside 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 flex flex-col w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 z-50 lg:hidden shadow-2xl"
            style="display: none;">
            
            <!-- Mobile Sidebar Header -->
            <div class="h-16 px-6 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white font-extrabold text-xs shadow-md">
                        MC
                    </div>
                    <span class="font-extrabold text-sm tracking-tight text-slate-900 dark:text-white">MindControl CRM</span>
                </a>
                <button @click="sidebarOpen = false" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation Links -->
            <div class="flex-1 px-4 py-6 overflow-y-auto space-y-1">
                @include('layouts.navigation-links')
            </div>

            <!-- Mobile Sidebar Footer User Info -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/60">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-full bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-semibold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono capitalize">{{ auth()->user()->role }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- DESKTOP FIXED SIDEBAR -->
        <aside class="hidden lg:flex flex-col w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex-shrink-0 transition-colors duration-200">
            <!-- Brand Logo -->
            <div class="h-16 px-6 flex items-center border-b border-slate-200 dark:border-slate-800">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white font-extrabold text-xs shadow-md shadow-indigo-600/20 group-hover:scale-105 transition transform">
                        MC
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-sm tracking-tight text-slate-900 dark:text-white">MindControl CRM</span>
                        <span class="text-[9px] text-slate-400 font-medium">Pendengar &amp; Pengendali</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Menu -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1.5">
                @include('layouts.navigation-links')
            </nav>

            <!-- Bottom Diagnostics Link -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-800 space-y-2">
                <a href="/system-health" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>System Health</span>
                    </span>
                    <span class="font-mono text-[10px] px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-800">v{{ config('app.version') }}</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- TOPBAR -->
            <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 sm:px-6 lg:px-8 flex items-center justify-between flex-shrink-0 z-30 transition-colors duration-200">
                <!-- Left: Hamburger (Mobile) & Page Title -->
                <div class="flex items-center space-x-3">
                    <button 
                        @click="sidebarOpen = true" 
                        class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>
                </div>

                <!-- Right: Theme Toggle & User Menu Dropdown -->
                <div class="flex items-center space-x-3">
                    <!-- Theme Toggle Button -->
                    <button 
                        @click="toggleTheme()" 
                        type="button" 
                        title="Ubah Mode Tampilan" 
                        class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                        <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            @click.away="open = false" 
                            class="flex items-center space-x-2.5 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-md shadow-indigo-600/20">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="hidden md:flex flex-col text-left">
                                <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate max-w-[120px]">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-[10px] font-mono text-slate-500 dark:text-slate-400 capitalize">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl py-1 z-50 text-xs"
                            style="display: none;">
                            
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800">
                                <div class="font-semibold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ auth()->user()->email }}</div>
                            </div>

                            <a href="/profile" class="flex items-center gap-2 px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Profil Saya</span>
                            </a>

                            <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>

                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition cursor-pointer">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Keluar (Logout)</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE BODY -->
            <main class="flex-1 overflow-y-auto flex flex-col justify-between">
                <div class="p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                    {{ $slot }}
                </div>

                <!-- GLOBAL FOOTER (Versi: 0.3) -->
                <x-footer />
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
