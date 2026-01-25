@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container py-5">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.agency.index') }}" class="text-decoration-none text-secondary">
        &larr;
      </a>
      <h1 class="h4 mb-0">View Agency Details</h1>
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
                 class="form-control" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">P.IVA*</label>
          <input type="text" name="piv" id="piv"
                 value="{{ $agency->piv }}"
                 class="form-control" readonly>
        </div>
      </div>

      <div class="mt-3">
        <label class="form-label">Agency Address*</label>
        <input type="text" name="agency_address" id="agency_address"
               value="{{ $agency->address }}"
               class="form-control" readonly>
      </div>

      <!-- User Details -->
      <h5 class="mt-4 mb-3">User Details</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Name*</label>
          <input type="text" name="name" id="name"
                 value="{{ $agency->user->name }}"
                 class="form-control" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Email*</label>
          <input type="email" name="email" id="email"
                 value="{{ $agency->user->email }}"
                 class="form-control" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Phone No*</label>
          <input type="text" name="phone_no" id="phone_no"
                 value="{{ $agency->user->phone_no }}"
                 class="form-control" readonly>
        </div>

        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status" id="status" class="form-select" disabled>
            @foreach(\App\Enums\AgencyStatus::cases() as $status)
              <option value="{{ $status->value }}" @selected($agency->status === $status)>
                {{ $status->label() }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection

@section('scripts')
<!-- No scripts required for readonly view -->
@endsection
