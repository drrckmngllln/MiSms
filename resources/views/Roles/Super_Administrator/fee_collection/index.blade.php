@extends('Roles.layouts.master')
@section('content')
    <style>
        .card-title {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-title input {
            margin-left: 10px;
            flex: 1;
        }

        /* Base styling for select */
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <form action="" method="POST" id="fee_summaries_id">
                @csrf
                @method('POST')

                <input type="hidden" name="total_assessment" id="total_assessment_idddds">
                <input type="hidden" id="fee_student_collection" name="fee_student_collection">
                <input type="hidden" name="semester" id="semester_ID_ID">
                <input type="hidden" name="year_level" id="year_level_ID_ID">
                <input type="text" class="form-control" name="payment2hidden" id="paymenthidden_id2" hidden>
                <input type="text" class="form-control" name="downpayment22" id="downpayment_2" hidden>
                <input type="text" class="form-control" name="department_id" id="dept_id" hidden>
                <input type="text" class="form-control" name="role_name_id" value="{{ $id }}" hidden
                    id="role_name_id">
                <input type="text" class="form-control" name="campus_id" id="campus_id_ID" hidden>
                <input type="text" class="form-control" name="course_id" id="course_id_id" hidden>


                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <div class="d-flex gap-3 align-items-end">
                                <input type="text " hidden id="department_id" name="department"
                                    value="{{ $role }}">
                                <input type="text " hidden id="name" name="name" value="{{ $name }}">
                                <div class="form-group">
                                    <label>Reference Number</label>
                                    <input type="text" class="form-control" name="or_number" id="setOrNumber"
                                        value="" required>
                                </div>
                                <div class="form-group">
                                    <label>Cash/Check</label>
                                    <select name="payment_status" id="payment_status" class="form-select">
                                        <option value="">--Select One--</option>
                                        <option value="Cash">Cash</option>
                                        <option value="BDO Unibank Inc">BDO Unibank Inc</option>
                                        <option value="BPI">BPI</option>
                                        <option value="Metropolitan Bank and Trust Company">Metropolitan Bank and Trust
                                            Company</option>
                                        <option value="PNB">PNB</option>
                                        <option value="Security Bank Corporation">Security Bank Corporation</option>
                                        <option value="China Bank">China Bank</option>
                                        <option value="UnionBank of the Philippines">UnionBank of the Philippines</option>
                                        <option value="EastWest Bank">EastWest Bank</option>
                                        <option value="Rizal Commercial Banking Corporation">RCBC</option>
                                        <option value="Philippine Savings Bank ">PSBank
                                        </option>
                                        <option value="Standard Chartered Bank">Standard Chartered Bank
                                        </option>
                                        <option value="HSBC">HSBC
                                        </option>
                                        <option value="Landbank">Landbank
                                        </option>
                                        <option value="Citibank NA">Citibank NA</option>
                                        <option value="Deutsche Bank AG">Deutsche Bank AG</option>
                                        <option value="JPMorgan Chase Bank NA">JPMorgan Chase Bank</option>
                                        <option value="Bank of China Philippine Branch">Bank of China (Philippine Branch)
                                        </option>
                                        <option value="Development Bank of the Philippines DBP">Development Bank of the
                                            Philippines
                                            (DBP)
                                        </option>
                                        <option value="Pag IBIG Fund">Pag-IBIG Fund
                                        </option>
                                        <option value="China Bank Savings">China Bank Savings
                                        </option>
                                        <option value="Robinsons Bank Corporation">Robinsons Bank Corporation</option>

                                    </select>
                                </div>
                                <div class="form-group" id="bank-details" style="display: none;">
                                    <label>Check No.</label>
                                    <input type="text" name="check_no" class="form-control" placeholder="Enter check no">
                                </div>

                                <div class="form-group">
                                    <label>Incharge</label>
                                    <input type="text" class="form-control" name="cahier_in_charge"
                                        id="edit_cashier_in_charge" value="{{ $role }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name_id"
                                        value="{{ $name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control" name="date" id="edit_date"
                                        value="" readonly>
                                </div>


                            </div>
                            <h4 class="mb-sm-0"></h4>
                            <div class="page-title-right">

                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Fee Collection</a></li>

                                    {{-- <select name="school_year" id="gender" class="form-select" aria-describedby="helpId">
                                        @foreach ($school_year as $sy)
                                            <option value="{{ $sy->id }}">{{ $sy->code }}</option>
                                        @endforeach
                                    </select> --}}

                                    <li class="breadcrumb-item active mx-1">School Year</li>
                                    <select name="school_year" id="school_year_ched" class="form-select" required>
                                        <option value="" disabled selected>--Select One--</option>
                                    </select>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card" style="width:1200px;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <h4 class="card-title mb-0">Collect</h4>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <h4 class="card-title mb-0 me-2">Scholarship:</h4>
                                        <input name="scholarship" type="checkbox" class="form-check-input"
                                            id="customSwitch1">
                                    </div>
                                </div>

                                <div class="row align-items-center" id="rowFields">
                                    <div class="col-md-2 mb-2">
                                        <label for="downpayment_id">Amount Received:</label>
                                        <input type="text" class="form-control" name="downpayment"
                                            id="downpayment_id" value="" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="payable_id">Amount to pay:</label>
                                        <input type="text" class="form-control" name="payable" id="payable_id"
                                            value="" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="excess_id">Excess:</label>
                                        <input type="text" class="form-control" name="excess" id="excess_id"
                                            value="" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="particulars_id">Particulars:</label>
                                        <input type="text" class="form-control" name="particulars"
                                            id="particulars_id" value="" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="fees_id">Fees:</label>
                                        <select id="fees_id" class="form-select" aria-describedby="helpId">
                                            <option value="" disabled selected>Select Fees</option>
                                            @foreach ($fees as $fee)
                                                <option value="{{ $fee['id'] }}"
                                                    data-campus-id="{{ $fee['campus_id'] }}">
                                                    {{ $fee['description'] }}, Semester: {{ $fee['semester'] }}, Campus:
                                                    {{ $fee['campus'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <h5>Selected Fees:</h5>
                                        <ul id="selected-fees-list" class="list-group">
                                            <input type="text" name="selected_fees" hidden>

                                        </ul>
                                    </div>

                                    <div class="col-md-3 mb-3 align-items-center">
                                        <button type="submit" class="btn btn-success waves-effect waves-light w-100"
                                            id="amount_submit">
                                            Confirm Fees
                                        </button>
                                    </div>
                                    <div class="col-md-3 mb-3 align-items-center">
                                        <button type="submit" class="btn btn-secondary waves-effect waves-light w-100"
                                            id="clear_fields">
                                            Clear Fields
                                        </button>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="card" style="width:1200px;">
                            <div class="card-body">
                                <h4 class="card-title"><b>Fee Breakdown</b>

                                </h4>
                                <table id="live-breakdown" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Downpayment</th>
                                            <th>Prelims</th>
                                            <th>Midterms</th>
                                            <th>Semi-Final</th>
                                            <th>Finals</th>
                                            <th>Total Assessment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card" style="width:1200px;">
                            <div class="card-body">
                                <h4 class="card-title"><b>Fee Collection</b> / Miscellaneous Fees / Laboratory Fees /
                                    Other
                                    Fees / Tuition Fees
                                </h4>
                                <table id="assesment-Breakdownsss"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Fee Type</th>
                                            <th>Amount</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 mb-1">
                        <div class="card" style="width:370px; left:700px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <h4 class="card-title">Student Info:</h4>
                                    </div>
                                    <div class="col-md-4 mb-3 mx--200">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"
                                            style="width: 150px; height: 35px; line-height: 1px;">
                                            Add Student
                                        </button>
                                    </div>
                                </div>
                                <h5 class="card-title">Student Name: <span id="hii"></span></h5>
                                <h5 class="card-title">Course/Strand: <span id="holee"></span></h5>
                                <h5 class="card-title">Year Level: <span id="yahu"></span></h5>
                                <h5 class="card-title">Semester: <span id="hahi"></span></h5>
                                <h5 class="card-title">Status: <span id="hoy"></span></h5>
                                <h5 class="card-title">ID Number: <input type="text" name="id_number" id="hey"
                                        readonly>

                                    <input type="text" name="campus" id="campus_id_id" hidden>

                                </h5>
                            </div>
                        </div>
                        <input type="text" name="downpayment2" id="downpayment_idd" hidden>

                        <div class="card" style="width:370px; left:700px;">
                            {{-- <div class="card-body">
                                <h4 class="card-title">Collect</h4>

                                <h4 class="card-title">Amount Recieved: <input type="text" name="downpayment"
                                        id="downpayment_id">
                                </h4>


                                <h4 class="card-title">Amount to pay: <input type="text" id="payable_id"
                                        name="payable">
                                </h4>

                                <h4 class="card-title">Excess: <input type="text" id="excess_id" name="excess">
                                </h4>
                                <h4 class="card-title">Particulars:
                                    <textarea rows="5" cols="30" name="particulars" id="particulars_id" required></textarea>
                                </h4>
                                <h4 class="card-title">Fees
                                    <select name="" id="">
                                        <option value="">Select</option>
                                    </select>
                                </h4>
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <button type="submit" id="amount_submit"
                                            class="btn btn-primary mx-10">Confirm</button>
                                    </div>

                                </div>
                            </div> --}}
                        </div>

                        <div class="card" style="width:370px; left:700px;">
                            <div class="card-body">
                                <h4 class="card-title">Original Fee Breakdown</h4>
                                <table id="fee-breakdown-table"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Term</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>DownPayment</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Prelims/First Grading For HS</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Midterms/Second Grading For HS</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Semi Finals</td>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <td>Finals</td>
                                            <td id="finals_id">0</td>
                                        </tr>
                                        <tr>
                                            <td>Total Assessment</td>
                                            <td id="total_assessment_id">0</td>
                                        </tr>

                                        {{-- <div id="printrecipt-id">
                                            <h1>Hello, this is the content you want to print!</h1>
                                        </div> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form> <!-- Close the form tag here -->
        </div>
    </div>
    </div>
    </div>
    <div id="printrecipt-container">

    </div>
@endsection

@include('Roles.Super_Administrator.fee_collection.selectStudent')

@push('scripts')
    <script>
        $(document).ready(function() {
            // Get the CSRF token from Laravel meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('#fee_summaries_id').submit(function(event) {
                event.preventDefault();
                $('#total_assessment_idddds').val(totalAssessmentValue);

                var Particulars = $('#particulars_id').val();
                var PaymentAmount = $('#downpayment_id').val();
                var PayableAmount = parseFloat($('#payable_id').val());
                var collectAllChecked = $('#collect_all_checkbox').is(':checked');

                if (!collectAllChecked && PaymentAmount < PayableAmount) {
                    toastr.error('The amount must be greater than the payable only.');
                    return;
                }

                const title = 'Confim Payment: ' + PaymentAmount + ', ' + 'Particulars: ' + ' ' +
                    Particulars;
                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'YES',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $(this).serialize();
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('superadmin.save.FeeSummaries') }}',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                $('#student-feesummaries-table').DataTable().ajax
                                    .reload();
                                $('#assesment-Breakdownsss').DataTable().ajax.reload();
                                $('#live-breakdown').DataTable().ajax.reload();

                                if (response.status === 'success') {
                                    toastr.success('Confirmed!!');

                                    var excessAmount = response.data.exessAmount
                                        .toFixed(2);
                                    $('#excess_id').val(excessAmount);

                                    Swal.fire({
                                        title: 'Excess Amount',
                                        text: 'Your excess is ' + excessAmount,
                                        icon: 'success',
                                        confirmButtonText: 'Print Recipt',
                                    }).then((printResult) => {
                                        if (printResult.isConfirmed) {
                                            var studentId = window.idValue;
                                            var isScholarship = $(
                                                '#customSwitch1').is(
                                                ':checked');
                                            var selectedFees = $(
                                                'input[name="selected_fees"]'
                                            ).val();

                                            if (studentId) {
                                                $.ajax({
                                                    type: 'GET',
                                                    url: 'printRecipt/' +
                                                        studentId,
                                                    data: {
                                                        scholarship: isScholarship,
                                                        selectedFees: selectedFees
                                                    },
                                                    headers: {
                                                        'X-CSRF-TOKEN': csrfToken
                                                    },
                                                    success: function(
                                                        response) {
                                                        $('#printrecipt-container')
                                                            .html(
                                                                response
                                                            );

                                                        printJS({
                                                            printable: 'printrecipt-id',
                                                            type: 'html',
                                                            targetStyle: [
                                                                '*'
                                                            ],
                                                            base64: true,
                                                            documentTitle: 'Your Document Title',
                                                            size: {
                                                                width: 21.59,
                                                                height: 11.43
                                                            },
                                                            onPrintDialogClose: function() {
                                                                $('#downpayment_id')
                                                                    .val(
                                                                        ''
                                                                    );
                                                                $('#payable_id')
                                                                    .val(
                                                                        ''
                                                                    );
                                                                $('#excess_id')
                                                                    .val(
                                                                        ''
                                                                    );
                                                                window
                                                                    .location
                                                                    .href =
                                                                    window
                                                                    .location
                                                                    .href
                                                                    .split(
                                                                        '?'
                                                                    )[
                                                                        0
                                                                    ] +
                                                                    '?refresh=' +
                                                                    new Date()
                                                                    .getTime();
                                                            },
                                                        });
                                                    },
                                                    error: function(
                                                        error) {
                                                        console
                                                            .error(
                                                                'Error:',
                                                                error
                                                            );
                                                    }
                                                });
                                            } else {
                                                console.error(
                                                    'Error: No studentId provided.'
                                                );
                                            }
                                        }
                                    });
                                }
                                // updatePage(response);
                            },
                            error: function(error) {
                                console.error('Error:', error);
                            }
                        });
                    }
                });
            });
        });

        function updatePage(response) {

            var updatedData = response.data;

            // var tdDownPayment = $('#fee-breakdown-table tbody').find('td:contains(\'DownPayment\')');

            // tdDownPayment.next('td').text(updatedData.newDownpayment.toFixed(2));
            // var tdPrelims = $('#fee-breakdown-table tbody').find('td:contains(\'Prelims\')');
            // tdPrelims.next('td').text(updatedData.newPrelims.toFixed(2));
            // var tdElement = $('#fee-breakdown-table tbody').find('td:contains(\'Midterms\')');

            // tdElement.next('td').text(updatedData.newMidterms.toFixed(2));

            // var tdSemiFinals = $('#fee-breakdown-table tbody').find('td:contains(\'Semi Finals\')');
            // tdSemiFinals.next('td').text(updatedData.newSemis.toFixed(2));
            // // var tdFinals = $('#fee-breakdown-table tbody').find('td:contains(\'Finals\')');
            // // tdFinals.next('td').text(updatedData.newFinals.toFixed(4));

            // $('#finals_id').text(updatedData.newFinals.toFixed(2));
            // $('#total_assessment_id').text(updatedData.newTotalAssestment.toFixed(2));


        }
    </script>
    <script>
        function collectAll() {
            var collectCheckbox = document.getElementById("collect_all_checkbox");
            var downpaymentInput = document.getElementById("downpayment_id");
            var payableInput = document.getElementById("payable_id");

            // Kung hindi na-check ang checkbox, suriin kung ang downpayment ay mas mataas kaysa sa payable
            // Kung mas mataas, ibalik ang halaga sa payable
            if (!collectCheckbox.checked && parseInt(downpaymentInput.value) > parseInt(payableInput.value)) {
                downpaymentInput.value = payableInput.value;
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var year = today.getFullYear();
            var dateString = year + '-' + month + '-' + day;
            document.getElementById("edit_date").value = dateString;
        });
    </script>
    <script>
        $(document).ready(function() {
            function generateAutoIncrementValue(lastOrNumber) {
                var currentValue = parseInt(lastOrNumber) || 0;
                var newValue = currentValue + 1;
                if (newValue < 100000) {
                    paddedValue = ('00000' + newValue).slice(-5); // 5-digit padding
                } else {
                    paddedValue = ('000000' + newValue).slice(-6); // 6-digit padding
                }

                return paddedValue;
            }

            var role = $('#edit_cashier_in_charge').val().trim();
            var name = $('#name_id').val();
            // console.log(name);
            $.ajax({
                url: '{{ route('superadmin.get.LastorNumber') }}',
                method: 'GET',
                data: {
                    role: role,
                    name: name
                },
                success: function(response) {
                    // console.log(response);
                    var lastOrNumber = response.last_or_number.trim();
                    var nextIdNumber = generateAutoIncrementValue(lastOrNumber);
                    $('#setOrNumber').val(nextIdNumber);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>
    <script>
        document.getElementById('downpayment_id').addEventListener('input', calculateExcess);
        document.getElementById('payable_id').addEventListener('input', calculateExcess);

        function calculateExcess() {
            const amountReceived = parseFloat(document.getElementById('downpayment_id').value) || 0;
            const amountToPay = parseFloat(document.getElementById('payable_id').value) || 0;
            const excess = amountReceived > amountToPay ? amountReceived - amountToPay : 0;
            document.getElementById('excess_id').value = excess.toFixed(2);

        }
    </script>

    <script>
        document.getElementById('downpayment_id').addEventListener('input', function() {
            document.getElementById('downpayment_idd').value = this.value;
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#school_year_ched');
                    select.empty();
                    if (data.activeYears.length === 1) {
                        select.append('<option value="' + data.activeYears[0].id +
                            '" selected>' + data.activeYears[0].code + '</option>');
                    } else {
                        select.append(
                            '<option value="" disabled selected>--Select One--</option>'
                        );

                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>
    <script>
        document.getElementById('clear_fields').addEventListener('click', function() {

            const inputs = document.querySelectorAll('#rowFields input');


            inputs.forEach(input => input.value = '');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectElement = document.getElementById("fees_id");
            const selectedFeesList = document.getElementById("selected-fees-list");
            const selectedFees = new Map();
            const selectedFeesInput = document.querySelector('input[name="selected_fees"]');

            selectElement.addEventListener("change", function() {
                const selectedText = selectElement.options[selectElement.selectedIndex].text;
                const selectedValue = selectElement.value;

                if (!selectedFees.has(selectedValue) && selectedValue !== "") {
                    selectedFees.set(selectedValue, selectedText);

                    const li = document.createElement("li");
                    li.className = "list-group-item d-flex justify-content-between align-items-center";

                    li.textContent = selectedText;

                    const removeBtn = document.createElement("button");
                    removeBtn.className = "btn btn-sm btn-danger";
                    removeBtn.textContent = "Remove";
                    removeBtn.addEventListener("click", function() {
                        selectedFees.delete(selectedValue);
                        li.remove();
                        updateSelectedFeesInput();
                    });

                    li.appendChild(removeBtn);
                    selectedFeesList.appendChild(li);

                    updateSelectedFeesInput();
                    selectElement.value = "";
                }
            });

            function updateSelectedFeesInput() {
                selectedFeesInput.value = Array.from(selectedFees.keys()).join(",");
            }
        });
    </script>
    <script>
        document.getElementById('payable_id').addEventListener('input', function() {
            // Kunin ang value ng payable_id at i-set ito sa downpayment_id2
            document.getElementById('paymenthidden_id2').value = this.value;
            document.getElementById('downpayment_2').value = this.value;

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#checke_id').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
    </script>
    <script>
        document.getElementById('payment_status').addEventListener('change', function() {
            const bankDetailsDiv = document.getElementById('bank-details');
            const bankDetailsInput = document.getElementById('bank_details_input');

            if (this.value === 'Cash') {
                bankDetailsDiv.style.display = 'none'; // Itago ang input field
                bankDetailsInput.removeAttribute('required'); // Alisin ang required attribute
                bankDetailsInput.value = ''; // I-clear ang input value
            } else if (this.value !== '') {
                bankDetailsDiv.style.display = 'block'; // Ipakita ang input field
                bankDetailsInput.setAttribute('required', 'required'); // Gawing required ang input field
            }
        });
    </script>
@endpush
