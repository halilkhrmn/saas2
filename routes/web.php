<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    // Contact form submission logic would go here
    return back()->with('success', 'Thank you for your message! We will get back to you soon.');
})->name('contact.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Google OAuth routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/invoices', [DashboardController::class, 'invoices'])->name('dashboard.invoices');
    
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/buy/{package}', [SubscriptionController::class, 'buy'])->name('buy');
        Route::post('/purchase/{package}', [SubscriptionController::class, 'purchase'])->name('purchase');
        Route::get('/invoice/{invoice}', [SubscriptionController::class, 'invoice'])->name('invoice');
        Route::post('/invoice/{invoice}/pay', [SubscriptionController::class, 'pay'])->name('pay');
    });
});
