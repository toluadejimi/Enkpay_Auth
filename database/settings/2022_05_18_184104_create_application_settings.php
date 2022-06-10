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

        $this->migrator->add('application.customer_charges_commission_pos', 6);
        $this->migrator->add('application.customer_charges_commission_transfer', 2);
        $this->migrator->add('application.customer_charges_commission_pay_bills', 2);
        $this->migrator->add('application.customer_charges_commission_buy_airtime', 4);
        $this->migrator->add('application.customer_charges_commission_insurance', 0);
        $this->migrator->add('application.customer_charges_commission_exam_card', 1);
        $this->migrator->add('application.customer_charges_commission_buy_ticket', 10);
        $this->migrator->add('application.customer_charges_commission_exchange', 2);
        $this->migrator->add('application.customer_charges_commission_data', 3);
        $this->migrator->add('application.customer_charges_commission_flight', 3);

        $this->migrator->add('application.agent_charges_commission_pos', 6);
        $this->migrator->add('application.agent_charges_commission_transfer', 2);
        $this->migrator->add('application.agent_charges_commission_pay_bills', 2);
        $this->migrator->add('application.agent_charges_commission_buy_airtime', 4);
        $this->migrator->add('application.agent_charges_commission_insurance', 0);
        $this->migrator->add('application.agent_charges_commission_exam_card', 1);
        $this->migrator->add('application.agent_charges_commission_buy_ticket', 10);
        $this->migrator->add('application.agent_charges_commission_exchange', 2);
        $this->migrator->add('application.agent_charges_commission_data', 3);
        $this->migrator->add('application.agent_charges_commission_flight', 3);
    }
}
