@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
    <div class="container-fluid p-4">
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
    </div>
@endsection

@section('scripts')
@endsection