<?php

use App\Models\Activity;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PakasirWebhookController;

Route::get('/', function () {
    $activities = Activity::with('program')->latest('activity_date')->get();
    return view('home', compact('activities'));
});

Route::post('/webhook/pakasir', [PakasirWebhookController::class, 'handle'])->name('webhook.pakasir');