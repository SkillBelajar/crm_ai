<x-app-layout header="Dashboard Eksekutif">
    <div class="space-y-8">
        <!-- Hero Welcome Header -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 dark:from-slate-900 dark:via-indigo-950/60 dark:to-slate-950 p-6 sm:p-8 text-white shadow-xl border border-indigo-900/40">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                            Role: {{ auth()->user()->role }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Akun Aktif
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Anda berada di pusat kendali negosiasi dan diplomasi psikologis. Gunakan prinsip 3 Misi: dengarkan 80%, kunci komitmen pihak lawan, dan biarkan AI merumuskan strategi tanpa menguras energi Anda.
                    </p>
                </div>

                <!-- Session & Octane Diagnostic Badge -->
                <div class="flex-shrink-0 bg-white/10 dark:bg-slate-900/60 backdrop-blur-md rounded-2xl p-4 border border-white/10 space-y-1.5 min-w-[200px]">
                    <div class="text-[10px] font-mono text-slate-300 uppercase tracking-wider">Infrastruktur Sesi</div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Driver Sesi:</span>
                        <span class="font-mono font-bold text-emerald-400 uppercase">{{ config('session.driver') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Cache Driver:</span>
                        <span class="font-mono font-bold text-indigo-300 uppercase">{{ config('cache.default') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">App Engine:</span>
                        <span class="font-mono font-semibold text-slate-200">Octane FrankenPHP</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Psychological Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Kontak Terkoneksi -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Kontak Terkoneksi</span>
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono">{{ auth()->user()->contacts()->count() }}</div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Daftar target lawan bicara &amp; stakeholder aktif.</p>
            </div>

            <!-- Misi Terkunci -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Sesi & Misi Aktif</span>
                    <div class="w-9 h-9 rounded-xl bg-violet-50 dark:bg-violet-950/80 text-violet-600 dark:text-violet-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono">{{ auth()->user()->meetings()->count() }}</div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Sesi 3 Misi & komitmen yang sedang berjalan.</p>
            </div>

            <!-- Energi Terjaga -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Indeks Energi Terjaga</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">100%</div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Prinsip Anti-Lilin: beban aksi tetap ada di lawan bicara.</p>
            </div>
        </div>

        <!-- Quick Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Action 1: Workspace 3 Misi -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-indigo-600/20">
                        01
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Mulai Pertemuan Baru</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Pancing ego, catat 1 poin kebutuhan, dan kunci komitmen.</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Masuk ke ruang kerja interaktif 3 Misi yang dirancang khusus untuk memandu jalannya pembicaraan tatap muka atau panggilan virtual secara taktis.
                </p>
                <div class="pt-2">
                    <a href="/meetings" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md shadow-indigo-600/20 transition">
                        <span>Buka Workspace 3 Misi &rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Action 2: Setup AI BYOK -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-violet-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-violet-600/20">
                        02
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Setup AI Endpoint (BYOK)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Hubungkan OpenAI, Ollama, vLLM, atau custom server.</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Simpan konfigurasi endpoint AI Anda secara terenkripsi. Tanpa biaya kuota langganan SaaS, gunakan model pilihan Anda sendiri.
                </p>
                <div class="pt-2">
                    <a href="/ai-settings" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 transition">
                        <span>Konfigurasi AI Endpoint &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
