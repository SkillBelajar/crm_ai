<?php

namespace Tests\Feature;

use App\Livewire\HealthCheck;
use Livewire\Livewire;
use Tests\TestCase;

class ArchitectureAndHealthCheckTest extends TestCase
{
    public function test_version_config_is_configured_to_0_1(): void
    {
        $this->assertEquals('0.1', config('app.version'));
    }

    public function test_welcome_page_renders_cleanly_with_version_footer(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('AI Psychological CRM');
        $response->assertSee('Versi: 0.1');
        $response->assertSee('Pancing & Catat', false);
        $response->assertSee('Filtrasi Anti-Lilin');
        $response->assertSee('Kunci Kontrak Psikologis 24 Jam');
    }

    public function test_livewire_health_check_component_runs_and_verifies_services(): void
    {
        $component = Livewire::test(HealthCheck::class);
        
        $this->assertTrue($component->get('dbConnected'), 'DB Message: ' . $component->get('dbMessage'));
        $this->assertTrue($component->get('redisConnected'), 'Redis Message: ' . $component->get('redisMessage'));

        $component->call('checkHealth');

        $this->assertTrue($component->get('dbConnected'));
        $this->assertTrue($component->get('redisConnected'));
    }
}
