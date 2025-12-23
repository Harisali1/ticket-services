@extends('Admin.layouts.main')

@section('styles')

@endsection

@section('content')
    @livewire('admin.pnr.pnr-list')
@endsection

@section('scripts')
<script>
    window.addEventListener('open-put-on-sale-modal', () => {
        new bootstrap.Modal(
            document.getElementById('putOnSaleModal')
        ).show();
    });

    window.addEventListener('close-put-on-sale-modal', () => {
        bootstrap.Modal.getInstance(
            document.getElementById('putOnSaleModal')
        ).hide();
    });
</script>
@endsection




