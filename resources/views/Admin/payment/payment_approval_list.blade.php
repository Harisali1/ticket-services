@extends('Admin.layouts.main')

@section('styles')
@endsection

@section('content')
    @livewire('admin.payment.payment-approval-list', ['id' => $id])
@endsection

@section('scripts')
@endsection




