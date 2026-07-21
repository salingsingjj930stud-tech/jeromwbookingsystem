@extends('layouts.app')

@section('content')
    <div class="step-bar">
        <div class="step active">1. Welcome</div>
        <div class="step">2. Details</div>
        <div class="step">3. Upload</div>
        <div class="step">4. Summary</div>
    </div>

    <div class="content">
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-gem">&#9670;&#9670;&#9670;</div>
            <div class="divider-line"></div>
        </div>

        <h1>Welcome, {{ $customerName }}</h1>
        <h2>Your reservation awaits</h2>

        <p style="color:#666; line-height:1.9; font-size:0.85rem; margin-bottom:2rem;">
            We are pleased to have you with us. Please have your <span style="color:#d4af6a;">Booking ID</span>
            and a confirmation file <span style="color:#d4af6a;">(PDF, JPG, or PNG)</span> ready before proceeding.
        </p>

        <div class="alert-info">
            <p>&#9670; &nbsp; Reservation Steps</p>
            <ul style="margin-top:0.5rem; line-height:2.2;">
                <li>Fill in your booking details</li>
                <li>Upload your confirmation file</li>
                <li>Review your reservation summary</li>
            </ul>
        </div>

        <a href="{{ route('booking.details', ['customerName' => $customerName]) }}" class="btn">
            Proceed &rarr;
        </a>
    </div>
@endsection