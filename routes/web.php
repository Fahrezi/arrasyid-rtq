<?php

use App\Models\Activity;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationReturnController;
use App\Http\Controllers\DuitkuCallbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $activities = Activity::with('program')->latest('activity_date')->get();
    return view('home', compact('activities'));
});

Route::post('/donate', [DonationController::class, 'store'])->name('donate');
Route::post('/callback/duitku', [DuitkuCallbackController::class, 'handle'])->name('callback.duitku');
Route::get('/donation/loading', [DonationReturnController::class, 'loading'])->name('donation.loading');
Route::get('/donation/return', [DonationReturnController::class, 'handle'])->name('donation.return');