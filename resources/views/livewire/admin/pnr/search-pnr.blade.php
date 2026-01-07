<div class="container my-4">
    <h5 class="mb-3 fw-semibold">Available PNR’s</h5>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-striped table-scroll">
                <colgroup>
                    <col style="width: 80px">
                    <col style="width: 50px">
                    <col style="width: 80px">
                    <col style="width: 50px">
                    <col style="width: 50px">
                    <col style="width: 80px">
                    <col style="width: 80px">
                    <col style="width: 190px">
                    <col style="width: 190px">
                    <col style="width: 100px">
                    <col style="width: 220px">
                </colgroup>
                <thead class="table-light">
                    <tr>
                        <th><i class="fa fa-ticket-perforated me-1"></i>Vector</th>
                        <th><i class="fa fa-ticket-perforated me-1"></i>Flight</th>
                        <th><i class="fa fa-ticket-perforated me-1"></i>Air Craft</th>
                        <th><i class="fa fa-airplane me-1"></i> Class</th>
                        <th><i class="fa fa-airplane me-1"></i> Fare</th>
                        <th><i class="fa fa-airplane me-1"></i> From</th>
                        <th><i class="fa fa-airplane me-1"></i> To</th>
                        <th><i class="fa fa-airplane-engines me-1"></i> Departure </th>
                        <th><i class="fa fa-airplane-fill me-1"></i> Arrival </th>
                        <th><i class="fa fa-airplane-fill me-1"></i> Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pnrs as $pnr)
                        @if($pnr->pnr_type == 'return')
                            <tr>
                                <td>
                                    <img src="{{ $pnr->airline->logo 
                                        ? asset('storage/'.$pnr->airline->logo) 
                                        : asset('images/logo-placeholder.png') }}"
                                        alt="logo"
                                        class="rounded-circle border"
                                        style="width:25px;height:25px;object-fit:contain;"><hr>
                                    <img src="{{ $pnr->airline->logo 
                                        ? asset('storage/'.$pnr->airline->logo) 
                                        : asset('images/logo-placeholder.png') }}"
                                        alt="logo"
                                        class="rounded-circle border"
                                        style="width:25px;height:25px;object-fit:contain;">
                                </td>
                                <td>
                                    {{ $pnr->flight_no }}<hr>
                                    {{ $pnr->flight_no }}
                                </td>
                                <td>
                                    {{ $pnr->air_craft }}<hr>
                                    {{ $pnr->air_craft }}
                                </td>
                                <td>
                                    {{ $pnr->class }}<hr>
                                    {{ $pnr->class }}
                                </td>
                                <td>
                                    {{ $pnr->baggage }}<hr>
                                    {{ $pnr->baggage }}
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
                                    {{ $pnr->return_departure_date_time }}
                                </td>
                                <td>
                                    {{ $pnr->arrival_date_time }}<hr>
                                    {{ $pnr->return_arrival_date_time }}
                                </td>
                                <td>
                                    {{ $pnr->duration }}<hr>
                                    {{ $pnr->return_duration }}
                                </td>
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
                                    <img src="{{ $pnr->airline->logo 
                                        ? asset('storage/'.$pnr->airline->logo) 
                                        : asset('images/logo-placeholder.png') }}"
                                        alt="logo"
                                        class="rounded-circle border"
                                        style="width:25px;height:25px;object-fit:contain;">
                                </td>
                                <td>
                                    {{ $pnr->flight_no }}
                                </td>
                                <td>
                                    {{ $pnr->air_craft }}
                                </td>
                                <td>
                                    {{ $pnr->class }}
                                </td>
                                <td>
                                    {{ $pnr->baggage }}
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
                                <td>{{ $pnr->duration }}</td>
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
                                <div class="col-md-3">
                                    <select class="form-select select2" id="return_day_plus" name="return_day_plus">
                                        @foreach($passengerTypes as $type)                                  
                                            <option value="1">{{ $type->title .'('. $type->code .')' }}</option>
                                        @endforeach
                                    </select>
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


