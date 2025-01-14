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
            position: relative;
            color: rgb(32, 143, 247);
            font-size: 15px;
            font-family: Tahoma, sans-serif;
            right: 30px;
            font-weight: normal;
        }

        span {
            color: rgb(32, 143, 247);
            font-size: 15px;
            font-family: Tahoma, sans-serif;
        }

        .tele {
            color: black;
            font-size: 13px;
            font-family: Tahoma, sans-serif;
            line-height: 1px;
            position: relative;
            right: 34px;
            font-weight: normal;
        }

        .Header {
            text-align: center;
            margin-top: 15px;
            font-family: Tahoma, sans-serif;
            font-weight: bold;
            font-size: 20px;
            color: rgb(212, 6, 6);
            line-height: 5px;
        }

        .TOP {
            text-align: center;
            margin-top: -50px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 20px;
        }

        .CERT {
            font-size: 40px;
            line-height: 100px;
            text-align: center;
            margin-top: -50px;
        }

        .letter {
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
            line-height: 1.6;
        }

        .letter p {
            text-align: justify;
            margin: 0 40px;
            line-height: 1.7;
            text-indent: 4em;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 80%;
            margin: 20px auto;
        }

        .web {
            color: black;
            font-size: 11px;
            font-family: Tahoma, sans-serif;
            line-height: 1px;
        }

        .email {
            font-size: 11px;
            font-family: Tahoma, sans-serif;
            line-height: 50px;
            margin-left: 20em;
        }

        .logo {
            position: relative;
            display: inline-block;
            margin-left: 10px;
            top: -10px;
        }

        .heads {
            display: inline-block;
        }

        .heads p {
            margin-right: 50px;
        }

        .footerEmailAdd u {
            margin-right: 20px;
            position: relative;
            top: -20px;
        }

        .footerEmailAdd {
            margin-top: -30px;
        }

        .footerEmailAdd .webspan {
            font-size: 11px;
            position: relative;
            top: -20px;
        }

        .footerEmailAdd .email {
            font-size: 11px;
            position: relative;
            top: -20px;
        }

        .footerEmailAdd .web u {
            margin-right: 20px;
            position: relative;
            top: -20px;
        }
    </style>
</head>

<body>
    <div class="Header">
        <p class="Boarder1"> ______________________________________________________________</p>
        <div>
            <div class="logo">
                <img src="{{ asset('backend/assets/images/3cd6232a-9413-43b6-9671-ef2945c4df76.jfif') }}" alt="Logo">
            </div>
            <div class="heads">
                <p>INTERNATIONAL SCHOOL OF ASIA AND THE PACIFIC</p>
                <p class="address">Bulanao Norte, Tabuk Kalinga</p>
                <p class="tele"><span>Telefax No.: </span>(078) 304-1010</p>
            </div>
            <div class="footerEmailAdd">
                <p class="web"><span class="webspan">Website:</span><u>www.isap.edu.ph</u>
                    <span class="email" style="position: relative; left:25px">Email Address:
                        <u style="position: relative; top: -0.1px">isapkalinga2011@isap.edu.ph</u></span>
                </p>
                <p class="Boarder2"> ______________________________________________________________</p>
            </div>
        </div>
    </div>
    <div class="TOP">
        <p>OFFICE OF THE REGISTRAR</p>
    </div>
    <div>
        <p class="CERT"><u>CERTIFICATION</u></p>
    </div>
    @foreach ($studentData as $student)
        <div class="letter">
            <p>This is to certify that <b><u>{{ $student['first_name'] }} {{ $student['middle_name'] }}
                        {{ $student['last_name'] }}</u></b>, a <u>{{ $student['yearlevel'] }}</u>
                student of the
                course {{ $student['course'] }}, was officially enrolled of this Institution is officially enrolled in
                the
                subjects listed below with their correspending unit('s):</p>
        </div>
    @endforeach

    <div>
        <table>
            <thead>
                <tr>
                    <th>CODE</th>
                    <th>DESCRIPTIVE TITLE</th>
                    <th>UNITS</th>
                </tr>
                @foreach ($studentData as $student)
                    <tr>
                        <th colspan="3"><b><u>{{ $student['schoolyear'] }}</u></b></th>
                    </tr>
                    </tr>
                @endforeach
            </thead>
            <tbody>
                @foreach ($studentData as $student)
                    @foreach ($student['subjects'] as $code => $subject)
                        <tr>
                            <td>{{ $code }}</td>
                            <td>{{ $subject }}</td>
                            <td>{{ $student['units'][array_search($code, array_keys($student['subjects']))] ?? 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="2">···········NOTHING FOLLOWS············</td>
                </tr>
                @foreach ($studentData as $student)
                    <tr>
                        <td colspan="2"><b>TOTAL UNITS:</b></td>
                        <td>{{ $student['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>
