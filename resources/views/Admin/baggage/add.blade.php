@extends('Admin.layouts.main')

@section('styles')
<style>
    body {
        background: #f1f3f5;
    }
    table th {
        width: 30%;
        background: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.baggage.index') }}" class="text-decoration-none text-secondary">
                &larr;
            </a>
            <h1 class="h4 mb-0">Create Baggage</h1>
        </div>
    </div>

    <hr>

    <!-- Table Form -->
    <div class="card p-4">
        <form id="baggage-form">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted">Title *</label>
                    <input type="text" name="title" id="title"
                        class="form-control"
                        placeholder="Enter Baggage Title">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Price *</label>
                    <input type="text" name="price" id="price"
                        class="form-control"
                        placeholder="Enter price">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('admin.baggage.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-dark">
                    Save
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.getElementById('baggage-form').addEventListener('submit', function (e) {
    e.preventDefault();

    function error(msg) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: msg,
            showConfirmButton: false,
            timer: 2500
        });
    }

    const data = {
        title: title.value.trim(),
        price: price.value.trim(),
    };

    const rules = [
        ['title', 'Title is required'],
        ['price', 'Price is required'],
    ];

    for (const [field, message] of rules) {
        if (!data[field]) {
            error(message);
            return;
        }
    }

    Swal.fire({
        title: 'Saving...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('admin.baggage.store') }}",
        type: "POST",
        data: $('#baggage-form').serialize(),
        dataType: "json",
        success: function (res) {
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: res.message,
                showConfirmButton: true
            }).then(() => {
                window.location.href = "{{ route('admin.baggage.create') }}";
            });
        },
        error: function (xhr) {
            Swal.close();
            error(xhr.responseJSON?.message || 'Something went wrong');
        }
    });
});
</script>
@endsection
