<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Workspace 3 Misi & Sesi Pertemuan - MindControl CRM')]
class MeetingIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'status')]
    public string $statusFilter = '';

    #[Url(as: 'contact')]
    public string $contactFilter = '';

    #[Url(as: 'new_with')]
    public ?int $new_with = null;

    public bool $showCreateModal = false;
    public bool $showDeleteModal = false;
    public ?int $meetingToDeleteId = null;

    // Create Modal Properties
    public string $form_contact_id = '';
    public string $form_title = '';
    public string $form_biggest_need = '';
    public string $form_user_goal = '';
    public string $form_ego_validation_note = '';
    public string $form_context_notes = '';

    public ?string $successMessage = null;

    protected function rules(): array
    {
        return [
            'form_contact_id' => 'required|exists:contacts,id',
            'form_title' => 'required|string|max:255',
            'form_biggest_need' => 'required|string|min:3',
            'form_user_goal' => 'required|string|min:3',
            'form_ego_validation_note' => 'nullable|string',
            'form_context_notes' => 'nullable|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'form_contact_id.required' => 'Pilih salah satu kontak terlebih dahulu.',
            'form_title.required' => 'Judul pertemuan wajib diisi.',
            'form_biggest_need.required' => '1 Kebutuhan terbesar lawan bicara wajib dicatat (Misi 1).',
            'form_user_goal.required' => 'Tujuan utama Anda wajib ditentukan agar hasil pertemuan terarah.',
        ];
    }

    public function mount(): void
    {
        if ($this->new_with) {
            $contact = Auth::user()->contacts()->find($this->new_with);
            if ($contact) {
                $this->openCreateModal($contact->id);
            }
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedContactFilter(): void
    {
        $this->resetPage();
    }

    public function setStatusFilter(string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function updatedFormContactId($contactId): void
    {
        if ($contactId) {
            $contact = Auth::user()->contacts()->find($contactId);
            if ($contact) {
                if (empty($this->form_biggest_need) && ! empty($contact->primary_need)) {
                    $this->form_biggest_need = $contact->primary_need;
                }
                if (empty($this->form_ego_validation_note) && ! empty($contact->ego_trigger)) {
                    $this->form_ego_validation_note = $contact->ego_trigger;
                }
            }
        }
    }

    public function openCreateModal(?int $contactId = null): void
    {
        $this->resetValidation();
        $this->resetCreateForm();

        if ($contactId) {
            $this->form_contact_id = (string) $contactId;
            $this->updatedFormContactId($contactId);
        } else {
            // Default select first contact if available
            $firstContact = Auth::user()->contacts()->first();
            if ($firstContact) {
                $this->form_contact_id = (string) $firstContact->id;
                $this->updatedFormContactId($firstContact->id);
            }
        }

        $this->showCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
        $this->resetCreateForm();
        $this->resetValidation();
    }

    protected function resetCreateForm(): void
    {
        $this->form_contact_id = '';
        $this->form_title = '';
        $this->form_biggest_need = '';
        $this->form_user_goal = '';
        $this->form_ego_validation_note = '';
        $this->form_context_notes = '';
    }

    public function createMeeting()
    {
        $this->validate();

        // Verify contact belongs to authenticated user
        $contact = Auth::user()->contacts()->findOrFail((int) $this->form_contact_id);

        $meeting = Auth::user()->meetings()->create([
            'contact_id' => $contact->id,
            'title' => $this->form_title,
            'biggest_need' => $this->form_biggest_need,
            'user_goal' => $this->form_user_goal,
            'ego_validation_note' => $this->form_ego_validation_note,
            'context_notes' => $this->form_context_notes,
            'status' => Meeting::STATUS_DRAFT,
            'meeting_date' => now(),
            'contract_deadline_at' => now()->addHours(24),
        ]);

        return redirect()->route('meetings.show', $meeting->id);
    }

    public function confirmDelete(int $id): void
    {
        $meeting = Auth::user()->meetings()->findOrFail($id);
        $this->meetingToDeleteId = $meeting->id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->meetingToDeleteId = null;
        $this->showDeleteModal = false;
    }

    public function deleteMeeting(): void
    {
        if ($this->meetingToDeleteId) {
            $meeting = Auth::user()->meetings()->findOrFail($this->meetingToDeleteId);
            $meeting->delete();

            $this->successMessage = 'Sesi pertemuan berhasil dihapus.';
            $this->meetingToDeleteId = null;
            $this->showDeleteModal = false;
        }
    }

    public function toggleArchive(int $id): void
    {
        $meeting = Auth::user()->meetings()->findOrFail($id);
        if ($meeting->status === Meeting::STATUS_ARCHIVED) {
            $meeting->update(['status' => Meeting::STATUS_DRAFT]);
            $this->successMessage = "Sesi \"{$meeting->title}\" berhasil diaktifkan kembali dari arsip.";
        } else {
            $meeting->update(['status' => Meeting::STATUS_ARCHIVED]);
            $this->successMessage = "Sesi \"{$meeting->title}\" berhasil dipindahkan ke Arsip (tidak aktif).";
        }
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->meetings()
            ->with('contact')
            ->latest('meeting_date');

        if (! empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('biggest_need', 'like', $search)
                    ->orWhereHas('contact', function ($cq) use ($search) {
                        $cq->where('name', 'like', $search)
                            ->orWhere('role_or_company', 'like', $search);
                    });
            });
        }

        if (! empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (! empty($this->contactFilter)) {
            $query->where('contact_id', (int) $this->contactFilter);
        }

        $meetings = $query->paginate(10);
        $contacts = $user->contacts()->orderBy('name')->get();

        $rawCounts = $user->meetings()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusCounts = [
            'all' => array_sum($rawCounts),
            Meeting::STATUS_DRAFT => $rawCounts[Meeting::STATUS_DRAFT] ?? 0,
            Meeting::STATUS_SENT => $rawCounts[Meeting::STATUS_SENT] ?? 0,
            Meeting::STATUS_COMMITTED => $rawCounts[Meeting::STATUS_COMMITTED] ?? 0,
            Meeting::STATUS_FAILED => $rawCounts[Meeting::STATUS_FAILED] ?? 0,
            Meeting::STATUS_ARCHIVED => $rawCounts[Meeting::STATUS_ARCHIVED] ?? 0,
        ];

        return view('livewire.meeting-index', [
            'meetings' => $meetings,
            'contacts' => $contacts,
            'statusCounts' => $statusCounts,
        ]);
    }
}
