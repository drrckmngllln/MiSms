<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="form_subject">
                @csrf
                @method('PUT')
                    <div class="modal-body row">
                       
                        <input type="hidden" name="id" id="subject_id">
                        <div class="form-group col-md-3 mb-3">
                            <label>Semester</label>
                            <input type="text" class="form-control" name="semester_id" id="semester_id">
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="code">
                        </div>

                        <div class="form-group">
                            <label>Descriptive Tittle</label>
                            <textarea class="form-control" name="descriptive_tittle" cols="5" rows="3" id="descriptive_tittle"></textarea>
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Total Units</label>
                            <input type="number" class="form-control" name="total_units" id="total_units">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Lecture Units</label>
                            <input type="number" class="form-control" name="lecture_units" id="lecture_units">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Lab Units</label>
                            <input type="number" class="form-control" name="lab_units" id="lab_units">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Pre-Requisite</label>
                            <input type="text" class="form-control" name="pre_requisite" id="pre_requisite">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Total Hours/Week</label>
                            <input type="number" class="form-control" name="total_hrs_per_week" id="total_hrs_per_week">
                        </div>
                        
                        <div class="form-group col-md-3 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="is_active" id="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Level</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        function editUser(id, semester_id, code, descriptive_tittle, total_units, lecture_units, lab_units, pre_requisite, total_hrs_per_week, is_active){
            $("#subject_id").val(id);
            $("#semester_id").val(semester_id);
            $("#code").val(code);
            $("#descriptive_tittle").val(descriptive_tittle);
            $("#total_units").val(total_units);
            $("#lecture_units").val(lecture_units);
            $("#lab_units").val(lab_units);
            $("#pre_requisite").val(pre_requisite);
            $("#total_hrs_per_week").val(total_hrs_per_week);
            $("#is_active").val(is_active);
            $("#form_subject").attr('action', location.href + '/' + id);
        }
    </script>
@endpush