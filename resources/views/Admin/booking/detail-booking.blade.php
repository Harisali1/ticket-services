@extends('Admin.layouts.main')

@section('styles')
  
@endsection

@section('content')
<div class="container-fluid p-0">

    <!-- Top Bar -->
    <div class="bg-primary text-white px-4 py-3 d-flex justify-content-between align-items-center">
        <div>
            <small>Home / Booking List / Booking Detail</small>
            <strong class="ms-2">ICFQsT5r1E_3D</strong>
        </div>
        <div class="btn-group">
            <button class="btn btn-danger btn-sm">Cancel PNR</button>
            <button class="btn btn-warning btn-sm">Refresh</button>
            <button class="btn btn-success btn-sm">Ticket</button>
            <a href="{{ route('admin.booking.print.itinerary') }}"><button class="btn btn-secondary btn-sm">Print Itinerary</button></a>
        </div>
    </div>

    <!-- Success Alert -->
    <!-- <div class="alert alert-success m-4">
        Booking <strong>55A5F7</strong> has been created successfully.
    </div> -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
             {{ session('success') }} Booking No # {{ $booking->booking_no }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- Booking Info -->
    <div class="card mx-4 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <h5 class="text-warning">SKYALLOT</h5>
                    <span class="badge bg-info">PNR CREATED</span>
                    <p class="fw-bold mt-2">55A5F7</p>
                </div>

                <div class="col-md-3">
                    <small>Universal Record</small>
                    <p>AL-3DUd_2BkW_2FuTc_3D</p>
                </div>

                <div class="col-md-6">
                    <div class="row text-center">
                        <div class="col">
                            <small>Fare Time Limit</small>
                            <p>09 Jan 10:14</p>
                        </div>
                        <div class="col">
                            <small>Booking Date</small>
                            <p>08 Jan 10:16</p>
                        </div>
                        <div class="col">
                            <small>Sync Date</small>
                            <p>08 Jan 10:16</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row align-items-center">
                <div class="col-md-3">Base: <strong>500.00 EUR</strong></div>
                <div class="col-md-3">Tax: <strong>200.00 EUR</strong></div>
                <div class="col-md-3 text-success fw-bold fs-5">Total: 700.00 EUR</div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-success btn-sm">Requote</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flight Segments -->
    <div class="card mx-4 mb-4">
        <div class="card-header bg-light fw-bold">Outbound</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">Sat 31 Jan 2026<br><strong>FCO → DSS</strong></div>
                <div class="col-md-2">6h 0m</div>
                <div class="col-md-2">AZ854</div>
                <div class="col-md-2">Economy (Y)</div>
                <div class="col-md-1"><span class="badge bg-success">HK</span></div>
            </div>
        </div>

        <div class="card-header bg-light fw-bold">Inbound</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">Sun 15 Feb 2026<br><strong>DSS → FCO</strong></div>
                <div class="col-md-2">5h 30m</div>
                <div class="col-md-2">AZ855</div>
                <div class="col-md-2">Economy (Y)</div>
                <div class="col-md-1"><span class="badge bg-success">HK</span></div>
            </div>
        </div>
    </div>

    <!-- Passenger -->
    <div class="card mx-4 mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            Passenger 1 (ADT)
            <button class="btn btn-success btn-sm">Edit Passenger Data</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">Name: <strong>John Doe</strong></div>
                <div class="col-md-4">DOB: 22 May 1999</div>
                <div class="col-md-4">Gender: Male</div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">Email: email@gmail.com</div>
                <div class="col-md-4">Phone: +92 344 1231231</div>
            </div>
        </div>
    </div>

    <!-- Baggage -->
    <div class="card mx-4 mb-4">
        <div class="card-header bg-primary text-white">Baggage Included</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    ROME (FCO) → DAKAR (DSS)
                    <span>2 Pc / 8 Kg</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    DAKAR (DSS) → ROME (FCO)
                    <span>2 Pc / 8 Kg</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Reservation Recap -->
    <div class="card mx-4 mb-5">
        <div class="card-header bg-success text-white">Reservation Recap</div>
        <div class="card-body text-end">
            <p>Fare Amount: <strong>500.00 EUR</strong></p>
            <p>Tax: <strong>200.00 EUR</strong></p>
            <h4 class="text-success">Total: 700.00 EUR</h4>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>

</script>

@endsection
