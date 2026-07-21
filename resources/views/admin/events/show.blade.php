@extends('layouts.app')
@section('content')
<div class="content">
    <div class="divider"><div class="divider-line"></div><div class="divider-gem">&#9670;&#9670;&#9670;</div><div class="divider-line"></div></div>
    <h1>{{ $event->name }}</h1>
    <h2>{{ ucfirst($event->type) }} details</h2>

    <table class="summary-table">
        <tr><td>Name</td><td>{{ $event->name }}</td></tr>
        <tr><td>Type</td><td>{{ ucfirst($event->type) }}</td></tr>
        <tr><td>Capacity</td><td>{{ $event->capacity }} persons</td></tr>
        <tr><td>Description</td><td>{{ $event->description ?? '—' }}</td></tr>
        <tr><td>Total Bookings</td><td>{{ $event->bookings->count() }}</td></tr>
    </table>

    @if($event->bookings->count())
        <h2 style="margin-bottom:1rem;">Bookings for this Event</h2>
        <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
            <thead>
                <tr style="border-bottom:1px solid #c0c0c0;">
                    <th style="text-align:left; padding:0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Customer</th>
                    <th style="text-align:left; padding:0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Booking ID</th>
                    <th style="text-align:left; padding:0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Persons</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->bookings as $booking)
                <tr style="border-bottom:1px solid #1e1e1e;">
                    <td style="padding:0.65rem 0.5rem; color:#f0f0f0;">{{ $booking->customer_name }}</td>
                    <td style="padding:0.65rem 0.5rem; color:#f0f0f0;">{{ $booking->booking_id }}</td>
                    <td style="padding:0.65rem 0.5rem; color:#f0f0f0;">{{ $booking->num_persons }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="margin-top:1.5rem;">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn" style="margin-right:1rem;">Edit &rarr;</a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Back</a>
    </div>
</div>
@endsection