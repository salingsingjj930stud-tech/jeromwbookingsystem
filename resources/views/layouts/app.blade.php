<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lee Residence — Reservation Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Montserrat', sans-serif; background: #0d0d0d; color: #f0ead8; min-height: 100vh; }

        nav { background: #0d0d0d; border-bottom: 1px solid #2a2a2a; padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .nav-left .nav-brand { font-family: 'Cormorant Garamond', serif; color: #c0c0c0; font-size: 1.4rem; font-weight: 300; letter-spacing: 4px; text-transform: uppercase; text-decoration: none; display: block; }
        .nav-left .nav-sub { color: #555; font-size: 0.62rem; letter-spacing: 4px; text-transform: uppercase; margin-top: 3px; }
        .nav-links { display: flex; gap: 0.3rem; flex-wrap: wrap; align-items: center; }
        .nav-links a { color: #555; font-size: 0.62rem; letter-spacing: 3px; text-transform: uppercase; text-decoration: none; padding: 0.5rem 1rem; border: 1px solid transparent; transition: all 0.2s; }
        .nav-links a:hover { color: #c0c0c0; border-color: #2a2a2a; }
        .nav-links a.active { color: #c0c0c0; border-color: #c0c0c0; }

        .container { max-width: 900px; margin: 2.5rem auto; background: #141414; border: 1px solid #2a2a2a; }

        .step-bar { display: flex; border-bottom: 1px solid #2a2a2a; }
        .step { flex: 1; padding: 0.7rem; text-align: center; font-size: 0.6rem; letter-spacing: 3px; text-transform: uppercase; color: #444; border-right: 1px solid #2a2a2a; }
        .step:last-child { border-right: none; }
        .step.active { color: #fff; border-bottom: 2px solid #fff; }
        .step.done { color: #c0c0c0; border-bottom: 2px solid #c0c0c0; }

        .content { padding: 2.5rem; }

        .divider { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.8rem; }
        .divider-line { flex: 1; height: 1px; background: #2a2a2a; }
        .divider-gem { color: #c0c0c0; font-size: 0.7rem; letter-spacing: 6px; }

        h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; color: #f0ead8; margin-bottom: 0.3rem; letter-spacing: 2px; }
        h2 { font-size: 0.62rem; color: #555; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 2rem; }

        label { display: block; font-size: 0.6rem; letter-spacing: 3px; text-transform: uppercase; color: #666; margin-bottom: 0.5rem; }
        input[type=text], input[type=number], input[type=file], input[type=password], input[type=email], select, textarea {
            width: 100%; padding: 0.8rem 1rem; background: #0d0d0d; border: 1px solid #2a2a2a;
            color: #f0ead8; font-family: 'Montserrat', sans-serif; font-size: 0.88rem;
            margin-bottom: 1.4rem; transition: border-color 0.2s;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #c0c0c0; }
        input[readonly] { color: #555; cursor: not-allowed; }
        small { color: #444; font-size: 0.68rem; display: block; margin-top: -1.1rem; margin-bottom: 1.2rem; }

        .field-error { color: #c0392b; font-size: 0.68rem; margin-top: -1rem; margin-bottom: 1rem; letter-spacing: 1px; }

        .alert-error { border-left: 2px solid #c0392b; padding: 0.9rem 1.2rem; margin-bottom: 1.5rem; background: #1a0000; }
        .alert-error ul { color: #a04040; font-size: 0.75rem; margin-left: 1.2rem; margin-top: 0.3rem; }
        .alert-success { border-left: 2px solid #c0c0c0; padding: 0.9rem 1.2rem; margin-bottom: 1.5rem; background: #161616; }
        .alert-success p { color: #888; font-size: 0.75rem; margin: 0; }
        .alert-info { border-left: 2px solid #c0c0c0; padding: 0.9rem 1.2rem; margin-bottom: 1.5rem; background: #161616; }
        .alert-info p { color: #888; font-size: 0.75rem; margin: 0 0 0.3rem; }
        .alert-info ul { color: #888; font-size: 0.75rem; margin-left: 1.2rem; }

        .btn { display: inline-block; background: #c0c0c0; color: #0d0d0d; border: none; padding: 0.85rem 2rem; font-family: 'Montserrat', sans-serif; font-size: 0.65rem; letter-spacing: 3px; text-transform: uppercase; cursor: pointer; font-weight: 500; text-decoration: none; transition: background 0.2s; }
        .btn:hover { background: #a8a8a8; }
        .btn-outline { background: transparent; color: #c0c0c0; border: 1px solid #c0c0c0; }
        .btn-outline:hover { background: #c0c0c0; color: #0d0d0d; }
        .btn-danger { background: transparent; color: #c0392b; border: 1px solid #c0392b; }
        .btn-danger:hover { background: #c0392b; color: #fff; }

        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        .summary-table td { padding: 0.85rem 0; border-bottom: 1px solid #1e1e1e; font-size: 0.85rem; }
        .summary-table td:first-child { font-size: 0.6rem; letter-spacing: 3px; text-transform: uppercase; color: #555; width: 40%; }

        .data-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        .data-table th { text-align: left; padding: 0.6rem 0.8rem; color: #c0c0c0; font-size: 0.6rem; letter-spacing: 3px; text-transform: uppercase; border-bottom: 1px solid #c0c0c0; font-weight: 400; }
        .data-table td { padding: 0.75rem 0.8rem; color: #f0ead8; border-bottom: 1px solid #1e1e1e; }
        .data-table tr:hover td { background: #1a1a1a; }

        .action-link { color: #c0c0c0; font-size: 0.6rem; letter-spacing: 2px; text-decoration: none; margin-right: 0.8rem; text-transform: uppercase; }
        .action-link:hover { text-decoration: underline; }
        .action-delete { background: none; border: none; color: #c0392b; font-size: 0.6rem; letter-spacing: 2px; cursor: pointer; font-family: 'Montserrat', sans-serif; text-transform: uppercase; }
        .action-delete:hover { text-decoration: underline; }

        .file-preview img { max-width: 100%; margin-top: 0.5rem; border: 1px solid #2a2a2a; }
        .file-preview a { color: #c0c0c0; text-decoration: none; font-size: 0.75rem; letter-spacing: 2px; }

        footer { text-align: center; padding: 1.5rem; color: #2a2a2a; font-size: 0.6rem; letter-spacing: 4px; text-transform: uppercase; border-top: 1px solid #1a1a1a; margin-top: 2rem; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('admin.bookings.index') : route('home') }}" class="nav-brand">&#9670; Noir Residence</a>
            <div class="nav-sub">Reservation Portal</div>
        </div>
        <div class="nav-links">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.events.index') }}"
                       class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                       Events & Rooms
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                     Dashboard
                            </a>
                    <a href="{{ route('admin.bookings.index') }}"
                       class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                       All Bookings
                    </a>
                  
                @else
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') || request()->routeIs('booking.*') ? 'active' : '' }}">
                       Book Now
                    </a>
                @endif

                <span style="color:#555; font-size:0.62rem; letter-spacing:2px; padding:0.5rem 1rem; text-transform:uppercase;">
                    &#9670; {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                </span>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:1px solid #2a2a2a; color:#555; font-size:0.62rem; letter-spacing:3px; text-transform:uppercase; padding:0.5rem 1rem; cursor:pointer; font-family:'Montserrat',sans-serif;">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>&#9670; &nbsp; Lee Residence &nbsp; &#9670; &nbsp; Luxury Reservation Portal &nbsp; &#9670;</footer>
</body>
</html>