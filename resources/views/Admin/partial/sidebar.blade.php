<div class="d-flex sidebar-position">

    <!-- Sidebar -->
<aside id="sidebar" class="bg-dark text-white d-flex flex-column p-3 sidebar-mobile">
        
       <!-- Title with Logo -->
<div class="mb-4 d-flex align-items-center gap-3">
    <img 
        src="{{ asset('images/logo.jpg') }}"
        alt="Logo"
        style="width:45px;height:45px;object-fit:contain"
        class="rounded border"
    >

    <h1 class="h5 mb-0 fw-semibold">
        DIVINE TRAVEL
    </h1>
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
                    <span class="menu-text">{{ __('messages.home') }}</span>
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
                    <span class="menu-text">{{ __('messages.manage_user') }}</span>
                </a>

                <a href="{{ route('admin.pnr.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-book me-3"></i>
                    <span class="menu-text">{{ __('messages.manage_pnr') }}</span>
                </a>
                 <a href="{{ route('admin.booking.create') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-plane me-3"></i>
                    <span class="menu-text">{{ __('messages.search_flight') }}</span>
                </a>
                <a href="{{ route('admin.booking.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-calendar me-3"></i>
                    <span class="menu-text">{{ __('messages.manage_booking') }}</span>
                </a>
                <a href="{{ route('admin.bank.create') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">{{ __('messages.bank_details') }}</span>
                </a>
                <a href="{{ route('admin.agency.payment.list') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">{{ __('messages.payment') }}</span>
                </a>
                <a href="{{ route('admin.news.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">{{ __('messages.notification') }}</span>
                </a>
            </nav>
        @endif
        @if(Auth::user()->user_type_id == '2' || Auth::user()->user_type_id == '4')
            <nav class="nav flex-column gap-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white bg-secondary rounded d-flex align-items-center">
                    <i class="fa fa-tachometer me-3"></i>
                    <span class="menu-text">{{ __('messages.home') }}</span>
                </a>
                @if(Auth::user()->can('search_flight'))
                <a href="{{ route('admin.booking.create') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-plane me-3"></i>
                    <span class="menu-text">{{ __('messages.search_flight') }}</span>
                </a>
                @endif
                @if(Auth::user()->can('manage_booking'))
                <a href="{{ route('admin.booking.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-calendar me-3"></i>
                    <span class="menu-text">{{__('messages.manage_booking')}}</span>
                </a>
                @endif
                @if(Auth::user()->user_type_id == '2')
                    @if(Auth::user()->can('manage_agencies'))
                        <a href="{{ route('admin.agency.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                            <i class="fa fa-cog me-3"></i>
                            <span class="menu-text">{{ __('messages.sub_agencies') }}</span>
                        </a>
                    @endif
                @endif
                @if(Auth::user()->can('payment'))
                <a href="{{ route('admin.payment.index') }}" class="nav-link text-white rounded d-flex align-items-center hover-bg-secondary">
                    <i class="fa fa-money me-3"></i>
                    <span class="menu-text">{{ __('messages.payment') }}</span>
                </a>
                @endif
            </nav>
        @endif
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

</div>

