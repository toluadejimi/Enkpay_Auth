<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /** Define the model's default state. */
    public function definition(): array
    {
        return [
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->numerify('080########'),
            'phone_country' => $this->faker->randomElement(['NG', 'NG']),
            'password' => Hash::make('password'),
        ];
    }
}
