<footer class="w-full border-t border-slate-800/80 bg-slate-950/60 backdrop-blur py-6 px-4 mt-auto">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
        <div class="flex items-center space-x-2">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="font-medium text-slate-300">AI Psychological CRM &mdash; Pendengar & Pengendali</span>
        </div>
        <div class="flex items-center space-x-3">
            <span class="px-2.5 py-1 rounded-full bg-slate-800 text-slate-200 font-mono font-semibold border border-slate-700">
                Versi: {{ config('app.version') }}
            </span>
            <span class="text-slate-500">&copy; {{ date('Y') }} All Rights Reserved.</span>
        </div>
    </div>
</footer>
