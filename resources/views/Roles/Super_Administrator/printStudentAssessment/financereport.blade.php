<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International School of Asia and the Pacific</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            justify-content: center;
            box-sizing: border-box;
        }

        .location {
            font-size: 18px;
            margin-top: 10px;
        }

        .container {
            width: auto;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            width: 100%;
        }

        img {
            vertical-align: middle;
            width: 60px;
        }

        .column {
            float: left;
            width: 30%;
            display: flex;
            flex-direction: column;
            max-height: 300px;
            padding-left: 30px;
        }

        .header span {
            vertical-align: middle;
            font-weight: bold;
            font-size: 14px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .center {
            text-align: center;
        }

        .border {
            border-top: 1px solid black;
            font-size: 10px;
        }

        th,
        td {
            text-align: left;
        }

        /* th {
        text-decoration: underline;
    } */

        .border-bottom {
            border-bottom: 1px solid black;
            font-size: 10px;
        }


        label {
            font-size: 11px;
        }

        label b {
            border-bottom: 1px solid black;
        }

        .border-all {
            border: 1px solid black;
            font-size: 10px;
        }

        .header p {
            position: absolute;
            left: 37%;
            font-weight: bold;
            margin-top: 40px;
            font-size: 11px;
        }

        .container {
            margin-top: 40px;
        }

        table {
            font-size: 9px;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header p {
            position: absolute;
            left: 37%;
            font-weight: bold;
            margin-top: 40px;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">

            <div style="text-align: center;">
                <img src="{{ asset('frontend/assets/images/Medical_Colleges_of_Northern_Philippines_(MCNP)_Logo.jpg') }}"
                    alt="" style="vertical-align: middle;">
                <div style="display: inline-block; text-align: center;">
                    <div>Medical Colleges of Northern Philippines
                        <div>International School of Asia and the Pacific</div>
                    </div>
                    <div style="font-size: 12px;"><b>ALIMANAO PEÑABLANCA, CAGAYAN</b></div>
                </div>
                <img src="{{ asset('frontend/assets/images/ISAP_LOGO_NO_BG.png') }}" alt=""
                    style="margin-left: 10px;">
                _________________________________________________________________________
            </div>
        </div>
        @if ($dateFrom == $dateTo)
            <p>{{ \Carbon\Carbon::parse($dateFrom)->format('l, F j, Y') }}</p>
        @else
            <p>{{ \Carbon\Carbon::parse($dateFrom)->format('l, F j, Y') }} to
                {{ \Carbon\Carbon::parse($dateTo)->format('l, F j, Y') }}</p>
        @endif
        <table>
            <tr>
                <th>NAME</th>
                <th>OR #</th>
                <th>TFEE</th>
                <th>NON ASSESSED</th>
                <th>MISC FEE</th>
                <th>OTHER FEE</th>
                <th style="width: 50px;">Investiture/FC/COC/BATTERY EXAM/ SUCCESS PLUS</th>
                <th>GRAD FEE/ LAB/DORM/SUHAY</th>
                <th>TOTAL</th>
            </tr>
            @foreach ($collects as $coll)
                <tr>
                    <td>{{ $coll['first_name'] }} {{ $coll['last_name'] }}</td>
                    <td>{{ $coll['or_number'] }}</td>
                    <td>{{ $coll['tutionFees'] }}</td>
                    <td>{{ $coll['otherFees'] }}</td>
                    <td>{{ $coll['MiscFee'] }}</td>
                    <td>{{ $coll['OTHERFEES'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <td><b>TOTAL COLLECTION</b></td>
                <td></td>
                <td><b>{{ $totalTutionFees }}</b></td>
                <td><b>{{ $OtherFees }}</b></td>
                <td><b>{{ $totalMiscFee }}</b></td>
                <td><b>{{ $OtherFees2 }}</b></td>
                <td></td>
                <td></td>
                @php
                    $totalFees = $totalTutionFees + $OtherFees + $totalMiscFee + $OtherFees2;
                @endphp
                <td><b>{{ $totalFees }}</b></td>
            </tr>
        </table>

    </div>
</body>

</html>
