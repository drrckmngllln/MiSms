<div class="modal fade bs-example-modal-xl" tabindex="-1" id="viewSubModal" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                </h5>
                <div class="modal-header">
                    <div class="d-flex justify-content-end w-500">

                    </div>
                    <!-- Add other modal header content as needed -->
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

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
                                        <table id="view-student-subject-with-grades"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Subjects</th>
                                                    <th>Grades</th>
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
@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $("#view-student-subject-with-grades").DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '{{ route('superadmin.studentSubjectswithgrade') }}',
                    type: 'GET',
                    data: function(d) {
                        d.id_number = $('#studentss_id_individual2')
                            .val();
                        d.school_year = $('#school_year_individual2').val();
                        d.semester = $('#semesterID_view').val();
                        d.course = $('#course_1').val();
                        d.include_all = $('#selectAll5').is(':checked') ? 1 : 0;
                    }
                },
                columns: [{
                        data: 'descriptive_tittle',
                        name: 'descriptive_tittle',
                    },
                    {
                        data: 'grade',
                        name: 'grade',
                    },

                ],
            });
            $(document).ready(function() {
                $('#studentss_id_individual2, #school_year_individual2, #semesterID_view, #course_1, #selectAll5')
                    .on(
                        'change',
                        function() {
                            table.ajax.reload();
                        });
            });

        });
    </script>
@endpush
