<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Spatie\LaravelSettings\Exceptions\SettingAlreadyExists;

class CreateApplicationSettings extends SettingsMigration
{
    /** @throws SettingAlreadyExists */
    public function up(): void
    {
        $this->migrator->add('application.features', true);
        $this->migrator->add('application.bills_commission', '');
        $this->migrator->add('application.transfer_commission', '');
    }
}
