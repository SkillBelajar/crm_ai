# AI Psychological CRM &mdash; Pendengar & Pengendali

[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Octane FrankenPHP](https://img.shields.io/badge/Octane-FrankenPHP-00ADD8?style=flat)](https://frankenphp.dev)
[![Livewire 3](https://img.shields.io/badge/Livewire-3-FB70A9?style=flat&logo=livewire)](https://livewire.laravel.com)
[![Tailwind CSS v4](https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)](https://docker.com)
[![Version](https://img.shields.io/badge/Version-0.1-emerald)](https://github.com/SkillBelajar/crm_ai)

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
- **Web Server:** Nginx Alpine sebagai Reverse Proxy dengan direct static asset caching.
- **Frontend & Dynamic UI:** Livewire 3 + Alpine.js + Tailwind CSS v4 via Vite.
- **Database Engine:** MySQL 8.0 (Database: `crm_psikologis`).
- **Cache, Session, & Queue:** Redis Alpine.
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

### 3. Migrasi Database
```bash
docker compose exec app php artisan migrate --force
```

### 4. Akses Aplikasi
Buka browser pada:
```
http://localhost:8484
```
Komponen **Health Check** real-time akan menampilkan status koneksi MySQL, Redis, dan Octane server, beserta footer versi global: **Versi: 0.1**.

### 5. Menjalankan Test Suite
```bash
docker compose exec app php artisan test
```

---

## Status Roadmap
- [x] **Slice 1 (v0.1):** Setup Arsitektur Dasar (Docker, Laravel Octane, MySQL, Redis, Livewire, Tailwind CSS, Alpine.js, Health Check & Continuous Memory).
- [ ] **Slice 2:** BYOK Custom AI Endpoint & Prompt Orchestration.
- [ ] **Slice 3:** Modul 1 &mdash; Pancing & Catat.
- [ ] **Slice 4:** Modul 2 &mdash; Filtrasi Anti-Lilin (Conditional Yes).
- [ ] **Slice 5:** Modul 3 &mdash; Kunci Kontrak Psikologis 24 Jam.
- [ ] **Slice 6 - 9:** Analytics, Webhook/WA Ingress, Multi-Tenant & Hardening.

---

## Lisensi
Open-source di bawah lisensi MIT.
