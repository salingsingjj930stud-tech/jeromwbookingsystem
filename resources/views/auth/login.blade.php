@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-gem">&#9670;&#9670;&#9670;</div>
            <div class="divider-line"></div>
        </div>

        <h1>Sign In</h1>
        <h2>Access your reservation portal</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <label for="email">Email Address</label>
            <input type="text" id="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="e.g. admin@noir.com"
                   autofocus>
            @error('email') <div class="field-error">{{ $message }}</div> @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Enter your password">
            @error('password') <div class="field-error">{{ $message }}</div> @enderror

            <div style="display:flex; align-items:center; gap:0.8rem; margin-bottom:1.5rem;">
                <input type="checkbox" id="remember" name="remember" style="width:auto; margin:0;">
                <label for="remember" style="margin:0; font-size:0.75rem; letter-spacing:1px; text-transform:none; color:#888;">Remember me</label>
            </div>

            <button type="submit" class="btn" style="width:100%;">Sign In &rarr;</button>
        </form>

        <div style="margin-top:2rem; border-top:1px solid #2a2a2a; padding-top:1.5rem;">
            <p style="color:#555; font-size:0.72rem; letter-spacing:2px; text-transform:uppercase; margin-bottom:0.8rem;">Test Accounts</p>
            <p style="color:#666; font-size:0.78rem; margin-bottom:0.3rem;">&#9670; Admin: admin@noir.com / admin123</p>
            <p style="color:#666; font-size:0.78rem;">&#9670; Customer: customer@noir.com / customer123</p>
        </div>
    </div>
@endsection