<?php

namespace App\Livewire;

use App\Models\Meeting;
use App\Models\MeetingLog;
use App\Services\StrategyAiService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Workspace 3 Misi & AI Persuasi - MindControl CRM')]
class MeetingWorkspace extends Component
{
    public Meeting $meeting;

    #[Url(as: 'tab')]
    public string $activeTab = 'misi-1';

    // Misi 1 fields
    public string $title = '';
    public string $biggest_need = '';
    public string $user_goal = '';
    public string $ego_validation_note = '';
    public string $context_notes = '';

    // Misi 2 fields
    public ?string $ai_conditional_yes = '';
    public ?string $conditionalYesRawAiResponse = null;
    public ?string $conditionalYesError = null;
    public bool $isGeneratingConditionalYes = false;

    // Misi 3 fields
    public ?string $ai_psychological_contract = '';
    public ?string $contractRawAiResponse = null;
    public ?string $contractError = null;
    public bool $isGeneratingContract = false;
    public string $status = '';
    public ?string $commitment_result = '';

    // Tab 4 (Log History & AI Follow Update) fields
    public string $newLogChannel = MeetingLog::CHANNEL_NOTE;
    public string $newLogSentiment = MeetingLog::SENTIMENT_NEUTRAL;
    public string $newLogContent = '';
    public string $newLoggedAt = '';
    public ?string $latest_ai_strategy = '';
    public ?string $followUpdateError = null;
    public bool $isGeneratingFollowUpdate = false;

    // UI Toast Feedback
    public ?string $feedbackMessage = null;
    public string $feedbackType = 'success';

    public function mount(Meeting $meeting): void
    {
        if ($meeting->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang membuka sesi pertemuan ini.');
        }

        $this->meeting = $meeting->load(['contact', 'logs']);

        // Initialize Misi 1
        $this->title = $meeting->title;
        $this->biggest_need = $meeting->biggest_need;
        $this->user_goal = $meeting->user_goal;
        $this->ego_validation_note = $meeting->ego_validation_note ?? '';
        $this->context_notes = $meeting->context_notes ?? '';

        // Initialize Misi 2
        $this->ai_conditional_yes = $meeting->ai_conditional_yes ?? '';

        // Initialize Misi 3
        $this->ai_psychological_contract = $meeting->ai_psychological_contract ?? '';
        $this->status = $meeting->status;
        $this->commitment_result = $meeting->commitment_result ?? '';

        // Initialize Tab 4: Log History & Follow Update
        $this->latest_ai_strategy = $meeting->latest_ai_strategy ?? '';
        $this->newLoggedAt = now()->format('Y-m-d\TH:i');

        // Intelligently select tab
        $tabParam = request()->query('tab');
        if (in_array($tabParam, ['misi-1', 'misi-2', 'misi-3', 'logs'])) {
            $this->activeTab = $tabParam;
        } elseif ($meeting->logs()->exists() && ! empty($meeting->latest_ai_strategy)) {
            $this->activeTab = 'logs';
        } elseif (! empty($this->ai_psychological_contract)) {
            $this->activeTab = 'misi-3';
        } elseif (! empty($this->ai_conditional_yes)) {
            $this->activeTab = 'misi-2';
        } else {
            $this->activeTab = 'misi-1';
        }
    }

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['misi-1', 'misi-2', 'misi-3', 'logs'])) {
            $this->activeTab = $tab;
        }
    }

    public function saveMisi1(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'biggest_need' => 'required|string|min:3',
            'user_goal' => 'required|string|min:3',
            'ego_validation_note' => 'nullable|string',
            'context_notes' => 'nullable|string',
        ], [
            'title.required' => 'Judul pertemuan wajib diisi.',
            'biggest_need.required' => '1 Kebutuhan terbesar lawan bicara wajib dicatat.',
            'user_goal.required' => 'Tujuan utama Anda wajib ditentukan.',
        ]);

        $this->meeting->update([
            'title' => $this->title,
            'biggest_need' => $this->biggest_need,
            'user_goal' => $this->user_goal,
            'ego_validation_note' => $this->ego_validation_note,
            'context_notes' => $this->context_notes,
        ]);

        $this->feedbackMessage = 'Catatan Misi 1 berhasil disimpan.';
        $this->feedbackType = 'success';
    }

    public function saveMisi1AndProceed(): void
    {
        $this->saveMisi1();
        $this->activeTab = 'misi-2';
    }

    public function generateConditionalYes(StrategyAiService $aiService): void
    {
        $this->conditionalYesError = null;
        $this->isGeneratingConditionalYes = true;

        // Ensure Misi 1 is saved first
        $this->meeting->update([
            'title' => $this->title,
            'biggest_need' => $this->biggest_need,
            'user_goal' => $this->user_goal,
            'ego_validation_note' => $this->ego_validation_note,
            'context_notes' => $this->context_notes,
        ]);

        $result = $aiService->generateConditionalYes(Auth::user(), $this->meeting);

        $this->isGeneratingConditionalYes = false;

        if ($result['success']) {
            $this->ai_conditional_yes = $result['content'];
            $this->conditionalYesRawAiResponse = $result['content'];
            $this->meeting->update([
                'ai_conditional_yes' => $this->ai_conditional_yes,
            ]);
            $this->feedbackMessage = 'Formula strategi Conditional Yes berhasil dirumuskan AI (' . $result['latency_ms'] . 'ms).';
            $this->feedbackType = 'success';
        } else {
            $this->conditionalYesError = $result['message'];
            $this->feedbackMessage = 'Gagal memanggil AI: ' . $result['message'];
            $this->feedbackType = 'error';
        }
    }

    public function saveMisi2AndProceed(): void
    {
        $this->validate([
            'ai_conditional_yes' => 'required|string|min:5',
        ], [
            'ai_conditional_yes.required' => 'Opsi Conditional Yes wajib dirumuskan sebelum lanjut.',
        ]);

        $this->meeting->update([
            'ai_conditional_yes' => $this->ai_conditional_yes,
        ]);

        $this->feedbackMessage = 'Misi 2 berhasil disimpan. Lanjut ke Misi 3 (Kontrak 24 Jam).';
        $this->feedbackType = 'success';
        $this->activeTab = 'misi-3';
    }

    public function generateContract(StrategyAiService $aiService): void
    {
        $this->contractError = null;
        $this->isGeneratingContract = true;

        $result = $aiService->generatePsychologicalContract(Auth::user(), $this->meeting);

        $this->isGeneratingContract = false;

        if ($result['success']) {
            $this->ai_psychological_contract = $result['content'];
            $this->contractRawAiResponse = $result['content'];

            // Set default deadline 24 hours if not set
            $deadline = $this->meeting->contract_deadline_at ?? now()->addHours(24);

            $this->meeting->update([
                'ai_psychological_contract' => $this->ai_psychological_contract,
                'contract_deadline_at' => $deadline,
                'status' => $this->status === Meeting::STATUS_DRAFT ? Meeting::STATUS_SENT : $this->status,
            ]);
            $this->status = $this->meeting->status;
            $this->feedbackMessage = 'Draf Kontrak Psikologis 24 Jam berhasil dibuat AI (' . $result['latency_ms'] . 'ms).';
            $this->feedbackType = 'success';
        } else {
            $this->contractError = $result['message'];
            $this->feedbackMessage = 'Gagal menyusun kontrak AI: ' . $result['message'];
            $this->feedbackType = 'error';
        }
    }

    public function saveContract(): void
    {
        $this->validate([
            'ai_psychological_contract' => 'nullable|string',
            'status' => 'required|in:draft,sent,committed,failed,archived',
            'commitment_result' => 'nullable|string',
        ]);

        $this->meeting->update([
            'ai_psychological_contract' => $this->ai_psychological_contract,
            'status' => $this->status,
            'commitment_result' => $this->commitment_result,
        ]);

        $this->feedbackMessage = 'Kontrak psikologis dan status komitmen berhasil diperbarui.';
        $this->feedbackType = 'success';
    }

    public function updateStatus(string $newStatus): void
    {
        if (in_array($newStatus, [Meeting::STATUS_DRAFT, Meeting::STATUS_SENT, Meeting::STATUS_COMMITTED, Meeting::STATUS_FAILED, Meeting::STATUS_ARCHIVED])) {
            $this->status = $newStatus;
            $this->meeting->update(['status' => $newStatus]);
            $this->feedbackMessage = 'Status sesi diperbarui menjadi: ' . $this->meeting->status_label;
            $this->feedbackType = 'success';
        }
    }

    public function archiveWorkspace(): void
    {
        $this->updateStatus(Meeting::STATUS_ARCHIVED);
    }

    public function unarchiveWorkspace(): void
    {
        $this->updateStatus(Meeting::STATUS_DRAFT);
    }

    /**
     * Tambahkan catatan riwayat proses interaksi baru.
     */
    public function addLog(): void
    {
        $this->validate([
            'newLogChannel' => 'required|in:whatsapp,call,meeting,email,note',
            'newLogSentiment' => 'required|in:positive,neutral,objection,negotiation',
            'newLogContent' => 'required|string|min:3|max:5000',
            'newLoggedAt' => 'required|date',
        ], [
            'newLogContent.required' => 'Catatan proses / respons target wajib diisi.',
            'newLogContent.min' => 'Catatan proses minimal 3 karakter.',
            'newLoggedAt.required' => 'Waktu kejadian wajib ditentukan.',
        ]);

        $this->meeting->logs()->create([
            'user_id' => Auth::id(),
            'channel' => $this->newLogChannel,
            'sentiment' => $this->newLogSentiment,
            'content' => trim($this->newLogContent),
            'logged_at' => $this->newLoggedAt,
        ]);

        $this->newLogContent = '';
        $this->newLoggedAt = now()->format('Y-m-d\TH:i');
        $this->newLogChannel = MeetingLog::CHANNEL_NOTE;
        $this->newLogSentiment = MeetingLog::SENTIMENT_NEUTRAL;

        $this->meeting->load('logs');
        $this->feedbackMessage = 'Catatan riwayat proses berhasil ditambahkan ke log.';
        $this->feedbackType = 'success';
    }

    /**
     * Hapus catatan proses tertentu.
     */
    public function deleteLog(int $logId): void
    {
        $log = $this->meeting->logs()->where('id', $logId)->where('user_id', Auth::id())->first();
        if ($log) {
            $log->delete();
            $this->meeting->load('logs');
            $this->feedbackMessage = 'Catatan log berhasil dihapus.';
            $this->feedbackType = 'success';
        }
    }

    /**
     * Jalankan AI untuk menganalisis seluruh riwayat log & merumuskan strategi lanjutan (Follow Update).
     */
    public function generateFollowUpdate(StrategyAiService $strategyAiService): void
    {
        $this->followUpdateError = null;
        $this->isGeneratingFollowUpdate = true;

        $result = $strategyAiService->generateFollowUpdateStrategy(Auth::user(), $this->meeting);

        $this->isGeneratingFollowUpdate = false;

        if ($result['success']) {
            $this->latest_ai_strategy = $result['content'];
            $this->meeting->update([
                'latest_ai_strategy' => $this->latest_ai_strategy,
                'latest_ai_strategy_at' => now(),
            ]);
            $this->meeting->refresh();

            $latency = isset($result['latency_ms']) ? " ({$result['latency_ms']}ms)" : '';
            $this->feedbackMessage = 'Strategi negosiasi lanjutan (Follow Update) berhasil dirumuskan AI' . $latency . '.';
            $this->feedbackType = 'success';
        } else {
            $this->followUpdateError = $result['message'];
            $this->feedbackMessage = 'Gagal merumuskan strategi: ' . $result['message'];
            $this->feedbackType = 'error';
        }
    }

    /**
     * Simpan penyesuaian manual teks strategi.
     */
    public function saveStrategy(): void
    {
        $this->validate([
            'latest_ai_strategy' => 'nullable|string',
        ]);

        $this->meeting->update([
            'latest_ai_strategy' => $this->latest_ai_strategy,
            'latest_ai_strategy_at' => $this->meeting->latest_ai_strategy_at ?: now(),
        ]);

        $this->feedbackMessage = 'Catatan strategi negosiasi berhasil disimpan.';
        $this->feedbackType = 'success';
    }

    public function render()
    {
        return view('livewire.meeting-workspace', [
            'deadlineInfo' => $this->meeting->getDeadlineInfo(),
            'logs' => $this->meeting->logs()->with('user')->get(),
            'channels' => MeetingLog::CHANNELS,
            'sentiments' => MeetingLog::SENTIMENTS,
        ]);
    }
}
