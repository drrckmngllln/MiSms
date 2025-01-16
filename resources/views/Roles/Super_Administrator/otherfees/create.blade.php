<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="createOtherFees">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Other Fees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.otherfees.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" name="category" id="category" value="Other Fees"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>
                        <div class="form-group">
                            <label>Semester:</label>
                            <input type="text" class="form-control" name="semester" id="semester_idd">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Campus</label>
                                <select class="form-control" name="campus_id" id="campus_id">
                                    <option value="">Select Campus</option>
                                    @foreach ($campus as $cp)
                                        <option value="{{ $cp->id }}">{{ $cp->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label>1st Year</label>
                            <input type="text" class="form-control" name="first_year" id="first_year">
                        </div>
                        <div class="form-group">
                            <label>2nd Year</label>
                            <input type="text" class="form-control" name="second_year" id="second_year">
                        </div>
                        <div class="form-group">
                            <label>3rd Year</label>
                            <input type="text" class="form-control" name="third_year" id="third_year">
                        </div>
                        <div class="form-group">
                            <label>4th Year</label>
                            <input type="text" class="form-control" name="fourth_year" id="fourth_year">
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
</div>
@push('scripts')
    <script>
        $('#course_id_select2').select2({
            dropdownParent: $('#createOtherFees'),
            dropdownAutoWidth: true
        });
    </script>
@endpush
