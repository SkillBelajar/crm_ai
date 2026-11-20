<div class="space-y-6">
    <!-- TOP HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
                    Sistem 3 Misi
                </span>
                <span class="text-xs text-zinc-400">•</span>
                <span class="text-xs text-zinc-500 dark:text-zinc-400">Pancing & Catat &bull; Filtrasi Anti-Lilin &bull; Kontrak 24 Jam</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white mt-1">
                Workspace Sesi Pertemuan
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Kelola setiap sesi negosiasi, rumuskan kalimat <em>Conditional Yes</em> via AI, dan kunci komitmen dalam 24 jam.
            </p>
        </div>

        <div class="flex items-center space-x-3">
            <button
                wire:click="openCreateModal"
                type="button"
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm shadow-indigo-600/20 transition-all focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                + Mulai Sesi 3 Misi Baru
            </button>
        </div>
    </div>

    <!-- FLASH TOAST NOTIFICATION -->
    @if ($successMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-sm flex items-center justify-between transition-all">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $successMessage }}</span>
            </div>
            <button @click="show = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- FILTER & SEARCH BAR -->
    <div class="p-4 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs flex flex-col md:flex-row gap-3">
        <!-- Search -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari judul sesi, nama lawan bicara, atau kebutuhan utama..."
                class="w-full pl-10 pr-4 py-2 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            />
            @if ($search)
                <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <!-- Filter Status -->
            <select
                wire:model.live="statusFilter"
                class="px-3.5 py-2 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-700 dark:text-zinc-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            >
                <option value="">Semua Status</option>
                <option value="draft">Draft (Menyusun Strategi)</option>
                <option value="sent">Sudah Dikirim</option>
                <option value="committed">Komitmen Tercapai</option>
                <option value="failed">Batal / Gagal</option>
            </select>

            <!-- Filter Kontak -->
            <select
                wire:model.live="contactFilter"
                class="px-3.5 py-2 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-700 dark:text-zinc-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all max-w-[180px] truncate"
            >
                <option value="">Semua Kontak</option>
                @foreach ($contacts as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- MEETINGS CONTAINER -->
    @if ($meetings->count() > 0)
        <!-- DESKTOP VIEW: TABEL -->
        <div class="hidden lg:block bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-300">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Judul Sesi & Lawan Bicara</th>
                            <th scope="col" class="px-6 py-3.5">1 Kebutuhan Terbesar (Misi 1)</th>
                            <th scope="col" class="px-6 py-3.5">Batas 24 Jam</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach ($meetings as $meeting)
                            @php
                                $deadlineInfo = $meeting->getDeadlineInfo();
                            @endphp
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                                <!-- Judul Sesi & Kontak -->
                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                                            {{ strtoupper(substr($meeting->contact?->name ?? 'M', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('meetings.show', $meeting->id) }}" class="font-semibold text-zinc-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors block">
                                                {{ $meeting->title }}
                                            </a>
                                            <div class="flex items-center space-x-2 text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                <a href="{{ route('contacts.show', $meeting->contact_id) }}" class="hover:underline flex items-center">
                                                    <span>{{ $meeting->contact?->name ?? 'Kontak Terhapus' }}</span>
                                                    @if ($meeting->contact?->role_or_company)
                                                        <span class="text-zinc-400 ml-1">({{ $meeting->contact->role_or_company }})</span>
                                                    @endif
                                                </a>
                                                <span>•</span>
                                                <span>{{ $meeting->meeting_date ? $meeting->meeting_date->format('d M Y, H:i') : '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- 1 Kebutuhan Terbesar -->
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="text-xs text-zinc-700 dark:text-zinc-300 line-clamp-2 italic">
                                        “{{ $meeting->biggest_need }}”
                                    </p>
                                </td>

                                <!-- Batas 24 Jam -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $deadlineInfo['badge'] }}">
                                        <svg class="w-3.5 h-3.5 mr-1.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $deadlineInfo['label'] }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $meeting->status_badge_class }}">
                                        {{ $meeting->status_label }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a
                                            href="{{ route('meetings.show', $meeting->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors"
                                        >
                                            Buka Workspace
                                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>

                                        <button
                                            wire:click="confirmDelete({{ $meeting->id }})"
                                            type="button"
                                            class="p-1.5 rounded-lg text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors"
                                            title="Hapus Sesi"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                {{ $meetings->links() }}
            </div>
        </div>

        <!-- MOBILE VIEW: CARD LIST -->
        <div class="block lg:hidden space-y-3">
            @foreach ($meetings as $meeting)
                @php
                    $deadlineInfo = $meeting->getDeadlineInfo();
                @endphp
                <div class="p-4 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border {{ $meeting->status_badge_class }}">
                                {{ $meeting->status_label }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium border {{ $deadlineInfo['badge'] }}">
                                {{ $deadlineInfo['label'] }}
                            </span>
                        </div>

                        <button
                            wire:click="confirmDelete({{ $meeting->id }})"
                            class="text-zinc-400 hover:text-rose-500 p-1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div>
                        <a href="{{ route('meetings.show', $meeting->id) }}" class="font-bold text-zinc-900 dark:text-white text-base hover:text-indigo-600 dark:hover:text-indigo-400 block">
                            {{ $meeting->title }}
                        </a>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            Bersama: <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $meeting->contact?->name ?? '-' }}</span>
                            @if ($meeting->contact?->role_or_company)
                                <span class="text-zinc-400">({{ $meeting->contact->role_or_company }})</span>
                            @endif
                        </p>
                    </div>

                    <div class="p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200/60 dark:border-zinc-700/60">
                        <div class="text-[10px] uppercase font-bold tracking-wider text-indigo-600 dark:text-indigo-400">
                            1 Kebutuhan Terbesar:
                        </div>
                        <p class="text-xs text-zinc-700 dark:text-zinc-300 mt-0.5 line-clamp-2 italic">
                            “{{ $meeting->biggest_need }}”
                        </p>
                    </div>

                    <a
                        href="{{ route('meetings.show', $meeting->id) }}"
                        class="w-full inline-flex items-center justify-center py-2 px-4 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-xs transition-colors"
                    >
                        Buka Workspace 3 Misi
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endforeach

            <div class="pt-2">
                {{ $meetings->links() }}
            </div>
        </div>
    @else
        <!-- EMPTY STATE -->
        <div class="text-center py-12 px-4 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>

            @if ($contacts->count() === 0)
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Kontak CRM</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mt-1 mb-5">
                    Anda perlu menambahkan kontak lawan bicara terlebih dahulu sebelum memulai sesi 3 Misi bersama AI.
                </p>
                <a
                    href="{{ route('contacts') }}"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition-colors shadow-sm"
                >
                    + Buat Kontak CRM Pertama
                </a>
            @elseif ($search || $statusFilter || $contactFilter)
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Tidak Ada Sesi yang Cocok</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mt-1 mb-5">
                    Tidak ditemukan sesi pertemuan dengan filter atau kata kunci saat ini.
                </p>
                <button
                    wire:click="$set('search', ''); $set('statusFilter', ''); $set('contactFilter', '')"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-200 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 transition-colors"
                >
                    Reset Filter
                </button>
            @else
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Sesi Pertemuan</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-md mx-auto mt-1 mb-5">
                    Mulai sesi pertemuan pertama Anda: dengarkan 80%, catat 1 kebutuhan terbesar mereka, dan biarkan AI merumuskan strategi <em>Conditional Yes</em>.
                </p>
                <button
                    wire:click="openCreateModal"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition-colors shadow-sm"
                >
                    + Mulai Sesi 3 Misi Baru
                </button>
            @endif
        </div>
    @endif

    <!-- MODAL CREATE QUICK SESSION -->
    @if ($showCreateModal)
        <div class="relative z-50" aria-labelledby="modal-session-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div wire:click="closeCreateModal" class="fixed inset-0 bg-zinc-950/75 backdrop-blur-xs transition-opacity"></div>

            <!-- Scrollable & Centering Container -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div wire:click.self="closeCreateModal" class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <!-- Modal Panel -->
                    <div class="relative w-full sm:max-w-xl bg-white dark:bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 border border-zinc-200 dark:border-zinc-800">
                        <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-zinc-900 dark:text-white" id="modal-session-title">
                                        Mulai Sesi 3 Misi Baru
                                    </h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        Pilih kontak lawan bicara dan siapkan catatan Misi 1.
                                    </p>
                                </div>
                            </div>

                            <button wire:click="closeCreateModal" type="button" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <form wire:submit="createMeeting">
                            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                                <!-- Pilih Kontak -->
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Pilih Lawan Bicara (Kontak CRM) *
                                    </label>
                                    <select
                                        wire:model.live="form_contact_id"
                                        id="form_contact_id"
                                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                        <option value="">-- Pilih Kontak --</option>
                                        @foreach ($contacts as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->role_or_company ?: $c->category_label }})</option>
                                        @endforeach
                                    </select>
                                    @error('form_contact_id')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Judul Sesi -->
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Judul / Topik Pertemuan *
                                    </label>
                                    <input
                                        type="text"
                                        wire:model="form_title"
                                        id="form_title"
                                        placeholder="Contoh: Rapat Kerjasama Distribusi Q4 / Negosiasi Fee"
                                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                    @error('form_title')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- 1 Kebutuhan Terbesar (Misi 1) -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
                                            1 Kebutuhan Terbesar Lawan Bicara *
                                        </label>
                                        <span class="text-[11px] text-indigo-600 dark:text-indigo-400 font-semibold">Misi 1: Pancing & Catat</span>
                                    </div>
                                    <textarea
                                        wire:model="form_biggest_need"
                                        id="form_biggest_need"
                                        rows="2"
                                        placeholder="Apa 1 hal psikologis yang paling mereka inginkan/butuhkan dari pertemuan ini?"
                                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    ></textarea>
                                    @error('form_biggest_need')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Target / Tujuan Anda -->
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Tujuan Utama Anda *
                                    </label>
                                    <textarea
                                        wire:model="form_user_goal"
                                        id="form_user_goal"
                                        rows="2"
                                        placeholder="Apa hasil akhir konkret yang Anda inginkan tanpa Anda kehabisan tenaga?"
                                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    ></textarea>
                                    @error('form_user_goal')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Validasi Ego / Yes (Opsional) -->
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Poin Validasi Ego ("Yes / Setuju") <span class="text-zinc-400 font-normal lowercase">(opsional)</span>
                                    </label>
                                    <input
                                        type="text"
                                        wire:model="form_ego_validation_note"
                                        id="form_ego_validation_note"
                                        placeholder="Contoh: Mengakui keahlian teknis mereka, menghargai status mereka"
                                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>
                            </div>

                            <div class="p-6 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-end space-x-3">
                                <button
                                    wire:click="closeCreateModal"
                                    type="button"
                                    class="px-4 py-2.5 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm shadow-indigo-600/20 transition-all"
                                >
                                    <span>Masuk ke Workspace &rarr;</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL DELETE CONFIRMATION -->
    @if ($showDeleteModal)
        <div class="relative z-50" aria-labelledby="modal-delete-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div wire:click="cancelDelete" class="fixed inset-0 bg-zinc-950/75 backdrop-blur-xs transition-opacity"></div>

            <!-- Scrollable & Centering Container -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div wire:click.self="cancelDelete" class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <!-- Modal Panel -->
                    <div class="relative w-full sm:max-w-md bg-white dark:bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 border border-zinc-200 dark:border-zinc-800 p-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 rounded-xl bg-rose-500/10 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white" id="modal-delete-title">
                                    Hapus Sesi Pertemuan?
                                </h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Seluruh catatan 3 Misi, rekomendasi strategi AI, dan draf kontrak psikologis pada sesi ini akan dihapus secara permanen.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <button
                                wire:click="cancelDelete"
                                type="button"
                                class="px-4 py-2 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                            >
                                Batal
                            </button>
                            <button
                                wire:click="deleteMeeting"
                                type="button"
                                class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-rose-600 hover:bg-rose-500 transition-colors shadow-xs"
                            >
                                Hapus Sesi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
