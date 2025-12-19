@extends('Admin.layouts.main')

@section('styles')
  <!-- Font Awesome for eye icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
@endsection

@section('content')
<div class="container py-4">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.agency.index') }}" class="text-decoration-none text-secondary">
        &larr;
      </a>
      <h1 class="h4 mb-0">Update Agency</h1>
    </div>
  </div>

  <hr>

  <!-- Form Container -->
  <div class="card p-4">
    <form id="agency-form">

      <!-- Agency Details -->
      <h5 class="mb-3">Agency Details</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Agency Name*</label>
          <input type="text" name="agency_name" id="agency_name" 
                 value="{{ $agency->name }}" 
                 class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">P.IVA*</label>
          <input type="text" name="piv" id="piv" 
                 value="{{ $agency->piv }}" 
                 class="form-control">
        </div>
      </div>

      <div class="mt-3">
        <label class="form-label">Agency Address*</label>
        <input type="text" name="agency_address" id="agency_address" 
               value="{{ $agency->address }}" 
               class="form-control">
      </div>

      <!-- User Details -->
      <h5 class="mt-4 mb-3">User Details</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Name*</label>
          <input type="text" name="name" id="name" 
                 value="{{ $agency->user->name }}" 
                 class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">Email*</label>
          <input type="email" name="email" id="email" 
                 value="{{ $agency->user->email }}" 
                 class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">Phone No*</label>
          <input type="text" name="phone_no" id="phone_no" 
                 value="{{ $agency->user->phone_no }}" 
                 class="form-control">
        </div>

        <!-- Password -->
        <div class="col-md-6 position-relative">
          <label class="form-label">Password*</label>
          <input type="password" name="password" id="password" 
                 placeholder="*******" class="form-control pr-5">
          <button type="button" class="btn btn-outline-secondary position-absolute top-0 end-0 mt-2 me-2" 
                  onclick="togglePassword('password', this)">
            <i class="fa fa-eye"></i>
          </button>
        </div>

        <div class="col-md-6 position-relative">
          <label class="form-label">Confirm Password*</label>
          <input type="password" name="confirm_password" id="confirm_password" 
                 placeholder="*******" class="form-control pr-5">
          <button type="button" class="btn btn-outline-secondary position-absolute top-0 end-0 mt-2 me-2" 
                  onclick="togglePassword('confirm_password', this)">
            <i class="fa fa-eye"></i>
          </button>
        </div>

        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" id="status" class="form-select">
            @foreach(\App\Enums\AgencyStatus::cases() as $status)
              <option value="{{ $status->value }}" @selected($agency->status === $status)>
                {{ $status->label() }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.agency.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button class="btn btn-dark">Save</button>
      </div>

    </form>
  </div>

</div>
@endsection

@section('scripts')
<script>
  // Toggle password visibility
  function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = "password";
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }

  // Form validation & AJAX submit
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
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.ajax({
      url: "{{ route('admin.agency.update') }}",
      method: "POST",
      data: data,
      dataType: 'json',
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
