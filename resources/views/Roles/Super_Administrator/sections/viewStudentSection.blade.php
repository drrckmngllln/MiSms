<div class="modal fade bs-example-modal-xl" tabindex="-1" id="viewStudentSectionModal" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">


                <div class="modal-header">
                    <div class="d-flex justify-content-end w-500">
                        <h5>Students</h5>
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
                                <input type="hidden" id="section_id_id">

                                <div class="row" id="enrolled_student">
                                    <div class="row">
                                        {{-- //content --}}
                                        <table id="studentSectionTable"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID Number</th>
                                                    <th>Name</th>
                                                    <th>Year Level</th>
                                                    <th>Semester</th>
                                                    <th>Section</th>

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
        function studentSection(id) {
            // Set the section_id
            $('#section_id_id').val(id);
            $("#studentSectionTable").DataTable().destroy();

            $('#studentSectionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('superadmin.get.studentSection') }}',
                    data: function(d) {
                        d.section_id = $('#section_id_id').val();
                    }
                },
                columns: [{
                        data: 'id_number',
                        name: 'id_number'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },

                    {
                        data: 'year_level',
                        name: 'year_level'
                    },
                    {
                        data: 'semester',
                        name: 'semester'
                    },
                    {
                        data: 'section',
                        name: 'section'
                    },

                ]
            });
        }
    </script>
@endpush
