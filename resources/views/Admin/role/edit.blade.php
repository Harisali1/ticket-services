@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container-fluid bg-light min-vh-100 py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.airport.index') }}"
               class="text-secondary text-decoration-none fs-5">
                ←
            </a>
            <h4 class="mb-0 fw-semibold">Edit Airport</h4>
        </div>
    </div>

    <hr>

    <!-- Form Container -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form id="airport-form-update" enctype="multipart/form-data">
                <!-- AirLine Details -->
                <div class="mb-5">
                    <h5 class="fw-semibold mb-4">AirPort Details</h5>

                    <div class="row g-4">

                        <!-- Name -->
                        <div class="col-md-4"> 
                          <input type="hidden"
                              name="id"
                              id="id"
                              value="{{ $airport->id }}"
                              class="form-control bg-light">
                            <label class="form-label text-muted">Name *</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $airport->name) }}"
                                   class="form-control bg-light"
                                   required>
                        </div>

                        <!-- Code -->
                        <div class="col-md-4">
                            <label class="form-label text-muted">Code *</label>
                            <input type="text"
                                   name="code"
                                   id="code"
                                   value="{{ old('code', $airport->code) }}"
                                   class="form-control bg-light"
                                   required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label for="status1" class="form-label">Status</label>
                            <select name="status1" id="status1" class="form-select">
                                @foreach(\App\Enums\AirportStatus::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        @selected(old('status', $airport->status->value) == $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.airport.index') }}"
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
    const form = document.getElementById("airport-form-update");
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

        if (!name) { showError("Airport name is required"); return; }
        if (!code) { showError("Airport code is required"); return; }
        if (code.length < 2) { showError("Airport code must be at least 2 characters"); return; }
        if (!status) { showError("Status is required"); return; }

        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.airport.update') }}",
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
                window.location.href = "{{ route('admin.airport.index') }}";  
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
