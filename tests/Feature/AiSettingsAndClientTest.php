<?php

namespace Tests\Feature;

use App\Livewire\AiSettingsForm;
use App\Models\User;
use App\Models\UserAiSetting;
use App\Services\AiClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AiSettingsAndClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_ai_settings_and_is_redirected(): void
    {
        $response = $this->get('/ai-settings');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_ai_settings_page_with_version_0_5(): void
    {
        $user = User::create([
            'name' => 'Tester Eksekutif',
            'email' => 'eksekutif@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/ai-settings');

        $response->assertStatus(200);
        $response->assertSee('Pengaturan AI Mandiri (BYOK)');
        $response->assertSee('Versi: 0.6');
        $response->assertSee('Base URL Endpoint');
        $response->assertSee('Test Koneksi AI');
        $response->assertSee('Simpan Pengaturan');
    }

    public function test_user_can_save_ai_settings_via_livewire(): void
    {
        $user = User::create([
            'name' => 'Setting User',
            'email' => 'setting@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        Livewire::test(AiSettingsForm::class)
            ->set('base_url', 'http://213.199.61.184:20130/v1')
            ->set('api_key', 'sk-test-secret-key-123')
            ->set('model_name', 'gpt-4o-mini')
            ->call('save')
            ->assertSee('Pengaturan AI Mandiri (BYOK) berhasil disimpan');

        $this->assertDatabaseHas('user_ai_settings', [
            'user_id' => $user->id,
            'base_url' => 'http://213.199.61.184:20130/v1',
            'model_name' => 'gpt-4o-mini',
        ]);

        // Verify Eloquent decrypts the key transparently
        $freshSetting = $user->fresh()->aiSetting;
        $this->assertEquals('sk-test-secret-key-123', $freshSetting->api_key);
    }

    public function test_api_key_is_stored_encrypted_in_raw_database(): void
    {
        $user = User::create([
            'name' => 'Crypto User',
            'email' => 'crypto@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        UserAiSetting::create([
            'user_id' => $user->id,
            'base_url' => 'https://api.openai.com/v1',
            'api_key' => 'secret-super-safe-api-token',
            'model_name' => 'gpt-4o',
            'is_verified' => false,
        ]);

        // Inspect raw database column to verify it is NOT plain text
        $rawRecord = DB::table('user_ai_settings')->where('user_id', $user->id)->first();
        $this->assertNotEquals('secret-super-safe-api-token', $rawRecord->api_key);
        $this->assertStringStartsWith('eyJ', $rawRecord->api_key); // Laravel encrypted payload starts with base64 JSON
    }

    public function test_ai_client_service_test_connection_success_with_mocked_http(): void
    {
        Http::fake([
            'http://213.199.61.184:20130/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'OK',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = new AiClientService();
        $result = $service->testConnection('http://213.199.61.184:20130/v1', 'test-key', 'gpt-4o-mini');

        $this->assertTrue($result['success']);
        $this->assertEquals('OK', $result['reply']);
        $this->assertStringContainsString('Koneksi berhasil', $result['message']);
        $this->assertGreaterThanOrEqual(0, $result['latency_ms']);
    }

    public function test_ai_client_service_handles_unauthorized_401(): void
    {
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'error' => [
                    'message' => 'Incorrect API key provided.',
                    'type' => 'invalid_request_error',
                ],
            ], 401),
        ]);

        $service = new AiClientService();
        $result = $service->testConnection('https://api.openai.com/v1', 'wrong-key', 'gpt-4o');

        $this->assertFalse($result['success']);
        $this->assertNull($result['reply']);
        $this->assertStringContainsString('401', $result['message']);
        $this->assertStringContainsString('Incorrect API key provided', $result['message']);
    }

    public function test_ai_client_service_chat_method_sends_proper_payload(): void
    {
        Http::fake([
            'http://213.199.61.184:20130/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'Conditional Yes: Tentu kami bisa bantu, asal Anda lengkapi data X.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::create([
            'name' => 'Chat User',
            'email' => 'chat@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $setting = UserAiSetting::create([
            'user_id' => $user->id,
            'base_url' => 'http://213.199.61.184:20130/v1',
            'api_key' => 'token-abc',
            'model_name' => 'llama-3.1-8b',
            'is_verified' => true,
        ]);

        $service = new AiClientService();
        $chatResult = $service->chat(
            $setting,
            [['role' => 'user', 'content' => 'Analisa percakapan ini']]
        );

        $this->assertTrue($chatResult['success']);
        $this->assertStringContainsString('Conditional Yes', $chatResult['content']);
        $this->assertEquals(200, $chatResult['status_code']);
    }

    public function test_livewire_test_connection_action_verifies_setting(): void
    {
        Http::fake([
            'http://213.199.61.184:20130/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'OK',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::create([
            'name' => 'Verify User',
            'email' => 'verify@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        Livewire::test(AiSettingsForm::class)
            ->set('base_url', 'http://213.199.61.184:20130/v1')
            ->set('api_key', 'valid-key')
            ->set('model_name', 'gpt-4o-mini')
            ->call('testConnection')
            ->assertSet('is_verified', true)
            ->assertSet('testSuccess', true)
            ->assertSee('Uji Koneksi Berhasil');

        $this->assertDatabaseHas('user_ai_settings', [
            'user_id' => $user->id,
            'is_verified' => true,
        ]);
    }
}
