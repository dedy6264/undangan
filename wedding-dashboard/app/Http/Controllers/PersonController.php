<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\PersonParent;
use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonController extends CrudController
{
    public function __construct()
    {
        $this->model = Person::class;
        $this->routePrefix = 'people';
        $this->columns = ['id', 'couple_id', 'role', 'full_name', 'image_url', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $records = Person::with('couple')->latest()->paginate(10);
        $title = 'People';
        
        return view('admin.crud.index', [
            'records' => $records,
            'title' => $title,
            'columns' => ['couple_id', 'role', 'full_name', 'image_url'],
            'createRoute' => route('people.create'),
            'editRoute' => 'people.edit',
            'deleteRoute' => 'people.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Person';
        $couples = Couple::all();
        
        return view('people.create', compact('title', 'couples'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'couple_id' => 'required|exists:couples,id',
            'role' => 'required|in:groom,bride',
            'full_name' => 'required|string|max:100',
            'image_url' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            // Person Parent validation rules
            'father_name' => 'nullable|string|max:100',
            'father_status' => 'nullable|in:alive,deceased',
            'mother_name' => 'nullable|string|max:100',
            'mother_status' => 'nullable|in:alive,deceased',
        ], [
            'couple_id.unique' => 'A person with this role already exists for the selected couple.',
        ]);

        // Check if a person with the same couple_id and role already exists
        $existingPerson = Person::where('couple_id', $request->couple_id)
            ->where('role', $request->role)
            ->first();
            
        if ($existingPerson) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['couple_id' => 'A person with this role already exists for the selected couple.']);
        }

        // Create the person
        $person = Person::create($request->only([
            'couple_id', 'role', 'full_name', 'image_url', 'additional_info'
        ]));

        // Create or update person parent information
        if ($person && ($request->father_name || $request->mother_name)) {
            PersonParent::updateOrCreate(
                ['person_id' => $person->id],
                $request->only(['father_name', 'father_status', 'mother_name', 'mother_status'])
            );
        }

        return redirect()->route('people.index')
            ->with('success', 'Person created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $record = Person::with(['couple', 'personParent'])->findOrFail($id);
        $title = 'View Person';
        
        return view('people.show', compact('record', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = Person::with(['couple', 'personParent'])->findOrFail($id);
        $title = 'Edit Person';
        $couples = Couple::all();
        
        return view('people.edit', compact('record', 'title', 'couples'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $record = Person::findOrFail($id);
        
        $request->validate([
            'couple_id' => 'required|exists:couples,id',
            'role' => 'required|in:groom,bride',
            'full_name' => 'required|string|max:100',
            'image_url' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            // Person Parent validation rules
            'father_name' => 'nullable|string|max:100',
            'father_status' => 'nullable|in:alive,deceased',
            'mother_name' => 'nullable|string|max:100',
            'mother_status' => 'nullable|in:alive,deceased',
        ]);

        // Check if a person with the same couple_id and role already exists (excluding current record)
        $existingPerson = Person::where('couple_id', $request->couple_id)
            ->where('role', $request->role)
            ->where('id', '!=', $id)
            ->first();
            
        if ($existingPerson) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['couple_id' => 'A person with this role already exists for the selected couple.']);
        }

        $record->update($request->only([
            'couple_id', 'role', 'full_name', 'image_url', 'additional_info'
        ]));

        // Create or update person parent information
        if ($request->father_name || $request->mother_name) {
            PersonParent::updateOrCreate(
                ['person_id' => $record->id],
                $request->only(['father_name', 'father_status', 'mother_name', 'mother_status'])
            );
        } else {
            // If no parent info provided, delete existing record
            PersonParent::where('person_id', $record->id)->delete();
        }

        return redirect()->route('people.index')
            ->with('success', 'Person updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = Person::findOrFail($id);
        $record->delete();

        return redirect()->route('people.index')
            ->with('success', 'Person deleted successfully.');
    }
}
