@extends('Admin.layouts.main')

@section('styles')
<style>
    .stat-card:hover {
        cursor: pointer;
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.08);
    }
    .stat-card {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.08);
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    .table-height{
        height: 100vh;
    }
</style>
@endsection

@section('content')
    @livewire('admin.agency.agency-list')
@endsection

@section('scripts')
<script>
    document.addEventListener('open-password-modal', () => {
        const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    });
</script>

@endsection




