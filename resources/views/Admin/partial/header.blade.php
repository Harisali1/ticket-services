<nav class="navbar navbar-expand bg-white border-bottom px-4 py-3 shadow-sm">

    <!-- ===== BRAND ===== -->

    <!-- ===== REMAINING BALANCE ===== -->
    @if(Auth::user()->user_type_id == '2' || Auth::user()->user_type_id == '4')
    <div class="ms-3 d-none d-lg-block">
        <span class="badge bg-success-subtle text-success fw-semibold px-4 py-2 rounded-pill">
            <i class="fas fa-wallet me-1"></i>
            <span class="text-muted me-1">{{ __('messages.remaining_balance') }}</span>
            {{ number_format(auth()->user()->remaining_amount + auth()->user()->on_approval_amount) }} EUR
        </span>
    </div>
    @endif

    @php
    use Illuminate\Notifications\DatabaseNotification;

    $isAdmin = auth()->check() && auth()->user()->user_type_id === 1;

    $notifications = $isAdmin
        ? DatabaseNotification::latest()->take(7)->get()
        : auth()->user()->notifications->take(7);

    $unreadCount = $isAdmin
        ? DatabaseNotification::whereNull('read_at')->count()
        : auth()->user()->unreadNotifications->count();
    @endphp

    <!-- ===== RIGHT SIDE ===== -->
    <div class="d-flex align-items-center ms-auto gap-3">

        <!-- ===== NOTIFICATIONS ===== -->
        <div class="dropdown">
            <a href="#" class="icon-btn position-relative" data-bs-toggle="dropdown">
                <i class="fa fa-bell"></i>
                @if($unreadCount)
                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle blink-badge">
                    {{ $unreadCount }}
                </span>
            @endif
                
            </a>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 notification-dropdown">
            <li class="dropdown-header fw-semibold">Notifications</li>
            @forelse($notifications as $notification)
                <li>
                    <a href="{{ route(
                            $isAdmin ? 'admin.notification.open' : 'admin.notification.open',
                            $notification->id
                        ) }}"
                       class="dropdown-item small {{ $notification->read_at ? '' : 'fw-bold' }}">

                        {{ $notification->data['title'] ?? 'Notification' }}

                        <div class="text-muted small">
                            {{ $notification->data['message'] ?? '' }}
                        </div>
                    </a>
                </li>
            @empty
                <li class="dropdown-item text-muted small">
                    No notifications
                </li>
            @endforelse
        </ul>
    </div>


        <!-- ===== LANGUAGE FLAGS ===== -->
        <div class="d-flex align-items-center gap-2 ms-2">

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

        <!-- ===== PROFILE ===== -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none"
               data-bs-toggle="dropdown">

                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.setting.index') }}">
                        <i class="fas fa-user-cog me-2"></i>
                        {{ __('messages.profile_setting') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>
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
