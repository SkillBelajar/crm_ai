<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'role_or_company' => fake()->jobTitle() . ' di ' . fake()->company(),
            'category' => fake()->randomElement(['client', 'partner', 'colleague', 'vendor', 'other']),
            'phone_or_contact' => fake()->phoneNumber(),
            'primary_need' => fake()->sentence(),
            'ego_trigger' => fake()->sentence(),
            'notes' => fake()->paragraph(),
        ];
    }
}
