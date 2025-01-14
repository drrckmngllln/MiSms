<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Campus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="campus-form">
                @csrf
                @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="code">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" cols="10" rows="10" id="description"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Complete Address</label>
                            <input type="text" class="form-control" name="address" id="address">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="is_active" id="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
        function editUser(id, code, description, address, is_active){
            $("#id").val(id);
            $("#code").val(code);
            $("#description").val(description);
            $("#address").val(address);
            $("#is_active").val(is_active);
            $("#campus-form").attr('action', location.href + '/' + id);
        }
    </script>
@endpush