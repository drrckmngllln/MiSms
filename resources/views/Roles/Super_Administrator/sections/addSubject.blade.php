<!--  Modal content for the above example -->
<div id="addsubject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
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
                                <th>Curriculum</th>
                                <th>Code</th>
                                <th>Descriptive Title</th>
                                <th>Total Units</th>
                                <th>Lecture Units</th>
                                <th>Semester</th>
                                <th>Year Level</th>
                                <th>Lab Units</th>
                                <th>Pre Requisite</th>
                                <th>Total Hours</th>

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
                    data: 'curriculum',
                    name: 'curriculum'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'descriptive_tittle',
                    name: 'descriptive_title'
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
                    data: 'semester_id',
                    name: 'semester_id'
                },
                {
                    data: 'year_level',
                    name: 'year_level'
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
                    data: 'action',
                    name: 'action'
                },
            ],

        });
    </script>
    <script>
        var curriculumSubjectDataTable;

        function addSubject(id, code, descriptive_tittle, total_units, lecture_units, lab_units, pre_requisite,
            total_hrs_per_week) {

            const semester_id = $("#sem_id").val();
            const curriculum_id = $("#curriculum_id").val();
            const view_year_level = $("#view_year_level").val();
            const section_code = $('#section_subject_id').val();
            const course_id = $('#view_course_id').val();


            const newRow = {
                section_code,
                course_id,
                year_level: view_year_level,
                curriculum_id,
                semester_id,
                subject_id: id,
                code,
                descriptive_tittle,
                total_units,
                lecture_units,
                lab_units,
                pre_requisite,
                total_hrs_per_week,
            };


            $.ajax({
                url: '{{ route('superadmin.save.addSectionSubject') }}',
                type: 'POST',
                data: newRow,
                success: function(response) {
                    // Handle the response
                    toastr.success(response.success);
                    if (response.error) {
                        toastr.error(response.error);
                        return;
                    }
                    $("#section-curruculum").DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Handle the error
                }
            });
        }
    </script>
@endpush
