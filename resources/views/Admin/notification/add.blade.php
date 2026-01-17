@extends('Admin.layouts.main')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.airport.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Add Airport</h1>
        </div>
    </div>

    <hr>

    <!-- Form -->
    <div class="card p-4">
        <form id="airport-form" enctype="multipart/form-data">
            
            <!-- airport Details -->
            <h5 class="mb-3">Airport Details</h5>

            <div class="row g-3 mb-4">
                <!-- Name -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           placeholder="Enter airport Name" class="form-control">
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Code -->
                <div class="col-md-4">
                    <label for="code" class="form-label">Code *</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                           placeholder="airport Code" class="form-control">
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

            <!-- Actions -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.airport.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-dark">Save</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("airport-form");
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

        if (!name) { showError("airport name is required"); return; }
        if (!code) { showError("airport code is required"); return; }
        if (code.length < 2) { showError("airport code must be at least 2 characters"); return; }
        if (!status) { showError("Status is required"); return; }

        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.airport.store') }}",
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
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.airport.index') }}"; 
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
});

</script>
@endsection
