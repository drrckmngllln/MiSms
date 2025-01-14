<!--  Modal content for the above example -->
<div id="additionalFees" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Add Other Fees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.store.AddtionalFees') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">


                        <input type="text" class="form-control" name="cahier_in_charge" id="edit_cashier_in_charge"
                            value="{{ $role }}" hidden>

                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name_id"
                            value="{{ $name }}" hidden>

                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" name="particulars" id="particulars"
                                value="Other Fees" hidden>
                            <label>Category</label>
                            <input type="text" class="form-control" name="category" id="category" value="Other Fees"
                                readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Description:</label>
                            <input type="text" class="form-control" name="description" id="description_id">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Fee Type:</label>
                            <input type="text" class="form-control" name="fee_type" id="fee_type_id">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Semester:</label>
                            <input type="text" class="form-control" name="semester" id="semester_idd">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Year Level:</label>
                            <input type="text" class="form-control" name="year_level" id="year_level_id">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Course</label>
                            <select class="form-control" name="course_id" id="course_id">
                                <option value="">Select Course</option>
                                @foreach ($course as $cs)
                                    <option value="{{ $cs->id }}">{{ $cs->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>School Year</label>
                            <select class="form-control" name="school_year" id="school_year_id">
                                <option value="">Select Schoolyear</option>
                                @foreach ($schoolyear as $sy)
                                    <option value="{{ $sy->id }}">{{ $sy->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Campus</label>
                            <select class="form-control" name="campus_id" id="campus_id">
                                <option value="">Select Campus</option>
                                @foreach ($campus as $cp)
                                    <option value="{{ $cp->id }}">{{ $cp->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>1st Year</label>
                            <input type="text" class="form-control" name="first_year" id="first_year">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>2nd Year</label>
                            <input type="text" class="form-control" name="second_year" id="second_year">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>3rd Year</label>
                            <input type="text" class="form-control" name="third_year" id="third_year">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>4th Year</label>
                            <input type="text" class="form-control" name="fourth_year" id="fourth_year">
                        </div>
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
        document.getElementById('description_id').addEventListener("input", function() {
            const descriptionValue = this.value;
            document.getElementById('fee_type_id').value = descriptionValue;
            document.getElementById('particulars').value = descriptionValue;
        })
    </script>
@endpush
