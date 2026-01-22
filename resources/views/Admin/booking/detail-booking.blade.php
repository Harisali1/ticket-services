@extends('Admin.layouts.main')

@section('styles')
  <style>
        .ticket-badge {
            background-color: #5cb85c;
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 4px;
        }
        .status-badge {
            background-color: #5cb85c;
            font-size: 13px;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .copy-icon {
            margin-left: 6px;
            font-size: 14px;
        }
    </style>

@endsection

@section('content')
<div class="container-fluid p-0" id="main-content">

    <!-- Top Bar -->
    <div class="bg-primary text-white px-4 py-3 d-flex justify-content-between align-items-center">
        <div>
            <small><a href="{{ route('admin.dashboard') }}">Home</a> / <a href="{{ route('admin.booking.index') }}">Booking List</a> / Booking Detail</small>
            <strong class="ms-2"></strong>
        </div>
        <div class="btn-group">
            @if($booking->status->label() === 'Created')
                <button class="btn btn-danger btn-sm" onclick="ticketedBooking({{ $booking->id }}, 'cancel', 'Do you want to Cancel this Booking?')">Cancel PNR</button>
                <button class="btn btn-success btn-sm" onclick="ticketedBooking({{ $booking->id }}, 'ticket', 'Do you want to Ticketed this Booking?')">Ticket</button>
            @endif
            <a href="{{ route('admin.booking.print.itinerary', $booking->id) }}"><button class="btn btn-secondary btn-sm">Print Itinerary</button></a>
        </div>
    </div>

    <!-- Success Alert -->
    <!-- <div class="alert alert-success m-4">
        Booking <strong>55A5F7</strong> has been created successfully.
    </div> -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
             {{ session('success') }} Booking No # {{ $booking->booking_no }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- Booking Info -->
    <div class="card mx-4 mb-4 mt-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <!-- <h5 class="text-warning">SKYALLOT</h5> -->
                    <img src="{{ $booking->pnr->airline->logo 
                            ? asset('storage/'.$booking->pnr->airline->logo) 
                                : asset('images/logo-placeholder.png') }}"
                                alt="logo"
                                class="rounded-circle border"
                                style="width:45px;height:45px;object-fit:contain;">
                    @if($booking->status->label() === 'Created')
                        <span class="badge bg-info">PNR CREATED </span>
                    @elseif($booking->status->label() === 'Ticketed')
                        <span class="badge bg-secondary">PNR TICKETED </span>
                    @elseif($booking->status->label() === 'Paid')
                        <span class="badge bg-success">PNR PAID </span>
                    @elseif($booking->status->label() === 'Cancel')
                        <span class="badge bg-danger">PNR CANCELED </span>
                    @else
                        <span class="badge bg-warning">PNR VOID </span>                
                    @endif
                    <span class="ml-4"> {{ $booking->booking_no }}<span>
                    
                </div>

                <div class="col-md-8">
                    <div class="row text-center">
                        <div class="col">
                            <small>Fare Time Limit</small>
                            <p>{{ $booking->fare_limit_date }}</p>
                        </div>
                        <div class="col">
                            <small>Booking Date</small>
                            <p>{{ $booking->booking_date }}</p>
                        </div>
                        <div class="col">
                            <small>Sync Date</small>
                            <p>{{ $booking->booking_date }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row align-items-center">
                <div class="col-md-3">Base: <strong>{{ number_format($booking->price, 2) }} EUR</strong></div>
                <div class="col-md-3">Tax: <strong>{{ number_format($booking->tax, 2) }} EUR</strong></div>
                <div class="col-md-3">Administrator Fee: <strong>{{ number_format($booking->admin_fee, 2) }} EUR</strong></div>
                <div class="col-md-3 text-success fw-bold fs-5">Total: {{ number_format($booking->total_amount, 2) }} EUR </div>
                
            </div>
            <div class="row align-items-center">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                @if($booking->status->label() === 'Ticketed')
                    <div class="col-md-3 text-success fw-bold fs-5"><button class="btn btn-success btn-sm" onclick="reQuotePrice({{ $booking->id }})">Requote</button></div> 
                @endif
            </div>

            @if($booking->status->label() === 'Ticketed' || $booking->status->label() === 'Paid')
            <hr>

            <div class="container mt-4">
                <!-- Row 1 -->
                <div class="row align-items-center mb-2">
                    <div class="col-md-6">
                        <span class="me-2">Ticket Number</span>
                        <a href="{{ route('admin.booking.print.ticketed', [$booking->id, 'dept']) }}">
                            <span class="badge ticket-badge">
                                {{ $booking->dept_ticket_no }} <i class="bi bi-files copy-icon"></i>
                            </span>
                        </a>
                    </div>

                    
                    <div class="col-md-6 text-end">
                        <span class="me-2">Ticket Status</span>
                        <span class="badge status-badge">
                            {{$booking->status->label()}} <i class="bi bi-caret-down-fill ms-1"></i>
                        </span>
                    </div>
                    
                </div>
                
                @if($booking->pnr->pnr_type != 'one_way')
                    <!-- Row 2 -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <span class="me-2">Ticket Number</span>
                            <a href="{{ route('admin.booking.print.ticketed', [$booking->id, 'arr']) }}">
                                <span class="badge ticket-badge">
                                    {{ $booking->arr_ticket_no }} <i class="bi bi-files copy-icon"></i>
                                </span>
                            </a>
                        </div>

                        <div class="col-md-6 text-end">
                            <span class="me-2">Ticket Status</span>
                            <span class="badge status-badge">
                                {{$booking->status->label()}} <i class="bi bi-caret-down-fill ms-1"></i>
                            </span>
                        </div>
                    </div>
                @endif
                <!-- Button -->
                <a href="{{ route('admin.booking.send.email.ticketed', [$booking->id, 'dept']) }}">
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-send"></i> Send tickets by email
                    </button>
                </a>
                
            </div>
            @endif
        </div>
    </div>

    <!-- Flight Segments -->
    <div class="card mx-4 mb-4">
        <div class="p-4">
        <h6 class="text-primary fw-bold">OUTBOUND</h6>
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="row align-items-center">
                    <!-- Airline -->
                    <div class="col-md-1 text-center">
                       <img src="{{ $booking->pnr->airline->logo 
                            ? asset('storage/'.$booking->pnr->airline->logo) 
                                : asset('images/logo-placeholder.png') }}"
                                alt="logo"
                                class="rounded-circle border"
                                style="width:45px;height:45px;object-fit:contain;">
                    </div>

                    <!-- From / To -->
                     <div class="col-md-2">
                        <p class="mb-1">
                            <small class="text-muted">From:</small><br>
                            <strong>{{ $booking->pnr->departure_date_time }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">To:</small><br>
                            <strong>{{ ($booking->pnr->middle_arrival_date_time) ? $booking->pnr->middle_arrival_date_time :  $booking->pnr->arrival_date_time }}</strong>
                        </p>
                    </div>

                    <!-- Airports -->
                    <div class="col-md-1 text-center fw-bold fs-5">
                        {{ $booking->pnr->departure->code}}
                    </div>
                     <div class="col-md-1 text-center fw-bold fs-5">
                        {{ (isset($booking->pnr->middle_arrival->code)) ? $booking->pnr->middle_arrival->code : $booking->pnr->arrival->code }}
                    </div>

                    <div class="col-md-2 text-center">
                        <small class="text-muted">Duration</small><br>
                        <strong>{{ ($booking->pnr->middle_arrival_date_time) ? $booking->pnr->first_duration : $booking->pnr->duration }}</strong>
                    </div>


                   

                    <!-- Aircraft -->
                    <div class="col-md-2 text-center">
                        <small class="text-muted">Airplane</small><br>
                        <strong>{{ $booking->pnr->air_craft }}</strong>
                    </div>

                    <!-- Flight Info -->
                    <div class="col-md-2">
                        <p class="mb-1">
                            <small class="text-muted">Num.:</small>
                            <strong>{{ $booking->pnr->flight_no }}</strong>
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">Class:</small>
                            <strong>{{ $booking->pnr->class }}</strong>
                        </p>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-success btn-sm">HK</button>
                    </div>

                </div>

            </div>
        </div>

        @if($booking->pnr->middle_arrival_id != null && $booking->pnr->middle_arrival_time != null && $booking->pnr->rest_time != null)
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row align-items-center">
                        <!-- Airline -->
                        <div class="col-md-1 text-center">
                        <img src="{{ $booking->pnr->airline->logo 
                                ? asset('storage/'.$booking->pnr->airline->logo) 
                                    : asset('images/logo-placeholder.png') }}"
                                    alt="logo"
                                    class="rounded-circle border"
                                    style="width:45px;height:45px;object-fit:contain;">
                        </div>

                        <!-- From / To -->
                        <div class="col-md-2">
                            <p class="mb-1">
                                <small class="text-muted">From:</small><br>
                                <strong>{{ $booking->pnr->middle_departure_date_time }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">To:</small><br>
                                <strong>{{ $booking->pnr->arrival_date_time }}</strong>
                            </p>
                        </div>

                        <!-- Airports -->
                        <div class="col-md-1 text-center fw-bold fs-5">
                            {{ $booking->pnr->middle_arrival->code}}
                        </div>
                        <div class="col-md-1 text-center fw-bold fs-5">
                            {{ $booking->pnr->arrival->code}}
                        </div>

                        <div class="col-md-2 text-center">
                            <small class="text-muted">Duration</small><br>
                            <strong>{{ $booking->pnr->second_duration }}</strong>
                        </div>

                    

                        <!-- Aircraft -->
                        <div class="col-md-2 text-center">
                            <small class="text-muted">Airplane</small><br>
                            <strong>{{ ($booking->pnr->middle_air_craft == null) ? $booking->pnr->air_craft : $booking->pnr->middle_air_craft }}</strong>
                        </div>

                        <!-- Flight Info -->
                        <div class="col-md-2">
                            <p class="mb-1">
                                <small class="text-muted">Num.:</small>
                                <strong>{{ ($booking->pnr->middle_flight_no == null) ? $booking->pnr->flight_no : $booking->pnr->middle_flight_no }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">Class:</small>
                                <strong>{{ $booking->pnr->class }}</strong>
                            </p>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-success btn-sm">HK</button>
                        </div>

                    </div>

                </div>
            </div>
        @endif

    </div>

    @if($booking->pnr->pnr_type == 'return')
        <!-- INBOUND -->
        <div class="p-4">
            <h6 class="text-primary fw-bold">INBOUND</h6>
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row align-items-center">
                        <!-- Airline -->
                        <div class="col-md-1 text-center">
                            <img src="{{ $booking->pnr->airline->logo 
                            ? asset('storage/'.$booking->pnr->airline->logo) 
                                : asset('images/logo-placeholder.png') }}"
                                alt="logo"
                                class="rounded-circle border"
                                style="width:45px;height:45px;object-fit:contain;">
                        </div>

                        <!-- From / To -->
                        <div class="col-md-2">
                            <p class="mb-1">
                                <small class="text-muted">From:</small><br>
                                <strong>{{ $booking->pnr->return_departure_date_time }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">To:</small><br>
                                <strong>{{ $booking->pnr->return_arrival_date_time }}</strong>
                            </p>
                        </div>

                        <!-- Airports -->
                        <div class="col-md-1 text-center fw-bold fs-5">
                            FSS
                        </div>
                        <div class="col-md-1 text-center fw-bold fs-5">
                            DSS
                        </div>

                        <div class="col-md-2 text-center">
                            <small class="text-muted">Duration</small><br>
                            <strong>{{ $booking->pnr->return_duration }}</strong>
                        </div>

                        

                        <!-- Aircraft -->
                        <div class="col-md-2 text-center">
                            <small class="text-muted">Airplane</small><br>
                            <strong>{{ $booking->pnr->air_craft }}</strong>
                        </div>

                        <!-- Flight Info -->
                        <div class="col-md-2">
                            <p class="mb-1">
                                <small class="text-muted">Num.:</small>
                                <strong>{{ $booking->pnr->flight_no }}</strong>
                            </p>
                            <p class="mb-0">
                                <small class="text-muted">Class:</small>
                                <strong>{{ $booking->pnr->class }}</strong>
                            </p>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-success btn-sm">HK</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endif
    </div>

    <!-- Passenger -->
    @foreach($customers as $index => $customer)
        <form class="passenger-form mb-4" data-id="{{ $customer->id }}">
            @csrf

            <div class="card mx-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    Passenger {{ $index + 1 }} (ADT)

                    <button type="button"
                        class="btn btn-success btn-sm edit-btn"
                        data-target="passenger-{{ $index }}">
                        Edit Passenger Data
                    </button>
                </div>

                <div class="card-body passenger-{{ $index }}">
                    <div class="row">
                        <div class="col-md-4">
                            Name:
                            <input type="text" class="form-control readonly-input" name="name"
                                value="{{ $customer->name }}" disabled>
                        </div>

                        <div class="col-md-4">
                            Sur Name:
                            <input type="text" class="form-control readonly-input" name="surname"
                                value="{{ $customer->surname }}" disabled>
                        </div>

                        <div class="col-md-4">
                            DOB:
                            <input type="date" class="form-control readonly-input" name="dob"
                                value="{{ $customer->dob }}" disabled>
                        </div>

                        <div class="col-md-4">
                            Gender:
                            <input type="text" class="form-control readonly-input" name="gender"
                                value="{{ $customer->gender }}" disabled>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            Email:
                            <input type="email" class="form-control readonly-input" name="email"
                                value="{{ $customer->email }}" disabled>
                        </div>

                        <div class="col-md-4">
                            Phone:
                            <input type="text" class="form-control readonly-input" name="phone_no"
                                value="{{ $customer->phone_no }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach



    <form class="booking-form" data-booking-id="{{ $booking->id }}">
        @csrf

        <div class="card mx-4 mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                Special Request

                <button type="button" class="btn btn-success btn-sm booking-edit-btn">
                    Edit Special Request
                </button>
            </div>

            <div class="card-body row booking-fields">
                <div class="col-md-3">
                    <label class="form-label small">Meal</label>
                    <select class="form-select booking-input" name="meal" disabled>
                        <option value="">Select</option>
                        @php
                            $meals = [
                                'Hindu Meal','Sea Food Meal','Kosher Meal','Vegetarian Oriental Meal',
                                'Vegetarian Vegan Meal','Low Salt Meal','Low Calorie Meal','Bland Meal',
                                'Vegetarian Jain Meal','Diabetic Meal','Vegetarian Hindu Meal','Special Meal',
                                'Gluten Intollerant Meal','Low Fat Meal','Baby Meal','Vegetarian Raw Meal',
                                'Fruit Platter Meal','Child Meal','Moslem Meal','Low Lactose Meal',
                                'Vegetarian Lacto-ovo Meal'
                            ];
                        @endphp

                        @foreach($meals as $meal)
                            <option value="{{ $meal }}" {{ $booking->meal === $meal ? 'selected' : '' }}>
                                {{ $meal }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Wheel Chair</label>
                    <select class="form-select booking-input" name="wheel_chair" disabled>
                        <option value="">Select</option>
                        <option value="WHEELCHAIR (CAN CLIMB STAIRS)" {{ $booking->wheel_chair === 'WHEELCHAIR (CAN CLIMB STAIRS)' ? 'selected' : '' }}>
                            WHEELCHAIR (CAN CLIMB STAIRS)
                        </option>
                        <option value="WHEELCHAIR (CAN NOT CLIMB STAIRS)" {{ $booking->wheel_chair === 'WHEELCHAIR (CAN NOT CLIMB STAIRS)' ? 'selected' : '' }}>
                            WHEELCHAIR (CAN NOT CLIMB STAIRS)
                        </option>
                        <option value="WHEELCHAIR (ALL THE WAY TO SEAT)" {{ $booking->wheel_chair === 'WHEELCHAIR (ALL THE WAY TO SEAT)' ? 'selected' : '' }}>
                            WHEELCHAIR (ALL THE WAY TO SEAT)
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </form>


    <div class="card mx-4 mb-4">

        <!-- Header -->
        <div class="bg-primary text-white px-3 py-2" data-bs-toggle="collapse" data-bs-target="#fareRules">
            <strong>Fare Rules</strong> ▼
        </div>

        <div id="fareRules" class="collapse show border p-3">
            <!-- Body -->
            <div class="border p-3">

                <div class="row">
                    <!-- Rules -->
                    <div class="col-md-12">
                        <span class="badge bg-light text-dark mb-2">Regole</span>

                        <div class="border p-3 bg-light small"
                            style="max-height: 260px; overflow-y: auto; white-space: pre-line;">
                               🔄 Modifiche e cancellazioni (chiaro e trasparente)

                                ✅ Cambio data fino a 10 giorni prima della partenza Gratuito – si paga solo l’eventuale differenza tariffaria.

                                ⚠️ Cambio data da 9 a 3 giorni prima della partenza Penale di 100 € + differenza tariffaria.

                                ❌ Cancellazione fino a 10 giorni prima della partenza Penale di 100 € a tratta.

                                ❌ Cancellazione da 7 a 3 giorni prima della partenza Penale di 200 € a tratta.

                                🚫 No-Show (mancata presentazione al volo) Nessun rimborso previsto. Il biglietto è considerato No-Show se la richiesta avviene entro 3 giorni dalla partenza.

                                🔁 Cambio data in caso di No-Show Penale di 200 € + differenza tariffaria.

                                🎒 Bagaglio a mano

                                👨‍🦰 Adulti e bambini (Child): 8 kg
                                👶 Neonati (Infant): 10 kg

                                Vi ricordiamo gentilmente di confermare l’orario del vostro volo 3 giorni prima della partenza
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Baggage -->
    <div class="card mx-4 mb-4">
        <div class="card-header bg-primary text-white">Document</div>
        <div class="card-body">
            
        </div>
    </div>

    <!-- Baggage -->
    <div class="card mx-4 mb-4">
        <div class="card-header bg-primary text-white">Baggage Included</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    {{ $booking->pnr->departure->name }} ({{ $booking->pnr->departure->code }}) → {{ $booking->pnr->arrival->name }} ({{ $booking->pnr->arrival->code }})
                    <span> {{ $booking->pnr->baggage }} / 8 Kg</span>
                </li>
                @if($booking->pnr->pnr_type == 'return')
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $booking->pnr->return_departure->name }} ({{ $booking->pnr->return_departure->code }}) → {{ $booking->pnr->return_arrival->name }} ({{ $booking->pnr->return_arrival->code }})
                        <span>{{ $booking->pnr->baggage }} / 8 Kg</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Reservation Recap -->
    <div class="card mx-4 mb-5">
        <div class="card-header bg-success text-white">Reservation Recap</div>
        <div class="card-body text-end">
            <p>Fare Amount: <strong>{{ number_format($booking->price, 2) }} EUR</strong></p>
            <p>Tax: <strong>{{ number_format($booking->tax, 2) }} EUR</strong></p>
            <p>Administrator Fee: <strong>{{ number_format($booking->admin_fee, 2) }} EUR</strong></p>
            <h4 class="text-success">Total: {{ number_format($booking->total_amount, 2) }} EUR</h4>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('click', function (e) {

        if (!e.target.classList.contains('edit-btn')) return;

        const btn = e.target;
        const form = btn.closest('.passenger-form');
        const container = form.querySelector('.' + btn.dataset.target);
        const inputs = container.querySelectorAll('.readonly-input');
        const passengerId = form.dataset.id;

        const isReadonly = inputs[0].hasAttribute('disabled');

        // EDIT MODE
        if (isReadonly) {
            inputs.forEach(i => i.removeAttribute('disabled'));
            btn.innerText = 'Save Passenger Data';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-warning');
            return;
        }

        // SAVE MODE (AJAX)
        const formData = new FormData(form);

        Swal.fire({
            title: "Processing...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(`/admin/passengers/${passengerId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.status) {
                // lock fields again
                inputs.forEach(i => i.setAttribute('disabled', true));

                btn.innerText = 'Edit Passenger Data';
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');

                // optional success highlight
                form.classList.add('border-success');
                setTimeout(() => form.classList.remove('border-success'), 1000);
                Swal.close();
                Swal.fire("Success", resp.message, "success");
            } else {
                alert(resp.message);
            }
        })
        .catch(() => alert('Update failed'));
    });

    document.addEventListener('click', function (e) {

        if (!e.target.classList.contains('booking-edit-btn')) return;

        const btn = e.target;
        const form = btn.closest('.booking-form');
        const inputs = form.querySelectorAll('.booking-input');
        const bookingId = form.dataset.bookingId;

        const isReadonly = inputs[0].hasAttribute('disabled');

        // EDIT MODE
        if (isReadonly) {
            inputs.forEach(i => i.removeAttribute('disabled'));
            btn.innerText = 'Save Special Request';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-warning');
            return;
        }

        Swal.fire({
            title: "Processing...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        // SAVE MODE
        const formData = new FormData(form);

        fetch(`/admin/bookings/${bookingId}/special-request`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.status) {
                
                inputs.forEach(i => i.setAttribute('disabled', true));

                btn.innerText = 'Edit Special Request';
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');

                form.classList.add('border-success');
                setTimeout(() => form.classList.remove('border-success'), 1000);

                Swal.close();
                Swal.fire("Success", resp.message, "success");
            } else {
                alert(resp.message);
            }
        })
        .catch(() => alert('Update failed'));
    });


    function ticketedBooking(id, status, message){
        Swal.fire({
            title: "Are you sure?",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: "Processing...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('admin.booking.ticketed') }}",
                    type: "GET",
                    data: {id: id, status: status},
                    success: function (res) {
                        if(res.code == 2){
                            Swal.fire(
                                "Warning",
                                res.message,
                                "error"
                            );
                        }else{
                            Swal.fire("Success", res.message, "success")
                            .then(() => {
                                window.location.href = "{{ route('admin.booking.index') }}";
                            });
                        }
                        
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Error",
                            xhr.responseJSON?.message || "Something went wrong",
                            "error"
                        );
                    }
                });

            }

        });

    }

    function reQuotePrice(id){
        let url = "{{ route('admin.booking.requote', ':id') }}";
        url = url.replace(':id', id);   

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to requote price this booking!",
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
                                $("#main-content").load(location.href + " #main-content > *");
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


@endsection
