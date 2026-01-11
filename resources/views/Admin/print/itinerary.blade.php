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
        padding: 6px 10px;
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
        float: right;
        font-size: 11px;
    }

    .clearfix {
        clear: both;
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div class="route">
            ({{ $booking['pnr']['departure']['code'] }}) → ({{ $booking['pnr']['arrival']['code'] }}) {{ (isset($booking['pnr']['return_arrival'])) ? '→ ('.$booking['pnr']['return_arrival']['code'].')' : ''}}
        </div>

        <div class="reservation-box">
            <strong>Reservation Number:</strong> {{ $booking['booking_no'] }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Reservation Date:</strong> {{ $booking['created_at'] }}
        </div>
    </div>

    <!-- AGENCY -->
    <div class="section-title">Agency Details</div>
    <div class="small-text">
        <strong>{{ $booking['user']['name'] }}</strong><br>
        <strong>Phone:</strong> {{ $booking['user']['phone_no'] }}<br>
        <strong>Email:</strong> {{ $booking['user']['email'] }}
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
                    {{ $booking['pnr']['departure_time'] }} – {{ $booking['pnr']['departure']['name'] }} ({{ $booking['pnr']['departure']['code'] }}) – {{ $booking['pnr']['departure']['country'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Arrival:</strong><br>
                    {{ $booking['pnr']['arrival_time'] }} – {{ $booking['pnr']['arrival']['name'] }} ({{ $booking['pnr']['arrival']['code'] }}) – {{ $booking['pnr']['arrival']['country'] }}
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

</div>
