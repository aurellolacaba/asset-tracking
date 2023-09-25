<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\FacebookLoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\LoanApplication\ReleaseController;
use App\Http\Controllers\LoanApplication\AcceptController;
use App\Http\Controllers\PaymongoWebhookController;
use App\Http\Controllers\LoanApplication\ProcessLoanPaymentController;


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

Route::prefix('v1')->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
    
    //Facebook Login
    Route::get('/auth/facebook/callback', [FacebookLoginController::class, 'handleFacebookCallback']);
    
    //Loan Application
    Route::controller(LoanApplicationController::class)->middleware('auth:sanctum')->group(function() {
        Route::post('/loan-applications', 'store');
        Route::post('/loan-applications/{loan_application}/approve', 'handleApproveLoanRequest');
    });

    Route::post('/loan-applications/{loan_application}/release', ReleaseController::class)->middleware('auth:sanctum');
    Route::post('/loan-applications/{loan_application}/accept', AcceptController::class)->middleware('auth:sanctum');
    Route::post('/loan-schedules/{loan_schedule}/pay', ProcessLoanPaymentController::class)->middleware('auth:sanctum');
    
    //Webhook Paymongo
    Route::post('/services/paymongo/pj6sdmg1Fh', PaymongoWebhookController::class);
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Resource Not Found.'
    ], 404);
});