<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Agencies Payment List</h1>

        <!-- <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.agency.create') }}" class="btn btn-dark">
                + Create Agency
            </a>

            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                  <path d="M1.5 1.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8L10 7.7v5.6a.5.5 0 0 1-.757.429L7 12.101l-2.243 1.628A.5.5 0 0 1 4 12.3V7.7L1.1 2.3a.5.5 0 0 1 .4-.8z"/>
                </svg>
            </button>
        </div> -->
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

    <!-- Per Page Selector -->
    <div class="mb-3">
        <select wire:model.live="perPage" class="form-select w-auto">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

    <!-- Table -->
    <div class="mb-4">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Agency Name</th>
                    <th>Agency Email</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agencies as $agency)
                    <tr>
                        <td>{{ $agency->name }}</td>
                        <td>{{ $agency->user->email }}</td>
                        <td>{{ $agency->user->paid_balance }}</td>
                        <td>{{ $agency->user->remain_balance }}</td>
                        <td>{{ $agency->created_date }}</td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No agencies payment found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        {{ $agencies->links() }}
    </div>

</div>

