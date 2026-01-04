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
            <a href="{{ route('admin.airline.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Add Pnr</h1>
        </div>
    </div>
    <hr>
    <!-- Content -->
    <div class="card p-4">

        <!-- Form -->
        <form id="pnr-form" enctype="multipart/form-data">
            <h5 class="mb-3">Basic Details</h5>
            <!-- Grid -->
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label text-muted">Departure</label>
                    <select class="form-select select2" id="departure_id" name="departure_id">
                        <option selected value="">Please Select Departure</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival</label>
                    <select class="form-select select2" id="arrival_id" name="arrival_id">
                        <option value="">Please Select Arrival</option>
                    </select>
                </div>
                <!-- Airline -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Airline</label>
                    <select class="form-select select2" id="airline_id" name="airline_id">
                        <option value="">Please Select AirLine</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-muted">Baggage</label>
                    <select
                        class="form-select select2"
                        id="baggage_id"
                        name="baggage_id[]"
                        multiple>
                        <option value="">Please Select Baggage</option>
                    </select>
                </div>


                <!-- Seats -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Seats</label>
                    <input type="number" id="seats" name="seats" class="form-control" placeholder="0">
                </div>

                <!-- Departure Date -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Departure Date *</label>
                    <input type="date" id="departure_date" name="departure_date" class="form-control">
                </div>

                <!-- Departure Time -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Departure Time *</label>
                    <input type="time" id="departure_time" name="departure_time" class="form-control">
                </div>

                <!-- Arrival Date -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival Date *</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="form-control">
                </div>

                <!-- Arrival Time -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Arrival Time *</label>
                    <input type="time" id="arrival_time" name="arrival_time" class="form-control">
                </div>

                <!-- Price -->
                <div class="col-md-3">
                    <label class="form-label text-muted">Price</label>
                    <input type="text" id="price" name="price" class="form-control" placeholder="0">
                </div>

            </div>

            <!-- Footer Buttons -->
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

        $("#airline_id").select2({
            placeholder: "Search Airline",
            minimumInputLength: 2, // Minimum characters before sending the AJAX request
            allowClear: true,
            ajax: {
                url: "{{ route('search.airline') }}", // Replace with your actual server endpoint
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
        
        $('#baggage_id').select2({
            placeholder: 'Please Select Baggage',
            allowClear: true,
            width: '100%',
            ajax: {
                url: "{{ route('search.baggage') }}", // Replace with your actual server endpoint
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

    document.getElementById("pnr-form").addEventListener("submit", function (e) {
        e.preventDefault();

            const baggageIds = $('#baggage_id').val(); // ARRAY

    // Collect form values
        const formData = {
            // pnr_no: document.getElementById("pnr_no").value.trim(),
            departure_id: document.getElementById("departure_id").value.trim(),
            arrival_id: document.getElementById("arrival_id").value.trim(),
            airline_id: document.getElementById("airline_id").value.trim(),
            seats: document.getElementById("seats").value.trim(),
            baggage_id: baggageIds,
            departure_date: document.getElementById("departure_date").value,
            departure_time: document.getElementById("departure_time").value,
            arrival_date: document.getElementById("arrival_date").value,
            arrival_time: document.getElementById("arrival_time").value,
            baggage_id: document.getElementById("baggage_id").value.trim(),
            price: document.getElementById("price").value.trim(),
        };

        // Validation rules
        const validations = [
            // { field: "pnr_no", message: "PNR number is required", test: v => v !== "" },
            { field: "departure_id", message: "Please select an departure", test: v => v !== "" },
            { field: "arrival_id", message: "Please select an arrival", test: v => v !== "" },
            { field: "airline_id", message: "Please select an airline", test: v => v !== "" },
            { field: "baggage_id", message: "Please select an baggage", test: v => v !== "" },
            { field: "seats", message: "Seats field is required", test: v => v !== "" },
            { field: "departure_date", message: "Departure date is required", test: v => v !== "" },
            { field: "departure_time", message: "Departure time is required", test: v => v !== "" },
            { field: "arrival_date", message: "Arrival date is required", test: v => v !== "" },
            { field: "arrival_time", message: "Arrival time is required", test: v => v !== "" },
            { field: "price", message: "Price field is required", test: v => v !== "" },
            // File size ≤ 5MB
            // { 
            //     field: "pnr_file",
            //     message: "File size must be under 5MB",
            //     test: v => !v || v.size <= 5242880
            // },

            // // File type validation
            // {
            //     field: "pnr_file",
            //     message: "Invalid file format (JPG, PNG or JPEG only)",
            //     test: v => !v || /\.(png|jpg|jpeg)$/i.test(v.name)
            // }
        ];

        // Run validations
        for (const rule of validations) {
            if (!rule.test(formData[rule.field])) {
                showError(rule.message);
                return;
            }
        }

        // Show loading
        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading()
        });

        const newFormData = new FormData();
        newFormData.append("pnr_no", formData.pnr_no);
        newFormData.append("departure_id", formData.departure_id);
        newFormData.append("arrival_id", formData.arrival_id);
        newFormData.append("airline_id", formData.airline_id);
        newFormData.append("baggage_id", formData.baggage_id);
        newFormData.append("seats", formData.seats);
        newFormData.append("departure_date", formData.departure_date);
        newFormData.append("departure_time", formData.departure_time);
        newFormData.append("arrival_date", formData.arrival_date);
        newFormData.append("arrival_time", formData.arrival_time);
        // newFormData.append("pnr_file", formData.pnr_file);
        newFormData.append("price", formData.price);

        baggageIds.forEach(id => {
            newFormData.append("baggage_id[]", id);
        });

        console.log(newFormData);

        // Submit form normally after validation
        $.ajax({
            url: "{{ route('admin.pnr.store') }}",
            type: "POST",
            data: newFormData,
            processData: false, // IMPORTANT
            contentType: false, // IMPORTANT
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
                        window.location.href = "{{ route('admin.pnr.index') }}";
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

                showError(message);
            }
        });
    });
</script>

@endsection




