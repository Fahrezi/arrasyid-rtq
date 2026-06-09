<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityReportController;
use App\Http\Controllers\DonationController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('donations', DonationController::class);
Route::resource('activities', ActivityReportController::class);