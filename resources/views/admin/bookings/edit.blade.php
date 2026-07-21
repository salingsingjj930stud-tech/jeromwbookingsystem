@extends('layouts.app')
@section('content')
<div class="content">
    <div class="divider"><div class="divider-line"></div><div class="divider-gem">&#9670;&#9670;&#9670;</div><div class="divider-line"></div></div>
    <h1>Edit Booking</h1>
    <h2>Update reservation record</h2>

    @if($errors->any())
        <div class="alert-error"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
        @csrf @method('PUT')

        <label>Customer Name</label>
        <input type="text" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}">
        @error('customer_name') <div class="field-error">{{ $message }}</div> @enderror

        <label>Booking ID</label>
        <input type="text" name="booking_id" value="{{ old('booking_id', $booking->booking_id) }}" maxlength="8">
        @error('booking_id') <div class="field-error">{{ $message }}</div> @enderror
        <small>Exactly 8 alphanumeric characters.</small>

        <label>Event / Room</label>
        <select name="event_id" style="width:100%; padding:0.8rem 1rem; background:#0d0d0d; border:1px solid #2a2a2a; color:#f0f0f0; font-family:'Montserrat',sans-serif; font-size:0.88rem; margin-bottom:1.4rem;">
            @foreach($events as $event)
                <option value="{{ $event->id }}" {{ old('event_id', $booking->event_id) == $event->id ? 'selected' : '' }}>
                    {{ $event->name }} ({{ ucfirst($event->type) }})
                </option>
            @endforeach
        </select>
        @error('event_id') <div class="field-error">{{ $message }}</div> @enderror

        <label>Number of Persons</label>
        <input type="number" name="num_persons" value="{{ old('num_persons', $booking->num_persons) }}" min="1">
        @error('num_persons') <div class="field-error">{{ $message }}</div> @enderror

        <label>Date & Time</label>
<input type="datetime-local" name="booking_datetime"
       value="{{ old('booking_datetime', \Carbon\Carbon::parse($booking->booking_datetime)->format('Y-m-d\TH:i')) }}"
       style="width:100%; padding:0.8rem 1rem; background:#0d0d0d; border:1px solid #2a2a2a; color:#f0ead8; font-family:'Montserrat',sans-serif; font-size:0.88rem; margin-bottom:1.4rem;">
@error('booking_datetime') <div class="field-error">{{ $message }}</div> @enderror

        <button type="submit" class="btn" style="margin-right:1rem;">Save Changes &rarr;</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">Cancel</a>
    </form>
</div>
@endsection