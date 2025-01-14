<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal{{ $permission->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel{{ $permission->id }}">Edit Permssion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- form ng pag update ng permission --}}
                    <form action="{{ route('superadmin.permission.update', $permission->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $permission->name }}">
                        </div>

                        <!-- Move the closing </div> for the modal content here -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                style="float: left;">Update Curriculum</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
