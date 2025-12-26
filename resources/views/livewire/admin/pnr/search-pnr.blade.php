<div class="container my-4">
    <h5 class="mb-3 fw-semibold">Available PNR’s</h5>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" class="form-check-input"></th>
                        <th>
                            <i class="bi bi-ticket-perforated me-1"></i> PNR #
                        </th>
                        <th>
                            <i class="bi bi-airplane me-1"></i> Airline
                        </th>
                        <th>
                            <i class="bi bi-airplane-engines me-1"></i> Departure Date/Time
                        </th>
                        <th>
                            <i class="bi bi-airplane-fill me-1"></i> Arrival Date/Time
                        </th>
                        <th>
                            <i class="bi bi-person-wheelchair me-1"></i> Available Seats
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pnrs as $pnr)
                    <tr>
                        <td><input type="checkbox" class="form-check-input"></td>
                        <td>{{ $pnr->pnr_no }}</td>
                        <td><strong>AirSial</strong></td>
                        <td>11/30/2025 at 11:00 am GMT</td>
                        <td>11/30/2025 at 11:00 am GMT</td>
                        <td>20</td>
                        <td>
                            <li>
                                <button class="dropdown-item" onclick="selectPNRBooking({{ $pnr->id }})">
                                    Select
                                </button>
                            </li>
                        </td>
                    </tr>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeAndRefresh()"></button>
                    </div>

                    <!-- Body -->
                    <form id="pnr-select-seat">
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
                        <button class="btn btn-dark">
                            Save
                        </button>
                    </div>
                    </form>


                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
</div>


