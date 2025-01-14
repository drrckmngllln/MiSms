<!--  Modal content for the above example -->
<div id="addSubject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
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
                    <table id="add-subject" class="table table-striped table-bordered"
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
                                <th>Laboratory</th>
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
        // console.log("testing", curriculumValue);

        $(document).ready(function() {
            // Retrieve school_year from localStorage
            let schoolYear = JSON.parse(localStorage.getItem('school_year'));

            if (schoolYear) {
                // Initialize DataTable
                $("#add-subject").DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    destroy: true,
                    ajax: {
                        url: "{{ route('superadmin.get.sectionSubjects') }}",
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
                            data: 'subject_id',
                            name: 'subject_id'
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
                            data: 'instructor',
                            name: 'instructor'
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
        var curriculumSubjectDataTable;

        function addSubject2(subject_id, code, descriptive_tittle, total_units, lecture_units, lab_units, pre_requisite,
            total_hrs_per_week, time, day, room, lab_id, instructor_id) {
            console.log(subject_id);
            const dt = $("#section-subject").DataTable();

            // const timeDuplicate = dt.rows().data().toArray().some(row => row.time === time && row.day === day);

            // if (timeDuplicate) {
            //     toastr.error("Schedule already exists: " + time + ' on day ' + day);
            //     return;
            // }
            // const dayDuplicate = dt.rows().data().toArray().some(row => row.day === day);

            // if (dayDuplicate) {
            //     toastr.error("Schedule for day " + day + " already exists.");
            //     return;
            // }
            // const isDuplicate = dt.rows().data().toArray().some(row => row.code === code);

            const newRow = {
                subject_id: subject_id,
                code: code,
                descriptive_tittle: descriptive_tittle,
                total_units: total_units,
                lab_id: lab_id,
                time: time,
                day: day,
                room: room,
                total_hrs_per_week: total_hrs_per_week,
                lecture_units: lecture_units,
                lab_units: lab_units,
                pre_requisite: pre_requisite,
                instructor_id: instructor_id
            };
            dt.off('draw');
            dt.row.add(newRow).draw(false);

            toastr.success("Subject added successfully:" + descriptive_tittle)
        }
    </script>
    <script>
        $(document).ready(function() {
            var isDragging = false;
            var dragStartX, dragStartY;
            var modal = $('#addSubject .modal-dialog');

            $('#addSubject .modal-header').on('mousedown', function(e) {
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
