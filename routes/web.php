<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PartnerController;

// Halaman Beranda (Home)
Route::get('/', [EventController::class, 'index'])->name('welcome');

// Halaman Detail Event
Route::get('/event-detail', [EventController::class, 'show'])->name('event-detail');

// Halaman Checkout
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');

// Halaman Ticket (Setelah Bayar)
Route::get('/ticket', function () {
    return view('ticket');
})->name('ticket');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // Halaman Dashboard Admin (URL: /admin)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Kelola Event Admin (URL: /admin/events)
    Route::resource('events', AdminEventController::class)->except(['show']);

    // Halaman Kelola Partner Admin (URL: /admin/partners)
    Route::resource('partners', PartnerController::class)->except(['show']);

    // Halaman Laporan Transaksi Admin (URL: /admin/transactions)
    Route::get('/transactions', [AdminEventController::class, 'transactions'])->name('transactions.index');
});
