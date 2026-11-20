<?php

namespace Tests\Feature;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AuthenticationAndRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_with_livewire_and_version_0_3(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk ke Akun');
        $response->assertSee('Versi: 0.3');
        $response->assertSee('Ingat Saya');
    }

    public function test_register_page_renders_with_livewire_and_version_0_3(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Gratis');
        $response->assertSee('Versi: 0.3');
        $response->assertSee('Konfirmasi Kata Sandi');
    }

    public function test_user_can_login_with_valid_credentials_and_redirects_to_dashboard(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'testuser@crm.test')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Test Admin',
            'email' => 'testadmin@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'testadmin@crm.test')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_user_with_invalid_credentials_cannot_login(): void
    {
        User::create([
            'name' => 'Active User',
            'email' => 'active@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'active@crm.test')
            ->set('password', 'wrongpassword')
            ->call('login')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => false,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'inactive@crm.test')
            ->set('password', 'password123')
            ->call('login')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_guest_cannot_access_dashboard_and_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_admin_and_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin_panel_and_gets_403(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'regular@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_panel_successfully(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Panel Administrator MindControl');
        $response->assertSee('Pusat Kendali Pengguna');
        $response->assertSee('superadmin@crm.test');
        $response->assertSee('Versi: 0.3');
    }

    public function test_user_can_register_new_account_via_livewire(): void
    {
        Livewire::test(Register::class)
            ->set('name', 'Baru Bergabung')
            ->set('email', 'baru@crm.test')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'name' => 'Baru Bergabung',
            'email' => 'baru@crm.test',
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->assertAuthenticated();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::create([
            'name' => 'Logout User',
            'email' => 'logout@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_placeholder_pages_render_for_authenticated_users(): void
    {
        $user = User::create([
            'name' => 'Negotiator User',
            'email' => 'negotiator@crm.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $routes = ['/contacts', '/meetings', '/ai-settings', '/guide', '/profile'];

        foreach ($routes as $route) {
            $response = $this->actingAs($user)->get($route);
            $response->assertStatus(200);
            $response->assertSee('Versi: 0.3');
        }
    }
}
