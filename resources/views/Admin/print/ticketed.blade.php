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

            .info-table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 10px;
            }

            .info-table th {
                text-align: left;
                font-weight: 700;
                padding: 8px 4px;
                font-size: 14px;
                color: #000;
            }

            .info-table td {
                padding: 6px 4px 12px 4px;
                font-size: 14px;
                color: #000;
            }

            .info-table thead tr {
                border-bottom: 1px solid #000;
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
                text-align: right;
            }

        </style>
    </head>

    <body>
        <div class="container">

            <!-- HEADER -->
            <table style="margin-bottom:6px;">
                <tr>
                    <td width="60%">
                        <img src="{{ auth()->user()->logo ? public_path('storage/' . auth()->user()->logo) : public_path('images/logo-placeholder.png') }}" style="height:45px;">
                    </td>
                    <td width="40%" class="right">
                        <strong style="font-size:15px;">E-Ticket / Flight Itinerary</strong><br>
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
                        <td>{{ $customers->map(fn ($c) => $c->name.' '.$c->surname)->implode(', ') }}</td>
                        <td>{{ $type == 'dept' ? $booking['dept_ticket_no'] : $booking['arr_ticket_no'] }}</td>
                        <td>{{ $booking['booking_no'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking['created_at'])->format('d F Y') }}</td>
                    </tr>
                </tbody>
            </table>


            <!-- AGENCY -->
            <div class="title-bar">Agency Details</div>
            <div class="small">
                <strong>{{ $agency->name ?? $booking['user']['name'] }}</strong><br>
                Business Address: {{ $agency->address ?? '' }}<br>
                Phone: {{ $agency->user->phone_no ?? $booking['user']['phone_no'] }}<br>
                Email: {{ $agency->user->email ?? '' }}
            </div>

            <!-- FLIGHT -->
            <div class="title-bar">Flight Information</div>
            <div class="flight-header">
                @if($type == 'dept')
                    ✈ {{ $booking['pnr']['airline']['name'] }} ({{ $booking['pnr']['airline']['code'] }}) – 
                    Flight {{ $booking['pnr']['flight_no'] }} – {{ \Carbon\Carbon::parse($booking['pnr']['departure_date'])->format('d F Y') }}
                @else
                    ✈ {{ $booking['return_pnr']['airline']['name'] }} ({{ $booking['return_pnr']['airline']['code'] }}) – 
                    Flight {{ $booking['return_pnr']['flight_no'] }} – {{ \Carbon\Carbon::parse($booking['return_pnr']['departure_date'])->format('d F Y') }}
                @endif
            </div>


            <table class="flight-table">
                <tr>
                    <td width="45%">
                        @if($type == 'dept')
                            <div class="label">Departure</div>
                            {{ $booking['pnr']['departure']['name'] }}<br>
                            <strong>{{ \Carbon\Carbon::parse($booking['pnr']['departure_time'])->format('H:i') }}</strong>
                        @else
                            <div class="label">Departure</div>
                            {{ $booking['return_pnr']['departure']['name'] }}<br>
                            <strong>{{ \Carbon\Carbon::parse($booking['return_pnr']['departure_time'])->format('H:i') }}</strong>
                        @endif
                    </td>

                    <td width="10%" class="center">➜</td>
                    @if($booking['pnr']['middle_arrival_id'] != null && $booking['pnr']['middle_arrival_time'] != null && $booking['pnr']['rest_time'] != null)
                        <td width="45%">
                            <div class="label">Middle Arrival</div>
                            {{ $booking['pnr']['middle_arrival']['name'] }}<br>
                            <strong>{{ \Carbon\Carbon::parse($booking['pnr']['middle_arrival_time'])->format('H:i') }}</strong>
                        </td>

                        <td width="10%" class="center">➜</td>

                        <td width="45%">
                            <div class="label">Middle Departure</div>
                            {{ $booking['pnr']['middle_arrival']['name'] }}<br>
                            <strong>{{ \Carbon\Carbon::parse($booking['pnr']['rest_time'])->format('H:i') }}</strong>
                        </td>

                        <td width="10%" class="center">➜</td>
                    @endif
                    <td width="45%">
                        @if($type == 'dept')
                            <div class="label">Arrival</div>
                            {{ $booking['pnr']['arrival']['name'] }}<br>
                            <strong>{{ \Carbon\Carbon::parse($booking['pnr']['arrival_time'])->format('H:i') }}</strong>
                        @else
                            <div class="label">Arrival</div>
                            {{ $booking['return_pnr']['arrival']['name'] }}<br>
                            <strong>{{ \Carbon\Carbon::parse($booking['return_pnr']['arrival_time'])->format('H:i') }}</strong>
                        @endif
                    </td>
                </tr>
            </table>
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
            </table>

            <!-- BAGGAGE -->
            <div class="title-bar">Baggage Allowance</div>
            <div class="baggage-box">
                <strong>Checked:</strong> {{ $booking['pnr']['baggage'] }} |
                <strong>Hand:</strong> 8 KG
            </div>

            <!-- SPECIAL REQUEST -->
            <div class="title-bar">Special Service Request</div>
            <div class="baggage-box">
                <strong>Meal:</strong> {{ $booking['meal'] }} |
                <strong>Wheel Chair:</strong> {{ $booking['wheel_chair'] }}
            </div>

            <!-- FARE RULES -->
            <div class="title-bar" style="margin-top:10px;">Fare Rules</div>

            <table style="border:1px solid #ccc; page-break-inside:avoid;">
                <tr>
                    <td style="font-size:9px; line-height:1.15; padding:4px; white-space:pre-line;">
                        <b style="font-size:15px;"> . </b>Modifiche e cancellazioni (chiaro e trasparente)
                        <b style="font-size:15px;"> . </b>Cambio data fino a 10 giorni prima della partenza Gratuito – si paga solo l’eventuale differenza tariffaria.
                        <b style="font-size:15px;"> . </b>Cambio data da 9 a 3 giorni prima della partenza Penale di 100 € + differenza tariffaria.
                        <b style="font-size:15px;"> . </b>Cancellazione fino a 10 giorni prima della partenza Penale di 100 € a tratta.
                        <b style="font-size:15px;"> . </b>Cancellazione da 7 a 3 giorni prima della partenza Penale di 150 € a tratta.
                        <b style="font-size:15px;"> . </b>No-Show (mancata presentazione al volo) Nessun rimborso previsto. Il biglietto è considerato No-Show se la richiesta avviene entro 3 giorni dalla partenza.
                        <b style="font-size:15px;"> . </b>Cambio data in caso di No-Show Penale di 150 € + differenza tariffaria.
                        <b style="font-size:15px;"> . </b>Bagaglio a mano
                        <b style="font-size:15px;"> . </b>Adulti e bambini (Child): 8 kg
                        <b style="font-size:15px;"> . </b>Neonati (Infant): 10 kg
                        <b style="font-size:15px;"> . </b>Vi ricordiamo gentilmente di confermare l’orario del vostro volo 3 giorni prima della partenza
                    </td>
                </tr>
            </table>

            <!-- FOOTER -->
            <div class="footer text-right">
                We appreciate your business and wish you safe travels.
            </div>

        </div>
    </body>
</html>
