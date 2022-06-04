<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Spatie\LaravelSettings\Exceptions\SettingAlreadyExists;

class CreateApplicationSettings extends SettingsMigration
{
    /** @throws SettingAlreadyExists */
    public function up(): void
    {
        $this->migrator->add('application.pos', true);
        $this->migrator->add('application.data', true);
        $this->migrator->add('application.flight', false);
        $this->migrator->add('application.transfer', true);
        $this->migrator->add('application.exam_card', true);
        $this->migrator->add('application.pay_bills', true);
        $this->migrator->add('application.exchange', false);
        $this->migrator->add('application.buy_ticket', false);
        $this->migrator->add('application.insurance', false);
        $this->migrator->add('application.buy_airtime', true);
        $this->migrator->add('application.bills_commission', '');
        $this->migrator->add('application.transfer_commission', '');
    }
}
