@extends('Admin.layouts.main')

@section('styles')
    <style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-selection__rendered {
        line-height: 34px!important;
    }
    .select2-selection__arrow {
        height: 38px;
    }
    .select2-container--default{
        width: -webkit-fill-available!important;
    }
    </style>
@endsection
@section('content')
<div class="container">
    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.airline.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Add Pnr</h1>
        </div>
    </div>
    <hr>
    <div class="card p-4">
        <form id="pnr-form" enctype="multipart/form-data">
            <h5 class="mb-3">PNR & Flight Info</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">PNR Type</label>
                    <select class="form-select select2" id="pnr_type" name="pnr_type">
                        <option value="">Please Select Type</option>
                        <option value="one_way">One Way</option>
                        <option value="return">Return</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Flight No</label>
                    <input type="text" name="flight_no" id="flight_no" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Aircraft</label>
                    <input type="text" name="air_craft" id="air_craft" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Class</label>
                    <select class="form-select" name="class" id="class">
                        <option value="Y" selected>Y</option>
                    </select>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Route & Airline</h5>
            <!-- Outbound -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted">Departure</label>
                    <select class="form-select select2" id="departure_id" name="departure_id"></select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-muted">Arrival</label>
                    <select class="form-select select2" id="arrival_id" name="arrival_id"></select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-muted">Airline</label>
                    <select class="form-select select2" id="airline_id" name="airline_id"></select>
                </div>
            </div>

            <!-- Return -->
            <div class="row g-3 return-fields d-none mt-2">
                <div class="col-md-4">
                    <label for="return_departure_id" class="form-label text-muted">Return Departure</label>
                    <select class="form-select select2 return-select" id="return_departure_id" name="return_departure_id"></select>
                </div>

                <div class="col-md-4">
                    <label for="return_arrival_id" class="form-label text-muted">Return Arrival</label>
                    <select class="form-select select2 return-select" id="return_arrival_id" name="return_arrival_id"></select>
                </div>

                <div class="col-md-4">
                    <label for="return_airline_id" class="form-label text-muted">Return Airline</label>
                    <select class="form-select select2 return-select" id="return_airline_id" name="return_airline_id"></select>
                </div>
            </div>


            <hr>
            <h5 class="mb-3">Dates & Times</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Departure Date *</label>
                    <input type="date" id="departure_date" name="departure_date" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Departure Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input
                            type="number"
                            min="0"
                            max="23"
                            id="departure_time_hour"
                            name="departure_time_hour"
                            class="form-control"
                            placeholder="HH"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');
                            if (this.value !== '' && (this.value < 0 || this.value > 24)) this.value = '';">
                        <input
                            type="number"
                            min="0"
                            max="59"
                            id="departure_time_minute"
                            name="departure_time_minute"
                            class="form-control"
                            placeholder="MM"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');
                            if (this.value !== '' && (this.value < 0 || this.value > 59)) this.value = '';">
                    </div>
                </div>

                <!-- Arrival Date -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival Date *</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="form-control">
                </div>

                <!-- Arrival Time -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival Time *</label>
                    <!-- <input type="time" id="time" name="time"> -->
                    <div class="d-flex align-items-center gap-2">
                        <input
                            type="number"
                            min="0"
                            max="23"
                            id="arrival_time_hour"
                            name="arrival_time_hour"
                            class="form-control"
                            placeholder="HH"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');
                            if (this.value !== '' && (this.value < 0 || this.value > 24)) this.value = '';">
                        <input
                            type="number"
                            min="0"
                            max="59"
                            id="arrival_time_minute"
                            name="arrival_time_minute"
                            class="form-control"
                            placeholder="MM"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');
                            if (this.value !== '' && (this.value < 0 || this.value > 59)) this.value = '';">
                    </div>
                </div>

                <div class="col-md-3 return-fields d-none">
                    <label class="form-label text-muted">Return Departure Date</label>
                    <input type="date" id="return_departure_date" name="return_departure_date" class="form-control">
                </div>

                <div class="col-md-3 return-fields d-none">
                    <label class="form-label text-muted">Return Departure Time</label>
                    <div class="d-flex align-items-center gap-2">
                    <input
                        type="number"
                        min="0"
                        max="23"
                        id="return_departure_time_hour"
                        name="return_departure_time_hour"
                        class="form-control"
                        placeholder="HH"
                        oninput="this.value = this.value.replace(/[^0-9]/g,'');
                        if (this.value !== '' && (this.value < 0 || this.value > 24)) this.value = '';">
                    <input
                        type="number"
                        min="0"
                        max="59"
                        id="return_departure_time_minute"
                        name="return_departure_time_minute"
                        class="form-control"
                        placeholder="MM"
                        oninput="this.value = this.value.replace(/[^0-9]/g,'');
                        if (this.value !== '' && (this.value < 0 || this.value > 59)) this.value = '';">
                    </div>
                </div>

                <div class="col-md-3 return-fields d-none">
                    <label class="form-label text-muted">Return Arrival Date</label>
                    <input type="date" id="return_arrival_date" name="return_arrival_date" class="form-control">
                </div>

                <div class="col-md-3 return-fields d-none">
                    <label class="form-label text-muted">Return Arrival Time</label>
                    <div class="d-flex align-items-center gap-2">
                    <input
                        type="number"
                        min="0"
                        max="23"
                        id="return_arrival_time_hour"
                        name="return_arrival_time_hour"
                        class="form-control"
                        placeholder="HH"
                        oninput="this.value = this.value.replace(/[^0-9]/g,'');
                        if (this.value !== '' && (this.value < 0 || this.value > 24)) this.value = '';">
                    <input
                        type="number"
                        min="0"
                        max="59"
                        id="return_arrival_time_minute"
                        name="return_arrival_time_minute"
                        class="form-control"
                        placeholder="MM"
                        oninput="this.value = this.value.replace(/[^0-9]/g,'');
                        if (this.value !== '' && (this.value < 0 || this.value > 59)) this.value = '';">
                    </div>
                </div>
            </div> 

            <hr>
            <h5 class="mb-3">Baggage & Seats</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Baggage</label>
                    <select class="form-select select2" id="baggage" name="baggage">
                        <option value="">Please Select Baggage</option>
                        <option value="0 PC">0 PC</option>
                        <option value="2 PC">2 PC</option>
                        <option value="3 PC">3 PC</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Seats</label>
                    <input type="number" id="seats" name="seats" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Price</label>
                    <input type="text" id="price" name="price" class="form-control" placeholder="0">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Put On Sale</label>
                    <input type="checkbox" id="put_on_sale" name="put_on_sale">
                </div>
            </div>

            <hr>
            <h5 class="mb-3 mt-3">Passenger Types</h5>

            @foreach($passengerTypes as $type)
                <div class="row g-3 passenger-price-row" data-title="{{ $type->title }}">
                    <div class="col-md-4">
                        <label class="form-label text-muted">{{ $type->title }}</label>
                    </div>

                    <div class="col-md-3">
                        <input
                            type="number"
                            name="passenger_prices[{{ $type->id }}]"
                            class="form-control passenger-price"
                            placeholder="0"
                            min="0"
                            required>
                    </div>
                </div>
            @endforeach


            <div class="d-flex justify-content-end gap-3 mt-5">
                <button type="button" class="btn btn-outline-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn btn-dark">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
   $('#pnr_type').on('change', function () {
    $('.return-fields').toggleClass('d-none', $(this).val() !== 'return');
});


    function showError(message) {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: message,
            showConfirmButton: false,
            timer: 2500
        });
    }

    function initSelect2(id, url) {
        $(id).select2({
            placeholder: 'Search',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: data.map(item => ({
                        id: item.id,
                        text: item.label
                    }))
                })
            }
        });
    }

    function setSelect2AjaxValue($select, id, text) {
        if (!id) return;
    
        // Remove existing option if any
        $select.find('option[value="' + id + '"]').remove();

        // Create & select new option
        const option = new Option(text, id, true, true);
        $select.append(option).trigger('change');
    }


    $(document).ready(function () {
        initSelect2('#departure_id', "{{ route('search.airport') }}");
        initSelect2('#arrival_id', "{{ route('search.airport') }}");
        initSelect2('#airline_id', "{{ route('search.airline') }}");
        initSelect2('#return_departure_id', "{{ route('search.airport') }}");
        initSelect2('#return_arrival_id', "{{ route('search.airport') }}");
        initSelect2('#return_airline_id', "{{ route('search.airline') }}");
    });

    // Departure → Return Arrival
    $('#departure_id').on('select2:select', function (e) {
        const data = e.params.data;

        setSelect2AjaxValue(
            $('#return_arrival_id'),
            data.id,
            data.text
        );
    });

    // Arrival → Return Departure
    $('#arrival_id').on('select2:select', function (e) {
        const data = e.params.data;

        setSelect2AjaxValue(
            $('#return_departure_id'),
            data.id,
            data.text
        );
    });

    document.getElementById("pnr-form").addEventListener("submit", function (e) {
        e.preventDefault();

        const isReturn = document.getElementById("pnr_type").value === 'return';

        const fields = {
            pnr_type: {value: document.getElementById("pnr_type").value, message: "PNR Type is required"},
            flight_no: {value: document.getElementById("flight_no").value, message: "Flight number is required"},
            departure_id: {value: document.getElementById("departure_id").value, message: "Please select departure"},
            arrival_id: {value: document.getElementById("arrival_id").value, message: "Please select arrival"},
            airline_id: {value: document.getElementById("airline_id").value, message: "Please select airline"},
            departure_date: {value: document.getElementById("departure_date").value, message: "Departure date is required"},
            departure_time_hour: {value: document.getElementById("departure_time_hour").value, message: "Departure time is required"},
            departure_time_minute: {value: document.getElementById("departure_time_minute").value, message: "Departure time is required"},
            arrival_date: {value: document.getElementById("arrival_date").value,message: "Arrival date is required"},
            arrival_time_hour: {value: document.getElementById("arrival_time_hour").value,message: "Arrival time is required"},
            arrival_time_minute: {value: document.getElementById("arrival_time_minute").value,message: "Arrival time is required"},
            baggage: {value: document.getElementById("baggage").value,message: "Please select baggage"},
            seats: {value: document.getElementById("seats").value,message: "Seats are required"},
            price: {value: document.getElementById("price").value,message: "Price is required"}
        };

        /* --------------------
        BASIC VALIDATION
        -------------------- */
        for (const key in fields) {
            if (!fields[key].value) {
                showError(fields[key].message);
                return;
            }
        }

        /* --------------------
        RETURN PNR VALIDATION
        -------------------- */
        if (isReturn) {
            const returnFields = {
                return_departure_id: {value: document.getElementById("return_departure_id").value,message: "Return departure is required"},
                return_arrival_id: {value: document.getElementById("return_arrival_id").value,message: "Return arrival is required"},
                return_airline_id: {value: document.getElementById("return_airline_id").value,message: "Return airline is required"},
                return_departure_date: {value: document.querySelector('[name="return_departure_date"]').value,message: "Return departure date is required"},
                return_departure_time_hour: {value: document.querySelector('[name="return_departure_time_hour"]').value,message: "Return departure time is required"},
                return_departure_time_minute: {value: document.querySelector('[name="return_departure_time_minute"]').value,message: "Return departure time is required"},
                return_arrival_date: {value: document.querySelector('[name="return_arrival_date"]').value,message: "Return arrival date is required"},
                return_arrival_time_hour: {value: document.querySelector('[name="return_arrival_time_hour"]').value,message: "Return arrival time is required"},
                return_arrival_time_minute: {value: document.querySelector('[name="return_arrival_time_minute"]').value,message: "Return arrival time is required"}
            };

            for (const key in returnFields) {
                if (!returnFields[key].value) {
                    showError(returnFields[key].message);
                    return;
                }
            }
        }

        /* --------------------
        SUBMIT FORM
        -------------------- */
        Swal.fire({
            title: "Processing...",
            didOpen: () => Swal.showLoading()
        });

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.pnr.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                Swal.fire("Success", res.message, "success")
                    .then(() => window.location.href = "{{ route('admin.pnr.index') }}");
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message || "Something went wrong");
            }
        });
    });

</script>

@endsection




