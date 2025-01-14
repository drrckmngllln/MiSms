<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content for the outer div -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" method="POST" id="edit_form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="edit_code">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" cols="10" rows="8" id="edit_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="is_active" id="edit_is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Level</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


@push('scripts')
    <script>
        function editUser(id, code, description, is_active){
            $("#edit_id").val(id);
            $("#edit_code").val(code);
            $("#edit_description").val(description);
            $("#edit_is_active").val(is_active);
            $("#edit_form").attr('action', location.href + '/' + id);
        }
    </script>
@endpush