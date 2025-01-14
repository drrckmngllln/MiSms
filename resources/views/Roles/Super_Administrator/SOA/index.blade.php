@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Statement of Account</a></li>
                                <li class="breadcrumb-item active">SOA</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                * {
                    box-sizing: border-box;
                    font-family: Arial, sans-serif;
                }

                .container {
                    width: 80%;
                    margin: 20px auto;
                    border: 1px solid #ccc;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 10px;
                }

                .header .student-info {
                    font-size: 1.2em;
                    font-weight: bold;
                }

                .search-container {
                    margin-bottom: 15px;
                }

                .table-container {
                    width: 100%;
                    border-collapse: collapse;
                }

                .table-container th,
                .table-container td {
                    padding: 8px;
                    text-align: center;
                    border: 1px solid #ddd;
                }

                .table-container th {
                    background-color: #f4f4f4;
                }

                .semester-row {
                    background-color: #93c3f7;
                    color: #fff;
                    font-weight: bold;
                    text-align: left;
                }

                .table-container tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                .highlight {
                    background-color: #e7e3ff;
                }

                .debit {
                    color: red;
                }

                .credit {
                    color: green;
                }
            </style>

            <div class="container">
                <!-- Search bar -->
                <div class="search-container">
                    <select id="studentss_id" name="id_number" class="form-select" aria-describedby="helpId">
                        <option value="all">All Student</option>
                        @foreach ($Students as $student)
                            <option value="{{ $student->id_number }}">{{ $student->first_name }}
                                {{ $student->middle_name }} {{ $student->last_name }},
                                {{ $student->id_number }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Transaction table -->
                <div id="transactionContainer" style="display: none;">
                    <table class="table-container" id="transactionTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Doc No</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="semester-row">
                                <td colspan="6">No Year Found</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- Additional rows for Second Semester... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@endsection
@push('scripts')
    <script>
        $('#student-feesummaries-table').DataTable().destroy();
        $('#student-feesummaries-table').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: '/superadmin/getFeesummariessoa/',
                type: 'GET',
            },
            columns: [{
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'id_number',
                    name: 'id_number'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'first_name',
                    name: 'first_name'
                },
                {
                    data: 'particulars',
                    name: 'particulars'
                },

                {
                    data: 'or_number',
                    name: 'or_number'
                },
                {
                    data: 'total_assessment',
                    name: 'total_assessment'
                },
                {
                    data: 'downpayment',
                    name: 'downpayment'
                },
                {
                    data: null,
                    render: function(data, type, row) {

                        var balance = row.total_assessment - row.downpayment;
                        return balance.toFixed(2);

                    },
                    name: 'balance'
                }
            ],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;


                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                total = api
                    .column(6) // Adjust column index as needed
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                $('#totalCreditInput').val(total);

                totalDebit = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update total in the input field
                $('#totalDebitInput').val(totalDebit);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            instructorEdit = $('#studentss_id').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
            $('#studentss_id').on('change', function() {
                if ($(this).val() !== "all") {
                    $('#transactionContainer').show();
                } else {
                    $('#transactionContainer').hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#studentss_id').on('change', function() {
                let id_number = $(this).val();


                if (id_number !== 'all') {
                    $.ajax({
                        url: `/superadmin/getTotalAssessmentEachStudent/${id_number}`,
                        method: 'GET',
                        success: function(response) {
                            console.log(response);
                            const transactionTableBody = $('#transactionTable tbody');
                            transactionTableBody.empty();

                            response.forEach((res, index) => {

                                const backgroundColor = index % 2 === 0 ? '#93c3f7' :
                                    '#93c3f7';
                                let schoolYear =
                                    ` ${res.school_year_id}`;
                                console.log(schoolYear);
                                let YearRow = `
                            <tr class="semester-row" style="background-color: ${backgroundColor};">
                                <td colspan="6">${schoolYear}</td>
                            </tr>
                        `;
                                transactionTableBody.append(YearRow);

                                res.tableData.forEach(function(item) {
                                    const row = `
                            <tr>
                                <td>${item.date}</td>
                                <td>${item.transaction}</td>
                                <td>${item.doc_no}</td>
                                <td class="${item.debit ? 'debit' : ''}">${item.debit || ''}</td>
                                <td class="${item.credit ? 'credit' : ''}">${item.credit || ''}</td>
                                <td>${item.balance}</td>
                            </tr>
                        `;
                                    transactionTableBody.append(row);
                                });
                            })

                            $('#transactionContainer').show();
                        },
                        error: function(error) {
                            console.error('Error fetching transactions:', error);
                        }
                    });
                } else {

                    $('#transactionContainer').hide();
                }
            });
        });
    </script>
@endpush
