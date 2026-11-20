<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserAiSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAiSettingFactory extends Factory
{
    protected $model = UserAiSetting::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'base_url' => 'https://api.openai.com/v1',
            'api_key' => 'sk-mock-key-for-testing',
            'model_name' => 'gpt-4o-mini',
            'is_verified' => true,
        ];
    }
}
