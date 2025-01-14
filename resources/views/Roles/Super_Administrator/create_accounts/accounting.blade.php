<div class="modal fade bs-example-modal-xl" tabindex="-1" id="accountingModal" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">


                <h5 class="modal-title" id="student">Student Assessment: <span id="student_name"></span>
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <form action=""method="POST" id="student_fees">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="student_assessment" name="student_assessment">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label>ID number</label>
                            <input type="text" class="form-control" name="id_number" id="id_numbers" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select name="course_id" id="course_id_id" class="form-select " required>
                                <option value="" selected disabled>--Select One--</option>
                                @foreach ($course as $ce)
                                    <option value="{{ $ce->id }}">{{ $ce->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="campus_id" class="form-label">Campus</label>
                            <select name="campus_id" id="select_campus_id" class="form-select " required>
                                <option value="" selected disabled>--Select One--</option>
                                @foreach ($campus as $cp)
                                    <option value="{{ $cp->id }}">{{ $cp->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label>Year Level</label>
                            <input type="text" class="form-control" name="year_level" id="year_level_id">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label>Or Number</label>
                            <input type="text" class="form-control" name="or_number" id="setOrNumber" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Semester</label>
                            <input type="text" class="form-control" name="semester" id="semester_id_id">
                        </div>


                        <div class="col-md-2 mb-3">
                            <label for="course" class="form-label">School Year</label>
                            <select name="school_year" id="select_school_year" class="form-select" required>
                                <option value="" disabled selected>--Select One--</option>
                            </select>
                        </div>


                        <div class="col-md-2 mb-3">
                            <label>Tuition Fee</label>
                            <h5>Total:<input type="text" name="" id="total_tuition_fees" readonly></h5>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Lab Fee</label>
                            <h5>Total:<input type="text" name="" id="total_laboratory_fees" readonly></h5>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Miscellaneous Fee</label>
                            <h5>Total: <input type="text" name="total_miscfee_first_year" id="total_misc_fees"
                                    readonly>
                            </h5>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Other Fee</label>
                            <h5>Total: <input id="total_other_fees"></input></h5>
                        </div>
                        {{-- <div class="col-md-2 mb-3">
                            <label>Discount</label>
                            <h4>Total: <span>0</span></h4>
                        </div> --}}
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" id="enrolled_student" name="enrol_student_id">
                                <div class="row" id="enrolled_student">
                                    <div class="row">
                                        {{-- //content --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3 ">
                                        <label>Fee Breakdown</label>
                                        <input type="text" name="sdownpayment" id="edit_sdownpayment" hidden>
                                        <input type="text" name="sprelims" id="edit_prelims" hidden>
                                        <input type="text" name="smidterms" id="edit_midterms" hidden>
                                        <input type="text" name="ssemi_finals" id="edit_semi_final" hidden>
                                        <input type="text" name="sfinals" id="edit_finals" hidden>
                                        <input type="text" name="stotal_assessment" id="edit_total_assessment"
                                            hidden>
                                        <input type="text" name="totalAss" id="edit_totalAss" hidden>

                                        <h5>Downpayment: <input type="text" id="down_payment" name="downpayment"
                                                style="margin-left: 10px;" readonly></h5>
                                        <h5>Prelims: <input type="text" name="prelims" id="prelims"
                                                style="margin-left: 65px;" readonly></h5>
                                        <h5>Midterms:<input type="text" name="midterms" id="midterms"
                                                style="margin-left: 57px;" readonly></h5>
                                        <h5>Semi-Finals: <input type="text" name="semi_finals" id="semi_final"
                                                style="margin-left: 32px;" readonly></span>
                                        </h5>
                                        <h5>Finals:<input type="text" name="finals" id="finals"
                                                style="margin-left: 85px;" readonly></h5>
                                        <br>
                                        </br>
                                        <h5>Total Assessment: <input type="text" name="total_assessment"
                                                id="total_assessment" readonly></h5>
                                    </div>

                                    <div class="col-md-9 mb-12">
                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <label for="course" class="form-label">Student Status</label>
                                                <select name="cross_enrollee" id="cross_enrollee_id"
                                                    class="form-select" required>
                                                    <option value="Regular Student">Regular Student</option>
                                                    <option value="Cross Enrollee">Cross Enrollee/Delete Fees</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-6">
                                                <label for="course" class="form-label">Add Other Fees</label>
                                                <select name="add_other_fees" id="add_other_fees_id"
                                                    class="form-select">
                                                    <option value="">Select Fees</option>
                                                    @foreach ($otherFees as $fees)
                                                        <option value="{{ $fees->id }}">{{ $fees->description }},
                                                            {{ $fees->category }}, {{ $fees->semester }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <table id="accounting-subject-table"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Fee Type</th>
                                                    <th>Amount</th>
                                                    <th>Units</th>
                                                    <th>Computation</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                    style="float: left;" id="accounting_btn_id">Confirm Assesment</button>

                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>
</div>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        var semesterValue;

        function studentAss(id, id_number, first_name, middle_name, last_name, code, campus_id, year_level, semester,
            school_year) {

            //kungg meron siyang middle name MERON kung wala wala
            semesterValue = semester;
            // console.log(semesterValue);
            var fullName = first_name + ' ' + (middle_name ? middle_name + ' ' : '') + last_name;
            $('#student_assessment').val(id);
            $('#student_name').html(fullName);
            $('#id_numbers').val(id_number);
            $('#course_id_id').val(code);
            $('#select_campus_id').val(campus_id);
            $('#year_level_id').val(year_level);
            $('#semester_id_id').val(semester);
            // $('#select_school_year').val(school_year);

            var table = $('#createaccount-table').DataTable();

            $(document).ready(function() {
                $('#student_fees').on('submit', function(event) {
                    event.preventDefault();
                    // console.log('testing');

                    const formValues = $(this).serializeArray();
                    const formData = new FormData();

                    formValues.forEach((item) => {
                        formData.append(item.name, item.value);
                    });
                    const dt = $("#accounting-subject-table").DataTable();

                    dt.data().toArray().forEach((item) => {
                        formData.append('fees[]', JSON.stringify(item));
                    });
                    formData.append('first_name', first_name);
                    formData.append('middle_name', middle_name);
                    formData.append('last_name', last_name);

                    //eto yung alert
                    const title = 'Are you sure?';
                    Swal.fire({
                        title: title,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'YES',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('superadmin.student.feeSave') }}',
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(data) {
                                    toastr.success(data.message);
                                    table.ajax.reload();
                                    dt.clear().draw();
                                    $('#accountingModal').modal('hide');
                                    $('#select_school_year').val('');
                                    $('#down_payment').val('');
                                    $('#prelims').val('');
                                    $('#midterms').val('');
                                    $('#semi_final').val('');
                                    $('#finals').val('');
                                    $('#total_assessment').val('');
                                    $('#total_tuition_fees').val('');
                                    $('#total_laboratory_fees').val('');
                                    $('#total_misc_fees').val('');
                                    $('#total_other_fees').val('');
                                },
                                error: function(xhr, status, error) {}

                            });

                        }
                    });
                });
            });
        }
        $(document).ready(function() {
            const url = location.origin + '/superadmin/create_account/fees';

            // Initialize DataTable
            var dt = $("#accounting-subject-table").DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: url,
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    data: function(d) {
                        d.campus_id = $('#select_campus_id').val();
                        d.year_level = $('#year_level_id').val();
                        d.student_id = $('#id_numbers').val();
                        d.course_id = $('#course_id_id').val();
                        d.semester = $('#semester_id_id').val();
                        return JSON.stringify(d);
                    },
                    dataSrc: function(response) {
                        $('#total_assessment').val(response.total.toFixed(2));
                        $('#edit_total_assessment').val(response.total.toFixed(2));
                        $('#edit_totalAss').val(response.total.toFixed(2));

                        const breakdown = (+response.total / 5).toFixed(2);
                        $('#down_payment').val(breakdown);
                        $('#edit_sdownpayment').val(breakdown);
                        $('#prelims').val(breakdown);
                        $('#edit_prelims').val(breakdown);
                        $('#midterms').val(breakdown);
                        $('#edit_midterms').val(breakdown);
                        $('#semi_final').val(breakdown);
                        $('#edit_semi_final').val(breakdown);
                        $('#finals').val(breakdown);
                        $('#edit_finals').val(breakdown);

                        $('#total_tuition_fees').val(response.total_tuition_fees.toFixed(2));
                        $('#total_misc_fees').val(response.total_misc_fee.toFixed(2));
                        $('#total_other_fees').val(response.total_other_fees.toFixed(2));
                        $('#total_laboratory_fees').val(response.total_laboratory_fees.toFixed(2));

                        //delete 0 response
                        response.data = response.data.filter(function(row) {
                            return parseFloat(row.amount) !== 0 && parseFloat(row
                                .computation) !== 0;
                        });

                        return response.data;
                    }
                },
                columns: [{
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'fee_type',
                        name: 'fee_type'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render: function(data) {
                            return parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'lecture_units',
                        name: 'lecture_units'
                    },
                    {
                        data: 'computation',
                        name: 'computation',
                        render: function(data) {
                            return parseFloat(data).toFixed(2);
                        }
                    },

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<button class="btn btn-danger btn-sm delete-btn" style="display: none;">Delete</button>';
                        }
                    }
                ]
            });


            function toggleDeleteButtons() {
                const isCrossEnrollee = $('#cross_enrollee_id').val() === 'Cross Enrollee';

                if (isCrossEnrollee) {
                    $('.delete-btn').show();
                } else {
                    $('.delete-btn').hide();
                }
            }


            $('#select_school_year').on('change', function() {
                dt.ajax.reload(); // Reload DataTable data
                toggleDeleteButtons();
            });


            $('#cross_enrollee_id').on('change', function() {
                toggleDeleteButtons();
            });


            toggleDeleteButtons();

            // Delete button action
            $('#accounting-subject-table tbody').on('click', '.delete-btn', function() {
                const row = dt.row($(this).parents('tr'));
                const rowData = row.data();
                const rowCategory = rowData.category;
                const rowComputation = parseFloat(rowData.computation);

                row.remove().draw(false);
                toastr.success('Row deleted successfully.');


                if (rowCategory === "Laboratory Fees") {
                    let currentLabFee = parseFloat($('#total_laboratory_fees').val()) || 0;
                    currentLabFee -= rowComputation;
                    $('#total_laboratory_fees').val(currentLabFee.toFixed(2));
                } else if (rowCategory === "Miscellaneous Fee") {
                    let currentMiscFee = parseFloat($('#total_misc_fees').val()) || 0;
                    currentMiscFee -= rowComputation;
                    $('#total_misc_fees').val(currentMiscFee.toFixed(2));
                } else if (rowCategory === "Other Fees") {
                    let currentOtherFee = parseFloat($('#total_other_fees').val()) || 0;
                    currentOtherFee -= rowComputation;
                    $('#total_other_fees').val(currentOtherFee.toFixed(2));
                } else if (rowCategory === "Tuition Fees") {
                    let currentTuitionFee = parseFloat($('#total_tuition_fees').val()) || 0;
                    currentTuitionFee -= rowComputation;
                    $('#total_tuition_fees').val(currentTuitionFee.toFixed(2));
                }


                let totalAssessment = parseFloat($('#total_assessment').val()) || 0;
                totalAssessment -= rowComputation;
                $('#total_assessment').val(totalAssessment.toFixed(2));

                const newBreakdown = (totalAssessment / 5).toFixed(2);
                $('#down_payment').val(newBreakdown);
                $('#prelims').val(newBreakdown);
                $('#midterms').val(newBreakdown);
                $('#semi_final').val(newBreakdown);
                $('#finals').val(newBreakdown);
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#select_school_year');
                    select.empty();

                    select.append('<option value="" disabled selected>--Select One--</option>');

                    if (data.activeYears.length > 0) {
                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    } else {
                        select.append('<option value="" disabled>No active school year found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>
    <script>
        $.ajax({
            url: '/superadmin/fee-summary/latest-or-number',
            type: 'GET',
            success: function(response) {
                if (response.or_number) {

                    $('#setOrNumber').val(response.or_number);
                }
            },
            error: function(xhr, status, error) {

            }
        });


        $('#add_other_fees_id').select2({
            dropdownParent: $('#accountingModal'),
            dropdownAutoWidth: true
        });
    </script>|
    <script>
        $(document).on('change', '#add_other_fees_id', function() {
            const campus_id = $('#select_campus_id').val();
            const semester = $('#semester_id_id').val();
            const year_level = $('#year_level_id').val();
            const selectedFeeId = $(this).val();
            $.ajax({
                url: '{{ route('superadmin.add.otherFeestoStudent') }}',
                type: 'POST',
                data: {
                    campus_id: campus_id,
                    semester: semester,
                    year_level: year_level,
                    fee_id: selectedFeeId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    const feeData = response[0];
                    const feeAmount = parseFloat(feeData.fee_amount || 0);
                    const totalAssessment = parseFloat($('#total_assessment').val()) + feeAmount;
                    const totalOtherFees = parseFloat($('#total_other_fees').val()) + feeAmount;

                    $('#total_assessment').val(totalAssessment.toFixed(2));
                    $('#total_other_fees').val(totalOtherFees.toFixed(2));


                    const breakdown = (totalAssessment / 5).toFixed(2);
                    $('#down_payment').val(breakdown);
                    $('#prelims').val(breakdown);
                    $('#midterms').val(breakdown);
                    $('#semi_final').val(breakdown);
                    $('#finals').val(breakdown);


                    const table = $('#accounting-subject-table').DataTable();
                    table.row.add({
                        category: 'Other Fees',
                        fee_type: feeData.description,
                        amount: feeAmount.toFixed(2),
                        lecture_units: '1',
                        computation: feeAmount.toFixed(2),
                        action: '',
                    }).draw();
                },
                error: function() {

                }
            });
        })
    </script>
@endpush
