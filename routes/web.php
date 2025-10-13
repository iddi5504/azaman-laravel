<?php

use App\Http\Controllers\WalletController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DashboardMiddleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified', DashboardMiddleware::class])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/wallets', [WalletController::class, 'index'])->name('wallets.index');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');
    Route::get('/admin/add-wallet', [WalletController::class, 'create'])->name('add-wallet');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
