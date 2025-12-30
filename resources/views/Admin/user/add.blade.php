@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.user.index') }}" class="text-secondary text-decoration-none fs-4">
                ←
            </a>
            <h4 class="mb-0 fw-semibold">Create User</h4>
        </div>
    </div>

    <hr>

    <!-- Form Container -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form id="user-form">

                <div class="row g-4">

                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Name *</label>
                        <input type="text" name="name" id="name"
                               class="form-control"
                               placeholder="Enter Name">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email *</label>
                        <input type="text" name="email" id="email"
                               class="form-control"
                               placeholder="Enter Email Address">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Phone No *</label>
                        <input type="text" name="phone_no" id="phone_no"
                               class="form-control"
                               placeholder="Enter Phone No">
                    </div>

                    <!-- Password -->
                    <div class="col-md-6" x-data="{ show: false }">
                        <label class="form-label text-muted">Password *</label>
                        <div class="position-relative">
                            <input :type="show ? 'text' : 'password'"
                                   id="password"
                                   name="password"
                                   class="form-control pe-5"
                                   placeholder="*******">

                            <button type="button"
                                    class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                                    @click="show = !show">
                                <i class="fa" :class="show ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6" x-data="{ show: false }">
                        <label class="form-label text-muted">Confirm Password *</label>
                        <div class="position-relative">
                            <input :type="show ? 'text' : 'password'"
                                   id="confirm_password"
                                   name="confirm_password"
                                   class="form-control pe-5"
                                   placeholder="*******">

                            <button type="button"
                                    class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                                    @click="show = !show">
                                <i class="fa" :class="show ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status *</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1">Approved</option>
                            <option value="0">Pending Approval</option>
                            <option value="2">Suspended</option>
                        </select>
                    </div>

                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('admin.user.index') }}"
                       class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-dark px-4">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.getElementById("user-form").addEventListener("submit", function(e) {
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
        name: document.getElementById("name").value.trim(),
        email: document.getElementById("email").value.trim(),
        phone: document.getElementById("phone_no").value.trim(),
        password: document.getElementById("password").value.trim(),
        confirm_password: document.getElementById("confirm_password").value.trim(),
        status: document.getElementById("status").value.trim(),
    };

    const validations = [
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

    $.ajax({
        url: "{{ route('admin.user.store') }}",
        method: "POST",
        data: $('#user-form').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          Swal.fire({
              toast: true,
              position: "top-end",
              icon: "success",
              title: data.message,
              showConfirmButton: true,
              confirmButtonText: "OK"
          }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "{{ route('admin.user.index') }}";
              }
          });
        },
        error: function (xhr) {
            Swal.close();
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: xhr.responseJSON?.message ?? 'Something went wrong',
                showConfirmButton: false,
                timer: 2500
            });
        }
    });
});
</script>
@endsection
