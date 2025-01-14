<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Create Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.subjects.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row">
                        <div class="form-group col-md-3 mb-3">
                            <label>Semester</label>
                            <input type="text" name="semester_id" id="">
                            {{-- <select name="semester_id" id="" class="form-control">
                                <option value="{{ $semester->id }}">{{ $semester->description }}</option>
                            </select> --}}
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                        </div>
                        <div class="form-group">
                            <label>Descriptive Tittle</label>
                            <textarea class="form-control" name="descriptive_tittle" cols="5" rows="3">{{ old('descriptive_tittle') }}</textarea>
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Total Units</label>
                            <input type="number" class="form-control" name="total_units"
                                value="{{ old('total_units') }}">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Lecture Units</label>
                            <input type="number" class="form-control" name="lecture_units"
                                value="{{ old('lecture_units') }}">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Lab Units</label>
                            <input type="number" class="form-control" name="lab_units" value="{{ old('lab_units') }}">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Pre-Requisite</label>
                            <input type="text" class="form-control" name="pre_requisite"
                                value="{{ old('pre_requisite') }}">
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label>Total Hours/Week</label>
                            <input type="number" class="form-control" name="total_hrs_per_week"
                                value="{{ old('total_hrs_per_week') }}">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Subjects</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
