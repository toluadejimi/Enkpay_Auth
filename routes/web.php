<?php
/** Web Routes */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LandingPageController;

/** Landing page route */
//Route::get('/', LandingPageController::class);


Route::get('/', function () {
   $state = \App\Services\Bank\Vulte\Reference::signature("RQ|20220208120217|742648");

   dd($state);
});
