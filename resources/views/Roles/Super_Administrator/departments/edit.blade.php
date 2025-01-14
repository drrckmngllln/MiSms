<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="form-departments">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body row">
                        <div class="form-group col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" id="code">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" cols="10" rows="8" id="description"></textarea>
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

@push('scripts')
    <script>
        function editUser(id, code, description, campus_id) {
            $("#id").val(id);
            $("#code").val(code);
            $("#description").val(description);
            $("#campus_id").val(campus_id);
            $("#form-departments").attr('action', location.href + '/' + id);
        }
    </script>
@endpush
