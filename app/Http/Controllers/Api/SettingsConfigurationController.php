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
            ]
        ])->setStatusCode(
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK]
        );//'customer_charges', 'agent_charges'
    }
}
