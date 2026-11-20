<?php

namespace App\Livewire;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app', ['title' => 'Detail Kontak Psikologis — MindControl CRM'])]
class ContactShow extends Component
{
    public Contact $contact;

    // Edit Modal state
    public bool $showEditModal = false;
    public string $name = '';
    public string $role_or_company = '';
    public string $phone_or_contact = '';
    public string $category = 'client';
    public string $primary_need = '';
    public string $ego_trigger = '';
    public string $notes = '';

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
    ];

    public function mount(Contact $contact): void
    {
        // Enforce SaaS per-user data isolation (403 Forbidden)
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk melihat profil kontak ini.');
        }

        $this->contact = $contact;
        $this->fillForm();
    }

    public function fillForm(): void
    {
        $this->name = $this->contact->name;
        $this->role_or_company = $this->contact->role_or_company ?? '';
        $this->phone_or_contact = $this->contact->phone_or_contact ?? '';
        $this->category = $this->contact->category;
        $this->primary_need = $this->contact->primary_need ?? '';
        $this->ego_trigger = $this->contact->ego_trigger ?? '';
        $this->notes = $this->contact->notes ?? '';
    }

    public function openEditModal(): void
    {
        $this->fillForm();
        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->fillForm();
        $this->resetValidation();
    }

    public function updateContact(): void
    {
        $validated = $this->validate();

        $this->contact->update($validated);
        $this->contact->refresh();

        $this->showEditModal = false;
        $this->successMessage = 'Profil psikologis kontak berhasil diperbarui.';
    }

    public function dismissNotification(): void
    {
        $this->successMessage = null;
    }

    public function render()
    {
        return view('livewire.contact-show', [
            'categories' => Contact::CATEGORIES,
        ]);
    }
}
