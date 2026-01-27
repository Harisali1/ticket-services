<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">{{ __('messages.booking_list') }}</h1>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.booking.create') }}" class="btn btn-dark">
                + {{ __('messages.create_booking') }}
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
                <label class="form-label">Booking No</label>
                <input type="text" wire:model.defer="filters.booking_no" class="form-control" placeholder="Booking No #">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select wire:model.defer="filters.status" class="form-select">
                    <option value="">Select</option>
                    <option value="1">Created</option>
                    <option value="2">Ticketed</option>
                    <option value="3">Paid</option>
                    <option value="4">Void</option>
                    <option value="5">Cancel</option>
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

        <div class="col-12 col-sm-6 col-lg-2">
            <div class="card shadow-sm border-0 h-100 stat-card">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.all') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-dark">
                        {{ $allCounts }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Reserved -->
        <div class="col-12 col-sm-6 col-lg-2">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-warning border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.reserved') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-warning">
                        {{ $reservedCounts }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Ticketed -->
        <div class="col-12 col-sm-6 col-lg-2">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-primary border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.ticketed') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-primary">
                        {{ $ticketedCounts }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="col-12 col-sm-6 col-lg-2">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-success border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.paid') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-success">
                        {{ $paidCounts }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Void -->
        <div class="col-12 col-sm-6 col-lg-2">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-secondary border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.void') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-secondary">
                        {{ $voidCounts }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Cancel -->
        <div class="col-12 col-sm-6 col-lg-2">
            <div class="card shadow-sm border-0 h-100 stat-card border-start border-danger border-4">
                <div class="card-body text-center">
                    <p class="text-muted text-uppercase small mb-1">
                        {{ __('messages.cancel') }}
                    </p>
                    <h2 class="fw-bold mb-0 text-danger">
                        {{ $cancelCounts }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Per Page Selector -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <select wire:model.live="perPage" class="form-select form-select-sm w-auto">
                <option value="2">2</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <button wire:click="exportExcel" class="btn btn-sm btn-success">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </button>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-lg">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <!-- Table Head -->
                <thead class="bg-light">
                    <tr class="text-uppercase small text-muted">
                        <th>{{ __('messages.booking_no') }} #</th>
                        <th>{{ __('messages.pnr_no') }} #</th>
                        <th>{{ __('messages.departure_date_time') }}</th>
                        <th>{{ __('messages.arrival_date_time') }}</th>
                        <th class="text-center">{{ __('messages.seats') }}</th>
                        <th>{{ __('messages.paid_by') }}</th>
                        <th>{{ __('messages.paid_at') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th class="text-end">{{ __('messages.action') }}</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($bookings as $booking)

                    @php
                        $bookingDate = \Carbon\Carbon::parse($booking->created_at)->toDateString();
                        $today = \Carbon\Carbon::today()->toDateString();
                        $now = \Carbon\Carbon::now();
                    @endphp

                    <tr>
                        <td class="fw-semibold">{{ $booking->booking_no }}</td>

                        <td class="text-muted">
                            {{ $booking->pnr?->pnr_no }}
                        </td>

                        <td>{{ $booking->pnr?->departure_date }}</td>
                        <td>{{ $booking->pnr?->arrival_date }}</td>

                        <td class="text-center">
                            <span class="badge bg-secondary-subtle text-dark">
                                {{ $booking->seats }}
                            </span>
                        </td>

                        <td>{{ optional($booking->payable)->name }}</td>
                        <td>{{ $booking->paid_at }}</td>

                        <!-- Status -->
                        <td>
                            <span class="badge rounded-pill {{ $booking->status->color() }}">
                                {{ $booking->status->label() }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">

                                @if($booking->status->label() === 'Created')
                                    <a href="{{ route('admin.booking.details', [$booking->id, $booking->pnr_id, $booking->return_pnr_id ?? 0]) }}"
                                    class="btn btn-sm btn-outline-info">
                                        PNR
                                    </a>

                                @elseif($booking->status->label() === 'Ticketed')
                                    <a href="{{ route('admin.booking.details', [$booking->id, $booking->pnr_id, $booking->return_pnr_id ?? 0]) }}"
                                    class="btn btn-sm btn-outline-success">
                                        TKT
                                    </a>

                                    @can('void')
                                        @if($bookingDate == $today && $now->hour >= 0)
                                            <button class="btn btn-sm btn-outline-warning"
                                                    onclick="voidBooking({{ $booking->id }})">
                                                Void
                                            </button>
                                        @endif
                                    @endcan

                                @elseif($booking->status->label() === 'Paid')
                                    <a href="{{ route('admin.booking.details', [$booking->id, $booking->pnr_id, $booking->return_pnr_id ?? 0]) }}"
                                    class="btn btn-sm btn-outline-success">
                                        Paid
                                    </a>

                                @elseif($booking->status->label() === 'Cancel')
                                    <span class="badge bg-danger-subtle text-danger">
                                        Cancelled
                                    </span>
                                @endif

                                @if($booking->status->label() === 'Void')
                                    <span class="badge bg-warning-subtle text-warning">
                                        Voided
                                    </span>
                                @endif

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No bookings found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $bookings->links() }}
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
                            <input type="text" readonly id="pnr_id" name="pnr_id" wire:model="selectedPnrId">

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
                    <button class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeAndRefresh()">Cancel</button>
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
                            <input type="text" readonly id="pnr_id" name="pnr_id" wire:model="selectedPnrId">

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
                    <button class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeAndRefresh()">Cancel</button>
                    <button type="submit" class="btn btn-dark">
                        Save
                    </button>
                </div>
                </form>


            </div>
        </div>
    </div>
</div>
<script>

    


    function voidBooking(id){
        let url = "{{ route('admin.booking.void', ':id') }}";
        url = url.replace(':id', id);   

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Void this booking!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.close();

                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: true,
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('admin.booking.index') }}";
                            }
                        });
                    },
                    error: function (xhr) {
                        Swal.close();

                        let message = "Something went wrong";
                        if (xhr.responseJSON?.errors) {
                            message = Object.values(xhr.responseJSON.errors)[0][0];
                        } else if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    }
                });
            }
        });  
    }

</script>

<!-- ================== MODAL ================== -->
 



