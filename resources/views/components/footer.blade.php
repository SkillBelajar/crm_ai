<footer class="w-full border-t border-slate-200 dark:border-slate-800/80 bg-white/90 dark:bg-slate-950/80 backdrop-blur py-8 px-4 mt-auto transition-colors duration-200">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-slate-500 dark:text-slate-400">
        <!-- Brand & Tagline -->
        <div class="flex flex-col sm:flex-row items-center gap-3 text-center sm:text-left">
            <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-indigo-600/30">
                MC
            </div>
            <div>
                <span class="font-bold text-slate-900 dark:text-slate-200">MindControl CRM</span>
                <span class="text-slate-400 dark:text-slate-500 hidden sm:inline">&bull;</span>
                <span class="block sm:inline text-slate-500 dark:text-slate-400">Pendengar & Pengendali di Setiap Pertemuan</span>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2 font-medium">
            <a href="#misi" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Konsep 3 Misi</a>
            <a href="#byok" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Keunggulan BYOK AI</a>
            <a href="#cara-kerja" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Cara Kerja</a>
            <a href="/system-health" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Diagnostik Sistem
            </a>
            <a href="/login" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Masuk</a>
            <a href="/register" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Mulai Gratis</a>
        </div>

        <!-- Version & Copyright -->
        <div class="flex items-center space-x-3">
            <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-mono font-semibold border border-slate-200 dark:border-slate-800 text-[11px]">
                Versi: {{ config('app.version') }}
            </span>
            <span class="text-slate-400 dark:text-slate-500">&copy; {{ date('Y') }} All Rights Reserved.</span>
        </div>
    </div>
</footer>
