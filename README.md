# AI Psychological CRM &mdash; Pendengar & Pengendali

[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Octane FrankenPHP](https://img.shields.io/badge/Octane-FrankenPHP-00ADD8?style=flat)](https://frankenphp.dev)
[![Livewire 3](https://img.shields.io/badge/Livewire-3-FB70A9?style=flat&logo=livewire)](https://livewire.laravel.com)
[![Tailwind CSS v4](https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)](https://docker.com)
[![Version](https://img.shields.io/badge/Version-0.7-emerald)](https://github.com/SkillBelajar/crm_ai)

SaaS Gratis dengan arsitektur **BYOK (Bring Your Own Key) Custom AI Endpoint**. Dirancang khusus untuk mengendalikan dinamika percakapan prospek melalui 3 misi psikologis strategis dengan performa worker Laravel Octane (FrankenPHP) dan UI reaktif Livewire 3 + Alpine.js.

---

## 3 Misi Utama Psikologis CRM

1. **Pancing & Catat (Active Elicitation & Pattern Capture)**  
   Mendengarkan secara proaktif sinyal terselubung, pain points prospek, dan pola emosional tanpa memicu resistensi pertahanan diri calon klien.
2. **Filtrasi Anti-Lilin (Conditional Yes)**  
   Mencegah tim habis terbakar (*burnout*) melayani prospek *ghosting*. Mengunci syarat sebelum memberi komitmen melalui formula psikologis *Conditional Yes*.
3. **Kunci Kontrak Psikologis 24 Jam (24-Hour Behavioral Urgency Lock)**  
   Menerapkan batas penutupan internal 24 jam untuk memicu urgensi mental dan komitmen prospek sebelum momentum keputusan mendingin.

---

## Tech Stack & Arsitektur

- **Backend:** Laravel 13 + Laravel Octane (FrankenPHP worker di port internal 8000).
- **Web Server:** Nginx Alpine sebagai Reverse Proxy dengan direct static asset caching & preserve X-Forwarded-Proto.
- **Frontend & Dynamic UI:** Livewire 3 + Alpine.js + Tailwind CSS v4 via Vite.
- **Database Engine:** MySQL 8.0 (Database: `crm_psikologis`).
- **Cache, Session, & Queue:** Redis Alpine (`SESSION_DRIVER=redis`, `CACHE_STORE=redis`).
- **Continuous Project Memory:** `.ai-project-memory.md` (Visi 5W+1H, spesifikasi arsitektur, dan roadmap slice 1–9).

---

## Panduan Menjalankan (Docker Compose)

### 1. Salin Environment
```bash
cp .env.example .env
```

### 2. Jalankan Container Docker
```bash
docker compose up -d --build
```

Container yang dijalankan:
- `crm_app`: Laravel Octane (FrankenPHP PHP 8.4)
- `crm_web`: Nginx Reverse Proxy (Port host: `8484`)
- `crm_db`: MySQL 8.0 (Port host: `33091`)
- `crm_redis`: Redis Alpine (Port host: `63831`)

### 3. Migrasi & Seeder Database
```bash
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
```

### 4. Akun Bawaan untuk Pengujian (Seeder)
- **Admin:** `admin@crm.test` | Kata Sandi: `password123` (Akses `/admin`)
- **User:** `user@crm.test` | Kata Sandi: `password123` (Akses `/dashboard`)

### 5. Akses Aplikasi
- **Aplikasi Publik:** `https://crm.pawandigital.id/`
- **Lokal:** `http://localhost:8484`
- **Login:** `https://crm.pawandigital.id/login`
- **Daftar Akun Gratis:** `https://crm.pawandigital.id/register`
- **Diagnostik Sistem:** `https://crm.pawandigital.id/system-health`

### 6. Menjalankan Test Suite
```bash
docker compose exec app php artisan test
```

---

## Status Roadmap
- [x] **Slice 1 (v0.1):** Setup Arsitektur Dasar (Docker, Laravel Octane, MySQL, Redis, Livewire, Tailwind CSS, Alpine.js, Health Check & Continuous Memory).
- [x] **Slice 2 (v0.2):** Modul Landing Page Executive Minimalist, Dark/Light Mode, Responsif Mobile, BYOK, Diagnostik System Health.
- [x] **Slice 3 (v0.3):** Modul Autentikasi (Livewire 3), Multi-Tenancy / RBAC (`admin`/`user`), Session Driver Redis, Dashboard Eksekutif & Admin Panel.
- [x] **Slice 4 (v0.4):** Modul Pengaturan AI Mandiri (BYOK) Livewire 3 & AI Client Service (OpenAI-compatible) dengan Enkripsi Kunci AES-256.
- [x] **Slice 5 (v0.5):** Modul Manajemen Kontak (CRM) & Profil Psikologis (Tabel `contacts`, Isolasi Multi-Tenant per-User, Livewire 3 Debounced Real-time Search, Kategori, 1 Kebutuhan Psikologis Terbesar & Pemicu Validasi Ego).
- [x] **Slice 6 (v0.6):** Modul Sesi 3 Misi & Active Elicitation Logger Integrasi BYOK AI (Tabel `meetings`, 3 Langkah Terpadu, Generator Opsi Conditional Yes AI, Draf Pesan Kontrak 24 Jam WhatsApp/Email, Ticker Batas Waktu 24 Jam, & Isolasi Data Multi-Tenant).
- [x] **Slice 7 (v0.7):** Modul Dashboard & 7-Day Tracker (Livewire 3 `UserDashboard`, 4 Kartu KPI Smart Goal 7 Hari, Progress Bar Komitmen Terkunci, Daftar Prioritas 24 Jam, Aktivitas & Komitmen Terbaru, Banner Status AI Mandiri).
- [ ] **Slice 8 (v0.8):** 24-Hour Psychological Lock & Evaluasi 7 Hari.
- [ ] **Slice 9 (v1.0):** Dashboard Eksekutif Komprehensif & Polishing Akhir.

---

## Lisensi
Open-source di bawah lisensi MIT.
