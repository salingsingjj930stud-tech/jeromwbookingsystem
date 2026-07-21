<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingApiController extends Controller
{
    // GET /api/bookings — list user's own bookings
    public function index(Request $request)
    {
        $bookings = $request->user()->isAdmin()
            ? Booking::with('event', 'user')->latest()->get()
            : Booking::with('event')->where('user_id', $request->user()->id)->latest()->get();

        return response()->json([
            'status'   => 'success',
            'bookings' => $bookings,
        ]);
    }

    // GET /api/bookings/{booking} — view single booking
    public function show(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        return response()->json([
            'status'  => 'success',
            'booking' => $booking->load('event', 'user'),
        ]);
    }

    // POST /api/bookings — create booking
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'booking_id'       => ['required', 'regex:/^[A-Za-z0-9]{8}$/', 'unique:bookings,booking_id'],
                'event_id'         => ['required', 'exists:events,id'],
                'num_persons'      => ['required', 'integer', 'min:1'],
                'booking_datetime' => ['required', 'date', 'after:now'],
            ],
            [
                'booking_id.required'       => 'A Booking ID is required.',
                'booking_id.regex'          => 'Booking ID must be exactly 8 alphanumeric characters.',
                'booking_id.unique'         => 'This Booking ID already exists.',
                'event_id.required'         => 'Please select an Event or Room.',
                'num_persons.min'           => 'At least 1 person is required.',
                'booking_datetime.required' => 'Please select a date and time.',
                'booking_datetime.after'    => 'Booking date must be in the future.',
            ]
        );

        // Check duplicate date for same event
        $selectedDate = Carbon::parse($request->booking_datetime)->format('Y-m-d');
        $alreadyBooked = Booking::where('event_id', $request->event_id)
            ->whereRaw('DATE(booking_datetime) = ?', [$selectedDate])
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This Event/Room is already booked on that date.',
            ], 422);
        }

        $booking = Booking::create([
            'user_id'          => $request->user()->id,
            'event_id'         => $validated['event_id'],
            'customer_name'    => $request->user()->name,
            'booking_id'       => $validated['booking_id'],
            'num_persons'      => $validated['num_persons'],
            'booking_datetime' => $validated['booking_datetime'],
            'file_name'        => 'none',
            'file_path'        => 'none',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Booking created successfully.',
            'booking' => $booking->load('event'),
        ], 201);
    }

    // PUT /api/bookings/{booking} — update booking
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'num_persons'      => ['sometimes', 'integer', 'min:1'],
            'booking_datetime' => ['sometimes', 'date', 'after:now'],
            'event_id'         => ['sometimes', 'exists:events,id'],
        ]);

        $booking->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Booking updated successfully.',
            'booking' => $booking->load('event'),
        ]);
    }

    // DELETE /api/bookings/{booking} — delete booking
    public function destroy(Request $request, Booking $booking)
    {
        $this->authorize('delete', $booking);

        $booking->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Booking deleted successfully.',
        ]);
    }

    // GET /api/events — list all events
    public function events()
    {
        $events = Event::withCount('bookings')->get();

        return response()->json([
            'status' => 'success',
            'events' => $events,
        ]);
    }
}