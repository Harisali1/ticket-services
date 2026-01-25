@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container-fluid bg-light min-vh-100 py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.agency.index') }}"
               class="text-secondary text-decoration-none fs-5">
                ←
            </a>
            <h4 class="mb-0 fw-semibold">Edit AirLine</h4>
        </div>
    </div>

    <hr>

    <!-- Form Container -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form id="airline-form-update" enctype="multipart/form-data">
                <!-- AirLine Details -->
                <div class="mb-5">
                    <h5 class="fw-semibold mb-4">AirLine Details</h5>

                    <div class="row g-4">

                        <!-- Name -->
                        <div class="col-md-4"> 
                          <input type="hidden"
                              name="id"
                              id="id"
                              value="{{ $airline->id }}"
                              class="form-control bg-light">
                            <label class="form-label text-muted">Name *</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $airline->name) }}"
                                   class="form-control bg-light"
                                   required>
                        </div>

                        <!-- Code -->
                        <div class="col-md-4">
                            <label class="form-label text-muted">Code *</label>
                            <input type="text"
                                   name="code"
                                   id="code"
                                   value="{{ old('code', $airline->code) }}"
                                   class="form-control bg-light"
                                   required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label for="status1" class="form-label">Status</label>
                            <select name="status1" id="status1" class="form-select">
                                @foreach(\App\Enums\AirLineStatus::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        @selected(old('status', $airline->status->value) == $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Logo -->
                        <div class="col-md-6">
                            <label class="form-label">AirLine Logo</label>

                            <div class="d-flex align-items-center gap-3">
                                <!-- Preview -->
                                <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                                     style="width: 90px; height: 90px;">
                                    <img id="logoPreview"
                                         src="{{ $airline->logo
                                                ? asset('storage/'.$airline->logo)
                                                : asset('images/logo-placeholder.png') }}"
                                         class="img-fluid"
                                         style="max-height: 80px;">
                                </div>

                                <!-- Upload -->
                                <div>
                                    <input type="file"
                                           name="logo"
                                           id="logo"
                                           class="form-control"
                                           accept="image/*"
                                           onchange="previewLogo(this)">
                                    <small class="text-muted">
                                        JPG / PNG • Max 2MB
                                    </small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.airline.index') }}"
                       class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-dark px-4">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("airline-form-update");
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
        const status = document.getElementById("status1").value;
        const logo   = document.getElementById("logo").files[0] ?? null;

        if (!name) { showError("Airline name is required"); return; }
        if (!code) { showError("Airline code is required"); return; }
        if (code.length < 2) { showError("Airline code must be at least 2 characters"); return; }
        if (!status) { showError("Status is required"); return; }
        // if (!logo) { showError("Airline logo is required"); return; }

        // const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        // if (!allowedTypes.includes(logo.type)) { showError("Logo must be JPG or PNG"); return; }
        // if (logo.size > 2097152) { showError("Logo size must be less than 2MB"); return; }

        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.airline.update') }}",
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
