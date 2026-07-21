@extends('layouts.app')
@section('content')
<div class="content">
    <div class="divider"><div class="divider-line"></div><div class="divider-gem">&#9670;&#9670;&#9670;</div><div class="divider-line"></div></div>
    <h1>Events & Rooms</h1>
    <h2>Manage available venues</h2>

    @if(session('success'))
        <div class="alert-success"><p>&#9670; &nbsp; {{ session('success') }}</p></div>
    @endif

    <div style="margin-bottom:1.5rem; display:flex; gap:1rem;">
        <a href="{{ route('admin.events.create') }}" class="btn">+ Add New</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">View Bookings &rarr;</a>
    </div>

    <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
        <thead>
            <tr style="border-bottom:1px solid #c0c0c0;">
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Name</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Type</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Capacity</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Bookings</th>
                <th style="text-align:left; padding:0.6rem 0.5rem; color:#c0c0c0; font-size:0.6rem; letter-spacing:3px; text-transform:uppercase;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr style="border-bottom:1px solid #1e1e1e;">
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ $event->name }}</td>
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ ucfirst($event->type) }}</td>
                <td style="padding:0.75rem 0.5rem; color:#f0f0f0;">{{ $event->capacity }}</td>
                <td style="padding:0.75rem 0.5rem; color:#c0c0c0;">{{ $event->bookings_count }}</td>
                <td style="padding:0.75rem 0.5rem;">
                    <a href="{{ route('admin.events.show', $event) }}" style="color:#c0c0c0; font-size:0.65rem; letter-spacing:2px; margin-right:0.8rem; text-decoration:none;">VIEW</a>
                    <a href="{{ route('admin.events.edit', $event) }}" style="color:#c0c0c0; font-size:0.65rem; letter-spacing:2px; margin-right:0.8rem; text-decoration:none;">EDIT</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this event?')"
                            style="background:none; border:none; color:#c0392b; font-size:0.65rem; letter-spacing:2px; cursor:pointer; font-family:'Montserrat',sans-serif;">DELETE</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:1.5rem;">{{ $events->links() }}</div>
</div>
@endsection