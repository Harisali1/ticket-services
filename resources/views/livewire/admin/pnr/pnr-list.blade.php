<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Pnr List</h1>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.pnr.create') }}" class="btn btn-dark">
                + Create Pnr
            </a>
             <a href="{{ route('admin.pnr.upload') }}" class="btn btn-dark">
                ! Upload Pnr
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
                <label class="form-label">Pnr No</label>
                <input type="text" wire:model.defer="filters.pnr_no" class="form-control" placeholder="Pnr No #">
            </div>

            <div class="mb-3">
                <label class="form-label">AirLine</label>
                <select wire:model.defer="filters.airline_id" class="form-select">
                    <option value="">Select AirLine</option>
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Suspended</option>
                </select>
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
    <div class="row mb-4">
        @foreach($stats as $label => $count)
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="card border">
                    <div class="card-body">
                        <p class="text-muted mb-1">{{ ucfirst($label) }}</p>
                        <h3 class="card-title">{{ $count }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
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
     <div class="container">
        <div class="mb-4">
            <div class="table-responsive pnrs pnr-scroll">
                <table class="table table-bordered table-hover align-middle pnr-table">
                    <thead class="table-light">
                        <tr>
                            <th>Pnr No</th>
                            <th>Airline</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Departure Date</th>
                            <th>Arrival Date</th>
                            <th>Seats</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pnrs as $pnr)
                            <tr>
                                <td>{{ $pnr->ref_no }}</td>

                                <td>{{ $pnr->airline->name }}</td>

                                <td>{{ $pnr->departure->code }}</td>

                                <td>{{ $pnr->arrival->code }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($pnr->departure_date_time)->format('d M Y') }}<br>
                                    <small>{{ \Carbon\Carbon::parse($pnr->departure_date_time)->format('H:i') }}</small>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($pnr->arrival_date_time)->format('d M Y') }}<br>
                                    <small>{{ \Carbon\Carbon::parse($pnr->arrival_date_time)->format('H:i') }}</small>
                                </td>

                                <td>
                                    Total Seats = {{ $pnr->seats }}<br>
                                    Available Seats = {{ $pnr->seat_available }}<br>
                                    Sale Seats = {{ $pnr->seat_is_sale }}<br>
                                    Sold Seats = {{ $pnr->seat_is_sold }}
                                </td>

                            

                                <td>
                                    <span class="{{ $pnr->status->color() }}">
                                        {{ $pnr->status->label() }}
                                    </span>
                                </td>

                                <td wire:key="pnr-row-{{ $pnr->id }}">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.pnr.edit', $pnr) }}">
                                                    Edit
                                                </a>
                                            </li>

                                            @if($pnr->seat_available > 0)
                                                <li>
                                                    <button class="dropdown-item"
                                                        onclick="putOnSaleAndCancel({{ $pnr->id }}, 'sale', 'Do you want to put on sale this PNR?')">
                                                        Put on Sale
                                                    </button>
                                                </li>
                                            @endif

                                            @if($pnr->seat_is_sale > 0)
                                                <li>
                                                    <button class="dropdown-item"
                                                        onclick="putOnSaleAndCancel({{ $pnr->id }}, 'cancel', 'Do you want to cancel this sale?')">
                                                        Cancel Sale
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-4">
                                    No PNRs found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
     </div>
    
    
    <!-- Pagination -->
    <div>
        {{ $pnrs->links() }}
    </div>

    <!-- put on sale modal -->
    <div wire:ignore.self class="modal fade" id="putOnSaleModal" data-bs-backdrop="static" 
        data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Put on sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeAndRefresh()"></button>
                </div>

                <!-- Body -->
                <form id="put-on-sale">
                    <div class="modal-body pt-0">

                        <p class="text-muted mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            <input type="hidden" readonly id="pnr_id" name="pnr_id" value="{{ $selectedPnrId }}">

                        </p>
                        <h6 class="fw-semibold mb-3">Seat Details</h6>
                        <div class="border rounded mb-4">
                            <div class="d-flex justify-content-between p-3 border-bottom">
                                <span>Total Seats</span>
                                <strong>{{ $selectedPnr->total_seats ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between p-3 border-bottom">
                                <span>Sold Seats</span>
                                <strong>{{ $selectedPnr->sold_seats ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between p-3 border-bottom">
                                <span>On Sale Seats</span>
                                <strong>{{ $selectedPnr->sale_seats ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <span>Available Seats</span>
                                <strong>{{ $selectedPnr->available_seats ?? 0 }}</strong>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Seats</label>
                                <select class="form-select" wire:model="seats" id="seats" name="seats">
                                    <option value="">Select</option>
                                    @for($i = 1; $i <= ($selectedPnr->available_seats ?? 0); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('seats') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Price *</label>
                                
                                
                                <input type="number" class="form-control"
                                    id="price" name="price"
                                    wire:model="price"
                                    placeholder="Enter price">
                                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                    </div>
                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeAndRefresh()">Cancel</button>
                    <button type="submit" class="btn btn-dark">
                        Save
                    </button>
                </div>
                </form>


            </div>
        </div>
    </div>

    <!-- cancel sale modal -->
     <div wire:ignore.self class="modal fade" id="cancelCurrentSaleModal" data-bs-backdrop="static" 
        data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Cancel Current Sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeAndRefresh()"></button>
                </div>

                <!-- Body -->
                <form id="cancel-current-sale">
                    <div class="modal-body pt-0">

                        <p class="text-muted mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            <input type="text" readonly id="pnr_id" name="pnr_id" value="{{ $selectedPnrId }}">

                        </p>
                        <h6 class="fw-semibold mb-3">Seat Details</h6>
                        <div class="border rounded mb-4">
                            <div class="d-flex justify-content-between p-3 border-bottom">
                                <span>Total Seats</span>
                                <strong>{{ $selectedPnr->total_seats ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between p-3 border-bottom">
                                <span>Sold Seats</span>
                                <strong>{{ $selectedPnr->sold_seats ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between p-3 border-bottom">
                                <span>On Sale Seats</span>
                                <strong>{{ $selectedPnr->sale_seats ?? 0 }}</strong>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cancel Sale</label>
                                <select class="form-select" id="cancel_sale" name="cancel_sale">
                                    <option value="">Select</option>
                                    <option value="yes">YES</option>
                                    <option value="no">NO</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Comments</label>
                                <input type="text" class="form-control"
                                    id="comment" name="comment"
                                    wire:model="comment"
                                    placeholder="Enter Your Comments">
                                @error('comment') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                    </div>
                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeAndRefresh()">Cancel</button>
                    <button type="submit" class="btn btn-dark">
                        Save
                    </button>
                </div>
                </form>


            </div>
        </div>
    </div>
</div>
<!-- ================== MODAL ================== -->
 



