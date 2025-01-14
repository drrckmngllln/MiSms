<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Fees Creation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.feesCategory.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                    </div>

                    <div class="form-group">
                        <label>Tuition Fees</label>
                        <input type="text" class="form-control" name="category" id="category">
                    </div>

                    <div class="form-group">
                        <label>Tuition Free Type</label>
                        <input type="text" class="form-control" name="freetype" id="freetype">
                    </div>

                    <div class="form-group">
                        <label for="course_id" class="form-label">Course</label>
                        <select name="course_id" id="course_id" class="form-select id-number" aria-describedby="helpId">
                            <option value="" selected disabled>--Select One--</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->code }}</option>
                            @endforeach
                        </select>


                    </div>
                    <div class="form-group">
                        <label>Year Level</label>
                        <input type="text" class="form-control" name="year_level" id="year_level">
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" name="amount" id="amount">
                    </div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" name="remarks" cols="10" rows="10"></textarea>
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
