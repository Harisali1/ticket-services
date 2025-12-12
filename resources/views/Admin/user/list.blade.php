@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="p-6 space-y-6 bg-gray-50 min-h-screen">
  <!-- Page Title -->
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">User List</h1>

    <div class="flex items-center gap-3">
      <a href="{{ route('admin.user.create') }}" class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-md">
        <span>+</span> Add User
      </a>

      <button class="p-2 border rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M4 8h16M6 12h12M9 16h6M11 20h2"/>
        </svg>
      </button>
    </div>
  </div>
  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">All Users</p>
      <p class="text-3xl font-semibold mt-2">100</p>
    </div>

    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">Active</p>
      <p class="text-3xl font-semibold mt-2">05</p>
    </div>

    <div class="bg-white border p-5 rounded-lg">
      <p class="text-sm text-gray-500">In-Active</p>
      <p class="text-3xl font-semibold mt-2">90</p>
    </div>
  </div>

  <!-- Header Actions -->
  

  <!-- Table -->
  <div class="overflow-auto border rounded-lg bg-white">
    <table class="min-w-full text-left text-sm">
      <thead class="bg-gray-100 text-gray-600 border-b">
        <tr>
          <th class="p-3"><input type="checkbox" /></th>
          <th class="p-3 font-medium">Name</th>
          <th class="p-3 font-medium">Email</th>
          <th class="p-3 font-medium">Created/Updated On</th>
          <th class="p-3 font-medium">Status</th>
          <th class="p-3 font-medium">Action</th>
        </tr>
      </thead>

      <tbody>
        <!-- Row -->
        <tr class="border-b">
          <td class="p-3"><input type="checkbox" /></td>
          <td class="p-3">Farzan</td>
          <td class="p-3">farzan@gmail.com</td>
          <td class="p-3">11/30/2025 at 11:00 am GMT</td>
          <td class="p-3 text-yellow-600">Active</td>
          <td class="p-3">
            <button class="p-1">
              <span class="text-xl">⋮</span>
            </button>
          </td>
        </tr>
        <tr class="border-b">
          <td class="p-3"><input type="checkbox" /></td>
          <td class="p-3">Farzan</td>
          <td class="p-3">farzan@gmail.com</td>
          <td class="p-3">11/30/2025 at 11:00 am GMT</td>
          <td class="p-3 text-yellow-600">Active</td>
          <td class="p-3">
            <button class="p-1">
              <span class="text-xl">⋮</span>
            </button>
          </td>
        </tr>
        <tr class="border-b">
          <td class="p-3"><input type="checkbox" /></td>
          <td class="p-3">Farzan</td>
          <td class="p-3">farzan@gmail.com</td>
          <td class="p-3">11/30/2025 at 11:00 am GMT</td>
          <td class="p-3 text-yellow-600">Active</td>
          <td class="p-3">
            <button class="p-1">
              <span class="text-xl">⋮</span>
            </button>
          </td>
        </tr>

        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
@endsection




