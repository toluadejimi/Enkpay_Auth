<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $this->command->line("<fg=blue>Resetting cached permissions...</>");
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $this->command->line('<fg=green>Done resetting cached permissions.</>');

        $this->command->line("<fg=blue>Seeding permissions...</>");
        collect(config('iam'))
            ->each(function ($permission) {
                Permission::query()
                    ->updateOrCreate([
                        'name' => $permission
                    ]
                );
            }
        );
        $this->command->line('<fg=green>Done seeding permissions.</>');
    }
}
