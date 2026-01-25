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
<div class="container py-5">
    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.airline.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">{{ isset($pnr) ? 'Edit PNR' : 'Add PNR' }}</h1>
        </div>
    </div>
    <hr>
    <div class="card p-5">
        <form id="pnr-edit-form" enctype="multipart/form-data">
            <!-- PNR & Flight Info -->
            <h5 class="mb-3">PNR & Flight Info</h5>
            <div class="row g-3">
                <!-- <div class="col-md-3">
                    <label class="form-label text-muted">PNR Type</label>
                    <select class="form-select select2" id="pnr_type" name="pnr_type">
                        <option value="">Please Select Type</option>
                        <option value="one_way" {{ (old('pnr_type', $pnr->pnr_type ?? '') == 'one_way') ? 'selected' : '' }}>One Way</option>
                        <option value="return" {{ (old('pnr_type', $pnr->pnr_type ?? '') == 'return') ? 'selected' : '' }}>Return</option>
                        <option value="open_jaw" {{ (old('pnr_type', $pnr->pnr_type ?? '') == 'open_jaw') ? 'selected' : '' }}>Open Jaw</option>
                    </select>
                </div> -->

                <div class="col-md-3">
                    <label class="form-label text-muted">Flight No</label>
                    <input type="text" name="flight_no" id="flight_no" class="form-control" value="{{ old('flight_no', $pnr->flight_no ?? '') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Reference PNR No #</label>
                    <input type="text" name="ref_no" id="ref_no" class="form-control" value="{{ old('ref_no', $pnr->ref_no ?? '') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Aircraft</label>
                    <input type="text" name="air_craft" id="air_craft" class="form-control" value="{{ old('air_craft', $pnr->air_craft ?? '') }}">
                </div>
                
            </div>

            <!-- Route & Airline -->
            <hr>
            <h5 class="mb-3">Route & Airline</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Departure</label>
                    <select class="form-select select2" id="departure_id" name="departure_id"></select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Middle Arrival</label>
                    <select class="form-select select2" id="middle_arrival_id" name="middle_arrival_id"></select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival</label>
                    <select class="form-select select2" id="arrival_id" name="arrival_id"></select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Airline</label>
                    <select class="form-select select2" id="airline_id" name="airline_id"></select>
                </div>
            </div>

            <!-- Return Fields -->
            <div class="row g-3 return-fields mt-2 {{ (old('pnr_type', $pnr->pnr_type ?? '') == 'return' || old('pnr_type', $pnr->pnr_type ?? '') == 'open_jaw') ? '' : 'd-none' }}">
                <div class="col-md-3">
                    <label for="return_departure_id" class="form-label text-muted">Return Departure</label>
                    <select class="form-select select2 return-select" id="return_departure_id" name="return_departure_id"></select>
                </div>
                 <div class="col-md-3">
                    <label class="form-label text-muted">Return Middle Arrival</label>
                    <select class="form-select select2" id="return_middle_arrival_id" name="return_middle_arrival_id"></select>
                </div>
                <div class="col-md-3">
                    <label for="return_arrival_id" class="form-label text-muted">Return Arrival</label>
                    <select class="form-select select2 return-select" id="return_arrival_id" name="return_arrival_id"></select>
                </div>
                <div class="col-md-3">
                    <label for="return_airline_id" class="form-label text-muted">Return Airline</label>
                    <select class="form-select select2 return-select" id="return_airline_id" name="return_airline_id"></select>
                </div>
            </div>

            <!-- Dates & Times -->
            <hr>
            <h5 class="mb-3">Dates & Times</h5>
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label text-muted">Departure Date *</label>
                    <input type="date" id="departure_date" name="departure_date" class="form-control" value="{{ old('departure_date', $pnr->departure_date ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted">Departure Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="departure_time_hour" name="departure_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('departure_time_hour', $pnr->departure_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="departure_time_minute" name="departure_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('departure_time_minute', $pnr->departure_time_minute ?? '') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted">Middle Arrival Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="middle_arrival_time_hour" name="middle_arrival_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('middle_arrival_time_hour', $pnr->middle_arrival_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="middle_arrival_time_minute" name="middle_arrival_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('middle_arrival_time_minute', $pnr->middle_arrival_time_minute ?? '') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted">Middle Dept Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="middle_departure_time_hour" name="middle_departure_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('middle_departure_time_hour', $pnr->middle_departure_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="middle_departure_time_minute" name="middle_departure_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('middle_departure_time_minute', $pnr->middle_departure_time_minute ?? '') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted">Arrival Date *</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="form-control" value="{{ old('arrival_date', $pnr->arrival_date ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted">Arrival Time *</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="arrival_time_hour" name="arrival_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('arrival_time_hour', $pnr->arrival_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="arrival_time_minute" name="arrival_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('arrival_time_minute', $pnr->arrival_time_minute ?? '') }}">
                    </div>
                </div>

                <!-- Return Dates & Times -->
                <div class="col-md-2 return-fields d-none">
                    <label class="form-label text-muted">Return Departure Date</label>
                    <input type="date" id="return_departure_date" name="return_departure_date" class="form-control"
                           value="{{ old('return_departure_date', $pnr->return_departure_date ?? '') }}">
                </div>
                <div class="col-md-2 return-fields d-none">
                    <label class="form-label text-muted">Return Departure Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="return_departure_time_hour" name="return_departure_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('return_departure_time_hour', $pnr->return_departure_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="return_departure_time_minute" name="return_departure_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('return_departure_time_minute', $pnr->return_departure_time_minute ?? '') }}">
                    </div>
                </div>
                <div class="col-md-2 return-fields d-none">
                    <label class="form-label text-muted">Middle Arrival Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="middle_return_arrival_time_hour" name="middle_return_arrival_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('middle_return_arrival_time_hour', $pnr->middle_return_arrival_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="middle_return_arrival_time_minute" name="middle_return_arrival_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('middle_return_arrival_time_minute', $pnr->middle_return_arrival_time_minute ?? '') }}">
                    </div>
                </div>
                <div class="col-md-2 return-fields d-none">
                    <label class="form-label text-muted">Middle Departure Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="middle_return_departure_time_hour" name="middle_return_departure_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('middle_return_departure_time_hour', $pnr->middle_return_departure_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="middle_return_departure_time_minute" name="middle_return_departure_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('middle_return_departure_time_minute', $pnr->middle_return_departure_time_minute ?? '') }}">
                    </div>
                </div>
                <div class="col-md-2 return-fields d-none">
                    <label class="form-label text-muted">Return Arrival Date</label>
                    <input type="date" id="return_arrival_date" name="return_arrival_date" class="form-control"
                           value="{{ old('return_arrival_date', $pnr->return_arrival_date ?? '') }}">
                </div>
                <div class="col-md-2 return-fields d-none">
                    <label class="form-label text-muted">Return Arrival Time</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="number" min="0" max="23" id="return_arrival_time_hour" name="return_arrival_time_hour" class="form-control" placeholder="HH"
                               value="{{ old('return_arrival_time_hour', $pnr->return_arrival_time_hour ?? '') }}">
                        <input type="number" min="0" max="59" id="return_arrival_time_minute" name="return_arrival_time_minute" class="form-control" placeholder="MM"
                               value="{{ old('return_arrival_time_minute', $pnr->return_arrival_time_minute ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Baggage & Seats -->
            <hr>
            <h5 class="mb-3">Baggage & Seats</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Baggage</label>
                    <select class="form-select select2" id="baggage" name="baggage">
                        <option value="">Please Select Baggage</option>
                        <option value="0 PC" {{ (old('baggage', $pnr->baggage ?? '') == '0 PC') ? 'selected' : '' }}>0 PC</option>
                        <option value="2 PC" {{ (old('baggage', $pnr->baggage ?? '') == '2 PC') ? 'selected' : '' }}>2 PC</option>
                        <option value="3 PC" {{ (old('baggage', $pnr->baggage ?? '') == '3 PC') ? 'selected' : '' }}>3 PC</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Seats</label>
                    <input type="number" id="seats" name="seats" class="form-control" value="{{ old('seats', $pnr->seats ?? '') }}">
                </div>

                <div class="col-md-3" style="margin-top:50px">
                    <label class="form-label text-muted">Put On Sale</label>
                    <input type="checkbox" id="put_on_sale" name="put_on_sale" {{ (old('put_on_sale', $pnr->put_on_sale ?? false)) ? 'checked' : '' }}>
                </div>
            </div>

            <!-- Prices -->
            <hr>
            <h5 class="mb-3">Prices</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Base Fare</label>
                    <input type="text" id="base_price" name="base_price" class="form-control" placeholder="0" readonly value="{{ old('base_price', $pnr->base_price ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Tax</label>
                    <input type="text" id="tax" name="tax" class="form-control" placeholder="0" readonly value="{{ old('tax', $pnr->tax ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Total</label>
                    <input type="text" id="total" name="total" class="form-control" placeholder="0" readonly value="{{ old('total', $pnr->total ?? '') }}">
                </div>
            </div>

            <div class="row g-3 return-fields d-none mt-2">
                <div class="col-md-3">
                    <label class="form-label text-muted">Return Base Fare</label>
                    <input type="text" id="return_base_price" name="return_base_price" class="form-control" onkeyup="returnFunction()" placeholder="0"
                           value="{{ old('return_base_price', $pnr->return_base_price ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Return Tax</label>
                    <input type="text" id="return_tax" name="return_tax" class="form-control" placeholder="0" onkeyup="returnFunction()" value="{{ old('return_tax', $pnr->return_tax ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Return Total</label>
                    <input type="text" id="return_total" name="return_total" class="form-control" placeholder="0" readonly value="{{ old('return_total', $pnr->return_total ?? '') }}">
                </div>
            </div>

            <!-- Passenger Types -->
            <hr>
            <h5 class="mb-3 mt-3">Passenger Types</h5>
            <div class="row g-3 passenger-price-row" id="passenger-type-row">
                @foreach($pnrPassenger as $type)
                    <div class="col-md-2">
                        <label class="form-label text-muted">{{ $type->title }}</label>
                    </div>
                    <div class="col-md-2">
                        <input
                            type="number"
                            name="passenger_prices[{{ $type->id }}]"
                            class="form-control passenger-price"
                            placeholder="0"
                            min="0"
                            value="{{ old('passenger_prices.'.$type->id, $type->price ?? '') }}"
                            {{ $loop->first ? '' : 'readonly' }}>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end gap-3 mt-5">
                <button type="button" class="btn btn-outline-secondary">Cancel</button>
                <button type="submit" class="btn btn-dark">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#pnr_type').on('change', function () {
        const show = ['return', 'open_jaw'].includes($(this).val());
        $('.return-fields').toggleClass('d-none', !show);
    });

    function returnFunction(){
        const returnBasePriceInput = document.getElementById('return_base_price');
        const returnTaxInput       = document.getElementById('return_tax');
        const returnTotalInput     = document.getElementById('return_total');
        returnTotalInput.value = parseFloat(returnBasePriceInput.value || 0) + parseFloat(returnTaxInput.value || 0);
    }

    function showError(message) {
        Swal.fire({toast: true, position: "top-end", icon: "error", title: message, showConfirmButton: false, timer: 2500});
    }
      
    document.addEventListener('DOMContentLoaded', function () {
        const passengerPrices = document.querySelectorAll('.passenger-price');
        const basePriceInput = document.getElementById('base_price');
        const taxInput       = document.getElementById('tax');
        const totalInput     = document.getElementById('total');

        if (passengerPrices.length > 0) {
            passengerPrices[0].addEventListener('keyup', function () {
                const price = parseFloat(this.value) || 0;
                basePriceInput.value = price;
                taxInput.value = price > 0 ? 100 : 0;
                totalInput.value = price + (price > 0 ? 100 : 0);

                if (passengerPrices[1]) passengerPrices[1].value = Math.max(price - 10, 0);
                if (passengerPrices.length > 2) passengerPrices[passengerPrices.length - 1].value = 50;
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
                        results: data.map(item => ({id: item.id, text: item.label}))
                    })
                }
            });
        }

        function setSelect2AjaxValue($select, id, text) {
            if (!id) return;
            $select.find('option[value="' + id + '"]').remove();
            const option = new Option(text, id, true, true);
            $select.append(option).trigger('change');
        }

        // Init Select2
        initSelect2('#departure_id', "{{ route('search.airport') }}");
        initSelect2('#middle_arrival_id', "{{ route('search.airport') }}");
        initSelect2('#arrival_id', "{{ route('search.airport') }}");
        initSelect2('#airline_id', "{{ route('search.airline') }}");
        initSelect2('#return_departure_id', "{{ route('search.airport') }}");
        initSelect2('#return_middle_arrival_id', "{{ route('search.airport') }}");
        initSelect2('#return_arrival_id', "{{ route('search.airport') }}");
        initSelect2('#return_airline_id', "{{ route('search.airline') }}");

        @if(isset($pnr))
            setSelect2AjaxValue($('#departure_id'), '{{ $pnr->departure_id }}', '{{ $pnr->departure->name ?? '' }}');
            setSelect2AjaxValue($('#middle_arrival_id'), '{{ $pnr->middle_arrival_id }}', '{{ $pnr->middle_arrival->name ?? '' }}');
            setSelect2AjaxValue($('#arrival_id'), '{{ $pnr->arrival_id }}', '{{ $pnr->arrival->name ?? '' }}');
            setSelect2AjaxValue($('#airline_id'), '{{ $pnr->airline_id }}', '{{ $pnr->airline->name ?? '' }}');

            @if(in_array($pnr->pnr_type, ['return', 'open_jaw']))
                $('.return-fields').removeClass('d-none');
                setSelect2AjaxValue($('#return_departure_id'), '{{ $pnr->return_departure_id }}', '{{ $pnr->return_departure->name ?? '' }}');
                setSelect2AjaxValue($('#return_middle_arrival_id'), '{{ $pnr->return_middle_arrival_id }}', '{{ $pnr->middle_return_arrival->name ?? '' }}');
                setSelect2AjaxValue($('#return_arrival_id'), '{{ $pnr->return_arrival_id }}', '{{ $pnr->return_arrival->name ?? '' }}');
                setSelect2AjaxValue($('#return_airline_id'), '{{ $pnr->return_airline_id }}', '{{ $pnr->return_airline->name ?? '' }}');
            @endif
        @endif
    });

    document.getElementById("pnr-edit-form").addEventListener("submit", function (e) {
        e.preventDefault();

        // const isReturn = document.getElementById("pnr_type").value === 'return';
        const fields = {
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
            price: {value: document.getElementById("base_price").value,message: "Price is required"}
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
        // if (isReturn) {
        //     const returnFields = {
        //         return_departure_id: {value: document.getElementById("return_departure_id").value,message: "Return departure is required"},
        //         return_arrival_id: {value: document.getElementById("return_arrival_id").value,message: "Return arrival is required"},
        //         return_airline_id: {value: document.getElementById("return_airline_id").value,message: "Return airline is required"},
        //         return_departure_date: {value: document.querySelector('[name="return_departure_date"]').value,message: "Return departure date is required"},
        //         return_departure_time_hour: {value: document.querySelector('[name="return_departure_time_hour"]').value,message: "Return departure time is required"},
        //         return_departure_time_minute: {value: document.querySelector('[name="return_departure_time_minute"]').value,message: "Return departure time is required"},
        //         return_arrival_date: {value: document.querySelector('[name="return_arrival_date"]').value,message: "Return arrival date is required"},
        //         return_arrival_time_hour: {value: document.querySelector('[name="return_arrival_time_hour"]').value,message: "Return arrival time is required"},
        //         return_arrival_time_minute: {value: document.querySelector('[name="return_arrival_time_minute"]').value,message: "Return arrival time is required"}
        //     };

        //     for (const key in returnFields) {
        //         if (!returnFields[key].value) {
        //             showError(returnFields[key].message);
        //             return;
        //         }
        //     }
        // }

        const passengerPrices = document.querySelectorAll('.passenger-price');

        for (let i = 0; i < passengerPrices.length; i++) {
            if (passengerPrices[i].value === '' || passengerPrices[i].value <= 0) {
                showError('All passenger prices are required');
                passengerPrices[i].focus();
                return;
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
            url: "{{ route('admin.pnr.update', $pnr) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                Swal.fire("Success", res.message, "success");
                window.location.href = "{{ route('admin.pnr.index') }}";
            },
            error: function (xhr) {
                showError(xhr.responseJSON?.message || "Something went wrong");
            }
        });
    });
</script>
@endsection
