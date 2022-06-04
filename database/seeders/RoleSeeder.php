<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public static string $DEFAULT_ROLE = "Administrator";

    public function run(): void
    {
        $this->command->line('<fg=blue>Resetting cached roles...</>');
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->command->line('<fg=green>Done resetting cached roles.</>');

        $this->command->line('<fg=blue>Seeding roles and assigning permissions...</>');
        Role::query()->updateOrCreate([
            'name' => static::$DEFAULT_ROLE
        ])->givePermissionTo(Permission::all());
        $this->command->line('<fg=green>Done.</>');
    }
}
