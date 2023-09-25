<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [App\Http\Controllers\LoginController::class, 'show'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home', [
            'frameworks' => [
                'Laravel', 'Inertia', 'Vue'
            ]
        ]);
    });
    
    Route::get('/user', function () {
        sleep(3);
        return Inertia::render('User');
    });

    Route::get('/loans', [App\Http\Controllers\LoanController::class, 'index']);
    
    
});

Route::get('/auth/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/paypal/callback', function () {
    return 'Thank you for Payment.';
});

Route::get('/paypal/cancel', function () {
    return 'Your payment has been cancelled.';
});
