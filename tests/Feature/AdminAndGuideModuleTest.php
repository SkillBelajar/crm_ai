<?php

namespace Tests\Feature;

use App\Livewire\AdminDashboard;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use App\Models\UserAiSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAndGuideModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_guide_and_is_redirected_to_login(): void
    {
        $response = $this->get('/guide');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_guide_with_version_0_8(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/guide');

        $response->assertStatus(200);
        $response->assertSee('Panduan Pengguna &amp; Standard Operating Procedure', false);
        $response->assertSee('Setup Endpoint AI Mandiri');
        $response->assertSee('http://213.199.61.184:20130/v1');
        $response->assertSee('Praktik 3 Misi');
        $response->assertSee('Memantau Smart Goal 7 Hari');
        $response->assertSee('Versi: 0.8');
    }

    public function test_admin_can_access_guide_and_sees_admin_sop(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/guide');

        $response->assertStatus(200);
        $response->assertSee('Panduan Admin SaaS');
        $response->assertSee('Manajemen Pengguna &amp; Proteksi Status Akun', false);
        $response->assertSee('Pemantauan Arsitektur &amp; Diagnostik Sistem', false);
        $response->assertSee('Kebijakan Privasi Kunci AI Mandiri (BYOK)');
        $response->assertSee('/system-health');
    }

    public function test_guest_cannot_access_admin_panel(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin_panel_returns_403(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard_with_kpis(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Create 2 regular users
        $user1 = User::factory()->create(['role' => 'user', 'is_active' => true]);
        $user2 = User::factory()->create(['role' => 'user', 'is_active' => false]);

        // User 1 has AI setting
        UserAiSetting::factory()->create([
            'user_id' => $user1->id,
            'is_verified' => true,
        ]);

        // Create contact & meeting
        $contact = Contact::factory()->create(['user_id' => $user1->id]);
        Meeting::factory()->create([
            'user_id' => $user1->id,
            'contact_id' => $contact->id,
            'status' => Meeting::STATUS_COMMITTED,
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Panel Admin SaaS');
        $response->assertSee('Versi: 0.8');

        // Test Livewire component data
        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->assertViewHas('totalRegularUsers', 2)
            ->assertViewHas('activeRegularUsers', 1)
            ->assertViewHas('totalAiConfigured', 1)
            ->assertViewHas('totalContacts', 1)
            ->assertViewHas('totalMeetings', 1)
            ->assertViewHas('committedMeetings', 1)
            ->assertViewHas('conversionRate', 100);
    }

    public function test_admin_can_search_users_in_real_time(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $userA = User::factory()->create(['name' => 'Budi Santoso', 'email' => 'budi@example.com']);
        $userB = User::factory()->create(['name' => 'Siti Rahma', 'email' => 'siti@example.com']);

        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->set('search', 'Budi')
            ->assertSee('Budi Santoso')
            ->assertSee('budi@example.com')
            ->assertDontSee('Siti Rahma')
            ->set('search', 'siti@example.com')
            ->assertSee('Siti Rahma')
            ->assertDontSee('Budi Santoso');
    }

    public function test_admin_can_filter_users_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $activeUser = User::factory()->create(['name' => 'Pengguna Aktif', 'is_active' => true]);
        $suspendedUser = User::factory()->create(['name' => 'Pengguna Ditangguhkan', 'is_active' => false]);

        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->set('statusFilter', 'active')
            ->assertSee('Pengguna Aktif')
            ->assertDontSee('Pengguna Ditangguhkan')
            ->set('statusFilter', 'suspended')
            ->assertSee('Pengguna Ditangguhkan')
            ->assertDontSee('Pengguna Aktif');
    }

    public function test_admin_can_toggle_user_status_suspend_and_activate(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $targetUser = User::factory()->create(['name' => 'Target User', 'is_active' => true]);

        // Suspend user
        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->call('toggleUserStatus', $targetUser->id)
            ->assertSee('berhasil dinonaktifkan (suspended)');

        $this->assertFalse($targetUser->fresh()->is_active);

        // Reactivate user
        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->call('toggleUserStatus', $targetUser->id)
            ->assertSee('berhasil diaktifkan kembali');

        $this->assertTrue($targetUser->fresh()->is_active);
    }

    public function test_admin_cannot_suspend_self_or_other_admin(): void
    {
        $admin = User::factory()->create(['name' => 'Admin Utama', 'role' => 'admin', 'is_active' => true]);
        $otherAdmin = User::factory()->create(['name' => 'Admin Kedua', 'role' => 'admin', 'is_active' => true]);

        // Try suspending self
        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->call('toggleUserStatus', $admin->id)
            ->assertSee('Anda tidak dapat menonaktifkan akun Anda sendiri');

        $this->assertTrue($admin->fresh()->is_active);

        // Try suspending other admin
        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->call('toggleUserStatus', $otherAdmin->id)
            ->assertSee('Akun dengan role Administrator tidak dapat dinonaktifkan');

        $this->assertTrue($otherAdmin->fresh()->is_active);
    }
}
