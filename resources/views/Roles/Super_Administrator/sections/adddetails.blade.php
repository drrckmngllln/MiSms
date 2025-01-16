<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content for the outer div -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="adddetails" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="background-color: rgb(206, 199, 199);">
                <div class="modal-header" style="">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="form_SubjectSection">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="subject_id" id="detailsofsubject_id">
                    <input type="hidden" name="adddetails_id" id="adddetails_id">
                    <input type="hidden" name="sectionsub_id" id="section_sub_id">



                    <div class="modal-body row">
                        <div class="form-group">
                            <label>Section Code</label>
                            <select class="form-control" name="section_id" id="section_idd" required>
                                <option value="">Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_code }}
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" class="form-control" name="semester" id="semester_id_add_details">
                        </div>
                        <div class="form-group">
                            <label>Time</label>
                            <input type="text" class="form-control" name="time" id="clear_time">
                        </div>
                        <div class="form-group">
                            <label>Day</label>
                            <input type="text" class="form-control" name="day" id="clear_day">
                        </div>
                        <div class="form-group">
                            <label>Room</label>
                            <input type="text" class="form-control" name="room" id="clear_room">
                        </div>
                        <div class="form-group">
                            <label>Subject ID</label>
                            <input type="text" class="form-control" name="subject_id" id="subject_iddddd"
                                placeholder="Copy the Subject ID on Table Ex.231" readonly>
                        </div>
                        <div class="form-group">
                            <label>School Year</label>
                            <select name="school_year" id="school_year_id_add_details" class="form-select" required>
                                <option value="" disabled selected>--Select One--</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>Curriculum</label>
                            <select class="form-control" name="instructor_id" id="clear_instructor_id">
                                <option value="">Select Instructor</option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->full_name }} /
                                    </option>
                                    </option>
                                @endforeach
                            </select> --}}

                        <div class="form-group">
                            <label for="course" class="form-label">Instrutor</label>
                            <select name="instructor_id" id="discount_id_select2" class="form-select id-number"
                                aria-describedby="helpId" required>
                                <option value="">Select Instructor</option>
                                <option value="TBA">TBA</option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->full_name }} /
                                    </option>
                                    </option>
                                @endforeach
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
        function hasAction(id, time, room, day, instructor_id, section_code, subject_id, adddetails_id, secid) {
            // console.log(secid);

            $('#detailsofsubject_id').val(id);
            $('#clear_time').val(time);
            $('#clear_day').val(day);
            $('#clear_room').val(room);
            $('#subject_iddd').val(id);
            instructorEdit.val(instructor_id).trigger('change.select2');
            $('#section_idd').val(section_code).trigger('change');
            $('#subject_iddddd').val(subject_id);
            $('#adddetails_id').val(adddetails_id);
            $('#section_sub_id').val(secid);

        }
    </script>
    <script>
        let instructorEdit;
        $(document).ready(function() {
            instructorEdit = $('#discount_id_select2').select2({
                dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
    </script>

    <script>
        $("#form_SubjectSection").submit(function(event) {
            event.preventDefault();
            var id = $('#detailsofsubject_id').val();
            var formData = $(this).serialize();
            var time = $('#clear_time').val();
            var day = $('#clear_day').val();
            var room = $('#clear_room').val();
            var instructor_id = $('#discount_id_select2').val();
            var section_id = $('#section_idd').val();
            var subjectID = $('#subject_iddddd').val();
            var semester = $('#semester_id_add_details').val();
            var school_year = $('#school_year_id_add_details').val();
            var sectionSub_id = $('#section_sub_id').val();


            $.ajax({
                url: '/superadmin/add-details/' + id,
                method: "POST",
                data: {
                    subject_id: subjectID,
                    time: time,
                    day: day,
                    room: room,
                    instructor_id: instructor_id,
                    section_id: section_id,
                    semester: semester,
                    school_year: school_year,
                    sectionSub_id: sectionSub_id
                },
                success: function(response) {
                    toastr.success(response.message);
                    // Update the data table with the new data
                    $("#section-curruculum").DataTable().ajax.reload();
                    $('#clear_time').val('');
                    $('#clear_day').val('');
                    $('#clear_room').val('');
                    // $('#discount_id_select2').val('');

                    // // Close the modal
                    $("#adddetails").modal('hide');
                },
                error: function(error) {
                    // Handle any errors
                    console.error(error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#adddetails').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('superadmin.get.activeYear') }}',
                    type: 'GET',
                    success: function(data) {
                        let select = $('#school_year_id_add_details');
                        select.empty();
                        if (data.activeYears.length === 1) {
                            select.append('<option value="' + data.activeYears[0].id +
                                '" selected>' + data.activeYears[0].code + '</option>');
                        } else {
                            select.append(
                                '<option value="" disabled selected>--Select One--</option>'
                            );

                            $.each(data.activeYears, function(index, schoolYear) {
                                select.append('<option value="' + schoolYear.id + '">' +
                                    schoolYear.code + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching school years:', error);
                    }
                });
            });
        });
    </script>
@endpush
