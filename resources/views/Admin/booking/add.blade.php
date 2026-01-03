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
            <div class="col-md-3 mb-3">
                <label class="me-3">
                    <input type="radio" name="trip_type" value="one_way">
                    One Way
                </label>

                <label class="type-style">
                    <input type="radio" name="trip_type" value="return" checked>
                    Return
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
                           required>
                </div>

                <div class="col-md-2" id="arrival-date-wrapper">
                    <label class="form-label text-muted">Arrival Date</label>
                    <input type="date"
                           class="form-control"
                           name="arrival_date"
                           id="arrival_date">
                </div>

                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-dark w-100">
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

    /* ===============================
       Select2
    =============================== */
    $("#departure_id").select2({
        placeholder: "Search Departure",
        minimumInputLength: 2,
        ajax: {
            url: "{{ route('search.airport') }}",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.label
                    }))
                };
            }
        }
    });

    $("#arrival_id").select2({
        placeholder: "Search Arrival",
        minimumInputLength: 2,
        ajax: {
            url: "{{ route('search.airport') }}",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.label
                    }))
                };
            }
        }
    });

    /* ===============================
       Trip Type Logic
    =============================== */
    const arrivalWrapper = document.getElementById('arrival-date-wrapper');
    const arrivalDate    = document.getElementById('arrival_date');

    function toggleArrivalDate() {
        const type = document.querySelector('input[name="trip_type"]:checked').value;

        if (type === 'one_way') {
            arrivalDate.required = false;
            arrivalDate.value = '';
            arrivalWrapper.classList.add('d-none');
        } else {
            arrivalDate.required = true;
            arrivalWrapper.classList.remove('d-none');
        }
    }

    document.querySelectorAll('input[name="trip_type"]').forEach(radio => {
        radio.addEventListener('change', toggleArrivalDate);
    });

    // Initial load
    toggleArrivalDate();

    function selectPNRBooking(id){
        let modal = new bootstrap.Modal(document.getElementById('searchPnrSeatModal'));
        document.getElementById('pnr_id').value = id;
        modal.show();
    }


    document.addEventListener("livewire:load", function () {
        const form = document.getElementById("pnr-select-seat");
        if (!form) return;

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

            const seat = document.getElementById("seat").value.trim();

            // Validation
            if (seat === "") {
                showError("Seat is required");
                return;
            }

            // Optional loading
            Swal.fire({
                title: "Processing...",
                text: "Please wait",
                didOpen: () => Swal.showLoading()
            });

            var data = $('#pnr-select-seat').serialize();
            $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                url: "{{ route('admin.booking.seats.availability') }}",
                method: "POST",
                data: data,
                dataType: 'json',
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function (data) {
                    Swal.close();
                    if(data.code == 2){
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                    if(data.code == 1){
                        e.target.submit();
                    }

                },
                error: function (xhr) {
                    Swal.close();
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: xhr.responseJSON.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    return false;
                }
            });
        });
    });
});
</script>
@endsection




