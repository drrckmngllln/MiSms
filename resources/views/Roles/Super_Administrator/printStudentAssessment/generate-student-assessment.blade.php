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
</style>

<body>
    <div class="container">
        <div class="header">
            @foreach ($studentData as $student)
                <span><img src="{{ $student['campusLogo'] }}" alt="">
                    {{ $student['campus'] }}</span>
            @endforeach
            <p>ALIMANAO PEÑABLANCA, CAGAYAN</p>

        </div>
        <br>
        <div class="row">
            @foreach ($studentData as $studentBasicInfo)
                <div class="column">
                    <label for="">Name:
                        <b>{{ $studentBasicInfo['first_name'] . ' ' . $studentBasicInfo['last_name'] }}</b></label><br>
                    <label for="">ID No.: <b>{{ $studentBasicInfo['id_number'] }}</b></label>
                </div>
                <div class="column">
                    <label for="">Course/Yr:
                        <b>{{ $studentBasicInfo['course_id'] }}-{{ $studentBasicInfo['yearlevel'] }} </b></label>
                </div>
                <div class="column">

                    <label for="">Period:<b>{{ $studentBasicInfo['schoolYear'] }} -
                            {{ $studentBasicInfo['semester'] }}</b> </label><br>
                    <label for="">Date: <b>{{ $studentBasicInfo['date'] }}</b></label>
                </div>
            @endforeach
        </div>
        <br>
        <table class="border" style="width: 100%;">
            <tr class="border-bottom">
                <th>Subject Code</th>
                <th>Subject Description</th>
                <th>Units</th>

                <th>Lab</th>
                <th>Schedule</th>
                <th>Instructor</th>
                <th>Section</th>
            </tr>
            @foreach ($studentData as $data)
                @php
                    // $subjectsArray = explode(', ', $data['subjects']);
                    $subjectsArray = explode('#$% ', $data['subjects']);
                    // dd($subjectsArray);
                    $unitsArray = explode('#$% ', $data['units']);
                    $labUnitsArray = explode(',', $data['labunits']);
                    $SubjectCode = explode('#$% ', $data['subjectCode']);
                    $instructors = explode('#$% ', $data['instructors']);

                    $times = explode('#$% ', $data['time']);
                    $rooms = explode('#$% ', $data['room']);
                    $days = explode('#$% ', $data['day']);
                    $laboratories = explode(', ', $data['laboratory']);
                    $section_ids = $data['section_id'];

                @endphp
                @foreach ($subjectsArray as $index => $subject)
                    @php
                        $units = isset($unitsArray[$index]) ? $unitsArray[$index] : '';
                        $lab_units = isset($labUnitsArray[$index]) ? $labUnitsArray[$index] : '';
                        $Subject_Code = isset($SubjectCode[$index]) ? $SubjectCode[$index] : '';
                        $instructor = isset($instructors[$index]) ? $instructors[$index] : '';
                        $time = isset($times[$index]) ? $times[$index] : '';
                        $room = isset($rooms[$index]) ? $rooms[$index] : '';
                        $day = isset($days[$index]) ? $days[$index] : '';
                        $section_id = isset($section_ids[$index]) ? $section_ids[$index] : '';

                    @endphp
                    <tr class="border-bottom">
                        <td>{{ $Subject_Code }}</td>
                        <td>{{ $subject }}</td>
                        <td>{{ $units }}</td>

                        <td>{{ $lab_units > 0 ? $lab_units : '0' }}</td>
                        <td><span>{{ $time ?: '' }}</span>
                            <span>{{ $room }}</span> <span>{{ $day }}</span>
                        </td>
                        <td>{{ $instructor ?: '' }}</td>
                        <td>{{ $section_id }}</td>
                    </tr>
                @endforeach
            @endforeach
            <br>
            <tr class="border-bottom">
                <td></td>
                <td></td>
                <td><b>Total Units: </b></td>
                <td><b>{{ $studentData[0]['totalUnits'] }}</b></td>
                <td><b>{{ $studentData[0]['totallabUnits'] }}</b></td>
                <td><b></b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>

        <table class="border" style="width: 100%; max-height: 100vh;">
            <tr>
                <th>Assessment</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
            <!-- Tuition Fees Section -->
            @if (
                !(
                    $data['campus'] == 'Medical Colleges of Northern Philippines' &&
                    $data['yearlevel'] == 4 &&
                    $data['semester'] == 2
                ))
                <tr>
                    <td>
                        Tuition Fees <br>
                        @foreach ($studentData as $data)
                            @php
                                $tuitionfeess = explode(', ', $data['tutionFeeAmount']);
                            @endphp
                            <span style="margin-left: 20px;">Tuition Fee {{ $data['totalUnits'] }} x
                                @foreach ($tuitionfeess as $tuitionfee)
                                    @if (!empty($tuitionfee))
                                        <span>{{ $tuitionfee }}</span>/unit
                            </span><br>
                        @endif
            @endforeach
            @endforeach
            </td>
            @foreach ($studentData as $tuition)
                @php
                    // dd($tuition['tuitionFees']);
                @endphp
                <td>{{ $tuition['tuitionFees'] }}</td>
                <td>{{ $tuition['tuitionFees'] }}</td>
            @endforeach
            </tr>

            <!-- Laboratory Fees Section -->
            <tr>
                <td style="vertical-align: top;">
                    Laboratory Fees<br>
                    @foreach ($studentData as $data)
                        @php
                            $laboratories = array_values(array_filter(explode(', ', $data['laboratory'])));
                            $labUnits = array_values(array_filter(explode(', ', $data['labunits'])));
                            $laboratoriesAmount = explode(', ', $data['laboratory_amount']);
                        @endphp
                        @foreach ($laboratories as $index => $laboratory)
                            @if (!empty($laboratory) && isset($labUnits[$index]) && isset($laboratoriesAmount[$index]))
                                <span style="margin-top: 0; margin-left: 20px;">
                                    {{ $laboratory }} {{ $labUnits[$index] }} x
                                    {{ number_format(floatval($laboratoriesAmount[$index]), 2) }} /unit
                                </span><br>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td>
                    @foreach ($studentData as $data)
                        @php
                            $laboratoriesAmount = explode(', ', $data['laboratory_amount']);
                        @endphp
                        @foreach ($laboratoriesAmount as $index => $labAmount)
                            @if (isset($labUnits[$index]))
                                {{ number_format(floatval($labAmount) * floatval($labUnits[$index]), 2) }}<br>
                            @else
                                {{ number_format(floatval($labAmount), 2) }} (No corresponding lab unit)<br>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td style="vertical-align: bottom;">
                    <?php
                    $totallabFees = 0;
                    foreach ($studentData as $data) {
                        $labfeesamount = explode(', ', $data['laboratory_amount']);
                        $totallabFees += array_sum($labfeesamount);
                    }
                    echo number_format($totallabFees, 2, '.', ',');
                    ?>
                </td>
            </tr>

            <!-- Miscellaneous Fees Section -->
            {{-- <tr>
                <td>
                    Miscellaneous Fees <br>
                    @foreach ($studentData as $data)
                        @php
                            $miscFees = explode(', ', $data['miscDescription']);
                        @endphp
                        @foreach ($miscFees as $miscFee)
                            <span style="margin-top: 0; margin-left: 20px;">{{ $miscFee }}</span><br>
                        @endforeach
                    @endforeach
                </td>

                <td style="vertical-align: bottom;">
                    <?php
                    $totalOtherFees = 0;
                    foreach ($studentData as $data) {
                        $otherFeesAmount = explode(', ', $data['totalMiscFeeAmount']);
                        $totalOtherFees += array_sum($otherFeesAmount);
                    }
                    echo number_format($totalOtherFees, 2, '.', ',');
                    ?>
                </td>
            </tr> --}}
            <tr>
                <td>
                    Miscellaneous Fees<br>
                    @foreach ($studentData as $data)
                        @php
                            $otherFees = explode(', ', $data['miscDescription']);
                        @endphp
                        @foreach ($otherFees as $otherFee)
                            <span style="margin-left: 20px;">{{ $otherFee }}</span><br>
                        @endforeach
                    @endforeach
                </td>
                <td>
                    @foreach ($studentData as $data)
                        @php
                            $otherFeesFullPackAmount = explode(', ', $data['totalMiscFeeAmount']);
                        @endphp
                        @foreach ($otherFeesFullPackAmount as $amount)
                            {{ number_format((float) $amount, 2, '.', ',') }}<br>
                        @endforeach
                    @endforeach
                </td>
                <td style="vertical-align: bottom;">
                    <?php
                    $totalOtherFees = 0;
                    foreach ($studentData as $data) {
                        $otherFeesAmount = explode(', ', $data['totalMiscFeeAmount']);
                        $totalOtherFees += array_sum($otherFeesAmount);
                    }
                    echo number_format($totalOtherFees, 2, '.', ',');
                    ?>
                </td>
            </tr>

            <tr>
                <td>
                    Other Fees <br>
                    @foreach ($studentData as $data)
                        @php
                            $otherFees = explode(', ', $data['otherFees']);
                            $otherFeesAmount = explode(', ', $data['otherFeesAmount']);
                        @endphp
                        @foreach ($otherFees as $key => $otherFee)
                            @if ($otherFeesAmount[$key] != 0)
                                <span style="margin-left: 20px;">{{ $otherFee }}</span><br>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td>
                    @foreach ($studentData as $data)
                        @php
                            $otherFeesAmount = explode(', ', $data['otherFeesAmount']);
                        @endphp
                        @foreach ($otherFeesAmount as $amount)
                            @if ((float) $amount != 0)
                                {{ number_format((float) $amount, 2, '.', ',') }}<br>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td style="vertical-align: bottom;">
                    <?php
                    $totalOtherFees = 0;
                    foreach ($studentData as $data) {
                        $otherFeesAmount = explode(', ', $data['otherFeesAmount']);
                        $totalOtherFees += array_sum($otherFeesAmount);
                    }
                    echo number_format($totalOtherFees, 2, '.', ',');
                    ?>
                </td>
            </tr>
            @endif


            <!-- MCNP -->
            @if ($data['campus'] == 'Medical Colleges of Northern Philippines' && $data['yearlevel'] == 4 && $data['semester'] == 2)
                <tr>
                    <td>
                        Other Fees<br>
                        @foreach ($studentData as $data)
                            @php
                                $otherFees = explode(', ', $data['otherFeesFullPack']);
                            @endphp
                            @foreach ($otherFees as $otherFee)
                                <span style="margin-left: 20px;">{{ $otherFee }}</span><br>
                            @endforeach
                        @endforeach
                    </td>
                    <td>
                        @foreach ($studentData as $data)
                            @php
                                $otherFeesFullPackAmount = explode(', ', $data['otherFeesFullPackAmount']);
                            @endphp
                            @foreach ($otherFeesFullPackAmount as $amount)
                                {{ number_format((float) $amount, 2, '.', ',') }}<br>
                            @endforeach
                        @endforeach
                    </td>
                    <td style="vertical-align: bottom;">
                        <?php
                        $totalOtherFeess = 0;
                        foreach ($studentData as $data) {
                            $otherFeesAmounts = explode(', ', $data['otherFeesFullPackAmount']);
                            $totalOtherFeess += array_sum($otherFeesAmounts);
                        }
                        echo number_format($totalOtherFeess, 2, '.', ',');
                        ?>
                    </td>
                </tr>
            @endif

            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            
            function calculateTotalAssessment($data)
            {
                $grandTotal = 0;
            
                $grandTotal += floatval($data['tuitionFees']);
            
                $labAmounts = explode(', ', $data['laboratory_amount']);
                $labUnits = array_values(array_filter(explode(', ', $data['labunits'])));
                foreach ($labAmounts as $index => $amount) {
                    if (isset($labUnits[$index])) {
                        $grandTotal += floatval($amount) * floatval($labUnits[$index]);
                    }
                }
            
                $miscAmounts = explode(', ', $data['totalMiscFeeAmount']);
                foreach ($miscAmounts as $amount) {
                    $grandTotal += floatval($amount);
                }
            
                $otherAmounts = explode(', ', $data['otherFeesAmount']);
                foreach ($otherAmounts as $amount) {
                    $grandTotal += floatval($amount);
                }
                $totalDiscount = floatval($data['totalDiscount'] ?? 0);
                $grandTotal -= $totalDiscount;
                return $grandTotal;
            }
            if ($data['campus'] == 'Medical Colleges of Northern Philippines' && $data['yearlevel'] == 4 && $data['semester'] == 2) {
                function calculateTotalAssessmentfullpack($data)
                {
                    $grandTotal = 0;
                    $otherAmounts = explode(', ', $data['otherFeesFullPackAmount']);
                    foreach ($otherAmounts as $amount) {
                        $grandTotal += floatval($amount);
                    }
                    return $grandTotal;
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            @foreach ($studentData as $student)
                @php
                    // Check if both discountCode and totalDiscount are empty or zero
                    $isDiscountEmpty =
                        empty($student['discountCode']) &&
                        (empty($student['totalDiscount']) || $student['totalDiscount'] == 0);
                @endphp

                <tr class="{{ $isDiscountEmpty ? 'hidden-row' : '' }}">
                    <td>Discount<br>(Less){{ $student['discountCode'] ?? '' }}</td>
                    <td>{{ $student['totalDiscount'] ?? '' }}</td>
                    <td>{{ $student['totalDiscount'] ?? '' }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total Assessment</td>
                <td></td>
                <td>
                    <?php
                    
                    if ($data['campus'] == 'Medical Colleges of Northern Philippines' && $data['yearlevel'] == 4 && $data['semester'] == 2) {
                        $totalAssessment = 0;
                        foreach ($studentData as $data) {
                            $totalAssessment = calculateTotalAssessmentfullpack($data);
                            echo number_format($totalAssessment, 2, '.', ',');
                        }
                    } else {
                        $totalAssessment = 0;
                        foreach ($studentData as $data) {
                            $totalAssessment = calculateTotalAssessment($data);
                            echo number_format($totalAssessment, 2, '.', ',');
                        }
                    }
                    ?>
                </td>

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
                <td class="border-bottom">Current Assessment</td>
                @foreach ($studentData as $data)
                    <td class="border-bottom">
                        <?php
                        $currentAssessment = calculateTotalAssessment($data);
                        echo number_format($currentAssessment, 2, '.', ',');
                        ?>
                    </td>
                @endforeach
                <td></td>
                <td class="border-bottom">Down</td>
                @foreach ($studentData as $downpayment)
                    <td class="border-bottom">{{ $downpayment['downpayment'] }}</td>
                @endforeach
                @foreach ($studentData as $downpayment)
                    <td class="border-bottom"></td>
                @endforeach

            </tr>
            <tr>
                <td class="border-bottom">Discounts/Scholarships</td>
                @foreach ($studentData as $studentDiscount)
                    <td class="border-bottom">
                        {{ $studentDiscount['discountAmount'] ?? '' }}
                        {{ $studentDiscount['discountComputeMiscFee'] ?? '' }}
                        {{ $studentDiscount['discount'] ?? '' }}
                    </td>
                @endforeach
                <td></td>
                <td class="border-bottom">Prelims</td>
                @foreach ($studentData as $prelims)
                    <td class="border-bottom">{{ $prelims['prelims'] }}</td>
                @endforeach
                <td class="border-bottom"></td>
            </tr>
            <tr>
                <td class="border-bottom">Previous Balance</td>

                <td class="border-bottom">

                </td>

                <td></td>
                <td class="border-bottom">Midterms</td>
                @foreach ($studentData as $midterms)
                    <td class="border-bottom">{{ $midterms['midterms'] }}</td>
                @endforeach

                <td class="border-bottom"></td>
            </tr>
            <tr>
                <td class="border-bottom">Current Receivable</td>
                <td class="border-bottom"></td>
                <td></td>
                <td class="border-bottom">Semi-Finals</td>
                @foreach ($studentData as $semifinals)
                    <td class="border-bottom">{{ $semifinals['semi_finals'] }}</td>
                @endforeach
                <td class="border-bottom"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="border-bottom">Finals</td>
                @foreach ($studentData as $finals)
                    <td class="border-bottom">{{ $finals['semi_finals'] }}</td>
                @endforeach

                @foreach ($studentData as $data)
                    <td class="border-bottom">{{ $finals['total_assessment'] }}</td>
                @endforeach

            </tr>
        </table>
    </div>
</body>

</html>
