<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuestController extends CrudController
{
    public function __construct()
    {
        $this->model = Guest::class;
        $this->routePrefix = 'guests';
        $this->columns = ['id', 'name', 'email', 'phone', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $records = Guest::latest()->paginate(10);
        $title = 'Guests';
        
        return view('admin.crud.index', [
            'records' => $records,
            'title' => $title,
            'columns' => ['name', 'email', 'phone'],
            'createRoute' => route('guests.create'),
            'editRoute' => 'guests.edit',
            'deleteRoute' => 'guests.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Guest';
        
        return view('admin.crud.create', [
            'title' => $title,
            'columns' => ['name', 'email', 'phone'],
            'storeRoute' => route('guests.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
        ]);

        Guest::create($request->all());

        return redirect()->route('guests.index')
            ->with('success', 'Guest created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $record = Guest::findOrFail($id);
        $title = 'View Guest';
        
        return view('admin.crud.show', [
            'record' => $record,
            'title' => $title,
            'columns' => ['name', 'email', 'phone', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = Guest::findOrFail($id);
        $title = 'Edit Guest';
        
        return view('admin.crud.edit', [
            'record' => $record,
            'title' => $title,
            'columns' => ['name', 'email', 'phone'],
            'updateRoute' => route('guests.update', $record->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
        ]);

        $record = Guest::findOrFail($id);
        $record->update($request->all());

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
