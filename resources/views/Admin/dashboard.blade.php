@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="p-10">

      <h3 class="text-xl font-semibold mb-8">Quick Stats</h3>

      <!-- Stats Row -->
      <div class="flex gap-2 flex-wrap">

            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">100</div>
            <div class="text-gray-500 mt-1">Reserved</div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">40</div>
            <div class="text-gray-500 mt-1">Remaining</div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">30</div>
            <div class="text-gray-500 mt-1">Ticketed</div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">30</div>
            <div class="text-gray-500 mt-1">Abandoned</div>
            </div>

            <!-- Card 5 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">50</div>
            <div class="text-gray-500 mt-1">Completed</div>
            </div>

        </div>


    </div>
@endsection

@section('scripts')
@endsection
