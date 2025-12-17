@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="p-6 space-y-6 bg-gray-50 min-h-screen">

  <!-- Header -->
  <div class="flex justify-between items-center">
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.agency.index') }}" class="text-gray-600 hover:text-black">
        ←
      </a>
      <h1 class="text-2xl font-semibold">Update Agency</h1>
    </div>
  </div>

  <hr />

  <!-- Form Container -->
  <div class="bg-white border rounded-lg p-6 space-y-10">

    <form id="agency-form">
    <!-- Agency Details -->
      <div>
        <h2 class="font-semibold text-lg mb-4">Agency Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Agency Name -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Agency Name*</label>
            <input type="text" placeholder="Enter Agency Name" name="agency_name" id="agency_name"
              value="{{ $agency->name }}"
              class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- P.IVA -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">P.IVA *</label>
            <input type="text" name="piv" id="piv" placeholder="Enter Code" 
            value="{{ $agency->piv }}"
            class="w-full border rounded-md p-3 bg-gray-50" />
          </div>
        </div>

        <!-- Address -->
        <div class="mt-6">
          <label class="block text-sm text-gray-600 mb-1">Agency Address*</label>
          <input type="text" name="agency_address" id="agency_address" placeholder="Enter Address" 
          value="{{ $agency->address }}"
          class="w-full border rounded-md p-3 bg-gray-50" />
        </div>
      </div>

    <!-- User Details -->
      <div>
        <h2 class="font-semibold text-lg mb-4 mt-4">User Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Name -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Name*</label>
            <input type="text" name="name" id="name" placeholder="Enter Name" 
            value="{{ $agency->user->name }}"
            class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Email*</label>
            <input type="text" name="email" id="email" placeholder="Enter Email Address" 
            value="{{ $agency->user->email }}"
            class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- Phone -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Phone No*</label>
            <input type="text" name="phone_no" id="phone_no" placeholder="Enter Phone No #" 
            value="{{ $agency->user->phone_no }}"
            class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- Password -->
          <div class="relative">
            <label class="block text-sm text-gray-600 mb-1">Password*</label>
            <input type="password"name="password" id="password" placeholder="*******" class="w-full border rounded-md p-3 bg-gray-50 pr-10" />

            <button class="absolute right-3 top-10 text-gray-500 hover:text-black">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.708.042C20.88 7.943 16.884 5 12 5 7.115 5 3.12 7.943 2.292 12.042c-.06.29-.06.627 0 .916C3.12 16.057 7.115 19 12 19c4.884 0 8.88-2.943 9.708-6.042.06-.289.06-.626 0-.916z" />
              </svg>
            </button>
          </div>

          <div class="relative">
            <label class="block text-sm text-gray-600 mb-1">Confirm Password*</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="*******" class="w-full border rounded-md p-3 bg-gray-50 pr-10" />

            <button class="absolute right-3 top-10 text-gray-500 hover:text-black">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.708.042C20.88 7.943 16.884 5 12 5 7.115 5 3.12 7.943 2.292 12.042c-.06.29-.06.627 0 .916C3.12 16.057 7.115 19 12 19c4.884 0 8.88-2.943 9.708-6.042.06-.289.06-.626 0-.916z" />
              </svg>
            </button>
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>

            <select name="status" id="status"
                class="w-full border rounded-md p-3 bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-400">

                @foreach(\App\Enums\AgencyStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                        @selected($agency->status === $status)>
                        {{ $status->label() }}
                    </option>
                @endforeach

            </select>
          </div>




        </div>
        <div class="flex justify-end gap-3 mt-10">
            <a href="{{ route('admin.agency.index') }}" class="border border-gray-400 px-5 py-2 rounded-md">Cancel</a>
            <button class="bg-black text-white px-5 py-2 rounded-md">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
  <script>
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
            // status: document.getElementById("status").value.trim(),
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
            // { field: "status", message: "Status is required", test: v => v !== "" },
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('admin.agency.update') }}",
            method: "POST",
            data: data,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function(){
                $('.error-container').html('');
            },
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




