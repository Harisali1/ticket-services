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
</style>
@endsection

@section('content')
<div class="container">
    <hr>

    <div class="card p-4">

        <form method="POST" action="{{ route('admin.booking.create') }}">
            @csrf

            <h5 class="mb-3">Search Flight</h5>
            <hr>

            <!-- Trip Type -->
            <div class="col-md-4 mb-3">
                <label class="me-3">
                    <input type="radio" name="trip_type" value="one_way"
                        {{ request('trip_type', 'one_way') === 'one_way' ? 'checked' : '' }}>
                    One Way
                </label>

                <label class="type-style">
                    <input type="radio" name="trip_type" value="return"
                        {{ request('trip_type') === 'return' ? 'checked' : '' }}>
                    Return
                </label>

                <label class="type-style">
                    <input type="radio" name="trip_type" value="open_jaw"
                        {{ request('trip_type') === 'open_jaw' ? 'checked' : '' }}>
                    Open Jaw
                </label>
            </div>


            <hr>

            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label text-muted">Departure</label>
                    <select class="form-select" name="departure_id" id="departure_id" required>
                        <option value="">Select Departure</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival</label>
                    <select class="form-select" name="arrival_id" id="arrival_id" required>
                        <option value="">Select Arrival</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">Departure Date</label>
                    <input type="date"
                           class="form-control"
                           name="departure_date"
                           id="departure_date"
                           value="{{ old('departure_date', request('departure_date')) }}"
                           required>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">Day -</label>
                    <select class="form-select select2" id="day_minus" name="day_minus">
                        <option value="1">-1</option>
                        <option value="2">-2</option>
                        <option value="3" selected>-3</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">Day +</label>
                    <select class="form-select select2" id="day_plus" name="day_plus">
                        <option value="1">+1</option>
                        <option value="2">+2</option>
                        <option value="3" selected>+3</option>
                    </select>
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
                        Search
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
    $(document).ready(function () {

        function toggleReturnFields() {
            const tripType = $('input[name="trip_type"]:checked').val();

            if (tripType === 'return' || tripType === 'open_jaw') {
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

    function selectPNRBooking(id){
        let modal = new bootstrap.Modal(document.getElementById('searchPnrSeatModal'));
        document.getElementById('pnr_id').value = id;
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




