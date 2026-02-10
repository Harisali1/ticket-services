<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">{{__('messages.agencies_list')}}</h1>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.agency.create') }}" class="btn btn-dark">
                + {{__('messages.create_agency')}}
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
                <label class="form-label">Agency Name</label>
                <input type="text" wire:model.defer="filters.agency_name" class="form-control" placeholder="Agency Name">
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
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
        </select>
    </div>

    <!-- Table -->
    <div class="mb-4 card shadow-sm border-0">
        <div class="table-responsive table-height">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted text-uppercase small">
                    <tr>
                        <th class="ps-4">{{__('messages.agency_name')}}</th>
                        <th>{{__('messages.agency_email')}}</th>
                        <th>{{__('messages.piva')}}</th>
                        <th>{{__('messages.address')}}</th>
                        <th>{{__('messages.created_on')}}</th>
                        <th>{{__('messages.status')}}</th>
                        <th class="text-end pe-4">{{__('messages.action')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($agencies as $agency)
                        <tr class="border-top">
                            <td class="ps-4 fw-semibold">
                                {{ $agency->name }}
                            </td>

                            <td class="text-muted">
                                {{ $agency->user->email }}
                            </td>

                            <td>
                                {{ $agency->piv }}
                            </td>

                            <td class="text-muted text-truncate" style="max-width: 200px;">
                                {{ $agency->address }}
                            </td>

                            <td class="text-muted">
                                {{ $agency->created_date }}
                            </td>

                            <td>
                                <span class="{{ $agency->status->color() }}">
                                    {{ $agency->status->label() }}
                                </span>
                            </td>

                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-light rounded-circle"
                                        data-bs-toggle="dropdown"
                                    >
                                        <strong>⋮</strong>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.agency.edit', $agency->id) }}">
                                                ✏️ Edit
                                            </a>
                                        </li>

                                        @if(auth()->user()->user_type_id != 2)
                                            <li>
                                                <button
                                                    class="dropdown-item"
                                                    wire:click="openPasswordModal({{ $agency->id }})"
                                                >
                                                    🔐 Show Pass
                                                </button>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.role.permission.create', $agency->user_id) }}">
                                                    🛡 Assign Permission
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete-button" onclick="deleteAgency({{ $agency->id }})">
                                                    🗑 Delete
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.agency.show', $agency->id) }}">
                                                👁 View Details
                                            </a>
                                        </li>

                                        

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No agencies found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Pagination -->
    <div>
        {{ $agencies->links() }}
    </div>
    <div wire:ignore.self class="modal fade" id="passwordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Admin Authentication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    @if(!$showPassword)
                        <label class="form-label">Admin Password</label>
                        <input 
                            type="password"
                            class="form-control"
                            wire:model.defer="adminPassword"
                        >

                        @error('adminPassword')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    @endif

                    @if($showPassword)
                        <div class="alert alert-success text-center">
                            <strong>Agency Password</strong><br>
                            <span class="fs-4">{{ $agencyPassword }}</span>
                        </div>
                    @endif

                </div>

                <div class="modal-footer">
                    <button 
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>

                    @if(!$showPassword)
                        <button 
                            type="button"
                            class="btn btn-dark"
                            wire:click="verifyAdminPassword"
                        >
                            Verify
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

