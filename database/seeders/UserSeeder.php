<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run()
    {
        $this->command->info('You are about to seed users.');

        $quantity = $this->command->ask('How many user do you want to create?');

        if (empty($quantity)) {
            $this->command->info('You did not specify quantity, so by default {10} user will be created.');
            $quantity = 10;
        }

        User::factory($quantity)->create();

        $this->command->info("{$quantity} users was successfully created.");

        if ($this->command->confirm('Would you like to assign the first user to be an administrator?')) {
            $this->command->info('Assigning administrative role to the first user.');
            User::query()->first()->assignRole(RoleSeeder::$DEFAULT_ROLE);
        }
    }
}
