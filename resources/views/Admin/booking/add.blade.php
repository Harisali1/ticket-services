@extends('Admin.layouts.main')

@section('styles')
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-selection__rendered {
        line-height: 34px !important;
    }
    .select2-selection__arrow {
        height: 38px;
    }
    .type-style {
        margin-left: 25px;
    }
    .table-scroll {
        max-height: 500px;
        overflow-x: auto;
    }

    .table-scroll thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f8f9fa;
    }
    .select2-container--default{
        width: -webkit-fill-available!important;
    }
    .pnr-shadow-box {
        background: #fff;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .shoadow-master{
        background: lightgray!important;
    }
    /*price range slider  */
.price-box{
    width: 300px;
    background:#fff;
    border-radius:12px;
}

.slider-container{
    position:relative;
    height:40px;
}

input[type=range]{
    position:absolute;
    width:100%;
    pointer-events:none;
    background:none;
    -webkit-appearance:none;
}

input[type=range]::-webkit-slider-thumb{
    pointer-events:auto;
    width:18px;
    height:18px;
    border-radius:50%;
    background:#000;
    cursor:pointer;
    -webkit-appearance:none;
}

.track{
    position:absolute;
    height:6px;
    background:#ddd;
    width:100%;
    top:17px;
    border-radius:5px;
}

.range{
    position:absolute;
    height:6px;
    background:#000;
    top:17px;
    border-radius:5px;
}

.values{
    display:flex;
    justify-content:space-between;
    font-weight:bold;
}

/* Make modal full width on small screens */
@media (max-width: 768px) {

    .modal-dialog {
        margin: 10px;
    }

    #mytable thead {
        display: none;
    }

    #mytable,
    #mytable tbody,
    #mytable tr,
    #mytable td {
        display: block;
        width: 100%;
    }

    #mytable tr {
        margin-bottom: 15px;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 10px;
    }

    #mytable td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border: none;
    }

    #mytable td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: 600;
        text-align: left;
    }

    #mytable td:last-child {
        text-align: left;
        padding-left: 0;
    }

}

</style>
@endsection

@section('content')
<div class="container">
    <hr>

    <div class="card p-4">

        <form method="POST" action="{{ route('admin.booking.create') }}">
            @csrf

            <h5 class="mb-3">{{ __('messages.search_flight') }}</h5>
            <hr>

            <!-- Trip Type -->
            <!-- <div class="col-md-5 mb-3">
                <label class="me-3">
                    <input type="radio" name="trip_type" value="one_way"
                        {{ request('trip_type', 'one_way') === 'one_way' ? 'checked' : '' }}>
                    {{ __('messages.one_way') }}
                </label>

                <label class="type-style">
                    <input type="radio" name="trip_type" value="return"
                        {{ request('trip_type') === 'return' ? 'checked' : '' }}>
                    {{ __('messages.return') }}
                </label>

                <label class="type-style">
                    <input type="radio" name="trip_type" value="return"
                        {{ request('trip_type') === 'return' ? 'checked' : '' }}>
                    {{ __('messages.open_jaw') }}
                </label>
                <div class="price-box">
                    <label class="form-label text-muted">Price</label>
                    <div class="slider-container">

                        <div class="track"></div>
                        <div class="range" id="range"></div>

                        <input type="range" id="min" min="0" max="5000" value="500">
                        <input type="range" id="max" min="0" max="5000" value="3500">
                    </div>

                    <div class="values">
                        <span>$<span id="minVal">500</span></span>
                        <span>$<span id="maxVal">3500</span></span>
                    </div>
                </div>
            </div> -->
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">

                <!-- LEFT : Trip Type -->
                <div>
                    <label class="me-3">
                    <input type="radio" name="trip_type" value="one_way"
                        {{ request('trip_type', 'one_way') === 'one_way' ? 'checked' : '' }}>
                        {{ __('messages.one_way') }}
                    </label>

                    <label class="type-style">
                    <input type="radio" name="trip_type" value="return"
                        {{ request('trip_type') === 'return' ? 'checked' : '' }}>
                    {{ __('messages.return') }}
                    </label>

                    <label class="type-style">
                        <input type="radio" name="trip_type" value="return"
                            {{ request('trip_type') === 'return' ? 'checked' : '' }}>
                        {{ __('messages.open_jaw') }}
                    </label>
                </div>

                <!-- RIGHT : Price Slider -->
                <!-- <div class="price-box">

                    <div class="slider-container">
                        <div class="track"></div>
                        <div class="range" id="range"></div>

                        <input type="range" id="min" name="min" min="0" max="5000" value="500">
                        <input type="range" id="max" name="max" min="0" max="5000" value="3500">
                    </div>

                    <div class="values">
                        <span>$<span id="minVal">500</span></span>
                        <span>$<span id="maxVal">3500</span></span>
                    </div>
                </div> -->

            </div>


            <hr>

            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label text-muted">{{ __('messages.departure') }}</label>
                    <select class="form-select" name="departure_id" id="departure_id" required>
                        <option value="">Select Departure</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">{{ __('messages.arrival') }}</label>
                    <select class="form-select" name="arrival_id" id="arrival_id" required>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">{{ __('messages.departure_date') }}</label>
                    <input type="date"
                           class="form-control"
                           name="departure_date"
                           id="departure_date"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('departure_date', request('departure_date')) }}"
                           required>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">{{ __('messages.day') }} -</label>
                    <select class="form-select select2" id="day_minus" name="day_minus">
                        <option value="1">-1</option>
                        <option value="2">-2</option>
                        <option value="3" selected>-3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">{{ __('messages.day') }} +</label>
                    <select class="form-select select2" id="day_plus" name="day_plus">
                        <option value="1">+1</option>
                        <option value="2">+2</option>
                        <option value="3" selected>+3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">{{ __('messages.price_to') }}</label>
                    <input type="number"
                           class="form-control"
                           name="price_to"
                           id="price_to"
                           value="{{ old('price_to', request('price_to')) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted">{{ __('messages.price_from') }}</label>
                    <input type="number"
                           class="form-control"
                           name="price_from"
                           id="price_from"
                           value="{{ old('price_from', request('price_from')) }}">
                </div>
                

            </div>

            <div class="row g-3 d-none mt-1" id="return-fields">

                <div class="col-md-3">
                    <!-- <label class="form-label text-muted">Departure</label> -->
                    <select class="form-select" name="return_departure_id" id="return_departure_id">
                        <option value="">Select Departure</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <!-- <label class="form-label text-muted">Arrival</label> -->
                    <select class="form-select" name="return_arrival_id" id="return_arrival_id">
                        <option value="">Select Arrival</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <!-- <label class="form-label text-muted">Departure Date</label> -->
                    <input type="date"
                           class="form-control"
                           name="return_departure_date"
                           id="return_departure_date"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('return_departure_date', request('return_departure_date')) }}">
                </div>

                <div class="col-md-2">
                    <!-- <label class="form-label text-muted">Day -</label> -->
                    <select class="form-select select2" id="return_day_minus" name="return_day_minus">
                        <option value="1">-1</option>
                        <option value="2">-2</option>
                        <option value="3" selected>-3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <!-- <label class="form-label text-muted">Day +</label> -->
                    <select class="form-select select2" id="return_day_plus" name="return_day_plus">
                        <option value="1">+1</option>
                        <option value="2">+2</option>
                        <option value="3" selected>+3</option>
                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark">
                        {{ __('messages.search') }}
                    </button>
                </div>
            </div>

                

           
        </form>

        @if($showPnrSearch)
            <livewire:admin.pnr.search-pnr :initialFilters="$initialFilters" />
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>

    // const minSlider = document.getElementById("min");
    // const maxSlider = document.getElementById("max");
    // const minVal = document.getElementById("minVal");
    // const maxVal = document.getElementById("maxVal");
    // const range = document.getElementById("range");

    // function updateSlider(){
    //     let min = parseInt(minSlider.value);
    //     let max = parseInt(maxSlider.value);

    //     if(min > max - 100){
    //         minSlider.value = max - 100;
    //         min = max - 100;
    //     }

    //     if(max < min + 100){
    //         maxSlider.value = min + 100;
    //         max = min + 100;
    //     }

    //     minVal.innerText = min;
    //     maxVal.innerText = max;

    //     let percentMin = (min / 5000) * 100;
    //     let percentMax = (max / 5000) * 100;

    //     range.style.left = percentMin + "%";
    //     range.style.width = (percentMax - percentMin) + "%";
    //     minSlider.value = min;
    //     maxSlider.value = max;
    // }

    // minSlider.addEventListener("input", updateSlider);
    // maxSlider.addEventListener("input", updateSlider);

    // updateSlider();

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
    
    $(document).ready(function () {

        function syncReturnDateMin() {
            const departureDate = $('#departure_date').val();

            if (departureDate) {
                $('#return_departure_date')
                    .attr('min', departureDate);

                // Agar return date already pichay ki hai, clear kar do
                if ($('#return_departure_date').val() < departureDate) {
                    $('#return_departure_date').val('');
                }
            }
        }

        // Jab departure date change ho
        $('#departure_date').on('change', function () {
            syncReturnDateMin();
        });

        // Page load pe bhi apply ho
        syncReturnDateMin();

        function toggleReturnFields() {
            const tripType = $('input[name="trip_type"]:checked').val();

            if (tripType === 'return') {
                $('#return-fields').removeClass('d-none');
            } else {
                $('#return-fields').addClass('d-none');
            }
        }

        // On radio change
        $('input[name="trip_type"]').on('change', function () {
            toggleReturnFields();
        });

        // On page load
        toggleReturnFields();

        /* ===============================
        Select2
        =============================== */

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
            initSelect2('#return_departure_id', "{{ route('search.airport') }}");
            initSelect2('#return_arrival_id', "{{ route('search.airport') }}");

            @if(isset($departureAirport))
                setSelect2AjaxValue(
                    $('#departure_id'),
                    "{{ $departureAirport->id }}",
                    "{{ $departureAirport->name }} ({{ $departureAirport->code }})"
                );
            @endif

            @if(isset($arrivalAirport))
                setSelect2AjaxValue(
                    $('#arrival_id'),
                    "{{ $arrivalAirport->id }}",
                    "{{ $arrivalAirport->name }} ({{ $arrivalAirport->code }})"
                );
            @endif

            @if(isset($returnDepartureAirport))
                setSelect2AjaxValue(
                    $('#return_departure_id'),
                    "{{ $returnDepartureAirport->id }}",
                    "{{ $returnDepartureAirport->name }} ({{ $returnDepartureAirport->code }})"
                );
            @endif

            @if(isset($returnArrivalAirport))
                setSelect2AjaxValue(
                    $('#return_arrival_id'),
                    "{{ $returnArrivalAirport->id }}",
                    "{{ $returnArrivalAirport->name }} ({{ $returnArrivalAirport->code }})"
                );
            @endif
        });

        // Departure → Return Arrival
        $('#departure_id').on('select2:select', function (e) {
            const data = e.params.data;

            setSelect2AjaxValue(
                $('#return_arrival_id'),
                data.id,
                data.text
            );
            // $('#return_arrival_id').prop('readonly', true);
        });

        // Arrival → Return Departure
        $('#arrival_id').on('select2:select', function (e) {
            const data = e.params.data;

            setSelect2AjaxValue(
                $('#return_departure_id'),
                data.id,
                data.text
            );
            // $('#return_departure_id').prop('readonly', true);
        });
    });

    function selectPNRBooking(id, returnId= null){
        let modal = new bootstrap.Modal(document.getElementById('searchPnrSeatModal'));
        document.getElementById('pnr_id').value = id;
        document.getElementById('return_pnr_id').value = returnId;
        modal.show();
    }

    

    document.addEventListener('DOMContentLoaded', function () {

        // Re-bind after Livewire DOM updates
        Livewire.hook('message.processed', () => {
            bindSeatForm();
        });

        bindSeatForm();

        function bindSeatForm() {

            const form = document.getElementById("pnr-select-seat");
            if (!form || form.dataset.bound) return;

            form.dataset.bound = "true"; // prevent multiple bindings

            form.addEventListener("submit", function (e) {
                e.preventDefault();

                

                const seat = document.getElementById("seat")?.value.trim();

                if (!seat) {
                    showError("Seat is required");
                    return;
                }

                Swal.fire({
                    title: "Processing...",
                    text: "Please wait",
                    didOpen: () => Swal.showLoading()
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content')
                    }
                });

                $.ajax({
                    url: "{{ route('admin.booking.seats.availability') }}",
                    method: "POST",
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (data) {
                        Swal.close();

                        if (data.code === 2) {
                            showError(data.message);
                            return;
                        }

                        // ✅ allow actual submit if OK
                        if (data.code === 1) {
                            form.submit();
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        showError(xhr.responseJSON?.message || 'Something went wrong');
                    }
                });
            });
        }
    });

</script>
@endsection




