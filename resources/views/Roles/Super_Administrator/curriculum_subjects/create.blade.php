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
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="d-flex justify-content-center">
                    </div>

                    <div class="form-group">
                        <label for="campus_id" class="form-label">Campus</label>
                        <select name="campus_id" id="campus_id" class="form-select id-number" aria-describedby="helpId">
                            <option value="" selected disabled>--Select One--</option>
                            {{-- @foreach ($department as $dp)
                                <option value="{{ $dp->id }}">{{ $dp->code }}</option>
                            @endforeach --}}
                        </select>
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
