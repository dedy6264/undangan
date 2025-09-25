<?php

namespace App\Http\Controllers;

use App\Models\GuestMessage;
use App\Models\Guest;
use App\Models\WeddingEvent;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class GuestMessageController extends CrudController
{
    public function __construct()
    {
        $this->model = GuestMessage::class;
        $this->routePrefix = auth()->user()->role=="client" ?'my-guest-messages':'guest-messages';
        $this->columns = ['id', 'guest_id', 'wedding_event_id', 'guest_name', 'message', 'is_approved', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $records = GuestMessage::with(['guest', 'weddingEvent'])->latest()->paginate(10);
        $title = 'Guest Messages';
        
        return view('admin.crud.index', [
            'records' => $records,
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'guest_name', 'message', 'is_approved'],
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
        $title = 'Create Guest Message';
        $guests = Guest::all();
        $weddingEvents = WeddingEvent::all();
        
        return view('admin.crud.create', [
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'guest_name', 'message', 'is_approved'],
            'guests' => $guests,
            'weddingEvents' => $weddingEvents,
            'storeRoute' => route($this->routePrefix.'.store'),
            'indexRoute' => route($this->routePrefix.'.index'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        // Check if this is an API request (from the invitation page) or admin panel request
        $isApiRequest = $request->has('invitation_id');
        
        if ($isApiRequest) {
            $validated = $request->validate([
                'guest_name' => 'required|string|max:100',
                'message' => 'required|string|max:1000',
                'invitation_id' => 'required|exists:invitations,id',
            ], [
                'guest_name.required' => 'Nama harus diisi.',
                'message.required' => 'Pesan harus diisi.',
                'invitation_id.required' => 'ID undangan harus disediakan.',
                'invitation_id.exists' => 'ID undangan tidak valid.',
            ]);

            try {
                // Get the invitation to get guest_id and wedding_event_id
                $invitation = Invitation::findOrFail($validated['invitation_id']);
                
                // Create the guest message
                $guestMessage = GuestMessage::create([
                    'guest_id' => $invitation->guest_id,
                    'wedding_event_id' => $invitation->wedding_event_id,
                    'guest_name' => $validated['guest_name'],
                    'message' => $validated['message'],
                    'is_approved' => false, // Default to not approved yet
                ]);

                // Return JSON response for API requests
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim',
                    'data' => $guestMessage
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengirim pesan',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            // Original validation for admin panel requests
            $request->validate([
                'guest_id' => 'required|exists:guests,id',
                'wedding_event_id' => 'required|exists:wedding_events,id',
                'guest_name' => 'required|string|max:100',
                'message' => 'required|string',
                'is_approved' => 'nullable|boolean',
            ]);

            GuestMessage::create($request->all());

            return redirect()->route($this->routePrefix.'.index')
                ->with('success', 'Guest Message created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $record = GuestMessage::with(['guest', 'weddingEvent'])->findOrFail($id);
        $title = 'View Guest Message';
        
        return view('admin.crud.show', [
            'record' => $record,
            'title' => $title,
             'indexRoute' => route($this->routePrefix.'.index'),
            'editRoute' => $this->routePrefix.'.edit',
            'columns' => ['guest_id', 'wedding_event_id', 'guest_name', 'message', 'is_approved', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = GuestMessage::findOrFail($id);
        $title = 'Edit Guest Message';
        $guests = Guest::all();
        $weddingEvents = WeddingEvent::all();
        
        return view('admin.crud.edit', [
            'record' => $record,
            'title' => $title,
            'columns' => ['guest_id', 'wedding_event_id', 'guest_name', 'message', 'is_approved'],
            'guests' => $guests,
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
            'guest_id' => 'required|exists:guests,id',
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'guest_name' => 'required|string|max:100',
            'message' => 'required|string',
            'is_approved' => 'nullable|boolean',
        ]);

        $record = GuestMessage::findOrFail($id);
        $record->update($request->all());

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Guest Message updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = GuestMessage::findOrFail($id);
        $record->delete();

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Guest Message deleted successfully.');
    }
    
    /**
     * Display a listing of approved guest messages for a specific wedding event via API.
     */
    public function indexForWeddingEvent($wedding_event_id): JsonResponse
    {
        try {
            $guestMessages = GuestMessage::where('wedding_event_id', $wedding_event_id)
                ->where('is_approved', true)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'guest_name', 'message', 'created_at']);
                
            return response()->json([
                'success' => true,
                'data' => $guestMessages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil pesan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
