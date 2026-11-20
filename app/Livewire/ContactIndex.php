<?php

namespace App\Livewire;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app', ['title' => 'Kontak CRM — MindControl CRM'])]
class ContactIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'kategori')]
    public string $categoryFilter = '';

    // Modal Create / Edit
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $contactId = null;

    // Form fields
    public string $name = '';
    public string $role_or_company = '';
    public string $phone_or_contact = '';
    public string $category = 'client';
    public string $primary_need = '';
    public string $ego_trigger = '';
    public string $notes = '';

    // Modal Delete
    public bool $showDeleteModal = false;
    public ?int $contactToDeleteId = null;
    public string $contactToDeleteName = '';

    // Notification toast
    public ?string $successMessage = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'role_or_company' => ['nullable', 'string', 'max:255'],
            'phone_or_contact' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'string', 'in:client,prospect,partner,colleague,other'],
            'primary_need' => ['nullable', 'string', 'max:2000'],
            'ego_trigger' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    protected array $messages = [
        'name.required' => 'Nama lengkap kontak wajib diisi.',
        'name.min' => 'Nama kontak minimal 2 karakter.',
        'category.required' => 'Kategori kontak wajib dipilih.',
        'category.in' => 'Kategori yang dipilih tidak valid.',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isEditing = false;
        $this->contactId = null;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $this->resetForm();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contact = $user->contacts()->findOrFail($id);

        $this->contactId = $contact->id;
        $this->name = $contact->name;
        $this->role_or_company = $contact->role_or_company ?? '';
        $this->phone_or_contact = $contact->phone_or_contact ?? '';
        $this->category = $contact->category;
        $this->primary_need = $contact->primary_need ?? '';
        $this->ego_trigger = $contact->ego_trigger ?? '';
        $this->notes = $contact->notes ?? '';

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm(): void
    {
        $this->name = '';
        $this->role_or_company = '';
        $this->phone_or_contact = '';
        $this->category = 'client';
        $this->primary_need = '';
        $this->ego_trigger = '';
        $this->notes = '';
    }

    public function save(): void
    {
        $validated = $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($this->isEditing && $this->contactId) {
            $contact = $user->contacts()->findOrFail($this->contactId);
            $contact->update($validated);
            $this->successMessage = "Kontak '{$contact->name}' berhasil diperbarui.";
        } else {
            $contact = $user->contacts()->create($validated);
            $this->successMessage = "Kontak '{$contact->name}' berhasil ditambahkan ke CRM.";
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contact = $user->contacts()->findOrFail($id);

        $this->contactToDeleteId = $contact->id;
        $this->contactToDeleteName = $contact->name;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->contactToDeleteId = null;
        $this->contactToDeleteName = '';
    }

    public function deleteContact(): void
    {
        if (! $this->contactToDeleteId) {
            return;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $contact = $user->contacts()->findOrFail($this->contactToDeleteId);
        $name = $contact->name;

        $contact->delete();

        $this->showDeleteModal = false;
        $this->contactToDeleteId = null;
        $this->contactToDeleteName = '';
        $this->successMessage = "Kontak '{$name}' telah dihapus.";
    }

    public function dismissNotification(): void
    {
        $this->successMessage = null;
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->contacts()->latest();

        if (trim($this->search) !== '') {
            $searchTerm = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('role_or_company', 'like', $searchTerm)
                    ->orWhere('primary_need', 'like', $searchTerm)
                    ->orWhere('phone_or_contact', 'like', $searchTerm);
            });
        }

        if ($this->categoryFilter !== '') {
            $query->where('category', $this->categoryFilter);
        }

        $contacts = $query->paginate(10);
        $totalContacts = $user->contacts()->count();

        return view('livewire.contact-index', [
            'contacts' => $contacts,
            'totalContacts' => $totalContacts,
            'categories' => Contact::CATEGORIES,
        ]);
    }
}
