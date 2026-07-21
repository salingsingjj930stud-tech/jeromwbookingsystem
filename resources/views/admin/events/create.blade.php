@extends('layouts.app')
@section('content')
<div class="content">
    <div class="divider"><div class="divider-line"></div><div class="divider-gem">&#9670;&#9670;&#9670;</div><div class="divider-line"></div></div>
    <h1>Add Event / Room</h1>
    <h2>Create a new venue</h2>

    @if($errors->any())
        <div class="alert-error"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Grand Ballroom">
        @error('name') <div class="field-error">{{ $message }}</div> @enderror

        <label>Type</label>
        <select name="type" style="width:100%; padding:0.8rem 1rem; background:#0d0d0d; border:1px solid #2a2a2a; color:#f0f0f0; font-family:'Montserrat',sans-serif; font-size:0.88rem; margin-bottom:1.4rem;">
            <option value="room" {{ old('type') == 'room' ? 'selected' : '' }}>Room</option>
            <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
        </select>
        @error('type') <div class="field-error">{{ $message }}</div> @enderror

        <label>Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" placeholder="e.g. 100">
        @error('capacity') <div class="field-error">{{ $message }}</div> @enderror

        <label>Description</label>
        <input type="text" name="description" value="{{ old('description') }}" placeholder="Optional description">

        <button type="submit" class="btn" style="margin-right:1rem;">Create &rarr;</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Cancel</a>
    </form>
</div>
@endsection