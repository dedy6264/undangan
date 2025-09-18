<?php

namespace App\Http\Controllers;

use App\Models\{
    Client,
    Couple,
    WeddingEvent,
    Guest
};
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $clientCount = Client::count();
        $coupleCount = Couple::count();
        $eventCount = WeddingEvent::count();
        $guestCount = Guest::count();
        
        $recentClients = Client::latest()->take(5)->get();
        $recentEvents = WeddingEvent::with('couple')->latest()->take(5)->get();
        
        return view('admin.dashboard-new', compact(
            'clientCount',
            'coupleCount',
            'eventCount',
            'guestCount',
            'recentClients',
            'recentEvents'
        ));
    }
    
    public function clientIndex(Request $request): View
    {
        // Get the authenticated user
        $user = $request->user();
        
        // Get client data if user is associated with a client
        $client = $user->client;
        
        // Get couples associated with this client
        $couples = $client ? $client->couples : collect();
        
        // Get wedding events for these couples
        $coupleIds = $couples->pluck('id');
        $events = WeddingEvent::whereIn('couple_id', $coupleIds)->get();
        
        return view('client.dashboard-new', compact(
            'client',
            'couples',
            'events'
        ));
    }
}
