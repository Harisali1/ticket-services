<div class="d-flex sidebar-position">

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-dark text-white expanded d-flex flex-column p-3">
        
        <!-- Title -->
        <div class="mb-4">
            <h1 class="h5 mb-0">DIVINE TRAVEL</h1>
        </div>

        <!-- Toggle Button -->
        <!-- <button class="btn btn-outline-light mb-3" id="sidebarToggle">
            <i class="fa fa-bars"></i>
        </button> -->

        <!-- Navigation -->
         @if(Auth::user()->user_type_id == '1' || Auth::user()->user_type_id == '3')
            <nav class="nav flex-column gap-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white bg-secondary rounded d-flex align-items-center">
                    <i class="fa fa-tachometer me-3"></i>
                    <span class="menu-text">{{ __('messages.dashboard') }}</span>
                </a>

                <a href="{{ route('admin.agency.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-building me-3"></i>
                    <span class="menu-text">{{ __('messages.manage_agencies') }}</span>
                </a>

                <a href="{{ route('admin.airline.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-plane me-3"></i>
                    <span class="menu-text">{{ __('messages.manage_airline') }}</span>
                </a>

                <a href="{{ route('admin.airport.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-plane me-3"></i>
                    <span class="menu-text">{{ __('messages.manage_airport') }}</span>
                </a>


                <a href="{{ route('admin.user.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-user me-3"></i>
                    <span class="menu-text">Manage User</span>
                </a>

                <a href="{{ route('admin.pnr.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-book me-3"></i>
                    <span class="menu-text">Manage PNR</span>
                </a>
                 <a href="{{ route('admin.booking.create') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-plane me-3"></i>
                    <span class="menu-text">Search Flight</span>
                </a>
                <a href="{{ route('admin.booking.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-calendar me-3"></i>
                    <span class="menu-text">Manage Bookings</span>
                </a>
                <a href="{{ route('admin.bank.create') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">Bank Details</span>
                </a>
                <a href="{{ route('admin.agency.payment.list') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">Payments</span>
                </a>
                <a href="{{ route('admin.notification.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">Notification</span>
                </a>
            </nav>
        @endif
        @if(Auth::user()->user_type_id == '2')
            <nav class="nav flex-column gap-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white bg-secondary rounded d-flex align-items-center">
                    <i class="fa fa-tachometer me-3"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                @if(Auth::user()->can('search_flight'))
                <a href="{{ route('admin.booking.create') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-plane me-3"></i>
                    <span class="menu-text">Search Flight</span>
                </a>
                @endif
                @if(Auth::user()->can('manage_booking'))
                <a href="{{ route('admin.booking.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-calendar me-3"></i>
                    <span class="menu-text">Manage Bookings</span>
                </a>
                @endif
                @if(Auth::user()->can('manage_agencies'))
                <a href="{{ route('admin.agency.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-cog me-3"></i>
                    <span class="menu-text">Sub Agencies</span>
                </a>
                @endif
                @if(Auth::user()->can('payment'))
                <a href="{{ route('admin.payment.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">Payments</span>
                </a>
                @endif
            </nav>
        @endif
    </aside>
</div>

