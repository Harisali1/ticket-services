<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11.5px;
        color: #222;
        line-height: 1.4;
    }

    h1, h2, h3, h4 {
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 10px 20px;
    }

    /* Header */
    .header {
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }

    .route {
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    .reservation-box {
        width: 100%;
        margin-top: 10px;
        border: 1px solid #000;
        padding: 6px 0px;
        font-size: 11px;
    }

    /* Section title */
    .section-title {
        margin-top: 18px;
        margin-bottom: 6px;
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #000;
        padding-bottom: 4px;
    }

    /* Tables */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #000;
        padding: 6px;
        vertical-align: top;
    }

    .table th {
        background: #f0f0f0;
        font-weight: bold;
        text-align: left;
    }

    .small-text {
        font-size: 11px;
    }

    /* Flight box */
    .flight-box {
        border: 1px solid #000;
        padding: 8px 10px;
        margin-bottom: 12px;
    }

    .flight-header {
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .badge {
        background: #eaeaea;
        padding: 4px 8px;
        font-weight: bold;
        font-size: 11px;
        margin-bottom: 6px;
        display: inline-block;
    }

    .right {
        text-align: right;
        float: right;
        font-size: 11px;
    }

    .clearfix {
        clear: both;
    }
    .small{
        text-align:right;
    }
</style>

<div class="container">
    <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
        <tr>
            <td width="60%">
                <img src="{{ auth()->user()->logo ? public_path('storage/' . auth()->user()->logo) : public_path('images/logo-placeholder.png') }}" style="height:50px;">
            </td>
            <td width="40%" class="right">
                <strong style="font-size:16px;">E-Ticket / Flight Itinerary</strong><br>
                <span class="small">Generated on {{ now()->format('d F Y') }}</span>
            </td>
        </tr>
    </table>
    <!-- HEADER -->
    <div class="header">
        <div class="route">
            ({{ $booking['pnr']['departure']['code'] }}) → ({{ (isset($booking['pnr']['middle_arrival'])) ? $booking['pnr']['middle_arrival']['code'] : $booking['pnr']['arrival']['code']}}) 
            
            {{ (isset($booking['pnr']['return_arrival'])) ? '→ ('.$booking['pnr']['return_arrival']['code'].')' : ''}}
        </div>

        <div class="reservation-box">
            <strong>Reservation Number:</strong> {{ $booking['booking_no'] }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Reservation Date:</strong> {{ \Carbon\Carbon::parse($booking['created_at'])->format('d F Y H:i') }}
        </div>
    </div>

    <!-- AGENCY -->
    <div class="section-title">Agency Details</div>
    <div class="small-text">
        <strong>{{ $agency->name ?? $booking['user']['name'] }}</strong><br>
        Business Address: {{ $agency->address ?? '' }}<br>
        Phone: {{ $agency->user->phone_no ?? $booking['user']['phone_no'] }}<br>
        Email: {{ $agency->user->email ?? '' }}
    </div>

    <!-- TRAVELERS -->
    <div class="section-title">Travelers</div>
    <table class="table small-text">
        <thead>
            <tr>
                <th width="35%">Traveler Name</th>
                <th width="20%">Birth Date</th>
                <th width="35%">Phone Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->dob }}</td>
                <td>{{ $customer->phone_no }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ONE WAY -->
    <div class="section-title">Flight Details – One Way</div>
    <div class="flight-box">
        <div class="flight-header">
            {{ $booking['pnr']['airline']['name'] }} ({{ $booking['pnr']['airline']['code'] }}) – Flight {{ $booking['pnr']['flight_no'] }} – {{ \Carbon\Carbon::parse($booking['pnr']['departure_date'])->format('d F Y') }}
            <!-- <span class="right">Operated by ITA</span> -->
        </div>
        <div class="clearfix"></div>

        <table class="small-text">
            <tr>
                <td><strong>Class:</strong> Economy</td>
                <td><strong>Fare Class:</strong> {{ $booking['pnr']['class'] }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Baggage:</strong> ADT – {{ $booking['pnr']['baggage'] }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Departure:</strong><br>
                    {{ \Carbon\Carbon::parse($booking['pnr']['departure_time'])->format('H:i') }} – {{ $booking['pnr']['departure']['name'] }} ({{ $booking['pnr']['departure']['code'] }}) – {{ $booking['pnr']['departure']['country'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Arrival:</strong><br>
                    {{ \Carbon\Carbon::parse($booking['pnr']['arrival_time'])->format('H:i') }} – {{ $booking['pnr']['arrival']['name'] }} ({{ $booking['pnr']['arrival']['code'] }}) – {{ $booking['pnr']['arrival']['country'] }}
                </td>
            </tr>
        </table>
    </div>

    <!-- RETURN -->
     @if($booking['pnr']['pnr_type'] == 'return')
    <div class="section-title">Flight Details – {{ \Illuminate\Support\Str::camel($booking['pnr']['pnr_type']) }}</div>
    <div class="flight-box">
        <div class="flight-header">
            {{ $booking['pnr']['return_airline']['name'] }} ({{ $booking['pnr']['return_airline']['code'] }}) – Flight {{ $booking['pnr']['flight_no'] }} – {{ \Carbon\Carbon::parse($booking['pnr']['return_departure_date'])->format('d F Y') }}
            <!-- <span class="right">Operated by ITA</span> -->
        </div>
        <div class="clearfix"></div>

        <table class="small-text">
            <tr>
                <td><strong>Class:</strong> Economy</td>
                <td><strong>Fare Class:</strong> {{ $booking['pnr']['class'] }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Baggage:</strong> ADT – {{ $booking['pnr']['baggage'] }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Departure:</strong><br>
                    {{ $booking['pnr']['return_departure_time'] }} – {{ $booking['pnr']['return_departure']['name'] }} ({{ $booking['pnr']['return_departure']['code'] }}) – {{ $booking['pnr']['return_departure']['country'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Arrival:</strong><br>
                    {{ $booking['pnr']['return_arrival_time'] }} – {{ $booking['pnr']['return_arrival']['name'] }} ({{ $booking['pnr']['return_arrival']['code'] }}) – {{ $booking['pnr']['return_arrival']['country'] }}
                </td>
            </tr>
        </table>
    </div>
    @endif
    <div class="footer">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="small">
                    We appreciate your business and wish you safe travels.
                </td>
            </tr>
        </table>
    </div>

</div>
