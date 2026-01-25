<nav class="navbar navbar-expand bg-white border-bottom px-4 py-2 shadow-sm">

    <!-- Brand -->
    <a class="navbar-brand fw-bold d-none d-md-block" href="#">
        Airline
    </a>

    <!-- Search -->
    <form class="d-flex mx-auto w-50 position-relative">
        <input class="form-control form-control-sm ps-4 rounded-pill"
               type="search"
               placeholder="Search flights, PNR..."
               aria-label="Search">
        <i class="fas fa-search position-absolute text-muted"
           style="left:14px; top:50%; transform:translateY(-50%)"></i>
    </form>

    <!-- Remaining Balance -->
    @if(Auth::user()->user_type_id == '2')
        <div class="d-flex align-items-center ms-3">
            
            <span class="badge bg-success-subtle text-success fw-semibold px-3 py-2">
                <b class="text-muted me-2 ">{{ __('messages.remaining_balance') }}</b>
                {{ number_format(auth()->user()->remaining_amount+auth()->user()->on_approval_amount) }} EUR
            </span>
        </div>
    @endif

    <!-- Right Icons -->
    <div class="d-flex align-items-center ms-auto gap-3">

        <!-- Notifications -->
        <div class="dropdown">
            <a href="#" class="text-dark position-relative"
               data-bs-toggle="dropdown">
                <i class="fa fa-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li class="dropdown-header fw-semibold">Notifications</li>
                <li><a class="dropdown-item small" href="#">✈ New booking received</a></li>
                <li><a class="dropdown-item small" href="#">💳 Balance updated</a></li>
                <li><a class="dropdown-item small" href="#">📄 PNR cancelled</a></li>
            </ul>
        </div>

<!-- Language Flags -->
<div class="d-flex align-items-center gap-2 ms-3">

    <a href="{{ route('language.switch', 'en') }}"
       class="language-flag"
       title="English">
        <img src="https://flagcdn.com/w20/gb.png" alt="English">
    </a>

    <a href="{{ route('language.switch', 'it') }}"
       class="language-flag"
       title="Italian">
        <img src="https://flagcdn.com/w20/it.png" alt="Italian">
    </a>

    <a href="{{ route('language.switch', 'fr') }}"
       class="language-flag"
       title="French">
        <img src="https://flagcdn.com/w20/fr.png" alt="French">
    </a>

</div>



        <!-- Profile -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none"
               data-bs-toggle="dropdown">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-semibold"
                     style="width:36px;height:36px;">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item" href="{{ route('admin.setting.index') }}">{{ __('messages.profile_setting') }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('messages.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
            </ul>
        </div>

    </div>
</nav>
