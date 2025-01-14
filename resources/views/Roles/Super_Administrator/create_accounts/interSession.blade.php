<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" id="interSession" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Select Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="status_save_intersession" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_idddd">
                    <div class="row">
                        <label for="occupation" class="form-label">Status</label>
                        <select name="course_id" id="course_id_select2" class="form-select id-number"
                            aria-describedby="helpId" required>
                            <option value="">Select Status</option>
                            <option value="PENDING">PENDING FOR CURRICULUM APPROVAL</option>
                            <option value="FOR ENROLLMENT">FOR ENROLLMENT</option>
                            <option value="INTERSESSION">INTERSESSION</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                            style="float: left;" name="submitType" value="curriculum">Approve</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('scripts')
    <script>
        function Intersession(id) {
            $('#edit_idddd').val(id);
            var form = $('#status_save_intersession');
            var route = "{{ route('superadmin.studentapp.changeStatusIntersession', ['id' => ':id']) }}";
            route = route.replace(':id', id);
            form.attr('action', route);
        }
    </script>
@endpush
