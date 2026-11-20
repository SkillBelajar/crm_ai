<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mulai Gratis &mdash; MindControl CRM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
    <nav class="w-full border-b border-slate-800/80 bg-slate-950/70 backdrop-blur px-4 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-600/30">
                    MC
                </div>
                <span class="font-bold tracking-tight text-white">MindControl CRM</span>
            </a>
            <a href="/" class="text-xs text-slate-400 hover:text-white transition">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </nav>

    <main class="max-w-md w-full mx-auto px-4 py-12 flex-1 flex flex-col justify-center">
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-8 shadow-2xl backdrop-blur text-center space-y-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-950/80 border border-emerald-800/60 flex items-center justify-center text-emerald-400">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>

            <div class="space-y-2">
                <h1 class="text-xl font-bold text-white tracking-tight">Pendaftaran Akun Gratis</h1>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Pendaftaran mandiri (100% Gratis & BYOK) sedang dikonfigurasi pada siklus pengerjaan berikutnya.
                </p>
            </div>

            <div class="p-4 rounded-xl bg-slate-950/80 border border-slate-800 text-left text-xs space-y-2 font-mono text-slate-300">
                <div class="flex items-center justify-between text-slate-400 text-[11px]">
                    <span>Model Lisensi:</span>
                    <span class="text-emerald-400 font-semibold">100% Free • BYOK</span>
                </div>
                <div class="flex items-center justify-between text-slate-400 text-[11px]">
                    <span>Status Integrasi:</span>
                    <span class="text-indigo-400 font-semibold">Slice 2 (Landing Ready)</span>
                </div>
            </div>

            <div class="space-y-2 pt-2">
                <a href="/" class="block w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs transition shadow-lg shadow-emerald-600/30">
                    Kembali ke Beranda
                </a>
                <a href="/system-health" class="block w-full py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-medium text-xs transition border border-slate-700">
                    Lihat Status Sistem & Health Check
                </a>
            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
