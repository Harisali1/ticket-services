@extends('Admin.layouts.main')

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
        <form id="pnr-form" enctype="multipart/form-data">
            <h5 class="mb-3">Search Pnr</h5>
            <!-- Grid -->
             <hr>
            <div class="row g-3">

                <!-- Baggage -->
                <div class="col-md-2">
                    <label class="form-label text-muted">Departure</label>
                    <select class="form-select">
                        <option>Select option</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted">Arrival</label>
                    <select class="form-select">
                        <option>Select option</option>
                    </select>
                </div>

                <!-- Departure Date -->
                <div class="col-md-2">
                    <label class="form-label text-muted">Departure Date *</label>
                    <input type="date" id="departure_date" name="departure_date" class="form-control">
                </div>
                <!-- Arrival Date -->
                <div class="col-md-2">
                    <label class="form-label text-muted">Arrival Date *</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="form-control">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark">
                        Save
                    </button>
                </div>
            </div>


            <!-- Footer Buttons -->
            

        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
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

    document.addEventListener("DOMContentLoaded", function () {
        const dropzone = document.getElementById('pnr-dropzone');
        const fileInput = document.getElementById('pnr_file');
        const fileName  = document.getElementById('pnr-filename');
        const removeBtn = document.getElementById('pnr-remove');
        const allowedTypes = [
            'image/jpeg',
            'image/png'
        ];

        dropzone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function () {
            if (!this.files.length) return;
            const file = this.files[0];
            if (!allowedTypes.includes(file.type)) {
                showError('Only JPG, JPEG or PNG images are allowed');
                this.value = '';
                return;
            }

            if (file.size > 5242880) { // 5MB
                showError('Max file size is 5MB');
                this.value = '';
                return;
            }

            fileName.textContent = file.name;
            removeBtn.classList.remove('hidden');
        });

        /* ============================
        Drag & Drop
        ============================ */
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('border-black');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-black');
        });

        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('border-black');

            const file = e.dataTransfer.files[0];
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        });

        /* ============================
        Remove File
        ============================ */
        removeBtn.addEventListener('click', e => {
            e.stopPropagation();
            fileInput.value = '';
            fileName.textContent = 'Click or drop file here';
            removeBtn.classList.add('hidden');
        });

    });

    document.getElementById("pnr-form").addEventListener("submit", function (e) {
        e.preventDefault();

    // Collect form values
        const formData = {
            pnr_no: document.getElementById("pnr_no").value.trim(),
            airline_id: document.getElementById("airline_id").value.trim(),
            seats: document.getElementById("seats").value.trim(),
            departure_date: document.getElementById("departure_date").value,
            departure_time: document.getElementById("departure_time").value,
            arrival_date: document.getElementById("arrival_date").value,
            arrival_time: document.getElementById("arrival_time").value,
            pnr_file: document.getElementById("pnr_file").files[0] ?? null,
        };

        // Validation rules
        const validations = [
            { field: "pnr_no", message: "PNR number is required", test: v => v !== "" },
            { field: "airline_id", message: "Please select an airline", test: v => v !== "" },
            { field: "seats", message: "Seats field is required", test: v => v !== "" },
            { field: "departure_date", message: "Departure date is required", test: v => v !== "" },
            { field: "departure_time", message: "Departure time is required", test: v => v !== "" },
            { field: "arrival_date", message: "Arrival date is required", test: v => v !== "" },
            { field: "arrival_time", message: "Arrival time is required", test: v => v !== "" },
            { field: "pnr_file", message: "PNR document is required", test: v => v !== null },

            // File size ≤ 5MB
            { 
                field: "pnr_file",
                message: "File size must be under 5MB",
                test: v => !v || v.size <= 5242880
            },

            // File type validation
            {
                field: "pnr_file",
                message: "Invalid file format (JPG, PNG or JPEG only)",
                test: v => !v || /\.(png|jpg|jpeg)$/i.test(v.name)
            }
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
        newFormData.append("airline_id", formData.airline_id);
        newFormData.append("seats", formData.seats);
        newFormData.append("departure_date", formData.departure_date);
        newFormData.append("departure_time", formData.departure_time);
        newFormData.append("arrival_date", formData.arrival_date);
        newFormData.append("arrival_time", formData.arrival_time);
        newFormData.append("pnr_file", formData.pnr_file);

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
            success: function (response) {
                Swal.close();
                window.location.href = "{{ route('admin.pnr.index') }}";
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




