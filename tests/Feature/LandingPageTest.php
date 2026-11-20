<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_renders_with_executive_minimalist_sections_and_v0_2(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('MindControl CRM');
        $response->assertSee('Pendengar &amp; Pengendali', false);
        $response->assertSee('Jadilah', false);
        $response->assertSee('100% Gratis &bull; SaaS Berbasis AI Mandiri (BYOK)', false);
        $response->assertSee('Pancing &amp; Catat', false);
        $response->assertSee('Filtrasi &ldquo;Anti-Lilin&rdquo;', false);
        $response->assertSee('Kunci Kontrak Psikologis', false);
        $response->assertSee('Keunggulan SaaS Gratis &amp; AI Mandiri (BYOK)', false);
        $response->assertSee('Cara Kerja dalam 3 Langkah Praktis', false);
        $response->assertSee('Versi: 0.2');
    }

    public function test_auth_placeholder_routes_respond_with_200(): void
    {
        $loginResponse = $this->get('/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('Portal Masuk (Login)');
        $loginResponse->assertSee('Versi: 0.2');

        $registerResponse = $this->get('/register');
        $registerResponse->assertStatus(200);
        $registerResponse->assertSee('Pendaftaran Akun Gratis');
        $registerResponse->assertSee('Versi: 0.2');
    }
}
