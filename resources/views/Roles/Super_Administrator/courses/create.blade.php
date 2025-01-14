<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content for the outer div -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="createCourse" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="">
                <div class="modal-header" style="">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Create Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="course-editt">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="subject_id" id="course-editt">
                    <div class="modal-body row">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="clear_code"
                                placeholder="Ex. BSN">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" id="clear_description">
                        </div>
                        <div class="form-group">
                            <label for="campus" class="form-label">Campus</label>
                            <select name="campus_id" id="campus_id_select2" class="form-select id-number"
                                aria-describedby="helpId" required>
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
                            <select name="department_id" id="department_id_select2" class="form-select id-number"
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
                            <input type="text" class="form-control" name="max_units" id="clear_max_units">
                        </div>
                        <div class="form-group">
                            <label>Is Offered</label>
                            <select name="is_offered" id="is_offered_select2" class="form-select id-number"
                                aria-describedby="helpId" required>
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Status</label>
                            <select name="is_active" id="is_active_select2" class="form-select id-number"
                                aria-describedby="helpId" required>
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit_id" class="btn btn-primary">Save Level</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#department_id_select2').select2({
                dropdownParent: $('#createCourse'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
