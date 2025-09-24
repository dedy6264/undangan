<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\WeddingEvent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends CrudController
{
    public function __construct()
    {
        $this->model = Location::class;
        $this->routePrefix = auth()->user()->role=="client" ?'my-locations':'locations';
        $this->columns = ['id', 'wedding_event_id', 'venue_name', 'address', 'map_embed_url', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $locations = Location::with('weddingEvent.couple')->latest()->paginate(10);
        $title = 'Locations';
        
        return view('locations.index', [
            'locations' => $locations,
            'title' => $title,
            'createRoute' => route($this->routePrefix.'.create'),
            'editRoute' => $this->routePrefix.'.edit',
            'showRoute' => $this->routePrefix.'.show',
            'deleteRoute' => $this->routePrefix.'.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Location';
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('locations.create', [
            'title' => $title,
            'weddingEvents' => $weddingEvents,
             'storeRoute' => route($this->routePrefix.'.store'),
            'indexRoute' => route($this->routePrefix.'.index'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'venue_name' => 'required|string|max:150',
            'address' => 'required|string',
            'map_embed_url' => 'nullable|string',
        ]);

        Location::create($request->all());

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $location = Location::with('weddingEvent.couple')->findOrFail($id);
        $title = 'View Location';
        
        return view('locations.show', [
            'location' => $location,
            'title' => $title,
              'indexRoute' => route($this->routePrefix.'.index'),
            'editRoute' => $this->routePrefix.'.edit']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = Location::findOrFail($id);
        $title = 'Edit Location';
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('locations.edit', [
            'record' => $record,
            'title' => $title,
            'weddingEvents' => $weddingEvents,
               'indexRoute' => route($this->routePrefix.'.index'),
            'updateRoute' => route($this->routePrefix.'.update', $record->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'venue_name' => 'required|string|max:150',
            'address' => 'required|string',
            'map_embed_url' => 'nullable|string',
        ]);

        $record = Location::findOrFail($id);
        $record->update($request->all());

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = Location::findOrFail($id);
        $record->delete();

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Location deleted successfully.');
    }
}
