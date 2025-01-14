<!DOCTYPE html>
<html>

<head>
    <style>
        .Boarder1 {
            color: black;
        }

        .Boarder2 {
            color: black;
            line-height: 10px;
            position: relative;
            top: -45px;
        }

        .address {
            color: black;
            font-size: 15px;
            font-style: tahoma;
            right: 30px;
            font-weight: normal;
        }

        span {
            color: rgb(32, 143, 247);
            font-size: 15px;
            font-style: tahoma;
        }

        .tele {
            color: black;
            font-size: 13px;
            font-style: tahoma;
            line-height: 1px;
            right: 30px;
            font-weight: normal;
        }

        .Header {
            text-align: center;
            margin-top: 10px;
            font-family: Tahoma;
            font-weight: bold;
            font-size: 20px;
            color: rgb(212, 6, 6);
            line-height: 5px;
        }

        .TOP {
            text-align: center;
            margin-top: 1px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 20px;
        }

        .letter {
            position: relative;
            top: -80px;
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .letter p {
            text-align: justify;
            margin: 0 50px;
            line-height: 1.7;
            text-indent: 4em;
        }

        table,
        th,
        td {
            position: relative;

            border: 1px solid white;
            border-collapse: collapse;
            padding-left: 10px;
            font-weight: normal;
        }

        table {
            width: 90%;
            margin: 20px auto;
        }

        .units {

            padding-left: 560px;
        }

        .web {
            color: black;
            font-size: 11px;
            font-style: tahoma;
            line-height: 1px;
        }

        .email {
            margin-bottom: 100px;
            font-size: 11px;
            font-style: tahoma;
            line-height: 50px;
            margin-left: 20em;
        }

        .logo {
            display: inline-block;
            margin-left: 10px;
        }

        .heads {
            display: inline-block;
        }

        .heads p {
            position: relative;
            margin-right: 50px;
        }

        .footerEmailAdd .email {
            position: relative;
            top: -10px;
            left: 50px;
        }

        .footerEmailAdd {
            margin-top: -30px;
        }

        .footerEmailAdd .webspan {
            position: relative;
            top: -10px;
            font-size: 11px;
        }

        .footerEmailAdd .webspan .websiteurl {
            color: black;
        }

        .footerEmailAdd .web u {
            position: relative;
            margin-right: 50px;
        }

        .to {
            position: relative;
            top: -80px;
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
            line-height: 1.6;
            margin-bottom: 1px;
            padding-left: 100px;
        }

        .top {
            text-align: justify;
            margin: 0 50px;
            display: inline-block;
        }

        .letters {
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
            line-height: 1.6;
            margin-top: -120px;
        }

        .letters p {
            text-align: justify;
            margin: 0 50px;
            line-height: 1.7;
            text-indent: 4em;
        }

        .signature {
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
            line-height: 1.6;
            margin-top: -20px;
        }

        .signature p {
            text-align: justify;
            margin: 0 50px;
            line-height: 1.7;
            text-indent: 4em;
        }

        .reg {
            position: relative;
            left: 400px;
            max-width: 700px;
            margin: 0 auto;
            margin-top: -1px;
        }

        .reg p {
            text-align: justify;
            margin: 0 50px;
            line-height: 1.7;
            text-indent: 30em;
            white-space: nowrap;
            /* Add this line */
        }

        .seal p {
            margin: 0 0;
            margin-left: 650px;
            max-width: 70px;
        }

        .document table,
        th,
        td {
            border-collapse: collapse;
            font-weight: normal;
        }

        .document table {
            margin-top: 1px;
            margin: 0 560px;
        }

        .office {
            position: relative;
            top: -97px;
            right: -80px;
            border: 1px solid white;
            text-indent: 10em;
            margin-bottom: -1px;
        }

        .docs {
            position: relative;
            top: -70px;
            right: 150px;
            border: 1px solid black;
            font-size: 10px;
            max-width: 200px;
            line-height: 1;
        }

        .docs .effectiveDate {
            font-size: 10px;
            color: black;

        }

        .tableGrade {
            position: relative;
            top: -100px;
        }

        .tableGrade td {
            text-align: center;

        }

        .tableGrade .schoolyear tr {
            position: relative;
            margin-top: 100px;
        }

        */.tableGrade {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10px;
            /* Reduced font size */
        }

        .tableGrade th,
        .tableGrade td {
            padding: 5px;
            /* Reduced padding */
            border: none;
            text-align: center;
            font-size: 14px;
        }

        .tableGrade th:nth-child(1),
        .tableGrade td:nth-child(1) {
            width: 10%;
            /* CODE */
        }

        .tableGrade th:nth-child(2),
        .tableGrade td:nth-child(2) {
            width: 48%;
            /* Reduced width slightly */
            /* DESCRIPTIVE TITLE */
            text-align: left;
            padding-left: 8px;
            /* Reduced padding */
        }

        .tableGrade th:nth-child(3),
        .tableGrade td:nth-child(3) {
            width: 10%;
            /* GRADE */
        }

        .tableGrade th:nth-child(4),
        .tableGrade td:nth-child(4) {
            width: 10%;
            /* C.G. */
        }

        .tableGrade th:nth-child(5),
        .tableGrade td:nth-child(5) {
            width: 10%;
            /* UNITS */
        }

        .nothingFollowsRow td {
            border: none;
            text-align: center;
        }

        .units {
            text-align: right;
            padding-right: 8px;
            /* Slightly reduced padding */
            border-top: 1px solid black;
        }

        .page-break {
            /* page-break-after: always; */
            margin-top: 230px;
        }
    </style>
</head>

<body>

    <div class="Header">
        <p class="Boarder1"> ______________________________________________________________</p>

        <div>
            @switch($campus)
                @case(1)
                    <div class="logo">
                        <img src="{{ asset('backend/assets/images/ISAP_LOGO_NO_BG.png') }}" width="75" height="75">
                    </div>
                @break

                @case(2)
                    <div class="logo">
                        <img src="{{ asset('backend/assets/images/Medical_Colleges_of_Northern_Philippines_(MCNP)_Logo.jpg') }}"
                            width="75" height="75">
                    </div>
                @break

                @case(3)
                    <div class="logo">
                        <img src="{{ asset('backend/assets/images/ISAP_LOGO_NO_BG.png') }}" width="75" height="75">
                    </div>
                @break

                @default
            @endswitch
            <div class="heads">
                @switch($campus)
                    @case(1)
                        <p>INTERNATIONAL SCHOOL OF ASIA AND THE PACIFIC</p>
                        <p class="address">Alimannao Hills, Peñablanca, Cagayan</p>
                        <p class="tele">Telefax No.: (078) 304-1010/846-7539</p>
                    @break

                    @case(2)
                        <p style="color:rgb(42, 42, 177);">MEDICAL COLLEGES OF NORTHERN PHILLIPINES</p>
                        <p class="address">Alimannao Hills, Peñablanca, Cagayan</p>
                        <p class="tele">Telefax No.: (078) 304-1010/846-7539</p>
                    @break

                    @default
                        <!-- Default content if needed -->
                @endswitch
            </div>
            <div class="footerEmailAdd">
                @switch($campus)
                    @case(1)
                        <p class="web">
                            <span class="webspan">Website:
                                <u class="websiteurl">www.isap.edu.ph</u>
                            </span>
                            <span class="email">Email Address: <u>adminoffice@isap.edu.ph</u></span>
                        </p>
                    @break

                    @case(2)
                        <p class="web">
                            <span class="webspan">Website:
                                <u class="websiteurl">www.mcnp.edu.ph</u>
                            </span>
                            <span class="email">Email Address: <u>adminoffice@mcnp.edu.ph</u></span>
                        </p>
                    @break

                    @default
                @endswitch

                <p class="Boarder2"> ______________________________________________________________</p>
            </div>
        </div>
    </div>

    <div class="TOP">
        <div class="document">
            <table>
                <tr>
                    <td>
                    </td>
                    <td>
                        <p class="docs">Document No.<br>MCNP-QMS-DCO-REG Form No:
                            006COE<br>———————————————————— <span class="effectiveDate">Effective Date</span>:
                            January
                            2020<br>Revision No. 00
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <p class="office"><b>OFFICE OF THE REGISTRAR</b></p>
    <div>
        <p class="to">TO WHOM IT MAY CONCERN:</p>
    </div>
    <div class="letter">
        @php
            $firstSemester = array_key_first($studentData);
        @endphp
        <p>This is to certify that <b><u>{{ strtoupper($studentData[$firstSemester]['first_name']) }}
                    {{ strtoupper($studentData[$firstSemester]['middle_name']) }}
                    {{ strtoupper($studentData[$firstSemester]['last_name']) }}</u></b>, a
            {{ $studentData[$firstSemester]['yearlevel'] }} student
            of the course
            {{ $studentData[$firstSemester]['course'] }} of {{ $studentData[$firstSemester]['department_id'] }}, was
            officially enrolled in the subjects listed below with their corresponding units.</p>
    </div>
    @foreach ($studentData as $semester => $data)
        <div>
            <table class="tableGrade">
                <tr>
                    <th>CODE</th>
                    <th>DESCRIPTIVE TITLE</th>
                    <th>GRADE</th>
                    <th>C.G.</th>
                    <th>UNITS</th>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: left;"><u>{{ $data['schoolyear'] }}</u></td>
                </tr>
                @foreach ($data['subjects'] as $subject)
                    <tr>
                        <td>{{ $subject['code'] }}</td>
                        <td>{{ $subject['title'] }}</td>
                        <td>{{ $data['grades'][$loop->index] ?? '' }}</td>
                        <td></td>
                        <td>{{ $subject['units'] }}</td>
                    </tr>
                @endforeach
                <!-- Row for total units -->
                <tr class="nothingFollowsRow">
                    <td></td>
                    <td colspan="2">···········NOTHING FOLLOWS············</td>
                    <td></td>
                    <td colspan="4" class="units">UNITS: <b><u>{{ $data['total'] }}</u></b></td>
                    <td></td>
                </tr>
            </table>
        </div>



        <!-- Add a page break after each semester except the last one -->
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
    <div class="letters">
        <p>This certification is issued upon the request of the above-named student for whatever purpose it may
            serve
            her best.</p>
    </div>
    <br>
    <div class="signature">
        <p>Given this <u>{{ date('jS') }}</u> day of <u>{{ date('F') }}</u>, <u>{{ date('Y') }}</u>.
        </p>
    </div>

    <div class="reg">
        <p><b><u>NESSIE M. JERUSALEM, MAEd</u></b></p>
    </div>

    <p style="position: relative; left: 543px; margin-top:-1px;">Registrar</p>



</body>

</html>
