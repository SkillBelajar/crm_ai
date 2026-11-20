<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Psychological CRM &mdash; Pendengar & Pengendali</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        code, pre, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white flex flex-col">
    <!-- Background subtle ambient effect -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-tr from-indigo-600/15 via-violet-600/10 to-transparent blur-3xl rounded-full"></div>
        <div class="absolute top-1/2 -right-40 w-[500px] h-[500px] bg-gradient-to-bl from-blue-600/10 to-transparent blur-3xl rounded-full"></div>
    </div>

    <!-- Header / Navigation -->
    <header class="relative z-10 w-full border-b border-slate-800/80 bg-slate-950/70 backdrop-blur sticky top-0">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-base tracking-tight text-white">AI Psychological CRM</span>
                    <span class="hidden sm:inline-block text-xs text-slate-400 font-medium ml-2 px-2 py-0.5 rounded bg-slate-800 border border-slate-700">Pendengar & Pengendali</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/" class="text-xs font-medium text-slate-300 hover:text-white px-3 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 border border-slate-700 transition">
                    &larr; Beranda
                </a>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-950/90 text-emerald-300 border border-emerald-800/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    Diagnostik System
                </span>
                <span class="text-xs font-mono px-2 py-1 rounded bg-slate-900 border border-slate-800 text-slate-400">
                    v{{ config('app.version') }}
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 flex-1 max-w-6xl w-full mx-auto px-4 py-8 md:py-12 space-y-10">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-950/60 border border-indigo-800/50 text-indigo-300 text-xs font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Fondasi Arsitektur High Concurrency Octane</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                AI Psychological CRM &mdash;<br class="hidden sm:inline" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-violet-400 to-pink-400">
                    Pendengar & Pengendali
                </span>
            </h1>
            <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
                SaaS Gratis dengan arsitektur <em>BYOK (Bring Your Own Key) Custom AI Endpoint</em>. 
                Dirancang untuk mengendalikan dinamika percakapan prospek melalui 3 misi psikologis strategis dengan performa worker Laravel Octane (FrankenPHP).
            </p>
        </div>

        <!-- Livewire Health Check Real-time System Badges -->
        <section class="space-y-3">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    System Health & Infrastructure Monitor
                </h2>
                <span class="text-xs text-slate-500">Live Backend Verification</span>
            </div>
            
            <livewire:health-check />
        </section>

        <!-- 3 Core Psychological Pillars Grid -->
        <section class="space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                3 Misi Utama Psikologis CRM
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pillar 1 -->
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 hover:border-indigo-500/50 transition duration-300">
                    <div class="w-10 h-10 rounded-xl bg-indigo-950 border border-indigo-800/60 text-indigo-400 flex items-center justify-center font-bold text-sm mb-4">
                        01
                    </div>
                    <h3 class="text-base font-bold text-slate-100 mb-2">Pancing & Catat</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mendengarkan secara proaktif sinyal terselubung, pain points prospek, dan pola emosional tanpa memicu resistensi pertahanan diri calon klien.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-800/80 text-[11px] font-mono text-indigo-400">
                        &rarr; Elicitation & Hidden Pattern Capture
                    </div>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 hover:border-violet-500/50 transition duration-300">
                    <div class="w-10 h-10 rounded-xl bg-violet-950 border border-violet-800/60 text-violet-400 flex items-center justify-center font-bold text-sm mb-4">
                        02
                    </div>
                    <h3 class="text-base font-bold text-slate-100 mb-2">Filtrasi Anti-Lilin (Conditional Yes)</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mencegah tim habis terbakar (burnout) melayani prospek *ghosting*. Mengunci syarat sebelum memberi komitmen melalui formula psikologis <em>Conditional Yes</em>.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-800/80 text-[11px] font-mono text-violet-400">
                        &rarr; Boundary Guard & Reciprocal Compliance
                    </div>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 hover:border-pink-500/50 transition duration-300">
                    <div class="w-10 h-10 rounded-xl bg-pink-950 border border-pink-800/60 text-pink-400 flex items-center justify-center font-bold text-sm mb-4">
                        03
                    </div>
                    <h3 class="text-base font-bold text-slate-100 mb-2">Kunci Kontrak Psikologis 24 Jam</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Menerapkan batas penutupan internal 24 jam untuk memicu *urgency* internal dan komitmen mental prospek sebelum momentum keputusan memudar.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-800/80 text-[11px] font-mono text-pink-400">
                        &rarr; 24-Hour Behavioral Urgency Lock
                    </div>
                </div>
            </div>
        </section>

        <!-- Technical Foundation & Roadmap Grid -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Architecture Stack -->
            <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-200 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    Spesifikasi Arsitektur Stack (Slice 1)
                </h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800/80">
                        <dt class="text-slate-500 font-medium">Framework & Concurrency</dt>
                        <dd class="text-slate-200 font-semibold mt-0.5">Laravel 13 + Octane (FrankenPHP)</dd>
                    </div>
                    <div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800/80">
                        <dt class="text-slate-500 font-medium">Reverse Proxy Web</dt>
                        <dd class="text-slate-200 font-semibold mt-0.5">Nginx Alpine (Static Cache)</dd>
                    </div>
                    <div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800/80">
                        <dt class="text-slate-500 font-medium">Database Persistence</dt>
                        <dd class="text-slate-200 font-semibold mt-0.5">MySQL 8.0 (crm_psikologis)</dd>
                    </div>
                    <div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800/80">
                        <dt class="text-slate-500 font-medium">Cache / Session / Queue</dt>
                        <dd class="text-slate-200 font-semibold mt-0.5">Redis Alpine</dd>
                    </div>
                    <div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800/80">
                        <dt class="text-slate-500 font-medium">Dynamic Reactive UI</dt>
                        <dd class="text-slate-200 font-semibold mt-0.5">Livewire 3 + Alpine.js</dd>
                    </div>
                    <div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800/80">
                        <dt class="text-slate-500 font-medium">Styling & Engine</dt>
                        <dd class="text-slate-200 font-semibold mt-0.5">Tailwind CSS v4 (Vite)</dd>
                    </div>
                </dl>
            </div>

            <!-- Slice Roadmap Tracker -->
            <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-200 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Roadmap Delivery (Slice 1 - 9)
                    </h3>
                    <span class="text-xs font-mono text-emerald-400 font-medium">Slice 1 Complete</span>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-emerald-950/40 border border-emerald-800/50">
                        <span class="font-medium text-emerald-300">Slice 1: Setup Arsitektur Dasar & Project Memory</span>
                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-500/20 text-emerald-300">Selesai (v0.1)</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-950/60 border border-slate-800/60 text-slate-400">
                        <span>Slice 2: BYOK Custom AI Endpoint & Prompt Orchestration</span>
                        <span class="text-[11px] font-mono text-slate-500">Planned</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-950/60 border border-slate-800/60 text-slate-400">
                        <span>Slice 3: Modul 1 &mdash; Pancing & Catat (Active Elicitation)</span>
                        <span class="text-[11px] font-mono text-slate-500">Planned</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-950/60 border border-slate-800/60 text-slate-400">
                        <span>Slice 4: Modul 2 &mdash; Filtrasi Anti-Lilin (Conditional Yes)</span>
                        <span class="text-[11px] font-mono text-slate-500">Planned</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-950/60 border border-slate-800/60 text-slate-400">
                        <span>Slice 5: Modul 3 &mdash; Kunci Kontrak Psikologis 24 Jam</span>
                        <span class="text-[11px] font-mono text-slate-500">Planned</span>
                    </div>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-950/60 border border-slate-800/60 text-slate-400">
                        <span>Slice 6 - 9: Analytics, Webhook/WA Ingress, Multi-Tenant & Hardening</span>
                        <span class="text-[11px] font-mono text-slate-500">Planned</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Global Footer Component (WAJIB: Menampilkan Versi 0.1) -->
    <x-footer />

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
