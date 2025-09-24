<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use App\Models\WeddingEvent;
use App\Models\QrCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvitationController extends CrudController
{
    public function __construct()
    {
        $this->model = Invitation::class;
        $this->routePrefix = auth()->user()->role=="client" ?'my-invitations':'invitations';
        $this->columns = ['id', 'guest_id', 'wedding_event_id', 'invitation_code', 'is_attending', 'responded_at', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $invitations = Invitation::with(['guest', 'weddingEvent'])->latest()->paginate(10);
        $title = 'Invitations';
        
        return view('invitations.index', [
            'invitations' => $invitations,
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
        $title = 'Create Invitation';
        $guests = Guest::all();
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('invitations.create', [
            'title' => $title,
            'guests' => $guests,
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
            'guest_id' => 'required|exists:guests,id',
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'invitation_code' => 'required|string|unique:invitations,invitation_code|max:50',
            'is_attending' => 'nullable|boolean',
            'responded_at' => 'nullable|date',
        ]);

        // Create the invitation
        $invitation = Invitation::create($request->all());

        // Generate QR code data (using invitation code as the data)
        $qrData = route($this->routePrefix.'.show', $invitation->id);
        
        // Generate QR code image in SVG format (doesn't require imagick)
        $qrImage = QrCodeGenerator::format('svg')->size(300)->generate($qrData);
        
        // Save QR code image to file
        $qrImageName = 'qr_codes/invitation_' . $invitation->id . '.svg';
        $qrImagePath = public_path($qrImageName);
        
        // Create directory if it doesn't exist
        if (!file_exists(dirname($qrImagePath))) {
            mkdir(dirname($qrImagePath), 0755, true);
        }
        
        // Save the image
        file_put_contents($qrImagePath, $qrImage);
        
        // Create QR code record
        QrCode::create([
            'invitation_id' => $invitation->id,
            'qr_data' => $qrData,
            'qr_image_url' => $qrImageName,
        ]);

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Invitation created successfully with QR code.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $invitation = Invitation::with(['guest', 'weddingEvent', 'qrCode'])->findOrFail($id);
        $title = 'View Invitation';
        
        return view('invitations.show', [
            'invitation' => $invitation,
            'title' => $title,
             'indexRoute' => route($this->routePrefix.'.index'),
            'editRoute' => $this->routePrefix.'.edit',
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
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('invitations.edit', [
            'record' => $record,
            'title' => $title,
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
        $record = Invitation::findOrFail($id);
        
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'invitation_code' => 'required|string|unique:invitations,invitation_code,' . $record->id . '|max:50',
            'is_attending' => 'nullable|boolean',
            'responded_at' => 'nullable|date',
        ]);

        $record->update($request->all());

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Invitation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = Invitation::findOrFail($id);
        $record->delete();

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Invitation deleted successfully.');
    }
}
