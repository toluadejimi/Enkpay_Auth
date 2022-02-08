<?php

namespace Database\Factories;

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
            'phone' => $this->faker->unique()->numerify('080########'),
            'phone_country' => $this->faker->randomElement(['NG', 'NG']),
            'password' => $password = $this->faker->password(8),
            'password_confirmation' => $password
        ];
    }
}
