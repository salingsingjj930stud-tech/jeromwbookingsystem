<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BookingApiController;

// ─── Public API Routes ────────────────────────────────────────────────────────
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login',    [AuthApiController::class, 'login']);

// ─── Protected API Routes (Sanctum) ──────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',  [AuthApiController::class, 'logout']);
    Route::get('/user',     [AuthApiController::class, 'user']);

    // Bookings
    Route::get('/bookings',           [BookingApiController::class, 'index']);
    Route::post('/bookings',          [BookingApiController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingApiController::class, 'show']);
    Route::put('/bookings/{booking}', [BookingApiController::class, 'update']);
    Route::delete('/bookings/{booking}', [BookingApiController::class, 'destroy']);

    // Events
    Route::get('/events', [BookingApiController::class, 'events']);
});