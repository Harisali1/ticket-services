<nav class="navbar navbar-expand bg-white border-bottom px-4 py-2">
            <a class="navbar-brand d-none d-md-block" href="#">Airline</a>

            <form class="d-flex mx-auto w-50">
                <input class="form-control form-control-sm me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fas fa-search"></i></button>
            </form>

            @if(Auth::user()->user_type_id == '2')
                <p class="mt-2">Remaining Balance: <span>{{ Auth::user()->remaining_balance }}</span></p>
            @endif
            <div class="dropdown ms-auto">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:35px;height:35px;">JD</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>