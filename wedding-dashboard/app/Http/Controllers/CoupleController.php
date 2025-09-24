<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CoupleController extends CrudController
{
    public function __construct()
    {
        $this->role=auth()->user()->role ;

        $this->model = Couple::class;
        $this->routePrefix = auth()->user()->role=="client" ? 'my-couples':'couples';
        $this->columns = ['id', 'client_id', 'groom_name', 'bride_name', 'wedding_date', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $records = Couple::with('client')->latest()->paginate(10);
        $title = 'Couples';
        
        return view('couples.index', [
            'records' => $records,
            'title' => $title,
            'createRoute' => route($this->routePrefix.'.create'),
            'editRoute' => $this->routePrefix.'.edit',
            'deleteRoute' => $this->routePrefix.'.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Couple';
        $clients = Client::all();
        
        return view('couples.create', [
            'title' => $title,
            'storeRoute' => route($this->routePrefix.'.store'),
            'clients' => $clients,
            'indexRoute' => route($this->routePrefix.'.index'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'groom_name' => 'required|string|max:100',
            'bride_name' => 'required|string|max:100',
            'wedding_date' => 'required|date',
        ]);

        Couple::create($request->all());

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Couple created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $couple = Couple::with('client')->findOrFail($id);
        $title = 'View Couple';
        
        return view('admin.crud.show', [
            'record' => $couple,
            'title' => $title,
             'indexRoute' => route($this->routePrefix.'.index'),
            'editRoute' => $this->routePrefix.'.edit',
            'columns' => ['client_id', 'groom_name', 'bride_name', 'wedding_date', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $couple = Couple::with('client')->findOrFail($id);
        $title = 'Edit Couple';
        $clients = Client::all();
        
        return view('couples.edit', [
            'record' => $couple,
            'title' => $title,
            'updateRoute' => route($this->routePrefix.'.update', $couple->id),
            'clients' => $clients,
            'indexRoute' => route($this->routePrefix.'.index'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'groom_name' => 'required|string|max:100',
            'bride_name' => 'required|string|max:100',
            'wedding_date' => 'required|date',
        ]);

        $couple = Couple::findOrFail($id);
        $couple->update($request->all());

        return redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Couple updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $couple = Couple::findOrFail($id);
        $couple->delete();
        return  redirect()->route($this->routePrefix.'.index')
            ->with('success', 'Couple deleted successfully.');
    }
}
