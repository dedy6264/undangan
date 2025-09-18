<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminUserController,
    DashboardController,
    ClientController,
    CoupleController,
    PersonController,
    PersonParentController,
    WeddingEventController,
    LocationController,
    GalleryImageController,
    TimelineEventController,
    BankAccountController,
    GuestController,
    InvitationController,
    QrCodeController,
    GuestMessageController,
    PackageController,
    TransactionController,
    PaymentMethodController,
    PaymentTransactionController,
    ProfileController
};

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // All admin CRUD operations
    Route::resource('clients', ClientController::class);
    Route::resource('couples', CoupleController::class);
    Route::resource('people', PersonController::class);
    Route::resource('wedding-events', WeddingEventController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('gallery-images', GalleryImageController::class);
    Route::resource('timeline-events', TimelineEventController::class);
    Route::resource('bank-accounts', BankAccountController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('invitations', InvitationController::class);
    Route::resource('qr-codes', QrCodeController::class);
    Route::resource('guest-messages', GuestMessageController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('payment-transactions', PaymentTransactionController::class);
    
    // User management
    Route::resource('admin/users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

// Client routes (protected by client middleware)
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/client/dashboard', [DashboardController::class, 'clientIndex'])->name('client.dashboard');
    
    // Client-specific routes (limited access)
    Route::resource('my-couples', CoupleController::class)->only(['index', 'show']);
    Route::resource('my-wedding-events', WeddingEventController::class)->only(['index', 'show']);
    Route::resource('my-gallery-images', GalleryImageController::class)->only(['index', 'show']);
    Route::resource('my-timeline-events', TimelineEventController::class)->only(['index', 'show']);
    Route::resource('my-bank-accounts', BankAccountController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
