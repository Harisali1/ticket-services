<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">User List</h1>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.user.create') }}" class="btn btn-dark">
                + Create User
            </a>

            <!-- Filter button triggers offcanvas -->
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                  <path d="M1.5 1.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8L10 7.7v5.6a.5.5 0 0 1-.757.429L7 12.101l-2.243 1.628A.5.5 0 0 1 4 12.3V7.7L1.1 2.3a.5.5 0 0 1 .4-.8z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Filter Sidebar (Bootstrap Offcanvas) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Filters</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" wire:model.defer="filters.name" class="form-control" placeholder="Name">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" wire:model.defer="filters.email" class="form-control" placeholder="Email">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select wire:model.defer="filters.status" class="form-select">
                    <option value="">Select</option>
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Suspended</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Created Date</label>
                <div class="row g-2">
                    <div class="col">
                        <input type="date" wire:model.defer="filters.from" class="form-control">
                    </div>
                    <div class="col">
                        <input type="date" wire:model.defer="filters.to" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button wire:click="applyFilters" data-bs-dismiss="offcanvas" class="btn btn-dark flex-fill">Search</button>
                <button wire:click="resetFilters" data-bs-dismiss="offcanvas" class="btn btn-outline-secondary flex-fill">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4 g-3">

        <!-- All -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card">
                <div class="card-body text-center" wire:click="filterStatus(0)">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.all') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-dark">
                        {{ $all }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Reserved -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-warning border-4">
                <div class="card-body text-center" wire:click="filterStatus(1)">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.pending') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-warning">
                        {{ $pending }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-success border-4">
                <div class="card-body text-center" wire:click="filterStatus(2)">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.approved') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-success">
                        {{ $approved }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Cancel -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-danger border-4">
                <div class="card-body text-center" wire:click="filterStatus(3)">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.suspended') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-danger">
                        {{ $suspended }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Per Page Selector -->
    <div class="mb-3">
        <select wire:model.live="perPage" class="form-select w-auto">
            <option value="2">2</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>

    <!-- Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('m/d/Y h:i a') }}</td>
                        <td>
                            <span class="{{ $user->status->color() }}">
                                {{ $user->status->label() }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    ⋮
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.user.edit', $user->id) }}">Edit</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No agencies found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        {{ $users->links() }}
    </div>
</div>

