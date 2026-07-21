@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card">
    <h1>Create Account 👤</h1>
    <p class="subtitle">Register to start booking.</p>

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" 
            placeholder="Enter your name" value="{{ old('name') }}">
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label for="email">Email</label>
        <input type="email" name="email" id="email" 
            placeholder="Enter your email" value="{{ old('email') }}">
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Password</label>
        <input type="password" name="password" id="password" 
            placeholder="Enter your password">
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" 
            placeholder="Confirm your password">

        <button type="submit">Register</button>
    </form>

    <p style="text-align:center; margin-top:1rem;">
        Already have an account? 
        <a href="{{ route('login') }}">Login here</a>
    </p>
    <p style="text-align:center; margin-top:1rem;">
    Don't have an account? 
    <a href="{{ route('register') }}">Register here</a>
</p>

</div>
@endsection