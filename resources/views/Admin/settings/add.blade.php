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
            <h1 class="h4 mb-0">Personal Setting</h1>
        </div>
    </div>

    <hr>

    <!-- Table Form -->
    <div class="card p-4">
        <form id="setting-form" enctype="multipart/form-data">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Logo *</label>
                    <input type="file" name="logo" id="logo" class="form-control">
                    <div class="mt-2">
                        <img id="logoPreview"
                            src="{{ auth()->user()->logo 
                                ? asset('storage/'.auth()->user()->logo) 
                                : asset('images/logo-placeholder.png') }}"
                            class="img-thumbnail"
                            style="max-height:120px; {{ empty(auth()->user()->logo) ? 'display:none' : '' }}">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
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
    document.getElementById('logo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById('logoPreview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('setting-form').addEventListener('submit', function (e) {
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

        let formData = new FormData(document.getElementById('setting-form'));

        $.ajax({
            url: "{{ route('admin.setting.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
                    window.location.href = "{{ route('admin.setting.index') }}";
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
