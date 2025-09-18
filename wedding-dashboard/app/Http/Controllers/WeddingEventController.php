<?php

namespace App\Http\Controllers;

use App\Models\WeddingEvent;
use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WeddingEventController extends CrudController
{
    public function __construct()
    {
        $this->model = WeddingEvent::class;
        $this->routePrefix = 'wedding-events';
        $this->columns = ['id', 'couple_id', 'event_name', 'event_date', 'event_time', 'end_time', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $weddingEvents = WeddingEvent::with('couple')->latest()->paginate(10);
        $title = 'Wedding Events';
        
        return view('wedding_events.index', [
            'weddingEvents' => $weddingEvents,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Wedding Event';
        $couples = Couple::with('client')->get();
        
        // Using custom view instead of admin.crud.create
        return view('wedding_events.create', [
            'title' => $title,
            'couples' => $couples,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'couple_id' => 'required|exists:couples,id',
            'event_name' => 'required|string|max:100',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:event_time',
        ]);

        WeddingEvent::create($request->all());

        // Check if user is a client, redirect to my-wedding-events.index
        if (auth()->user()->isClient()) {
            return redirect()->route('my-wedding-events.index')
                ->with('success', 'Wedding Event created successfully.');
        }
        
        // For admin users, redirect to wedding-events.index
        return redirect()->route('wedding-events.index')
            ->with('success', 'Wedding Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $weddingEvent = WeddingEvent::with(['couple', 'location', 'galleryImages'])->findOrFail($id);
        $title = 'View Wedding Event';
        
        return view('wedding_events.show', [
            'weddingEvent' => $weddingEvent,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $weddingEvent = WeddingEvent::findOrFail($id);
        $title = 'Edit Wedding Event';
        $couples = Couple::with('client')->get();
        
        // Using custom view instead of admin.crud.edit
        return view('wedding_events.edit', [
            'record' => $weddingEvent,
            'title' => $title,
            'couples' => $couples,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'couple_id' => 'required|exists:couples,id',
            'event_name' => 'required|string|max:100',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:event_time',
        ]);

        $record = WeddingEvent::findOrFail($id);
        $record->update($request->all());

        // Check if user is a client, redirect to my-wedding-events.index
        if (auth()->user()->isClient()) {
            return redirect()->route('my-wedding-events.index')
                ->with('success', 'Wedding Event updated successfully.');
        }
        
        // For admin users, redirect to wedding-events.index
        return redirect()->route('wedding-events.index')
            ->with('success', 'Wedding Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = WeddingEvent::findOrFail($id);
        $record->delete();

        return redirect()->route('wedding-events.index')
            ->with('success', 'Wedding Event deleted successfully.');
    }
}

