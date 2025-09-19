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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'sort_order' => 'nullable|integer',
            'is_inverted' => 'nullable|boolean',
        ], [
            'image.image' => 'The uploaded file must be an image (jpeg, png, jpg, gif).',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2MB.',
        ]);

        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/timeline'), $imageName);
            $data['image_url'] = 'images/timeline/' . $imageName;
        }

        TimelineEvent::create($data);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'sort_order' => 'nullable|integer',
            'is_inverted' => 'nullable|boolean',
        ], [
            'image.image' => 'The uploaded file must be an image (jpeg, png, jpg, gif).',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2MB.',
        ]);

        $record = TimelineEvent::findOrFail($id);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if it exists and is a local file
            if ($record->image_url && file_exists(public_path($record->image_url))) {
                unlink(public_path($record->image_url));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/timeline'), $imageName);
            $data['image_url'] = 'images/timeline/' . $imageName;
        }

        $record->update($data);

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
