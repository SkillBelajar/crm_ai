<?php

namespace Tests\Feature;

use App\Livewire\UserDashboard;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use App\Models\UserAiSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard_and_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_authenticated_user_can_access_dashboard_with_version_0_7(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Pusat Kendali Eksekutif');
        $response->assertSee('Selamat datang, ' . $user->name);
        $response->assertSee('Smart Goal 7 Hari');
        $response->assertSee('Versi: 0.7');
    }

    public function test_dashboard_computes_7_day_metrics_and_conversion_rate(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $contact = Contact::factory()->create(['user_id' => $user->id]);

        // Meeting 1: within 7 days, committed
        Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'status' => Meeting::STATUS_COMMITTED,
            'created_at' => now()->subDays(2),
        ]);

        // Meeting 2: within 7 days, sent
        Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'status' => Meeting::STATUS_SENT,
            'created_at' => now()->subDays(3),
        ]);

        // Meeting 3: within 7 days, draft
        Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'status' => Meeting::STATUS_DRAFT,
            'created_at' => now()->subDays(1),
            'contract_deadline_at' => now()->addHours(10),
        ]);

        // Meeting 4: older than 7 days (should not be counted in 7-day stats)
        Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'status' => Meeting::STATUS_COMMITTED,
            'created_at' => now()->subDays(15),
        ]);

        $component = Livewire::actingAs($user)->test(UserDashboard::class);

        $component->assertSee('Total Pertemuan (7 Hari)');
        // 3 meetings created in 7 days
        $this->assertEquals(3, $component->viewData('totalMeetings7Days'));
        // 1 committed in 7 days
        $this->assertEquals(1, $component->viewData('committed7Days'));
        // Conversion rate: 1 / 3 = 33%
        $this->assertEquals(33, $component->viewData('conversionRate'));
        // Pending follow up: 1 draft
        $this->assertEquals(1, $component->viewData('pendingFollowUpCount'));
        // Total contact: 1
        $this->assertEquals(1, $component->viewData('totalContacts'));
        // Locked: committed + sent = 2 out of 3 = 67%
        $this->assertEquals(2, $component->viewData('locked7Days'));
        $this->assertEquals(67, $component->viewData('goalProgressPercent'));
    }

    public function test_dashboard_displays_urgent_24h_action_list(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $contact = Contact::factory()->create(['user_id' => $user->id, 'name' => 'Klien Prioritas']);

        $urgentMeeting = Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'title' => 'Negosiasi Kontrak Tahunan',
            'status' => Meeting::STATUS_DRAFT,
            'contract_deadline_at' => now()->addHours(3),
            'biggest_need' => 'Diskon volume 20% dan termin 60 hari',
        ]);

        Livewire::actingAs($user)->test(UserDashboard::class)
            ->assertSee('Prioritas Batas 24 Jam (Misi 3)')
            ->assertSee('Negosiasi Kontrak Tahunan')
            ->assertSee('Klien Prioritas')
            ->assertSee('Diskon volume 20% dan termin 60 hari')
            ->assertSee('Buka Workspace')
            ->assertSeeHtml('/meetings/' . $urgentMeeting->id);
    }

    public function test_dashboard_displays_positive_empty_state_when_no_urgent_meetings(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        Livewire::actingAs($user)->test(UserDashboard::class)
            ->assertSee('Semua pertemuan sudah ditindaklanjuti!')
            ->assertSee('+ Mulai Sesi Pertemuan Baru');
    }

    public function test_dashboard_displays_conditional_ai_banner(): void
    {
        $userWithoutAi = User::factory()->create(['role' => 'user']);

        // Without verified AI
        Livewire::actingAs($userWithoutAi)->test(UserDashboard::class)
            ->assertSee('Endpoint AI Strategist Belum Terhubung')
            ->assertSee('Atur Endpoint AI Sekarang')
            ->assertSee('AI Mandiri Belum Diatur');

        // With verified AI
        UserAiSetting::factory()->create([
            'user_id' => $userWithoutAi->id,
            'is_verified' => true,
            'model_name' => 'gpt-4o-mini',
        ]);
        $userWithoutAi->refresh();

        Livewire::actingAs($userWithoutAi)->test(UserDashboard::class)
            ->assertDontSee('Endpoint AI Strategist Belum Terhubung')
            ->assertSee('AI Strategist Aktif (Model: gpt-4o-mini)');
    }

    public function test_dashboard_strictly_isolates_multi_tenant_data(): void
    {
        $userA = User::factory()->create(['role' => 'user']);
        $userB = User::factory()->create(['role' => 'user']);

        $contactB = Contact::factory()->create([
            'user_id' => $userB->id,
            'name' => 'Kontak Rahasia User B',
        ]);

        Meeting::factory()->create([
            'user_id' => $userB->id,
            'contact_id' => $contactB->id,
            'title' => 'Pertemuan Rahasia User B',
            'status' => Meeting::STATUS_DRAFT,
            'contract_deadline_at' => now()->addHours(2),
        ]);

        // User A tests dashboard
        Livewire::actingAs($userA)->test(UserDashboard::class)
            ->assertDontSee('Kontak Rahasia User B')
            ->assertDontSee('Pertemuan Rahasia User B')
            ->assertSee('Semua pertemuan sudah ditindaklanjuti!');
    }
}
