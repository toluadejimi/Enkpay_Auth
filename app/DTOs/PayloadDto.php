<?php

namespace App\DTOs;

class PayloadDto
{

    public function __construct()
    {

    }

    public static function fromPayload($request)
    {

    }
}
/*
 *  {
     'details': {
         'data': {
             'Hash': 'd73427efde0356efe899e45d8186f2ff7a7f2f7d5628132a61fa15c1c2e6f632b45bed',
             'Narration': 'NIBSS:90148:USSD-NIP To ONEPIPE',
             'bank_code': '076',
             'VirtualAccount': '0123456789',
             'account_number': '0123456789',
             'TransactionDate': '2022-04-25T09:33:04.47',
             'TransactionAmount': 1738,
             'VirtualAccountName': 'John Doe',
             'TransactionReference': '00000422000000050500'
         },
         'meta': {
             'route': 'listener',
             'lock_account': 'true',
             'transaction_date': '2022-04-25-09-33-04'
         },
         'amount': 173800,
         'status': 'Successful',
         'provider': 'DemoProvider',
         'customer_ref': '2347012345678',
         'customer_email': null,
         'transaction_ref': '000004220425095505',
         'customer_surname': 'Doe',
         'transaction_type': 'collect',
         'customer_firstname': 'John',
         'customer_mobile_no': null
     },
     'app_info': {
         'app_code': 'APP-001'
     },
     'mock_mode': 'Live',
     'requester': 'DemoProvider',
     'request_ref': '9B8BA3AE8D4148DBA29D99',
     'request_type': 'transaction_notification'
 }
 */
