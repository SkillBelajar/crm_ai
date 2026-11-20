<?php

namespace Tests\Feature;

use App\Livewire\MeetingIndex;
use App\Livewire\MeetingWorkspace;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use App\Models\UserAiSetting;
use App\Services\AiClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;

class MeetingAndMissionTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Contact $contact;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->contact = Contact::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Bapak Hendra Wijaya',
            'role_or_company' => 'Direktur Operasional PT Mega Sentosa',
            'category' => 'client',
            'primary_need' => 'Kepastian kepatuhan regulasi dan minim komplain dari komisaris',
            'ego_trigger' => 'Diakui sebagai pemimpin visioner yang efisien',
        ]);
    }

    public function test_guest_cannot_access_meetings_or_workspace(): void
    {
        $response = $this->get('/meetings');
        $response->assertRedirect('/login');

        $meeting = Meeting::factory()->create([
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
        ]);

        $responseMeeting = $this->get('/meetings/' . $meeting->id);
        $responseMeeting->assertRedirect('/login');
    }

    public function test_user_can_view_meetings_page_with_version_0_6(): void
    {
        $response = $this->actingAs($this->user)->get('/meetings');

        $response->assertStatus(200);
        $response->assertSee('Workspace Sesi Pertemuan');
        $response->assertSee('Versi: 0.8');
    }

    public function test_user_can_create_new_meeting_via_livewire(): void
    {
        Livewire::actingAs($this->user)
            ->test(MeetingIndex::class)
            ->call('openCreateModal', $this->contact->id)
            ->assertSet('form_contact_id', (string) $this->contact->id)
            ->assertSet('form_biggest_need', 'Kepastian kepatuhan regulasi dan minim komplain dari komisaris')
            ->set('form_title', 'Negosiasi Penandatanganan Kontrak Tahunan')
            ->set('form_user_goal', 'Mendapatkan pembayaran DP 50% dan SLA yang masuk akal')
            ->call('createMeeting')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('meetings', [
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
            'title' => 'Negosiasi Penandatanganan Kontrak Tahunan',
            'biggest_need' => 'Kepastian kepatuhan regulasi dan minim komplain dari komisaris',
            'user_goal' => 'Mendapatkan pembayaran DP 50% dan SLA yang masuk akal',
            'status' => 'draft',
        ]);
    }

    public function test_user_cannot_access_other_users_meeting_workspace_returns_403(): void
    {
        $otherUser = User::factory()->create(['role' => 'user', 'is_active' => true]);
        $otherContact = Contact::factory()->create(['user_id' => $otherUser->id]);

        $otherMeeting = Meeting::factory()->create([
            'user_id' => $otherUser->id,
            'contact_id' => $otherContact->id,
            'title' => 'Pertemuan Rahasia User Lain',
        ]);

        // Attempt to access other user's meeting workspace
        $response = $this->actingAs($this->user)->get('/meetings/' . $otherMeeting->id);
        $response->assertStatus(403);
    }

    public function test_user_can_update_misi_1_notes(): void
    {
        $meeting = Meeting::factory()->create([
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
            'title' => 'Judul Awal',
            'biggest_need' => 'Kebutuhan Awal',
            'user_goal' => 'Goal Awal',
        ]);

        Livewire::actingAs($this->user)
            ->test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('title', 'Judul Diperbarui')
            ->set('biggest_need', 'Ingin kepastian zero-downtime')
            ->set('user_goal', 'Retainer fee bulanan Rp 25 juta')
            ->set('ego_validation_note', 'Puji reputasi perusahaannya di pasar')
            ->call('saveMisi1')
            ->assertHasNoErrors()
            ->assertSet('feedbackType', 'success');

        $this->assertDatabaseHas('meetings', [
            'id' => $meeting->id,
            'title' => 'Judul Diperbarui',
            'biggest_need' => 'Ingin kepastian zero-downtime',
            'user_goal' => 'Retainer fee bulanan Rp 25 juta',
            'ego_validation_note' => 'Puji reputasi perusahaannya di pasar',
        ]);
    }

    public function test_ai_conditional_yes_prompts_user_to_setup_byok_when_not_configured(): void
    {
        $meeting = Meeting::factory()->create([
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
            'biggest_need' => 'Kebutuhan pengujian',
            'user_goal' => 'Goal pengujian',
        ]);

        Livewire::actingAs($this->user)
            ->test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->call('generateConditionalYes')
            ->assertSee('Konfigurasi AI belum diatur');
    }

    public function test_ai_conditional_yes_executes_successfully_with_configured_endpoint(): void
    {
        // Setup mock UserAiSetting
        UserAiSetting::factory()->create([
            'user_id' => $this->user->id,
            'base_url' => 'https://api.openai.com/v1',
            'api_key' => 'sk-test-mock-key',
            'model_name' => 'gpt-4o-mini',
        ]);

        $meeting = Meeting::factory()->create([
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
            'biggest_need' => 'Ingin solusi cepat tanpa repot',
            'user_goal' => 'Mendapatkan data awal dari mereka',
        ]);

        // Mock AiClientService
        $mockAi = Mockery::mock(AiClientService::class);
        $mockAi->shouldReceive('chat')
            ->once()
            ->andReturn([
                'success' => true,
                'reply' => "1. Opsi Santai: \"Bisa banget Pak, asalkan Bapak tugaskan staf untuk siapkan data mentah hari ini.\"\n2. Opsi Profesional: \"Kami siap mendukung penuh...\"",
                'message' => 'Success',
                'latency_ms' => 420,
            ]);

        $this->app->instance(AiClientService::class, $mockAi);

        Livewire::actingAs($this->user)
            ->test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('activeTab', 'misi-2')
            ->call('generateConditionalYes')
            ->assertSet('feedbackType', 'success')
            ->assertSee('Bisa banget Pak, asalkan Bapak tugaskan staf');

        $this->assertDatabaseHas('meetings', [
            'id' => $meeting->id,
            'ai_conditional_yes' => "1. Opsi Santai: \"Bisa banget Pak, asalkan Bapak tugaskan staf untuk siapkan data mentah hari ini.\"\n2. Opsi Profesional: \"Kami siap mendukung penuh...\"",
        ]);
    }

    public function test_ai_psychological_contract_executes_successfully_and_can_be_saved(): void
    {
        UserAiSetting::factory()->create([
            'user_id' => $this->user->id,
            'base_url' => 'https://api.openai.com/v1',
            'api_key' => 'sk-test-mock-key',
            'model_name' => 'gpt-4o-mini',
        ]);

        $meeting = Meeting::factory()->create([
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
            'biggest_need' => 'Kebutuhan kepatuhan regulasi',
            'user_goal' => 'DP 50%',
            'ai_conditional_yes' => 'Lawan bicara setuju kirim berkas legalitas hari ini',
        ]);

        $mockContractMessage = "Yth. Bapak Hendra,\n\nTerima kasih banyak atas diskusi bernas tadi siang...\nSesuai kesepakatan, kami menunggu berkas legalitas dari tim Bapak...";

        $mockAi = Mockery::mock(AiClientService::class);
        $mockAi->shouldReceive('chat')
            ->once()
            ->andReturn([
                'success' => true,
                'reply' => $mockContractMessage,
                'message' => 'Success',
                'latency_ms' => 380,
            ]);

        $this->app->instance(AiClientService::class, $mockAi);

        Livewire::actingAs($this->user)
            ->test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('activeTab', 'misi-3')
            ->call('generateContract')
            ->assertSet('feedbackType', 'success')
            ->assertSee('Yth. Bapak Hendra')
            ->set('status', 'sent')
            ->set('commitment_result', 'Pesan WA sudah terkirim, menunggu balasan dokumen')
            ->call('saveContract')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('meetings', [
            'id' => $meeting->id,
            'status' => 'sent',
            'commitment_result' => 'Pesan WA sudah terkirim, menunggu balasan dokumen',
        ]);
    }

    public function test_user_can_delete_meeting(): void
    {
        $meeting = Meeting::factory()->create([
            'user_id' => $this->user->id,
            'contact_id' => $this->contact->id,
            'title' => 'Sesi yang Akan Dihapus',
        ]);

        Livewire::actingAs($this->user)
            ->test(MeetingIndex::class)
            ->call('confirmDelete', $meeting->id)
            ->assertSet('showDeleteModal', true)
            ->call('deleteMeeting')
            ->assertSet('showDeleteModal', false);

        $this->assertDatabaseMissing('meetings', [
            'id' => $meeting->id,
        ]);
    }
}
