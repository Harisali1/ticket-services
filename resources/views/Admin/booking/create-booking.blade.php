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
        <span>PKR {{ $data['total_seats_price'] }}/-</span>
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
            <input type="text" class="form-control" disabled value="PKR {{ $data['total_seats_price'] }}/-">
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

<form id="bookingForm">

<!-- ================= STEP 1 ================= -->
<div id="step-1">

@foreach(range(1, $data['seat']) as $key => $i )
          <div class="card card-body mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0">Passenger {{ $key+1; }}: Basic Details</h6>
                <span class="fw-semibold">Ticket Price : PKR {{ $data['total_seats_price']/$data['seat'] }}/-</span>
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

              <div class="col-md-3">
                  <label class="form-label small">Email*</label>
                  <input type="email" class="form-control">
              </div>

              <div class="col-md-3">
                  <label class="form-label small">Phone*</label>
                  <div class="input-group">
                      <select class="form-select" style="max-width:90px">
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

              <div class="col-md-3">
                  <label class="form-label small">Country</label>
                  <select class="form-select">
                      <option>Select</option>
                      <option>Pakistan</option>
                      <option>Saudi Arabia</option>
                  </select>
              </div>

              <div class="col-md-6">
                  <label class="form-label small">Address</label>
                  <div class="input-group">
                      <input type="text" class="form-control">
                  </div>
              </div>

              <div class="col-md-3">
                  <label class="form-label small">City</label>
                  <select class="form-select">
                      <option>Select</option>
                      <option>Pakistan</option>
                      <option>Saudi Arabia</option>
                  </select>
              </div>

              <div class="col-md-3">
                  <label class="form-label small">Postal Code</label>
                  <div class="input-group">
                      <input type="text" class="form-control">
                  </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h6 class="fw-semibold mb-0">Document Details</h6>
              </div>

              <div class="col-md-3">
                  <label class="form-label small">Passport Type</label>
                  <select class="form-select">
                      <option>Select</option>
                      <option>Pakistan</option>
                      <option>Saudi Arabia</option>
                  </select>
              </div>

              <div class="col-md-3">
                  <label class="form-label small">Passport Number</label>
                  <div class="input-group">
                      <input type="text" class="form-control">
                  </div>
              </div>

              <div class="col-md-3">
                  <label class="form-label small">Residence Country</label>
                  <select class="form-select">
                      <option>Select</option>
                      <option>Pakistan</option>
                      <option>Saudi Arabia</option>
                  </select>
              </div>

              <div class="col-md-3">
                  <label class="form-label small">Nationality</label>
                  <select class="form-select">
                      <option>Select</option>
                      <option>Pakistan</option>
                      <option>Saudi Arabia</option>
                  </select>
              </div>
              
              <div class="col-md-3">
                  <label class="form-label small">Expiry Date</label>
                  <div class="input-group">
                      <input type="date" class="form-control">
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
let currentStep = 1;

const step1 = document.getElementById('step-1');
const step2 = document.getElementById('step-2');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

const i1 = document.getElementById('step-indicator-1');
const i2 = document.getElementById('step-indicator-2');

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

nextBtn.onclick = () => {
    if (currentStep === 1) {
        currentStep = 2;
        showStep(2);
    } else {
        document.getElementById('bookingForm').submit();
    }
};

prevBtn.onclick = () => {
    currentStep = 1;
    showStep(1);
};

document.querySelectorAll('.seat').forEach(seat => {
    seat.onclick = function() {
        if (this.classList.contains('occupied')) return;
        document.querySelectorAll('.seat.selected').forEach(s => s.classList.remove('selected'));
        this.classList.add('selected');
    }
});
</script>
@endsection
