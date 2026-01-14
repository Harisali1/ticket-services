<div class="container my-4">
    <h5 class="mb-3 fw-semibold">Available PNR’s</h5>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-scroll">
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
                        @if($pnr->seat_is_sale != 0)
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
                                        <p>{{ $pnr->seat_is_sale }} seat available</p>
                                        <button class="btn btn-primary" onclick="selectPNRBooking({{ $pnr->id }})">
                                            {{ $pnr->total + $pnr->return_total }} EUR
                                        </button>
                                    </td>
                                </tr>
                            @else
                                @if($pnr->middle_arrival_id != null && $pnr->rest_time)
                                <tr>
                                    <td colspan="11" class="p-2 shoadow-master">
                                        <div class="pnr-shadow-box">
                                            <table class="w-100">
                                                <tr>
                                                    <td>
                                                        <img src="{{ $pnr->airline->logo 
                                                            ? asset('storage/'.$pnr->airline->logo) 
                                                            : asset('images/logo-placeholder.png') }}"
                                                            class="rounded-circle border"
                                                            style="width:25px;height:25px;object-fit:contain;">
                                                        <hr>
                                                        <img src="{{ $pnr->airline->logo 
                                                            ? asset('storage/'.$pnr->airline->logo) 
                                                            : asset('images/logo-placeholder.png') }}"
                                                            class="rounded-circle border"
                                                            style="width:25px;height:25px;object-fit:contain;">
                                                    </td>

                                                    <td>{{ $pnr->flight_no }}<hr>{{ $pnr->flight_no }}</td>
                                                    <td>{{ $pnr->air_craft }}<hr>{{ $pnr->air_craft }}</td>
                                                    <td>{{ $pnr->class }}<hr>{{ $pnr->class }}</td>
                                                    <td>{{ $pnr->baggage }}<hr>{{ $pnr->baggage }}</td>
                                                    <td>{{ $pnr->departure->code }}<hr>{{ $pnr->arrival->code }}</td>
                                                    <td>{{ $pnr->arrival->code }}<hr>{{ $pnr->departure->code }}</td>
                                                    <td>{{ $pnr->departure_date_time }}<hr>{{ $pnr->return_departure_date_time }}</td>
                                                    <td>{{ $pnr->arrival_date_time }}<hr>{{ $pnr->return_arrival_date_time }}</td>
                                                    <td>{{ $pnr->duration }}<hr>{{ $pnr->return_duration }}</td>

                                                    <td>
                                                        <p class="mb-1">{{ $pnr->seat_is_sale }} seat available</p>
                                                        <button class="btn btn-primary btn-sm">
                                                            {{ $pnr->total + $pnr->return_total }} EUR
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                @else
                                <tr>
                                    <td colspan="11" class="p-2 shoadow-master">
                                        <div class="pnr-shadow-box">
                                            <table class="w-100">
                                                <tr>
                                                    <td>
                                                        <img src="{{ $pnr->airline->logo 
                                                            ? asset('storage/'.$pnr->airline->logo) 
                                                            : asset('images/logo-placeholder.png') }}"
                                                            class="rounded-circle border"
                                                            style="width:25px;height:25px;object-fit:contain;">
                                                    </td>

                                                    <td>{{ $pnr->flight_no }}</td>
                                                    <td>{{ $pnr->air_craft }}</td>
                                                    <td>{{ $pnr->class }}</td>
                                                    <td>{{ $pnr->baggage }}</td>
                                                    <td>{{ $pnr->arrival->code }}</td>
                                                    <td>{{ $pnr->departure->code }}</td>
                                                    <td>{{ $pnr->return_departure_date_time }}</td>
                                                    <td>{{ $pnr->return_arrival_date_time }}</td>
                                                    <td>{{ $pnr->return_duration }}</td>

                                                    <td>
                                                        <p class="mb-1">{{ $pnr->seat_is_sale }} seat available</p>
                                                        <button class="btn btn-primary btn-sm">
                                                            {{ $pnr->total + $pnr->return_total }} EUR
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endif
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
                            <div class="table-responsive">
                                

                                <table class="table table-bordered align-middle" id="mytable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Seat *</th>
                                            <th>Passenger Type</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    name="seat[]"
                                                    id="seat"
                                                    min="0"
                                                    placeholder="Enter seat" 
                                                    required
                                                    oninput="this.value = this.value.replace(/[^0-9]/g,'');
                                                    if (this.value !== '' && (this.value < 0 )) this.value = '';">
                                            </td>
                                            <td>
                                                <select class="form-select select2 passenger-type"
                                                        name="passenger_type[]" required>
                                                    @foreach($passengerTypes as $type)
                                                        <option value="{{ $type->id }}">
                                                            {{ $type->title . ' (' . $type->code . ')' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-success btn-sm addRow" onclick="addRow()">
                                                    +
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

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
        <script>
            const passengerOptions = `
                    @foreach($passengerTypes as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->title }} ({{ $type->code }})
                        </option>
                    @endforeach
                `;

            function addRow(){
                let newRow = `
                            <tr>
                                <td>
                                    <input type="number"
                                        class="form-control"
                                        name="seat[]"
                                        min="0"
                                        placeholder="Enter seat" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g,'');
                                        if (this.value !== '' && (this.value < 0 )) this.value = '';">
                                </td>
                                <td>
                                    <select class="form-select select2 passenger-type"
                                            name="passenger_type[]" required>
                                        ${passengerOptions}
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-danger btn-sm removeRow">−</button>
                                </td>
                            </tr>
                            `;

                // var str ="<tr><td>data 1</td><td>data 2</td><td>data 3</td></tr>";
                $('#mytable tbody').append(newRow);
            }
        </script>
    </div>
</div>


