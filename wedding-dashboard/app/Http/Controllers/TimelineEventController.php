<?php

namespace App\Http\Controllers;

use App\Models\TimelineEvent;
use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TimelineEventController extends CrudController
{
    public function __construct()
    {
        $this->model = TimelineEvent::class;
        $this->routePrefix = 'timeline-events';
        $this->columns = ['id', 'couple_id', 'title', 'event_date', 'description', 'image_url', 'sort_order', 'is_inverted', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $timelineEvents = TimelineEvent::with('couple')->latest()->paginate(10);
        $title = 'Timeline Events';
        
        return view('timeline_events.index', [
            'timelineEvents' => $timelineEvents,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Timeline Event';
        $couples = Couple::with('client')->get();
        
        return view('timeline_events.create', [
            'title' => $title,
            'storeRoute' => route('timeline-events.store'),
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
            'title' => 'nullable|string|max:100',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_inverted' => 'nullable|boolean',
        ]);

        TimelineEvent::create($request->all());

        return redirect()->route('timeline-events.index')
            ->with('success', 'Timeline Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $timelineEvent = TimelineEvent::with('couple')->findOrFail($id);
        $title = 'View Timeline Event';
        
        return view('timeline_events.show', [
            'timelineEvent' => $timelineEvent,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = TimelineEvent::findOrFail($id);
        $title = 'Edit Timeline Event';
        $couples = Couple::with('client')->get();
        
        return view('timeline_events.edit', [
            'record' => $record,
            'title' => $title,
            'updateRoute' => route('timeline-events.update', $record->id),
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
            'title' => 'nullable|string|max:100',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_inverted' => 'nullable|boolean',
        ]);

        $record = TimelineEvent::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('timeline-events.index')
            ->with('success', 'Timeline Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = TimelineEvent::findOrFail($id);
        $record->delete();

        return redirect()->route('timeline-events.index')
            ->with('success', 'Timeline Event deleted successfully.');
    }
}
