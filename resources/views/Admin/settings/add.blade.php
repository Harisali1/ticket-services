@extends('Admin.layouts.main')

@section('styles')
<style>
    body {
        background: #f1f3f5;
    }
    .card {
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    <h1 class="h4">Personal Settings</h1>
    <hr>

    <form id="setting-form" enctype="multipart/form-data" class="pb-5">
        <div class="row g-4">

            <!-- LEFT: Agency Details -->
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <h5 class="mb-3">Agency Details</h5>

                    <!-- Logo (Editable) -->
                    <div class="mb-3">
                        <label class="form-label">Agency Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control">

                        <img id="logoPreview"
                             src="{{ auth()->user()->logo ? asset('storage/'.auth()->user()->logo) : '' }}"
                             class="img-thumbnail mt-2"
                             style="max-height:120px; {{ auth()->user()->logo ? '' : 'display:none' }}">
                    </div>

                    <!-- Read Only Fields -->
                    <div class="mb-3">
                        <label class="form-label">Agency Name</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->agency->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">P.IVA</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->agency->piv }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="2" disabled>{{ auth()->user()->agency->address }}</textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">Phone No</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->phone_no }}" disabled>
                        </div>

                      
                    </div>

                </div>
            </div>

            <!-- RIGHT: Change Password -->
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <h5 class="mb-3">Change Password</h5>

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>

        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-dark px-4">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('logo').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('logoPreview');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

$('#setting-form').on('submit', function(e){
    e.preventDefault();

    Swal.fire({title:'Saving...',allowOutsideClick:false,didOpen:()=>Swal.showLoading()});

    $.ajax({
        url: "{{ route('admin.setting.store') }}",
        type: "POST",
        data: new FormData(this),
        processData:false,
        contentType:false,
        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        success: res => {
            Swal.fire({toast:true,icon:'success',title:res.message,position:'top-end'});
        },
        error: xhr => {
            Swal.fire({icon:'error',title:xhr.responseJSON?.message || 'Error'});
        }
    });
});
</script>
@endsection
