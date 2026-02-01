@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.agency.index') }}" class="text-decoration-none text-secondary">
        &larr;
      </a>
      <h1 class="h4 mb-0">{{__('messages.update_agency')}}</h1>
    </div>
  </div>

  <hr>

  <!-- Form Container -->
  <div class="card p-4">
    <form id="agency-form">
      <!-- Agency Details -->
      <h5 class="mb-3">{{ __('messages.agency_detail') }}</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <input type="hidden" value="{{ $agency->id }}" id="id" name="id">
          <label class="form-label">{{ __('messages.agency_name') }}*</label>
          <input type="text" name="agency_name" id="agency_name" 
                 value="{{ $agency->name }}" 
                 class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">{{ __('messages.piva') }}*</label>
          <input type="text" name="piv" id="piv" 
                 value="{{ $agency->piv }}" 
                 class="form-control">
        </div>
        <div class="mt-3 col-md-6">
          <label class="form-label">{{ __('messages.agency_address') }}*</label>
          <input type="text" name="agency_address" id="agency_address" 
                value="{{ $agency->address }}" 
                class="form-control">
        </div>

        <div class="mt-3 col-md-6">
          <label class="form-label">{{ __('messages.postal_code') }}</label>
          <input type="text" name="postal_code" id="postal_code" 
            class="form-control" value="{{ $agency->postal_code }}">
        </div>

        <div class="mt-3 col-md-6">
          <label class="form-label">{{ __('messages.city') }}</label>
          <input type="text" name="city" id="city"
              class="form-control" value="{{ $agency->city }}">
        </div>

        <div class="mt-3 col-md-6">
          <label class="form-label">{{ __('messages.country') }}</label>
          <input type="text" name="country" id="country"
          class="form-control" value="{{ $agency->country }}">
        </div>
      </div>

      
      
      <!-- User Details -->
      <h5 class="mt-4 mb-3">{{ __('messages.user_details') }}</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">{{ __('messages.name') }}*</label>
          <input type="text" name="name" id="name" 
                 value="{{ $agency->user->name }}" 
                 class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">{{ __('messages.email') }}*</label>
          <input type="email" name="email" id="email" 
                 value="{{ $agency->user->email }}" 
                 class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">{{ __('messages.phone_no') }}*</label>
            <input 
                type="text"
                name="phone_no"
                id="phone_no"
                placeholder="Enter Phone No #"
                class="form-control"
                value="{{ $agency->user->phone_no }}"
                inputmode="numeric"
                autocomplete="tel"
            >
        </div>
        
        @if(Auth::user()->user_type_id == '2')
          <div class="col-md-6">
            <label class="form-label">{{ __('messages.mark_up') }}</label>
            <input type="text" name="mark_up" id="mark_up" placeholder="Enter Any Mark Up" class="form-control" value="{{ $agency->mark_up }}">
          </div>
        @endif
      
        @if(Auth::user()->user_type_id == '1' || Auth::user()->user_type_id == '3')
          <div class="col-md-6">
            <label class="form-label">{{ __('messages.status') }}</label>
            <select name="status" id="status" class="form-select">
              @foreach(\App\Enums\AgencyStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected($agency->status === $status)>
                  {{ $status->label() }}
                </option>
              @endforeach
            </select>
          </div>
        @endif
        @if(Auth::user()->user_type_id == '1')
          <div class="col-md-6">
            <label class="form-label">{{ __('messages.limit_amount_for_booking') }}</label>
            <input type="text" name="limit" id="limit" placeholder="EUR 100/=" class="form-control" value="{{ $agency->limit }}">
          </div>
        @endif
      </div>

      <!-- Form Actions -->
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.agency.index') }}" class="btn btn-outline-secondary">{{ __('messages.cancel')}}</a>
        <button class="btn btn-dark">{{__('messages.update')}}</button>
      </div>

    </form>
  </div>

</div>
@endsection

@section('scripts')
<script>
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
    };

    const validations = [
      { field: "agency_name", message: "Agency name is required", test: v => v !== "" },
      { field: "piv", message: "P.IVA is required", test: v => v !== "" },
      { field: "agency_address", message: "Agency address is required", test: v => v !== "" },
      { field: "name", message: "Name is required", test: v => v !== "" },
      { field: "email", message: "Email is required", test: v => v !== "" },
      { field: "email", message: "Invalid email format", test: v => /^\S+@\S+\.\S+$/.test(v) },
      { field: "phone", message: "Phone no required", test: v => v !== '' },
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

    // var params = new URLSearchParams(data);
    // var id = params.get('id');
    // console.log(id); // 6

    $.ajax({
      url: "{{ route('admin.agency.update') }}",
      method: "POST",
      data: data,
      dataType: 'json',
      success: function (data) {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: data.message,
            showConfirmButton: true,
            confirmButtonText: "OK"
        });
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
