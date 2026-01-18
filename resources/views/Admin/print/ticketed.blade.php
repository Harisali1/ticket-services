<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Flight Ticket</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #000;
        }

        .container {
            border: 1px solid #ccc;
            padding: 14px;
        }

        .title-bar {
            background: #ccccccff;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 14px;
            border-left: 4px solid #000000ff;
            margin-bottom: 8px;
        }

        .section {
            margin-bottom: 14px;
        }

        .label {
            font-weight: bold;
            color: #444;
            font-size: 12px;
        }

        .value {
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 8px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        .flight-header {
            background: #f1f1f1;
            font-weight: bold;
            padding: 8px;
            font-size: 13px;
        }

        .flight-table td {
            padding: 8px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .small {
            font-size: 12px;
        }

        .baggage-box {
            border: 1px dashed #999;
            padding: 8px;
        }
        @page {
            margin: 20px 14px 60px 14px; /* bottom space for footer */
        }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 14px;
            right: 14px;
            font-size: 11px;
        }
    </style>
</head>

<body>

<div class="container">

            <!-- HEADER -->
    <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
        <tr>
            <td width="60%">
                <img 
                    src="{{ public_path('images/logo.jpg') }}" 
                    style="height:50px;"
                >
            </td>
            <td width="40%" class="right">
                <strong style="font-size:16px;">E-Ticket / Flight Itinerary</strong><br>
                <span class="small">Generated on {{ now()->format('d F Y') }}</span>
            </td>
        </tr>
    </table>

    <!-- TRAVELER -->
    <div class="title-bar">Traveler Information</div>
    <table class="info-table" width="100%" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th>Passenger</th>
            <th>E-Ticket No</th>
            <th>Booking Ref</th>
            <th>Issue Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $customers->pluck('name')->implode(', ') }}</td>
            <td>{{ $type == 'dept' ? $booking['dept_ticket_no'] : $booking['arr_ticket_no'] }}</td>
            <td>{{ $booking['booking_no'] }}</td>
            <td>{{ \Carbon\Carbon::parse($booking['created_at'])->format('d F Y') }}</td>
        </tr>
    </tbody>
</table>


    <!-- AGENCY -->
    <div class="title-bar">Agency Details</div>
    <div class="small">
        <strong>{{ (isset($agency->name)) ? $agency->name : $booking['user']['name'] }}</strong><br>
        Address: {{ (isset($agency->address)) ? $agency->address : '' }}<br>
        Phone: {{ (isset($agency->user->phone_no)) ? $agency->user->phone_no : $booking['user']['phone_no'] }}<br>
        Email: {{ (isset($agency->user->email)) ? $agency->user->email : '' }}
    </div>

    <!-- FLIGHT -->
    <div class="title-bar">Flight Information</div>
    <div class="flight-header">
        ✈ {{ $booking['pnr']['airline']['name'] }} ({{ $booking['pnr']['airline']['code'] }}) – Flight {{ $booking['pnr']['flight_no'] }} – {{ \Carbon\Carbon::parse($booking['pnr']['departure_date'])->format('d F Y') }}
    </div>

    <table class="flight-table">
        <tr>
            <td width="45%">
                <div class="label">Departure</div>
                @if($type == 'dept')
                    {{ $booking['pnr']['departure']['name'] }} ({{ $booking['pnr']['departure']['code'] }}), {{ $booking['pnr']['departure']['country'] }}<br>
                    <strong>{{ \Carbon\Carbon::parse($booking['pnr']['departure_time'])->format('H:i') }}</strong>
                @else
                    {{ $booking['pnr']['return_departure']['name'] }} ({{ $booking['pnr']['return_departure']['code'] }}), {{ $booking['pnr']['return_departure']['country'] }}<br>
                    <strong>{{ \Carbon\Carbon::parse($booking['pnr']['return_departure_time'])->format('H:i') }}</strong>
                @endif
            </td>

            <td width="10%" class="center">
                ➜
            </td>

            <td width="45%">
                <div class="label">Arrival</div>
                 @if($type == 'dept')
                    {{ $booking['pnr']['arrival']['name'] }} ({{ $booking['pnr']['arrival']['code'] }}), {{ $booking['pnr']['arrival']['country'] }}<br>
                    <strong>{{ \Carbon\Carbon::parse($booking['pnr']['arrival_time'])->format('H:i') }}</strong>
                @else
                    {{ $booking['pnr']['return_arrival']['name'] }} ({{ $booking['pnr']['return_arrival']['code'] }}), {{ $booking['pnr']['return_arrival']['country'] }}<br>
                    <strong>{{ \Carbon\Carbon::parse($booking['pnr']['return_arrival_time'])->format('H:i') }}</strong>
                @endif
            </td>
        </tr>
    </table>

    <!-- FARE -->
    <table class="flight-table" style="margin-top:8px;">
        <tr>
            <td width="40%">
                <div class="label">Confirmation No</div>
                {{ $booking['pnr']['ref_no'] }}
            </td>
            <td width="20%">
                <div class="label">Class</div>
                Economy
            </td>
            <td width="40%">
                <div class="label">Status</div>
                Ticketed
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Base Fare</div>
                {{ $booking['total_amount'] }}
            </td>
        </tr>
    </table>

    <!-- BAGGAGE -->
    <div class="title-bar">Baggage Allowance</div>
    <div class="baggage-box small">
        <strong>Checked Baggage:</strong> {{ $booking['pnr']['baggage'] }}<br>
        <strong>Hand Carry:</strong> 8 KG
    </div>
    <!-- FOOTER -->
    <div class="footer">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="small">
                    This is a system generated ticket and does not require a signature.
                </td>
                <td class="small right">
                    Generated on {{ now()->format('d F Y H:i') }}
                </td>
            </tr>
        </table>
    </div>


</div>

</body>
</html>
