<?php
/** Web Routes */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LandingPageController;

/** Landing page route */
Route::get('/', LandingPageController::class);

Route::get('/test', function () {
    (new \App\Services\Sms\Sms())->send([
        'to' => '234816484569',
        'from' => 'fastbeep',
        'message' => 'Hello',
    ]);
});

//'error' => 'Unauthorised'
// 'message' => 'Invalid Sender id' : 400





/*{
    'balance': '6',
    'code': 'ok',
    'message': 'Successfully Sent',
    'message_id': 4353946307335071557,
    'user': 'Benson Bariyana'
}*/
