@extends('Admin.layouts.main')

@section('styles')
<style>
/* ====== GENERAL ====== */
.bg-gray {
    background: #f8f9fa;
}

/* ====== STAT CARDS ====== */
.card-stat {
    background: #ffffff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    transition: all .25s ease;
    position: relative;
    overflow: hidden;
}

.card-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.10);
}

.card-stat h3 {
    font-weight: 700;
    margin-bottom: 4px;
}

.card-stat p {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
}

/* ====== SECTION CARDS ====== */
.card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
}

/* ====== TABLE ====== */
.table th {
    font-size: 12px;
    text-transform: uppercase;
    color: #6c757d;
}

.table td {
    font-size: 14px;
}

/* ====== NOTIFICATION IMAGE ====== */
.notification-img {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
}

/* ====== CAROUSEL ARROWS ====== */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}

/* ====== IMAGE POPUP ====== */
.image-popup img {
    max-height: 80vh;
    object-fit: contain;
}
</style>
@endsection

@section('content')
<div class="container py-5">

    <!-- ================= STATS ================= -->
    <h5 class="mb-4">{{ __('messages.quick_stats') }}</h5>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $bookingCounts->total }}</h3>
                        <p>{{ __('messages.total_booking') }}</p>
                    </div>
                    <i class="fa fa-dashboard fa-2x text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $bookingCounts->created }}</h3>
                        <p>{{ __('messages.reserved') }}</p>
                    </div>
                    <i class="fa fa-calendar fa-2x text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $bookingCounts->ticketed }}</h3>
                        <p>{{ __('messages.ticketed') }}</p>
                    </div>
                    <i class="fa fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $bookingCounts->cancelled }}</h3>
                        <p>{{ __('messages.cancel') }}</p>
                    </div>
                    <i class="fa fa-times-circle fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->user_type_id == '2')
    <!-- ================= SECOND ROW ================= -->
    <div class="row g-4 mt-5 mb-5">

        <!-- ===== BANK DETAILS ===== -->
        <div class="col-md-4">
            <div class="card p-4 h-100 bg-gray">
                <h6 class="fw-semibold text-uppercase text-muted text-center mb-3">
                    {{ __('messages.bank_details') }}
                </h6>

                <div id="accountSlider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach($bankDetails as $bank)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <p><strong>Bank:</strong> {{ $bank->bank_name }}</p>
                            <p><strong>Account Title:</strong> {{ $bank->ac_title }}</p>
                            <p><strong>Swift Code:</strong> {{ $bank->swift_code }}</p>
                            <p><strong>IBAN:</strong> {{ $bank->iban }}</p>
                        </div>
                        @endforeach

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#accountSlider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#accountSlider" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== NOTIFICATIONS ===== -->
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h6 class="fw-semibold text-uppercase text-muted text-center mb-3">
                    {{ __('messages.notification') }}
                </h6>

                <div style="max-height:220px; overflow-y:auto;">
                    @forelse($notifications as $notify)
                    <div class="d-flex gap-3 mb-3 pb-2 border-bottom">

                        @if(!empty($notify->image))
                        <img class="notification-img"
                             src="{{ asset('storage/'.$notify->image) }}"
                             onclick="showImage(this.src)">
                        @endif

                        <div>
                            <strong class="d-block mb-1">{{ $notify->title }}</strong>
                            <p class="mb-0 text-muted small">
                                {{ \Illuminate\Support\Str::limit($notify->description, 80) }}
                            </p>
                        </div>
                    </div>
                    @empty
                        <p class="text-center text-muted">No notifications found</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ===== TODAY RESERVATION ===== -->
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h6 class="fw-semibold text-uppercase text-muted text-center mb-3">
                    {{ __('messages.today_reservation') }}
                </h6>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>PNR</th>
                                <th>Route</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todayReservation as $key => $reservation)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $reservation->pnr->pnr_no }}</td>
                                <td>
                                    {{ $reservation->pnr->departure->code }}
                                    →
                                    {{ $reservation->pnr->arrival->code }}
                                </td>
                                <td>
                                    <span class="badge {{ $reservation->status->color() }}">
                                        {{ $reservation->status->label() }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
function showImage(src) {
    Swal.fire({
        imageUrl: src,
        showCloseButton: true,
        showConfirmButton: false,
        background: '#000',
        customClass: { popup: 'image-popup' }
    });
}
</script>
@endsection
