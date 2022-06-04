<?php
/** Web Routes */
use App\Http\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Web\LandingPageController;

/** Landing page route */
//Route::get('/', LandingPageController::class);
Route::redirect('/', '/login');

Route::get('/login', Login::class);
