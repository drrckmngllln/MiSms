<div class="modal fade bs-example-modal-xl" id="editCurriculumSubject" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Curriculum Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit-Curriculum-Subjects">
                @csrf
                @method('PUT')
                <div class="modal-body row">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Semester</label>
                            <input type="text" name="semester_id" id="edit_semester" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Year Level</label>
                            <input type="text" name="year_level" id="edit_year_level" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Code</label>
                            <input type="text" name="code" id="edit_code" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Description</label>
                            <input type="text" name="descriptive_tittle" id="edit_descriptive_tittle"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Total Units</label>
                            <input type="text" name="total_units" id="edit_total_units" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Lecture Units</label>
                            <input type="text" name="lecture_units" id="edit_lecture_units" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Lab Units</label>
                            <input type="text" name="lab_units" id="edit_lab_units" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Pre Requisite</label>
                            <input type="text" name="pre_requisite" id="edit_pre_requisite" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Total Hours</label>
                            <input type="text" name="total_hrs_per_week" id="edit_total_hrs_per_week"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
    <script>
        function editCurriculumSubject(id, year_level, semester_id, code, descriptive_tittle, total_units, lecture_units,
            lab_units, pre_requisite, total_hrs_per_week) {
            // console.log(id);
            $('#edit_id').val(id);
            $('#edit_year_level').val(year_level);
            $('#edit_semester').val(semester_id);
            $('#edit_code').val(code);
            $('#edit_descriptive_tittle').val(descriptive_tittle);
            $('#edit_total_units').val(total_units);
            $('#edit_lecture_units').val(lecture_units);
            $('#edit_lab_units').val(lab_units);
            $('#edit_pre_requisite').val(pre_requisite);
            $('#edit_total_hrs_per_week').val(total_hrs_per_week);



            $("#edit-Curriculum-Subjects").submit(function(event) {
                event.preventDefault();
                var id = $('#edit_id').val();
                var url = "{{ route('superadmin.update.CurriculumSubject') }}";
                if (id) {
                    url += "/" + id;
                }
                $.ajax({
                    url: url,
                    method: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message);
                        // Close the modal
                        $("#editCurriculumSubject").modal('hide');
                        $('#curriculumSubject').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        // Handle any errors
                        console.error(error);
                    }
                });
            });
        }
    </script>
@endpush
