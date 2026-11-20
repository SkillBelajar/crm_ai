<x-app-layout header="Panel Administrator MindControl">
    <div class="space-y-8">
        <!-- Admin Header Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-6 sm:p-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                            Superadmin Access
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-rose-500/20 text-rose-300 border border-rose-400/30">
                            Strict Role Protection
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Pusat Kendali Pengguna &amp; Infrastruktur
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 max-w-2xl leading-relaxed">
                        Kelola akun pengguna, status aktivasi, dan pantau infrastruktur komputasi Octane, MySQL, serta cluster sesi Redis.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/system-health" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md transition">
                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                        <span>Cek Diagnostik Sistem</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Pengguna -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Pengguna</span>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono mt-2">
                    {{ $totalUsers ?? 0 }}
                </div>
                <div class="text-[11px] text-slate-400 mt-1">Akun terdaftar di database</div>
            </div>

            <!-- User Aktif -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Pengguna Aktif</span>
                <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono mt-2">
                    {{ $activeUsers ?? 0 }}
                </div>
                <div class="text-[11px] text-emerald-600/70 dark:text-emerald-400/70 mt-1">Status `is_active: true`</div>
            </div>

            <!-- Admin Aktif -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Admin Aktif</span>
                <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 font-mono mt-2">
                    {{ $adminUsers ?? 0 }}
                </div>
                <div class="text-[11px] text-indigo-500/70 mt-1">Hak akses superadmin</div>
            </div>

            <!-- Driver Session Redis -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Driver Sesi</span>
                <div class="text-2xl font-extrabold text-violet-600 dark:text-violet-400 font-mono mt-2 uppercase">
                    {{ config('session.driver') }}
                </div>
                <div class="text-[11px] text-slate-400 mt-1">Session store terdistribusi</div>
            </div>
        </div>

        <!-- Tabel Pengguna Ringkas -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Daftar Pengguna Sistem</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Semua akun yang terdaftar dalam database `crm_psikologis`.</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-mono font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                    Total: {{ count($users ?? []) }} Akun
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-950/50 text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">Nama &amp; Email</th>
                            <th class="px-6 py-3.5">Role</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 font-sans">
                        @forelse ($users ?? [] as $user)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                    <div class="text-slate-500 dark:text-slate-400 font-mono text-[11px]">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-mono font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 font-mono text-[11px]">
                                    {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    Belum ada pengguna terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
