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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- PNR -->
            <div>
                <label class="text-sm text-gray-600">PNR Number*</label>
                <input type="text" value="XJ7K2M"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Baggage -->
            <div>
                <label class="text-sm text-gray-600">Baggage</label>
                <select class="mt-1 w-full border rounded-md p-3">
                    <option>Checked Baggage's, Carry-On</option>
                </select>
            </div>

            <!-- Seats -->
            <div>
                <label class="text-sm text-gray-600">Seats</label>
                <select class="mt-1 w-full border rounded-md p-3">
                    <option>40</option>
                </select>
            </div>

            <!-- Airline -->
            <div>
                <label class="text-sm text-gray-600">Airline</label>
                <select class="mt-1 w-full border rounded-md p-3">
                    <option>PIA</option>
                </select>
            </div>

            <!-- Departure Date -->
            <div>
                <label class="text-sm text-gray-600">Departure Date*</label>
                <input type="date"
                       value="2025-12-08"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Departure Time -->
            <div>
                <label class="text-sm text-gray-600">Departure Time*</label>
                <input type="text"
                       value="11:00 am GMT"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Arrival Date -->
            <div>
                <label class="text-sm text-gray-600">Arrival Date*</label>
                <input type="date"
                       value="2025-12-08"
                       class="mt-1 w-full border rounded-md p-3">
            </div>

            <!-- Arrival Time -->
            <div>
                <label class="text-sm text-gray-600">Arrival Time*</label>
                <input type="text"
                       value="11:00 am GMT"
                       class="mt-1 w-full border rounded-md p-3">
            </div>
        </div>

        <!-- Upload Section -->
        <div class="mt-8">
            <h3 class="font-semibold text-gray-700 mb-3">
                Upload PNR Document
            </h3>

            <div class="border-2 border-dashed rounded-lg p-8 bg-white flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 border rounded flex items-center justify-center">
                        📄
                    </div>
                    <span class="text-gray-600">PNRList.exe</span>
                </div>

                <button class="text-gray-500 hover:text-red-500">
                    🗑
                </button>
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

    </div>
</div>

@endsection

@section('scripts')
  <script>
    document.getElementById("agency-form").addEventListener("submit", function(e) {
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

        const formData = {
            agency_name: document.getElementById("agency_name").value.trim(),
            piv: document.getElementById("piv").value.trim(),
            agency_address: document.getElementById("agency_address").value.trim(),
            name: document.getElementById("name").value.trim(),
            email: document.getElementById("email").value.trim(),
            phone: document.getElementById("phone_no").value.trim(),
            password: document.getElementById("password").value.trim(),
            confirm_password: document.getElementById("confirm_password").value.trim(),
            status: document.getElementById("status").value.trim(),
        };

        const validations = [
            { field: "agency_name", message: "Agency name is required", test: v => v !== "" },
            { field: "piv", message: "P.IVA is required", test: v => v !== "" },
            { field: "agency_address", message: "Agency address is required", test: v => v !== "" },
            { field: "name", message: "Name is required", test: v => v !== "" },
            { field: "email", message: "Email is required", test: v => v !== "" },
            { field: "email", message: "Invalid email format", test: v => /^\S+@\S+\.\S+$/.test(v) },
            { field: "phone", message: "Phone must be at least 11 digits", test: v => v.length >= 11 },
            { field: "password", message: "Password must be 6+ characters", test: v => v.length >= 6 },
            { field: "confirm_password", message: "Passwords do not match", test: v => v === formData.password },
            { field: "status", message: "Status is required", test: v => v !== "" },
        ];

        for (const rule of validations) {
            if (!rule.test(formData[rule.field])) {
                showError(rule.message);
                return;
            }
        }

        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading()
        });

        var data = $('#agency-form').serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('admin.agency.store') }}",
            method: "POST",
            data: data,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function(){
                $('.error-container').html('');
            },
            success: function () {
                window.location.href = "{{ route('admin.agency.index') }}";
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
            }
        });
    });
  </script>
@endsection




