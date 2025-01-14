 <!-- Modal content for the above example -->
 <div class="modal fade bs-example-modal-xl" tabindex="-1" id="editOtherFee" role="dialog"
     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-md">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Tuition Fees</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="" method="POST" id="edit_form" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                     <input type="hidden" name="id" id="edit_id">
                     <div class="form-group">
                         <label>Category</label>
                         <input type="text" class="form-control" name="category" id="category" value="Other Fees"
                             readonly>
                     </div>
                     <div class="form-group">
                         <label>Description:</label>
                         <input type="text" class="form-control" name="description" id="edit_description" required>
                     </div>
                     <div class="form-group">
                         <label>Semester:</label>
                         <input type="text" class="form-control" name="semester" id="edit_semester" required>
                     </div>
                     <div class="form-group">
                         <div class="form-group">
                             <label>Campus</label>
                             <select class="form-control" name="campus_id" id="edit_campus_id">
                                 <option value="">Select Campus</option>
                                 @foreach ($campus as $cp)
                                     <option value="{{ $cp->id }}">{{ $cp->code }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="course" class="form-label">Course</label>
                         <select name="course_id" id="edit_course_id_select2" class="form-select id-number"
                             aria-describedby="helpId" required>
                             <option value="">Select Course</option>
                             @foreach ($course as $cs)
                                 <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                             @endforeach
                         </select>
                     </div>
                     <div class="form-group">
                         <label>1st Year</label>
                         <input type="text" class="form-control" name="first_year" id="edit_first_year" required>
                     </div>
                     <div class="form-group">
                         <label>2nd Year</label>
                         <input type="text" class="form-control" name="second_year" id="edit_second_year" required>
                     </div>
                     <div class="form-group">
                         <label>3rd Year</label>
                         <input type="text" class="form-control" name="third_year" id="edit_third_year" required>
                     </div>
                     <div class="form-group">
                         <label>4th Year</label>
                         <input type="text" class="form-control" name="fourth_year" id="edit_fourth_year" required>
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
         function editOtherFee(id, category, description, campus_id, first_year, second_year, third_year, fourth_year,
             semester, course_id) {
             $('#edit_id').val(id);
             $('#edit_description').val(description);
             $('#edit_campus_id').val(campus_id);
             $('#edit_first_year').val(first_year);
             $('#edit_second_year').val(second_year);
             $('#edit_third_year').val(third_year);
             $('#edit_fourth_year').val(fourth_year);
             $('#edit_semester').val(semester);
             course_select_edit.val(course_id).trigger('change.select2')
             $('#edit_form').attr('action', location.href + '/' + id);
         }
     </script>
     <script>
         let course_select_edit;
         $(document).ready(function() {
             course_select_edit = $('#edit_course_id_select2').select2({
                 dropdownParent: $('#editOtherFee'),
                 dropdownAutoWidth: true
             });
         });
     </script>
 @endpush
