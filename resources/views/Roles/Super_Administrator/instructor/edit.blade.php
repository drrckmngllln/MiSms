<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" id="editModal" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Instructor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="edit_form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="text" name="full_name" id="instructorID" hidden>
                    <div class="form-group">
                        <label>Fullname</label>
                        <input type="text" class="form-control" name="full_name" id="edit_full_name">
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                    style="float: left;">Save</button>
            </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

@push('scripts')
    <script>
        function viewModal(id, full_name) {
            var test = $('#instructorID').val(id);
            $('#edit_full_name').val(full_name);
            $('#edit_form').attr('action', location.href + '/' + id);
            // instructorID = id;
            // console.log(test);
        }
    </script>
@endpush
