@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
    @livewire('admin.agency.agency-payment-list')
@endsection

@section('scripts')
<!-- <script>
    document.addEventListener('open-password-modal', () => {
        const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    });
</script> -->

@endsection




