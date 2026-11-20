<div class="space-y-6">
    <!-- BREADCRUMB & BACK BUTTON -->
    <div class="flex items-center space-x-2 text-xs text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('meetings') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Daftar Sesi
        </a>
        <span>/</span>
        <span class="text-zinc-900 dark:text-white font-medium truncate max-w-xs">{{ $meeting->title }}</span>
    </div>

    <!-- MAIN HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs">
        <div class="space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $meeting->status_badge_class }}">
                    {{ $meeting->status_label }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium border {{ $deadlineInfo['badge'] }}">
                    <svg class="w-3.5 h-3.5 mr-1 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $deadlineInfo['label'] }}
                </span>
                <span class="text-xs text-zinc-400">•</span>
                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                    Tgl: {{ $meeting->meeting_date ? $meeting->meeting_date->format('d M Y, H:i') : '-' }}
                </span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                {{ $meeting->title }}
            </h1>

            <div class="flex items-center space-x-2 text-sm text-zinc-600 dark:text-zinc-300">
                <span>Lawan Bicara:</span>
                <a href="{{ route('contacts.show', $meeting->contact_id) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                    {{ $meeting->contact?->name }}
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                @if ($meeting->contact?->role_or_company)
                    <span class="text-zinc-400">({{ $meeting->contact->role_or_company }})</span>
                @endif
            </div>
        </div>

        <!-- Quick Status Control -->
        <div class="flex items-center space-x-2 self-start lg:self-auto">
            <span class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">Ubah Status:</span>
            <select
                wire:change="updateStatus($event.target.value)"
                class="px-3 py-1.5 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-xs font-semibold text-zinc-700 dark:text-zinc-200 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
            >
                <option value="draft" @selected($status === 'draft')>Draft (Menyusun Strategi)</option>
                <option value="sent" @selected($status === 'sent')>Sudah Dikirim (Menunggu Respon)</option>
                <option value="committed" @selected($status === 'committed')>Komitmen Tercapai (Deal/Action Done)</option>
                <option value="failed" @selected($status === 'failed')>Batal / Gagal</option>
            </select>
        </div>
    </div>

    <!-- FLASH FEEDBACK TOAST -->
    @if ($feedbackMessage)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            class="p-4 rounded-xl text-sm flex items-center justify-between transition-all {{ $feedbackType === 'success' ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400' : 'bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400' }}"
        >
            <div class="flex items-center space-x-2">
                @if ($feedbackType === 'success')
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                @else
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button @click="show = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- STEPPER TABS: 3 MISI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <!-- TAB 1 -->
        <button
            wire:click="setTab('misi-1')"
            type="button"
            class="p-4 rounded-2xl text-left border transition-all relative overflow-hidden {{ $activeTab === 'misi-1' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-600/20' : 'bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-800 hover:border-indigo-300 dark:hover:border-zinc-700' }}"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider {{ $activeTab === 'misi-1' ? 'text-indigo-200' : 'text-indigo-600 dark:text-indigo-400' }}">
                    Langkah 1
                </span>
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $activeTab === 'misi-1' ? 'bg-white/20 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}">
                    1
                </span>
            </div>
            <h3 class="font-bold text-base mt-1 {{ $activeTab === 'misi-1' ? 'text-white' : 'text-zinc-900 dark:text-white' }}">
                Misi 1: Pancing & Catat
            </h3>
            <p class="text-xs mt-0.5 line-clamp-1 {{ $activeTab === 'misi-1' ? 'text-indigo-100' : 'text-zinc-500 dark:text-zinc-400' }}">
                Dengarkan 80% & gali 1 kebutuhan terbesar
            </p>
        </button>

        <!-- TAB 2 -->
        <button
            wire:click="setTab('misi-2')"
            type="button"
            class="p-4 rounded-2xl text-left border transition-all relative overflow-hidden {{ $activeTab === 'misi-2' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-600/20' : 'bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-800 hover:border-indigo-300 dark:hover:border-zinc-700' }}"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider {{ $activeTab === 'misi-2' ? 'text-indigo-200' : 'text-emerald-600 dark:text-emerald-400' }}">
                    Langkah 2 • AI Engine
                </span>
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $activeTab === 'misi-2' ? 'bg-white/20 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}">
                    2
                </span>
            </div>
            <h3 class="font-bold text-base mt-1 {{ $activeTab === 'misi-2' ? 'text-white' : 'text-zinc-900 dark:text-white' }}">
                Misi 2: Filtrasi Anti-Lilin
            </h3>
            <p class="text-xs mt-0.5 line-clamp-1 {{ $activeTab === 'misi-2' ? 'text-indigo-100' : 'text-zinc-500 dark:text-zinc-400' }}">
                Rumuskan formula "Conditional Yes" via AI
            </p>
        </button>

        <!-- TAB 3 -->
        <button
            wire:click="setTab('misi-3')"
            type="button"
            class="p-4 rounded-2xl text-left border transition-all relative overflow-hidden {{ $activeTab === 'misi-3' ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-600/20' : 'bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-800 hover:border-indigo-300 dark:hover:border-zinc-700' }}"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider {{ $activeTab === 'misi-3' ? 'text-indigo-200' : 'text-amber-600 dark:text-amber-400' }}">
                    Langkah 3 • Eksekusi 24 Jam
                </span>
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $activeTab === 'misi-3' ? 'bg-white/20 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}">
                    3
                </span>
            </div>
            <h3 class="font-bold text-base mt-1 {{ $activeTab === 'misi-3' ? 'text-white' : 'text-zinc-900 dark:text-white' }}">
                Misi 3: Kontrak 24 Jam
            </h3>
            <p class="text-xs mt-0.5 line-clamp-1 {{ $activeTab === 'misi-3' ? 'text-indigo-100' : 'text-zinc-500 dark:text-zinc-400' }}">
                Kunci kesepakatan internal selagi momentum hangat
            </p>
        </button>
    </div>

    <!-- TAB 1 PANEL: MISI 1 (PANCING & CATAT) -->
    @if ($activeTab === 'misi-1')
        <div class="space-y-6">
            <!-- PHILOSOPHY & PROFILE BANNER -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Kontak Profile Snapshot -->
                <div class="p-5 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-base">
                                {{ strtoupper(substr($meeting->contact?->name ?? 'K', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-zinc-900 dark:text-white text-sm">
                                    {{ $meeting->contact?->name }}
                                </h4>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $meeting->contact?->role_or_company ?: 'Relasi' }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between py-1 border-b border-zinc-100 dark:border-zinc-800">
                                <span class="text-zinc-400">Kategori:</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $meeting->contact?->category_label }}</span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-zinc-100 dark:border-zinc-800">
                                <span class="text-zinc-400">Kontak:</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $meeting->contact?->phone_or_contact ?: '-' }}</span>
                            </div>
                            <div class="py-1">
                                <span class="text-zinc-400 block mb-0.5">Pemicu Ego (Ego Trigger):</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300 italic">
                                    “{{ $meeting->contact?->ego_trigger ?: 'Diakui keahliannya & dihormati keputusannya' }}”
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contacts.show', $meeting->contact_id) }}" target="_blank" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center mt-3 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                        Buka Profil Kontak Lengkap &rarr;
                    </a>
                </div>

                <!-- Philosophy Box -->
                <div class="lg:col-span-2 p-5 bg-linear-to-br from-indigo-50 to-white dark:from-zinc-900 dark:to-zinc-900/60 rounded-2xl border border-indigo-100 dark:border-zinc-800 shadow-xs flex flex-col justify-center">
                    <div class="flex items-start space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 dark:text-white text-sm">
                                Protokol Misi 1: Pancing Bicara 80%, Dengarkan & Catat
                            </h4>
                            <p class="text-xs text-zinc-600 dark:text-zinc-300 mt-1 leading-relaxed">
                                Jangan terburu-buru menawarkan solusi atau mendominasi percakapan. Validasi emosi mereka, pancing mereka bercerita tentang ambisi, kesulitan, atau harapan mereka. Temukan <strong>1 hal psikologis terbesar</strong> yang menggerakkan mereka — itulah tuas kendali negosiasi Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM CATATAN MISI 1 -->
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-5">
                <div class="border-b border-zinc-200 dark:border-zinc-800 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-zinc-900 dark:text-white text-base">
                            Lembar Catatan Aktif (Elicitation Logger)
                        </h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Simpan data kunci sebelum merumuskan strategi AI pada Misi 2.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Judul Pertemuan -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                            Judul / Topik Pertemuan *
                        </label>
                        <input
                            type="text"
                            wire:model="title"
                            class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
                        />
                        @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 1 Kebutuhan Terbesar Lawan Bicara (Misi 1 Utama) -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                                1 Kebutuhan Psikologis Terbesar Lawan Bicara *
                            </label>
                            <span class="text-[10px] bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-full font-semibold">Misi 1 Utama</span>
                        </div>
                        <textarea
                            wire:model="biggest_need"
                            rows="4"
                            placeholder="Apa kebutuhan/ambisi terbesar yang terucap dari mereka? Contoh: Ingin dianggap inovatif di depan pimpinan, butuh garansi tidak ada komplain dari direksi, dsb."
                            class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 leading-relaxed"
                        ></textarea>
                        @error('biggest_need') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Target / Tujuan Utama Pengguna -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                Target / Hasil Akhir yang Anda Inginkan *
                            </label>
                            <span class="text-[10px] bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded-full font-semibold">Tujuan Anda</span>
                        </div>
                        <textarea
                            wire:model="user_goal"
                            rows="4"
                            placeholder="Apa target konkret yang Anda harapkan dari hubungan/proyek ini? Contoh: Fee DP 50% di muka, penandatanganan MOU minggu ini, pembagian beban kerja yang adil, dsb."
                            class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 leading-relaxed"
                        ></textarea>
                        @error('user_goal') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Validasi Ego / Hal yang Dihargai -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                            Poin Validasi Ego (Hal yang Membuat Mereka Bangga)
                        </label>
                        <input
                            type="text"
                            wire:model="ego_validation_note"
                            placeholder="Contoh: Sangat berpengalaman di bidangnya, memiliki tim yang solid"
                            class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
                        />
                    </div>

                    <!-- Konteks Pertemuan / Catatan Tambahan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                            Konteks Pertemuan / Catatan Situasi
                        </label>
                        <input
                            type="text"
                            wire:model="context_notes"
                            placeholder="Contoh: Bertemu di cafe, suasana santai tapi ada tekanan deadline kantor mereka"
                            class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
                        />
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <button
                        wire:click="saveMisi1"
                        type="button"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                    >
                        Simpan Catatan Misi 1
                    </button>

                    <button
                        wire:click="saveMisi1AndProceed"
                        type="button"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm shadow-indigo-600/20 transition-all"
                    >
                        <span>Simpan & Lanjut ke Misi 2 (AI Filtrasi Anti-Lilin)</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 2 PANEL: MISI 2 (FILTRASI ANTI-LILIN AI ENGINE) -->
    @if ($activeTab === 'misi-2')
        <div class="space-y-6">
            <!-- ANTI-BURN OUT PRINCIPLE BANNER -->
            <div class="p-5 bg-linear-to-r from-emerald-500/10 via-teal-500/10 to-indigo-500/10 rounded-2xl border border-emerald-500/20 shadow-xs">
                <div class="flex items-start space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-zinc-900 dark:text-white text-sm">
                            Prinsip Filtrasi Anti-Lilin: Jangan Pernah Membakar Diri Sendiri
                        </h4>
                        <p class="text-xs text-zinc-600 dark:text-zinc-300 mt-1 leading-relaxed">
                            Banyak orang gagal dalam negosiasi karena mereka langsung menyanggupi dan menanggung beban kerja sendirian (menjadi lilin yang meleleh). Dengan rumus <strong>Conditional Yes</strong>: Validasi ego mereka terlebih dahulu ("Tentu, ide luar biasa!"), lalu kunci dengan syarat tindakan konkret ("Bisa, asalkan Anda menyelesaikan data X terlebih dahulu sebelum besok").
                        </p>
                    </div>
                </div>
            </div>

            <!-- AI TRIGGER CARD -->
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-zinc-900 dark:text-white text-base flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                            AI Persuasi: Generator 3 Variasi Conditional Yes
                        </h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            AI akan menganalisis Misi 1 Anda dan merumuskan opsi kalimat siap pakai (Santai, Profesional, Tegas).
                        </p>
                    </div>

                    <button
                        wire:click="generateConditionalYes"
                        type="button"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-500 shadow-sm shadow-emerald-600/20 transition-all disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="generateConditionalYes" class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Rumuskan Kalimat via AI
                        </span>
                        <span wire:loading wire:target="generateConditionalYes" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            AI Sedang Menganalisis...
                        </span>
                    </button>
                </div>

                @if ($conditionalYesError)
                    <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-xs flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="font-semibold">{{ $conditionalYesError }}</p>
                            <a href="{{ route('ai-settings') }}" class="underline font-bold mt-1 inline-block">Buka Pengaturan AI Mandiri (BYOK) &rarr;</a>
                        </div>
                    </div>
                @endif

                <!-- AI Response Display (if available) -->
                @if ($conditionalYesRawAiResponse)
                    <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                Rekomendasi Opsi dari AI:
                            </span>
                            <span class="text-[11px] text-zinc-400">Pilih atau salin opsi terbaik ke editor di bawah</span>
                        </div>
                        <div class="text-xs text-zinc-800 dark:text-zinc-200 whitespace-pre-wrap leading-relaxed font-sans bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 max-h-96 overflow-y-auto">
{{ $conditionalYesRawAiResponse }}
                        </div>
                    </div>
                @endif

                <!-- Form Editor Strategi yang Dipilih -->
                <div class="pt-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                        Kalimat & Strategi "Conditional Yes" yang Anda Sepakati / Pilih:
                    </label>
                    <textarea
                        wire:model="ai_conditional_yes"
                        rows="4"
                        placeholder="Tuliskan atau sesuaikan kalimat Conditional Yes yang Anda gunakan pada sesi ini... Contoh: 'Tentu kami sangat senang bisa membantu proyek ini. Agar hasilnya maksimal, mohon kirimkan draf materi mentah dari tim Anda paling lambat hari Selasa pukul 15.00.'"
                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 leading-relaxed font-medium"
                    >{{ $ai_conditional_yes }}</textarea>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <button
                        wire:click="saveConditionalYes"
                        type="button"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                    >
                        Simpan Strategi Misi 2
                    </button>

                    <button
                        wire:click="saveMisi2AndProceed"
                        type="button"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm shadow-indigo-600/20 transition-all"
                    >
                        <span>Lanjut ke Misi 3 (Kontrak 24 Jam)</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 3 PANEL: MISI 3 (KONTRAK PSIKOLOGIS 24 JAM) -->
    @if ($activeTab === 'misi-3')
        <div class="space-y-6">
            <!-- 24-HOUR MOMENTUM BANNER & COUNTDOWN -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Countdown Card -->
                <div class="p-5 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="text-[11px] uppercase font-bold tracking-wider text-amber-600 dark:text-amber-400 mb-1">
                            Batas Waktu Penguncian
                        </div>
                        <h4 class="text-xl font-extrabold text-zinc-900 dark:text-white">
                            {{ $deadlineInfo['label'] }}
                        </h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                            Tenggat: {{ $meeting->contract_deadline_at ? $meeting->contract_deadline_at->format('d M Y, H:i') : '-' }} WIB
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $deadlineInfo['badge'] }}">
                            Status: {{ $deadlineInfo['status'] === 'active' ? 'Aktif (Segera Kirim)' : 'Waktu Habis / Lewat' }}
                        </span>
                    </div>
                </div>

                <!-- Guidance Box -->
                <div class="md:col-span-2 p-5 bg-linear-to-r from-amber-500/10 via-orange-500/10 to-indigo-500/10 rounded-2xl border border-amber-500/20 shadow-xs flex flex-col justify-center">
                    <div class="flex items-start space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 dark:text-white text-sm">
                                Protokol Misi 3: Kunci Kontrak Psikologis Dalam 24 Jam
                            </h4>
                            <p class="text-xs text-zinc-600 dark:text-zinc-300 mt-1 leading-relaxed">
                                Kirimkan pesan tindak lanjut internal dalam kurun waktu 24 jam. Pesan ini bukan sekadar ucapan terima kasih, melainkan <strong>kontrak psikologis</strong> yang merefleksikan 1 kebutuhan terbesar mereka dan menegaskan kembali langkah nyata yang disepakati untuk mereka kerjakan terlebih dahulu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI CONTRACT GENERATOR & EDITOR -->
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xs space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-zinc-900 dark:text-white text-base flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                            Draf Pesan Kontrak Psikologis (Siap Kirim WA/Email)
                        </h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            Susun draf pesan otomatis berdasarkan kesepakatan Misi 1 & Misi 2 Anda.
                        </p>
                    </div>

                    <button
                        wire:click="generateContract"
                        type="button"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-amber-600 hover:bg-amber-500 shadow-sm shadow-amber-600/20 transition-all disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="generateContract" class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Susun Draf Kontrak via AI
                        </span>
                        <span wire:loading wire:target="generateContract" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            AI Sedang Menyusun Pesan...
                        </span>
                    </button>
                </div>

                @if ($contractError)
                    <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 text-xs flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="font-semibold">{{ $contractError }}</p>
                            <a href="{{ route('ai-settings') }}" class="underline font-bold mt-1 inline-block">Buka Pengaturan AI Mandiri (BYOK) &rarr;</a>
                        </div>
                    </div>
                @endif

                <!-- Contract Textarea Editor -->
                <div x-data="{
                    copied: false,
                    copyText() {
                        const el = document.getElementById('contract_text');
                        if (el) {
                            navigator.clipboard.writeText(el.value);
                            this.copied = true;
                            setTimeout(() => this.copied = false, 3000);
                        }
                    }
                }" class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
                            Isi Pesan Kontrak Psikologis:
                        </label>

                        <div class="flex items-center space-x-2">
                            <button
                                @click="copyText"
                                type="button"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                            >
                                <svg x-show="!copied" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                <svg x-show="copied" class="w-3.5 h-3.5 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span x-text="copied ? 'Tersalin ke Clipboard!' : 'Salin Pesan'"></span>
                            </button>

                            @if (!empty($meeting->contact?->phone_or_contact))
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $meeting->contact->phone_or_contact);
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                @endphp
                                <a
                                    href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($ai_psychological_contract ?? '') }}"
                                    target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500 text-white hover:bg-emerald-600 transition-colors"
                                >
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    Buka WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    <textarea
                        id="contract_text"
                        wire:model="ai_psychological_contract"
                        rows="8"
                        placeholder="Draf pesan tindak lanjut internal yang merangkum kesepakatan 24 jam..."
                        class="w-full px-3.5 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-amber-500 leading-relaxed font-sans"
                    >{{ $ai_psychological_contract }}</textarea>
                </div>

                <!-- TRACKING KOMITMEN & STATUS -->
                <div class="p-5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700 space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
                        Pelacakan Status & Hasil Komitmen
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">
                                Status Pelaksanaan Sesi:
                            </label>
                            <select
                                wire:model="status"
                                class="w-full px-3.5 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm font-semibold text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
                            >
                                <option value="draft">Draft (Menyusun Strategi)</option>
                                <option value="sent">Sudah Dikirim (Menunggu Respon)</option>
                                <option value="committed">Komitmen Tercapai (Deal/Action Done)</option>
                                <option value="failed">Batal / Gagal</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">
                                Catatan Hasil Komitmen:
                            </label>
                            <input
                                type="text"
                                wire:model="commitment_result"
                                placeholder="Contoh: Lawan bicara sudah kirim draf data awal, lanjut rapat teknis minggu depan"
                                class="w-full px-3.5 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-900 dark:text-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-end space-x-3">
                    <button
                        wire:click="saveContract"
                        type="button"
                        class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-sm shadow-indigo-600/20 transition-all"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Kontrak & Status Sesi
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
