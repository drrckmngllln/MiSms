<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="createCurriculum">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Create Curriculum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.curriculum.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row">

                        <div class="form-group col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" cols="20" rows="3" id="create_description"></textarea>

                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Campus</label>

                            <select class="form-control" name="campus_id" id="campus_id">
                                @foreach ($campus as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->description }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="department" class="form-label">Course</label>
                            <select name="course_id" id="course_id_select2" class="form-select id-number"
                                aria-describedby="helpId" required>
                                <option value="">Select Course</option>
                                @foreach ($course as $cp)
                                    <option value="{{ $cp->id }}">{{ $cp->description }}
                                    </option>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group col-md-6 mb-3">
                            <label>Section</label>
                            <select class="form-control" name="section_code_id">
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_code }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group col-md-6 mb-3">
                            <label>Effective</label>
                            <input type="date" class="form-control" name="effective" id="create_effective">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Expires</label>
                            <input type="date" class="form-control" name="expires" id="create_expires">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="status" id="create_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Curriculum</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#course_id_select2').select2({
                dropdownParent: $('#createCurriculum'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
