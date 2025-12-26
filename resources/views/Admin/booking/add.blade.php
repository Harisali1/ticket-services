@extends('Admin.layouts.main')

@section('content')
<div class="container">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.booking.index') }}" class="text-decoration-none">&larr;</a>
            <h1 class="h4 mb-0">Create Booking</h1>
        </div>
    </div>
    <hr>
    <!-- Content -->
    <div class="card p-4">

        <!-- Form -->
        <form method="POST" action="{{ route('admin.booking.create') }}">
            @csrf
    <h5 class="mb-3">Search Pnr</h5>
    <hr>

    <div class="row g-3">
        <div class="col-md-2">
            <label class="form-label text-muted">Departure</label>
            <select class="form-select" name="departure_id" required>
                <option value="">Select</option>
                @foreach($airports as $airport)
                    <option value="{{ $airport->id }}" 
                        {{ request('departure_id') == $airport->id ? 'selected' : '' }}>
                        {{ $airport->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label text-muted">Arrival</label>
            <select class="form-select" name="arrival_id" required>
                <option value="">Select</option>
                @foreach($airports as $airport)
                    <option value="{{ $airport->id }}"
                        {{ request('arrival_id') == $airport->id ? 'selected' : '' }}>
                        {{ $airport->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label text-muted">Departure Date</label>
            <input type="date" class="form-control" name="departure_date"
                value="{{ request('departure_date') }}" required>
        </div>

        <div class="col-md-2">
            <label class="form-label text-muted">Arrival Date</label>
            <input type="date" class="form-control" name="arrival_date"
                value="{{ request('arrival_date') }}" required>
        </div>

        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-dark w-100">
                Search
            </button>
        </div>
    </div>
</form>

 @if($showPnrSearch)
    <livewire:admin.pnr.search-pnr 
        :initialFilters="$initialFilters" />
@endif
            <!-- Footer Buttons -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectPNRBooking(id){
        let modal = new bootstrap.Modal(document.getElementById('searchPnrSeatModal'));
        document.getElementById('pnr_id').value = id;
        modal.show();
    }

    document.getElementById("pnr-select-seat").addEventListener("submit", function(e) {
    e.preventDefault();

    function showError(message) {
      Swal.fire({
        toast: true,
        position: "top-end",
        icon: "error",
        title: message,
        showConfirmButton: false,
        timer: 2500
      });
    }

    const formData = {
      seat: document.getElementById("seat").value.trim(),
    };

    const validations = [
      { field: "seat", message: "Seat is required", test: v => v !== "" },
    ];

    for (const rule of validations) {
      if (!rule.test(formData[rule.field])) {
        showError(rule.message);
        return;
      }
    }

    Swal.fire({
      title: "Processing...",
      text: "Please wait",
      didOpen: () => Swal.showLoading()
    });

    var data = $('#pnr-select-seat').serialize();
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.ajax({
      url: "{{ route('admin.booking.store') }}",
      method: "POST",
      data: data,
      dataType: 'json',
      beforeSend: function(){
        $('.error-container').html('');
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
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.booking.index') }}";
            }
        });

      },
      error: function (xhr) {
        Swal.close();
        Swal.fire({
          toast: true,
          position: "top-end",
          icon: "error",
          title: xhr.responseJSON.message,
          showConfirmButton: false,
          timer: 2500
        });
      }
    });
  });

</script>

@endsection




