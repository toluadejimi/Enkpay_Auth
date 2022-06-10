<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings\ApplicationSettings;
use Symfony\Component\HttpFoundation\Response;

class SettingsConfigurationController extends Controller
{
    public function __invoke(ApplicationSettings $settings)
    {
        return response()->json([
            'status' => true,
            'features' => [
                'pos'                   => $settings->pos,
                'transfer'              => $settings->transfer,
                'payBills'              => $settings->pay_bills,
                'buyAirtime'            => $settings->buy_airtime,
                'insurance'             => $settings->insurance,
                'examCard'              => $settings->exam_card,
                'buyTicket'             => $settings->buy_ticket,
                'exchange'              => $settings->exchange,
                'data'                  => $settings->data,
                'flight'                => $settings->flight,
                'billsCommission'       => $settings->bills_commission,
                'transferCommission'    => $settings->transfer_commission,
            ],
            'customer_charges' => [
                'pos' => $settings->customer_charges_commission_pos,
                'transfer' => $settings->customer_charges_commission_transfer,
                'payBills' => $settings->customer_charges_commission_pay_bills,
                'buyAirtime' => $settings->customer_charges_commission_buy_airtime,
                'insurance' => $settings->customer_charges_commission_insurance,
                'examCard' => $settings->customer_charges_commission_exam_card,
                'buyTicket' => $settings->customer_charges_commission_buy_ticket,
                'exchange' => $settings->customer_charges_commission_exchange,
                'data' => $settings->customer_charges_commission_data,
                'flight' => $settings->customer_charges_commission_flight,
            ],
            'agent_charges' => [
                'pos' => $settings->agent_charges_commission_pos,
                'transfer' => $settings->agent_charges_commission_transfer,
                'payBills' => $settings->agent_charges_commission_pay_bills,
                'buyAirtime' => $settings->agent_charges_commission_buy_airtime,
                'insurance' => $settings->agent_charges_commission_insurance,
                'examCard' => $settings->agent_charges_commission_exam_card,
                'buyTicket' => $settings->agent_charges_commission_buy_ticket,
                'exchange' => $settings->agent_charges_commission_exchange,
                'data' => $settings->agent_charges_commission_data,
                'flight' => $settings->agent_charges_commission_flight,
            ],
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );
    }
}
