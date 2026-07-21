@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-gem">&#9670;&#9670;&#9670;</div>
            <div class="divider-line"></div>
        </div>

        <h1>Welcome</h1>
        <h2>Enter your name to begin your reservation</h2>

        @if ($errors->any())
            <div class="alert-error">
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('home.submit') }}">
            @csrf
            <label for="customer_name">Your Name</label>
            <input type="text" id="customer_name" name="customer_name"
                   value="{{ old('customer_name') }}"
                   placeholder="e.g. Jerome"
                   autofocus>
            @error('customer_name')
                <div class="field-error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn">Begin Reservation &rarr;</button>
        </form>
    </div>
@endsection