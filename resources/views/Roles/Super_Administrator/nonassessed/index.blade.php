@extends('Roles.layouts.master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <form action="" method="POST" id="fee_summaries_id">
                @csrf
                @method('POST')

                <input type="hidden" name="total_assessment" id="total_assessment_idddds">
                <input type="hidden" id="fee_student_collection" name="fee_student_collection">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <div class="d-flex gap-3 align-items-end">
                                {{-- <input type="text " hidden id="department_id" name="department"
                                    value="{{ $role }}"> --}}
                                {{-- <input type="text " hidden id="name" name="name" value="{{ $name }}"> --}}
                                <div class="form-group">
                                    <label>Set Or Number</label>
                                    <input type="text" class="form-control" name="or_number" id="setOrNumber"
                                        value="" required>
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
                                    <input type="text" class="form-control" name="date" id="edit_date" value=""
                                        readonly>
                                </div>
                            </div>
                            <h4 class="mb-sm-0"></h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Fee Collection</a></li>
                                    <li class="breadcrumb-item active mx-1">School Year</li>
                                    {{-- <select name="school_year" id="gender" class="form-select" aria-describedby="helpId">
                                        @foreach ($school_year as $sy)
                                            <option value="{{ $sy->id }}">{{ $sy->code }}</option>
                                        @endforeach
                                    </select> --}}
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card" style="width:1200px;">
                            <div class="card-body">
                                <h4 class="card-title">Statement of Account</h4>
                                <table id="nonassessed-table"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>ID Number</th>
                                            <th>OR Number</th>
                                            <th>Particulars</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                {{-- <input type="text" id="totalBalanceInputss" readonly> Total Balance --}}

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
                                <h5 class="card-title">Student Name: <span id="hiii"></span></h5>
                                <h5 class="card-title">Course: <span id="holeee"></span></h5>
                                <h5 class="card-title">Year Level: <span id="yahuu"></span></h5>
                                <h5 class="card-title">Semester: <span id="hahii"></span></h5>
                                <h5 class="card-title">Status: <span id="hoyy"></span></h5>
                                <h5 class="card-title">ID Number: <input type="text" name="id_number" id="heyy"
                                        readonly>
                                </h5>
                            </div>
                        </div>
                        <div class="card" style="width:370px; left:700px;">
                            <div class="card-body">
                                <h4 class="card-title">Collect</h4>

                                <h4 class="card-title">Amount Recieved: <input type="text" name="amount"
                                        id="downpayment_id">
                                </h4>
                                <input type="text" name="downpayment2" id="downpayment_idd" hidden>


                                <h4 class="card-title">Amount to pay: <input type="text" id="payable_id" name="payable">
                                </h4>

                                <h4 class="card-title">Excess: <input type="text" id="excess_id" name="excess">
                                </h4>
                                <h4 class="card-title">Particulars:
                                    <textarea rows="5" cols="30" name="particulars" id="particulars_id" required></textarea>
                                </h4>
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <button type="submit" id="amount_submit"
                                            class="btn btn-primary mx-10">Confirm</button>
                                    </div>

                                </div>
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

@include('Roles.Super_Administrator.nonassessed.selectStudent')

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#fee_summaries_id').submit(function(event) {
                event.preventDefault();
                // $('#balance_id').val(totalAssessmentValue);
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
                            url: '{{ route('superadmin.save.NonAssessed') }}',
                            data: formData,
                            success: function(response) {
                                $('#nonassessed-table').DataTable().ajax
                                    .reload();
                                $('#assesment-Breakdownsss').DataTable().ajax
                                    .reload();

                                if (response.status === 'success') {
                                    toastr.success('Confirmed!!');


                                    //exess Amount will display

                                    var excessAmount = $('#excess_id').val();
                                    // console.log(excessAmount);
                                    Swal.fire({
                                        title: 'Excess Amount',
                                        text: 'Your excess is ' + excessAmount,
                                        icon: 'success',
                                        confirmButtonText: 'Print Recipt',
                                    }).then((printResult) => {
                                        if (printResult.isConfirmed) {
                                            var formData = $(this).serialize();
                                            var studentId = window.idValue;
                                            // Check kung merong studentId
                                            if (studentId) {
                                                $.ajax({
                                                    type: 'GET',
                                                    url: 'printReciptNonAssessed/' +
                                                        studentId,
                                                    success: function(
                                                        response) {

                                                        $('#printrecipt-container')
                                                            .html(
                                                                response
                                                            );

                                                        // console.log(
                                                        //     response
                                                        // );
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
                                                                    .reload();
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
                            },
                            error: function(error) {
                                console.error('Error:', error);
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('#nonassessed-table').DataTable().destroy();
        $('#nonassessed-table').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: '/superadmin/get_non_assessed/',
                type: 'GET',
            },
            columns: [{
                    data: 'created_at',
                    name: 'created_at',

                },
                {
                    data: 'id_number',
                    name: 'id_number'
                },
                {
                    data: 'or_number',
                    name: 'or_number'
                },
                {
                    data: 'particulars',
                    name: 'particulars'
                },
                {
                    data: 'payable',
                    name: 'payable'
                },
            ],
        });
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
                var paddedValue = ('000000' + newValue).slice(-6);
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
                    console.log(response);
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
@endpush
