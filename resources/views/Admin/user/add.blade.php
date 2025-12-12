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
      <h1 class="text-2xl font-semibold">Create User</h1>
    </div>

    <!-- <button class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2M12 3v2m0 14v2m0 0h-2m2 0h2M5 11H3m2 0H3m14 0h2m0 0h-2m0 0h2" />
      </svg>
      Edit Agency
    </button> -->
  </div>

  <hr />

  <!-- Form Container -->
  <div class="bg-white border rounded-lg p-6 space-y-10">

    <form>
    <!-- User Details -->
      <div>
        <h2 class="font-semibold text-lg mb-4">User Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Name -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Name*</label>
            <input type="text" value="John Doe" readonly
              class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Email*</label>
            <input type="text" value="john.doe@gmail.com" readonly
              class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- Phone -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Phone No*</label>
            <input type="text" value="+92-1234567890" readonly
              class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <input type="text" value="+92-1234567890" readonly
              class="w-full border rounded-md p-3 bg-gray-50" />
          </div>


          
          <!-- Password -->
          <!-- <div class="relative">
            <label class="block text-sm text-gray-600 mb-1">Password*</label>
            <input type="password" value="******" readonly
              class="w-full border rounded-md p-3 bg-gray-50 pr-10" />

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
            <input type="password" value="******" readonly
              class="w-full border rounded-md p-3 bg-gray-50 pr-10" />

            <button class="absolute right-3 top-10 text-gray-500 hover:text-black">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.708.042C20.88 7.943 16.884 5 12 5 7.115 5 3.12 7.943 2.292 12.042c-.06.29-.06.627 0 .916C3.12 16.057 7.115 19 12 19c4.884 0 8.88-2.943 9.708-6.042.06-.289.06-.626 0-.916z" />
              </svg>
            </button>
          </div> -->

         
        </div>
        <div class="mt-6">
            <label class="block text-sm text-gray-600 mb-1">Agency Address*</label>
            <input type="text" value="Office #302, Park Tower, Clifton Block 2, Karachi" readonly class="w-full border rounded-md p-3 bg-gray-50" />
          </div>
        <div class="flex justify-end gap-3 mt-10">
            <button class="border border-gray-400 px-5 py-2 rounded-md">Cancel</button>
            <button class="bg-black text-white px-5 py-2 rounded-md">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
@endsection




