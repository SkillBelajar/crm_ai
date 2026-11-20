<x-app-layout header="Panduan Pengguna & SOP Strategis">
    <div class="max-w-5xl mx-auto space-y-8" x-data="{
        activeRole: '{{ auth()->user()->isAdmin() ? 'admin' : 'user' }}',
        accordionUser: {
            s1: true,
            s2: true,
            s3: false
        },
        accordionAdmin: {
            a1: true,
            a2: true,
            a3: true
        }
    }">
        <!-- Header Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-6 sm:p-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                            Dokumentasi Taktis
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            Versi: {{ config('app.version') }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Panduan Pengguna &amp; Standard Operating Procedure
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 max-w-2xl leading-relaxed">
                        Kuasai seni diplomasi dan kendali percakapan prospek tanpa menguras energi mental dengan integrasi AI Mandiri (BYOK) dan metode 3 Misi Terstruktur.
                    </p>
                </div>

                <!-- Role Tab Switcher -->
                <div class="flex items-center bg-slate-800/80 p-1.5 rounded-2xl border border-slate-700/80 self-start md:self-auto">
                    <button 
                        @click="activeRole = 'user'"
                        :class="activeRole === 'user' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2"
                        type="button"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Panduan Strategist</span>
                    </button>
                    <button 
                        @click="activeRole = 'admin'"
                        :class="activeRole === 'admin' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2"
                        type="button"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Panduan Admin SaaS</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- PANDUAN STRATEGIST (ROLE: USER)             -->
        <!-- ========================================== -->
        <div x-show="activeRole === 'user'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            
            <!-- SECTION 1: SETUP ENDPOINT AI BYOK -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm transition">
                <button @click="accordionUser.s1 = !accordionUser.s1" class="w-full flex items-center justify-between text-left group" type="button">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/70 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-mono font-bold text-lg">
                            01
                        </div>
                        <div>
                            <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Fondasi Utama</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                Setup Endpoint AI Mandiri (BYOK - Bring Your Own Key)
                            </h2>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="accordionUser.s1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <div x-show="accordionUser.s1" x-collapse class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-4">
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        MindControl CRM tidak menahan atau menjual kuota API Anda. Anda memiliki kedaulatan penuh menghubungkan model AI OpenAI-compatible milik Anda sendiri (OpenAI, Ollama, vLLM, DeepSeek, Local Server, dsb).
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2">
                            <h4 class="text-xs font-mono font-bold uppercase text-slate-500 dark:text-slate-400">Contoh Konfigurasi Mandiri</h4>
                            <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1.5 font-mono">
                                <li><strong class="text-slate-900 dark:text-white">Base URL:</strong> <code>https://api.openai.com/v1</code> (atau server Anda)</li>
                                <li><strong class="text-slate-900 dark:text-white">API Key:</strong> <code>sk-your-secret-api-key</code></li>
                                <li><strong class="text-slate-900 dark:text-white">Model:</strong> <code>gpt-4o-mini</code> atau <code>deepseek-chat</code></li>
                            </ul>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2">
                            <h4 class="text-xs font-mono font-bold uppercase text-slate-500 dark:text-slate-400">Keamanan Enkripsi Kunci</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                Kunci API Anda disimpan di MySQL dengan enkripsi simetris <strong>AES-256-CBC</strong> melalui Laravel Encrypted Cast. Admin maupun pihak ketiga tidak dapat membaca teks mentah kunci Anda.
                            </p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="text-xs font-bold text-indigo-900 dark:text-indigo-200">Verifikasi Koneksi AI</div>
                            <div class="text-xs text-indigo-700 dark:text-indigo-300">Gunakan tombol <em>Test Koneksi AI</em> di modul pengaturan untuk memastikan endpoint merespons dengan status 200 OK.</div>
                        </div>
                        <a href="/ai-settings" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition shadow-sm self-start sm:self-auto whitespace-nowrap">
                            <span>Atur Endpoint AI Sekarang</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: METODE 3 MISI -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm transition">
                <button @click="accordionUser.s2 = !accordionUser.s2" class="w-full flex items-center justify-between text-left group" type="button">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-mono font-bold text-lg">
                            02
                        </div>
                        <div>
                            <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Eksekusi Taktis</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">
                                Praktik 3 Misi "Pendengar &amp; Pengendali"
                            </h2>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="accordionUser.s2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <div x-show="accordionUser.s2" x-collapse class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Misi 1 -->
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                    Misi 01
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">Menit 1–3</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Pancing &amp; Catat (80%)</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                Biarkan lawan bicara mendominasi 80% durasi pembicaraan. Tangkap pemicu validasi ego mereka dan catat <strong>1 Kebutuhan Psikologis Terbesar</strong> mereka langsung dari ponsel.
                            </p>
                            <div class="pt-2 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                💡 Kunci: Jangan interupsi. Biarkan mereka merasa berkuasa sebelum Anda mengarahkan tujuan Anda.
                            </div>
                        </div>

                        <!-- Misi 2 -->
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-violet-100 dark:bg-violet-950 text-violet-600 dark:text-violet-400 border border-violet-200 dark:border-violet-800">
                                    Misi 02
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">Filtrasi Anti-Lilin</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Conditional Yes Engine</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                Jangan menjadi lilin yang mengorbankan diri demi orang lain. Klik tombol <strong>Generate Strategi AI</strong> untuk mendapatkan opsi kalimat persetujuan bersyarat yang mewajibkan pihak mereka bergerak lebih dahulu.
                            </p>
                            <div class="pt-2 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                💡 Rumus: <em>"Kami siap memprioritaskan X untuk Anda, begitu data Y diserahkan oleh tim Anda."</em>
                            </div>
                        </div>

                        <!-- Misi 3 -->
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    Misi 03
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">Jendela 24 Jam</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Kunci Kontrak Psikologis</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                Manfaatkan tombol <strong>1-Click Copy</strong> atau <strong>Kirim via WhatsApp</strong> untuk mengunci komitmen mereka sebelum mendingin dalam rentang emas 24 jam.
                            </p>
                            <div class="pt-2 text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                💡 Efek: Menutup celah ingkar janji secara sopan dan terhormat.
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <a href="/meetings" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white text-xs font-bold transition shadow-sm">
                            <span>Buka Workspace Sesi Pertemuan</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: SMART GOAL 7 HARI -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm transition">
                <button @click="accordionUser.s3 = !accordionUser.s3" class="w-full flex items-center justify-between text-left group" type="button">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/70 border border-amber-200 dark:border-amber-800 text-amber-600 dark:text-amber-400 flex items-center justify-center font-mono font-bold text-lg">
                            03
                        </div>
                        <div>
                            <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Evaluasi Berkala</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition">
                                Memantau Smart Goal 7 Hari &amp; Prioritas Kritis
                            </h2>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="accordionUser.s3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <div x-show="accordionUser.s3" x-collapse class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-4">
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Halaman <strong>Dashboard</strong> menyajikan metrik performa 7 hari terakhir secara otomatis untuk memastikan tidak ada prospek yang terbengkalai:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Total Pertemuan</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Volume sesi interaksi baru dalam siklus 7 hari.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                            <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Komitmen Tercapai</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Persentase konversi sesi menjadi komitmen nyata.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                            <div class="text-xs font-bold text-amber-600 dark:text-amber-400">Menunggu Tindak Lanjut</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Sesi draft yang mendekati atau melewati batas 24 jam.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                            <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400">Total Kontak CRM</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Seluruh profil psikologis lawan bicara yang tersimpan.</div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 text-xs text-amber-800 dark:text-amber-300">
                        <strong>Daftar Prioritas 24 Jam:</strong> Pantau widget daftar prioritas di dashboard setiap pagi. Label berkedip <span class="font-bold text-rose-600 dark:text-rose-400">Rose/Merah</span> menandakan sesi telah melewati batas 24 jam dan harus segera ditindaklanjuti sebelum komitmen menguap.
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- PANDUAN ADMIN SAAS (ROLE: ADMIN)            -->
        <!-- ========================================== -->
        <div x-show="activeRole === 'admin'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            
            <!-- ADMIN SECTION 1: MANAJEMEN PENGGUNA -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm transition">
                <button @click="accordionAdmin.a1 = !accordionAdmin.a1" class="w-full flex items-center justify-between text-left group" type="button">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/70 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-mono font-bold text-lg">
                            A1
                        </div>
                        <div>
                            <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Kontrol Akun</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                Manajemen Pengguna &amp; Proteksi Status Akun
                            </h2>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="accordionAdmin.a1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <div x-show="accordionAdmin.a1" x-collapse class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-4">
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Melalui <strong>Panel Admin SaaS (`/admin`)</strong>, administrator dapat memantau seluruh pengguna terdaftar, memeriksa keaktifan akun, dan melakukan tindakan penghentian (*suspend*) akun secara instan:
                    </p>

                    <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-2 list-disc list-inside">
                        <li><strong>Pencarian Real-time:</strong> Temukan pengguna berdasarkan nama atau alamat email dengan debounce instan 300ms.</li>
                        <li><strong>Filter Status:</strong> Saring daftar pengguna berdasarkan status (Semua, Aktif, atau Suspended).</li>
                        <li><strong>Toggle Status Suspend / Aktifkan:</strong> Administrator dapat menonaktifkan pengguna yang melanggar ketentuan tanpa menghapus database mereka. Pengguna dengan status <code>is_active = false</code> langsung ditolak saat mencoba login.</li>
                        <li><strong>Proteksi Superadmin:</strong> Akun administrator terlindungi secara permanen — sistem secara otomatis mencegah penonaktifan diri sendiri atau sesama role admin.</li>
                    </ul>

                    <div class="pt-2 flex justify-start">
                        <a href="/admin" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition shadow-sm">
                            <span>Buka Panel Admin SaaS</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ADMIN SECTION 2: PEMANTAUAN KESEHATAN SISTEM -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm transition">
                <button @click="accordionAdmin.a2 = !accordionAdmin.a2" class="w-full flex items-center justify-between text-left group" type="button">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-mono font-bold text-lg">
                            A2
                        </div>
                        <div>
                            <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Infrastruktur</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">
                                Pemantauan Arsitektur &amp; Diagnostik Sistem
                            </h2>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="accordionAdmin.a2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <div x-show="accordionAdmin.a2" x-collapse class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-4">
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Platform MindControl CRM dibangun di atas tumpukan teknologi modern berkinerja tinggi untuk memastikan keandalan tinggi dan latency rendah:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">Laravel Octane (PHP 8.4)</div>
                            <div class="text-xs text-slate-600 dark:text-slate-300">Aplikasi di-keep di RAM menggunakan FrankenPHP worker untuk waktu respon sub-milidetik.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400">MySQL 8.0 Persisten</div>
                            <div class="text-xs text-slate-600 dark:text-slate-300">Menyimpan data multi-tenant terisolasi, kontak, dan riwayat 3 Misi.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-mono font-bold text-rose-600 dark:text-rose-400">Redis 7 Alpine</div>
                            <div class="text-xs text-slate-600 dark:text-slate-300">Mengelola cache sistem, antrean asinkron, dan distributed sessions.</div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-start">
                        <a href="/system-health" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white text-xs font-bold transition shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Periksa Diagnostik Sistem (/system-health)</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ADMIN SECTION 3: PRIVASI & KEAMANAN BYOK -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm transition">
                <button @click="accordionAdmin.a3 = !accordionAdmin.a3" class="w-full flex items-center justify-between text-left group" type="button">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 dark:bg-violet-950/70 border border-violet-200 dark:border-violet-800 text-violet-600 dark:text-violet-400 flex items-center justify-center font-mono font-bold text-lg">
                            A3
                        </div>
                        <div>
                            <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-violet-600 dark:text-violet-400">Tata Kelola Data</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition">
                                Kebijakan Privasi Kunci AI Mandiri (BYOK)
                            </h2>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 transition group-hover:bg-slate-200 dark:group-hover:bg-slate-700">
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="accordionAdmin.a3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>

                <div x-show="accordionAdmin.a3" x-collapse class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-4">
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Sebagai administrator SaaS, prinsip <em>Zero-Knowledge API Key Storage</em> wajib dijaga untuk membangun kepercayaan pengguna:
                    </p>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2 text-xs text-slate-600 dark:text-slate-300">
                        <p><strong>1. Isolasi Database Ketat:</strong> Seluruh tabel relasional memiliki foreign key <code>user_id</code> dan dikunci oleh middleware serta model scope. Pengguna A tidak dapat melihat kontak, sesi, atau konfigurasi Pengguna B.</p>
                        <p><strong>2. Enkripsi At-Rest Kunci API:</strong> API key disimpan terenkripsi penuh. Tampilan antar muka panel admin hanya menunjukkan badge status <em>Terkonfigurasi / Belum</em> tanpa pernah menampilkan string token rahasia.</p>
                        <p><strong>3. Kedaulatan Kuota:</strong> Beban komputasi AI ditanggung langsung oleh endpoint pengguna masing-masing, sehingga server SaaS terhindar dari lonjakan biaya LLM.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
