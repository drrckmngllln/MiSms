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
                        <label>Total Lecture Units</label>
                        <input type="t" class="form-control" name="total_units" id="lecture_units" readonly>
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
                                            <select name="school_year" id="school_year" class="form-select " required>
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($sch_years as $sy)
                                                    <option value="{{ $sy->id }}">{{ $sy->code }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" class="form-control" name="school_year" id="school_year_code" readonly> --}}
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
                                            <select name="course_id" id="courseSelect" class="form-select " required>
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($course as $ce)
                                                    <option value="{{ $ce->id }}"
                                                        data-department-id="{{ $ce->department_id }}"
                                                        {{ $ce->description }}>{{ $ce->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label>Department Description</label>
                                                <select class="form-control" name="department_id" id="departmentSelect"
                                                    readonly selected disabled>
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
                                <table id="section-subjects"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Subject ID</th>
                                            <th>Code</th>
                                            <th>Descriptive Title</th>

                                            <th>Laboratory</th>
                                            <th>Time</th>
                                            <th>Day</th>
                                            <th>Room</th>
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
            $('#course_idsssss').val(course_id);
            $('#edittt_campus_id').val(campus_id);
            $('#full_name_id').val(fullName);
            $('#id_number_id').val(id_number);

            $.ajax({
                url: location.origin + '/superadmin/curriculum/curriculum_section/' +
                    curriculum_id,
                method: 'GET',
                success: function(sections) {
                    // console.log('section', sections);
                    const select_curr = $('#sec_id');
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

            // $.ajax({
            //     url: location.origin + '/superadmin/curriculum/curriculum_section/' + curriculum_id,
            //     method: 'GET',
            //     success: function(sections) {
            //         const select_curr = $('#sec_id');
            //         select_curr.empty();
            //         select_curr.append($("<option>").text("--Available Sections--").val('').attr('selected',
            //             true).attr('disabled', true));
            //         for (const curr of sections) {
            //             if (curr.number_of_students < curr.max_number_of_students) {
            //                 const newOption = $("<option>").text(curr.section_code).val(curr.id);
            //                 select_curr.append(newOption);
            //             }
            //         }
            //     },
            //     error: function(xhr, status, error) {
            //         console.log(error);
            //     }
            // });
            var table = $('#highSchoolTable').DataTable();
            $(document).ready(function() {
                $('#student_subject').on('submit', function(event) {

                    //eto yung pag save ngg and pag enroll ng mga subject
                    event.preventDefault();

                    const formValues = $(this).serializeArray();
                    const formData = new FormData();

                    formValues.forEach((item) => {
                        formData.append(item.name, item.value);
                    });

                    const dt = $("#section-subjects").DataTable();

                    dt.data().toArray().forEach((item) => {

                        formData.append('subjects[]', JSON.stringify(item));
                    });
                    formData.append('first_name', first_name);
                    formData.append('middle_name', middle_name);
                    formData.append('last_name', last_name);


                    //eto yung alert
                    // console.log(first_name);
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
                                url: '{{ route('superadmin.student.subjectSaveHs') }}',
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(data) {
                                    if (data.status === 'success') {
                                        toastr.success(data.message);
                                        table.ajax.reload();
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
    {{-- <script>
        //curriculum by section
        $(document).ready(function() {
            $('#curriculum_id').on('change', function(event) {
                const curriculum_id = event.target.value;
                // console.log('curriculum_id', curriculum_id);
                $.ajax({
                    url: location.origin + '/superadmin/curriculum/curriculum_section/' +
                        curriculum_id,
                    method: 'GET',
                    success: function(sections) {
                        console.log('section', sections);

                        const select_curr = $('#sec_id');
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
    </script> --}}
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
            // console.log(section_code);
            const url = location.origin + '/superadmin/curriculum_courses/' + year_level +
                "/" + semester_id + "/" + section_code;
            const requestData = {
                section_code: section_code,
                semester_id: semester_id,
                year_level: year_level,
            }

            $("#section-subjects").DataTable().destroy();
            var dt = $("#section-subjects").DataTable({
                processing: true,
                serverSide: false,

                ajax: {
                    url: url,
                    type: 'GET',
                    data: requestData,
                    dataSrc: function(response) {
                        return response.data;
                    }
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
                        data: 'descriptive_tittle',
                        name: 'descriptive_tittle'
                    },

                    {
                        data: 'lab_id',
                        name: 'lab_id',
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
                    var dt = $("#section-subjects").DataTable();
                    var totalUnits = 0;
                    var lectureUnits = 0;
                    var labUnits = 0;
                    dt.rows().every(function(index, element) {
                        var data = this.data();
                        //console test if yung datatable is may laman
                        // console.log(data);
                        totalUnits += parseFloat(data.total_units);
                        lectureUnits += parseFloat(data.lecture_units);
                        labUnits += parseFloat(data.lab_units);
                    });

                    // Update the total units input
                    $('#total_units').val(totalUnits);
                    $('#lecture_units').val(lectureUnits);
                    $('#lab_units').val(labUnits);
                }
            });
            $('#section-subjects').on('click', '.delete-row', function() {
                var tr = $(this).closest('tr');
                dt.row(tr).remove();
                tr.remove();
            });
        });
    </script>


    <script>
        $(document).on('click', '.delete-row', function() {
            var dt = $("#section-subjects").DataTable();
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
        document.getElementById('courseSelect').addEventListener('change', function() {
            var courseSelect = document.getElementById('courseSelect');
            var departmentSelect = document.getElementById('departmentSelect');
            var selectedCourseId = courseSelect.options[courseSelect.selectedIndex].getAttribute(
                'data-department-id');


            departmentSelect.selectedIndex = -1;


            departmentSelect.disabled = false;


            for (var i = 0; i < departmentSelect.options.length; i++) {
                if (departmentSelect.options[i].value === selectedCourseId) {
                    departmentSelect.selectedIndex = i;
                    break;
                }
            }
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
        var code1Value = document.getElementById("code")?.value;
        // console.log(code1Value);
        const sy_code = document.getElementById("school_year_code");
        if (sy_code) {
            sy_code.value = code1Value;
        }
    </script>
@endpush
