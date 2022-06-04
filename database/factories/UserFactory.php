<?php

namespace Database\Factories;

use App\Enums\AccountTypeEnum;
use Illuminate\Support\Facades\Hash;
use Spatie\Enum\Faker\FakerEnumProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /** Define the model's default state. */
    public function definition(): array
    {
        $this->faker->addProvider(new FakerEnumProvider($this->faker));

        return [
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->numerify('080########'),
            'phone_country' => $this->faker->randomElement(['NG', 'NG']),
            'type' => $this->faker->randomEnumValue(AccountTypeEnum::class),
            'password' => Hash::make('password'),
        ];
    }
}
