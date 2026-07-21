<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ─── Entry ───────────────────────────────────────────────────────────────────

    public function index()
    {
        return view('booking.index');
    }

    public function enterName(Request $request)
    {
        $request->validate(
            ['customer_name' => ['required', 'string', 'min:2']],
            [
                'customer_name.required' => 'Please enter your name to continue.',
                'customer_name.min'      => 'Your name must be at least 2 characters.',
            ]
        );

        return redirect()->route('booking.start', ['customerName' => $request->customer_name]);
    }

    // ─── Step 0 ───────────────────────────────────────────────────────────────────

    public function start(string $customerName)
    {
        Session::forget(['booking_details', 'booking_details_complete', 'booking_confirmation_complete', 'booking_file']);
        return view('booking.start', compact('customerName'));
    }

    // ─── Step 1 ───────────────────────────────────────────────────────────────────

    public function showDetails(string $customerName)
{
    $events = Event::all();

    // Get all booked dates for the calendar
    $bookedDates = \App\Models\Booking::pluck('booking_datetime')
        ->map(fn($dt) => \Carbon\Carbon::parse($dt)->format('Y-m-d'))
        ->unique()
        ->values()
        ->toArray();

    return view('booking.details', compact('customerName', 'events', 'bookedDates'));
}

   public function submitDetails(Request $request)
{
    $request->validate(
        [
            'customer_name'    => ['required', 'string'],
            'booking_id'       => ['required', 'regex:/^[A-Za-z0-9]{8}$/', 'unique:bookings,booking_id'],
            'event_id'         => ['required', 'exists:events,id'],
            'num_persons'      => ['required', 'integer', 'min:1'],
            'booking_datetime' => ['required', 'date', 'after:now'],
        ],
        [
            'booking_id.required'       => 'A Booking ID is required.',
            'booking_id.regex'          => 'The Booking ID must be exactly 8 alphanumeric characters.',
            'booking_id.unique'         => 'This Booking ID already exists.',
            'event_id.required'         => 'Please select an Event or Room.',
            'event_id.exists'           => 'The selected Event or Room is invalid.',
            'num_persons.required'      => 'Please specify the number of persons.',
            'num_persons.integer'       => 'The number of persons must be a whole number.',
            'num_persons.min'           => 'At least 1 person is required.',
            'booking_datetime.required' => 'Please select a date and time.',
            'booking_datetime.after'    => 'The booking date must be in the future.',
        ]
    );

    // ── Check if same date already booked for this event ──────────────────
    $selectedDate = Carbon::parse($request->booking_datetime)->format('Y-m-d');

    $alreadyBooked = \App\Models\Booking::where('event_id', $request->event_id)
        ->whereRaw('DATE(booking_datetime) = ?', [$selectedDate])
        ->exists();

    if ($alreadyBooked) {
        return back()
            ->withInput()
            ->withErrors([
                'booking_datetime' => 'This Event/Room is already booked on ' . Carbon::parse($request->booking_datetime)->format('F d, Y') . '. Please choose a different date.',
            ]);
    }

    $event = Event::findOrFail($request->event_id);

    Session::put('booking_details', [
        'customer_name'    => $request->customer_name,
        'booking_id'       => $request->booking_id,
        'event_id'         => $request->event_id,
        'event_name'       => $event->name,
        'num_persons'      => $request->num_persons,
        'booking_datetime' => $request->booking_datetime,
    ]);

    Session::put('booking_details_complete', true);

    return redirect()->route('booking.confirmation');
}

    // ─── NEW: Booked Dates JSON (for the calendar) ────────────────────────────────

    public function bookedDates(Request $request)
    {
        $eventId = $request->query('event_id');

        $dates = Booking::when($eventId, fn($q) => $q->where('event_id', $eventId))
            ->pluck('booking_datetime')
            ->map(fn($dt) => \Carbon\Carbon::parse($dt)->format('Y-m-d'))
            ->unique()
            ->values();

        return response()->json($dates);
    }
public function calendarEvents(Request $request)
{
    $eventId = $request->query('event_id');

    $bookings = Booking::with('event')
        ->when($eventId, fn($q) => $q->where('event_id', $eventId))
        ->get();

    $events = $bookings->map(function ($b) {
        return [
            'title' => \Carbon\Carbon::parse($b->booking_datetime)->format('g:i A'),
            'start' => $b->booking_datetime,
            'color' => '#c0c0c0',
        ];
    });

    return response()->json($events);
}
    // ─── Step 2 ───────────────────────────────────────────────────────────────────

    public function showConfirmation()
    {
        if (!Session::get('booking_details_complete')) {
            return redirect()->route('home');
        }
        return view('booking.confirmation');
    }

    public function submitConfirmation(Request $request)
    {
        if (!Session::get('booking_details_complete')) {
            return redirect()->route('home');
        }

        $request->validate(
            ['confirmation_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048']],
            [
                'confirmation_file.required' => 'You must upload a confirmation file.',
                'confirmation_file.mimes'    => 'Only PDF, JPG, and PNG files are accepted.',
                'confirmation_file.max'      => 'The file must not be larger than 2MB.',
            ]
        );

        $file     = $request->file('confirmation_file');
        $filePath = $file->store('confirmations', 'public');
        $fileName = $file->getClientOriginalName();

        Session::put('booking_file', compact('fileName', 'filePath'));
        Session::put('booking_confirmation_complete', true);

        return redirect()->route('booking.summary');
    }

    // ─── Summary + Save to DB ────────────────────────────────────────────────────

  public function summary()
    {
        if (!Session::get('booking_details_complete')) return redirect()->route('home');
        if (!Session::get('booking_confirmation_complete')) return redirect()->route('booking.confirmation');

        $details = Session::get('booking_details');
        $file    = Session::get('booking_file');

       $booking = Booking::updateOrCreate(
    ['booking_id' => $details['booking_id']],
    [
        'user_id'          => auth()->id(),  // ← add this
        'event_id'         => $details['event_id'],
        'customer_name'    => $details['customer_name'],
        'num_persons'      => $details['num_persons'],
        'booking_datetime' => $details['booking_datetime'],
        'file_name'        => $file['fileName'],
        'file_path'        => $file['filePath'],
    ]
);


        $booking->load('event');

        return view('booking.summary', compact('booking'));
    }
    // ─── Admin CRUD ───────────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $bookings = Booking::with('event')->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function adminShow(Booking $booking)
    {
        $booking->load('event');
        return view('admin.bookings.show', compact('booking'));
    }

    public function adminEdit(Booking $booking)
    {
        $events = Event::all();
        return view('admin.bookings.edit', compact('booking', 'events'));
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $request->validate([
            'customer_name' => ['required', 'string'],
            'booking_id'    => ['required', 'regex:/^[A-Za-z0-9]{8}$/', 'unique:bookings,booking_id,' . $booking->id],
            'event_id'      => ['required', 'exists:events,id'],
            'num_persons'   => ['required', 'integer', 'min:1'],
        ]);

        $booking->update($request->only(['customer_name', 'booking_id', 'event_id', 'num_persons']));

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function adminDestroy(Booking $booking)
    {
        Storage::disk('public')->delete($booking->file_path);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
    
}