<?php

namespace App\Livewire;

use App\Models\UserAiSetting;
use App\Services\AiClientService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app', ['title' => 'Pengaturan AI Mandiri (BYOK) — MindControl CRM'])]
class AiSettingsForm extends Component
{
    public string $base_url = '';
    public string $api_key = '';
    public string $model_name = 'gpt-4o-mini';

    public bool $is_verified = false;
    public ?string $last_tested_at = null;

    public ?bool $testSuccess = null;
    public ?string $testMessage = null;
    public ?int $testLatency = null;
    public ?string $testReply = null;

    public ?string $saveSuccessMessage = null;

    protected array $rules = [
        'base_url' => ['required', 'string', 'max:255'],
        'api_key' => ['nullable', 'string', 'max:1000'],
        'model_name' => ['required', 'string', 'max:100'],
    ];

    protected array $messages = [
        'base_url.required' => 'Base URL endpoint wajib diisi.',
        'model_name.required' => 'Nama model AI wajib diisi.',
    ];

    public function mount(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user) {
            $setting = $user->aiSetting;
            if ($setting) {
                $this->base_url = $setting->base_url;
                $this->api_key = $setting->api_key ?? '';
                $this->model_name = $setting->model_name;
                $this->is_verified = (bool) $setting->is_verified;
                $this->last_tested_at = $setting->last_tested_at
                    ? $setting->last_tested_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
                    : null;
            } else {
                // Default helper suggestion
                $this->base_url = 'https://api.openai.com/v1';
                $this->model_name = 'gpt-4o-mini';
            }
        }
    }

    public function testConnection(AiClientService $aiClient): void
    {
        $this->saveSuccessMessage = null;
        $this->testSuccess = null;
        $this->testMessage = null;
        $this->testLatency = null;
        $this->testReply = null;

        $this->validate();

        $result = $aiClient->testConnection($this->base_url, $this->api_key, $this->model_name);

        $this->testSuccess = $result['success'];
        $this->testMessage = $result['message'];
        $this->testLatency = $result['latency_ms'];
        $this->testReply = $result['reply'];

        if ($result['success']) {
            $this->is_verified = true;
            $this->last_tested_at = now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB';

            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user) {
                $user->aiSetting()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'base_url' => trim($this->base_url),
                        'api_key' => $this->api_key ?: null,
                        'model_name' => trim($this->model_name),
                        'is_verified' => true,
                        'last_tested_at' => now(),
                    ]
                );
            }
        } else {
            $this->is_verified = false;

            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user && $user->aiSetting) {
                $user->aiSetting->update([
                    'is_verified' => false,
                ]);
            }
        }
    }

    public function save(): void
    {
        $this->testSuccess = null;
        $this->testMessage = null;
        $this->saveSuccessMessage = null;

        $this->validate();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user) {
            $user->aiSetting()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'base_url' => trim($this->base_url),
                    'api_key' => $this->api_key ?: null,
                    'model_name' => trim($this->model_name),
                    'is_verified' => $this->is_verified,
                    'last_tested_at' => $this->last_tested_at ? now() : null,
                ]
            );

            $this->saveSuccessMessage = 'Pengaturan AI Mandiri (BYOK) berhasil disimpan ke sistem!';
        }
    }

    public function render()
    {
        return view('livewire.ai-settings-form');
    }
}
