<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'contact_id' => Contact::factory(),
            'title' => fake()->sentence(4),
            'meeting_date' => now(),
            'biggest_need' => fake()->sentence(),
            'ego_validation_note' => fake()->sentence(),
            'user_goal' => fake()->sentence(),
            'context_notes' => fake()->sentence(),
            'ai_conditional_yes' => null,
            'ai_psychological_contract' => null,
            'contract_deadline_at' => now()->addHours(24),
            'status' => 'draft',
            'commitment_result' => null,
        ];
    }
}
