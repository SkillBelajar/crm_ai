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

    <!-- Top Navigation & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('contacts') }}" class="inline-flex items-center space-x-1.5 text-xs font-semibold text-zinc-500 dark:text-zinc-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar Kontak</span>
            </a>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $contact->name }}</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $contact->category_badge_classes }}">
                    {{ $contact->category_label }}
                </span>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                {{ $contact->role_or_company ?: 'Tanpa data jabatan/perusahaan' }}
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <button wire:click="openEditModal"
                    type="button"
                    class="inline-flex items-center space-x-1.5 px-3.5 py-2 text-sm font-medium rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700/60 shadow-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Profil</span>
            </button>

            <a href="{{ route('meetings') }}"
               class="inline-flex items-center space-x-1.5 px-4 py-2 text-sm font-medium rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.01] active:scale-[0.99]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Mulai Sesi 3 Misi</span>
            </a>
        </div>
    </div>

    <!-- Grid: Profil Psikologis & Informasi Kontak -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri / Utama: Kartu Profil Psikologis -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Kartu 1 Kebutuhan Terbesar (Jangkar Misi 1 & 2) -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-500/5 via-white to-indigo-500/5 dark:from-indigo-950/20 dark:via-zinc-900 dark:to-indigo-950/20 border border-indigo-200/80 dark:border-indigo-800/60 shadow-xs space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-base">
                            🎯
                        </div>
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">
                                1 Kebutuhan Psikologis Terbesar (Inti Misi 1)
                            </h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Jangkar utama untuk filtrasi &ldquo;Conditional Yes&rdquo; (Anti-Lilin).
                            </p>
                        </div>
                    </div>
                </div>

                @if ($contact->primary_need)
                    <div class="p-4 rounded-xl bg-white/80 dark:bg-zinc-800/60 border border-indigo-100 dark:border-indigo-900/40 shadow-2xs">
                        <p class="text-base text-zinc-800 dark:text-zinc-100 font-medium leading-relaxed italic">
                            &ldquo;{{ $contact->primary_need }}&rdquo;
                        </p>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-white/50 dark:bg-zinc-800/40 border border-dashed border-zinc-300 dark:border-zinc-700 text-center">
                        <p class="text-sm text-zinc-400 italic">Belum ada catatan kebutuhan terbesar.</p>
                        <button wire:click="openEditModal" class="mt-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                            + Tambah Kebutuhan Terbesar Sekarang
                        </button>
                    </div>
                @endif
            </div>

            <!-- Kartu Pemicu Validasi Ego -->
            <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-500/5 via-white to-emerald-500/5 dark:from-emerald-950/20 dark:via-zinc-900 dark:to-emerald-950/20 border border-emerald-200/80 dark:border-emerald-800/60 shadow-xs space-y-3">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-base">
                        🛡️
                    </div>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-300">
                            Pemicu Validasi Ego (Menit 1–3)
                        </h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Validasi hal ini terlebih dahulu agar resistensi lawan bicara runtuh.
                        </p>
                    </div>
                </div>

                @if ($contact->ego_trigger)
                    <div class="p-4 rounded-xl bg-white/80 dark:bg-zinc-800/60 border border-emerald-100 dark:border-emerald-900/40 shadow-2xs">
                        <p class="text-sm text-zinc-800 dark:text-zinc-100 leading-relaxed">
                            {{ $contact->ego_trigger }}
                        </p>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-white/50 dark:bg-zinc-800/40 border border-dashed border-zinc-300 dark:border-zinc-700 text-center">
                        <p class="text-sm text-zinc-400 italic">Belum ada catatan pemicu ego.</p>
                        <button wire:click="openEditModal" class="mt-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                            + Catat Pemicu Validasi Ego
                        </button>
                    </div>
                @endif
            </div>

            <!-- Section Catatan Tambahan jika ada -->
            @if ($contact->notes)
                <div class="p-6 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-2">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Catatan & Konteks Tambahan
                    </h2>
                    <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed whitespace-pre-line">
                        {{ $contact->notes }}
                    </p>
                </div>
            @endif

            <!-- Section Riwayat Pertemuan (3 Misi) -->
            <div class="p-6 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white">
                            Riwayat Sesi Pertemuan (3 Misi)
                        </h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Log percakapan, taktik AI, dan kontrak psikologis yang pernah dijalankan.
                        </p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                        0 Sesi
                    </span>
                </div>

                <!-- Empty State Riwayat Pertemuan -->
                <div class="py-8 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Belum Ada Sesi Pertemuan</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 max-w-sm mx-auto mt-1 mb-4">
                        Mulai pertemuan dengan <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $contact->name }}</span> untuk mengeksekusi Misi 1, 2, dan 3.
                    </p>
                    <a href="{{ route('meetings') }}"
                       class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-xs shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Mulai Sesi 3 Misi Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan / Sidebar: Detail Ringkasan & Info Kontak -->
        <div class="space-y-6">
            <!-- Kartu Info Kontak Detail -->
            <div class="p-6 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                    Informasi Kontak
                </h3>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-xs text-zinc-400 block mb-0.5">Nama Lengkap</span>
                        <span class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $contact->name }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-zinc-400 block mb-0.5">Jabatan / Instansi</span>
                        <span class="text-zinc-700 dark:text-zinc-300">{{ $contact->role_or_company ?: '—' }}</span>
                    </div>

                    <div>
                        <span class="text-xs text-zinc-400 block mb-0.5">Kategori Hubungan</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border {{ $contact->category_badge_classes }}">
                            {{ $contact->category_label }}
                        </span>
                    </div>

                    <div>
                        <span class="text-xs text-zinc-400 block mb-0.5">Nomor HP / Email</span>
                        <span class="text-zinc-700 dark:text-zinc-300 font-mono text-xs">
                            {{ $contact->phone_or_contact ?: '—' }}
                        </span>
                    </div>

                    <div class="pt-2 border-t border-zinc-100 dark:border-zinc-800 text-[11px] text-zinc-400">
                        Ditambahkan: {{ $contact->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            <!-- Taktik Singkat Pendengar & Pengendali -->
            <div class="p-5 rounded-2xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-800 space-y-3 text-xs">
                <h4 class="font-bold text-zinc-900 dark:text-white flex items-center space-x-1.5">
                    <span>💡 Prinsip 3 Misi</span>
                </h4>
                <ul class="space-y-2 text-zinc-600 dark:text-zinc-400">
                    <li class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold shrink-0">1.</span>
                        <span><strong>Misi 1:</strong> Biarkan mereka bicara 80%, catat kebutuhan terbesar di atas.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold shrink-0">2.</span>
                        <span><strong>Misi 2:</strong> Berikan <em>Conditional Yes</em> agar mereka yang mengambil beban aksi.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="text-indigo-500 font-bold shrink-0">3.</span>
                        <span><strong>Misi 3:</strong> Kunci komitmen dalam 24 jam via pesan tertulis.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT PROFILE KONTAK -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-edit-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="closeEditModal" class="fixed inset-0 bg-zinc-950/70 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-zinc-200 dark:border-zinc-800">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                ✏️
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white" id="modal-edit-title">
                                    Edit Profil Kontak
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Perbarui pemetaan psikologis dan data kontak.
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeEditModal" type="button" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="updateContact">
                        <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="edit_name" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input wire:model="name"
                                       id="edit_name"
                                       type="text"
                                       class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                @error('name')
                                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Row: Jabatan/Perusahaan & Kategori -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_role" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Jabatan / Perusahaan
                                    </label>
                                    <input wire:model="role_or_company"
                                           id="edit_role"
                                           type="text"
                                           class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                </div>

                                <div>
                                    <label for="edit_category" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Kategori Kontak <span class="text-rose-500">*</span>
                                    </label>
                                    <select wire:model="category"
                                            id="edit_category"
                                            class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                        @foreach ($categories as $val => $text)
                                            <option value="{{ $val }}">{{ $text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- No HP / Kontak -->
                            <div>
                                <label for="edit_phone" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Nomor HP / WhatsApp / Email
                                </label>
                                <input wire:model="phone_or_contact"
                                       id="edit_phone"
                                       type="text"
                                       class="w-full px-3.5 py-2.5 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            </div>

                            <!-- 1 Kebutuhan Terbesar -->
                            <div class="p-4 rounded-xl bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 space-y-1.5">
                                <label for="edit_need" class="block text-xs font-bold text-indigo-700 dark:text-indigo-300">
                                    🎯 1 Kebutuhan Psikologis Terbesar
                                </label>
                                <textarea wire:model="primary_need"
                                          id="edit_need"
                                          rows="3"
                                          class="w-full px-3.5 py-2 text-sm rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                            </div>

                            <!-- Pemicu Validasi Ego -->
                            <div class="p-4 rounded-xl bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 space-y-1.5">
                                <label for="edit_ego" class="block text-xs font-bold text-emerald-700 dark:text-emerald-300">
                                    🛡️ Pemicu Validasi Ego
                                </label>
                                <textarea wire:model="ego_trigger"
                                          id="edit_ego"
                                          rows="2"
                                          class="w-full px-3.5 py-2 text-sm rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"></textarea>
                            </div>

                            <!-- Catatan Tambahan -->
                            <div>
                                <label for="edit_notes" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Catatan Tambahan
                                </label>
                                <textarea wire:model="notes"
                                          id="edit_notes"
                                          rows="2"
                                          class="w-full px-3.5 py-2 text-sm rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="p-6 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30 flex items-center justify-end space-x-3">
                            <button wire:click="closeEditModal"
                                    type="button"
                                    class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-xs shadow-indigo-600/30 transition-all cursor-pointer">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
