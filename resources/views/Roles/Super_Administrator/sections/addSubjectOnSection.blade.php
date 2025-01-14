<!--  Modal content for the above example -->
<div id="addSectionSubject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content "style="grey">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                    </div>
                    <table id="add-View-subject" class="table table-striped table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Subject ID</th>
                                <th>Code</th>
                                <th>Descriptive Title</th>
                                <th>Total Units</th>
                                <th>Lecture Units</th>
                                <th>Lab Units</th>
                                <th>Pre Requisite</th>
                                <th>Total Hours</th>
                                <th>Laboratory</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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
