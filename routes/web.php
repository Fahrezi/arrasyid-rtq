<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PakasirWebhookController;

Route::get('/', function () {
    return view('home');
});

Route::resource('donations', DonationController::class);
Route::resource('activities', ActivityReportController::class);

Route::post('/webhook/pakasir', [PakasirWebhookController::class, 'handle'])->name('webhook.pakasir');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');