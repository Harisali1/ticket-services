@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container-fluid bg-light min-vh-100 py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.user.index') }}" class="text-secondary text-decoration-none fs-4">
                ←
            </a>
            <h4 class="mb-0 fw-semibold">Edit User</h4>
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
                      <input type="hidden" name="id" id="id"
                               class="form-control"
                               value="{{ $user->id }}">

                        <label class="form-label text-muted">Name *</label>
                        <input type="text" name="name" id="name"
                               class="form-control"
                               value="{{ $user->name }}"
                               placeholder="Enter Name">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email *</label>
                        <input type="text" name="email" id="email"
                              value="{{ $user->email }}"
                              class="form-control"
                              placeholder="Enter Email Address">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Phone No *</label>
                        <input type="text" name="phone_no" id="phone_no"
                              value="{{ $user->phone_no }}"
                              class="form-control"
                              placeholder="Enter Phone No">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                      <label class="form-label">Status</label>
                      <select name="status" id="status" class="form-select">
                        @foreach(\App\Enums\UserStatus::cases() as $status)
                          <option value="{{ $status->value }}" @selected($user->status === $status)>
                            {{ $status->label() }}
                          </option>
                        @endforeach
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
        status: document.getElementById("status").value.trim(),
    };

    const validations = [
        { field: "name", message: "Name is required", test: v => v !== "" },
        { field: "email", message: "Email is required", test: v => v !== "" },
        { field: "email", message: "Invalid email format", test: v => /^\S+@\S+\.\S+$/.test(v) },
        { field: "phone", message: "Phone must be at least 11 digits", test: v => v.length >= 11 },
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
        url: "{{ route('admin.user.update') }}",
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
          });
          window.location.href = "{{ route('admin.user.index') }}";
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
