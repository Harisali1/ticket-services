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
            background: #e9ecef;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 14px;
            border-left: 4px solid #0d6efd;
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
            border: 1px solid #ccc;
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
    </style>
</head>

<body>

<div class="container">

    <!-- TRAVELER -->
    <div class="title-bar">Traveler Information</div>
    <table class="info-table">
        <thead>
            <th class="text-left">Passenger</th>
            <th class="text-left">E-Ticket No</th>
            <th class="text-left">Booking Ref</th>
            <th class="text-left">Issue Date</th>
        <thead>
        <tr>
            <td width="25%" class="text-center">
                DIALLO, YORO
            </td>
            <td width="25%">
                @if($type == 'dept')
                    <div class="value">{{ $booking['dept_ticket_no'] }}</div>
                @else
                    <div class="value">{{ $booking['arr_ticket_no'] }}</div>
                @endif
            </td>
            <td width="25%">
                <div class="value">{{ $booking['booking_no'] }}</div>
            </td>
            <td width="25%">
                <div class="value">{{ \Carbon\Carbon::parse($booking['created_at'])->format('d F Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- AGENCY -->
    <div class="title-bar">Agency Details</div>
    <div class="small">
        <strong>{{ $booking['user']['name'] }}</strong><br>
        Corso G Mazzini 71, Santa Croce Sull Arno 56029, IT<br>
        Phone: {{ $booking['user']['phone_no'] }}<br>
        Email: {{ $booking['user']['email'] }}
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
                    <strong>{{ $booking['pnr']['departure_time'] }}</strong>
                @else
                    {{ $booking['pnr']['return_departure']['name'] }} ({{ $booking['pnr']['return_departure']['code'] }}), {{ $booking['pnr']['return_departure']['country'] }}<br>
                    <strong>{{ $booking['pnr']['return_departure_time'] }}</strong>
                @endif
            </td>

            <td width="10%" class="center">
                ➜
            </td>

            <td width="45%">
                <div class="label">Arrival</div>
                 @if($type == 'dept')
                    {{ $booking['pnr']['arrival']['name'] }} ({{ $booking['pnr']['arrival']['code'] }}), {{ $booking['pnr']['arrival']['country'] }}<br>
                    <strong>{{ $booking['pnr']['arrival_time'] }}</strong>
                @else
                    {{ $booking['pnr']['return_arrival']['name'] }} ({{ $booking['pnr']['return_arrival']['code'] }}), {{ $booking['pnr']['return_arrival']['country'] }}<br>
                    <strong>{{ $booking['pnr']['return_arrival_time'] }}</strong>
                @endif
            </td>
        </tr>
    </table>

    <!-- FARE -->
    <table class="flight-table" style="margin-top:8px;">
        <tr>
            <td width="40%">
                <div class="label">Confirmation No</div>
                -
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
                
            </td>
            <td colspan="2">
                <div class="label">Validity</div>
                Not valid before / after
            </td>
        </tr>
    </table>

    <!-- BAGGAGE -->
    <div class="title-bar">Baggage Allowance</div>
    <div class="baggage-box small">
        <strong>Checked Baggage:</strong> {{ $booking['pnr']['baggage'] }}<br>
        <strong>Hand Carry:</strong> 8 KG
    </div>

</div>

</body>
</html>
