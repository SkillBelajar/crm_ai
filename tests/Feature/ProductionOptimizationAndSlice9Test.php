<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductionOptimizationAndSlice9Test extends TestCase
{
    use RefreshDatabase;

    public function test_application_version_is_strictly_1_0(): void
    {
        $this->assertEquals('1.0', config('app.version'));
    }

    public function test_custom_403_error_page_renders_cleanly(): void
    {
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);

        $contact = Contact::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get(route('contacts.show', $contact));

        $response->assertStatus(403);
        $response->assertSee('403');
        $response->assertSee('Akses Ditolak');
        $response->assertSee('Kembali ke Dashboard / Beranda');
        $response->assertSee('Versi: 1.0');
    }

    public function test_custom_404_error_page_renders_cleanly(): void
    {
        $response = $this->get('/non-existent-high-concurrency-route');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Halaman Tidak Ada');
        $response->assertSee('Kembali ke Dashboard / Beranda');
        $response->assertSee('Versi: 1.0');
    }

    public function test_database_performance_indexes_exist(): void
    {
        $this->assertTrue(Schema::hasTable('meetings'));
        $this->assertTrue(Schema::hasTable('contacts'));

        $meetingIndexes = Schema::getIndexes('meetings');
        $meetingIndexNames = array_column($meetingIndexes, 'name');

        $this->assertContains('meetings_user_created_idx', $meetingIndexNames);
        $this->assertContains('meetings_user_deadline_idx', $meetingIndexNames);
        $this->assertContains('meetings_user_meeting_date_idx', $meetingIndexNames);

        $contactIndexes = Schema::getIndexes('contacts');
        $contactIndexNames = array_column($contactIndexes, 'name');

        $this->assertContains('contacts_user_created_idx', $contactIndexNames);
    }

    public function test_saas_multi_tenant_isolation_is_strictly_enforced(): void
    {
        $owner = User::factory()->create(['role' => 'user']);
        $intruder = User::factory()->create(['role' => 'user']);

        $contact = Contact::factory()->create([
            'user_id' => $owner->id,
            'name' => 'Klien Rahasia Owner',
        ]);

        $meeting = Meeting::factory()->create([
            'user_id' => $owner->id,
            'contact_id' => $contact->id,
            'title' => 'Sesi Rahasia',
        ]);

        // Intruder accessing contact detail -> 403
        $this->actingAs($intruder)->get(route('contacts.show', $contact))->assertStatus(403);

        // Intruder accessing meeting workspace -> 403
        $this->actingAs($intruder)->get(route('meetings.show', $meeting))->assertStatus(403);
    }
}
