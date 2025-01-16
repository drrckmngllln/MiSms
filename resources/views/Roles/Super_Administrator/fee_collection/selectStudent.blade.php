<!--  Modal content for the above example -->
<div id="ehee"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Students:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="d-flex justify-content-center">
                    </div>
                    <table id="feeCollection-select-table"
                        class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Course</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        $('#feeCollection-select-table').DataTable().destroy();
        //initialize datatable 
        $('#feeCollection-select-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('superadmin.feeCollection.select') }}',
                type: 'GET',
                error: function(xhr, error, thrown) {
                    // Handle the Ajax error here
                    toastr.error('Enroll Student First or Check if there is a pending students');
                }
            },
            columns: [{
                    data: 'id_number',
                    name: 'id_number'
                },
                {
                    data: 'course',
                    name: 'course'
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
                    data: 'middle_name',
                    name: 'middle_name'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        var totalAssessmentValue;
        var idValue;

        function addSelectStudent(id, id_number, status, last_name, first_name, middle_name, code, year_level, semester,
            downpayment, premils, midterms, semi_finals, finals, total_assessment, computation, campus_id, school_year,
            sdownpayment, sprelims, smidterms, ssemi_finals, sfinals, stotal_assessment, department_id, campus_id, course_id
        ) {

            // Original addSelectStudent content dito
            // event.preventDefault();
            totalAssessmentValue = computation;

            idValue = id;
            $('#hahi').text(semester);
            $('#yahu').text(year_level);
            $('#holee').text(code);
            var fullName = last_name + ' ' + first_name + ' ' + (middle_name ? ' ' + middle_name : ' ');
            $('#hii').text(fullName);
            $('#hoy').text(status);
            $('#hey').val(id_number);

            $('#ehee').modal('hide');
            $('#campus_id_id').val(campus_id);
            $('#semester_ID_ID').val(semester);
            $('#year_level_ID_ID').val(year_level);
            $('#dept_id').val(department_id);
            $('#campus_id_ID').val(campus_id);
            $('#course_id_id').val(course_id);

            filterFeesByCampus(campus_id);

            // console.log($('#fee-breakdown-table tbody tr:eq(4) td:eq(1)').text(finals));

            //throw the content of downpayment prelims ang other on other table
            $('#fee-breakdown-table tbody tr:eq(0) td:eq(1)').text(sdownpayment);
            $('#fee-breakdown-table tbody tr:eq(1) td:eq(1)').text(sprelims);
            $('#fee-breakdown-table tbody tr:eq(2) td:eq(1)').text(smidterms);
            $('#fee-breakdown-table tbody tr:eq(3) td:eq(1)').text(semi_finals);
            $('#fee-breakdown-table tbody tr:eq(4) td:eq(1)').text(sfinals);
            $('#fee-breakdown-table tbody tr:eq(5) td:eq(1)').text(stotal_assessment);

            $('#assesment-Breakdownsss').DataTable().destroy();
            $('#assesment-Breakdownsss').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/getFeeTypeComputation/' + id_number,
                    type: 'GET',
                },
                data: {
                    id_number: id_number,
                },
                columns: [{
                        data: 'fee_type',
                        name: 'fee_type'
                    },
                    {
                        data: 'computation2Tuition',
                        name: 'computation2Tuition'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                ],
            });

            $('#live-breakdown').DataTable().destroy();
            $('#live-breakdown').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/getNewBreakDown/' + id_number,
                    type: 'GET',
                },
                data: {
                    id_number: id_number,
                },
                columns: [{
                        data: 'downpayment',
                        name: 'downpayment'
                    },
                    {
                        data: 'prelims',
                        name: 'prelims'
                    },
                    {
                        data: 'midterms',
                        name: 'midterms'
                    },
                    {
                        data: 'semi_finals',
                        name: 'semi_finals'
                    },
                    {
                        data: 'finals',
                        name: 'finals'
                    },
                    {
                        data: 'total_assessment',
                        name: 'total_assessment'
                    },
                ],
            });


            $('#student-feesummaries-table').DataTable().destroy();
            $('#student-feesummaries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/getFeesummaries/' + id_number,
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
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'discountAmount',
                        name: 'discountAmount'
                    },
                    {
                        data: 'discountMiscFee',
                        name: 'discountMiscFee'
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
                        data: 'department',
                        name: 'department'
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
                        render: function(data, type, row, meta) {
                            if (meta.row === 0) {
                                runningBalance = parseFloat(row.total_assessment) - parseFloat(row
                                    .downpayment);
                            } else {
                                runningBalance = parseFloat(row.total_assessment) - parseFloat(row
                                    .downpayment);
                            }
                            return runningBalance.toFixed(2);
                        },
                        name: 'balance'
                    }
                ],
                drawCallback: function(settings) {

                    runningBalance = 0;
                }
            });


            //total of credit

            if (parseFloat(downpayment) === 0) {
                var payableAmount = parseFloat(premils);
            }
            if (parseFloat(premils) === 0) {
                var payableAmount = parseFloat(midterms);
            }
            if (parseFloat(midterms) === 0) {
                var payableAmount = parseFloat(semi_finals);
            }
            if (parseFloat(semi_finals) === 0) {
                var payableAmount = parseFloat(finals);
            }
            if (parseFloat(total_assessment) === 0) {
                var payableAmount = parseFloat(total_assessment);
            }
            // Update the payable input field
            $('#payable_id').val(payableAmount.toFixed(2));
            $('#paymenthidden_id2').val(payableAmount.toFixed(2));
            $('#downpayment_2').val(payableAmount.toFixed(2));


            // console.log(finals);

            //
        }

        function filterFeesByCampus(campusId) {
            const feesSelect = document.getElementById('fees_id');
            const options = feesSelect.options;

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const optionCampusId = option.getAttribute('data-campus-id');


                if (optionCampusId === campusId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }

            // Reset the selected option
            feesSelect.selectedIndex = 0;
        }


        // function addSelectStudent(id, id_number, status, last_name, first_name, middle_name, code, year_level, semester,
        //     downpayment, premils, midterms, semi_finals, finals, total_assessment, computation, campus_id, school_year,
        //     sdownpayment, sprelims, smidterms, ssemi_finals, sfinals, stotal_assessment, department_id, campus_id, course_id
        // ) {

        // }
    </script>
    <script></script>
@endpush
