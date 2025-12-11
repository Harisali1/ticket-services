@extends('layouts.main')

@section('styles')
@endsection

@section('content')
<div class="p-6 space-y-6 bg-gray-50 min-h-screen">
  <!-- Page Title -->
  <h1 class="text-2xl font-semibold">Agencies List</h1>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">All Agencies</p>
      <p class="text-3xl font-semibold mt-2">100</p>
    </div>

    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">Pending Approval</p>
      <p class="text-3xl font-semibold mt-2">05</p>
    </div>

    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">Approved</p>
      <p class="text-3xl font-semibold mt-2">90</p>
    </div>

    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">Suspended</p>
      <p class="text-3xl font-semibold mt-2">05</p>
    </div>
  </div>

  <!-- Header Actions -->
  <div class="flex justify-end gap-3">
    <button class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-md">
      <span>+</span> Create Agency
    </button>

    <button class="p-2 border rounded-md">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M4 8h16M6 12h12M9 16h6M11 20h2"/>
      </svg>
    </button>
  </div>

  <!-- Table -->
  <div class="overflow-auto border rounded-lg bg-white">
    <table class="min-w-full text-left text-sm">
      <thead class="bg-gray-100 text-gray-600 border-b">
        <tr>
          <th class="p-3"><input type="checkbox" /></th>
          <th class="p-3 font-medium">Agency Name</th>
          <th class="p-3 font-medium">P.IVA</th>
          <th class="p-3 font-medium">Address</th>
          <th class="p-3 font-medium">Created/Updated On</th>
          <th class="p-3 font-medium">Status</th>
          <th class="p-3 font-medium">Action</th>
        </tr>
      </thead>

      <tbody>
        <!-- Row -->
        <tr class="border-b">
          <td class="p-3"><input type="checkbox" /></td>
          <td class="p-3">Global Travel Services</td>
          <td class="p-3">4YUK3R</td>
          <td class="p-3">Office #302, Park Tower, Clifton Block 2, Karachi</td>
          <td class="p-3">11/30/2025 at 11:00 am GMT</td>
          <td class="p-3 text-yellow-600">Pending Approval</td>
          <td class="p-3">
            <button class="p-1">
              <span class="text-xl">⋮</span>
            </button>
          </td>
        </tr>

        <tr class="border-b">
          <td class="p-3"><input type="checkbox" /></td>
          <td class="p-3">SkyRoute Travels</td>
          <td class="p-3">4YUK3R</td>
          <td class="p-3">Suite 14, Centaurus Mall, F-8, Islamabad</td>
          <td class="p-3">11/30/2025 at 11:00 am GMT</td>
          <td class="p-3 text-green-600">Approved</td>
          <td class="p-3"><button class="p-1"><span class="text-xl">⋮</span></button></td>
        </tr>

        <tr class="border-b">
          <td class="p-3"><input type="checkbox" /></td>
          <td class="p-3">Blue Horizon Agency</td>
          <td class="p-3">4YUK3R</td>
          <td class="p-3">Shop No. 22, Liberty Market, Gulberg III, Lahore</td>
          <td class="p-3">11/30/2025 at 11:00 am GMT</td>
          <td class="p-3 text-red-600">Suspended</td>
          <td class="p-3"><button class="p-1"><span class="text-xl">⋮</span></button></td>
        </tr>

        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
@endsection




