<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-50 font-serif">
                Pengaturan AI Mandiri (BYOK)
            </h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Hubungkan server atau endpoint OpenAI-compatible milik Anda sendiri tanpa biaya platform per percakapan.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-medium bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                BYOK Engine v0.4
            </span>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="rounded-xl border p-4 sm:p-5 transition-all {{ $is_verified ? 'bg-emerald-50/60 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-800/60' : 'bg-amber-50/60 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/60' }}">
        <div class="flex items-start sm:items-center gap-3">
            <div class="mt-0.5 sm:mt-0 p-2 rounded-lg {{ $is_verified ? 'bg-emerald-100 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-900/60 text-amber-700 dark:text-amber-300' }}">
                @if($is_verified)
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                @endif
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm font-semibold {{ $is_verified ? 'text-emerald-900 dark:text-emerald-200' : 'text-amber-900 dark:text-amber-200' }}">
                        {{ $is_verified ? 'Endpoint Terverifikasi & Siap Digunakan' : 'Endpoint Belum Terkonfigurasi / Belum Diuji' }}
                    </span>
                    @if($is_verified && $last_tested_at)
                        <span class="text-xs px-2 py-0.5 rounded-full font-mono bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300">
                            Terakhir diuji: {{ $last_tested_at }}
                        </span>
                    @endif
                </div>
                <p class="text-xs sm:text-sm mt-0.5 {{ $is_verified ? 'text-emerald-700 dark:text-emerald-300/80' : 'text-amber-700 dark:text-amber-300/80' }}">
                    {{ $is_verified
                        ? 'Model AI aktif siap digunakan untuk eksekusi Misi 1 (Pancing & Catat) dan Misi 2 (Filtrasi Anti-Lilin).'
                        : 'Lakukan uji koneksi dengan menekan tombol "Test Koneksi AI" untuk memastikan kredensial endpoint dapat merespons dengan baik.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Success Feedback Notification -->
    @if($saveSuccessMessage)
        <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/30 p-4 text-emerald-800 dark:text-emerald-300 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $saveSuccessMessage }}</span>
            </div>
            <button type="button" wire:click="$set('saveSuccessMessage', null)" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Test Feedback Result Box -->
    @if($testSuccess !== null)
        <div class="rounded-xl border p-4 sm:p-5 {{ $testSuccess ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-900 dark:text-emerald-200' : 'bg-rose-500/10 border-rose-500/30 text-rose-900 dark:text-rose-200' }}">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 p-1.5 rounded-lg {{ $testSuccess ? 'bg-emerald-200 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-300' : 'bg-rose-200 dark:bg-rose-900 text-rose-800 dark:text-rose-300' }}">
                    @if($testSuccess)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    @endif
                </div>
                <div class="flex-1 space-y-1">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="font-semibold text-sm">
                            {{ $testSuccess ? 'Uji Koneksi Berhasil!' : 'Uji Koneksi Gagal' }}
                        </p>
                        @if($testLatency !== null)
                            <span class="text-xs font-mono px-2 py-0.5 rounded {{ $testSuccess ? 'bg-emerald-200/80 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300' : 'bg-rose-200/80 dark:bg-rose-900/60 text-rose-800 dark:text-rose-300' }}">
                                Latensi: {{ $testLatency }} ms
                            </span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm opacity-90">
                        {{ $testMessage }}
                    </p>
                    @if($testReply)
                        <div class="mt-2.5 pt-2 border-t {{ $testSuccess ? 'border-emerald-200 dark:border-emerald-800/40' : 'border-rose-200 dark:border-rose-800/40' }}">
                            <span class="text-[11px] font-mono uppercase tracking-wider block opacity-70">Respons Uji Model:</span>
                            <div class="mt-1 text-xs font-mono bg-white/60 dark:bg-black/30 p-2.5 rounded-lg border border-black/5 dark:border-white/5 whitespace-pre-wrap">
                                {{ $testReply }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Main Grid: Form (Left) & Tips Card (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Configuration Form (2 Cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-6 sm:p-8 space-y-6">
                <!-- Base URL -->
                <div>
                    <label for="base_url" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                        Base URL Endpoint (OpenAI-Compatible) <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1.5 relative">
                        <input
                            type="text"
                            id="base_url"
                            wire:model="base_url"
                            placeholder="https://api.openai.com/v1"
                            class="w-full px-3.5 py-2.5 rounded-xl border font-mono text-sm bg-zinc-50/50 dark:bg-zinc-800/50 border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors"
                        />
                    </div>
                    <p class="mt-1.5 text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Sistem otomatis menambahkan <code class="px-1 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-indigo-600 dark:text-indigo-400">/chat/completions</code> di belakang URL ini.
                    </p>
                    @error('base_url')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- API Key -->
                <div x-data="{ showKey: false }">
                    <div class="flex items-center justify-between">
                        <label for="api_key" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            API Key <span class="text-xs text-zinc-400">(Opsional jika server privat tanpa autentikasi)</span>
                        </label>
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-600 dark:text-emerald-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Disimpan terenkripsi di server (AES-256)
                        </span>
                    </div>
                    <div class="mt-1.5 relative">
                        <input
                            :type="showKey ? 'text' : 'password'"
                            id="api_key"
                            wire:model="api_key"
                            placeholder="sk-..."
                            class="w-full pl-3.5 pr-20 py-2.5 rounded-xl border font-mono text-sm bg-zinc-50/50 dark:bg-zinc-800/50 border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors"
                        />
                        <button
                            type="button"
                            @click="showKey = !showKey"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-xs font-medium text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors"
                        >
                            <span x-text="showKey ? 'Sembunyi' : 'Lihat'"></span>
                        </button>
                    </div>
                    @error('api_key')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model Name -->
                <div>
                    <label for="model_name" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                        Nama Model AI <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1.5 relative">
                        <input
                            type="text"
                            id="model_name"
                            wire:model="model_name"
                            placeholder="gpt-4o-mini"
                            class="w-full px-3.5 py-2.5 rounded-xl border font-mono text-sm bg-zinc-50/50 dark:bg-zinc-800/50 border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors"
                        />
                    </div>
                    <p class="mt-1.5 text-xs text-zinc-500 dark:text-zinc-400">
                        Contoh: <code class="px-1 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 font-mono text-xs">gpt-4o-mini</code>, <code class="px-1 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 font-mono text-xs">llama-3.1-8b</code>, <code class="px-1 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 font-mono text-xs">deepseek-chat</code>.
                    </p>
                    @error('model_name')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons with Loading States -->
                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <!-- Test Connection Button -->
                    <button
                        type="button"
                        wire:click="testConnection"
                        wire:loading.attr="disabled"
                        wire:target="testConnection, save"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-medium text-sm text-zinc-700 dark:text-zinc-200 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 border border-zinc-300 dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-400 disabled:opacity-50 transition-all cursor-pointer"
                    >
                        <!-- Normal State -->
                        <span wire:loading.remove wire:target="testConnection" class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Test Koneksi AI
                        </span>
                        <!-- Loading State -->
                        <span wire:loading wire:target="testConnection" class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Menguji Endpoint...
                        </span>
                    </button>

                    <!-- Save Settings Button -->
                    <button
                        type="button"
                        wire:click="save"
                        wire:loading.attr="disabled"
                        wire:target="testConnection, save"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl font-medium text-sm text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm shadow-indigo-600/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 disabled:opacity-50 transition-all cursor-pointer"
                    >
                        <!-- Normal State -->
                        <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Pengaturan
                        </span>
                        <!-- Loading State -->
                        <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tips & Supported Providers Card (1 Col) -->
        <div class="space-y-4">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                    <div class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        Format Endpoint Didukung
                    </h2>
                </div>

                <div class="space-y-3.5 text-xs text-zinc-600 dark:text-zinc-400">
                    <!-- Provider 1 -->
                    <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-zinc-900 dark:text-zinc-200">Server Privat / Custom</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 font-mono">Lokal / Cloud</span>
                        </div>
                        <p class="font-mono text-[11px] text-zinc-500 break-all">https://ai.example.com/v1</p>
                        <p class="text-[11px]">Model: <code class="font-mono text-zinc-700 dark:text-zinc-300">gpt-4o-mini</code></p>
                    </div>

                    <!-- Provider 2 -->
                    <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-zinc-900 dark:text-zinc-200">OpenAI Resmi</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-mono">Cloud</span>
                        </div>
                        <p class="font-mono text-[11px] text-zinc-500 break-all">https://api.openai.com/v1</p>
                        <p class="text-[11px]">Model: <code class="font-mono text-zinc-700 dark:text-zinc-300">gpt-4o-mini</code>, <code class="font-mono text-zinc-700 dark:text-zinc-300">gpt-4o</code></p>
                    </div>

                    <!-- Provider 3 -->
                    <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-zinc-900 dark:text-zinc-200">Groq Fast Cloud</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-indigo-100 dark:bg-indigo-900/60 text-indigo-800 dark:text-indigo-300 font-mono">Ultra Cepat</span>
                        </div>
                        <p class="font-mono text-[11px] text-zinc-500 break-all">https://api.groq.com/openai/v1</p>
                        <p class="text-[11px]">Model: <code class="font-mono text-zinc-700 dark:text-zinc-300">llama-3.3-70b-versatile</code></p>
                    </div>

                    <!-- Provider 4 -->
                    <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-zinc-900 dark:text-zinc-200">Ollama Lokal</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-mono">Lokal</span>
                        </div>
                        <p class="font-mono text-[11px] text-zinc-500 break-all">http://localhost:11434/v1</p>
                        <p class="text-[11px]">Model: <code class="font-mono text-zinc-700 dark:text-zinc-300">llama3.2:latest</code></p>
                    </div>
                </div>
            </div>

            <!-- Security Assurance Note -->
            <div class="rounded-2xl p-5 bg-gradient-to-br from-zinc-50 to-indigo-50/30 dark:from-zinc-900 dark:to-indigo-950/20 border border-zinc-200 dark:border-zinc-800 text-xs text-zinc-500 dark:text-zinc-400 space-y-2">
                <div class="flex items-center gap-2 text-zinc-900 dark:text-zinc-200 font-semibold">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Prinsip Zero-Markup BYOK
                </div>
                <p>
                    MindControl CRM tidak memungut biaya margin API token ataupun menyimpan percakapan Anda di server pihak ketiga. Kunci API Anda disimpan menggunakan enkripsi tingkat militer (Laravel AES-256-CBC) dan langsung di-route ke endpoint pilihan Anda.
                </p>
            </div>
        </div>
    </div>
</div>
