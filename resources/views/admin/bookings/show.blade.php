@extends('layouts.app')
@section('content')
<div class="content">
    <div class="divider"><div class="divider-line"></div><div class="divider-gem">&#9670;&#9670;&#9670;</div><div class="divider-line"></div></div>
    <h1>Booking Record</h1>
    <h2>Reservation details</h2>
    <table class="summary-table">
        <tr><td>Customer Name</td><td>{{ $booking->customer_name }}</td></tr>
        <tr><td>Booking ID</td><td>{{ $booking->booking_id }}</td></tr>
        <tr><td>Event / Room</td><td>{{ $booking->event->name }}</td></tr>
        <tr><td>Type</td><td>{{ ucfirst($booking->event->type) }}</td></tr>
        <tr><td>Capacity</td><td>{{ $booking->event->capacity }}</td></tr>
        <tr><td>Persons</td><td>{{ $booking->num_persons }}</td></tr>
        <tr>
            <td>File</td>
            <td>
                @php $ext = strtolower(pathinfo($booking->file_name, PATHINFO_EXTENSION)); @endphp
                @if(in_array($ext, ['jpg','jpeg','png']))
                    <img src="{{ asset('storage/'.$booking->file_path) }}" style="max-width:100%; border:1px solid #2a2a2a;">
                @else
                    <a href="{{ asset('storage/'.$booking->file_path) }}" target="_blank" download style="color:#c0c0c0;">&#8595; {{ $booking->file_name }}</a>
                @endif
            </td>
        </tr>
        <tr><td>Created</td><td>{{ $booking->created_at->format('F d, Y h:i A') }}</td></tr>
    </table>
    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn" style="margin-right:1rem;">Edit &rarr;</a>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">Back</a>
</div>
@endsection