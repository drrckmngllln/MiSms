<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
    </div>
    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Create Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.departments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row">
                        <div class="form-group col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" placeholder="Ex. BSIT">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" cols="10" rows="8"
                                placeholder="Ex. College of Information Technology"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="campus_id" class="form-label">Campus</label>
                            <select name="campus_id" id="campus_id" class="form-select id-number"
                                aria-describedby="helpId">
                                <option value="" selected disabled>--Select One--</option>
                                @foreach ($campus as $cp)
                                    <option value="{{ $cp->id }}">{{ $cp->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
