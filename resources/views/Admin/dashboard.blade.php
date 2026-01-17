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

</style>
@endsection

@section('content')
    <div class="container p-4">
        <h5 class="mb-3">Quick Stats</h5>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>100</h3>
                    <p>Reserved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>40</h3>
                    <p>Reserved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>30</h3>
                    <p>Ticketed</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat">
                    <h3>30</h3>
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
                                    <p><strong>Account No:</strong> {{ $bank->ac_no }}</p>
                                    <p><strong>Bank Name:</strong> {{ $bank->bank_name }}</p>
                                    <p><strong>Account Title:</strong>{{ $bank->ac_title }}</p>
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
                    <h5 class="text-center mb-3">Notification</h5>
                    <div style="max-height:200px; overflow-y:auto;">
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
                        <p>Privacy Notice on the Processing of Personal Data...</p>
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
                                    <td>KHI → DXB</td>
                                    <td>
                                        <span class="badge bg-success">Confirmed</span>
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
@endsection