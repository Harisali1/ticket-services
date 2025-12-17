@extends('Admin.layouts.main')

@section('content')
<div class="p-6 space-y-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.airline.index') }}" class="text-gray-600 hover:text-black">←</a>
            <h1 class="text-2xl font-semibold">Add AirLine</h1>
        </div>
    </div>

    <hr />

    <!-- Form -->
    <div class="bg-white border rounded-lg p-6 space-y-10">
        <form id="airline-form" enctype="multipart/form-data">
            <!-- Airline Details -->
            <div>
                <h2 class="font-semibold text-lg mb-4">AirLine Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Name *</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               placeholder="Enter Airline Name"
                               class="w-full border rounded-md p-3 bg-gray-50">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Code -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Code *</label>
                        <input type="text"
                               name="code"
                               id="code"
                               value="{{ old('code') }}"
                               placeholder="Airline Code"
                               class="w-full border rounded-md p-3 bg-gray-50">
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                      <label class="block text-sm text-gray-600 mb-1">Status</label>
                      <select name="status" id="status"
                          class="w-full border rounded-md p-3 bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-400">
                          <option value="1">Approved</option>
                          <option value="0">Pending Approval</option>
                          <option value="2">Suspended</option>
                      </select>
                    </div>    
                </div>

                <!-- Logo Upload -->
                <div class="mt-6">
                    <label class="block text-sm text-gray-600 mb-2">Airline Logo</label>

                    <div class="flex items-center gap-6">
                        <!-- Preview -->
                        <div class="w-24 h-24 border rounded-md bg-gray-50 flex items-center justify-center overflow-hidden">
                            <img id="logoPreview"
                                 src="{{ asset('images/logo-placeholder.png') }}"
                                 class="w-full h-full object-contain">
                        </div>

                        <!-- Upload -->
                        <div>
                            <input type="file"
                                   name="logo"
                                   id="logo"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewLogo(this)">

                            <label for="logo"
                                   class="cursor-pointer px-4 py-2 border rounded-md bg-white hover:bg-gray-100 inline-flex items-center gap-2">
                                Upload Logo
                            </label>

                            <p class="text-xs text-gray-500 mt-2">
                                JPG / PNG • Max 2MB
                            </p>

                            @error('logo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.airline.index') }}"
                   class="border border-gray-400 px-5 py-2 rounded-md">
                    Cancel
                </a>

                <button class="bg-black text-white px-5 py-2 rounded-md">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("airline-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const showError = (message) => {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: message,
                showConfirmButton: false,
                timer: 2500
            });
        };

        /* ============================
           Get Form Values
        ============================ */
        const name   = document.getElementById("name").value.trim();
        const code   = document.getElementById("code").value.trim();
        const status = document.getElementById("status").value;
        const logo   = document.getElementById("logo").files[0] ?? null;

        /* ============================
           Client Side Validation
        ============================ */

        if (!name) {
            showError("Airline name is required");
            return;
        }

        if (!code) {
            showError("Airline code is required");
            return;
        }

        if (code.length < 2) {
            showError("Airline code must be at least 2 characters");
            return;
        }

        if (!status) {
            showError("Status is required");
            return;
        }

        if (!logo) {
            showError("Airline logo is required");
            return;
        }

        const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowedTypes.includes(logo.type)) {
            showError("Logo must be a JPG or PNG image");
            return;
        }

        if (logo.size > 2097152) { // 2MB
            showError("Logo size must be less than 2MB");
            return;
        }

        /* ============================
           Show Loading
        ============================ */
        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        /* ============================
           Prepare FormData
        ============================ */
        const formData = new FormData(form);

        /* ============================
           AJAX Submit
        ============================ */
        $.ajax({
            url: "{{ route('admin.airline.store') }}",
            type: "POST",
            data: formData,
            processData: false, // IMPORTANT
            contentType: false, // IMPORTANT
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.close();
                window.location.href = "{{ route('admin.airline.index') }}";
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
});
</script>
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('logoPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


@endsection
