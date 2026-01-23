@extends('Admin.layouts.main')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.role.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Add Role</h1>
        </div>
    </div>

    <hr>

    <!-- Form -->
    <div class="card p-4">
        <form method="post" action="{{ route('admin.role.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mb-4">
                <!-- Name -->
                <div class="col-md-4">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           placeholder="Enter airport Name" class="form-control">
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.role.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-dark">Save</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')

@endsection
