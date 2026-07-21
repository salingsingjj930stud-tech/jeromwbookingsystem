<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $totalUsers    = User::count();
        $totalEvents   = Event::count();

        $upcomingBookings = Booking::with('event')
            ->where('booking_datetime', '>=', now())
            ->orderBy('booking_datetime')
            ->take(5)
            ->get();

        $recentBookings = Booking::with('event')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBookings', 'totalUsers', 'totalEvents',
            'upcomingBookings', 'recentBookings'
        ));
    }

    // Called every few seconds for the live stat cards
    public function stats()
    {
        return response()->json([
            'totalBookings' => Booking::count(),
            'totalUsers'    => User::count(),
        ]);
    }

    // Feeds the calendar with ALL bookings (not just dates)
    public function calendarEvents()
    {
        $bookings = Booking::with('event')->get();

        $events = $bookings->map(function ($b) {
            return [
                'title' => ($b->event->name ?? 'Booking') . ' — ' . $b->customer_name,
                'start' => $b->booking_datetime,
                'color' => '#c0c0c0',
            ];
        });

        return response()->json($events);
    }
}