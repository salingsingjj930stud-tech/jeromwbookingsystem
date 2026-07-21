@extends('layouts.app')
@section('content')
<div class="content">
    <div class="divider"><div class="divider-line"></div><div class="divider-gem">&#9670;&#9670;&#9670;</div><div class="divider-line"></div></div>
    <h1>All Bookings</h1>
    <h2>Manage reservation records</h2>

    @if(session('success'))
        <div class="alert-success"><p>&#9670; &nbsp; {{ session('success') }}</p></div>
    @endif

    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Manage Events/Rooms &rarr;</a>
    </div>

    <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
        <thead>
            <tr style="border-bottom:1px solid #c0c0c0;">
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Name</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Booking ID</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Event / Room</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Persons</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr style="border-bottom:1px solid #1e1e1e;">
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ $booking->customer_name }}</td>
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ $booking->booking_id }}</td>
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ $booking->event->name }}</td>
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ $booking->num_persons }}</td>
                <td ...>{{ \Carbon\Carbon::parse($booking->booking_datetime)->format('M d, Y h:i A') }}</td>
                <td style="padding:0.75rem 0.5rem;">
                    <a href="{{ route('admin.bookings.show', $booking) }}" style="color:#c0c0c0; font-size:0.65rem; letter-spacing:2px; margin-right:0.8rem; text-decoration:none;">VIEW</a>
                    <a href="{{ route('admin.bookings.edit', $booking) }}" style="color:#c0c0c0; font-size:0.65rem; letter-spacing:2px; margin-right:0.8rem; text-decoration:none;">EDIT</a>
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this booking?')"
                            style="background:none; border:none; color:#c0392b; font-size:0.65rem; letter-spacing:2px; cursor:pointer; font-family:'Montserrat',sans-serif;">DELETE</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:1.5rem;">{{ $bookings->links() }}</div>
</div>
@endsection