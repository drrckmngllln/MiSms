<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->
    </div>
    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" id="showsubject" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Section Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- <button type="button" class="btn btn-secondary waves-effect waves-light mb-2 OpenViewModal">
                        <i class="ri-add-line" id="addSubjectBtn"></i> Add Subjects
                    </button> --}}
                    <!-- Navigation Tabs -->
                    <!-- Form -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data"
                                    id="Enrolled_Students">
                                    @csrf
                                    @method('POST')
                                    <input type="text" name="section_id" id="section_id_show_subject" hidden>
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label for="id_number" class="form-label">Section Code</label>
                                            <input type="text" name="section_code" id="section_subject_id"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>School Year</label>
                                            <select name="school_year" id="school_year_id_show_subject"
                                                class="form-select" required>
                                                <option value="" disabled selected>--Select One--</option>
                                            </select>

                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Course</label>
                                            <select class="form-control" name="course_id" id="view_course_id" disabled>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label>Campus</label>
                                            <select class="form-control" name="campus_id" id="campus_id_id" required>
                                                <option value="">Select Campus</option>
                                                @foreach ($campus as $cm)
                                                    <option value="{{ $cm->id }}">{{ $cm->code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <label for="id_number" class="form-label">Year Level</label>
                                            <input type="text" name="year_level" id="view_year_level"
                                                class="form-control" placeholder="" aria-describedby="helpId" readonly>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            {{-- <label>Curriculum</label>
                                            <select class="form-control" name="curriculum_id" id="curriculum_id">
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($curriculums as $curriculum)
                                                    <option value="{{ $curriculum->id }}">{{ $curriculum->code }}
                                                    </option>
                                                @endforeach
                                            </select> --}}

                                            {{-- <label>Curriculum</label>
                                            <select name="curriculum_id" id="curriculum_id"
                                                class="form-select id-number" aria-describedby="helpId" required>
                                                <option value="">Select Curriculum</option>
                                                @foreach ($curriculums as $curriculum)
                                                    <option value="{{ $curriculum->id }}">{{ $curriculum->code }}
                                                    </option>
                                                @endforeach
                                            </select> --}}

                                            <label for="course" class="form-label">Curriculum</label>
                                            <select name="curriculum_id" id="curriculum_id"
                                                class="form-select id-number" aria-describedby="helpId" required
                                                onchange="confirmCurriculumSelection(this)">
                                                <option value="">Select Curriculum</option>
                                                @foreach ($curriculums as $curriculum)
                                                    <option value="{{ $curriculum->id }}"
                                                        data-code="{{ $curriculum->code }}">{{ $curriculum->code }}
                                                    </option>
                                                @endforeach
                                            </select>




                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="id_number" class="form-label">Semester</label>
                                            <select name="semester_id" id="sem_id" class="form-select id-number"
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <button type="button" id="addSubject"
                            class="btn btn-secondary waves-effect waves-light mb-2 OpenModal4">
                            <i class="ri-add-line"></i> Add Subjects
                        </button>
                        <table id="section-curruculum" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Subject ID</th>
                                    {{-- <th>Semester</th> --}}
                                    {{-- <th>Year Level</th> --}}
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Total Units</th>
                                    <th>Lecture Units</th>
                                    <th>Lab Units</th>
                                    <th>Pre Requisite</th>
                                    <th>Total Hours</th>
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
        function ShowSCR(id, section_code, course_id, year_level) {

            $('#section_id_show_subject').val(id);
            $('#section_subject_id').val(section_code);
            $('#view_course_id').val(course_id);
            $('#view_year_level').val(year_level);
            $('#curriculum_id').val('');
            $('#sem_id').val('');

            var table = $("#section-curruculum").DataTable();
            table.clear();
            // console.log(course_id);
        }
    </script>
    <script>
        let addModal = new bootstrap.Modal(document.getElementById('adddetails'))
        let editModal = new bootstrap.Modal(document.getElementById('editadddetails'));
        let viewModal = new bootstrap.Modal(document.getElementById('view'));
        let addSubjects = new bootstrap.Modal(document.getElementById('addsubject'));

        $(document).ready(function() {
            setInterval(() => {
                $('.OpenModal').off('click');
                $(".OpenModal").click((event) => {
                    OpenModal();
                    event.stopPropagation();
                })
                $('.OpenModal2').off('click');
                $(".OpenModal2").click((event) => {
                    OpenModal2();
                    event.stopPropagation();
                })
                $('.OpenModal3').off('click');
                $(".OpenModal3").click((event) => {
                    OpenModal3();
                    event.stopPropagation();
                })
                $('.OpenModal4').off('click');
                $(".OpenModal4").click((event) => {
                    OpenModal4();
                    event.stopPropagation();
                })
            }, 500);
        });
        //datatables
        $('#sem_id').on('change', async function(event) {
            if (!$('#campus_id_id').val()) {
                toastr.warning('Select Campus.');
                $('#campus_id_id').focus();
                return;
            }

            const selectedOption = event.target.options[event.target.selectedIndex];
            const semester_id = event.target.value;
            const semesterText = selectedOption.text; // Kunin ang text ng napiling semester
            const curriculum_id = $("#curriculum_id").val();
            const view_year_level = $("#view_year_level").val();
            const section_code = $('#section_subject_id').val();
            const course_id = $('#view_course_id').val();
            const school_year = $('#school_year_id_show_subject').val();
            const section_id = $('#section_id_show_subject').val();
            const campus_id = $('#campus_id_id').val();

            if (!semester_id) {
                return; // Walang napiling semester
            }

            const confirmation = await Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to save the semester: ${semesterText}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            });

            if (!confirmation.isConfirmed) {

                $(this).val('');
                return;
            }


            await new Promise((resolve, reject) => {
                const allData = {
                    curriculum_id,
                    semester_id,
                    year_level: view_year_level,
                    section_code,
                    course_id,
                    section_id,
                    school_year,
                    campus_id,
                };

                $.ajax({
                    url: '{{ route('superadmin.save.sectionSubject') }}',
                    type: 'POST',
                    data: allData,
                    success: function(response) {
                        resolve();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        reject();
                    },
                });
            });

            const url = location.origin + '/superadmin/getSectionSubject/' + section_code + '/' +
                view_year_level + '/' + semester_id + '/' + school_year;

            const requestData = {
                section_code: section_code,
                section_id: section_id,
            };


            $("#section-curruculum").DataTable().destroy();


            $("#section-curruculum").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: url,
                    data: requestData,
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
                        data: 'instructor',
                        name: 'instructor'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                drawCallback: () => {
                    $(".OpenModal").click((event) => {
                        OpenModal();
                        event.stopPropagation();
                    });
                    $(".OpenModal2").click((event) => {
                        OpenModal2();
                        event.stopPropagation();
                    });
                    $(".OpenModal3").click((event) => {
                        OpenModal3();
                        event.stopPropagation();
                    });
                    $(".OpenModal4").click((event) => {
                        OpenModal4();
                        event.stopPropagation();
                    });
                },
            });


            $('#section-curruculum').on('click', '.delete-row', function() {
                var tr = $(this).closest('tr');
                dt.row(tr).remove().draw();
            });
        });
    </script>
    <script>
        //same with this
        $('#showsubject').on('shown.bs.modal', function() {
            $('#adddetails').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#editadddetails').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#view').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#addsubject').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        function OpenModal() {
            addModal.show();
        }

        function OpenModal2() {
            // editModal.show() {
            //     $('#editadddetails').modal('show');
            // }
            editModal.show();
        }

        function OpenModal3() {
            viewModal.show();
        }

        function OpenModal4() {
            addSubjects.show();
        }
    </script>

    <script>
        //curriculum by semester
        $(document).ready(function() {
            $('#curriculum_id').on('change', function(event) {
                // console.log('testing');
                const semester_id = event.target.value;

                $.ajax({
                    url: location.origin + '/superadmin/curriculum/curriculum_semester/' +
                        semester_id,
                    method: 'GET',
                    success: function(semester_id) {
                        const sem_id = new Set(semester_id.map(curr => curr.semester_id));
                        const select_curr = $('#sem_id');
                        select_curr.empty();
                        select_curr.append($("<option>").text("--Available Semester--").val(
                            '').attr('selected', true).attr('disabled', true));

                        for (const semesterId of sem_id) {
                            const newOption = $("<option>").text(semesterId).val(semesterId);
                            select_curr.append(newOption);
                        }
                        if (sem_id.size > 0) {
                            const firstSemester = Array.from(sem_id)[0];
                            localStorage.setItem('selectedSemester',
                                firstSemester);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#showsubject').on('hidden.bs.modal', function() {
                location.reload();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#showsubject').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('superadmin.get.activeYear') }}',
                    type: 'GET',
                    success: function(data) {
                        let select = $('#school_year_id_show_subject');
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#curriculum_id').select2({
                dropdownParent: $('#showsubject'),
                dropdownAutoWidth: true
            });
        });
    </script>
    <script>
        function confirmCurriculumSelection(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const curriculumCode = selectedOption.getAttribute('data-code');

            if (curriculumCode) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Is this the curriculum of this course? (${curriculumCode}), check carefully before select semester`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (!result.isConfirmed) {

                        selectElement.value = '';
                    }
                });
            }
        }
    </script>
@endpush
