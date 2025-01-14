    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="addpermissionToRoles{{ $role->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Name Role: {{ $role->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.roles.givepermission', $role->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="col-md-12 mb-12">
                            <label for="" class="form-label">Permissions</label>
                            @foreach ($permissions as $permission)
                                <input type="checkbox" name="permission[]" value="{{ $permission->name }}">
                                {{-- {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} --}}
                                {{ $permission->name }}
                            @endforeach
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
