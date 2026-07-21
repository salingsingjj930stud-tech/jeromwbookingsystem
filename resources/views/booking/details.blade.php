@extends('layouts.app')

@section('content')
    <div class="step-bar">
        <div class="step done">1. Welcome</div>
        <div class="step active">2. Details</div>
        <div class="step">3. Upload</div>
        <div class="step">4. Summary</div>
    </div>

    <div class="content">
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-gem">&#9670;&#9670;&#9670;</div>
            <div class="divider-line"></div>
        </div>

        <h1>Booking Details</h1>
        <h2>Fill in your reservation information</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.details.submit') }}">
            @csrf

            <label for="customer_name">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name"
                   value="{{ old('customer_name', $customerName) }}" readonly>
            <small>Your name is pre-filled and cannot be changed.</small>

            <label for="booking_id">Booking ID</label>
            <input type="text" id="booking_id" name="booking_id"
                   value="{{ old('booking_id') }}" placeholder="e.g. AB123456" maxlength="8">
            @error('booking_id') <div class="field-error">{{ $message }}</div> @enderror
            <small>Exactly 8 alphanumeric characters.</small>

            <label for="event_id">Event / Room</label>
            <select id="event_id" name="event_id" style="width:100%; padding:0.8rem 1rem; background:#0d0d0d; border:1px solid #2a2a2a; color:#f0f0f0; font-family:'Montserrat',sans-serif; font-size:0.88rem; margin-bottom:1.4rem;">
                <option value="">— Select an Event or Room —</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->name }} ({{ ucfirst($event->type) }} — Capacity: {{ $event->capacity }})
                    </option>
                @endforeach
            </select>
            @error('event_id') <div class="field-error">{{ $message }}</div> @enderror

            <label for="num_persons">Number of Persons</label>
            <input type="number" id="num_persons" name="num_persons"
                   value="{{ old('num_persons') }}" min="1" placeholder="e.g. 2">
            @error('num_persons') <div class="field-error">{{ $message }}</div> @enderror
            <small>At least 1 person required.</small>

           <label>Booking Date</label>
<div id="calendar-container" style="background:#0d0d0d; border:1px solid #2a2a2a; padding:1.2rem; margin-bottom:1.4rem;">
    
    <!-- Month Navigation -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <button type="button" id="prev-month" style="background:none; border:none; color:#c0c0c0; cursor:pointer; font-size:1rem;">&#8249;</button>
        <span id="month-year" style="font-family:'Cormorant Garamond',serif; color:#f0ead8; font-size:1.1rem; letter-spacing:3px;"></span>
        <button type="button" id="next-month" style="background:none; border:none; color:#c0c0c0; cursor:pointer; font-size:1rem;">&#8250;</button>
    </div>

    <!-- Day Headers -->
    <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:4px; margin-bottom:0.5rem;">
        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $day)
            <div style="text-align:center; font-size:0.6rem; letter-spacing:2px; color:#555; padding:0.3rem;">{{ $day }}</div>
        @endforeach
    </div>

    <!-- Calendar Days -->
    <div id="calendar-days" style="display:grid; grid-template-columns:repeat(7,1fr); gap:4px;"></div>

    <!-- Selected Date Display -->
    <div id="selected-display" style="margin-top:1rem; padding:0.6rem 1rem; border-left:2px solid #c0c0c0; background:#161616; display:none;">
        <span style="color:#c0c0c0; font-size:0.72rem; letter-spacing:2px;">&#10003; Selected: </span>
        <span id="selected-date-text" style="color:#f0ead8; font-size:0.72rem; letter-spacing:1px;"></span>
    </div>
</div>

<label>Booking Time</label>
<input type="time" id="booking_time" name="booking_time"
       style="width:100%; padding:0.8rem 1rem; background:#0d0d0d; border:1px solid #2a2a2a; color:#f0ead8; font-family:'Montserrat',sans-serif; font-size:0.88rem; margin-bottom:0.5rem;">
@error('booking_datetime') <div class="field-error">{{ $message }}</div> @enderror
<small>Select your preferred time.</small>

<!-- Hidden input that combines date + time -->
<input type="hidden" id="booking_datetime" name="booking_datetime">

<script>
    // Booked dates from database
    const bookedDates = @json($bookedDates ?? []);

    let currentDate = new Date();
    let selectedDate = null;

    const monthNames = ['January','February','March','April','May','June',
                        'July','August','September','October','November','December'];

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        document.getElementById('month-year').textContent = monthNames[month] + ' ' + year;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        today.setHours(0,0,0,0);

        const container = document.getElementById('calendar-days');
        container.innerHTML = '';

        // Empty cells before first day
        for (let i = 0; i < firstDay; i++) {
            container.innerHTML += `<div></div>`;
        }

        // Day cells
        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = year + '-' + String(month+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
            const thisDate = new Date(year, month, d);
            const isPast = thisDate < today;
            const isBooked = bookedDates.includes(dateStr);
            const isSelected = selectedDate === dateStr;
            const isToday = thisDate.getTime() === today.getTime();

            let bg = 'transparent';
            let color = '#f0ead8';
            let cursor = 'pointer';
            let border = '1px solid transparent';

            if (isPast) { color = '#333'; cursor = 'not-allowed'; }
            if (isBooked) { bg = '#8b3a2a'; color = '#fff'; cursor = 'not-allowed'; }
            if (isToday && !isBooked) { border = '1px solid #c0c0c0'; }
            if (isSelected) { bg = '#c0c0c0'; color = '#0d0d0d'; }

            const clickable = !isPast && !isBooked;

            container.innerHTML += `
                <div onclick="${clickable ? `selectDate('${dateStr}', ${d}, '${monthNames[month]}', ${year})` : ''}"
                     style="text-align:center; padding:0.45rem 0.2rem; font-size:0.78rem; 
                            background:${bg}; color:${color}; cursor:${cursor}; 
                            border:${border}; border-radius:2px; transition:background 0.15s;"
                     title="${isBooked ? 'Already booked' : ''}">
                    ${d}
                </div>`;
        }
    }

    function selectDate(dateStr, day, month, year) {
        selectedDate = dateStr;
        document.getElementById('selected-date-text').textContent = month + ' ' + day + ', ' + year;
        document.getElementById('selected-display').style.display = 'block';
        updateHiddenInput();
        renderCalendar();
    }

    function updateHiddenInput() {
        const time = document.getElementById('booking_time').value;
        if (selectedDate && time) {
            document.getElementById('booking_datetime').value = selectedDate + ' ' + time + ':00';
        } else if (selectedDate) {
            document.getElementById('booking_datetime').value = selectedDate + ' 00:00:00';
        }
    }

    document.getElementById('prev-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('next-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    document.getElementById('booking_time').addEventListener('change', updateHiddenInput);

    renderCalendar();
</script>

            <button type="submit" class="btn">Continue &rarr;</button>
        </form>
    </div>
@endsection