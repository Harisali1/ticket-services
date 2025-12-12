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
      <h1 class="text-2xl font-semibold">Add AirLine</h1>
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
    <!-- Agency Details -->
      <div>
        <h2 class="font-semibold text-lg mb-4">AirLine Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Agency Name -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Name*</label>
            <input type="text" placeholder="Enter Agency Name" class="w-full border rounded-md p-3 bg-gray-50" />
          </div>

          <!-- P.IVA -->
          <div>
            <label class="block text-sm text-gray-600 mb-1">Code*</label>
            <input type="text" value="4YUK3R" readonly
              class="w-full border rounded-md p-3 bg-gray-50" />
          </div>
        </div>

        <!-- Address -->
        <div class="mt-6">
          <label class="block text-sm text-gray-600 mb-1">Status*</label>
          <input type="text" value="Office #302, Park Tower, Clifton Block 2, Karachi" readonly
            class="w-full border rounded-md p-3 bg-gray-50" />
        </div>
      </div>

        <div class="flex justify-end gap-3 mt-10">
            <button class="border border-gray-400 px-5 py-2 rounded-md">Cancel</button>
            <button class="bg-black text-white px-5 py-2 rounded-md">Save</button>
        </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
@endsection




