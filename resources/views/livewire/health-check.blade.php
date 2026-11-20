<div class="w-full space-y-6">
    <!-- Top System Health Badges Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Database Badge -->
        <div class="bg-slate-900/80 border {{ $dbConnected ? 'border-emerald-500/30' : 'border-rose-500/30' }} rounded-xl p-5 backdrop-blur shadow-lg transition duration-200 hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider uppercase text-slate-400">Database Engine</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $dbConnected ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-800/60' : 'bg-rose-950/80 text-rose-400 border border-rose-800/60' }}">
                    <span class="w-2 h-2 rounded-full {{ $dbConnected ? 'bg-emerald-400 animate-pulse' : 'bg-rose-400' }}"></span>
                    {{ $dbConnected ? 'Connected' : 'Error' }}
                </span>
            </div>
            <div class="mt-3">
                <div class="text-lg font-bold text-slate-100">MySQL 8.0</div>
                <p class="text-xs font-mono text-slate-400 mt-1 truncate" title="{{ $dbMessage }}">
                    {{ $dbMessage }}
                </p>
            </div>
        </div>

        <!-- Redis Badge -->
        <div class="bg-slate-900/80 border {{ $redisConnected ? 'border-emerald-500/30' : 'border-rose-500/30' }} rounded-xl p-5 backdrop-blur shadow-lg transition duration-200 hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider uppercase text-slate-400">Cache & Session</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $redisConnected ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-800/60' : 'bg-rose-950/80 text-rose-400 border border-rose-800/60' }}">
                    <span class="w-2 h-2 rounded-full {{ $redisConnected ? 'bg-emerald-400 animate-pulse' : 'bg-rose-400' }}"></span>
                    {{ $redisConnected ? 'Connected' : 'Error' }}
                </span>
            </div>
            <div class="mt-3">
                <div class="text-lg font-bold text-slate-100">Redis Alpine</div>
                <p class="text-xs font-mono text-slate-400 mt-1 truncate" title="{{ $redisMessage }}">
                    {{ $redisMessage }}
                </p>
            </div>
        </div>

        <!-- Server Status Badge -->
        <div class="bg-slate-900/80 border border-indigo-500/30 rounded-xl p-5 backdrop-blur shadow-lg transition duration-200 hover:border-slate-700">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold tracking-wider uppercase text-slate-400">Server Engine</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-950/80 text-indigo-400 border border-indigo-800/60">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    Octane Active
                </span>
            </div>
            <div class="mt-3">
                <div class="text-lg font-bold text-slate-100">{{ $serverStatus }}</div>
                <p class="text-xs font-mono text-slate-400 mt-1">
                    PHP {{ $phpVersion }} &bull; {{ ucfirst($octaneServer) }} Worker
                </p>
            </div>
        </div>
    </div>

    <!-- Health Controls & Metadata bar -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-900/50 border border-slate-800 rounded-xl px-5 py-3 text-xs text-slate-400">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Pemeriksaan terakhir: <strong class="text-slate-200 font-mono">{{ $checkedAt }}</strong></span>
        </div>
        <button 
            wire:click="checkHealth" 
            wire:loading.attr="disabled"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-medium transition cursor-pointer disabled:opacity-50">
            <svg wire:loading.class="animate-spin" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span wire:loading.remove>Refresh Status</span>
            <span wire:loading>Memeriksa...</span>
        </button>
    </div>
</div>
