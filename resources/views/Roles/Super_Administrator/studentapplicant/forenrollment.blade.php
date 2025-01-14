<!-- Modal content for the above example -->

<div class="modal fade bs-example-modal-xl" tabindex="-1" id="viewForEnrollement" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">


                <h5 class="modal-title" id="myExtraLargeModalLabel">Enrollment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Navigation Tabs -->
                <!-- Form -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action=""method="POST" enctype="multipart/form-data" id="Enrolled_Students">
                                @csrf
                                @method('POST')
                                <input type="hidden" id="view_student_applicant" name="student_applicant_id">
                                <div class="row" id="edit_page_1_view">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="id_number" class="form-label">ID Number</label>
                                            <input type="text" name="id_number" id="view_enrollment"
                                                class="form-control" placeholder="" aria-describedby="helpId" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="course" class="form-label">Course</label>
                                            <select name="course_id" id="course_id" class="form-select " required>
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="curriculum" class="form-label">Curriculum</label>
                                            <select name="curriculum_id" id="curriculum_id" class="form-select "
                                                required>
                                                <option value="" selected disabled>--Select One--</option>
                                                <option value="">
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="year_level" class="form-label">Year Level</label>
                                            <input type="text" name="year_level" id="year_level" class="form-control"
                                                placeholder="" aria-describedby="helpId" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="section" class="form-label">Section</label>
                                            <select name="section_code" id="section_id" class="form-select" required>
                                                <option value="" selected disabled>--Select One--</option>
                                                <option value="">
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="semester" class="form-label">Semester</label>
                                            <input type="text" name="semester" id="semester" class="form-control"
                                                placeholder="" aria-describedby="helpId" required>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="student_type" class="form-label">Type</label>
                                            <select name="student_type" id="student_type" class="form-select" required>
                                                <option value="" selected disabled>--Select One--</option>
                                                <option value="1">Regular</option>
                                                <option value="0">Irregular</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="student_type" class="form-label">Status</label>
                                            <select name="status" id="status_id" class="form-select" required>
                                                <option value="" selected disabled>--Select One--</option>
                                                <option value="1">For Assesment</option>
                                                <option value="0">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <table id="datatable-curriculum-courses"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Total Units</th>
                                            <th>Lecture Units</th>
                                            <th>Lab Units</th>
                                            <th>Pre Requisite</th>
                                            <th>Total Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                {{-- <div class="d-flex">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#EditModal">
                                                                    <button type="button"
                                                                        class="btn btn-primary waves-effect waves-light"
                                                                        data-data="">
                                                                        <i class="ri-edit-2-fill"></i>
                                                                    </button>
                                                                </a>
                                                                <form
                                                                    action="{{ route('dashboard.activities.destroy', $act->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger delete-item"
                                                                        style="margin-left: 2px;">
                                                                        <i class="ri-delete-bin-6-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </div> --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                    style="float: left;" id="submit_id">Save</button>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Total</label>
                            <input type="t" class="form-control" name="total_units" id="total_units" readonly>
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
        $(document).ready(function() {
            $('#course_id').on('change', function(event) {
                const course_id = event.target.value;
                $.ajax({
                    url: location.origin + '/superadmin/curriculum/by_course/' + course_id,
                    method: 'GET',
                    success: function(curriculums) {
                        // console.log('data', curriculums);    
                        const select_curr = $('#curriculum_id');
                        select_curr.empty();
                        select_curr.append($("<option>").text("--Select One--").val('').attr(
                            'selected', true).attr('disabled', true));

                        for (const curr of curriculums) {
                            const newOption = $("<option>").text(curr.code).val(curr.id);
                            select_curr.append(newOption);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            })
            //datatables
            $('#curriculum_id').on('change', function(event) {
                const curriculum_id = event.target.value;
                console.log('curriculum_id', curriculum_id);
                const url = location.origin + '/superadmin/curriculum_courses/' + curriculum_id;
                curriculum_id;

                $("#datatable-curriculum-courses").DataTable().destroy();
                $("#datatable-curriculum-courses").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url,
                    columns: [{
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'descriptive_tittle',
                            name: 'descriptive_tittle'
                        },
                        {
                            data: 'total_units',
                            name: 'total_units'
                        },
                        {
                            data: 'lecture_units',
                            name: 'lecture_units'
                        },
                        {
                            data: 'lab_units',
                            name: 'lab_units'
                        },
                        {
                            data: 'pre_requisite',
                            name: 'pre_requisite'
                        },
                        {
                            data: 'total_hrs_per_week',
                            name: 'total_hrs_per_week'
                        }
                    ],
                });
                $.ajax({
                    type: 'GET',
                    url: '/superadmin/totalunits/by_studentsapplicant/' + section_id,
                    success: function(responseData) {
                        if (responseData.status === 'success') {
                            const totalUnits = responseData
                                .data;
                            $('#total_units').val(
                                totalUnits
                            );
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

        function viewEnrollment(id, id_number) {

            $('#view_student_applicant').val(id);
            $('#view_enrollment').val(id_number);
        }
    </script>
    <script>
        //section by course
        $(document).ready(function() {
            $('#course_id').on('change', function(event) {
                const course_id = event.target.value;
                // console.log('course_id', course_id);
                $.ajax({
                    url: location.origin + '/superadmin/section/by_course/' +
                        course_id,
                    method: 'GET',
                    success: function(sections) {
                        // console.log('section', sections);

                        const select_curr = $('#section_id');
                        select_curr.empty();
                        select_curr.append($("<option>").text("--Available Sections--").val(
                            '').attr(
                            'selected', true).attr('disabled', true));

                        //tung section code dito dapat yun yung laman ng database  
                        for (const curr of sections) {
                            const newOption = $("<option>").text(curr.section_code).val(curr
                                .id);
                            select_curr.append(newOption);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
    {{-- //alert for submit subject and students for regular --}}
    <script>
        $(document).ready(function() {
            $('#Enrolled_Students').on('submit', function(event) {
                event.preventDefault();
                // console.log('promises!');
                // return;
                let formData = $(this).serializeArray();
                // Determine the appropriate title and confirmation text based on the current toggle state
                const title = 'Are you sure you want to enroll this subject?';
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
                            url: "{{ route('superadmin.enrolled.students') }}",
                            method: 'POST',
                            data: formData,
                            success: function(data) {
                                toastr.success(data.message);
                                // Show an additional Swal alert for successful status change
                                if (data.status == 'success') {
                                    Swal.fire({
                                        title: 'Status Changed!',
                                        text: data.message,
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    } else {
                        // Reset the checkbox to its original state if the user clicks Cancel
                        $(this).prop('checked', !isChecked);
                    }
                });
            });
        });
    </script>
@endpush
