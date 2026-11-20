<?php

namespace Tests\Feature;

use App\Livewire\MeetingWorkspace;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\MeetingLog;
use App\Models\User;
use App\Models\UserAiSetting;
use App\Services\StrategyAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;

class MeetingLogAndFollowUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_logs_tab_on_meeting_workspace(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $meeting = Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
        ]);

        MeetingLog::create([
            'meeting_id' => $meeting->id,
            'user_id' => $user->id,
            'channel' => MeetingLog::CHANNEL_WHATSAPP,
            'sentiment' => MeetingLog::SENTIMENT_POSITIVE,
            'content' => 'Target antusias menyetujui pertemuan besok',
            'logged_at' => now()->subHour(),
        ]);

        $this->actingAs($user);

        $this->assertSame(MeetingLog::CHANNEL_NOTE, array_key_first(MeetingLog::CHANNELS));

        Livewire::test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->assertSet('newLogChannel', MeetingLog::CHANNEL_NOTE)
            ->call('setTab', 'logs')
            ->assertSee('Log History')
            ->assertSee('Rekomendasi Taktis AI')
            ->assertSee('Target antusias menyetujui pertemuan besok')
            ->assertSee('WhatsApp')
            ->assertSee('Positif / Tertarik')
            ->assertSee('Catatan Internal');
    }

    public function test_user_can_add_log_entry_to_meeting(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $meeting = Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
        ]);

        $this->actingAs($user);

        Livewire::test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('activeTab', 'logs')
            ->set('newLogChannel', MeetingLog::CHANNEL_CALL)
            ->set('newLogSentiment', MeetingLog::SENTIMENT_NEGOTIATION)
            ->set('newLogContent', 'Telepon 15 menit: target meminta diskon termin pembayaran tahap dua.')
            ->call('addLog')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('meeting_logs', [
            'meeting_id' => $meeting->id,
            'user_id' => $user->id,
            'channel' => MeetingLog::CHANNEL_CALL,
            'sentiment' => MeetingLog::SENTIMENT_NEGOTIATION,
            'content' => 'Telepon 15 menit: target meminta diskon termin pembayaran tahap dua.',
        ]);
    }

    public function test_user_can_delete_their_own_log_entry(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $meeting = Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
        ]);

        $log = MeetingLog::create([
            'meeting_id' => $meeting->id,
            'user_id' => $user->id,
            'channel' => MeetingLog::CHANNEL_NOTE,
            'sentiment' => MeetingLog::SENTIMENT_NEUTRAL,
            'content' => 'Catatan internal sementara',
            'logged_at' => now(),
        ]);

        $this->actingAs($user);

        Livewire::test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('activeTab', 'logs')
            ->call('deleteLog', $log->id);

        $this->assertDatabaseMissing('meeting_logs', [
            'id' => $log->id,
        ]);
    }

    public function test_user_cannot_delete_other_users_log(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $contact1 = Contact::factory()->create(['user_id' => $user1->id]);
        $meeting1 = Meeting::factory()->create([
            'user_id' => $user1->id,
            'contact_id' => $contact1->id,
        ]);

        $contact2 = Contact::factory()->create(['user_id' => $user2->id]);
        $meeting2 = Meeting::factory()->create([
            'user_id' => $user2->id,
            'contact_id' => $contact2->id,
        ]);

        $foreignLog = MeetingLog::create([
            'meeting_id' => $meeting2->id,
            'user_id' => $user2->id,
            'channel' => MeetingLog::CHANNEL_NOTE,
            'sentiment' => MeetingLog::SENTIMENT_NEUTRAL,
            'content' => 'Rahasia user 2',
            'logged_at' => now(),
        ]);

        $this->actingAs($user1);

        Livewire::test(MeetingWorkspace::class, ['meeting' => $meeting1])
            ->call('deleteLog', $foreignLog->id);

        // Foreign log must still exist in DB
        $this->assertDatabaseHas('meeting_logs', [
            'id' => $foreignLog->id,
        ]);
    }

    public function test_generate_follow_update_creates_adaptive_strategy_and_saves_to_meeting(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'user_id' => $user->id,
            'name' => 'Bambang Sudarmono',
            'ego_trigger' => 'Suka dihormati dan memegang kendali keputusan',
            'primary_need' => 'Efisiensi biaya dan prestise',
        ]);
        $meeting = Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'user_goal' => 'Mendapatkan tanda tangan kontrak layanan AI',
        ]);

        // Create log entries
        MeetingLog::create([
            'meeting_id' => $meeting->id,
            'user_id' => $user->id,
            'channel' => MeetingLog::CHANNEL_WHATSAPP,
            'sentiment' => MeetingLog::SENTIMENT_OBJECTION,
            'content' => 'Pak Bambang ragu karena timnya belum pernah pakai AI sebelumnya.',
            'logged_at' => now()->subDay(),
        ]);

        MeetingLog::create([
            'meeting_id' => $meeting->id,
            'user_id' => $user->id,
            'channel' => MeetingLog::CHANNEL_CALL,
            'sentiment' => MeetingLog::SENTIMENT_NEGOTIATION,
            'content' => 'Sudah dijelaskan ada pendampingan, dia tanya apakah ada garansi implementasi.',
            'logged_at' => now()->subHours(2),
        ]);

        // Mock StrategyAiService to avoid external API calls during testing
        $mockService = Mockery::mock(StrategyAiService::class);
        $mockService->shouldReceive('generateFollowUpdateStrategy')
            ->once()
            ->andReturn([
                'success' => true,
                'content' => "### ANALISIS POSISI PSIKOLOGIS\nTarget ingin merasa aman dan diakui.\n\n### DRAF PESAN FOLLOW-UP\nSelamat siang Pak Bambang, terkait pendampingan kemarin kami siapkan klausul khusus jaminan implementasi langsung untuk Bapak.",
                'message' => 'Success',
            ]);

        $this->app->instance(StrategyAiService::class, $mockService);

        $this->actingAs($user);

        Livewire::test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('activeTab', 'logs')
            ->call('generateFollowUpdate')
            ->assertSet('latest_ai_strategy', "### ANALISIS POSISI PSIKOLOGIS\nTarget ingin merasa aman dan diakui.\n\n### DRAF PESAN FOLLOW-UP\nSelamat siang Pak Bambang, terkait pendampingan kemarin kami siapkan klausul khusus jaminan implementasi langsung untuk Bapak.");

        $meeting->refresh();
        $this->assertStringContainsString('klausul khusus jaminan implementasi', $meeting->latest_ai_strategy);
        $this->assertNotNull($meeting->latest_ai_strategy_at);
    }

    public function test_user_can_edit_and_save_ai_strategy_manually(): void
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $meeting = Meeting::factory()->create([
            'user_id' => $user->id,
            'contact_id' => $contact->id,
            'latest_ai_strategy' => 'Draf awal dari AI',
        ]);

        $this->actingAs($user);

        Livewire::test(MeetingWorkspace::class, ['meeting' => $meeting])
            ->set('activeTab', 'logs')
            ->set('latest_ai_strategy', 'Draf yang sudah diedit manual oleh user.')
            ->call('saveStrategy');

        $meeting->refresh();
        $this->assertEquals('Draf yang sudah diedit manual oleh user.', $meeting->latest_ai_strategy);
    }
}
