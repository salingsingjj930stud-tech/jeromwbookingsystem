@extends('layouts.app')

@section('content')
    <div class="step-bar">
        <div class="step done">1. Welcome</div>
        <div class="step done">2. Details</div>
        <div class="step active">3. Upload</div>
        <div class="step">4. Summary</div>
    </div>

    <div class="content">
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-gem">&#9670;&#9670;&#9670;</div>
            <div class="divider-line"></div>
        </div>

        <h1>Upload Confirmation</h1>
        <h2>Attach your booking confirmation file</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert-info">
            <p>&#9670; &nbsp; File Requirements</p>
            <ul style="margin-top:0.5rem; line-height:2.2;">
                <li>Accepted formats: PDF, JPG, PNG</li>
                <li>Maximum file size: 2MB</li>
                <li>At least one file must be uploaded</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('booking.confirmation.submit') }}" enctype="multipart/form-data">
            @csrf

            <label for="confirmation_file">Confirmation File</label>
            <input type="file" id="confirmation_file" name="confirmation_file"
                   accept=".pdf,.jpg,.jpeg,.png">
            @error('confirmation_file') <div class="field-error">{{ $message }}</div> @enderror

            <div style="margin-top:1rem;">
                <button type="submit" class="btn">Continue &rarr;</button>
            </div>
        </form>
    </div>
@endsection