@extends('Admin.layouts.main')

@section('styles')
  
@endsection

@section('content')
<div class="container-fluid p-0">

    <!-- Top Bar -->
    <div class="bg-primary text-white px-4 py-3 d-flex justify-content-between align-items-center">
        <div>
            <small>Home / Booking List / Booking Detail</small>
            <strong class="ms-2"></strong>
        </div>
        <div class="btn-group">
            @if($booking->status->label() === 'Created')
            <button class="btn btn-danger btn-sm">Cancel PNR</button>
            <button class="btn btn-success btn-sm" onclick="ticketedBooking({{ $booking->id }})">Ticket</button>
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
                    <span class="badge bg-info">PNR CREATED </span><span class="ml-4">{{ $booking->booking_no }}<span>
                    
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
                <div class="col-md-3">Base: <strong>{{ $booking->pnr->base_price }}.00 EUR</strong></div>
                <div class="col-md-3">Tax: <strong>{{ $booking->pnr->tax}}.00 EUR</strong></div>
                <div class="col-md-3 text-success fw-bold fs-5">Total: {{ $booking->pnr->total }}.00 EUR</div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-success btn-sm">Requote</button>
                </div>
            </div>
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
                            <strong>{{ $booking->pnr->arrival_date_time }}</strong>
                        </p>
                    </div>

                    <!-- Airports -->
                    <div class="col-md-1 text-center fw-bold fs-5">
                        {{ $booking->pnr->departure->code}}
                    </div>
                     <div class="col-md-1 text-center fw-bold fs-5">
                        {{ $booking->pnr->arrival->code}}
                    </div>

                    <div class="col-md-2 text-center">
                        <small class="text-muted">Duration</small><br>
                        <strong>{{ $booking->pnr->duration }}</strong>
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
<form class="passenger-form mb-4">
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
                    <input type="text"
                           class="form-control readonly-input"
                           name="name[]"
                           value="{{ $customer->name }}"
                           disabled>
                </div>

                <div class="col-md-4">
                    DOB:
                    <input type="date"
                           class="form-control readonly-input"
                           name="dob[]"
                           value="{{ $customer->dob }}"
                           disabled>
                </div>

                <div class="col-md-4">
                    Gender:
                    <input type="text"
                           class="form-control readonly-input"
                           name="gender[]"
                           value="{{ $customer->gender }}"
                           disabled>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    Email:
                    <input type="email"
                           class="form-control readonly-input"
                           name="email[]"
                           value="{{ $customer->email }}"
                           disabled>
                </div>

                <div class="col-md-4">
                    Phone:
                    <input type="text"
                           class="form-control readonly-input"
                           name="phone[]"
                           value="{{ $customer->phone_no }}"
                           disabled>
                </div>
            </div>
        </div>
    </div>
</form>
@endforeach


    <div class="card mx-4 mb-4">
        <div class="card-header bg-primary text-white">Special Request:</div>
        <div class="card-body row">
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
                <option value="Gluten Intollerant Meal" {{ $booking->meal == 'Gluten Intollerant Meal' ? 'selected' : '' }}>Gluten Intollerant Meal</option>
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
    </div>

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
                                - Si ricorda che i 30Kg compresi DEVONO essere in 1 Bagaglio
                                - Tutti i passeggeri hanno l'obbligo di riconfermare l'orario 3 GIORNI PRIMA DELLA PARTENZA

                                - Cambio data a 7gg prima della partenza GRATUITO, da pagare solo differenza tariffaria
                                - Cambio data entro 6gg dalla partenza fino a 24ore prima del volo: 100euro + differenza tariffaria
                                - Penale di cancellazione 7gg prima della partenza: 100euro a tratta
                                - Penale di cancellazione entro i 6gg dalla partenza fino a 24ore prima del volo: 200euro a tratta
                                - In caso di No-Show non sono previsti rimborsi (entro le 24ore dal volo il biglietto è da considerarsi No-show)
                                - Cambio data in caso di No-Show penale 200euro + differenza tariffaria
                                - Bagaglio a mano Adulto e Child 10kg
                                - Secondo Bagaglio Extra da 23Kg: 70euro a tratta
                                - Secondo Bagaglio Extra da 30Kg: 100euro a tratta
                                - Terzo Bagaglio o superiore da 23Kg: 100euro a tratta
                                - Terzo Bagaglio o superiore da 30Kg: 120euro a tratta
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
            <p>Fare Amount: <strong>{{ $booking->pnr->base_price }}.00 EUR</strong></p>
            <p>Tax: <strong>{{ $booking->pnr->tax }}.00 EUR</strong></p>
            <h4 class="text-success">Total: {{ $booking->pnr->total }}.00 EUR</h4>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {

            const targetClass = e.target.dataset.target;
            const container = document.querySelector('.' + targetClass);
            const inputs = container.querySelectorAll('.readonly-input');

            const isReadonly = inputs[0].hasAttribute('disabled');

            inputs.forEach(input => {
                if (isReadonly) {
                    input.removeAttribute('disabled');
                } else {
                    input.setAttribute('disabled', true);
                }
            });

            // Toggle button text
            e.target.innerText = isReadonly ? 'Save Passenger Data' : 'Edit Passenger Data';
            e.target.classList.toggle('btn-success');
            e.target.classList.toggle('btn-warning');
        }
    });

    function ticketedBooking(id){
            Swal.fire({
            title: "Are you sure?",
            text: "Do you want to save this PNR?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Save it",
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
                    data: {id: id},
                    success: function (res) {
                        Swal.fire("Success", res.message, "success")
                            .then(() => {
                                window.location.href = "{{ route('admin.pnr.index') }}";
                            });
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
</script>


@endsection
