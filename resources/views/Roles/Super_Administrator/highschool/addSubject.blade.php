<!--  Modal content for the above example -->
<div id="addSubject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content "style="grey">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Add Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                                <th>Code</th>
                                <th>Descriptive Title</th>
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

        $("#add-subject").DataTable().destroy();
        $("#add-subject").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('superadmin.create_account.create') }}",

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
                    data: 'action',
                    name: 'action'
                },
            ],

        });
    </script>
    <script>
        var curriculumSubjectDataTable;

        function addSubject(subject_id, code, descriptive_tittle, total_units, lab_id, time, day, room) {

            const dt = $("#section-subjects").DataTable();

            const timeDuplicate = dt.rows().data().toArray().some(row => row.time === time && row.day === day)
            if (timeDuplicate) {
                toastr.error("Schedule already exist:" + time + 'on day' + day);
                return;
            }

            const isDuplicate = dt.rows().data().toArray().some(row => row.code === code);
            // console.log('Values:', values);
            const newRow = {
                subject_id: subject_id,
                code: code,
                descriptive_tittle: descriptive_tittle,
                total_units: total_units,
                lab_id: lab_id,
                time: time,
                day: day,
                room: room,
                // ... other properties
            };
            console.log(newRow);

            dt.off('draw');
            dt.row.add(newRow).draw(false);

            toastr.success("Subject added successfully:" + descriptive_tittle)
        }
    </script>
@endpush
