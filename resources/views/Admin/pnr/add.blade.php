@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="min-h-screen bg-gray-100">

    <!-- Top Bar -->
    <div class="bg-gray-200 px-6 py-3 flex items-center justify-between">
        <h2 class="font-semibold text-gray-700">Basic Details</h2>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto p-6">

        <!-- Form Grid -->
        <form id="pnr-form" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- PNR -->
            <div>
                <label class="text-sm text-gray-600">PNR Number*</label>
                <input type="text" id="pnr_no" name="pnr_no"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Baggage -->
            <div>
                <label class="text-sm text-gray-600">Baggage</label>
                <select class="mt-1 w-full border rounded-md p-3">
                    <option>Select option</option>
                </select>
            </div>
            
            <!-- Airline -->
            <div>
                <label class="text-sm text-gray-600">Airline</label>
                <select class="mt-1 w-full border rounded-md p-3" id="airline_id" name="airline_id">
                    <option value="1">PIA</option>
                </select>
            </div>

            <!-- Seats -->
            <div>
                <label class="text-sm text-gray-600">Seats</label>
                <input type="number" id="seats" name="seats"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Departure Date -->
            <div>
                <label class="text-sm text-gray-600">Departure Date*</label>
                <input type="date" id="departure_date" name="departure_date" 
                        class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Departure Time -->
            <div>
                <label class="text-sm text-gray-600">Departure Time*</label>
                <input type="time" id="departure_time" name="departure_time"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Arrival Date -->
            <div>
                <label class="text-sm text-gray-600">Arrival Date*</label>
                <input type="date" id="arrival_date" name="arrival_date"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Arrival Time -->
            <div>
                <label class="text-sm text-gray-600">Arrival Time*</label>
                <input type="time" id="arrival_time" name="arrival_time"
                       class="mt-1 w-full border rounded-md p-3">
            </div>
        </div>

        <!-- Upload Section -->
        <div class="mt-8">
            <h3 class="font-semibold text-gray-700 mb-3">
                Upload PNR Document
            </h3>

            <div id="pnr-dropzone"
                class="border-2 border-dashed rounded-lg p-8 bg-white flex items-center justify-between cursor-pointer">

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 border rounded flex items-center justify-center text-xl">
                        📄
                    </div>

                    <div>
                        <p id="pnr-filename" class="text-gray-600">
                            Click or drop file here
                        </p>
                        <p class="text-xs text-gray-400">
                            PDF, XLS, XLSX, CSV (Max 5MB)
                        </p>
                    </div>
                </div>

                <button type="button"
                        id="pnr-remove"
                        class="hidden text-gray-500 hover:text-red-500 text-xl">
                    🗑
                </button>

                <input type="file"
                    id="pnr_file"
                    name="pnr_file"
                    class="hidden"
                    accept=".pdf,.xls,.xlsx,.csv">
            </div>
        </div>


        <!-- Footer Buttons -->
        <div class="flex justify-end gap-4 mt-10">
            <button class="px-6 py-2 border rounded-md bg-white">
                Cancel
            </button>
            <button class="px-6 py-2 bg-black text-white rounded-md">
                Save
            </button>
        </div>
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
            'application/pdf',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/csv'
        ];

        dropzone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function () {
            if (!this.files.length) return;
            const file = this.files[0];
            if (!allowedTypes.includes(file.type)) {
                showError('Only PDF, Excel or CSV allowed');
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
</script>
<script>
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
            message: "Invalid file format (PDF, XLS, XLSX, CSV only)",
            test: v => !v || /\.(pdf|xls|xlsx|csv)$/i.test(v.name)
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




