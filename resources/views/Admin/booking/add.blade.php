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
    </style>
@endsection
@section('content')
<div class="container">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.booking.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Create Booking</h1>
        </div>
    </div>
    <hr>
    <!-- Content -->
    <div class="card p-4">

        <!-- Form -->
        <form method="POST" action="{{ route('admin.booking.create') }}">
            @csrf
    <h5 class="mb-3">Search Pnr</h5>
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
            <input type="date" class="form-control" name="departure_date"
                value="{{ request('departure_date') }}" required>
        </div>

        <div class="col-md-2">
            <label class="form-label text-muted">Arrival Date</label>
            <input type="date" class="form-control" name="arrival_date"
                value="{{ request('arrival_date') }}" required>
        </div>

        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-dark w-100">
                Search
            </button>
        </div>
    </div>
</form>

 @if($showPnrSearch)
    <livewire:admin.pnr.search-pnr 
        :initialFilters="$initialFilters" />
@endif
            <!-- Footer Buttons -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        $("#departure_id").select2({
            placeholder: "Search Departure",
            minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ route('search.airport') }}", // Replace with your actual server endpoint
                dataType: "json",
                delay: 250, // Delay before sending the request in milliseconds
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.label // 'text' property is required by Select2
                            };
                        })
                    };
                },
                cache: true // Enable caching of AJAX results
            }
        });

        $("#arrival_id").select2({
            placeholder: "Search Arrival",
            minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ route('search.airport') }}", // Replace with your actual server endpoint
                dataType: "json",
                delay: 250, // Delay before sending the request in milliseconds
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.label // 'text' property is required by Select2
                            };
                        })
                    };
                },
                cache: true // Enable caching of AJAX results
            }
        });
    });

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


    // document.getElementById("pnr-select-seat").addEventListener("submit", function (e) {
    //     e.preventDefault();

    //     function showError(message) {
    //         Swal.fire({
    //             toast: true,
    //             position: "top-end",
    //             icon: "error",
    //             title: message,
    //             showConfirmButton: false,
    //             timer: 2500
    //         });
    //     }

    //     const seat = document.getElementById("seat").value.trim();

    //     // Validation
    //     if (seat === "") {
    //         showError("Seat is required");
    //         return;
    //     }

    //     // Optional loading
    //     Swal.fire({
    //         title: "Processing...",
    //         text: "Please wait",
    //         didOpen: () => Swal.showLoading()
    //     });

    //     var data = $('#pnr-select-seat').serialize();
    //     $.ajaxSetup({
    //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    //     });

    //     $.ajax({
    //         url: "{{ route('admin.booking.seats.availability') }}",
    //         method: "POST",
    //         data: data,
    //         dataType: 'json',
    //         beforeSend: function(){
    //             $('.error-container').html('');
    //         },
    //         success: function (data) {
    //             Swal.close();
    //             if(data.code == 2){
    //                 Swal.fire({
    //                     toast: true,
    //                     position: "top-end",
    //                     icon: "error",
    //                     title: data.message,
    //                     showConfirmButton: false,
    //                     timer: 2500
    //                 });
    //             }
    //             if(data.code == 1){
    //                 e.target.submit();
    //             }

    //         },
    //         error: function (xhr) {
    //             Swal.close();
    //             Swal.fire({
    //                 toast: true,
    //                 position: "top-end",
    //                 icon: "error",
    //                 title: xhr.responseJSON.message,
    //                 showConfirmButton: false,
    //                 timer: 2500
    //             });
    //             return false;
    //         }
    //     });

    //     // ✅ SUBMIT FORM NORMALLY
        
    // });

</script>

@endsection




