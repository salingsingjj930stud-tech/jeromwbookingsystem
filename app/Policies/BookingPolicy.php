<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    // Admin can do everything
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    // Customer can only view their own bookings
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    // Customer can only update their own bookings
    public function update(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    // Customer can only delete their own bookings
    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }
}