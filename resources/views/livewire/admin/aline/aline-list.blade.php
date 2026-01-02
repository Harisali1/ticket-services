<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">AirLine List</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.airline.create') }}" class="btn btn-dark">
                + Create AirLine
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

            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" wire:model.defer="filters.code" class="form-control" placeholder="Code">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select wire:model.defer="filters.status" class="form-select">
                    <option value="">Select</option>
                    <option value="1">Active</option>
                    <option value="2">DeActive</option>
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
    <div class="row g-3 my-4">
        @foreach($stats as $label => $count)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card p-3 text-center">
                    <p class="text-muted mb-1">{{ ucfirst($label) }}</p>
                    <h3 class="mb-0">{{ $count }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Table -->
    <div class="">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">Logo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created On</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($airlines as $airline)
                    <tr>
                        <td>
                            <img src="{{ $airline->logo 
                                ? asset('storage/'.$airline->logo) 
                                : asset('images/logo-placeholder.png') }}"
                                alt="logo"
                                class="rounded-circle border"
                                style="width:45px;height:45px;object-fit:contain;">
                        </td>
                        <td>{{ $airline->name }}</td>
                        <td>{{ $airline->code }}</td>
                        <td>
                            <span class="{{ $airline->status->color() }}">
                                {{ $airline->status->label() }}
                            </span>
                        </td>
                        <td>{{ $airline->created_at->format('m/d/Y h:i a') }}</td>
                        <td class="position-relative">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $airline->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    ⋮
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $airline->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.airline.edit', $airline->id) }}">Edit</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No airlines found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $airlines->links() }}
    </div>

</div>