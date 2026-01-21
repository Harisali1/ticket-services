@extends('Admin.layouts.main')

@section('styles')
<style>
.scroll {
    max-height: 200px;   /* apni requirement ke mutabiq */
    overflow-y: auto;
    padding-right: 10px;
}
.bg-gray{
    background: #f2f2f2;
}
/* Make carousel arrows black */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}
.image-popup img {
    max-height: 80vh;
    object-fit: contain;
}
.notification-img {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;   /* 👈 arrow → hand cursor */
}

</style>
@endsection

@section('content')
    <div class="container p-4">
        <h5 class="mb-3">Quick Stats</h5>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>{{ $bookingCounts->total }}</h3>
                    <p>Total</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>{{ $bookingCounts->created }}</h3>
                    <p>Reserved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>{{ $bookingCounts->ticketed }}</h3>
                    <p>Ticketed</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>{{ $bookingCounts->cancelled }}</h3>
                    <p>Abandoned</p>
                </div>
            </div>
        </div>
        @if(Auth::user()->user_type_id == '2')
        <div class="row g-3 mt-4">
           <div class="col-md-4">
                <div class="card p-3 h-100 bg-gray">
                    <h5 class="text-center mb-3">Account Details</h5>

                    <div id="accountSlider" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                            @foreach($bankDetails as $bank)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <p><strong>Bank Name:</strong> {{ $bank->bank_name }}</p>
                                    <p><strong>Account Title:</strong>{{ $bank->ac_title }}</p>
                                    <p><strong>Swift Code:</strong> {{ $bank->swift_code }}</p>
                                    <p><strong>IBAN:</strong> {{ $bank->iban }}</p>
                                </div>
                            @endforeach

                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#accountSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#accountSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <h5 class="text-center mb-3">Notifications</h5>

                    <div style="max-height:200px; overflow-y:auto;">
                        @forelse($notifications as $notify)
                            <div class="mb-3 border-bottom pb-2 d-flex gap-2">

                                @if(!empty($notify->image))
                                    <img class="notification-img"
                                        src="{{ $notify->image ? asset('storage/'.$notify->image) : asset('images/logo-placeholder.png') }}"
                                        alt="notification image" onclick="showImage(this.src)"
                                        style="width:45px; height:45px; object-fit:cover; border-radius:6px;">
                                @endif

                                <div>
                                    <strong class="d-block">{{ $notify->title }}</strong>
                                    <p class="mb-0 text-muted small">
                                        {{ $notify->description }}
                                    </p>
                                </div>

                            </div>
                        @empty
                            <p class="text-center text-muted">No notifications found</p>
                        @endforelse
                    </div>
                </div>
            </div>


            
            <div class="col-md-4">
                <div class="card p-3 h-100">
                    <h5 class="text-center mb-3">Today Reservations</h5>

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
                                @foreach($todayReservation as $reservation)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $reservation->pnr->pnr_no }}</td>
                                    <td>{{ $reservation->pnr->departure->code }} → {{ $reservation->pnr->arrival->code }}</td>
                                    <td>
                                        <span class="badge bg-success {{ $reservation->status->color() }}">{{ $reservation->status->label() }}</span>
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
            imageAlt: 'Notification Image',
            showCloseButton: true,
            showConfirmButton: false,
            background: '#000',
            imageWidth: '100%',
            customClass: {
                popup: 'image-popup'
            }
        });
    }
</script>
@endsection