<div class="w-full max-w-md mx-auto space-y-6">
    <!-- Register Card -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur transition-all">
        <!-- Brand Header -->
        <div class="text-center space-y-2 mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 border border-indigo-200 dark:border-indigo-800/80 text-indigo-600 dark:text-indigo-400 mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Daftar Akun Gratis</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                100% Bebas biaya langganan. Sambungkan AI Anda dan mulai kendalikan negosiasi.
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="register" class="space-y-4">
            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Nama Lengkap
                </label>
                <input 
                    wire:model="name" 
                    type="text" 
                    id="name" 
                    placeholder="Nama Lengkap Anda"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border @error('name') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition">
                @error('name')
                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Alamat Email
                </label>
                <input 
                    wire:model="email" 
                    type="email" 
                    id="email" 
                    placeholder="nama@perusahaan.com"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border @error('email') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition">
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
                    Kata Sandi (Min. 8 Karakter)
                </label>
                <input 
                    wire:model="password" 
                    type="password" 
                    id="password" 
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border @error('password') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition">
                @error('password')
                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Konfirmasi Kata Sandi
                </label>
                <input 
                    wire:model="password_confirmation" 
                    type="password" 
                    id="password_confirmation" 
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition">
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-lg shadow-indigo-600/30 transition cursor-pointer flex items-center justify-center gap-2 disabled:opacity-60">
                <svg wire:loading wire:target="register" class="w-4 h-4 animate-spin text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span wire:loading.remove wire:target="register">Daftar Akun Gratis</span>
                <span wire:loading wire:target="register">Mendaftarkan Akun...</span>
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Sudah memiliki akun?
                <a href="/login" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                    Masuk ke Akun Anda &rarr;
                </a>
            </p>
        </div>

        <!-- Version Footer Badge -->
        <div class="mt-6 pt-4 border-t border-dashed border-slate-200 dark:border-slate-800 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Versi: {{ config('app.version') }}
            </span>
        </div>
    </div>
</div>
