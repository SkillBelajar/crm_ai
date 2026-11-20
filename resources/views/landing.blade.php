<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MindControl CRM &mdash; Pendengar & Pengendali di Setiap Pertemuan</title>
    <meta name="description" content="SaaS Gratis berbasis AI Mandiri (BYOK) untuk mengendalikan dinamika percakapan prospek melalui 3 misi psikologis strategis. Jaga energi Anda tetap utuh, raih komitmen nyata dalam 7 hari.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Theme Initialization Script (Prevents flash of incorrect theme) -->
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        code, pre, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body 
    x-data="{
        darkMode: localStorage.getItem('theme') !== 'light',
        mobileMenuOpen: false,
        activeTab: 'conditional_yes',
        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }"
    class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-indigo-500 selection:text-white flex flex-col transition-colors duration-200">

    <!-- Subtle Ambient Glow Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] sm:w-[1000px] h-[400px] bg-gradient-to-tr from-indigo-500/10 via-violet-500/10 to-transparent dark:from-indigo-600/15 dark:via-violet-600/10 dark:to-transparent blur-3xl rounded-full"></div>
        <div class="absolute top-1/2 -right-40 w-[400px] sm:w-[600px] h-[500px] bg-gradient-to-bl from-emerald-500/10 to-transparent dark:from-emerald-600/10 dark:to-transparent blur-3xl rounded-full"></div>
    </div>

    <!-- Sticky & Responsive Navbar -->
    <header class="relative z-50 w-full border-b border-slate-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-950/80 backdrop-blur sticky top-0 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white font-extrabold text-sm shadow-md shadow-indigo-600/20 group-hover:scale-105 transition transform">
                    MC
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-base tracking-tight text-slate-900 dark:text-white">MindControl CRM</span>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium tracking-wide">Pendengar &amp; Pengendali</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-xs font-semibold text-slate-600 dark:text-slate-300">
                <a href="#misi" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Konsep 3 Misi</a>
                <a href="#byok" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Keunggulan BYOK AI</a>
                <a href="#cara-kerja" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Cara Kerja</a>
                <a href="/system-health" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Diagnostik</span>
                </a>
            </nav>

            <!-- Desktop Right Actions (Theme Toggle & CTA Buttons) -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- Theme Toggle Button -->
                <button 
                    @click="toggleTheme()" 
                    type="button" 
                    title="Ubah Mode Tampilan" 
                    class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                    <!-- Sun Icon (shown in dark mode) -->
                    <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon (shown in light mode) -->
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Auth Buttons -->
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? '/admin' : '/dashboard' }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-md shadow-indigo-600/25 transition">
                        <span>Ke Dashboard ({{ auth()->user()->name }}) &rarr;</span>
                    </a>
                @else
                    <a href="/login" class="text-xs font-semibold px-3.5 py-2 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition">
                        Masuk
                    </a>
                    <a href="/register" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-md shadow-indigo-600/25 transition">
                        <span>Mulai Gratis</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center space-x-2 md:hidden">
                <button 
                    @click="toggleTheme()" 
                    type="button" 
                    class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @click.away="mobileMenuOpen = false"
            class="md:hidden border-b border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 px-4 pt-3 pb-6 space-y-3"
            style="display: none;">
            <div class="flex flex-col space-y-2 text-sm font-semibold text-slate-700 dark:text-slate-200">
                <a @click="mobileMenuOpen = false" href="#misi" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">Konsep 3 Misi</a>
                <a @click="mobileMenuOpen = false" href="#byok" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">Keunggulan BYOK AI</a>
                <a @click="mobileMenuOpen = false" href="#cara-kerja" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">Cara Kerja</a>
                <a @click="mobileMenuOpen = false" href="/system-health" class="px-3 py-2 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Diagnostik Sistem</span>
                </a>
            </div>
            <div class="pt-3 border-t border-slate-200 dark:border-slate-800">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? '/admin' : '/dashboard' }}" class="block text-center py-2.5 px-3 rounded-xl bg-indigo-600 text-white font-semibold text-xs shadow-md shadow-indigo-600/30">
                        Ke Dashboard ({{ auth()->user()->name }})
                    </a>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="/login" class="text-center py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-700 font-semibold text-xs text-slate-700 dark:text-slate-300">
                            Masuk
                        </a>
                        <a href="/register" class="text-center py-2.5 px-3 rounded-xl bg-indigo-600 text-white font-semibold text-xs shadow-md shadow-indigo-600/30">
                            Mulai Gratis
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Landing Page Content -->
    <main class="relative z-10 flex-1">
        
        <!-- HERO SECTION -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 md:pt-20 md:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Column: Copy & Actions -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <!-- Top Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-950/70 border border-indigo-200 dark:border-indigo-800/60 text-indigo-700 dark:text-indigo-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 dark:bg-indigo-400 animate-pulse"></span>
                        <span>100% Gratis &bull; SaaS Berbasis AI Mandiri (BYOK)</span>
                    </div>

                    <!-- Strong Executive Headline -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.15]">
                        Jadilah <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-500 dark:from-indigo-400 dark:via-violet-400 dark:to-pink-400">Pendengar &amp; Pengendali</span> di Setiap Pertemuan.
                    </h1>

                    <!-- Subheadline: Smart Goal 7 Hari & Energy Guard -->
                    <p class="text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        <strong>Smart Goal 7 Hari:</strong> Biarkan lawan bicara berbicara 80% dan memberikan aksi serta komitmen nyata tanpa merasa diarahkan. Jaga energi Anda tetap utuh dengan taktik psikologis terukur yang diorkestrasi AI secara otomatis.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-2">
                        <a href="/register" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-xl shadow-indigo-600/30 transition transform hover:-translate-y-0.5">
                            <span>Daftar Gratis Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#misi" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-white dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold text-sm border border-slate-200 dark:border-slate-800 transition">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            <span>Pelajari 3 Misi</span>
                        </a>
                    </div>

                    <!-- Trust Signals -->
                    <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-slate-500 dark:text-slate-400 font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tanpa Biaya Langganan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Kunci API Terenkripsi Pribadi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Dukungan Endpoint Lokal / LAN</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive AI Strategy Card Mockup -->
                <div class="lg:col-span-5">
                    <div class="relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-2xl backdrop-blur transition-all duration-300 hover:border-indigo-500/40">
                        <!-- Header Mockup Window -->
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-mono font-semibold text-slate-400 ml-2">AI Strategy Copilot</span>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Analysis Active
                            </span>
                        </div>

                        <!-- Strategy Selector Tabs -->
                        <div class="grid grid-cols-2 gap-2 mt-4 p-1 rounded-xl bg-slate-100 dark:bg-slate-950 text-xs font-semibold">
                            <button 
                                @click="activeTab = 'conditional_yes'" 
                                :class="activeTab === 'conditional_yes' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 dark:text-slate-400'"
                                class="py-2 px-3 rounded-lg transition text-center cursor-pointer">
                                Conditional Yes
                            </button>
                            <button 
                                @click="activeTab = 'urgency_lock'" 
                                :class="activeTab === 'urgency_lock' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 dark:text-slate-400'"
                                class="py-2 px-3 rounded-lg transition text-center cursor-pointer">
                                Kontrak 24 Jam
                            </button>
                        </div>

                        <!-- Card Body Content: Dynamic based on Active Tab -->
                        <div class="mt-4 space-y-4">
                            <!-- Conditional Yes Tab View -->
                            <div x-show="activeTab === 'conditional_yes'" class="space-y-3">
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800">
                                    <div class="flex items-center justify-between text-[11px] font-mono text-slate-400 mb-1.5">
                                        <span>Target Ego Klien: "Minta Diskon + Deadline Cepat"</span>
                                        <span class="text-rose-500 font-bold">Resiko Lilin: Tinggi</span>
                                    </div>
                                    <div class="text-xs font-semibold text-slate-800 dark:text-slate-200">
                                        Taktik: Filtrasi Anti-Lilin (Beban Balik)
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800/60 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-wider font-mono">Skrip Respon Rekomendasi AI:</span>
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-indigo-200 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 font-mono">Siap Salin</span>
                                    </div>
                                    <p class="text-xs italic text-slate-700 dark:text-slate-200 leading-relaxed">
                                        &ldquo;Bisa, kami siap kunci timeline prioritas untuk Anda, <strong>asal tim Anda mengirimkan draft materi lengkap hari ini sebelum jam 17:00</strong>. Jika draft masuk tepat waktu, kami langsung eksekusi tanpa jeda.&rdquo;
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-center">
                                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400">Energi Terselamatkan</div>
                                        <div class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">92%</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400">Peluang Aksi Nyata</div>
                                        <div class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400 font-mono">87%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Urgency Lock Tab View -->
                            <div x-show="activeTab === 'urgency_lock'" class="space-y-3" style="display: none;">
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800">
                                    <div class="flex items-center justify-between text-[11px] font-mono text-slate-400 mb-1.5">
                                        <span>Status Evaluasi: 24-Hour Timer Active</span>
                                        <span class="text-indigo-400 font-bold">Internal Lock</span>
                                    </div>
                                    <div class="text-xs font-semibold text-slate-800 dark:text-slate-200">
                                        Taktik: Kontrak Psikologis &amp; Batas Keputusan
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-violet-50/80 dark:bg-violet-950/40 border border-violet-200 dark:border-violet-800/60 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-violet-700 dark:text-violet-300 uppercase tracking-wider font-mono">Rangkuman Kesepakatan:</span>
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-violet-200 dark:bg-violet-900 text-violet-800 dark:text-violet-200 font-mono">24 Jam</span>
                                    </div>
                                    <p class="text-xs italic text-slate-700 dark:text-slate-200 leading-relaxed">
                                        &ldquo;Menyambung poin Anda tadi: Solusi ini kami reserve khusus hingga besok pukul 15:00 agar jadwal peluncuran Anda tidak mundur. Begitu konfirmasi Anda terima, slot pengerjaan terkunci otomatis.&rdquo;
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-center">
                                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400">Waktu Kedaluwarsa</div>
                                        <div class="text-sm font-extrabold text-amber-500 font-mono">23:59:12</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400">Komitmen Tertutup</div>
                                        <div class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">7 Hari</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Indicator -->
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-400 font-mono">
                            <span>BYOK Endpoint: Connected</span>
                            <span class="text-indigo-500 dark:text-indigo-400">Prompt Latency: 420ms</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3 MISI: PENDENGAR & PENGENDALI -->
        <section id="misi" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 border-t border-slate-200 dark:border-slate-800/80">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800/50 text-indigo-700 dark:text-indigo-300 text-xs font-semibold uppercase tracking-wider">
                    Metodologi Inti
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    3 Misi &ldquo;Pendengar &amp; Pengendali&rdquo;
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                    Jangan biarkan tim Anda habis membakar diri sendiri layaknya lilin. Gunakan 3 tahapan psikologis yang membalik dinamika percakapan agar lawan bicara yang mengambil tindakan nyata.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Misi 1 -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 hover:border-indigo-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 border border-indigo-200 dark:border-indigo-800/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-extrabold text-lg mb-6 group-hover:scale-110 transition transform">
                            01
                        </div>
                        <div class="inline-block text-[11px] font-mono font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-2">
                            Menit 1 &ndash; 3
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
                            Pancing &amp; Catat
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                            Dengarkan 80%, validasi ego mereka (&ldquo;Yes / Setuju&rdquo;), dan catat 1 kebutuhan terbesar mereka secara instan dari HP tanpa memicu resistensi pertahanan diri.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 text-[11px] font-mono text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        <span>Active Elicitation &amp; Zero Resistance</span>
                    </div>
                </div>

                <!-- Misi 2 -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 hover:border-violet-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 dark:bg-violet-950/80 border border-violet-200 dark:border-violet-800/80 text-violet-600 dark:text-violet-400 flex items-center justify-center font-extrabold text-lg mb-6 group-hover:scale-110 transition transform">
                            02
                        </div>
                        <div class="inline-block text-[11px] font-mono font-bold uppercase tracking-wider text-violet-600 dark:text-violet-400 mb-2">
                            AI Strategist
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
                            Filtrasi &ldquo;Anti-Lilin&rdquo;
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                            AI merumuskan kalimat <em>Conditional Yes</em> (&ldquo;Bisa, asal kamu kerjakan bagian X dulu&rdquo;) agar mereka yang bergerak memberikan syarat komitmen, bukan Anda yang habis tenaga.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 text-[11px] font-mono text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                        <span>Conditional Yes &amp; Reciprocal Effort</span>
                    </div>
                </div>

                <!-- Misi 3 -->
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 hover:border-emerald-500/50 shadow-lg hover:shadow-xl transition-all duration-300 group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-800/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-extrabold text-lg mb-6 group-hover:scale-110 transition transform">
                            03
                        </div>
                        <div class="inline-block text-[11px] font-mono font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-2">
                            Batas 24 Jam
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
                            Kunci Kontrak Psikologis
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                            AI menyusun rangkuman komitmen internal yang menyelaraskan keinginan mereka dengan tujuan Anda, siap salin dan pantau dalam evaluasi 7 hari berikutnya.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 text-[11px] font-mono text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Behavioral Lock &amp; Urgency Momentum</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION KEUNGGULAN SAAS GRATIS & CUSTOM AI (BYOK) -->
        <section id="byok" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 border-t border-slate-200 dark:border-slate-800/80">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Visual Config Mockup -->
                <div class="lg:col-span-5 order-2 lg:order-1">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Custom Endpoint Setup
                            </span>
                            <span class="text-[11px] font-mono text-emerald-600 dark:text-emerald-400 font-semibold">Self-Hosted / BYOK</span>
                        </div>

                        <!-- Form Field Mockups -->
                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block text-slate-500 dark:text-slate-400 font-medium mb-1">Base URL (OpenAI-Compatible)</label>
                                <div class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-800 dark:text-slate-200">
                                    https://api.deepseek.com/v1 <span class="text-slate-400 text-[10px]">(atau http://192.168.1.5:11434/v1)</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-slate-500 dark:text-slate-400 font-medium mb-1">Model Name</label>
                                <div class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-indigo-600 dark:text-indigo-400 font-semibold">
                                    deepseek-chat &bull; gpt-4o-mini &bull; llama3.3
                                </div>
                            </div>
                            <div>
                                <label class="block text-slate-500 dark:text-slate-400 font-medium mb-1">API Key</label>
                                <div class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-400 flex items-center justify-between">
                                    <span>sk-•••••••••••••••••••••••••</span>
                                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">AES-256 Encrypted</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/50 text-[11px] text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Nol Biaya Tambahan: Anda bayar langsung biaya token ke AI provider Anda tanpa mark-up sepeser pun.</span>
                        </div>
                    </div>
                </div>

                <!-- Right Copy: Value Proposition -->
                <div class="lg:col-span-7 order-1 lg:order-2 space-y-6">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 text-emerald-700 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider">
                        Privasi &amp; Efisiensi Maksimal
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        Keunggulan SaaS Gratis &amp; AI Mandiri (BYOK)
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                        Kami tidak membatasi kreativitas atau menambah margin biaya token. Hubungkan endpoint AI pilihan Anda sendiri untuk kedaulatan data dan fleksibilitas penuh.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Dukungan Universal Endpoint</div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Kompatibel dengan OpenAI, DeepSeek, Groq, OpenRouter, vLLM, hingga Ollama lokal.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Server Intranet / LAN Pribadi</div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Gunakan server lokal seperti <code class="text-indigo-500">http://192.168.x.x:port/v1</code> demi kerahasiaan absolut data prospek.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Kunci API Terenkripsi</div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">API Key disimpan terenkripsi di database Anda dan hanya dipanggil saat Anda memicu taktik AI.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">High Concurrency Octane</div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Ditenagai worker FrankenPHP Octane untuk waktu respons sub-detik tanpa jeda boot.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION CARA KERJA (3 LANGKAH MUDAH) -->
        <section id="cara-kerja" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 border-t border-slate-200 dark:border-slate-800/80">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold uppercase tracking-wider">
                    Alur Sederhana
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Cara Kerja dalam 3 Langkah Praktis
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                    Mulai dalam hitungan menit tanpa setup rumit. Fokus pada mendengarkan, biarkan sistem merancang kendali psikologisnya.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="relative bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 space-y-3">
                    <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-sm font-mono">1</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Sambungkan AI Endpoint</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Masukkan URL endpoint OpenAI-compatible dan API Key Anda di menu pengaturan. Selesai dalam 1 menit.
                    </p>
                </div>
                <div class="relative bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 space-y-3">
                    <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-sm font-mono">2</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Catat Poin Pertemuan</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Saat meeting, cukup input 1-2 kalimat kunci kebutuhan prospek langsung dari layar HP Anda.
                    </p>
                </div>
                <div class="relative bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 space-y-3">
                    <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold text-sm font-mono">3</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Eksekusi Taktik AI</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Salin formula <em>Conditional Yes</em> atau <em>Kontrak 24 Jam</em> yang disarankan AI, dan lihat komitmen klien terkunci.
                    </p>
                </div>
            </div>
        </section>

        <!-- CTA SECTION PENUTUP -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-slate-900 to-slate-950 p-8 sm:p-12 lg:p-16 border border-indigo-500/30 shadow-2xl text-center space-y-6">
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-indigo-500/20 blur-3xl rounded-full pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-emerald-500/20 blur-3xl rounded-full pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                        Siap Menjadi Pengendali di Meja Negosiasi Berikutnya?
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                        Lindungi energi tim Anda, saring prospek yang tidak serius, dan kunci komitmen bernilai tinggi dengan taktik psikologis terukur.
                    </p>
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="/register" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-xl shadow-indigo-600/40 transition transform hover:-translate-y-0.5">
                            Daftar Gratis Sekarang
                        </a>
                        <a href="/system-health" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition">
                            Cek Diagnostik Sistem &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer Component (Menampilkan Versi: {{ config('app.version') }}) -->
    <x-footer />

</body>
</html>
