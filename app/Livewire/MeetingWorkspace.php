<?php

namespace App\Livewire;

use App\Models\Meeting;
use App\Services\StrategyAiService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Workspace 3 Misi & AI Persuasi - MindControl CRM')]
class MeetingWorkspace extends Component
{
    public Meeting $meeting;

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

    // UI Toast Feedback
    public ?string $feedbackMessage = null;
    public string $feedbackType = 'success';

    public function mount(Meeting $meeting): void
    {
        if ($meeting->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang membuka sesi pertemuan ini.');
        }

        $this->meeting = $meeting->load('contact');

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

        // Intelligently select tab
        if (! empty($this->ai_psychological_contract)) {
            $this->activeTab = 'misi-3';
        } elseif (! empty($this->ai_conditional_yes)) {
            $this->activeTab = 'misi-2';
        } else {
            $this->activeTab = 'misi-1';
        }
    }

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['misi-1', 'misi-2', 'misi-3'])) {
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

        // Auto save latest Misi 1 data first
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
            $this->conditionalYesRawAiResponse = $result['content'];
            // If empty, also prefill the chosen formula
            if (empty($this->ai_conditional_yes)) {
                $this->ai_conditional_yes = $result['content'];
                $this->meeting->update(['ai_conditional_yes' => $result['content']]);
            }
            $this->feedbackMessage = 'AI berhasil merumuskan 3 opsi Conditional Yes (' . $result['latency_ms'] . 'ms).';
            $this->feedbackType = 'success';
        } else {
            $this->conditionalYesError = $result['message'];
            $this->feedbackMessage = 'Gagal memanggil AI: ' . $result['message'];
            $this->feedbackType = 'error';
        }
    }

    public function saveConditionalYes(): void
    {
        $this->validate([
            'ai_conditional_yes' => 'nullable|string',
        ]);

        $this->meeting->update([
            'ai_conditional_yes' => $this->ai_conditional_yes,
        ]);

        $this->feedbackMessage = 'Strategi Conditional Yes berhasil disimpan.';
        $this->feedbackType = 'success';
    }

    public function saveMisi2AndProceed(): void
    {
        $this->saveConditionalYes();
        $this->activeTab = 'misi-3';
    }

    public function generateContract(StrategyAiService $aiService): void
    {
        $this->contractError = null;
        $this->isGeneratingContract = true;

        // Ensure Misi 2 is up to date
        $this->meeting->update([
            'ai_conditional_yes' => $this->ai_conditional_yes,
        ]);

        $result = $aiService->generatePsychologicalContract(Auth::user(), $this->meeting);

        $this->isGeneratingContract = false;

        if ($result['success']) {
            $this->contractRawAiResponse = $result['content'];
            $this->ai_psychological_contract = $result['content'];
            $this->meeting->update([
                'ai_psychological_contract' => $result['content'],
            ]);
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
            'status' => 'required|in:draft,sent,committed,failed',
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
        if (in_array($newStatus, [Meeting::STATUS_DRAFT, Meeting::STATUS_SENT, Meeting::STATUS_COMMITTED, Meeting::STATUS_FAILED])) {
            $this->status = $newStatus;
            $this->meeting->update(['status' => $newStatus]);
            $this->feedbackMessage = 'Status sesi diperbarui menjadi: ' . $this->meeting->status_label;
            $this->feedbackType = 'success';
        }
    }

    public function render()
    {
        return view('livewire.meeting-workspace', [
            'deadlineInfo' => $this->meeting->getDeadlineInfo(),
        ]);
    }
}
