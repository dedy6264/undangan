<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') || request()->routeIs('client.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - Users -->
    @if(auth()->user()->role=="admin")
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Users</span>
        </a>
    </li>
    
    <!-- Nav Item - Clients -->
    <li class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('clients.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Clients</span>
        </a>
    </li>
    @endif
    
    <!-- Nav Item - Wedding Data Collapse Menu -->
    <li class="nav-item {{ request()->routeIs('couples.*') || request()->routeIs('people.*') || request()->routeIs('wedding-events.*') || request()->routeIs('locations.*') || request()->routeIs('gallery-images.*') || request()->routeIs('timeline-events.*') || request()->routeIs('bank-accounts.*') || request()->routeIs('guests.*') || request()->routeIs('invitations.*') || request()->routeIs('qr-codes.*') || request()->routeIs('guest-messages.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('couples.*') || request()->routeIs('people.*') || request()->routeIs('wedding-events.*') || request()->routeIs('locations.*') || request()->routeIs('gallery-images.*') || request()->routeIs('timeline-events.*') || request()->routeIs('bank-accounts.*') || request()->routeIs('guests.*') || request()->routeIs('invitations.*') || request()->routeIs('qr-codes.*') || request()->routeIs('guest-messages.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseWedding"
            aria-expanded="{{ request()->routeIs('couples.*') || request()->routeIs('people.*') || request()->routeIs('wedding-events.*') || request()->routeIs('locations.*') || request()->routeIs('gallery-images.*') || request()->routeIs('timeline-events.*') || request()->routeIs('bank-accounts.*') || request()->routeIs('guests.*') || request()->routeIs('invitations.*') || request()->routeIs('qr-codes.*') || request()->routeIs('guest-messages.*') ? 'true' : 'false' }}" aria-controls="collapseWedding">
            <i class="fas fa-fw fa-heart"></i>
            <span>Wedding Data</span>
        </a>
        <div id="collapseWedding" class="collapse {{ request()->routeIs('couples.*') || request()->routeIs('people.*') || request()->routeIs('wedding-events.*') || request()->routeIs('locations.*') || request()->routeIs('gallery-images.*') || request()->routeIs('timeline-events.*') || request()->routeIs('bank-accounts.*') || request()->routeIs('guests.*') || request()->routeIs('invitations.*') || request()->routeIs('qr-codes.*') || request()->routeIs('guest-messages.*') ? 'show' : '' }}" aria-labelledby="headingWedding" data-parent="#accordionSidebar">
            <div class="py-2 bg-white rounded collapse-inner">
                @if(auth()->user()->role=="admin")
                <a class="collapse-item {{ request()->routeIs('couples.*') ? 'active' : '' }}" href="{{ route('couples.index') }}">Couples</a>
                <a class="collapse-item {{ request()->routeIs('people.*') ? 'active' : '' }}" href="{{ route('people.index') }}">People</a>
                <a class="collapse-item {{ request()->routeIs('wedding-events.*') ? 'active' : '' }}" href="{{ route('wedding-events.index') }}">Wedding Events</a>
                <a class="collapse-item {{ request()->routeIs('locations.*') ? 'active' : '' }}" href="{{ route('locations.index') }}">Locations</a>
                @endif
                <a class="collapse-item {{ request()->routeIs('gallery-images.*') ? 'active' : '' }}" href="{{ route('gallery-images.index') }}">Gallery Images</a>
                <a class="collapse-item {{ request()->routeIs('timeline-events.*') ? 'active' : '' }}" href="{{ route('timeline-events.index') }}">Timeline Events</a>
                <a class="collapse-item {{ request()->routeIs('bank-accounts.*') ? 'active' : '' }}" href="{{ route('bank-accounts.index') }}">Bank Accounts</a>
                <a class="collapse-item {{ request()->routeIs('guests.*') ? 'active' : '' }}" href="{{ route('guests.index') }}">Guests</a>
                <a class="collapse-item {{ request()->routeIs('invitations.*') ? 'active' : '' }}" href="{{ route('invitations.index') }}">Invitations</a>
                <a class="collapse-item {{ request()->routeIs('qr-codes.*') ? 'active' : '' }}" href="{{ route('qr-codes.index') }}">QR Codes</a>
                <a class="collapse-item {{ request()->routeIs('guest-messages.*') ? 'active' : '' }}" href="{{ route('guest-messages.index') }}">Guest Messages</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Business Management Collapse Menu -->
    <li class="nav-item {{ request()->routeIs('packages.*') || request()->routeIs('transactions.*') || request()->routeIs('payment-methods.*') || request()->routeIs('payment-transactions.*') || request()->routeIs('create-order.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('packages.*') || request()->routeIs('transactions.*') || request()->routeIs('payment-methods.*') || request()->routeIs('payment-transactions.*') || request()->routeIs('create-order.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseBusiness"
            aria-expanded="{{ request()->routeIs('packages.*') || request()->routeIs('transactions.*') || request()->routeIs('payment-methods.*') || request()->routeIs('payment-transactions.*') || request()->routeIs('create-order.*') ? 'true' : 'false' }}" aria-controls="collapseBusiness">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Business Management</span>
        </a>
        <div id="collapseBusiness" class="collapse {{ request()->routeIs('packages.*') || request()->routeIs('transactions.*') || request()->routeIs('payment-methods.*') || request()->routeIs('payment-transactions.*') || request()->routeIs('create-order.*') ? 'show' : '' }}" aria-labelledby="headingBusiness" data-parent="#accordionSidebar">
            <div class="py-2 bg-white rounded collapse-inner">
                 @if(auth()->user()->role=="admin")
                <a class="collapse-item {{ request()->routeIs('packages.*') ? 'active' : '' }}" href="{{ route('packages.index') }}">Packages</a>
                @endif
                <a class="collapse-item {{ request()->routeIs('create-order.*') ? 'active' : '' }}" href="{{ route('create-order.step1') }}">Create Order</a>
                <a class="collapse-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
                 @if(auth()->user()->role=="admin")
                <a class="collapse-item {{ request()->routeIs('payment-methods.*') ? 'active' : '' }}" href="{{ route('payment-methods.index') }}">Payment Methods</a>
                <a class="collapse-item {{ request()->routeIs('payment-transactions.*') ? 'active' : '' }}" href="{{ route('payment-transactions.index') }}">Payment Transactions</a>
                @endif
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="border-0 rounded-circle" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->