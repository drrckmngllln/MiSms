<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true" id="adddate">
    <div class="modal-dialog modal-md">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Date From-To</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('superadmin.add.date') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <div class="form-group">
                        <label>Year Level</label>
                        <input type="text" class="form-control" name="year_level" placeholder="Ex. 1">
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" class="form-control" name="from">
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" class="form-control" name="to">
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
