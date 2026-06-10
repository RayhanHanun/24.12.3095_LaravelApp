<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\EventController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

// Halaman Beranda (Home)
Route::get('/', [EventController::class, 'index'])->name('welcome');

// Halaman Detail Event
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/event-detail', function () {
    $event = Event::oldest()->first();

    return $event
        ? redirect()->route('events.show', $event)
        : redirect()->route('welcome');
})->name('event-detail');

// Halaman Checkout
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{event}', [EventController::class, 'checkout'])->name('checkout.event');

// Halaman Ticket (Setelah Bayar)
Route::get('/ticket', function () {
    return view('ticket');
})->name('ticket');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', AdminEventController::class);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});
