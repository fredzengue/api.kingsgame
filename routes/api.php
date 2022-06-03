<?php

use App\Http\Controllers\DepositController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
<<<<<<< HEAD
Route::apiResource('loan', App\http\Controllers\LoanController::class);
=======
Route::apiResource('withdrawall',App\Http\Controllers\WithdrawallController::class);
Auth::routes();
>>>>>>> 7e17f46fb878e1fbc7bfedf6e998971d8e423115
