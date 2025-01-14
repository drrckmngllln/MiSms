<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Curriculum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" method="POST" id="edit_form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body row">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="code">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" cols="20" rows="3" id="description"></textarea>

                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>Campus</label>
                            <select class="form-control" name="campus_id" id="campus_id">
                                @foreach ($campus as $campus)
                                    <option {{ $campus->id == 1 ? 'selected' : '' }} value="{{ $campus->id }}">
                                        {{ $campus->description }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Course</label>
                            <select name="course_id" id="course_id_select22" class="form-select id-number"
                                aria-describedby="helpId" required>
                                <option value="">Select Course</option>
                                @foreach ($course as $cp)
                                    <option value="{{ $cp->id }}">{{ $cp->description }}
                                    </option>
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Effective</label>
                            <input type="date" class="form-control" name="effective" id="effective">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Expires</label>
                            <input type="date" class="form-control" name="expires" id="expires">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Status</label>
                            {{-- <input type="text" name="" id="status"> --}}
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Curriculum</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


@push('scripts')
    <script>
        function editCurriculum(id, code, description, campus_id, course_id, effective, expires, status) {
            $("#id").val(id);
            $("#code").val(code);
            $("#description").val(description);
            $("#campus_id").val(campus_id);
            // $("#course_id").val(course_id);
            course_id_select2_edit.val(course_id).trigger('change.select2');
            $("#effective").val(effective);
            $("#expires").val(expires);
            $("#status").val(status);
            $("#edit_form").attr('action', location.href + '/' + id);
        }
    </script>
    <script>
        let course_id_select2_edit;
        $(document).ready(function() {
            course_id_select2_edit = $('#course_id_select22').select2({
                dropdownParent: $('#editModal'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
