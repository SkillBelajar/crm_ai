<div class="space-y-8">
    <!-- FLASH NOTIFICATION TOAST/ALERT -->
    @if($flashMessage)
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="relative overflow-hidden rounded-2xl border p-4 sm:p-5 shadow-sm flex items-center justify-between gap-4 {{ $flashType === 'error' ? 'bg-rose-50 dark:bg-rose-950/40 border-rose-300 dark:border-rose-800 text-rose-900 dark:text-rose-200' : 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-300 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200' }}"
        >
            <div class="flex items-center gap-3">
                @if($flashType === 'error')
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
                <span class="text-xs sm:text-sm font-semibold">{{ $flashMessage }}</span>
            </div>
            <button 
                wire:click="dismissFlash" 
                @click="show = false" 
                type="button" 
                class="p-1 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition text-current opacity-70 hover:opacity-100"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- ADMIN HEADER BANNER -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                        Superadmin Access
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                        Versi: {{ config('app.version') }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Panel Admin SaaS
                </h1>
                <p class="text-xs sm:text-sm text-slate-400 max-w-2xl leading-relaxed">
                    Pusat Kendali Pengguna, pemantauan adopsi AI Mandiri, dan tata kelola platform MindControl CRM.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="/system-health" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-md transition">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>Cek System Health</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- GRID 4 KARTU KPI GLOBAL PLATFORM -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- KPI 1: Total Pengguna (Role User) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Total Pengguna</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-950/70 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono">
                    {{ $totalRegularUsers }}
                </div>
                <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium mt-1 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>{{ $activeRegularUsers }} akun aktif</span>
                </div>
            </div>
        </div>

        <!-- KPI 2: AI Terkonfigurasi -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">AI Terkonfigurasi</span>
                <div class="w-8 h-8 rounded-xl bg-violet-50 dark:bg-violet-950/70 text-violet-600 dark:text-violet-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-violet-600 dark:text-violet-400 font-mono">
                    {{ $totalAiConfigured }}
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mt-1">
                    Pengguna BYOK mandiri
                </div>
            </div>
        </div>

        <!-- KPI 3: Total Kontak CRM -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Total Kontak CRM</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/70 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono">
                    {{ $totalContacts }}
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mt-1">
                    Profil lawan bicara terdata
                </div>
            </div>
        </div>

        <!-- KPI 4: Total Sesi 3 Misi & Persentase Committed -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Total Sesi 3 Misi</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/70 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-amber-600 dark:text-amber-400 font-mono">
                    {{ $totalMeetings }}
                </div>
                <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1 flex items-center gap-1">
                    <span>{{ $committedMeetings }} deal ({{ $conversionRate }}% committed)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MANAJEMEN DAFTAR PENGGUNA -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-sm overflow-hidden">
        <!-- Table Controls: Search & Filter -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Manajemen Pengguna SaaS</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Pantau pertumbuhan akun, aktivitas, dan kendalikan status akses login.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <!-- Search Input with Debounce -->
                <div class="relative min-w-[240px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Cari nama atau email..." 
                        class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    />
                </div>

                <!-- Status Filter Pill Group -->
                <div class="inline-flex rounded-xl bg-slate-100 dark:bg-slate-950 p-1 border border-slate-200 dark:border-slate-800 text-xs">
                    <button 
                        type="button" 
                        wire:click="$set('statusFilter', 'all')" 
                        class="px-3 py-1.5 rounded-lg font-bold transition {{ $statusFilter === 'all' ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}"
                    >
                        Semua
                    </button>
                    <button 
                        type="button" 
                        wire:click="$set('statusFilter', 'active')" 
                        class="px-3 py-1.5 rounded-lg font-bold transition {{ $statusFilter === 'active' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}"
                    >
                        Aktif
                    </button>
                    <button 
                        type="button" 
                        wire:click="$set('statusFilter', 'suspended')" 
                        class="px-3 py-1.5 rounded-lg font-bold transition {{ $statusFilter === 'suspended' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}"
                    >
                        Suspended
                    </button>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- DESKTOP VIEW: CLEAN RESPONSIVE TABLE (HIDDEN ON MOBILE) -->
        <!-- ============================================== -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-950/80 text-slate-500 dark:text-slate-400 font-mono uppercase text-[10px] tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Pengguna</th>
                        <th class="px-6 py-3.5 font-semibold">Tanggal Daftar</th>
                        <th class="px-6 py-3.5 font-semibold text-center">Statistik</th>
                        <th class="px-6 py-3.5 font-semibold text-center">Status AI</th>
                        <th class="px-6 py-3.5 font-semibold text-center">Status Akun</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/30 transition">
                            <!-- Pengguna -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900 dark:text-white truncate">{{ $user->name }}</span>
                                            @if($user->isAdmin())
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                                    Admin
                                                </span>
                                            @endif
                                            @if($user->id === auth()->id())
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-mono font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Tanggal Daftar -->
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 dark:text-slate-400 font-mono text-[11px]">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>

                            <!-- Statistik Ringkas -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center gap-2 font-mono text-[11px]">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300" title="Total Kontak">
                                        👥 {{ $user->contacts_count }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300" title="Total Pertemuan">
                                        🤝 {{ $user->meetings_count }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status AI -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->aiSetting && $user->aiSetting->is_verified)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-mono font-semibold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @elseif($user->aiSetting && !empty($user->aiSetting->api_key))
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-mono font-semibold bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-400 border border-amber-300 dark:border-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>Tersimpan</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-mono font-semibold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                        <span>Belum</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Status Akun -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                        Suspended
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi Toggle Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if($user->id === auth()->id() || $user->isAdmin())
                                    <span class="text-[11px] text-slate-400 italic">Terkunci</span>
                                @else
                                    @if($user->is_active)
                                        <button 
                                            type="button" 
                                            wire:click="toggleUserStatus({{ $user->id }})" 
                                            wire:confirm="Yakin ingin menonaktifkan akun {{ $user->name }}? Pengguna tidak akan bisa login." 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 font-bold text-[11px] transition cursor-pointer"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            <span>Suspend</span>
                                        </button>
                                    @else
                                        <button 
                                            type="button" 
                                            wire:click="toggleUserStatus({{ $user->id }})" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-bold text-[11px] transition cursor-pointer"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Aktifkan</span>
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="text-3xl">🔍</div>
                                    <div class="text-xs font-bold text-slate-700 dark:text-slate-300">Tidak ada pengguna ditemukan</div>
                                    <div class="text-[11px]">Coba ubah kata kunci pencarian atau reset filter status.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ============================================== -->
        <!-- MOBILE VIEW: COMPACT CARD LIST (VISIBLE ON MOBILE ONLY) -->
        <!-- ============================================== -->
        <div class="block md:hidden divide-y divide-slate-100 dark:divide-slate-800">
            @forelse($users as $user)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-xs text-slate-900 dark:text-white truncate">{{ $user->name }}</span>
                                    @if($user->isAdmin())
                                        <span class="px-1.5 py-0.2 rounded text-[8px] font-mono font-bold uppercase bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</div>
                            </div>
                        </div>

                        <!-- Status Akun Badge -->
                        @if($user->is_active)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex-shrink-0">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 flex-shrink-0">
                                Suspended
                            </span>
                        @endif
                    </div>

                    <!-- Meta Details & Badges -->
                    <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-100 dark:border-slate-800/80 text-[10px]">
                        <div class="flex items-center gap-2 text-slate-500 font-mono">
                            <span>👥 {{ $user->contacts_count }}</span>
                            <span>🤝 {{ $user->meetings_count }}</span>
                            <span>📅 {{ $user->created_at ? $user->created_at->format('d/m/y') : '-' }}</span>
                        </div>

                        <div>
                            @if($user->aiSetting && $user->aiSetting->is_verified)
                                <span class="text-emerald-600 dark:text-emerald-400 font-mono font-bold">AI Aktif</span>
                            @elseif($user->aiSetting && !empty($user->aiSetting->api_key))
                                <span class="text-amber-600 dark:text-amber-400 font-mono font-bold">AI Tersimpan</span>
                            @else
                                <span class="text-slate-400 font-mono">AI Belum</span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Button (Mobile) -->
                    @if(!($user->id === auth()->id() || $user->isAdmin()))
                        <div class="pt-1">
                            @if($user->is_active)
                                <button 
                                    type="button" 
                                    wire:click="toggleUserStatus({{ $user->id }})" 
                                    wire:confirm="Yakin ingin menonaktifkan akun {{ $user->name }}?" 
                                    class="w-full py-2 rounded-xl bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 font-bold text-xs flex items-center justify-center gap-2 transition"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    <span>Suspend Pengguna</span>
                                </button>
                            @else
                                <button 
                                    type="button" 
                                    wire:click="toggleUserStatus({{ $user->id }})" 
                                    class="w-full py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-bold text-xs flex items-center justify-center gap-2 transition"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Aktifkan Akun</span>
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-slate-500 dark:text-slate-400">
                    <div class="text-xs font-bold">Tidak ada pengguna ditemukan</div>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
