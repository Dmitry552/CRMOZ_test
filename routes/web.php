<?php

use App\Http\Controllers\AuthZohoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/zoho/redirect', [AuthZohoController::class, 'redirect'])->name('redirect');
Route::get('/zoho/callback', [AuthZohoController::class, 'callback']);

Route::get('/registration', function () {
    return view('signUp');
})->name('signUp');

Route::get('/zohoForm', function () {
    return view('zohoForm');
})->name('zohoForm');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)')
    ->name('home');
