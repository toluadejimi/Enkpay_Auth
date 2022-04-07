<?php
/** Web Routes */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LandingPageController;

/** Landing page route */
Route::get('/', LandingPageController::class);

Route::get('/frame', function (){
    $user = Auth::loginUsingId(1);
    dd(\Illuminate\Support\Facades\Crypt::decrypt($user->pin));
    //return \Illuminate\Support\Facades\Crypt::encrypt('806080');
});
