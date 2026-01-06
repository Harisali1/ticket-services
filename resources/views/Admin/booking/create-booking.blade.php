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
        background: lightgray;
        border: solid 1px #878787;
        border-radius: 5px;
        padding: 5px;
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
        <span id="totalPrice">PKR {{ $pnrBookings->price }}/-</span>
    </h5>
  </div>

  <hr>

  <form id="bookingForm" method="POST" action="{{ route('admin.booking.submit') }}">
    <!-- PNR Details -->
     @csrf()
    <h3 class="fw-semibold mb-3 pnr-detail">PNR Details:</h3>

    <div class="mb-3">
        <h6 class="fw-bold mb-2">Select Baggage</h6>

        <div class="row g-3 fare-group">
            @foreach($pnrBookings->baggages as $baggage)
            <div class="col-md-3">
                <label class="fare-card">
                    <input type="radio" name="fare" class="fare-radio" value="{{ $baggage->price + $pnrBookings->price }}">
                    <div class="fare-box">
                        <div class="fare-title">{{ $baggage->name }}</div>
                        <div class="fare-price">{{ $baggage->price + $pnrBookings->price }}.00 EUR</div>
                    </div>
                </label>
            </div>
            @endforeach


        </div>
    </div>



    <input type="hidden" id="pnr_id" name="pnr_id" value="{{ $data['pnr_id'] }}">
    <div class="row g-3 mb-4">
      <div class="col-md-3">
          <label class="form-label small">Departure</label>
          <input type="text" class="form-control" readonly id="departure_id" name="departure_id" value="{{ $pnrBookings->departure->name }}">
      </div>

      <div class="col-md-3">
          <label class="form-label small">Arrival</label>
          <input type="text" class="form-control" readonly id="arrival_id" name="arrival_id" value="{{ $pnrBookings->arrival->name }}">
      </div>

      <div class="col-md-3">
          <label class="form-label small">Departure Date/Time</label>
          <div class="input-group">
              <input type="text" class="form-control" readonly id="departure_date" name="departure_date" value="{{ $pnrBookings->departure_date_time }}">
              
          </div>
      </div>

      <div class="col-md-3">
          <label class="form-label small">Arrival Date/Time</label>
          <div class="input-group">
              <input type="text" class="form-control" readonly id="arrival_date" name="arrival_date" value="{{ $pnrBookings->arrival_date_time }}">    
          </div>
      </div>

      <div class="col-md-3">
          <label class="form-label small">Selected Seats</label>
          <input type="text" class="form-control" id="seats" name="seats" readonly value="{{ $data['seat'] }}">
      </div>

      <div class="col-md-3">
          <label class="form-label small">Total Tickets Price</label>
          <input type="text" class="form-control" id="total_price" name="total_price" readonly value="{{ $pnrBookings->price }}">
      </div>
    </div>

    <h3 class="fw-semibold mb-3 pnr-detail">Agency Details:</h3>

    <div class="row">
        <div class="col-md-4">
            <label class="form-label small">Agency Name</label>
            <input type="text" class="form-control" id="agency_name" name="agency_name" readonly value="{{ $pnrBookings->user->name }}">
        </div>
        
        <div class="col-md-4">
            <label class="form-label small">Email</label>
            <input type="text" class="form-control" id="email" name="email" readonly value="{{ $pnrBookings->user->email }}">
        </div>

        <div class="col-md-4">
            <label class="form-label small">Phone No</label>
            <input type="text" class="form-control" id="phone_no" name="phone_no" readonly value="{{ $pnrBookings->user->phone_no }}">
        </div>
    </div>
    

    <hr>
    <!-- ================= STEP INDICATOR ================= -->
    <div class="d-flex justify-content-center mb-4">
        <div class="d-flex gap-5 fw-semibold">
            <span id="step-indicator-1" class="text-primary">① Passenger Details</span>
            <span id="step-indicator-2" class="text-muted">② Passenger Seat</span>
        </div>
    </div>

    <!-- ================= STEP 1 ================= -->
    <div id="step-1">
      @foreach(range(1, $data['seat']) as $key => $i )
        <div class="card card-body mt-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-semibold mb-0">Passenger {{ $key+1; }}: Basic Details</h6>
              <!-- <span class="fw-semibold">Ticket Price : PKR {{ $data['total_seats_price']/$data['seat'] }}/-</span> -->
          </div>

          <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label small">Name Prefix</label>
                <select class="form-select" id="prefix[]" name="prefix[]" required>
                    <option value="">Select</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
              <label class="form-label small">Name*</label>
              <input type="text" class="form-control" id="name[]" name="name[]" required>
              <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Surname*</label>
                <input type="text" class="form-control" id="surname[]" name="surname[]" required>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Gender*</label>
                <select class="form-select" id="gender[]" name="gender[]" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Email*</label>
                <input type="email" class="form-control" id="email[]" name="email[]" required>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Phone*</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="phone[]" name="phone[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">D.O.B*</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="dob[]" name="dob[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Country</label>
                <select class="form-select" id="country_id[]" name="country_id[]" required>
                    <option value="">Select</option>
                    <option value="pak">Pakistan</option>
                    <option value="sau">Saudi Arabia</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-6">
                <label class="form-label small">Address</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="address[]" name="address[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">City</label>
                <select class="form-select" id="city_id[]" name="city_id[]" required>
                    <option value="">Select</option>
                    <option value="pak">Pakistan</option>
                    <option value="sau">Saudi Arabia</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Postal Code</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="postal_code[]" name="postal_code[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
              <h6 class="fw-semibold mb-0">Document Details</h6>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Passport Type</label>
                <select class="form-select" id="passport_type[]" name="passport_type[]" required>
                    <option value="">Select</option>
                    <option value="pak">Pakistan</option>
                    <option value="sau">Saudi Arabia</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Passport Number</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="passport_number[]" name="passport_number[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Residence Country</label>
                <select class="form-select" id="residence_country[]" name="residence_country[]" required>
                    <option value="">Select</option>
                    <option value="pak">Pakistan</option>
                    <option value="sau">Saudi Arabia</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Nationality</label>
                <select class="form-select" id="nationality[]" name="nationality[]" required>
                    <option value="">Select</option>
                    <option value="pak">Pakistan</option>
                    <option value="sau">Saudi Arabia</option>
                </select>
                <div class="invalid-feedback">This field is required</div>
            </div>
            
            <div class="col-md-3">
                <label class="form-label small">Expiry Date</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="expiry_date[]" name="expiry_date[]" required>
                    <div class="invalid-feedback">This field is required</div>
                </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- ================= STEP 2 ================= -->
    <div id="step-2" class="d-none">

      <div class="seat-legend">
        <div><span class="legend-box border border-primary"></span> Economy</div>
        <div><span class="legend-box" style="border:2px solid #c7a0ff"></span> Business</div>
        <div><span class="legend-box bg-primary"></span> Selected</div>
        <div><span class="legend-box bg-secondary"></span> Occupied</div>
      </div>

      <div class="d-flex justify-content-center">
        <div>
          @for($r=1;$r<=6;$r++)
            <div class="seat-row">
                <div class="seat economy"><i class="bi bi-person"></i></div>
                <div class="seat economy"><i class="bi bi-person"></i></div>
                <div class="seat occupied"><i class="bi bi-person"></i></div>
                <div class="aisle"></div>
                <div class="seat economy"><i class="bi bi-person"></i></div>
                <div class="seat economy"><i class="bi bi-person"></i></div>
                <div class="seat economy"><i class="bi bi-person"></i></div>
            </div>
          @endfor
        </div>
      </div>

    </div>

    <!-- ================= BUTTONS ================= -->
    <div class="d-flex justify-content-between mt-4">
        <button type="button" id="prevBtn" class="btn btn-outline-secondary d-none">
            ← Previous
        </button>

        <button type="button" id="nextBtn" class="btn btn-primary">
            Next →
        </button>
    </div>

  </form>
</div>

@endsection

@section('scripts')
<script>

    document.querySelectorAll('.fare-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            const price = this.value;

            document.getElementById('totalPrice').innerHTML =
                `PKR ${price}/-`;
            document.getElementById('total_price').value = price;
        });
    });

    let currentStep = 1;
    const MAX_SEATS = {{ $data['seat'] }};

    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const i1 = document.getElementById('step-indicator-1');
    const i2 = document.getElementById('step-indicator-2');

    /* ================= VALIDATION ================= */
    function validateStep1() {
        let isValid = true;

        const inputs = step1.querySelectorAll('input[required], select[required], textarea[required]');

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return isValid;
    }

    /* ================= STEP CONTROL ================= */
    function showStep(step) {
        if (step === 1) {
            step1.classList.remove('d-none');
            step2.classList.add('d-none');
            prevBtn.classList.add('d-none');
            nextBtn.innerText = 'Next →';
            i1.classList.replace('text-muted','text-primary');
            i2.classList.replace('text-primary','text-muted');
        } else {
            step1.classList.add('d-none');
            step2.classList.remove('d-none');
            prevBtn.classList.remove('d-none');
            nextBtn.innerText = 'Confirm Booking';
            i1.classList.replace('text-primary','text-muted');
            i2.classList.replace('text-muted','text-primary');
        }
    }

    /* ================= BUTTON EVENTS ================= */
    nextBtn.onclick = () => {
        if (currentStep === 1) {
            if (!validateStep1()) {
                alert('Please fill all required passenger details before proceeding.');
                return;
            }
            currentStep = 2;
            showStep(2);
        } else {
        if (selectedSeats.length < MAX_SEATS) {
            alert(`Please select ${MAX_SEATS} seat(s) before confirming.`);
            return;
        }
        document.getElementById('bookingForm').submit();
        }
    };

    prevBtn.onclick = () => {
        currentStep = 1;
        showStep(1);
    };

/* ================= SEAT SELECTION ================= */

    let selectedSeats = [];
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function () {

            if (this.classList.contains('occupied')) return;

            // If already selected → unselect
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s !== this);
                return;
            }

            // Limit reached
            if (selectedSeats.length >= MAX_SEATS) {
                alert(`You can only select ${MAX_SEATS} seat(s).`);
                return;
            }

            // Select seat
            this.classList.add('selected');
            selectedSeats.push(this);
        });
    });

</script>

@endsection
