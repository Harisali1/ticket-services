@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
<div class="container py-4">
  <hr>
  
  <div class="card p-4">
    <h3 class="mb-4">Role Permissions Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.role.permission.store') }}">
      @csrf

      <input type="hidden" name="user_id" value="{{ $user->id }}">
      <div class="row g-3 mb-4">
          <!-- Name -->
          <div class="col-md-4">
              <label for="name" class="form-label">Role Name *</label>
              <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Enter Role Name"
                    class="form-control"
                    value="{{ $role?->name }}"
                    required
                >
          </div>
      </div>
      <div class="row">
          @foreach($permissions as $permission)
              <div class="col-md-4 mb-2">
                  <div class="form-check">
                      <input
                            class="form-check-input"
                            type="checkbox"
                            name="permissions[]"
                            value="{{ $permission->name }}"
                            id="perm_{{ $permission->id }}"
                            {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}
                        >

                      <label class="form-check-label" for="perm_{{ $permission->id }}">
                          {{ $permission->name }}
                      </label>
                  </div>
              </div>
          @endforeach
      </div>

      <button type="submit" class="btn btn-primary mt-3">
          Save Permissions
      </button>
    </form>
  </div>



</div>

@endsection

@section('scripts')
@endsection




