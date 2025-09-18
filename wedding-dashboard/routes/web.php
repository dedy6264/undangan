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
    ProfileController,
    OrderController
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
    
    // Order creation routes
    Route::get('/create-order/step1', [OrderController::class, 'step1'])->name('create-order.step1');
    Route::post('/create-order/step1', [OrderController::class, 'processStep1'])->name('create-order.process-step1');
    Route::get('/create-order/step2', [OrderController::class, 'step2'])->name('create-order.step2');
    Route::post('/create-order/step2', [OrderController::class, 'processStep2'])->name('create-order.process-step2');
    Route::get('/create-order/step3', [OrderController::class, 'step3'])->name('create-order.step3');
    Route::post('/create-order/step3', [OrderController::class, 'processStep3'])->name('create-order.process-step3');
    Route::get('/create-order/step4', [OrderController::class, 'step4'])->name('create-order.step4');
    Route::post('/create-order/step4', [OrderController::class, 'processStep4'])->name('create-order.process-step4');
    Route::get('/create-order/step5', [OrderController::class, 'step5'])->name('create-order.step5');
    Route::post('/create-order/step5', [OrderController::class, 'processStep5'])->name('create-order.process-step5');
    Route::get('/create-order/step6', [OrderController::class, 'step6'])->name('create-order.step6');
    Route::post('/create-order/step6', [OrderController::class, 'processStep6'])->name('create-order.process-step6');
    Route::get('/create-order/step7', [OrderController::class, 'step7'])->name('create-order.step7');
    Route::post('/create-order/step7', [OrderController::class, 'processStep7'])->name('create-order.process-step7');
    Route::post('/create-order/cancel', [OrderController::class, 'cancel'])->name('create-order.cancel');
    
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
