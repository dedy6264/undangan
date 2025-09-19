<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuestController extends CrudController
{
    public function __construct()
    {
        $this->model = Guest::class;
        $this->routePrefix = 'guests';
        $this->columns = ['id', 'couple_id', 'name', 'email', 'phone', 'guest_index', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $guests = Guest::with('couple')->latest()->paginate(10);
        $title = 'Guests';
        
        return view('guests.index', [
            'guests' => $guests,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Guest';
        $couples = Couple::all();
        
        return view('guests.create', [
            'title' => $title,
            'storeRoute' => route('guests.store'),
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
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
        ]);

        // Generate guest_index as combination of couple_id and phone
        $guestIndex = null;
        if ($request->phone) {
            $guestIndex = $request->couple_id . '_' . preg_replace('/[^0-9]/', '', $request->phone);
        }

        Guest::create([
            'couple_id' => $request->couple_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'guest_index' => $guestIndex,
        ]);

        return redirect()->route('guests.index')
            ->with('success', 'Guest created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $guest = Guest::with('couple')->findOrFail($id);
        $title = 'View Guest';
        
        return view('guests.show', [
            'guest' => $guest,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = Guest::findOrFail($id);
        $title = 'Edit Guest';
        $couples = Couple::all();
        
        return view('guests.edit', [
            'record' => $record,
            'title' => $title,
            'updateRoute' => route('guests.update', $record->id),
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
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
        ]);

        $record = Guest::findOrFail($id);
        
        // Generate guest_index as combination of couple_id and phone
        $guestIndex = null;
        if ($request->phone) {
            $guestIndex = $request->couple_id . '_' . preg_replace('/[^0-9]/', '', $request->phone);
        }

        $record->update([
            'couple_id' => $request->couple_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'guest_index' => $guestIndex,
        ]);

        return redirect()->route('guests.index')
            ->with('success', 'Guest updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = Guest::findOrFail($id);
        $record->delete();

        return redirect()->route('guests.index')
            ->with('success', 'Guest deleted successfully.');
    }
}
