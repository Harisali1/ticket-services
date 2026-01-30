@extends('Admin.layouts.main')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.news.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Add Notification</h1>
        </div>
    </div>

    <hr>

    <!-- Form -->
    <div class="card p-4">
        <form id="airport-form" enctype="multipart/form-data">
            
            <!-- airport Details -->
            <h5 class="mb-3">Notification Details</h5>

            <div class="row g-3 mb-4">
                <!-- Name -->
                <div class="col-md-6">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           placeholder="Enter Notification Title" class="form-control">
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="2">DeActive</option>
                    </select>
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">Notification Image</label>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Preview -->
                        <div class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width:96px; height:96px;">
                            <img id="logoPreview" src="{{ asset('images/logo-placeholder.png') }}" class="img-fluid">
                        </div>

                        <!-- Upload -->
                        <div>
                            <input type="file" name="image" id="image" accept="image/*" class="d-none" onchange="previewLogo(this)">
                            <label for="image" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                                Upload Image
                            </label>
                            <div class="small text-muted mt-1">JPG / PNG • Max 2MB</div>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Code -->
                <div class="col-md-9">
                    <label for="description" class="form-label">Description *</label>
                    <textarea type="text" name="description" id="description" value="{{ old('description') }}"
                           placeholder="Description" class="form-control"></textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-dark">Save</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>

    function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { document.getElementById('logoPreview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("airport-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const showError = (message) => {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: message,
                showConfirmButton: false,
                timer: 2500
            });
        };

        const title   = document.getElementById("title").value.trim();
        const description   = document.getElementById("description").value.trim();
        const status = document.getElementById("status").value;
        const image   = document.getElementById("image").files[0] ?? null;

        if (!title) { showError("title is required"); return; }
        if (!description) { showError("description is required"); return; }
        if (!status) { showError("Status is required"); return; }

        const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowedTypes.includes(image.type)) { showError("Logo must be JPG or PNG"); return; }
        if (image.size > 2097152) { showError("Logo size must be less than 2MB"); return; }

        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.news.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) { 
                Swal.close(); 
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: data.message,
                    showConfirmButton: true,
                    confirmButtonText: "OK"
                });
                window.location.href = "{{ route('admin.news.index') }}";
            },
            error: function (xhr) {
                Swal.close();
                let message = "Something went wrong";
                if (xhr.responseJSON?.errors) {
                    message = Object.values(xhr.responseJSON.errors)[0][0];
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                showError(message);
            }
        });
    });
});

</script>
@endsection
