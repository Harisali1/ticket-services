@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')

<div class="container px-4 py-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left fs-5"></i>
            <h4 class="mb-0 fw-semibold">Create Booking</h4>
        </div>

        <h5 class="mb-0 fw-semibold">
            Total Tickets Price :
            <span class="text-dark">PKR 40,000/-</span>
        </h5>
    </div>

    <hr>

    <!-- PNR Details -->
    <h6 class="fw-semibold mb-3">PNR Details:</h6>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label small">Departure</label>
            <input type="text" class="form-control" disabled id="departure_id" name="departure_id" value="{{ $pnrBookings->departure->name }}">
        </div>

        <div class="col-md-3">
            <label class="form-label small">Arrival</label>
            <input type="text" class="form-control" disabled id="arrival_id" name="arrival_id" value="{{ $pnrBookings->arrival->name }}">
        </div>

        <div class="col-md-3">
            <label class="form-label small">Departure Date/Time</label>
            <div class="input-group">
                <input type="text" class="form-control" disabled id="departure_date" name="departure_date" value="{{ $pnrBookings->departure_date }}">
                
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label small">Arrival Date/Time</label>
            <div class="input-group">
                <input type="text" class="form-control" disabled id="arrival_date" name="arrival_date" value="{{ $pnrBookings->departure_date }}">    
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label small">Selected Seats</label>
            <input type="text" class="form-control" disabled value="{{ $data['seat'] }}">
        </div>

        <div class="col-md-3">
            <label class="form-label small">Total Tickets Price</label>
            <input type="text" class="form-control" disabled value="PKR 40,000/-">
        </div>
    </div>

    <hr>

    <!-- Passenger Tabs Header -->
    <div class="row mb-3">
        <div class="col-md-8">
            <h6 class="fw-semibold border-bottom pb-2">Passenger Details</h6>
        </div>
        <div class="col-md-4 text-end">
            <h6 class="fw-semibold border-bottom pb-2">Passenger Seat</h6>
        </div>
    </div>

    <!-- Passenger Card -->
    <div class="card mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0">Passenger 1: Basic Details</h6>
                <span class="fw-semibold">
                    Ticket Price : PKR 20,000/-
                </span>
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Name Prefix</label>
                    <select class="form-select">
                        <option>Select</option>
                        <option>Mr</option>
                        <option>Mrs</option>
                        <option>Ms</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Name*</label>
                    <input type="text" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Surname*</label>
                    <input type="text" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Gender*</label>
                    <select class="form-select">
                        <option>Select</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Email*</label>
                    <input type="email" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Phone*</label>
                    <div class="input-group">
                        <select class="form-select" style="max-width: 90px">
                            <option>+01</option>
                            <option>+92</option>
                        </select>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">D.O.B*</label>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-text">
                            <i class="bi bi-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Country</label>
                    <select class="form-select">
                        <option>Select</option>
                        <option>Pakistan</option>
                        <option>Saudi Arabia</option>
                    </select>
                </div>
            </div>

        </div>
    </div>

</div>


@endsection

@section('scripts')

@endsection




