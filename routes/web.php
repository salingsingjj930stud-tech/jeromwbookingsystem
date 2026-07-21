<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ─── Auth Routes ──────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');




Route::get('/booking/calendar-events', [BookingController::class, 'calendarEvents'])->name('booking.calendar-events');

// ─── Customer Routes ──────────────────────────────────────────────────────────
Route::middleware(['customer'])->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('home');
    Route::post('/', [BookingController::class, 'enterName'])->name('home.submit');
    Route::get('/booking/start/{customerName}', [BookingController::class, 'start'])->name('booking.start');
    Route::get('/booking/details/{customerName}', [BookingController::class, 'showDetails'])->name('booking.details');
    Route::post('/booking/details', [BookingController::class, 'submitDetails'])->name('booking.details.submit');
    Route::get('/booking/confirmation', [BookingController::class, 'showConfirmation'])->name('booking.confirmation');
    Route::post('/booking/confirmation', [BookingController::class, 'submitConfirmation'])->name('booking.confirmation.submit');
    Route::get('/booking/summary', [BookingController::class, 'summary'])->name('booking.summary');
    Route::get('/booking/booked-dates', [BookingController::class, 'bookedDates'])->name('booking.booked-dates');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::middleware(['admin'])->group(function () {

   Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard-stats', [DashboardController::class, 'stats'])->name('admin.dashboard.stats');
    Route::get('/admin/calendar-events', [DashboardController::class, 'calendarEvents'])->name('admin.calendar.events');


    Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
    Route::get('/admin/bookings/{booking}', [BookingController::class, 'adminShow'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [BookingController::class, 'adminEdit'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{booking}', [BookingController::class, 'adminDestroy'])->name('admin.bookings.destroy');
    Route::resource('admin/events', EventController::class)->names('admin.events');
});

