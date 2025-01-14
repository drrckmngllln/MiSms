<div id="addviewSubject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content "style="grey">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Add Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <style>
                .draggable {
                    cursor: move;
                }
            </style>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('POST')

                    <div class="row">

                    </div>
                    <table id="add-View-subject" class="table table-striped table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Subject ID</th>
                                <th>Section</th>
                                <th>Semester</th>

                                <th>Descriptive Title</th>

                                <th>Code</th>

                                <th>Instructor</th>

                                <th>Total Units</th>
                                <th>Lecture Units</th>
                                <th>Lab Units</th>
                                <th>Pre Requisite</th>
                                <th>Total Hrs.</th>
                                <th>Time</th>
                                <th>Day</th>
                                <th>Room</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                    style="float: left;">Save</button>
            </div>

            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        function addonStudentSubject2(id, code, descriptive_tittle, total_units, lecture_units, lab_units, pre_requisite,
            total_hrs_per_week, lab_id, curriculum_id, course_id, campus_id, id_number, year_level, semester, section_id,
            department_id, school_year, subject_id) {

            // console.log(idNumberValue);
            var data = {
                subject_id: subject_id,
                code: code,
                descriptive_tittle: descriptive_tittle,
                total_units: total_units,
                lecture_units: lecture_units,
                lab_units: lab_units,
                pre_requisite: pre_requisite,
                total_hrs_per_week: total_hrs_per_week,
                lab_id: lab_id,
                curriculum_id: curriculumValue,
                course_id: courseIDNValue,
                campus_id: campusIDValue,
                year_level: yearlevelValue,
                semester: semesterValue,
                section_id: sectionIDS,
                id_number: idNumberValue,
                school_year: school_yearID,
                department_id: departmentIDS
            };
            // console.log(data);
            $.ajax({
                type: "POST",
                url: "{{ route('superadmin.StudentSubject.store') }}",
                data: data,
                success: function(status) {
                    // setTimeout(() => {
                    //     location.reload();
                    // }, 1500);
                    $('#view-student-subject').DataTable().ajax.reload();
                    toastr.success('Added Successfully!');
                },
                error: function($error) {
                    console.log("Error", error);
                },
            });


            $.ajax({
                url: '{{ route('superadmin.add.StudentSubject', ['subject_id' => '__ID__']) }}'.replace('__ID__',
                    id),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    // id: id,
                    id_number: idNumberValue,
                    campus_id: campusIDValue,
                    year_level: yearlevelValue,
                    semester: semesterValue,
                    course_id: course_id
                },
                success: function(response) {

                },
                error: function(xhr, status, error) {

                }
            });
        }
    </script>
    <script>
        // console.log("testing", curriculumValue);

        $(document).ready(function() {
            let schoolYear = JSON.parse(localStorage.getItem('school_year'));

            if (schoolYear) {

                $("#add-View-subject").DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    destroy: true,
                    ajax: {
                        url: "{{ route('superadmin.get.viewsectionSubjects') }}",
                        type: 'POST',
                        data: function(d) {

                            d.school_year = schoolYear;
                            d._token = '{{ csrf_token() }}';
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching subjects:', error);
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'section',
                            name: 'section'
                        },
                        {
                            data: 'semester_id',
                            name: 'semester_id'
                        },
                        {
                            data: 'descriptive_tittle',
                            name: 'descriptive_tittle'
                        },

                        {
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'instructor_id',
                            name: 'instructor_id'
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
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var isDragging = false;
            var dragStartX, dragStartY;
            var modal = $('#addviewSubject .modal-dialog');

            $('#addviewSubject .modal-header').on('mousedown', function(e) {
                console.log("tesing");
                isDragging = true;
                dragStartX = e.pageX - modal.offset().left;
                dragStartY = e.pageY - modal.offset().top;
                modal.addClass('draggable');
            });
            $(document).on('mousemove', function(e) {
                if (isDragging) {
                    modal.offset({
                        top: e.pageY - dragStartY,
                        left: e.pageX - dragStartX
                    });
                }
            }).on('mouseup', function() {
                isDragging = false;
                modal.removeClass('draggable');
            });
        });
    </script>
@endpush
