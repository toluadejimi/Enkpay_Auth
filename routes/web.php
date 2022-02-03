<?php
/** Web Routes */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LandingPageController;

/** Landing page route */
Route::get('/', LandingPageController::class);

