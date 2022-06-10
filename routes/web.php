<?php
/** Web Routes */
use App\Http\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');
Route::get('/login', Login::class)->name('login');
