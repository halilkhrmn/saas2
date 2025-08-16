<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Payment Methods
    Route::get('/payment/processors', [PaymentController::class, 'getAvailableProcessors']);
    Route::get('/payment/methods', [PaymentController::class, 'getUserPaymentMethods']);
    Route::post('/payment/methods', [PaymentController::class, 'createPaymentMethod']);
    
    // Payment Processing
    Route::post('/payment/process', [PaymentController::class, 'processPayment']);
    
    // Subscription Changes
    Route::post('/subscription/change', [PaymentController::class, 'changeSubscription']);
});

// Webhooks (no auth required)
Route::post('/webhooks/{processor}', [PaymentController::class, 'webhookHandler'])
    ->where('processor', 'stripe|paypal|manual');