<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Receipts Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }

        h1,
        h2 {
            text-align: center;
            font-size: 16px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .right-align {
            text-align: right;
        }

        table,
        th,
        td {
            border: none;
        }
    </style>
</head>

<body>
    <h1>{{ $campus }}</h1>
    <h2>Official Receipts Listing ({{ $date }})</h2>
    <table>
        <thead>
            <tr>

                <th>Cashier</th>
                <th>Date</th>
                <th>OR No</th>
                <th>Name</th>
                <th>Period</th>
                <th>Dept</th>
                <th>Bank</th>
                <th>Check No</th>
                <th class="right-align">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0;
            @endphp
            @foreach ($data as $index => $datas)
                @php
                    $totalAmount += $datas['amount']; // Accumulate the total
                @endphp
                <tr>
                    <!-- Only display the date in the first row -->
                    <td>{{ $index === 0 ? $datas['name'] : '' }}</td>
                    <td>{{ $index === 0 ? $datas['date'] : '' }}</td>
                    <td>{{ $datas['or_number'] }}</td>
                    <td>{{ $datas['id_number'] }}</td>
                    <td>{{ $datas['period'] }}</td>
                    <td>{{ $datas['dept'] }}</td>
                    <td>{{ $datas['bank'] }}</td>
                    <td>{{ $datas['check_no'] }}</td>
                    <td class="right-align">{{ $datas['amount'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="8" class="right-align"><strong>Total</strong></td>
                <td class="right-align"><strong>{{ number_format($totalAmount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
