@extends('Admin.layouts.main')

@section('styles')
<style>
    .b-action-btn {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: auto !important;
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
    @livewire('admin.booking.booking-list')
@endsection

@section('scripts')
@endsection




