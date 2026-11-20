<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Masuk ke Akun - MindControl CRM')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ];
    }

    public function login()
    {
        $this->validate();

        $throttleKey = Str::transliterate(Str::lower($this->email).'|'.request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Terlalu banyak percobaan masuk. Silakan coba lagi dalam {$seconds} detik.");
            return;
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($throttleKey);
            $this->addError('email', 'Email atau kata sandi yang Anda masukkan tidak sesuai.');
            return;
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();
            if (request()->hasSession()) {
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }

            $this->addError('email', 'Akun Anda sedang dinonaktifkan. Silakan hubungi tim administrator.');
            return;
        }

        if (request()->hasSession()) {
            request()->session()->regenerate();
        }
        RateLimiter::clear($throttleKey);

        if ($user->role === 'admin') {
            return $this->redirect(route('admin.dashboard'));
        }

        return $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
