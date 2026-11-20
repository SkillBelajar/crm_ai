<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\User;

class StrategyAiService
{
    public function __construct(
        protected AiClientService $aiClient
    ) {}

    /**
     * Menghasilkan 3 variasi kalimat "Conditional Yes" (Filtrasi Anti-Lilin) untuk Misi 2.
     *
     * @return array{success: bool, content: ?string, message: string, needs_ai_settings: bool, latency_ms?: int}
     */
    public function generateConditionalYes(User $user, Meeting $meeting): array
    {
        $setting = $user->aiSetting;

        if (! $setting || empty($setting->base_url)) {
            return [
                'success' => false,
                'content' => null,
                'message' => 'Konfigurasi AI belum diatur. Silakan atur endpoint AI mandiri (BYOK) Anda di menu Pengaturan AI terlebih dahulu.',
                'needs_ai_settings' => true,
            ];
        }

        $contactName = $meeting->contact?->name ?? 'Lawan Bicara';
        $contactRole = $meeting->contact?->role_or_company ?? 'Relasi Bisnis';
        $contactCategory = $meeting->contact?->category_label ?? 'Klien';
        $egoTrigger = $meeting->ego_validation_note ?: ($meeting->contact?->ego_trigger ?: 'Diakui sebagai pihak yang berpengaruh & kompeten');
        $contextNotes = $meeting->context_notes ?: 'Diskusi langsung tatap muka / daring.';

        $systemPrompt = <<<PROMPT
Anda adalah Master Negosiator & Konsultan Psikologi Negosiasi "Pendengar & Pengendali" (MindControl CRM).
Tugas Anda adalah merumuskan STRATEGI FILTRASI "ANTI-LILIN" menggunakan prinsip CONDITIONAL YES.

PRINSIP INTI ANTI-LILIN:
1. Energi Pengguna Harus Tetap Utuh: Pengguna TIDAK boleh kelelahan menjadi pihak yang mengerjakan segalanya tanpa komitmen nyata lawan bicara (tidak menjadi lilin yang membakar diri sendiri).
2. Validasi Ego Terlebih Dahulu: Puji/akui keinginan atau posisi mereka agar resistensi pertahanan mereka turun.
3. Gerakkan Lawan Bicara: Gunakan formula "Bisa / Setuju, asalkan [Tindakan Nyata yang Wajib MEREKA Selesaikan Dulu]".
4. Hasil Selaras dengan Tujuan Pengguna: Prasyarat yang diminta secara otomatis memajukan tujuan pengguna.
PROMPT;

        $userPrompt = <<<PROMPT
Analisis data pertemuan berikut dan formulasikan 3 opsi kalimat "Conditional Yes":

DATA PERTEMUAN:
- Lawan Bicara: {$contactName} ({$contactRole} - {$contactCategory})
- 1 Kebutuhan Psikologis Terbesar Mereka: {$meeting->biggest_need}
- Poin Validasi Ego (Hal yang Membuat Mereka Bangga/Divalidasi): {$egoTrigger}
- Target / Hasil yang Diinginkan Pengguna: {$meeting->user_goal}
- Konteks Pertemuan: {$contextNotes}

INSTRUKSI OUTPUT:
Buatlah 3 PILIHAN OPSI KALIMAT CONDITIONAL YES dalam bahasa Indonesia yang tajam dan taktis:
1. 🟢 **Opsi Santai & Kolaboratif** (Cocok untuk chat WhatsApp atau obrolan santai, tetap hangat namun menaruh beban kerja pertama di pundak mereka).
2. 🔵 **Opsi Profesional & Korporat** (Formal, terstruktur, sangat cocok untuk email resmi atau rapat direksi).
3. 🟣 **Opsi Tegas & Berjarak (Assertive)** (Direct dan tanpa kompromi, cocok bila lawan bicara dominan, manipulatif, atau gemar meminta hal berlebih).

Pada tiap opsi, sertakan:
- **Kalimat yang Diucapkan/Dikirimkan:** (Kalimat langsung dalam tanda kutip)
- **Kunci Psikologis:** (1 kalimat mengapa formula ini membuat mereka yang harus bergerak duluan).
PROMPT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ];

        $response = $this->aiClient->chat($setting, $messages, temperature: 0.7, maxTokens: 900);

        return [
            'success' => $response['success'],
            'content' => $response['reply'],
            'message' => $response['message'],
            'needs_ai_settings' => false,
            'latency_ms' => $response['latency_ms'] ?? 0,
        ];
    }

    /**
     * Menghasilkan draf Pesan Kontrak Psikologis 24 Jam siap kirim untuk Misi 3.
     *
     * @return array{success: bool, content: ?string, message: string, needs_ai_settings: bool, latency_ms?: int}
     */
    public function generatePsychologicalContract(User $user, Meeting $meeting): array
    {
        $setting = $user->aiSetting;

        if (! $setting || empty($setting->base_url)) {
            return [
                'success' => false,
                'content' => null,
                'message' => 'Konfigurasi AI belum diatur. Silakan atur endpoint AI mandiri (BYOK) Anda di menu Pengaturan AI terlebih dahulu.',
                'needs_ai_settings' => true,
            ];
        }

        $contactName = $meeting->contact?->name ?? 'Rekan';
        $contactRole = $meeting->contact?->role_or_company ?? '';
        $conditionalYesUsed = $meeting->ai_conditional_yes ?: 'Lawan bicara menyetujui langkah awal untuk menyiapkan data/materi terlebih dahulu.';

        $systemPrompt = <<<PROMPT
Anda adalah Ahli Komunikasi Persuasif dan Psikologi Relasi Bisnis.
Tugas Anda adalah menyusun "DRAF KONTRAK PSIKOLOGIS 24 JAM" (Follow-up Message) siap kirim via WhatsApp atau Email.

PRINSIP KONTRAK PSIKOLOGIS 24 JAM:
1. Dikirim dalam 24 jam selagi memori dan komitmen emosional pertemuan masih kuat.
2. Tidak terasa seperti menagih atau memaksa, melainkan mengonfirmasi keselarasan ("kesepakatan bersama yang menguntungkan mereka").
3. Mengapresiasi kebutuhan utama mereka, lalu dengan tegas menegaskan tanggung jawab langkah awal yang harus mereka lakukan.
4. Menetapkan ekspektasi batas waktu tindak lanjut.
PROMPT;

        $userPrompt = <<<PROMPT
Susun SATU DRAF PESAN FOLLOW-UP SIAP KIRIM (format WhatsApp/Email) berdasarkan data ini:

DATA SESI PERTEMUAN:
- Nama Lawan Bicara: {$contactName} ({$contactRole})
- Judul Diskusi: {$meeting->title}
- 1 Kebutuhan Terbesar Mereka: {$meeting->biggest_need}
- Target Pengguna: {$meeting->user_goal}
- Strategi Conditional Yes / Kesepakatan Awal: {$conditionalYesUsed}

STRUKTUR PESAN:
1. Sapaan personal yang hangat & terima kasih atas waktu serta diskusi berkualitas kemarin/tadi.
2. Validasi atas visi/kebutuhan terbesar mereka (tunjukkan bahwa pengguna benar-benar mendengarkan).
3. Konfirmasi langkah konkret yang disepakati untuk MEREKA kerjakan terlebih dahulu.
4. Call to action / jadwal tindak lanjut yang jelas begitu mereka selesai mengirimkan bagian mereka.
5. Penutup santun dan profesional.

Tuliskan pesan lengkap dalam bahasa Indonesia yang elegan, hangat, profesional, dan siap dikirim hanya dengan 1 kali klik.
PROMPT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ];

        $response = $this->aiClient->chat($setting, $messages, temperature: 0.7, maxTokens: 900);

        return [
            'success' => $response['success'],
            'content' => $response['reply'],
            'message' => $response['message'],
            'needs_ai_settings' => false,
            'latency_ms' => $response['latency_ms'] ?? 0,
        ];
    }
}
