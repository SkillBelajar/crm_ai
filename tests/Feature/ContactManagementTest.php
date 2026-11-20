<?php

namespace Tests\Feature;

use App\Livewire\ContactIndex;
use App\Livewire\ContactShow;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ContactManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $userA;
    private User $userB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userA = User::create([
            'name' => 'User Eksekutif A',
            'email' => 'usera@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->userB = User::create([
            'name' => 'User Eksekutif B',
            'email' => 'userb@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }

    public function test_guest_cannot_access_contacts_index_or_detail(): void
    {
        $responseIndex = $this->get('/contacts');
        $responseIndex->assertRedirect('/login');

        $contact = Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Bapak Budi',
            'category' => 'client',
        ]);

        $responseDetail = $this->get("/contacts/{$contact->id}");
        $responseDetail->assertRedirect('/login');
    }

    public function test_user_can_access_contact_index_with_version_0_5(): void
    {
        $response = $this->actingAs($this->userA)->get('/contacts');

        $response->assertStatus(200);
        $response->assertSee('Kontak CRM');
        $response->assertSee('Versi: 0.7');
        $response->assertSee('+ Tambah Kontak');
    }

    public function test_user_can_create_new_contact_via_livewire(): void
    {
        $this->actingAs($this->userA);

        Livewire::test(ContactIndex::class)
            ->call('openCreateModal')
            ->set('name', 'Bapak Suryono')
            ->set('role_or_company', 'Direktur PT Cahaya Abadi')
            ->set('phone_or_contact', '08123456789')
            ->set('category', 'client')
            ->set('primary_need', 'Ingin menaikkan omzet tanpa menambah beban headcount')
            ->set('ego_trigger', 'Suka dipuji keahlian strategis dan kepemimpinannya')
            ->set('notes', 'Bertemu via seminar bisnis di Jakarta')
            ->call('save')
            ->assertSee("Kontak 'Bapak Suryono' berhasil ditambahkan ke CRM.");

        $this->assertDatabaseHas('contacts', [
            'user_id' => $this->userA->id,
            'name' => 'Bapak Suryono',
            'role_or_company' => 'Direktur PT Cahaya Abadi',
            'category' => 'client',
            'primary_need' => 'Ingin menaikkan omzet tanpa menambah beban headcount',
        ]);
    }

    public function test_user_can_search_contacts_in_real_time(): void
    {
        $this->actingAs($this->userA);

        Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Dr. Gunawan',
            'role_or_company' => 'Dekan Fakultas',
            'category' => 'partner',
            'primary_need' => 'Butuh sertifikasi akreditasi internasional',
        ]);

        Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Rina Wijaya',
            'role_or_company' => 'Founder Startup Edukasi',
            'category' => 'prospect',
            'primary_need' => 'Mencari investor awal tahap pre-seed',
        ]);

        // Search by name
        Livewire::test(ContactIndex::class)
            ->set('search', 'Gunawan')
            ->assertSee('Dr. Gunawan')
            ->assertDontSee('Rina Wijaya');

        // Search by primary need keyword
        Livewire::test(ContactIndex::class)
            ->set('search', 'pre-seed')
            ->assertSee('Rina Wijaya')
            ->assertDontSee('Dr. Gunawan');
    }

    public function test_user_can_filter_contacts_by_category(): void
    {
        $this->actingAs($this->userA);

        Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Klien Alpha',
            'category' => 'client',
        ]);

        Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Partner Beta',
            'category' => 'partner',
        ]);

        Livewire::test(ContactIndex::class)
            ->set('categoryFilter', 'client')
            ->assertSee('Klien Alpha')
            ->assertDontSee('Partner Beta');
    }

    public function test_user_can_update_contact_via_livewire(): void
    {
        $this->actingAs($this->userA);

        $contact = Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Nama Lama',
            'category' => 'client',
        ]);

        Livewire::test(ContactIndex::class)
            ->call('openEditModal', $contact->id)
            ->set('name', 'Nama Baru Terkoreksi')
            ->set('primary_need', 'Kebutuhan baru teridentifikasi')
            ->call('save')
            ->assertSee("berhasil diperbarui");

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Nama Baru Terkoreksi',
            'primary_need' => 'Kebutuhan baru teridentifikasi',
        ]);
    }

    public function test_user_can_delete_contact(): void
    {
        $this->actingAs($this->userA);

        $contact = Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Kontak Akan Dihapus',
            'category' => 'other',
        ]);

        Livewire::test(ContactIndex::class)
            ->call('confirmDelete', $contact->id)
            ->call('deleteContact')
            ->assertSee("telah dihapus");

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_user_can_view_contact_detail_and_sees_v0_5(): void
    {
        $contact = Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Ir. Hartono',
            'role_or_company' => 'CTO Megatech',
            'phone_or_contact' => '0878-999-000',
            'category' => 'client',
            'primary_need' => 'Migrasi sistem legacy tanpa downtime operasional',
            'ego_trigger' => 'Diakui sebagai arsitek software paling handal',
            'notes' => 'Senang meeting di pagi hari jam 09:00',
        ]);

        $response = $this->actingAs($this->userA)->get("/contacts/{$contact->id}");

        $response->assertStatus(200);
        $response->assertSee('Ir. Hartono');
        $response->assertSee('CTO Megatech');
        $response->assertSee('Migrasi sistem legacy tanpa downtime operasional');
        $response->assertSee('Diakui sebagai arsitek software paling handal');
        $response->assertSee('Versi: 0.7');
    }

    public function test_user_cannot_view_or_access_other_users_contact_returns_403(): void
    {
        // Contact belongs to User A
        $contactA = Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Kontak Rahasia User A',
            'category' => 'client',
        ]);

        // User B tries to view User A's contact
        $response = $this->actingAs($this->userB)->get("/contacts/{$contactA->id}");

        $response->assertStatus(403);
    }

    public function test_user_cannot_see_other_users_contacts_in_index(): void
    {
        Contact::create([
            'user_id' => $this->userA->id,
            'name' => 'Kontak Milik User A',
            'category' => 'client',
        ]);

        Contact::create([
            'user_id' => $this->userB->id,
            'name' => 'Kontak Milik User B',
            'category' => 'client',
        ]);

        // When User A views index, User B's contact is never rendered
        Livewire::actingAs($this->userA)
            ->test(ContactIndex::class)
            ->assertSee('Kontak Milik User A')
            ->assertDontSee('Kontak Milik User B');
    }
}
