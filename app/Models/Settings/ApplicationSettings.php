<?php

namespace App\Models\Settings;

use Spatie\LaravelSettings\Settings;

class ApplicationSettings extends Settings
{
    public bool $pos;
    public bool $data;
    public bool $flight;
    public bool $transfer;
    public bool $exam_card;
    public bool $pay_bills;
    public bool $exchange;
    public bool $buy_ticket;
    public bool $insurance;
    public bool $buy_airtime;
    public ?string $bills_commission;
    public ?string $transfer_commission;
    public int $customer_charges_commission_pos;
    public int $customer_charges_commission_transfer;
    public int $customer_charges_commission_pay_bills;
    public int $customer_charges_commission_buy_airtime;
    public int $customer_charges_commission_insurance;
    public int $customer_charges_commission_exam_card;
    public int $customer_charges_commission_buy_ticket;
    public int $customer_charges_commission_exchange;
    public int $customer_charges_commission_data;
    public int $customer_charges_commission_flight;
    public int $agent_charges_commission_pos;
    public int $agent_charges_commission_transfer;
    public int $agent_charges_commission_pay_bills;
    public int $agent_charges_commission_buy_airtime;
    public int $agent_charges_commission_insurance;
    public int $agent_charges_commission_exam_card;
    public int $agent_charges_commission_buy_ticket;
    public int $agent_charges_commission_exchange;
    public int $agent_charges_commission_data;
    public int $agent_charges_commission_flight;

    public static function group(): string
    {
        return "application";
    }
}
