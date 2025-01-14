 <!-- Modal content for the above example -->
 <div class="modal fade bs-example-modal-xl" tabindex="-1" id="editSchoolYear" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-md">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myExtraLargeModalLabel">Edit School Year</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="" method="POST" id="edit_form" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                     <input type="hidden" name="id" id="edit_id">
                     <div class="d-flex justify-content-center"></div>

                     <div class="form-group">
                         <label>Code</label>
                         <input type="text" class="form-control" name="code" id="edit_code" required>
                     </div>
                     <div class="form-group">
                         <label>Description</label>
                         <input type="text" class="form-control" name="description" id="edit_description" required>
                     </div>
                     <div class="form-group">
                         <label>From</label>
                         <input type="date" class="form-control" name="from" id="edit_from" required>
                     </div>
                     <div class="form-group">
                         <label>To</label>
                         <input type="date" class="form-control" name="to" id="edit_to" required>
                     </div>
                     <div class="form-group">
                         <label>Semester</label>
                         <input type="text" class="form-control" name="semester" id="edit_semester" required>
                     </div>
                     <div class="form-group">
                         <label for="status" class="form-label">Status</label>
                         <select name="status" id="edit_status_idd" class="form-select id-number"
                             aria-describedby="helpId">
                             <option value="">Select Status</option>
                             <option value="1">Active</option>
                             <option value="0">Deactive</option>
                         </select>
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
 </div><!-- /.modal -->

 @push('scripts')
     <script>
         function editSchoolYear(id, code, description, from, to, semester, status) {
             $('#edit_id').val(id);
             $('#edit_code').val(code);
             $('#edit_description').val(description);
             $('#edit_from').val(from);
             $('#edit_to').val(to);
             $('#edit_semester').val(semester);
             $('#edit_status_idd').val(status);
             $('#edit_form').attr('action', location.href + '/' + id);
         }
     </script>
 @endpush
