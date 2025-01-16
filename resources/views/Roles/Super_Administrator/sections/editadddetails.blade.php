<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" id="editadddetails" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background-color: rgb(206, 199, 199);">
            <div class="modal-header" style="">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Edit details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit_form_sections">
                @csrf
                @method('PUT')
                <input type="hidden" name="subject_id" id="detailsofsubject_id">

                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body row">
                    <div class="form-group">
                        <label>Section Code</label>
                        <select class="form-control" name="section_id" id="edit_section_idd">
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_code }}
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Time</label>
                        <input type="text" class="form-control" name="time" id="edit_clear_time">
                    </div>
                    <div class="form-group">
                        <label>Day</label>
                        <input type="text" class="form-control" name="day" id="edit_clear_day">
                    </div>
                    <div class="form-group">
                        <label>Room</label>
                        <input type="text" class="form-control" name="room" id="edit_clear_room">
                    </div>
                    <div class="form-group">
                        <label for="course" class="form-label">Instrutor</label>
                        <select name="instructor_id" id="edit_discount_id_select2" class="form-select id-number"
                            aria-describedby="helpId">
                            <option value="">Select Instructor</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->full_name }} /
                                </option>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label>email</label>
                        <input type="text" class="form-control" name="email" id="edit_clear_email">
                    </div> --}}
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
        function hasActionedit(id, time, section_id, day, room, instructor_id, subject_id, sectionSub) {
            console.log(time);
            currentEditId = id;
            // console.log(currentEditId);
            $('#edit_id').val(id);
            $('#edit_section_idd').val(section_id);
            $('#edit_clear_time').val(time);
            $('#edit_clear_day').val(day);
            $('#edit_clear_room').val(room);
            // $('#edit_clear_instructor_id').val(instructor_id);
            instructors_select_edit.val(instructor_id).trigger('change.select2');


            $("#edit_form_sections").submit(function(event) {
                event.preventDefault();
                var id = $('#edit_id').val();
                var url = "{{ route('superadmin.update.details') }}";
                if (id) {
                    url += "/" + id;
                }

                $.ajax({
                    url: url,
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message);
                        $("#section-curruculum").DataTable().ajax.reload();

                        // Close the modal
                        $("#editadddetails").modal('hide');
                    },
                    error: function(error) {
                        // Handle any errors
                        console.error(error);
                    }
                });
            });
        }
    </script>
    <script>
        //update ui   
        let instructors_select_edit;
        $(document).ready(function() {
            instructors_select_edit = $('#edit_discount_id_select2').select2({
                dropdownParent: $('#editadddetails'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
