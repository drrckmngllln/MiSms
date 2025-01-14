<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->


        <!-- Modal content for the above example -->
        <div class="modal fade bs-example-modal-xl" tabindex="-1" id="editModal" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Level</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="form-sections">
                        @csrf
                        @method('PUT')
                        <div class="modal-body row">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Section Code</label>
                                <input type="text" class="form-control" name="section_code" id="section_code">
                            </div>
                            <div class="form-group">
                                <label>Course</label>
                                <select class="form-control" name="course_id" id="courseSelectt">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            data-department-id="{{ $course->department_id }}">
                                            {{ $course->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Department Description</label>
                                <select class="form-control" name="department_id" id="departmentSelecttt" readonly>
                                    <option value="">Select Department</option>

                                    @foreach ($department as $dp)
                                        <option value="{{ $dp->id }}">{{ $dp->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <input type="number" class="form-control" name="semester" id="semester_id" readonly>
                            </div>
                            <div class="form-group">
                                <label>Year Level</label>
                                <input type="number" class="form-control" name="year_level" id="id_level_yeal">
                            </div>

                            <div class="form-group">
                                <label>Number of Students</label>
                                <input type="number" class="form-control" name="number_of_students"
                                    id="number_of_students">
                            </div>

                            <div class="form-group">
                                <label>Maximum Number of Students</label>
                                <input type="number" class="form-control" name="max_number_of_students"
                                    id="max_number_of_students">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1">Available</option>
                                    <option value="0">Full</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Remarks</label>
                                <select class="form-control" name="remarks" id="remarks_idd">
                                    <option value="regular">Regular</option>
                                    <option value="irregular">Irregular</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Level</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
@push('scripts')
    <script>
        let course_id_select2_edit;

        function editSection(id, section_code, course_id, number_of_students, max_number_of_students, status, year_level,
            remarks, department_id, semester) {

            $("#id").val(id);
            $("#section_code").val(section_code);
            course_id_select2_edit.val(course_id).trigger('change');
            $('#id_level_yeal').val(year_level);
            $("#number_of_students").val(number_of_students);
            $("#max_number_of_students").val(max_number_of_students);
            $("#status").val(status);
            $("#remarks_idd").val(remarks);
            $("#semester_id").val(semester);

            // We don't need to set department_id here, it will be set automatically
            $("#form-sections").attr('action', location.href + '/' + id);
        }

        $(document).ready(function() {
            course_id_select2_edit = $('#courseSelectt').select2({
                dropdownParent: $('#editModal'),
                dropdownAutoWidth: true
            });

            course_id_select2_edit.on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var departmentId = selectedOption.data('department-id');
                $('#departmentSelecttt').val(departmentId).trigger('change');
            });

            $('#departmentSelecttt').select2({
                dropdownParent: $('#editModal'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
