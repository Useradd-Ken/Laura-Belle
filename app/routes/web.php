<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/GeneralLedger', function () {
    return view('GL');
});

Route::get('/ChartOfAccounts', function () {
    return view('COA');
});

Route::get('/JournalEntry', function () {
    return view('JE');
});