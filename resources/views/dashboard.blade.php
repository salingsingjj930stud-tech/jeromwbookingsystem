@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<style>
    .dash-stats { display:flex; gap:1.2rem; margin-bottom:2rem; flex-wrap:wrap; }
    .dash-card {
        flex:1; min-width:180px; background:#141414; border:1px solid #2a2a2a;
        padding:1.6rem; text-align:left;
    }
    .dash-card .label {
        font-size:0.6rem; letter-spacing:3px; text-transform:uppercase; color:#666; margin-bottom:0.6rem;
    }
    .dash-card .value {
        font-family:'Cormorant Garamond', serif; font-size:2.4rem; color:#c0c0c0; line-height:1;
    }
    .dash-grid { display:flex; gap:1.5rem; align-items:flex-start; flex-wrap:wrap; }
    .dash-calendar-box { flex:2; min-width:320px; background:#141414; border:1px solid #2a2a2a; padding:1.5rem; }
    .dash-side { flex:1; min-width:280px; display:flex; flex-direction:column; gap:1.5rem; }
    .dash-panel { background:#141414; border:1px solid #2a2a2a; padding:1.5rem; }
    .dash-panel h3 {
        font-family:'Cormorant Garamond', serif; font-weight:400; font-size:1.15rem;
        color:#f0ead8; margin-bottom:1rem; letter-spacing:1px;
    }
    .dash-list-item {
        display:flex; justify-content:space-between; align-items:center;
        padding:0.7rem 0; border-bottom:1px solid #1e1e1e; font-size:0.82rem;
    }
    .dash-list-item:last-child { border-bottom:none; }
    .dash-list-item .name { color:#f0ead8; }
    .dash-list-item .meta { color:#666; font-size:0.68rem; letter-spacing:1px; margin-top:2px; }
    .dash-badge {
        font-size:0.58rem; letter-spacing:2px; text-transform:uppercase;
        padding:0.25rem 0.6rem; border:1px solid #c0c0c0; color:#c0c0c0;
    }
    .fc-daygrid-day-number { color:#f0ead8 !important; text-decoration:none !important; font-size:0.8rem; padding:6px !important; }
    .fc-col-header-cell-cushion { color:#c0c0c0 !important; text-decoration:none !important; font-size:0.62rem; letter-spacing:2px; text-transform:uppercase; }
    .fc-toolbar-title { color:#f0ead8 !important; font-family:'Cormorant Garamond', serif !important; }
    .fc-button { background:#1a1a1a !important; border:1px solid #2a2a2a !important; color:#c0c0c0 !important; box-shadow:none !important; }
    .fc-button:hover { background:#2a2a2a !important; }
    .fc-daygrid-day-frame { min-height:70px; }
    .fc-day-today { background:#1a1a1a !important; }
    .fc-event { border:none !important; font-size:0.68rem; padding:1px 4px; }
</style>

<div class="content">
    <div class="divider">
        <div class="divider-line"></div>
        <div class="divider-gem">&#9670;&#9670;&#9670;</div>
        <div class="divider-line"></div>
    </div>
    <h1>Dashboard</h1>
    <h2>Live overview of your reservation system</h2>

    <div class="dash-stats">
        <div class="dash-card">
            <div class="label">Total Events / Rooms</div>
            <div class="value">{{ $totalEvents }}</div>
        </div>
        <div class="dash-card">
            <div class="label">Total Booked Dates</div>
            <div class="value" id="totalBookings">{{ $totalBookings }}</div>
        </div>
        <div class="dash-card">
            <div class="label">Total Users</div>
            <div class="value" id="totalUsers">{{ $totalUsers }}</div>
        </div>
    </div>

    <div class="dash-grid">
        <div class="dash-calendar-box">
            <h3>Event Calendar</h3>
            <div id="dashboardCalendar"></div>
        </div>

        <div class="dash-side">
            <div class="dash-panel">
                <h3>Upcoming Bookings</h3>
                @forelse ($upcomingBookings as $b)
                    <div class="dash-list-item">
                        <div>
                            <div class="name">{{ $b->event->name ?? 'N/A' }}</div>
                            <div class="meta">{{ \Carbon\Carbon::parse($b->booking_datetime)->format('M d, Y • g:i A') }}</div>
                        </div>
                        <span class="dash-badge">Upcoming</span>
                    </div>
                @empty
                    <p style="color:#555; font-size:0.8rem;">No upcoming bookings.</p>
                @endforelse
            </div>

            <div class="dash-panel">
                <h3>Recent Bookings</h3>
                @forelse ($recentBookings as $b)
                    <div class="dash-list-item">
                        <div>
                            <div class="name">{{ $b->customer_name }}</div>
                            <div class="meta">{{ $b->event->name ?? 'N/A' }}</div>
                        </div>
                        <span class="dash-badge">{{ \Carbon\Carbon::parse($b->booking_datetime)->format('M d, Y') }}</span>
                    </div>
                @empty
                    <p style="color:#555; font-size:0.8rem;">No bookings yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Live stat cards
    async function refreshStats() {
        try {
            const res = await fetch("{{ route('admin.dashboard.stats') }}");
            const data = await res.json();
            document.getElementById('totalBookings').textContent = data.totalBookings;
            document.getElementById('totalUsers').textContent = data.totalUsers;
        } catch (e) {
            console.error('Stats refresh failed', e);
        }
    }
    setInterval(refreshStats, 3000);

    // Calendar showing all bookings
    fetch("{{ route('admin.calendar.events') }}")
        .then(r => r.json())
        .then(events => {
            const calendarEl = document.getElementById('dashboardCalendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                events: events
            });
            calendar.render();
        });
});
</script>
@endsection