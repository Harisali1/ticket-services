<div class="container my-4">
    <h5 class="mb-3 fw-semibold">Available PNR’s</h5>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-striped table-scroll">
                <colgroup>
                    <col style="width: 130px">   <!-- PNR -->
                    <col style="width: 50px">   <!-- Airline -->
                    <col style="width: 240px">   <!-- Baggage -->
                    <col style="width: 70px">    <!-- From -->
                    <col style="width: 70px">    <!-- To -->
                    <col style="width: 190px">   <!-- Departure -->
                    <col style="width: 190px">   <!-- Arrival -->
                    <!-- <col style="width: 90px">    Price -->
                    <!-- <col style="width: 120px">   Seats -->
                    <col style="width: 170px">    <!-- Action -->
                </colgroup>
                <thead class="table-light">
                    <tr>
                        <th><i class="fa fa-ticket-perforated me-1"></i> PNR #</th>
                        <th><i class="fa fa-airplane me-1"></i> Airline</th>
                        <th><i class="fa fa-airplane me-1"></i> Baggage</th>
                        <th><i class="fa fa-airplane me-1"></i> From</th>
                        <th><i class="fa fa-airplane me-1"></i> To</th>
                        <th><i class="fa fa-airplane-engines me-1"></i> Dept Date/Time</th>
                        <th><i class="fa fa-airplane-fill me-1"></i> Arrival Date/Time</th>
                        <!-- <th><i class="fa fa-airplane-fill me-1"></i> Price</th> -->
                        <!-- <th><i class="fa fa-person-wheelchair me-1"></i> Seats</th> -->
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pnrs as $pnr)
                        @if($pnr->pnr_type == 'return')
                            <tr>
                                <td>
                                    {{ $pnr->pnr_no }}<hr>
                                    {{ $pnr->pnr_no }}
                                </td>
                                <td>
                                    <strong>{{ $pnr->airline->code }}</strong><hr>
                                    <strong>{{ $pnr->airline->code }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $pnr->baggages->pluck('name')->implode(', ') }}</strong><hr>
                                    <strong>{{ $pnr->baggages->pluck('name')->implode(', ') }}</strong>
                                </td>
                                <td>
                                    {{ $pnr->departure->code }}<hr>
                                    {{ $pnr->arrival->code }}
                                </td>
                                <td>
                                    {{ $pnr->arrival->code }}<hr>
                                    {{ $pnr->departure->code }}
                                </td>
                                <td>
                                    {{ $pnr->departure_date_time }}<hr>
                                    {{ $pnr->arrival_date_time }}
                                </td>
                                <td>
                                    {{ $pnr->arrival_date_time }}<hr>
                                    {{ $pnr->departure_date_time }}
                                </td>
                                <!-- <td></td> -->
                                <!-- <td></td> -->
                                <td>
                                    <p>{{ $pnr->seat_available }} seat available</p>
                                    <button class="btn btn-primary" onclick="selectPNRBooking({{ $pnr->id }})">
                                        {{ $pnr->price }} EUR
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    {{ $pnr->pnr_no }}
                                </td>
                                <td>
                                    <strong>{{ $pnr->airline->code }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $pnr->baggages->pluck('name')->implode(', ') }}</strong>
                                </td>
                                <td>
                                    {{ $pnr->departure->code }}
                                </td>
                                <td>
                                    {{ $pnr->arrival->code }}
                                </td>
                                <td>
                                    {{ $pnr->departure_date_time }}
                                </td>
                                <td>
                                    {{ $pnr->arrival_date_time }}
                                </td>
                                <!-- <td>{{ $pnr->price }}</td> -->
                                <!-- <td>{{ $pnr->seat_available }}</td> -->
                                <td>
                                    <p>{{ $pnr->seat_available }} seat available</p>
                                    <button class="btn btn-primary" onclick="selectPNRBooking({{ $pnr->id }})">
                                        {{ $pnr->price }} EUR
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        {{ $pnrs->links() }}
        <!-- modal -->
        <div class="modal fade" id="searchPnrSeatModal" data-bs-backdrop="static" 
            data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">Select Number Of Seat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <form id="pnr-select-seat" method="POST" action="{{ route('admin.booking.pnr.info') }}">
                        @csrf
                        <div class="modal-body pt-0">

                            <p class="text-muted mb-4">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                <input type="hidden" readonly id="pnr_id" name="pnr_id">

                            </p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Seat *</label>
                                    <input type="number" class="form-control"
                                        id="seat" name="seat"
                                        placeholder="Enter seat">
                                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                        </div>
                    <!-- Footer -->
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>
                         <button type="submit" class="btn btn-dark">
                            Confirm Seat
                        </button>
                    </div>
                    </form>


                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
</div>


