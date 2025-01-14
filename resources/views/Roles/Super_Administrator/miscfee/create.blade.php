<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true" id="createMiscFee">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Fees Creation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.misc_fees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="d-flex justify-content-center">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" name="category" id="category"
                            value="Miscellaneous Fee" readonly>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" id="description">
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" class="form-control" name="semester" id="semester">
                    </div>
                    <div class="form-group">
                        <label for="campus_id" class="form-label">Campus</label>
                        <select name="campus_id" id="campus_id" class="form-select id-number" aria-describedby="helpId">
                            <option value="" selected disabled>--Select One--</option>
                            @foreach ($campus as $cp)
                                <option value="{{ $cp->id }}">{{ $cp->code }}</option>
                            @endforeach
                        </select>
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
            dropdownParent: $('#createMiscFee'),
            dropdownAutoWidth: true
        });
    </script>
@endpush
