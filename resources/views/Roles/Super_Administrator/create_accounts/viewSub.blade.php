<div class="modal fade bs-example-modal-xl" tabindex="-1" id="viewSubModal" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="student">Student: <span id="student_name_id"></span>
                    /
                </h5>
                <h5 class="modal-title mx-1" id="student">ID Number: <span id="student_id_number"></span>
                </h5>
                <div class="modal-header">
                    <div class="d-flex justify-content-end w-500">

                    </div>
                    <!-- Add other modal header content as needed -->
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label>Total Units</label>
                        <input type="t" class="form-control mb-2" name="total_units" id="total_units_id" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Lecture Units</label>
                        <input type="t" class="form-control mb-2" name="lecture_units" id="lecture_units_id"
                            readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Lab Units</label>
                        <input type="t" class="form-control mb-2" name="lab_units" id="lab_units_id" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="course" class="form-label">School Year</label>
                        <select name="school_year" id="school_year_id_for_subject" class="form-select" required>
                            <option value="" disabled selected>--Select One--</option>
                        </select>
                    </div>

                </div>
                <div class="col-md-2 mb-3">
                </div>
                <button type="button" id="addSubjectBtn"
                    class="btn btn-secondary waves-effect waves-light mb-2 OpenViewModal">
                    <i class="ri-add-line"></i> Add Subject
                </button>
                <form action=""method="POST" id="student_fees">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="student_assessment" name="student_sub_id">
                    <div class="row">

                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" id="enrolled_student" name="enrol_student_id">
                                <div class="row" id="enrolled_student">
                                    <div class="row">
                                        {{-- //content --}}
                                        <table id="view-student-subject"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Subject Code</th>
                                                    <th>Descriptive Title</th>
                                                    <th>Total Units</th>
                                                    <th>Lecture Units</th>
                                                    <th>Lab Units</th>
                                                    <th>Pre Requisite</th>
                                                    <th>Total Hrs.</th>
                                                    <th>Time</th>
                                                    <th>Day</th>
                                                    <th>Room</th>
                                                    <th>Laboratory</th>|
                                                    <th>Instructor</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <div class="modal-footer">


                </div>
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
        var idNumberValue;
        var courseIDNValue;
        var campusIDValue;
        var yearlevelValue;
        var curriculumValue;
        var semesterValue;
        var firstNameValue;
        var school_yearID;
        var departmentIDS;
        var sectionIDS;


        function studentSub(id, id_number, first_name, middle_name, last_name, year_level, school_year, course_id,
            campus_id, curriculum_id, semester, school_year, department_id, section_id) {



            idNumberValue = id_number;
            courseIDNValue = course_id;
            campusIDValue = campus_id;
            yearlevelValue = year_level;
            curriculumValue = curriculum_id;
            semesterValue = semester;
            firstNameValue = first_name;
            school_yearID = school_year;
            departmentIDS = department_id;
            sectionIDS = section_id;


            $('#student_sub_id').val(id);

            var fullname = first_name + ' ' + (middle_name ? middle_name + ' ' : ' ') + last_name;
            // console.log(school_year);
            $('#student_id_number').text(id_number);
            $('#student_name_id').text(fullname);
            $('#school_year_id').text(school_year);


            if (id_number.trim() !== '') {

                // Make an AJAX request to fetch the calculated total units
                $.ajax({
                    url: '/superadmin/calculate_units/' + id_number + '/' + semester,
                    type: 'GET',
                    success: function(response) {
                        var calculatedTotalUnits = response.total_units || 0;
                        var lectureUnits = response.lecture_units || 0;
                        var labUnits = response.lab_units || 0;

                        $('#total_units_id').val(calculatedTotalUnits);
                        $('#lecture_units_id').val(lectureUnits);
                        $('#lab_units_id').val(labUnits);

                    },
                    error: function(error) {
                        console.error('Error fetching calculated total:units'.error)
                    }
                });
            }
            let addModal = new bootstrap.Modal(document.getElementById('addviewSubject'));


            function OpenViewModal() {
                // console.log("OpenModal");
                addModal.show();
                // $('#adddetails').modal('show');
            }

            $(".OpenViewModal").click((event) => {
                OpenViewModal();
                event.stopPropagation();
            });

            drawCallback: () => {
                $(".OpenViewModal").click((event) => {
                    OpenViewModal();
                    event.stopPropagation();
                });
            }
            // Destroy the existing DataTable (if any)
            $("#view-student-subject").DataTable().destroy();
            // Initialize DataTable with dynamic id_number
            $("#view-student-subject").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/view_student_subject/',
                    type: 'GET',
                    data: {
                        id_number: id_number
                    },
                },
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
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'day',
                        name: 'day'
                    },
                    {
                        data: 'room',
                        name: 'room'
                    },
                    {
                        data: 'lab_id',
                        name: 'lab_id'
                    },
                    {
                        data: 'instructor',
                        name: 'instructor'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#viewSubModal').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('superadmin.get.activeYear') }}',
                    type: 'GET',
                    success: function(data) {
                        let select = $('#school_year_id_for_subject');
                        select.empty();

                        if (data.activeYears.length === 1) {
                            let activeYearId = data.activeYears[0].id;
                            select.append('<option value="' + activeYearId + '" selected>' +
                                data.activeYears[0].code + '</option>');


                            localStorage.setItem('school_year_id_for_subject', activeYearId);

                        } else {
                            select.append(
                                '<option value="" disabled selected>--Select One--</option>'
                            );
                            $.each(data.activeYears, function(index, schoolYear) {
                                select.append('<option value="' + schoolYear.id + '">' +
                                    schoolYear.code + '</option>');
                            });
                        }
                        let allSchoolYearIds = [];
                        $('#school_year_id_for_subject option').each(function() {
                            let value = $(this).val();
                            if (value) {
                                allSchoolYearIds.push(value);
                            }
                        });
                        if (allSchoolYearIds.length > 0) {
                            $.ajax({
                                url: '{{ route('superadmin.get.viewsectionSubjects') }}',
                                type: 'POST',
                                data: {
                                    school_year: allSchoolYearIds,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    localStorage.setItem(
                                        'school_year_id_for_subject', JSON
                                        .stringify(allSchoolYearIds));
                                    $('#add-View-subject').DataTable().ajax
                                        .reload();
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
