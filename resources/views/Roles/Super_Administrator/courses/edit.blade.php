<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editModal" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Create Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="course-edit">
                @csrf
                @method('PUT')
                <div class="modal-body row">
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" id="code">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" id="description">
                    </div>
                    <div class="form-group">
                        <label for="campus" class="form-label">Campus</label>
                        <select name="campus_id" id="campus_id" class="form-select id-number" aria-describedby="helpId"
                            required>
                            <option value="">Select Campus</option>
                            @foreach ($campus as $cp)
                                <option value="{{ $cp->id }}">{{ $cp->code }}
                                </option>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <select name="department_id" id="department_id_select22" class="form-select id-number"
                            aria-describedby="helpId" required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $dp)
                                <option value="{{ $dp->id }}">{{ $dp->description }}
                                </option>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Max Units</label>
                        <input type="text" class="form-control" name="max_units" id="max_units_id">
                    </div>
                    <div class="form-group">
                        <label>Is Offered</label>
                        <select name="is_offered" id="is_offered" class="form-select id-number"
                            aria-describedby="helpId" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Status</label>
                        <select name="is_active" id="is_active" class="form-select id-number" aria-describedby="helpId"
                            required>
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Campus</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        function editCourses(id, code, description, campus_id, department_id, max_units, is_offered, is_active) {
            // console.log(max_units);
            $("#edit_id").val(id);
            $("#code").val(code);
            $("#description").val(description);
            $("#campus_id").val(campus_id);
            // $("#department_id").val(department_id);
            department_id_select2_edit.val(department_id).trigger('change.select2');
            $("#max_units_id").val(max_units);
            $("#is_offered").val(is_offered);
            $("#is_active").val(is_active);
            $("#course-edit").attr('action', location.href + '/' + id);
        }
    </script>
    <script>
        let department_id_select2_edit;
        $(document).ready(function() {
            department_id_select2_edit = $('#department_id_select22').select2({
                dropdownParent: $('#editModal'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
