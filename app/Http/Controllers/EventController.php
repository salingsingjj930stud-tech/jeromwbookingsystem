<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('bookings')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'min:3'],
            'type'        => ['required', 'in:room,event'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        Event::create($request->only(['name', 'type', 'capacity', 'description']));

        return redirect()->route('admin.events.index')
            ->with('success', 'Event/Room created successfully.');
    }

    public function show(Event $event)
    {
        $event->load('bookings');
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name'        => ['required', 'string', 'min:3'],
            'type'        => ['required', 'in:room,event'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $event->update($request->only(['name', 'type', 'capacity', 'description']));

        return redirect()->route('admin.events.index')
            ->with('success', 'Event/Room updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event/Room deleted successfully.');
    }
}