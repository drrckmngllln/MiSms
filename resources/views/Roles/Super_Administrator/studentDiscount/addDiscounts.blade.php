<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" id="AddStudentDiscounts" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Select Discount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                    </div>

                    <input type="hidden" name="id_number" id="student_id_number">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label>Reference No.</label>
                            <input type="text" class="form-control" name="or_number" id="or_number_id" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>School Year</label>
                            <label for="course" class="form-label">School Year</label>
                            <select name="school_year" id="school_year" class="form-select" required>
                                <option value="" disabled selected>--Select One--</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Semester</label>
                            <input type="text" class="form-control" name="semester" id="sem_id" required>
                        </div>
                    </div>
                    <table id="students-select-discounts"
                        class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Section ID</th>
                                <th>Reason/Remarks</th>
                                <th>Discount Target</th>
                                <th>Default Selection</th>
                                <th>Discount Percentage</th>
                                <th>Discount Type</th>
                                <th>Discount Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
            <div class="modal-footer">
            </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        $("#students-select-discounts").DataTable().destroy();
        // Initialize DataTable with dynamic id_number
        $("#students-select-discounts").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('superadmin.students.Selectdiscounts') }}',
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'discount_target',
                    name: 'discount_target'
                }, {
                    data: 'description',
                    name: 'description'
                }, {
                    data: 'discount_percentage',
                    name: 'discount_percentage',
                },
                {
                    data: 'discount_type',
                    name: 'discount_type',
                },
                {
                    data: 'discount_code',
                    name: 'discount_code',
                },
                {
                    data: 'action',
                    name: 'action',

                },
            ],
        });
    </script>
    <script>
        function saveDiscount(id, code, discount_target, description, discount_percentage, discount_type, discount_code) {

            const urlParams = new URLSearchParams(window.location.search);
            const idNumber = urlParams.get('id');
            const schoolYear = $('#student_school_year').val();
            const or_number = document.getElementById('or_number_id').value;
            const school_year = document.getElementById('school_year').value;
            const semester = document.getElementById('sem_id').value;
            $('#or_number_id').val('');
            $('#school_year').val('');
            $('#sem_id').val('');

            if (!or_number || !school_year || !semester) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                url: '{{ route('superadmin.save.discount') }}',
                type: 'POST',
                data: {
                    id_number: idNumber,
                    discount_id: id,
                    code: code,
                    discount_target: discount_target,
                    description: description,
                    discount_percentage: discount_percentage,
                    school_year: school_year,
                    or_number: or_number,
                    semester: semester,
                    discount_type: discount_type,
                    discount_code: discount_code,
                    // department_id: departmentValue,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success('Discount saved successfully');
                    } else if (response.status === 'error') {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#AddStudentDiscounts').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('superadmin.get.activeYear') }}',
                    type: 'GET',
                    success: function(data) {
                        let select = $('#school_year');
                        select.empty();

                        if (data.activeYears.length === 1) {
                            let activeYearId = data.activeYears[0].id;
                            select.append('<option value="' + activeYearId + '" selected>' +
                                data.activeYears[0].code + '</option>');


                            localStorage.setItem('school_year', activeYearId);

                        } else {
                            select.append(
                                '<option value="" disabled selected>--Select One--</option>'
                            );
                            $.each(data.activeYears, function(index, schoolYear) {
                                select.append('<option value="' + schoolYear.id + '">' +
                                    schoolYear.code + '</option>');
                            });
                        }

                        // Collect all school_year IDs
                        let allSchoolYearIds = [];
                        $('#school_year option').each(function() {
                            let value = $(this).val();
                            if (value) {
                                allSchoolYearIds.push(value);
                            }
                        });

                        // Send school_year IDs if they exist
                        if (allSchoolYearIds.length > 0) {
                            $.ajax({
                                url: '{{ route('superadmin.get.sectionSubjects') }}',
                                type: 'POST',
                                data: {
                                    school_year: allSchoolYearIds,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {

                                    localStorage.setItem('school_year', JSON
                                        .stringify(allSchoolYearIds));
                                    $('#add-subject').DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error sending school year IDs:',
                                        error);
                                }
                            });
                        } else {
                            console.warn('No school year IDs found.');
                            alert('No school year IDs available to send.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching school years:', error);
                    }
                });
            });
        });
    </script>
@endpush
