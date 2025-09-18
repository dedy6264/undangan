<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use App\Models\WeddingEvent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvitationController extends CrudController
{
    public function __construct()
    {
        $this->model = Invitation::class;
        $this->routePrefix = 'invitations';
        $this->columns = ['id', 'guest_id', 'wedding_event_id', 'invitation_code', 'is_attending', 'responded_at', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $records = Invitation::with(['guest', 'weddingEvent'])->latest()->paginate(10);
        $title = 'Invitations';
        
        return view('admin.crud.index', [
            'records' => $records,
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'invitation_code', 'is_attending', 'responded_at'],
            'createRoute' => route('invitations.create'),
            'editRoute' => 'invitations.edit',
            'deleteRoute' => 'invitations.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Invitation';
        $guests = Guest::all();
        $weddingEvents = WeddingEvent::all();
        
        return view('admin.crud.create', [
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'invitation_code', 'is_attending', 'responded_at'],
            'storeRoute' => route('invitations.store'),
            'guests' => $guests,
            'weddingEvents' => $weddingEvents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'invitation_code' => 'required|string|unique:invitations,invitation_code|max:50',
            'is_attending' => 'nullable|boolean',
            'responded_at' => 'nullable|date',
        ]);

        Invitation::create($request->all());

        return redirect()->route('invitations.index')
            ->with('success', 'Invitation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $record = Invitation::with(['guest', 'weddingEvent'])->findOrFail($id);
        $title = 'View Invitation';
        
        return view('admin.crud.show', [
            'record' => $record,
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'invitation_code', 'is_attending', 'responded_at', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = Invitation::findOrFail($id);
        $title = 'Edit Invitation';
        $guests = Guest::all();
        $weddingEvents = WeddingEvent::all();
        
        return view('admin.crud.edit', [
            'record' => $record,
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'invitation_code', 'is_attending', 'responded_at'],
            'updateRoute' => route('invitations.update', $record->id),
            'guests' => $guests,
            'weddingEvents' => $weddingEvents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $record = Invitation::findOrFail($id);
        
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'invitation_code' => 'required|string|unique:invitations,invitation_code,' . $record->id . '|max:50',
            'is_attending' => 'nullable|boolean',
            'responded_at' => 'nullable|date',
        ]);

        $record->update($request->all());

        return redirect()->route('invitations.index')
            ->with('success', 'Invitation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = Invitation::findOrFail($id);
        $record->delete();

        return redirect()->route('invitations.index')
            ->with('success', 'Invitation deleted successfully.');
    }
}
