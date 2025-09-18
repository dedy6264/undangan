<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QrCodeController extends CrudController
{
    public function __construct()
    {
        $this->model = QrCode::class;
        $this->routePrefix = 'qr-codes';
        $this->columns = ['id', 'invitation_id', 'qr_data', 'qr_image_url', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $records = QrCode::with('invitation')->latest()->paginate(10);
        $title = 'QR Codes';
        
        return view('admin.crud.index', [
            'records' => $records,
            'title' => $title,
            'columns' => ['invitation_id', 'qr_data', 'qr_image_url'],
            'createRoute' => route('qr-codes.create'),
            'editRoute' => 'qr-codes.edit',
            'deleteRoute' => 'qr-codes.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create QR Code';
        $invitations = Invitation::all();
        
        return view('admin.crud.create', [
            'title' => $title,
            'columns' => ['invitation_id', 'qr_data', 'qr_image_url'],
            'storeRoute' => route('qr-codes.store'),
            'invitations' => $invitations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'qr_data' => 'required|string',
            'qr_image_url' => 'nullable|string|max:255',
        ]);

        QrCode::create($request->all());

        return redirect()->route('qr-codes.index')
            ->with('success', 'QR Code created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $record = QrCode::with('invitation')->findOrFail($id);
        $title = 'View QR Code';
        
        return view('admin.crud.show', [
            'record' => $record,
            'title' => $title,
            'columns' => ['invitation_id', 'qr_data', 'qr_image_url', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = QrCode::findOrFail($id);
        $title = 'Edit QR Code';
        $invitations = Invitation::all();
        
        return view('admin.crud.edit', [
            'record' => $record,
            'title' => $title,
            'columns' => ['invitation_id', 'qr_data', 'qr_image_url'],
            'updateRoute' => route('qr-codes.update', $record->id),
            'invitations' => $invitations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'qr_data' => 'required|string',
            'qr_image_url' => 'nullable|string|max:255',
        ]);

        $record = QrCode::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('qr-codes.index')
            ->with('success', 'QR Code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = QrCode::findOrFail($id);
        $record->delete();

        return redirect()->route('qr-codes.index')
            ->with('success', 'QR Code deleted successfully.');
    }
}
