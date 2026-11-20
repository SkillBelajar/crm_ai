<div class="space-y-8">
    <!-- TOP NOTIFICATION BANNER: CONDITIONAL AI STATUS -->
    @if(!$isAiVerified)
        <div class="relative overflow-hidden rounded-2xl border border-amber-500/30 bg-amber-500/10 dark:bg-amber-950/30 p-4 sm:p-5 text-amber-900 dark:text-amber-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-amber-950 dark:text-amber-100">Endpoint AI Strategist Belum Terhubung</h3>
                    <p class="text-xs text-amber-800/90 dark:text-amber-300/90 leading-relaxed">
                        Konfigurasikan endpoint AI mandiri (BYOK) Anda untuk mengaktifkan perumusan otomatis <em>Conditional Yes</em> (Misi 2) dan draf Kontrak Psikologis 24 Jam (Misi 3).
                    </p>
                </div>
            </div>
            <a href="/ai-settings" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-semibold text-xs shadow-md shadow-amber-600/20 transition flex-shrink-0">
                <span>Atur Endpoint AI Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    @endif

    <!-- EXECUTIVE WELCOME HERO & QUICK ACTIONS -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 text-white p-6 sm:p-8 shadow-xl">
        <!-- Ambient subtle background glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-violet-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                        Pusat Kendali Eksekutif
                    </span>
                    @if($isAiVerified)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            AI Strategist Aktif (Model: {{ $aiModelName }})
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-zinc-500/20 text-zinc-300 border border-zinc-400/30">
                            AI Mandiri Belum Diatur
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat datang, {{ $user->name }}!
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Fokus Smart Goal 7 Hari: Dengarkan 80%, pantau batas kritis 24 jam Misi 3, dan kunci komitmen lawan bicara tanpa menguras energi mental Anda.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-shrink-0">
                <a href="/meetings" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold text-xs shadow-lg shadow-indigo-600/30 transition transform active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Sesi 3 Misi Baru</span>
                </a>
                <a href="/contacts" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 dark:bg-slate-800/80 dark:hover:bg-slate-700/80 text-white font-semibold text-xs border border-white/20 backdrop-blur-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Tambah Kontak</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 KPI CARDS (7-DAY SMART GOAL METRICS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Metric 1: Total Pertemuan 7 Hari -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Pertemuan (7 Hari)</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono">{{ $totalMeetings7Days }}</div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Sesi dibuat 7 hari terakhir.</p>
        </div>

        <!-- Metric 2: Komitmen Tercapai -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Komitmen Tercapai</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">{{ $committed7Days }}</span>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 font-mono">({{ $conversionRate }}% Konversi)</span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Rasio kesepakatan tercapai.</p>
        </div>

        <!-- Metric 3: Menunggu Tindak Lanjut -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Menunggu Tindak Lanjut</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-amber-600 dark:text-amber-400 font-mono">{{ $pendingFollowUpCount }}</div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">&lt; 24 Jam Kritis (Status Draft).</p>
        </div>

        <!-- Metric 4: Total Kontak CRM -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Kontak CRM</span>
                <div class="w-9 h-9 rounded-xl bg-violet-50 dark:bg-violet-950/80 text-violet-600 dark:text-violet-400 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 dark:text-white font-mono">{{ $totalContacts }}</div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Database lawan bicara &amp; stakeholder.</p>
        </div>
    </div>

    <!-- 7-DAY SMART GOAL PROGRESS BAR -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>Smart Goal 7 Hari: Rasio Kunci Komitmen</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-semibold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
                        Target Evaluasi
                    </span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Tingkat keberhasilan sesi yang berhasil diformulasikan atau dikunci (Status Terkirim / Komitmen Tercapai) dalam 7 hari terakhir.
                </p>
            </div>
            <div class="text-right">
                <span class="text-xl font-extrabold font-mono text-slate-900 dark:text-white">{{ $goalProgressPercent }}%</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 block font-mono">({{ $locked7Days }} dari {{ $totalMeetings7Days }} Sesi)</span>
            </div>
        </div>

        <!-- Visual Bar -->
        <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-3 p-0.5 overflow-hidden border border-slate-200 dark:border-slate-700/50">
            <div class="bg-gradient-to-r from-indigo-500 via-violet-500 to-emerald-500 h-full rounded-full transition-all duration-700 ease-out" style="width: {{ max(4, $goalProgressPercent) }}%"></div>
        </div>

        <div class="flex items-center justify-between text-[11px] text-slate-400 font-mono">
            <span>0% (Awal Siklus)</span>
            <span>Target Ideal: &ge; 70%</span>
            <span>100% (Sempurna)</span>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- LEFT COLUMN: 24-HOUR DEADLINE PRIORITIES (MISI 3) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                        <span>Prioritas Batas 24 Jam (Misi 3)</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-mono font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                            {{ $urgentMeetings->count() }} Mendesak
                        </span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Sesi pertemuan draft yang perlu segera disusun kontrak psikologisnya sebelum momentum hilang.
                    </p>
                </div>
                <a href="/meetings" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline flex-shrink-0">
                    Semua Sesi &rarr;
                </a>
            </div>

            <!-- Priority List -->
            @if($urgentMeetings->isNotEmpty())
                <div class="space-y-3">
                    @foreach($urgentMeetings as $meeting)
                        @php
                            $deadline = $meeting->getDeadlineInfo();
                        @endphp
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-xs hover:border-indigo-500/40 transition space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                            {{ $meeting->title }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-semibold border {{ $deadline['badge'] }}">
                                            {{ $deadline['label'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $meeting->contact->name }}</span>
                                        @if($meeting->contact->role_or_company)
                                            <span>&bull;</span>
                                            <span>{{ $meeting->contact->role_or_company }}</span>
                                        @endif
                                    </p>
                                </div>

                                <a href="/meetings/{{ $meeting->id }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/60 dark:hover:bg-indigo-900 text-indigo-600 dark:text-indigo-400 font-semibold text-xs border border-indigo-200 dark:border-indigo-800 transition flex-shrink-0">
                                    <span>Buka Workspace</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            @if($meeting->biggest_need)
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-100 dark:border-slate-800/80 text-xs text-slate-600 dark:text-slate-400 flex items-start gap-2">
                                    <span class="text-[10px] font-mono uppercase font-bold text-indigo-500 dark:text-indigo-400 flex-shrink-0 mt-0.5">Kebutuhan Target:</span>
                                    <span class="line-clamp-1 italic">"{{ $meeting->biggest_need }}"</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Positive Empty State -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">Semua pertemuan sudah ditindaklanjuti!</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto leading-relaxed">
                            Tidak ada sesi draft kritis yang menunggu tindakan 24 jam. Setiap komitmen telah diamankan tepat waktu.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="/meetings" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md shadow-indigo-600/20 transition">
                            <span>+ Mulai Sesi Pertemuan Baru</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: RECENT COMMITMENTS & ACTIVITIES -->
        <div class="lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Aktivitas &amp; Komitmen Terbaru</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Daftar sesi yang telah dikirim atau disepakati.
                    </p>
                </div>
            </div>

            @if($recentActivities->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentActivities as $recent)
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition space-y-2.5">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                            {{ $recent->contact->name }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-semibold {{ $recent->status_badge['class'] ?? 'bg-slate-100 text-slate-700' }}">
                                            {{ $recent->status_badge['label'] ?? ucfirst($recent->status) }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                                        {{ $recent->updated_at->diffForHumans() }}
                                    </p>
                                </div>

                                <a href="/meetings/{{ $recent->id }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition flex-shrink-0">
                                    Lihat &rarr;
                                </a>
                            </div>

                            <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-2 leading-relaxed bg-slate-50 dark:bg-slate-950/40 p-2.5 rounded-xl border border-slate-100 dark:border-slate-800/60">
                                {{ $recent->commitment_result ?: ($recent->user_goal ?: 'Kontrak psikologis terkirim ke lawan bicara.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State for Recent Activities -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 text-center space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">Belum Ada Komitmen Terkunci</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Selesaikan Misi 2 dan 3 pada workspace pertemuan untuk mengunci kesepakatan dan mencatat komitmen.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
