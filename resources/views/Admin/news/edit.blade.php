@extends('Admin.layouts.main')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.news.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Edit Notification</h1>
        </div>
    </div>

    <hr>

    <!-- Form -->
    <div class="card p-4">
        <form id="notification-form" enctype="multipart/form-data">

            <h5 class="mb-3">Notification Details</h5>

            <div class="row g-3 mb-4">
                <input type="hidden" id="id" name="id" value="{{ $notification->id }}">
                <!-- Title -->
                <div class="col-md-6">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $notification->title) }}"
                           class="form-control"
                           placeholder="Enter Notification Title">
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ $notification->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ $notification->status == 2 ? 'selected' : '' }}>DeActive</option>
                    </select>
                </div>

                <!-- Image -->
                <div class="col-md-3">
                    <label class="form-label">Notification Image</label>
                    <div class="d-flex align-items-center gap-3">

                        <div class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden"
                             style="width:96px; height:96px;">
                            <img id="logoPreview"
                                 src="{{ $notification->image ? asset('storage/'.$notification->image) : asset('images/logo-placeholder.png') }}"
                                 class="img-fluid">
                        </div>

                        <div>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="d-none" onchange="previewLogo(this)">
                            <label for="image" class="btn btn-outline-secondary">
                                Change Image
                            </label>
                            <div class="small text-muted mt-1">JPG / PNG • Max 2MB</div>
                        </div>

                    </div>
                </div>

                <!-- Description -->
                <div class="col-md-9">
                    <label class="form-label">Description *</label>
                    <textarea name="description" id="description"
                              class="form-control"
                              placeholder="Description"
                              rows="5">{{ old('description', $notification->description) }}</textarea>
                </div>

            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-dark">Update</button>
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
        reader.onload = e => document.getElementById('logoPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("notification-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const showError = (msg) => {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: msg,
                showConfirmButton: false,
                timer: 2500
            });
        };

        const title = titleInput = document.getElementById("title").value.trim();
        const description = document.getElementById("description").value.trim();
        const status = document.getElementById("status").value;
        const image = document.getElementById("image").files[0] ?? null;

        if (!title) return showError("Title is required");
        if (!description) return showError("Description is required");

        if (image) {
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
            if (!allowedTypes.includes(image.type)) {
                return showError("Image must be JPG or PNG");
            }
            if (image.size > 2097152) {
                return showError("Image size must be less than 2MB");
            }
        }

        Swal.fire({
            title: "Updating...",
            text: "Please wait",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.news.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                Swal.close();
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: res.message,
                    showConfirmButton: true
                });
                window.location.href = "{{ route('admin.news.index') }}";
            },
            error: function (xhr) {
                Swal.close();
                let msg = "Something went wrong";
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors)[0][0];
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                showError(msg);
            }
        });
    });
});
</script>
@endsection
