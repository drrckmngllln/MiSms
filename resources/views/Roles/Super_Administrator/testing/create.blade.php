<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content Goes Here -->
    </div>

    <!-- Modal -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Testing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.testing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Banner</label>
                            <input type="file" class="form-control" name="banner">
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" class="form-control" name="type" value="{{ old('type') }}">
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <code>{{ $errors->first('title') }}</code>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Starting Price</label>
                            <input type="text" class="form-control" name="starting_price"
                                value="{{ old('starting_price') }}">
                        </div>
                        <div class="form-group">
                            <label>Button Url</label>
                            <input type="text" class="form-control" name="btn_url" value="{{ old('btn_url') }}">
                            @if ($errors->has('btn_url'))
                                <code>{{ $errors->first('btn_url') }}</code>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Serial</label>
                            <input type="text" class="form-control" name="serial" value="{{ old('serial') }}">
                            @if ($errors->has('serial'))
                                <code>{{ $errors->first('serial') }}</code>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputState">Select Status</label>
                            <select id="inputState" class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
