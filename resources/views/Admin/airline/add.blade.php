@extends('Admin.layouts.main')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.airline.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Add AirLine</h1>
        </div>
    </div>

    <hr>

    <!-- Form -->
    <div class="card p-4">
        <form id="airline-form" enctype="multipart/form-data">
            
            <!-- Airline Details -->
            <h5 class="mb-3">AirLine Details</h5>

            <div class="row g-3 mb-4">
                <!-- Name -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           placeholder="Enter Airline Name" class="form-control">
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Code -->
                <div class="col-md-4">
                    <label for="code" class="form-label">Code *</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                           placeholder="Airline Code" class="form-control">
                    @error('code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="2">DeActive</option>
                    </select>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="mb-4">
                <label class="form-label">Airline Logo</label>
                <div class="d-flex align-items-center gap-3">
                    <!-- Preview -->
                    <div class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width:96px; height:96px;">
                        <img id="logoPreview" src="{{ asset('images/logo-placeholder.png') }}" class="img-fluid">
                    </div>

                    <!-- Upload -->
                    <div>
                        <input type="file" name="logo" id="logo" accept="image/*" class="d-none" onchange="previewLogo(this)">
                        <label for="logo" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                            Upload Logo
                        </label>
                        <div class="small text-muted mt-1">JPG / PNG • Max 2MB</div>
                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.airline.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-dark">Save</button>
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

        const name   = document.getElementById("name").value.trim();
        const code   = document.getElementById("code").value.trim();
        const status = document.getElementById("status").value;
        const logo   = document.getElementById("logo").files[0] ?? null;

        if (!name) { showError("Airline name is required"); return; }
        if (!code) { showError("Airline code is required"); return; }
        if (code.length < 2) { showError("Airline code must be at least 2 characters"); return; }
        if (!status) { showError("Status is required"); return; }
        if (!logo) { showError("Airline logo is required"); return; }

        const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowedTypes.includes(logo.type)) { showError("Logo must be JPG or PNG"); return; }
        if (logo.size > 2097152) { showError("Logo size must be less than 2MB"); return; }

        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.airline.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
                });
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

// Logo Preview
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { document.getElementById('logoPreview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
