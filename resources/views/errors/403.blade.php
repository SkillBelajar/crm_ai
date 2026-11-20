<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | MindControl CRM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col justify-between selection:bg-rose-500 selection:text-white font-sans antialiased transition-colors duration-200">

    <!-- Top Minimal Navigation -->
    <header class="w-full border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-rose-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-rose-600/30">
                    403
                </div>
                <div>
                    <span class="font-bold text-slate-900 dark:text-slate-100 tracking-tight text-sm">MindControl CRM</span>
                    <span class="block text-[11px] text-slate-500 dark:text-slate-400 font-mono">Keamanan & Otorisasi</span>
                </div>
            </div>

            <!-- Dark / Light Mode Toggle -->
            <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" 
                    type="button"
                    class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition"
                    aria-label="Toggle Dark Mode">
                <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </button>
        </div>
    </header>

    <!-- Error Content Center -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="max-w-md w-full text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-400 border border-rose-200 dark:border-rose-900/60 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                403 &bull; Akses Terlarang
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-3">
                Akses Ditolak
            </h1>

            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-8">
                {{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses atau kredensial yang memadai untuk membuka halaman atau data ini. Akses lintas-pengguna dibatasi secara ketat untuk melindungi privasi strategi negosiasi.' }}
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? '/admin' : '/dashboard') : '/' }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-slate-900 font-semibold text-xs shadow-sm hover:opacity-90 transition">
                    Kembali ke Dashboard / Beranda
                </a>
                <button onclick="window.history.back()"
                        type="button"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 font-semibold text-xs border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition">
                    Halaman Sebelumnya
                </button>
            </div>
        </div>
    </main>

    <!-- Global Footer -->
    <x-footer />

</body>
</html>
