<div class="modal fade bs-example-modal-xl" tabindex="-1" id="enrollStudent" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-header">


                <h5 class="modal-title" id="myExtraLargeModalLabel">Enrollment</h5>


                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <!-- Navigation Tabs -->
                <!-- Form -->
                <button type="button" id="addSubjectOnEnroll"
                    class="btn btn-secondary waves-effect waves-light mb-2 OpenModal">
                    <i class="ri-add-line"></i> Add Subjects
                </button>
                <div class="row">

                    <div class="col-md-2 mb-3">
                        <label>Total Units</label>
                        <input type="t" class="form-control" name="total_units" id="total_units" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Total Lab Units</label>
                        <input type="t" class="form-control" name="lab_units" id="lab_units" readonly>
                    </div>


                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action=""method="POST" id="student_subject">
                                @csrf
                                @method('POST')
                                <input type="hidden" id="enrolled_student" name="enrol_student_id">
                                <div class="row" id="enrolled_student">
                                    <input type="text" name="full_name" id="full_name_id" hidden>
                                    <input type="text" name="id_number" id="id_number_id" hidden>

                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label for="course" class="form-label">School Year</label>
                                            <select name="school_year" id="school_year" class="form-select" required>
                                                <option value="" disabled selected>--Select One--</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="id_number" class="form-label">ID Number</label>
                                            <input type="text" name="id_number" id="view_id_number"
                                                class="form-control" placeholder="" aria-describedby="helpId" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="curriculum" class="form-label">Curriculum</label>
                                            <select name="curriculum_id" id="curriculum_ide" class="form-select "
                                                required>
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($curriculum as $cm)
                                                    <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                                                @endforeach
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="course" class="form-label">Course</label>
                                            <select name="course_id" id="courseSelect" class="form-select ">
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($course as $ce)
                                                    <option value="{{ $ce->id }}" {{ $ce->description }}>
                                                        {{ $ce->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label>Department Description</label>
                                                <select class="form-control" name="department_id" id="departmentSelect"
                                                    required>
                                                    <option value=""></option>
                                                    @foreach ($department as $dp)
                                                        <option value="{{ $dp->id }}">{{ $dp->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="campus_id" class="form-label">Campus</label>
                                            <select name="campus_id" id="edittt_campus_id" class="form-select "
                                                required>
                                                <option value="" selected disabled>--Select One--</option>

                                                @foreach ($campus as $cp)
                                                    <option value="{{ $cp->id }}">{{ $cp->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="year_level" class="form-label">Year Level</label>
                                            <input type="text" name="year_level" id="view_year_level"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="semester" class="form-label">Semester</label>
                                            <input type="text" name="semester" id="semester_id"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="section_id" class="form-label">Section</label>
                                            <select name="section_id" id="sec_id" class="form-select" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <table id="section-subject"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Subject ID</th>
                                            <th>Code</th>
                                            <th>Descriptive Title</th>
                                            <th>Total Units</th>
                                            <th>Laboratory</th>
                                            <th>Time</th>
                                            <th>Day</th>
                                            <th>Room</th>
                                            <th>Instructor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                    style="float: left;" id="submit_id">Save</button>
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
        function enrollStudents(id, id_number, curriculum_id, course_id, campus_id, first_name, middle_name, last_name,
            number_of_students) {


            var fullName = first_name + ' ' + (middle_name ? middle_name + ' ' : '') + last_name;
            $('#enrolled_student').val(id);
            $('#view_id_number').val(id_number);
            $('#curriculum_ide').val(curriculum_id);
            $('#courseSelect').val(course_id);
            $('#edittt_campus_id').val(campus_id);
            $('#full_name_id').val(fullName);
            $('#id_number_id').val(id_number);

            $('#school_year').val('');
            $('#view_year_level').val('');
            $('#semester_id').val('');

            const dt = $("#section-subject").DataTable();
            dt.clear().draw();

            $.ajax({
                url: "{{ route('superadmin.courseId.department') }}",
                type: 'GET',
                data: {
                    course_id: course_id
                },
                success: function(response) {
                    if (response.department_id) {
                        $('#departmentSelect').prop('disabled', false);
                        $('#departmentSelect').val(response.department_id);
                        $('#departmentSelect').prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching department:', error);
                }
            });



            //merge two input pass on backend
            $('#view_year_level, #semester_id').on('input', function() {
                updateSections();
            });

            function updateSections() {
                const curriculum_id = $('#curriculum_ide').val();
                const year_level = $('#view_year_level').val();
                const semester = $('#semester_id').val();
                const school_year = $('#school_year').val();

                if (curriculum_id && year_level && semester) {
                    $.ajax({
                        url: location.origin + '/superadmin/curriculum/curriculum_section/' + curriculum_id,
                        method: 'GET',
                        data: {
                            year_level: year_level,
                            semester: semester,
                            school_year: school_year
                        },
                        success: function(sections) {
                            const select_curr = $('#sec_id');
                            select_curr.empty();
                            select_curr.append($("<option>").text("--Available Sections--").val('').attr(
                                'selected',
                                true).attr('disabled', true));

                            for (const curr of sections) {
                                const newOption = $("<option>").text(curr.section_code).val(curr.id);
                                select_curr.append(newOption);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }

            // Form submission for student subject enrollment
            var table = $('#createaccount-table').DataTable();
            $(document).ready(function() {
                $('#student_subject').on('submit', function(event) {
                    event.preventDefault();

                    const formValues = $(this).serializeArray();
                    const formData = new FormData();

                    formValues.forEach((item) => {
                        formData.append(item.name, item.value);
                    });

                    const dt = $("#section-subject").DataTable();
                    dt.data().toArray().forEach((item) => {
                        formData.append('subjects[]', JSON.stringify({
                            ...item,
                            lab_name: item.lab_name ?? ''
                        }));
                    });
                    formData.append('first_name', first_name);
                    formData.append('middle_name', middle_name);
                    formData.append('last_name', last_name);
                    formData.append('department_id', $('#departmentSelect').val());

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
                                url: '{{ route('superadmin.student.subjectSave') }}',
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(data) {
                                    if (data.status === 'success') {
                                        toastr.success(data.message);
                                        table.ajax.reload();
                                        dt.clear().draw();
                                        $('#enrollStudent').modal('hide');
                                    } else {
                                        toastr.error(data.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                }
                            });
                        }
                    });
                });
            });
        }
    </script>

    <script>
        let addModal = new bootstrap.Modal(document.getElementById('addSubject'))
        $(document).ready(function() {

            // nilagay natin tung Open modal dito dahil undefiend siya
            function OpenModal() {
                // console.log("OpenModal");
                addModal.show();
                // $('#adddetails').modal('show');
            }
            $(".OpenModal").click((event) => {
                OpenModal();
                event.stopPropagation();
            })
        });
        let dt;
        //pagka select ng section dapat mag papakita yung  mga subject
        $('#sec_id').on('change', function(event) {
            // console.log('testinng');
            const curriculum_id = $('#curriculum_ide').val();
            const year_level = $('#view_year_level').val();
            const semester_id = $('#semester_id').val();
            const section_code = $('#sec_id').val();


            const url = location.origin + '/superadmin/curriculum_courses/' + year_level +
                "/" + semester_id + "/" + section_code;
            const requestData = {
                section_code: section_code,
                semester_id: semester_id,
                year_level: year_level,
            }
            $("#section-subject").DataTable().destroy();
            var dt = $("#section-subject").DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: url,
                    type: 'GET',
                    data: requestData,
                    dataSrc: function(response) {
                        return response.data;
                        dt.clear().draw();
                    }
                },
                columns: [{
                        data: 'subject_id',
                        name: 'subject_id'
                    },
                    {
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
                        data: 'lab_name',
                        name: 'lab_name',
                    },
                    {
                        data: 'time',
                        name: 'time',
                    },
                    {
                        data: 'day',
                        name: 'day',
                    },
                    {
                        data: 'room',
                        name: 'room',
                    },
                    {
                        data: 'instructor_id',
                        name: 'instructor_id',
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            return '<button type="button" class="btn btn-danger delete-row">Delete</button>';
                        }
                    }

                ],
                //click 2 modal
                drawCallback: () => {
                    $(".OpenModal").click((event) => {
                        OpenModal();
                        event.stopPropagation();
                    })
                    //add units on table
                    var dt = $("#section-subject").DataTable();
                    var totalUnits = 0;
                    // var lectureUnits = 0;
                    var labUnits = 0;
                    dt.rows().every(function(index, element) {
                        var data = this.data();
                        //console test if yung datatable is may laman
                        // console.log(data);
                        totalUnits += parseFloat(data.total_units);
                        // lectureUnits += parseFloat(data.lecture_units);
                        // labUnits += parseFloat(data.lab_units);
                    });

                    // Update the total units input
                    $('#total_units').val(totalUnits);
                    // $('#lecture_units').val(lectureUnits);
                    $('#lab_units').val(labUnits);
                }
            });
            $('#section-subject').on('click', '.delete-row', function() {
                var tr = $(this).closest('tr');
                dt.row(tr).remove();
                tr.remove();
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-row', function() {
            var dt = $("#section-subject").DataTable();
            var tr = $(this).closest('tr');
            var data = dt.row(tr).data();

            var totalUnits = parseFloat($('#total_units').val());
            var lectureUnits = parseFloat($('#lecture_units').val());
            var labUnits = parseFloat($('#lab_units').val());

            // Update the units based on the row being deleted
            totalUnits -= parseFloat(data.total_units);
            lectureUnits -= parseFloat(data.lecture_units);
            labUnits -= parseFloat(data.lab_units);

            // Update the input fields with the new values
            $('#total_units').val(totalUnits);
            $('#lecture_units').val(lectureUnits);
            $('#lab_units').val(labUnits);

            dt.row(tr).remove().draw();
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".OpenModal").click(function() {
                $(".modal-dialog").css("margin-left", "100px");
            });
        });
    </script>
    <script>
        var code1Value = document.getElementById("code").value;
        document.getElementById("school_year_code").value = code1Value;
    </script>
    <script>
        $(document).ready(function() {
            // Check if no option is selected (in case no school year has status 1)
            if ($('#school_year option:selected').length === 0) {
                $('#school_year option:first').prop('selected', true);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#enrollStudent').on('show.bs.modal', function() {
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
                                    console.log('IDs sent successfully:',
                                        allSchoolYearIds);


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
