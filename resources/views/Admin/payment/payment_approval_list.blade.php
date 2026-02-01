@extends('Admin.layouts.main')

@section('styles')
<style>
    .image-popup {
        max-width: 90vw !important;
        max-height: 90vh !important;
    }

    .swal-image-big {
        max-width: 100% !important;
        max-height: 90vh !important;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
    @livewire('admin.payment.payment-approval-list', ['id' => $id])
@endsection

@section('scripts')

<script>
function showImage(src) {
    Swal.fire({
        imageUrl: src,
        imageAlt: 'Preview',
        showCloseButton: true,
        showConfirmButton: false,

        // 🔥 popup size
        width: '60vw',

        // dark background
        background: '#000',

        // remove padding
        padding: '0',

        customClass: {
            popup: 'image-popup',
            image: 'swal-image-big'
        }
    });
}

</script>

@endsection




