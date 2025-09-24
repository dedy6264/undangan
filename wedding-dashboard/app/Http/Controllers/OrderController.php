<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Client;
use App\Models\Couple;
use App\Models\Person;
use App\Models\PersonParent;
use App\Models\WeddingEvent;
use App\Models\Location;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show the package selection step.
     */
    public function step1(Request $request): View
    {
        $packages = Package::all();
        $title = 'Create Order - Step 1: Select Package';
        
        // Get the authenticated user
        $user = $request->user();
        
        // For admin users, get all clients for dropdown
        $clients = [];
        if ($user->role === 'admin') {
            $clients = Client::all();
        }
        
        return view('orders.step1', [
            'packages' => $packages,
            'clients' => $clients,
            'user' => $user,
            'title' => $title,
            'step' => 1,
            'progress' => 14,
        ]);
    }

    /**
     * Process package selection and go to step 2.
     */
    public function processStep1(Request $request): RedirectResponse
    {
        // Get the authenticated user
        $user = $request->user();
        
        // Validate package selection
        $validatedData = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'client_id' => $user->role === 'admin' ? 'required|exists:clients,id' : 'nullable',
        ]);

        // Store package_id in session for later use
        session(['order_package_id' => $validatedData['package_id']]);

        // For admin users, store selected client_id in session
        if ($user->role === 'admin' && isset($validatedData['client_id'])) {
            session(['order_client_id' => $validatedData['client_id']]);
            // Skip step 2 (client creation) and go directly to step 3
            return redirect()->route('create-order.step3')
                ->with('success', 'Package and client selected successfully.');
        }
        
        // For regular users, use their own client_id
        if ($user->role === 'client' && $user->client_id) {
            session(['order_client_id' => $user->client_id]);
            // Skip step 2 (client creation) and go directly to step 3
            return redirect()->route('create-order.step3')
                ->with('success', 'Package selected successfully.');
        }

        // If we reach here, it means admin didn't select a client or regular user has no client
        // This shouldn't happen in normal circumstances, but we'll redirect to step 2 just in case
        return redirect()->route('create-order.step2')
            ->with('success', 'Package selected successfully.');
    }

    /**
     * Show the client creation step.
     */
    public function step2(): View
    {
        $title = 'Create Order - Step 2: Client Information';
        
        return view('orders.step2', [
            'title' => $title,
            'step' => 2,
            'progress' => 28,
        ]);
    }

    /**
     * Process client creation and go to step 3.
     */
    public function processStep2(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:100',
            'nik' => 'nullable|string|max:50|unique:clients,nik',
            'phone' => 'nullable|string|max:50|unique:clients,phone',
        ], [
            'nik.unique' => 'A client with this NIK already exists.',
            'phone.unique' => 'A client with this phone number already exists.',
        ]);

        // Create client
        $client = Client::create($validatedData);

        // Store client_id in session for later use
        session(['order_client_id' => $client->id]);

        return redirect()->route('create-order.step3')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Show the couple creation step.
     */
    public function step3(): View
    {
        $title = 'Create Order - Step 3: Couple Information';
        
        return view('orders.step3', [
            'title' => $title,
            'step' => 3,
            'progress' => 42,
        ]);
    }

    /**
     * Process couple creation and go to step 4.
     */
    public function processStep3(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'groom_name' => 'required|string|max:100',
            'bride_name' => 'required|string|max:100',
            'wedding_date' => 'required|date|after:today',
        ], [
            'wedding_date.after' => 'The wedding date must be a future date.',
        ]);

        // Get client_id from session
        $clientId = session('order_client_id');

        // Create couple
        $couple = Couple::create([
            'client_id' => $clientId,
            'groom_name' => $validatedData['groom_name'],
            'bride_name' => $validatedData['bride_name'],
            'wedding_date' => $validatedData['wedding_date'],
        ]);

        // Store couple_id in session for later use
        session(['order_couple_id' => $couple->id]);

        return redirect()->route('create-order.step4')
            ->with('success', 'Couple created successfully.');
    }

    /**
     * Show the people creation step.
     */
    public function step4(): View
    {
        $title = 'Create Order - Step 4: People Information';
        
        return view('orders.step4', [
            'title' => $title,
            'step' => 4,
            'progress' => 57,
        ]);
    }

    /**
     * Process people creation and go to step 5.
     */
    public function processStep4(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'groom_full_name' => 'required|string|max:100',
            'groom_image_url' => 'nullable|url|max:255',
            'groom_additional_info' => 'nullable|string',
            'groom_father_name' => 'nullable|string|max:100',
            'groom_father_status' => 'nullable|in:alive,deceased',
            'groom_mother_name' => 'nullable|string|max:100',
            'groom_mother_status' => 'nullable|in:alive,deceased',
            'bride_full_name' => 'required|string|max:100',
            'bride_image_url' => 'nullable|url|max:255',
            'bride_additional_info' => 'nullable|string',
            'bride_father_name' => 'nullable|string|max:100',
            'bride_father_status' => 'nullable|in:alive,deceased',
            'bride_mother_name' => 'nullable|string|max:100',
            'bride_mother_status' => 'nullable|in:alive,deceased',
        ]);

        // Get couple_id from session
        $coupleId = session('order_couple_id');

        // Create groom
        $groom = Person::create([
            'couple_id' => $coupleId,
            'role' => 'groom',
            'full_name' => $validatedData['groom_full_name'],
            'image_url' => $validatedData['groom_image_url'],
            'additional_info' => $validatedData['groom_additional_info'],
        ]);

        // Create groom's parents if provided
        if ($validatedData['groom_father_name'] || $validatedData['groom_mother_name']) {
            PersonParent::create([
                'person_id' => $groom->id,
                'father_name' => $validatedData['groom_father_name'] ?? null,
                'father_status' => $validatedData['groom_father_status'] ?? 'alive',
                'mother_name' => $validatedData['groom_mother_name'] ?? null,
                'mother_status' => $validatedData['groom_mother_status'] ?? 'alive',
            ]);
        }

        // Create bride
        $bride = Person::create([
            'couple_id' => $coupleId,
            'role' => 'bride',
            'full_name' => $validatedData['bride_full_name'],
            'image_url' => $validatedData['bride_image_url'],
            'additional_info' => $validatedData['bride_additional_info'],
        ]);

        // Create bride's parents if provided
        if ($validatedData['bride_father_name'] || $validatedData['bride_mother_name']) {
            PersonParent::create([
                'person_id' => $bride->id,
                'father_name' => $validatedData['bride_father_name'] ?? null,
                'father_status' => $validatedData['bride_father_status'] ?? 'alive',
                'mother_name' => $validatedData['bride_mother_name'] ?? null,
                'mother_status' => $validatedData['bride_mother_status'] ?? 'alive',
            ]);
        }

        return redirect()->route('create-order.step5')
            ->with('success', 'People created successfully.');
    }

    /**
     * Show the wedding event creation step.
     */
    public function step5(): View
    {
        $title = 'Create Order - Step 5: Wedding Event Information';
        
        return view('orders.step5', [
            'title' => $title,
            'step' => 5,
            'progress' => 71,
        ]);
    }

    /**
     * Process wedding event creation and go to step 6.
     */
    public function processStep5(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:100',
            'event_date' => 'required|date|after:today',
            'event_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:event_time',
        ], [
            'event_date.after' => 'The event date must be a future date.',
            'end_time.after' => 'The end time must be after the event time.',
        ]);

        // Get couple_id from session
        $coupleId = session('order_couple_id');

        // Create wedding event
        $weddingEvent = WeddingEvent::create([
            'couple_id' => $coupleId,
            'event_name' => $validatedData['event_name'],
            'event_date' => $validatedData['event_date'],
            'event_time' => $validatedData['event_time'],
            'end_time' => $validatedData['end_time'],
        ]);

        // Store wedding_event_id in session for later use
        session(['order_wedding_event_id' => $weddingEvent->id]);

        return redirect()->route('create-order.step6')
            ->with('success', 'Wedding event created successfully.');
    }

    /**
     * Show the location creation step.
     */
    public function step6(): View
    {
        $title = 'Create Order - Step 6: Location Information';
        
        return view('orders.step6', [
            'title' => $title,
            'step' => 6,
            'progress' => 85,
        ]);
    }

    /**
     * Process location creation and go to step 7.
     */
    public function processStep6(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'venue_name' => 'required|string|max:150',
            'address' => 'required|string',
            'map_embed_url' => 'nullable|url|max:255',
        ]);

        // Get wedding_event_id from session
        $weddingEventId = session('order_wedding_event_id');

        // Create location
        Location::create([
            'wedding_event_id' => $weddingEventId,
            'venue_name' => $validatedData['venue_name'],
            'address' => $validatedData['address'],
            'map_embed_url' => $validatedData['map_embed_url'],
        ]);

        return redirect()->route('create-order.step7')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Show the payment method selection step.
     */
    public function step7(): View
    {
        $paymentMethods = PaymentMethod::all();
        $title = 'Create Order - Step 7: Payment Method';
        
        return view('orders.step7', [
            'paymentMethods' => $paymentMethods,
            'title' => $title,
            'step' => 7,
            'progress' => 100,
        ]);
    }

    /**
     * Process payment method selection and create transaction.
     */
    public function processStep7(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        // Get data from session
        $packageId = session('order_package_id');
        $coupleId = session('order_couple_id');
        $paymentMethodId = $validatedData['payment_method_id'];

        // Get package to calculate total amount
        $package = Package::findOrFail($packageId);

        // Get payment method details
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        // Calculate fees
        $providerAdminFee = $paymentMethod->provider_admin_fee ?? 0;
        $providerMerchantFee = $paymentMethod->provider_merchant_fee ?? 0;
        $adminFee = $paymentMethod->admin_fee ?? 0;
        $merchantFee = $paymentMethod->merchant_fee ?? 0;

        // Calculate total amount (package price + all fees)
        $totalAmount = $package->price + $providerAdminFee + $providerMerchantFee + $adminFee + $merchantFee;

        // Use database transaction to ensure data consistency
        DB::beginTransaction();
        try {
            // Create transaction with pending status
            $transaction = Transaction::create([
                'couple_id' => $coupleId,
                'package_id' => $packageId,
                'status' => 'pending',
                'total_amount' => $totalAmount,
            ]);

            // Create payment transaction
            PaymentTransaction::create([
                'transaction_id' => $transaction->id,
                'payment_method_id' => $paymentMethodId,
                'payment_method_name' => $paymentMethod->payment_method_name,
                'provider_admin_fee' => $providerAdminFee,
                'provider_merchant_fee' => $providerMerchantFee,
                'admin_fee' => $adminFee,
                'merchant_fee' => $merchantFee,
            ]);

            // Commit the transaction
            DB::commit();

            // Clear session data
            session()->forget([
                'order_package_id',
                'order_client_id',
                'order_couple_id',
                'order_wedding_event_id'
            ]);

            return redirect()->route('transactions.index')
                ->with('success', 'Order created successfully with pending status.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Failed to create order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Cancel the order creation process.
     */
    public function cancel(): RedirectResponse
    {
        // Clear session data
        session()->forget([
            'order_package_id',
            'order_client_id',
            'order_couple_id',
            'order_wedding_event_id'
        ]);

        return redirect()->route('dashboard')
            ->with('info', 'Order creation process cancelled.');
    }
}