<x-app-layout header="Profil Saya">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white font-extrabold text-xl flex items-center justify-center shadow-lg shadow-indigo-600/30">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ auth()->user()->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800 uppercase">
                            Role: {{ auth()->user()->role }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Akun Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Profile Details Card -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100 dark:border-slate-800 text-xs">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                    <span class="text-slate-400 font-mono text-[10px] uppercase">Terdaftar Sejak</span>
                    <div class="font-bold text-slate-800 dark:text-slate-200 mt-1">
                        {{ auth()->user()->created_at ? auth()->user()->created_at->format('d F Y, H:i') : '-' }}
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                    <span class="text-slate-400 font-mono text-[10px] uppercase">Sesi Driver Aktif</span>
                    <div class="font-bold text-emerald-600 dark:text-emerald-400 mt-1 uppercase font-mono">
                        {{ config('session.driver') }}
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-between border-t border-slate-100 dark:border-slate-800">
                <a href="/dashboard" class="px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-800 text-white text-xs font-semibold hover:bg-slate-800 transition">
                    &larr; Kembali ke Dashboard
                </a>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold transition cursor-pointer">
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
