<?php

namespace Tests\Feature;

use App\Livewire\HealthCheck;
use Livewire\Livewire;
use Tests\TestCase;

class ArchitectureAndHealthCheckTest extends TestCase
{
    public function test_version_config_is_configured_to_0_2(): void
    {
        $this->assertEquals('0.2', config('app.version'));
    }

    public function test_system_health_page_renders_cleanly_with_diagnostics_and_version_footer(): void
    {
        $response = $this->get('/system-health');

        $response->assertStatus(200);
        $response->assertSee('AI Psychological CRM');
        $response->assertSee('Diagnostik System');
        $response->assertSee('Versi: 0.2');
        $response->assertSee('MySQL 8.0');
        $response->assertSee('Redis Alpine');
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
