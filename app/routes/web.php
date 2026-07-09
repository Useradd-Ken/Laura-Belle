<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/otp', function () {
    return view('');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth/send-otp',[AuthController::class,'sendOtp']);
Route::post('/auth/verify-otp',[AuthController::class,'verifyOtp']);

Route::middleware('auth')->group(function () {
    
    Route::get('/accounting', function () {
        return view('accounting');
    });

    Route::get('/ChartOfAccounts', function () {
        return view('accounting');
    });

    Route::get('/JournalEntry', function () {
        return view('accounting');
    });

    Route::get('/GeneralLedger', function () {
        return view('accounting');
    });

    Route::get('accounting/{any}', function () {
        return view('accounting');
    })->where('any', '.*');
    
});