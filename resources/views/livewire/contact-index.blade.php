<div class="space-y-6">
    <!-- Flash Toast Notification -->
    @if ($successMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-300 flex items-center justify-between shadow-xs transition-all">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">{{ $successMessage }}</span>
            </div>
            <button wire:click="dismissNotification" @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Kontak CRM</h1>
                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                    {{ $totalContacts }} Total
                </span>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Pusat pemetaan profil psikologis & 1 kebutuhan terbesar lawan bicara (Fondasi Misi 1: Pancing & Catat).
            </p>
        </div>
        <div>
            <button wire:click="openCreateModal"
                    type="button"
                    class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Tambah Kontak</span>
            </button>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs">
        <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
            <!-- Search Bar -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search"
                       type="text"
                       placeholder="Cari nama, jabatan, perusahaan, atau kebutuhan utama..."
                       class="w-full pl-10 pr-4 py-2 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                @if ($search !== '')
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>

            <!-- Category Filter -->
            <div class="w-full md:w-56 shrink-0">
                <select wire:model.live="categoryFilter"
                        class="w-full px-3.5 py-2 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            @if ($search !== '' || $categoryFilter !== '')
                <button wire:click="$set('search', ''); $set('categoryFilter', '')"
                        type="button"
                        class="px-3 py-2 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors flex items-center justify-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Contact List Section -->
    @if ($contacts->count() > 0)
        <!-- Desktop Table View (Hidden on mobile) -->
        <div class="hidden md:block rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Lawan Bicara</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">1 Kebutuhan Psikologis Terbesar</th>
                            <th class="py-3.5 px-6">Kontak</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800 text-sm">
                        @foreach ($contacts as $contact)
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40 transition-colors">
                                <!-- Name & Role -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/10 to-emerald-500/10 dark:from-indigo-500/20 dark:to-emerald-500/20 border border-indigo-500/20 flex items-center justify-center font-bold text-sm text-indigo-600 dark:text-indigo-400 shrink-0">
                                            {{ strtoupper(substr($contact->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('contacts.show', $contact) }}" class="font-semibold text-zinc-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                {{ $contact->name }}
                                            </a>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                {{ $contact->role_or_company ?: '—' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category Badge -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $contact->category_badge_classes }}">
                                        {{ $contact->category_label }}
                                    </span>
                                </td>

                                <!-- 1 Primary Need (Psychological Hook) -->
                                <td class="py-4 px-6">
                                    @if ($contact->primary_need)
                                        <div class="max-w-xs xl:max-w-md">
                                            <p class="text-xs text-zinc-700 dark:text-zinc-300 line-clamp-2 italic bg-zinc-100 dark:bg-zinc-800/60 p-2 rounded-lg border border-zinc-200/60 dark:border-zinc-700/60">
                                                &ldquo;{{ $contact->primary_need }}&rdquo;
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-xs text-zinc-400 italic">Belum dipetakan (Misi 1)</span>
                                    @endif
                                </td>

                                <!-- Contact Info -->
                                <td class="py-4 px-6 whitespace-nowrap text-xs text-zinc-600 dark:text-zinc-400">
                                    {{ $contact->phone_or_contact ?: '—' }}
                                </td>

                                <!-- Action Buttons -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <!-- Detail Link -->
                                        <a href="{{ route('contacts.show', $contact) }}"
                                           title="Lihat Detail Profil & 3 Misi"
                                           class="p-1.5 rounded-lg text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Edit Button -->
                                        <button wire:click="openEditModal({{ $contact->id }})"
                                                type="button"
                                                title="Edit Kontak"
                                                class="p-1.5 rounded-lg text-zinc-500 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <button wire:click="confirmDelete({{ $contact->id }})"
                                                type="button"
                                                title="Hapus Kontak"
                                                class="p-1.5 rounded-lg text-zinc-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card List View (Visible only on mobile) -->
        <div class="space-y-3 md:hidden">
            @foreach ($contacts as $contact)
                <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 border border-indigo-500/20 flex items-center justify-center font-bold text-sm text-indigo-600 dark:text-indigo-400 shrink-0">
                                {{ strtoupper(substr($contact->name, 0, 2)) }}
                            </div>
                            <div>
                                <a href="{{ route('contacts.show', $contact) }}" class="font-semibold text-zinc-900 dark:text-white">
                                    {{ $contact->name }}
                                </a>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $contact->role_or_company ?: 'Tanpa Jabatan' }}
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $contact->category_badge_classes }}">
                            {{ $contact->category_label }}
                        </span>
                    </div>

                    @if ($contact->primary_need)
                        <div class="p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200/70 dark:border-zinc-700/70">
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-0.5">
                                🎯 1 Kebutuhan Terbesar:
                            </span>
                            <p class="text-xs text-zinc-700 dark:text-zinc-300 line-clamp-2 italic">
                                &ldquo;{{ $contact->primary_need }}&rdquo;
                            </p>
                        </div>
                    @endif

                    @if ($contact->phone_or_contact)
                        <div class="flex items-center space-x-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $contact->phone_or_contact }}</span>
                        </div>
                    @endif

                    <!-- Mobile Action Buttons -->
                    <div class="pt-2 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between gap-2">
                        <a href="{{ route('contacts.show', $contact) }}"
                           class="flex-1 py-1.5 px-3 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-xs font-medium text-center border border-indigo-200/50 dark:border-indigo-800/50">
                            Detail & Profil
                        </a>
                        <button wire:click="openEditModal({{ $contact->id }})"
                                type="button"
                                class="py-1.5 px-3 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-medium">
                            Edit
                        </button>
                        <button wire:click="confirmDelete({{ $contact->id }})"
                                type="button"
                                class="py-1.5 px-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 text-xs font-medium">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="p-8 sm:p-12 text-center rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>

            @if ($search !== '' || $categoryFilter !== '')
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Tidak Ada Kontak yang Cocok</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mt-1 mb-6">
                    Pencarian dengan kriteria tersebut tidak menemukan hasil. Silakan reset filter pencarian.
                </p>
                <button wire:click="$set('search', ''); $set('categoryFilter', '')"
                        type="button"
                        class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm font-medium transition-colors">
                    <span>Reset Filter</span>
                </button>
            @else
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Belum Ada Kontak Tersimpan</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-md mx-auto mt-1 mb-6">
                    Mulai petakan lawan bicara, klien, atau prospek Anda. Catat 1 kebutuhan terbesar dan pemicu ego mereka untuk membalik kendali percakapan.
                </p>
                <button wire:click="openCreateModal"
                        type="button"
                        class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Tambah Kontak Pertama</span>
                </button>
            @endif
        </div>
    @endif

    <!-- MODAL CREATE / EDIT KONTAK -->
    @if ($showModal)
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div wire:click="closeModal" class="fixed inset-0 bg-zinc-950/75 backdrop-blur-xs transition-opacity"></div>

            <!-- Scrollable & Centering Container -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div wire:click.self="closeModal" class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <!-- Modal Panel -->
                    <div class="relative w-full sm:max-w-xl bg-white dark:bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 border border-zinc-200 dark:border-zinc-800">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                {{ $isEditing ? '✏️' : '👤' }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white" id="modal-title">
                                    {{ $isEditing ? 'Edit Data Kontak' : 'Tambah Kontak Baru' }}
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $isEditing ? 'Perbarui informasi kontak dan pemetaan psikologis.' : 'Masukkan data lawan bicara untuk integrasi 3 Misi CRM.' }}
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeModal" type="button" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body Form -->
                    <form wire:submit="save">
                        <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="form_name" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input wire:model="name"
                                       id="form_name"
                                       type="text"
                                       placeholder="Misal: Bapak Hendra Kurniawan"
                                       class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                @error('name')
                                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Row: Jabatan/Perusahaan & Kategori -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="form_role" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Jabatan / Perusahaan
                                    </label>
                                    <input wire:model="role_or_company"
                                           id="form_role"
                                           type="text"
                                           placeholder="Misal: Direktur PT Maju Jaya"
                                           class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                    @error('role_or_company')
                                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="form_category" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Kategori Kontak <span class="text-rose-500">*</span>
                                    </label>
                                    <select wire:model="category"
                                            id="form_category"
                                            class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                        @foreach ($categories as $val => $text)
                                            <option value="{{ $val }}">{{ $text }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- No HP / Kontak -->
                            <div>
                                <label for="form_phone" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Nomor HP / WhatsApp / Email
                                </label>
                                <input wire:model="phone_or_contact"
                                       id="form_phone"
                                       type="text"
                                       placeholder="Misal: 0812-3456-7890 / hendra@ptmajujaya.com"
                                       class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                @error('phone_or_contact')
                                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Pemetaan Psikologis: 1 Kebutuhan Terbesar -->
                            <div class="p-4 rounded-xl bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 space-y-1.5">
                                <label for="form_need" class="block text-xs font-bold text-indigo-700 dark:text-indigo-300 flex items-center justify-between">
                                    <span class="flex items-center space-x-1.5">
                                        <span>🎯 1 Kebutuhan Psikologis Terbesar (Inti Misi 1)</span>
                                    </span>
                                </label>
                                <p class="text-[11px] text-zinc-500 dark:text-zinc-400">
                                    Apa satu hal paling penting yang ingin mereka capai atau hindari? Ini adalah jangkar kendali Anda.
                                </p>
                                <textarea wire:model="primary_need"
                                          id="form_need"
                                          rows="3"
                                          placeholder="Contoh: Sangat ingin omzet naik 2x lipat sebelum Q3 tanpa menambah beban kerja operasional."
                                          class="w-full px-3.5 py-2 text-sm rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                                @error('primary_need')
                                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Pemetaan Psikologis: Pemicu Validasi Ego -->
                            <div class="p-4 rounded-xl bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 space-y-1.5">
                                <label for="form_ego" class="block text-xs font-bold text-emerald-700 dark:text-emerald-300 flex items-center justify-between">
                                    <span class="flex items-center space-x-1.5">
                                        <span>🛡️ Pemicu Validasi Ego</span>
                                    </span>
                                </label>
                                <p class="text-[11px] text-zinc-500 dark:text-zinc-400">
                                    Hal yang membuat lawan bicara merasa dihormati, diakui kepakarannya, atau merasa paling benar.
                                </p>
                                <textarea wire:model="ego_trigger"
                                          id="form_ego"
                                          rows="2"
                                          placeholder="Contoh: Suka dipuji visi kepemimpinannya dan senang bila idenya dikutip sebagai referensi utama."
                                          class="w-full px-3.5 py-2 text-sm rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"></textarea>
                                @error('ego_trigger')
                                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Catatan Tambahan -->
                            <div>
                                <label for="form_notes" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Catatan Tambahan
                                </label>
                                <textarea wire:model="notes"
                                          id="form_notes"
                                          rows="2"
                                          placeholder="Catatan latar belakang, preferensi waktu bertemu, hobi, dsb."
                                          class="w-full px-3.5 py-2 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                                @error('notes')
                                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="p-6 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30 flex items-center justify-end space-x-3">
                            <button wire:click="closeModal"
                                    type="button"
                                    class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center space-x-2 px-5 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-xs shadow-indigo-600/30 transition-all cursor-pointer disabled:opacity-50">
                                <span wire:loading.remove wire:target="save">
                                    {{ $isEditing ? 'Simpan Perubahan' : 'Tambah Kontak' }}
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center space-x-2">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    <span>Menyimpan...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL DELETE CONFIRMATION -->
    @if ($showDeleteModal)
        <div class="relative z-50" aria-labelledby="modal-delete" role="dialog" aria-modal="true">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white" id="modal-delete">
                                Hapus Kontak?
                            </h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Apakah Anda yakin ingin menghapus kontak <strong class="text-zinc-900 dark:text-white">&ldquo;{{ $contactToDeleteName }}&rdquo;</strong>? Seluruh data psikologis dan riwayat pertemuan terkait akan terhapus.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <button wire:click="cancelDelete"
                                type="button"
                                class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button wire:click="deleteContact"
                                type="button"
                                class="px-4 py-2 text-sm font-medium text-white bg-rose-600 hover:bg-rose-500 rounded-xl shadow-xs shadow-rose-600/30 transition-all cursor-pointer">
                            Ya, Hapus Kontak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
