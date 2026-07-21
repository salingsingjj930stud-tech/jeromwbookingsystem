@extends('layouts.app')

@section('content')
    <div class="step-bar">
        <div class="step done">1. Welcome</div>
        <div class="step done">2. Details</div>
        <div class="step done">3. Upload</div>
        <div class="step active">4. Summary</div>
    </div>

    <div class="content">
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-gem">&#9670;&#9670;&#9670;</div>
            <div class="divider-line"></div>
        </div>

        <h1>Reservation Summary</h1>
        <h2>Your booking has been received</h2>

        <div class="alert-success">
            <p>&#9670; &nbsp; Reservation submitted successfully.</p>
        </div>

        <table class="summary-table">
            <tr><td>Customer Name</td><td>{{ $booking->customer_name }}</td></tr>
            <tr><td>Booking ID</td><td>{{ $booking->booking_id }}</td></tr>
            <tr><td>Event / Room</td><td>{{ $booking->event->name }}</td></tr>
            <tr><td>Room Type</td><td>{{ ucfirst($booking->event->type) }}</td></tr>
            <tr><td>Capacity</td><td>{{ $booking->event->capacity }} persons</td></tr>
            <tr><td>Persons Booked</td><td>{{ $booking->num_persons }}</td></tr>
            <tr>
                 <td>Date & Time</td>
    <td>{{ \Carbon\Carbon::parse($booking->booking_datetime)->format('F d, Y h:i A') }}</td>
</tr>
            <tr>
                <td>Confirmation File</td>
                <td>
                    @php $ext = strtolower(pathinfo($booking->file_name, PATHINFO_EXTENSION)); @endphp
                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                        <span style="color:#888; font-size:0.8rem;">{{ $booking->file_name }}</span><br>
                        <img src="{{ asset('storage/' . $booking->file_path) }}" style="max-width:100%; margin-top:0.5rem; border:1px solid #2a2a2a;">
                    @else
                        <a href="{{ asset('storage/' . $booking->file_path) }}" target="_blank" download style="color:#c0c0c0;">&#8595; {{ $booking->file_name }}</a>
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline" style="margin-right:1rem;">View All Bookings &rarr;</a>
        <a href="{{ route('home') }}" class="btn">New Reservation &rarr;</a>
    </div>
@endsection