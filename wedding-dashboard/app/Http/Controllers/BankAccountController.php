<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\WeddingEvent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BankAccountController extends CrudController
{
    public function __construct()
    {
        $this->model = BankAccount::class;
        $this->routePrefix = 'bank-accounts';
        $this->columns = ['id', 'wedding_event_id', 'bank_name', 'account_number', 'account_holder_name', 'is_active', 'created_at', 'updated_at'];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $bankAccounts = BankAccount::with('weddingEvent.couple')->latest()->paginate(10);
        $title = 'Bank Accounts';
        
        return view('bank_accounts.index', [
            'bankAccounts' => $bankAccounts,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $title = 'Create Bank Account';
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('bank_accounts.create', [
            'title' => $title,
            'storeRoute' => route('bank-accounts.store'),
            'weddingEvents' => $weddingEvents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder_name' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        BankAccount::create($request->all());

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $bankAccount = BankAccount::with('weddingEvent.couple')->findOrFail($id);
        $title = 'View Bank Account';
        
        return view('bank_accounts.show', [
            'bankAccount' => $bankAccount,
            'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $record = BankAccount::findOrFail($id);
        $title = 'Edit Bank Account';
        $weddingEvents = WeddingEvent::with('couple')->get();
        
        return view('bank_accounts.edit', [
            'record' => $record,
            'title' => $title,
            'updateRoute' => route('bank-accounts.update', $record->id),
            'weddingEvents' => $weddingEvents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'wedding_event_id' => 'required|exists:wedding_events,id',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder_name' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $record = BankAccount::findOrFail($id);
        $record->update($request->all());

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $record = BankAccount::findOrFail($id);
        $record->delete();

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank Account deleted successfully.');
    }
}
