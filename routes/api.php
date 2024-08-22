<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ZohoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', [AuthUserController::class, 'login'])->name('login');

Route::middleware([
    'auth:user',
])
    ->prefix('user')
    ->group(function () {
        Route::get('me', [AuthUserController::class, 'me']);
        Route::post('logout', [AuthUserController::class, 'logout']);
    });

Route::middleware([
    'auth:user',
])->group(function () {
    Route::post('/module', [ZohoController::class, 'createModules']);
    Route::post('/account', [AccountController::class, 'createAccount']);
    Route::post('/deal', [DealController::class, 'createDeal']);
    Route::get('/fields', [ZohoController::class, 'getRequiredFields']);
});
