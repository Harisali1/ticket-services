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
            ({{ $booking['pnr']['departure']['code'] }}) → ({{ $booking['pnr']['arrival']['code'] }}) → ({{ $booking['pnr']['return_arrival']['code'] }})
        </div>

        <div class="reservation-box">
            <strong>Reservation Number:</strong> {{ $booking['booking_no'] }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Reservation Date:</strong> {{ $booking['booking_date'] }}
        </div>
    </div>

    <!-- AGENCY -->
    <div class="section-title">Agency Details</div>
    <div class="small-text">
        <strong>AMK SERVIZIO DI KHAN ATTA MUHAMMAD</strong><br>
        Corso G Mazzini 71<br>
        Santa Croce Sull Arno 56029<br>
        Phone: 3333713515<br>
        Email: AMKSERVIZIO@GMAIL.COM
    </div>

    <!-- TRAVELERS -->
    <div class="section-title">Travelers</div>
    <table class="table small-text">
        <thead>
            <tr>
                <th width="10%">PTC</th>
                <th width="35%">Traveler Name</th>
                <th width="20%">Birth Date</th>
                <th width="35%">Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ADT</td>
                <td>Name Name</td>
                <td>22 May 1999</td>
                <td>+92 344 1231231</td>
            </tr>
        </tbody>
    </table>

    <!-- ONE WAY -->
    <div class="section-title">Flight Details – One Way</div>
    <div class="flight-box">
        <div class="flight-header">
            ITA Airways (AZ) – Flight 854 – 31 January 2026
            <span class="right">Operated by ITA</span>
        </div>
        <div class="clearfix"></div>

        <table class="small-text">
            <tr>
                <td><strong>Class:</strong> Economy</td>
                <td><strong>Fare Class:</strong> Y</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Baggage:</strong> ADT – 2 PC</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Departure:</strong><br>
                    15:10 – Rome (FCO), Fiumicino – Italy
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Arrival:</strong><br>
                    20:10 – Dakar (DSS), Blaise Diagne – Senegal
                </td>
            </tr>
        </table>
    </div>

    <!-- RETURN -->
    <div class="section-title">Flight Details – Return</div>
    <div class="flight-box">
        <div class="flight-header">
            ITA Airways (AZ) – Flight 855 – 14 February 2026
            <span class="right">Operated by ITA</span>
        </div>
        <div class="clearfix"></div>

        <table class="small-text">
            <tr>
                <td><strong>Class:</strong> Economy</td>
                <td><strong>Fare Class:</strong> Y</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Baggage:</strong> ADT – 2 PC</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Departure:</strong><br>
                    23:50 – Dakar (DSS), Blaise Diagne – Senegal
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Arrival:</strong><br>
                    06:20 – Rome (FCO), Fiumicino – Italy
                </td>
            </tr>
        </table>
    </div>

</div>
