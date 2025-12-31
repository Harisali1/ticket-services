@extends('Admin.layouts.main')

@section('styles')
<style>
.scroll {
    max-height: 200px;   /* apni requirement ke mutabiq */
    overflow-y: auto;
    padding-right: 10px;
}
</style>
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
        @if(Auth::user()->user_type_id == '2')
        <div class="row g-3 mt-4">
            <div class="col-md-4">
                <div class="card card-stat">
                    <h3>Account Details</h3>
                    <p>Account No: 123456789012345</p>
                    <p>Bank Name: 123456789012345</p>
                    <p>Account Title: 123456789012345</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat">
                    <h3>Notification</h3>
                    <div class="scroll">
                        <p>Privacy Notice on the Processing of Personal Data (Art. 13 EU Regulation 2016/679 – GDPR)</p>
                        <p>Divine Travel, as Data Controller, informs you that your personal data will be processed for the purpose of managing the Information Request Service. The data collected through this registration (email address) will be processed using electronic and IT tools in a lawful, correct, and transparent manner.</p>
                        <p><b>Purpose and Legal Basis of Processing</b></p>
                        Your Personal Data is processed solely to respond to your information request. Providing your data is necessary to use the Service; failure to provide such data will make it impossible to process your request.
                        The legal basis for processing is Article 6(1)(b) GDPR (processing necessary to take steps at your request prior to entering into a contract).

                        Data Recipients

                        Your data may be processed only by authorized personnel responsible for managing your request and, if necessary, by technicians responsible for IT system maintenance.
                        Your data will not be disclosed to third parties, except where required by law, nor will it be disseminated.

                        Data Retention

                        Your data will be retained for the time strictly necessary to process your request and, in any case, no longer than permitted by applicable laws.

                        Rights of the Data Subject

                        Pursuant to Articles 15–22 GDPR, you may exercise the following rights at any time:

                        right of access to personal data;

                        right to rectification or updating;

                        right to erasure (“right to be forgotten”);

                        right to restriction of processing;

                        right to data portability;

                        right to object to processing;

                        right to lodge a complaint with the Data Protection Authority.

                        To exercise your rights, you may write to: sales@divinetravel.it

                        Data Controller
                        The Data Controller is Divine Travel.
                    </div>
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat">
                    <h3>Today Reservations</h3>
                    <p>right to lodge a complaint with the Data Protection Authority.

                        To exercise your rights, you may write to: sales@divinetravel.it

                        Data Controller
                        The Data Controller is Divine Travel.</p>
                </div>
            </div>
            
        </div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection