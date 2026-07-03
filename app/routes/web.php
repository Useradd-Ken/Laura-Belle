<?php

use Illuminate\Support\Facades\Route;

// Login page - standalone
Route::get('/', function () {
    return view('login');
});

// Accounting app pages - with Nav and Vue Router
Route::get('/ChartOfAccounts', function () {
    return view('accounting');
});

Route::get('/JournalEntry', function () {
    return view('accounting');
});

Route::get('/GeneralLedger', function () {
    return view('accounting');
});

// Catch-all for Vue Router on accounting pages - must be last
Route::get('accounting/{any}', function () {
    return view('accounting');
})->where('any', '.*');