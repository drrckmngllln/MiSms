<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCNPI-ISAP</title>
</head>
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

    .hidden-row {
        display: none;
    }

    .testing {

        left: 100px;
    }

    table {
        margin: 0 auto;
        width: 95%;

    }
</style>

<body>
    <div class="container">
        <div class="header">

            <span><img src="" alt="">
            </span>

            {{-- <p>ALIMANAO PEÑABLANCA, CAGAYAN</p> --}}

        </div>
        <br>
        @foreach ($studentData as $student)
            <div class="row">
                <div class="column">
                    <label>Name: <b>{{ $student['fullname'] }}</b></label><br>
                    <label>ID No.: <b>{{ $student['id_number'] }}</b></label>
                </div>
                <div class="column">
                    <label>Course/Yr: <b>{{ $student['course_id'] }} / {{ $student['year_level'] }}</b></label>
                </div>
                <div class="column">
                    <label>Period: <b>{{ $student['semester'] }} / {{ $student['schoolYear'] }}</b></label><br>
                    <label>Date: <b>{{ now()->format('Y-m-d') }}</b></label>
                </div>
            </div>
        @endforeach
        <br>
        <table class="table border">
            <thead>
                <tr class="border-bottom">
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Units</th>
                    <th>Lab</th>
                    <th>Schedule</th>
                    <th>Instructor</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studentDataSubject as $subject)
                    <tr class="border-bottom">
                        <td>{{ $subject['code'] }}</td>
                        <td>{{ $subject['descriptive_tittle'] }}</td>
                        <td>{{ $subject['lecture_units'] }}</td>
                        <td>{{ $subject['lab_units'] }}</td>
                        <td>
                            @if (isset($subject['schedule']))
                                {{ $subject['schedule'] }}
                            @endif
                        </td>
                        <td>
                            @if (isset($subject['instructor']))
                                {{ $subject['instructor'] }}
                            @endif
                        </td>
                        <td>{{ $subject['section_id'] }}</td>
                    </tr>
                @endforeach
                <tr class="testing">
                    <td colspan="2" style="text-align: right;"><b>Total Units:</b></td>
                    <td><b>{{ array_sum(array_column($studentDataSubject, 'lecture_units')) }}</b></td>
                    <td><b>{{ array_sum(array_column($studentDataSubject, 'lab_units')) }}</b></td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
        <br>

        <table class="border" style="width: 100%; max-height: 100vh;">
            <tr>
                <th>Assessment</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
            <!-- Tuition Fees Section -->

            <tr>
                <td>
                    <b>Tuition Fees</b> <br>
                    @foreach ($tuitionFees as $fee)
            <tr>
                <td>{{ $fee['fee_type'] }} ({{ $fee['amount'] }} x
                    {{ array_sum(array_column($studentDataSubject, 'lecture_units')) }})</td>
                <td>{{ number_format($fee['amount'] * array_sum(array_column($studentDataSubject, 'lecture_units')), 2) }}
                </td>
                @endforeach
                <td>
                    {{ number_format($fee['amount'] * array_sum(array_column($studentDataSubject, 'lecture_units')), 2) }}
                </td>
            </tr>



            <tr>
                <td>
                    <b>Laboratory Fees</b> <br>
                    @php
                        $totalLaboratoryFees = 0;
                        $totalLabUnits = array_sum(array_column($studentDataSubject, 'lab_units'));
                    @endphp
                    @foreach ($laboratoryFees as $fee)
            <tr>
                <td>{{ $fee['fee_type'] }} ({{ $fee['amount'] }} x {{ $totalLabUnits }})</td>
                <td>
                    {{ number_format($fee['amount'] * $totalLabUnits, 2) }}
                </td>
                @php
                    $totalLaboratoryFees += $fee['amount'] * $totalLabUnits;
                @endphp
            </tr>
            @endforeach
            <tr>
                <td><b></b></td>
                <td>{{ number_format($totalLaboratoryFees, 2) }}</td>
            </tr>
            </td>
            </tr>



            <tr>
                <td>
                    <b>Miscellaneous Fees</b> <br>
                    @php
                        $totalMiscellaneousFees = 0;
                    @endphp
                    @foreach ($miscellaneousFees as $fee)
            <tr>
                <td>{{ $fee['fee_type'] }}</td>
                <td>{{ number_format($fee['amount'], 2) }}</td>
                @php
                    $totalMiscellaneousFees += $fee['amount']; // Add to total
                @endphp
                @endforeach
                <td>{{ number_format($totalMiscellaneousFees, 2) }}</td>
            </tr>


            </td>
            <td style="vertical-align: bottom;">
            </td>
            </tr>
            <tr>
                <td>
                    <b>Other Fees</b> <br>
                    @php
                        $totalOtherFees = 0;
                    @endphp
                    @foreach ($otherFees as $fee)
            <tr>
                <td>{{ $fee['fee_type'] }}</td>
                <td>{{ number_format($fee['amount'], 2) }}</td>
                @php
                    $totalOtherFees += $fee['amount']; // Add to total
                @endphp
                @endforeach
                <td>{{ number_format($totalOtherFees, 2) }}</td>
            </tr>

            <td>



                <!-- MCNP -->


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td><b>Discount</b></td>
                    @foreach ($totalAssessment as $ass)
                        <td>{{ $ass['discount'] ?? '0.0' }}</td>
                        <td>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Total Assessment</b></td>
                    @foreach ($totalAssessment as $ass)
                        <td></td>

                        <td>
                            <b>{{ $ass['assessment'] }}</b>
                        </td>
                    @endforeach
                </tr>
        </table>
        <br>
        <table style="width: 100%; font-size: 10px;">
            <tr>
                <th class="border-bottom center">Summary</th>
                <th class="border-bottom center">Amount</th>
                <th style="border: none;"></th>
                <th class="border-bottom center">Payment Schedule</th>
                <th class="border-bottom center">Amount</th>
                <th class="border-bottom center">Total</th>

            </tr>
            <tr>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">Current Assessment</td>
                    <td class="border-bottom">{{ $ass['assessment'] }}</td>
                @endforeach
                <td></td>
                <td class="border-bottom">Down</td>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">{{ $ass['downpayment'] }}</td>
                @endforeach
                <td class="border-bottom"></td>


            </tr>
            <tr>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">Discounts/Scholarships</td>
                    <td class="border-bottom">{{ $ass['discountName'] }}</td>
                @endforeach
                <td></td>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">Prelims</td>
                    <td class="border-bottom">{{ $ass['prelims'] }}</td>
                @endforeach

                <td class="border-bottom"></td>
            </tr>
            <tr>
                <td class="border-bottom">Previous Balance</td>
                <td class="border-bottom">
                </td>

                <td></td>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">Midterms</td>
                    <td class="border-bottom">{{ $ass['midterms'] }}</td>
                @endforeach
                <td class="border-bottom"></td>
            </tr>
            <tr>
                <td class="border-bottom">Current Receivable</td>
                <td class="border-bottom"></td>
                <td></td>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">Semi-Finals</td>
                    <td class="border-bottom">{{ $ass['semifinals'] }}</td>
                @endforeach
                <td class="border-bottom"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom">Finals</td>
                    <td class="border-bottom">{{ $ass['finals'] }}</td>
                @endforeach
                @foreach ($totalAssessment as $ass)
                    <td class="border-bottom"><b>{{ $ass['assessment'] }}</b></td>
                @endforeach
            </tr>
        </table>
    </div>
</body>

</html>
