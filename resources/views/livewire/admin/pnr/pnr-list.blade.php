<div class="container py-5">
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
                
                <div class="row g-2">
                    <div class="col">
                        <label class="form-label">Departure Date</label>
                        <input type="date" wire:model.defer="filters.departure" class="form-control">
                    </div>
                    <!-- <div class="col">
                        <label class="form-label">Arrival Date</label>
                        <input type="date" wire:model.defer="filters.arrival" class="form-control">
                    </div> -->
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
                <div class="card-body text-center">
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
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.created') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-warning">
                        {{ $created }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-secondary border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.total') }} {{ __('messages.seats') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-secondary">
                        {{ $pnrs->sum('total_seats') }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-primary border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.available') }} {{ __('messages.seats') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-primary">
                        {{ $pnrs->sum('available_seats') }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Cancel -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-warning border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.on_sale') }} {{ __('messages.seats') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-warning">
                        {{ $pnrs->sum('on_sale_seats') }}
                    </h2>
                </div>
            </div>
        </div>

        
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('admin.booking.index', ['status' => 1]) }}">
                    <div class="card shadow-sm border-0 h-100 stat-card border-start border-info border-4">
                        <div class="card-body text-center">
                            <p class="text-muted text-uppercase small mb-1">
                                {{ __('messages.reserved') }} {{ __('messages.seats') }}
                            </p>
                            <h2 class="fw-bold mb-0 text-info">
                                {{ $pnrs->sum('reserved_seats') }}
                            </h2>
                        </div>
                    </div>
                </a>
            </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('admin.booking.index', ['status' => [2,3]]) }}">
                <div class="card shadow-sm border-0 h-100 stat-card border-start border-success border-4">
                    <div class="card-body text-center">
                        <p class="text-muted text-uppercase small mb-1">
                            {{ __('messages.sold_out') }} {{ __('messages.seats') }}
                        </p>
                        <h2 class="fw-bold mb-0 text-success">
                            {{ $pnrs->sum('sold_seats') }}
                        </h2>
                    </div>
                </div>
            </a>
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

    <div class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="table-responsive pnr-scroll table-height">
                <table class="table table-hover align-middle mb-0 pnr-table">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">PNR</th>
                            <th>Airline</th>
                            <th>Route</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Total</th>
                            <th>Available</th>
                            <th>Sale</th>
                            <th>Reserved</th>
                            <th>Sold</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pnrs as $pnr)
                            <tr>
                                <td class="ps-4 fw-semibold">
                                    {{ $pnr->ref_no }}
                                </td>

                                <td>
                                    {{ $pnr->airline->name }}
                                </td>

                                <td>
                                    <span class="fw-semibold">{{ $pnr->departure->code }}</span>
                                    →
                                    <span class="fw-semibold">{{ $pnr->arrival->code }}</span>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($pnr->departure_date_time)->format('d M Y') }}<br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($pnr->departure_date_time)->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($pnr->arrival_date_time)->format('d M Y') }}<br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($pnr->arrival_date_time)->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">{{ $pnr->seats }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $pnr->seat_available }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $pnr->seat_is_sale }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.booking.index', ['status' => 1, 'pnr_no' => $pnr->ref_no]) }}"><span class="badge bg-info text-dark">{{ $pnr->seat_is_reserved }}</span></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.booking.index', ['status' => 2, 'pnr_no' => $pnr->ref_no]) }}"><span class="badge bg-success">{{ $pnr->seat_is_sold }}</span></a>
                                </td>
                                

                                <td class="text-end pe-4" wire:key="pnr-row-{{ $pnr->id }}">
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-light rounded-circle"
                                            data-bs-toggle="dropdown"
                                        >
                                            <strong>⋮</strong>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.pnr.edit', $pnr) }}">
                                                    ✏️ Edit
                                                </a>
                                            </li>

                                            @if($pnr->seat_available > 0)
                                                <li>
                                                    <button
                                                        class="dropdown-item"
                                                        onclick="putOnSaleAndCancel({{ $pnr->id }}, 'sale', 'Do you want to put on sale this PNR?')"
                                                    >
                                                        🟢 Put on Sale
                                                    </button>
                                                </li>
                                            @endif

                                            @if($pnr->seat_is_sale > 0)
                                                <li>
                                                    <button
                                                        class="dropdown-item"
                                                        onclick="putOnSaleAndCancel({{ $pnr->id }}, 'cancel', 'Do you want to cancel this sale?')"
                                                    >
                                                        🔴 Cancel Sale
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
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
 



