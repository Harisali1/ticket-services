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
            <span class="text-muted small me-2">Balance</span>
            <span class="badge bg-success-subtle text-success fw-semibold px-3 py-2">
                @php
                    $remainingBalance = Auth::user()->remaining_balance;
                    $partialBalance = Auth::user()->partial_balance;
                    $finalAmount = $remainingBalance - $partialBalance;
                @endphp
                {{ number_format($finalAmount) }}
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

        <!-- Language -->
        <div class="dropdown">
            <a href="#" class="text-dark"
               data-bs-toggle="dropdown">
                <i class="fa fa-globe fs-5"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">🇬🇧 English</a></li>
                <li><a class="dropdown-item" href="{{ route('language.switch', 'it') }}">🇮🇹 Italian</a></li>
                <li><a class="dropdown-item" href="{{ route('language.switch', 'fr') }}">🇫🇷 French</a></li>
            </ul>
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
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.setting.index') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>
