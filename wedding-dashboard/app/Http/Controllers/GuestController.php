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
        $this->routePrefix = auth()->user()->role=="client" ?'my-guests':'guests';
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
        $title = 'Create Guest';
        $couples = Couple::all();
        
        return view('guests.create', [
            'title' => $title,
            'couples' => $couples,
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

        return redirect()->route($this->routePrefix.'.index')
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
            'indexRoute' => route($this->routePrefix.'.index'),
            'editRoute' => $this->routePrefix.'.edit',
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
            'couples' => $couples,
            'indexRoute' => route($this->routePrefix.'.index'),
            'updateRoute' => route($this->routePrefix.'.update',  $record->id),
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

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Guest updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = Guest::findOrFail($id);
        $record->delete();

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Guest deleted successfully.');
    }
}
