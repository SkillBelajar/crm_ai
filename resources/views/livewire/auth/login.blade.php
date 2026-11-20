<div class="w-full max-w-md mx-auto space-y-6">
    <!-- Login Card -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur transition-all">
        <!-- Brand Header -->
        <div class="text-center space-y-2 mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 border border-indigo-200 dark:border-indigo-800/80 text-indigo-600 dark:text-indigo-400 mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Masuk ke Akun</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Akses dashboard kendali psikologis dan strategi negosiasi Anda.
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="space-y-4">
            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Alamat Email
                </label>
                <div class="relative">
                    <input 
                        wire:model="email" 
                        type="email" 
                        id="email" 
                        placeholder="nama@perusahaan.com"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border @error('email') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition">
                </div>
                @error('email')
                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Kata Sandi
                </label>
                <div class="relative">
                    <input 
                        wire:model="password" 
                        type="password" 
                        id="password" 
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border @error('password') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition">
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input 
                        wire:model="remember" 
                        type="checkbox" 
                        class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 bg-slate-50 dark:bg-slate-950">
                    <span class="text-xs text-slate-600 dark:text-slate-400">Ingat Saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-lg shadow-indigo-600/30 transition cursor-pointer flex items-center justify-center gap-2 disabled:opacity-60">
                <svg wire:loading wire:target="login" class="w-4 h-4 animate-spin text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span wire:loading.remove wire:target="login">Masuk ke Akun</span>
                <span wire:loading wire:target="login">Memproses Masuk...</span>
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Belum memiliki akun?
                <a href="/register" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                    Daftar Gratis Sekarang &rarr;
                </a>
            </p>
        </div>

        <!-- Testing Credentials Helper Pill -->
        <div class="mt-4 p-3 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 text-[11px] text-slate-500 dark:text-slate-400 space-y-1">
            <div class="font-bold text-slate-700 dark:text-slate-300 font-mono">Demo Akun (Testing):</div>
            <div class="flex items-center justify-between font-mono">
                <span>Admin: <strong class="text-indigo-500">admin@crm.test</strong></span>
                <span>pass: <code class="text-slate-700 dark:text-slate-300">password123</code></span>
            </div>
            <div class="flex items-center justify-between font-mono">
                <span>User: <strong class="text-emerald-500">user@crm.test</strong></span>
                <span>pass: <code class="text-slate-700 dark:text-slate-300">password123</code></span>
            </div>
        </div>

        <!-- WAJIB: Nomor Versi di Bawah Form Login -->
        <div class="mt-6 pt-4 border-t border-dashed border-slate-200 dark:border-slate-800 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Versi: {{ config('app.version') }}
            </span>
        </div>
    </div>
</div>
