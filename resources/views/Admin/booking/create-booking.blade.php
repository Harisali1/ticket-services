@extends('Admin.layouts.main')

@section('styles')
  <style>
    /* ================= SEAT LEGEND ================= */
    .seat-legend {
        display: flex;
        gap: 24px;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .legend-box {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        display: inline-flex;
        margin-right: 6px;
    }

    /* ================= SEATS ================= */
    .seat {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .seat i { font-size: 18px; }

    .seat.economy {
        border-color: #7db6ff;
        background: #eef6ff;
    }

    .seat.business {
        border-color: #c7a0ff;
        background: #f6efff;
    }

    .seat.selected {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
    }

    .seat.occupied {
        background: #d1d5db;
        border-color: #9ca3af;
        cursor: not-allowed;
    }

    .seat-row {
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
    }

    .aisle { width: 24px; }

    .fare-card {
        display: block;
        cursor: pointer;
    }

    .fare-card input {
        display: none;
    }

    .fare-box {
        border: 1px solid #dcdcdc;
        border-radius: 4px;
        padding: 12px;
        text-align: center;
        height: 100%;
        transition: all 0.2s ease;
        background: #fff;
    }

    .fare-title {
        font-size: 13px;
        color: #333;
        margin-bottom: 6px;
    }

    .fare-price {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .fare-detail {
        display: block;
        margin-top: 6px;
        font-size: 11px;
        color: #666;
    }

    /* Active State */
    .fare-card input:checked + .fare-box {
        background: #0078c8;
        border-color: #0078c8;
        color: #fff;
    }

    .fare-card input:checked + .fare-box .fare-title,
    .fare-card input:checked + .fare-box .fare-price,
    .fare-card input:checked + .fare-box .fare-detail {
        color: #fff;
    }
    .pnr-detail{
        background: #0061A5;
        padding: 10px;
        color: white;
        font-size: 17px;
        font-family: inherit;
    }
  </style>
@endsection

@section('content')

<div class="container px-4 py-3">
  <!-- ================= HEADER ================= -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left fs-5"></i>
        <h4 class="mb-0 fw-semibold">Create Booking</h4>
    </div>

    <h5 class="fw-semibold">
        Total Tickets Price :
        <span id="totalPrice">PKR {{ $data['totalAmount'] }}/-</span>
    </h5>
  </div>

  <hr>

  <form id="bookingForm" method="POST" action="{{ route('admin.booking.submit') }}">
    <!-- PNR Details -->
     @csrf()
    <h3 class="fw-semibold mb-3 pnr-detail">PNR Details:</h3>

    <div class="mb-4">
        <h6 class="text-primary fw-bold mb-3">OUTBOUND</h6>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Airline -->
                    <div class="col-md-1 text-center">
                       <img src="{{ $pnrBookings->airline->logo 
                                        ? asset('storage/'.$pnrBookings->airline->logo) 
                                        : asset('images/logo-placeholder.png') }}"
                                        alt="logo"
                                        class="rounded-circle border"
                                        style="width:25px;height:25px;object-fit:contain;">
                    </div>

                    <!-- From / To -->
                    <div class="col-md-3">
                        <p class="mb-1">
                            <small class="text-muted">From:</small><br>
                            <strong>{{ $pnrBookings->departure_date_time }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">To:</small><br>
                            <strong>{{ $pnrBookings->arrival_date_time }}</strong>
                        </p>
                    </div>

                    <!-- Airports -->
                    <div class="col-md-1 text-center fw-bold fs-5">
                        {{ $pnrBookings->departure->code}}
                    </div>
                     <div class="col-md-1 text-center fw-bold fs-5">
                        {{ $pnrBookings->arrival->code}}
                    </div>

                    <div class="col-md-2 text-center">
                        <small class="text-muted">Duration</small><br>
                        <strong>{{ $pnrBookings->duration }}</strong>
                    </div>

                   

                    <!-- Aircraft -->
                    <div class="col-md-2 text-center">
                        <small class="text-muted">Airplane</small><br>
                        <strong>{{ $pnrBookings->air_craft }}</strong>
                    </div>

                    <!-- Flight Info -->
                    <div class="col-md-2">
                        <p class="mb-1">
                            <small class="text-muted">Num.:</small>
                            <strong>{{ $pnrBookings->flight_no }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">Class:</small>
                            <strong>{{ $pnrBookings->class }}</strong>
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @if($pnrBookings->pnr_type == 'return')
        <!-- INBOUND -->
        <div>
            <h6 class="text-primary fw-bold mb-3">INBOUND</h6>

            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="row align-items-center">

                        <!-- Airline -->
                        <div class="col-md-1 text-center">
                            <img src="{{ $pnrBookings->airline->logo 
                                            ? asset('storage/'.$pnrBookings->airline->logo) 
                                            : asset('images/logo-placeholder.png') }}"
                                            alt="logo"
                                            class="rounded-circle border"
                                            style="width:25px;height:25px;object-fit:contain;">
                        </div>

                        <!-- From / To -->
                        <div class="col-md-3">
                            <p class="mb-1">
                                <small class="text-muted">From:</small><br>
                                <strong>{{ $pnrBookings->return_departure_date_time }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">To:</small><br>
                                <strong>{{ $pnrBookings->return_arrival_date_time }}</strong>
                            </p>
                        </div>

                        <!-- Airports -->
                        <div class="col-md-1 text-center fw-bold fs-5">
                            {{ $pnrBookings->return_departure->code }}
                        </div>
                        <div class="col-md-1 text-center fw-bold fs-5">
                            {{ $pnrBookings->return_arrival->code }}
                        </div>

                        <div class="col-md-2 text-center">
                            <small class="text-muted">Duration</small><br>
                            <strong>{{ $pnrBookings->return_duration }}</strong>
                        </div>

                        

                        <!-- Aircraft -->
                        <div class="col-md-2 text-center">
                            <small class="text-muted">Airplane</small><br>
                            <strong>{{ $pnrBookings->air_craft }}</strong>
                        </div>

                        <!-- Flight Info -->
                        <div class="col-md-2">
                            <p class="mb-1">
                                <small class="text-muted">Num.:</small>
                                <strong>{{ $pnrBookings->flight_no }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">Class:</small>
                                <strong>{{ $pnrBookings->class }}</strong>
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endif

    <input type="hidden" id="pnr_id" name="pnr_id" value="{{ $data['pnr_id'] }}">
    <input type="hidden" id="booking_seats" name="booking_seats" value="{{ $seatSum }}">
    <input type="hidden" id="total_fare" name="total_fare" value="{{ $data['totalBaseFareAmount'] }}">
    <input type="hidden" id="total_tax" name="total_tax" value="{{ $data['totalTax'] }}">
    <input type="hidden" id="total_amount" name="total_amount" value="{{ $data['totalAmount'] }}">

    <h3 class="fw-semibold mb-3 pnr-detail">Agency Details:</h3>

    <div class="row">
        <div class="col-md-4">
            <label class="form-label small">Agency Name</label>
            <input type="text" class="form-control" id="agency_name" name="agency_name" readonly value="{{ $pnrBookings->user->name }}">
        </div>
        
        <div class="col-md-4">
            <label class="form-label small">Email</label>
            <input type="text" class="form-control" id="agency_email" name="agency_email" readonly value="{{ $pnrBookings->user->email }}">
        </div>

        <div class="col-md-4">
            <label class="form-label small">Phone No</label>
            <input type="text" class="form-control" id="phone_no" name="phone_no" readonly value="{{ $pnrBookings->user->phone_no }}">
        </div>
    </div>

    <hr>

    <h3 class="fw-semibold mb-3 pnr-detail">Fare Details:</h3>

    <table class="table table-bordered align-middle" id="mytable">
        <thead class="table-light">
            <tr>
                <th>Passenger Type</th>
                <th>Seat</th>
                <th>Base Fare</th>
                @if($pnrBookings->pnr_type == 'return' || $pnrBookings->pnr_type == 'open_jaw')
                    <th>Return Base Fare</th>
                @endif
                <th>Total Fare Amount</th>
                <th>Tax</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $fareAmount = 0;
                $taxAmount = 0;
            @endphp
            @foreach($fareDetails as $index => $fare)
                @php 
                    $fareAmount += $fare['total_fare_amount'];
                    $taxAmount += $fare['tax'];
                @endphp
                <tr>
                    <td>
                        {{ $fare['title'] }}
                    </td>
                    <td>
                        {{ $fare['seat'] }}
                    </td>
                    <td>
                        {{ $fare['base_fare'] }}
                    </td>
                    @if($pnrBookings->pnr_type == 'return' || $pnrBookings->pnr_type == 'open_jaw')
                        <td>
                            {{ $fare['return_base_fare'] }}
                        </td>
                    @endif
                    <td>
                        {{ $fare['total_fare_amount'] }}
                    </td>
                    <td>
                        {{ $fare['tax'] }}
                    </td>
                    <td>
                        {{ $fare['row_total'] }}
                    </td>
                </tr>
                <input type="hidden" name="fareDetails[{{ $index }}][type_id]" value="{{ $fare['type_id'] }}">
                <input type="hidden" name="fareDetails[{{ $index }}][seat]" value="{{ $fare['seat'] }}">
            @endforeach
        </tbody>
    </table>

    <hr>

    

    <hr>

    <h3 class="fw-semibold mb-3 pnr-detail">Passenger Details:</h3>

    <div id="step-1">
      @foreach(range(1, $seatSum) as $key => $i )
        <div class="card card-body mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0">Passenger {{ $key+1; }}: Basic Details</h6>
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Name Prefix</label>
                    <select class="form-select" id="customer_prefix[]" name="customer_prefix[]">
                        <option value="">Select</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                    </select>
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                <label class="form-label small">Name*</label>
                <input type="text" class="form-control" id="customer_name[]" name="customer_name[]" required>
                <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Surname*</label>
                    <input type="text" class="form-control" id="customer_surname[]" name="customer_surname[]">
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Gender*</label>
                    <select class="form-select" id="customer_gender[]" name="customer_gender[]">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Email*</label>
                    <input type="email" class="form-control" id="customer_email[]" name="customer_email[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Phone*</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer_phone[]" name="customer_phone[]" required>
                        <div class="invalid-feedback">This field is required</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">D.O.B*</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer_dob[]" name="customer_dob[]" required>
                        <div class="invalid-feedback">This field is required</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Country</label>
                    <input type="text" class="form-control" id="customer_country[]" name="customer_country[]">
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Address</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer_address[]" name="customer_address[]">
                        <div class="invalid-feedback">This field is required</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">City</label>
                    <input type="text" class="form-control" id="customer_city[]" name="customer_city[]">
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Postal Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer_postal_code[]" name="customer_postal_code[]">
                        <div class="invalid-feedback">This field is required</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h6 class="fw-semibold mb-0">Document Details</h6>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Passport Country</label>
                    <input type="text" class="form-control" id="customer_passport_county[]" name="customer_passport_county[]">
                    <div class="invalid-feedback">This field is required</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Passport Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer_passport_number[]" name="customer_passport_number[]" required>
                        <div class="invalid-feedback">This field is required</div>
                    </div>
                </div>

                <!-- <div class="col-md-3">
                    <label class="form-label small">Residence Country</label>
                    <select class="form-select" id="customer_residence_country[]" name="customer_residence_country[]" required>
                        <option value="">Select</option>
                        <option value="pak">Pakistan</option>
                        <option value="sau">Saudi Arabia</option>
                    </select>
                    <div class="invalid-feedback">This field is required</div>
                </div> -->

                <div class="col-md-3">
                    <label class="form-label small">Nationality</label>
                    <select class="form-select" id="customer_nationality[]" name="customer_nationality[]" required>
                        <option value="">Select</option>
                        <option value="pak">Pakistan</option>
                        <option value="sau">Saudi Arabia</option>
                    </select>
                    <div class="invalid-feedback">This field is required</div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small">Expiry Date</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="customer_expiry_date[]" name="customer_expiry_date[]" required>
                        <div class="invalid-feedback">This field is required</div>
                    </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>

    <hr>
    <h3 class="fw-semibold mb-3 pnr-detail">Special Request:</h3>

    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label small">Meal</label>
            <select class="form-select" id="meal" name="meal" required>
                <option value="">Select</option>
                <option value="Hindu Meal">Hindu Meal</option>
                <option value="Sea Food Meal">Sea Food Meal</option>
                <option value="Kosher Meal">Kosher Meal</option>
                <option value="Vegetarian Oriental Meal">Vegetarian Oriental Meal</option>
                <option value="Vegetarian Vegan Meal">Vegetarian Vegan Meal</option>
                <option value="Low Salt Meal">Low Salt Meal</option>
                <option value="Low Calorie Meal">Low Calorie Meal</option>
                <option value="Bland Meal">Bland Meal</option>
                <option value="Vegetarian Jain Meal">Vegetarian Jain Meal</option>
                <option value="Diabetic Meal">Diabetic Meal</option>
                <option value="Vegetarian Hindu Meal">Vegetarian Hindu Meal</option>
                <option value="Special Meal">Special Meal</option>
                <option value="Gluten Intollerant Meal">Gluten Intollerant Meal</option>
                <option value="Low Fat Meal">Low Fat Meal</option>
                <option value="Baby Meal">Baby Meal</option>
                <option value="Vegetarian Raw Meal">Vegetarian Raw Meal</option>
                <option value="Fruit Platter Meal">Fruit Platter Meal</option>
                <option value="Child Meal">Child Meal</option>
                <option value="Moslem Meal">Moslem Meal</option>
                <option value="Low Lactose Meal">Low Lactose Meal</option>
                <option value="Vegetarian Lacto-ovo Meal">Vegetarian Lacto-ovo Meal</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small">Wheel Chair</label>
            <select class="form-select" id="wheel_chair" name="wheel_chair" required>
                <option value="">Select</option>
                <option value="WHEELCHAIR (CAN CLIMB STAIRS)">WHEELCHAIR (CAN CLIMB STAIRS)</option>
                <option value="WHEELCHAIR (CAN NOT CLIMB STAIRS)">WHEELCHAIR (CAN NOT CLIMB STAIRS)</option>
                <option value="WHEELCHAIR (ALL THE WAY TO SEAT)">WHEELCHAIR (ALL THE WAY TO SEAT)</option>
            </select>
        </div>
    </div>
    <hr>
    <h3 class="fw-semibold mb-3 pnr-detail mt-2">Reservation Recap:</h3>
    <div class="container mt-4">
        <div class="row justify-content-end">
            <div class="col-md-4">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Fare Amount</span>
                    <span class="fw-bold text-success">{{ $fareAmount }}.00 EUR</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Tax</span>
                    <span class="fw-bold text-success">{{ $taxAmount }}.00 EUR</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">
                        Administrative Fee
                        <!-- <button class="btn btn-sm btn-info ms-2">
                            <i class="bi bi-pencil-square text-white"></i>
                        </button> -->
                    </span>
                    <span class="fw-bold text-success">0.00 EUR</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Total Amount</span>
                    <span class="fw-bold fs-4 text-success">{{ $data['totalAmount'] }}.00 EUR</span>
                </div>

            </div>
        </div>
    </div>


    <!-- ================= BUTTONS ================= -->
    <div class="d-flex justify-content-end mt-4">
        <button type="button" onclick="validatePassengerDetails()" class="btn btn-success">
            Submit
        </button>
    </div>

  </form>
</div>

@endsection

@section('scripts')
<script>
    

    function validatePassengerDetails() {
        const step1 = document.getElementById('step-1');
        let isValid = true;

        const inputs = step1.querySelectorAll('[required]');

        inputs.forEach(input => {
            if (!input.value || input.value.trim() === '') {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            alert('Please fill all required passenger details before proceeding.');
            return false;
        }

        Swal.fire({
            title: "Processing...",
            didOpen: () => Swal.showLoading()
        });

        document.getElementById('bookingForm').submit();
    }

    
</script>

@endsection
