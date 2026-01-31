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
    .stat-card {
        transition: all 0.2s ease-in-out;
    }

    .stat-card:hover {
        cursor: pointer;
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.08);
    }
.offcanvas {
    overflow: visible !important;
}

.select2-container {
    width: 100% !important;
}

.select2-dropdown {
    z-index: 2055 !important; /* bootstrap offcanvas z-index se zyada */
}

</style>
@endsection

@section('content')
    @livewire('admin.booking.booking-list')
@endsection

@section('scripts')

@endsection




