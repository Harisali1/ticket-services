<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Role List</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.role.create') }}" class="btn btn-dark">
                + Create Role
            </a>

            <!-- Filter Button trigger offcanvas -->
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar" aria-controls="filterSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                  <path d="M1.5 1.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8L10 7.7v5.6a.5.5 0 0 1-.757.429L7 12.101l-2.243 1.628A.5.5 0 0 1 4 12.3V7.7L1.1 2.3a.5.5 0 0 1 .4-.8z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Filter Sidebar using Bootstrap Offcanvas -->
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

            <div class="d-flex gap-2">
                <button wire:click="applyFilters" data-bs-dismiss="offcanvas" class="btn btn-dark flex-fill">Search</button>
                <button wire:click="resetFilters" data-bs-dismiss="offcanvas" class="btn btn-outline-secondary flex-fill">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Created On</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->created_at->format('m/d/Y h:i a') }}</td>
                        <td class="position-relative">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $role->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    ⋮
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $role->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.role.edit', $role->id) }}">Edit</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No roles found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $roles->links() }}
    </div>

</div>