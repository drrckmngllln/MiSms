<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content within the 'my-4 text-center' div goes here -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" id="editModal{{ $role->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel{{ $role->id }}">Edit Name Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('superadmin.role.update', $role->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $role->name }}">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                style="float: left;">Update Role Name</button>
                        </div>
                    </form>

                    <div class="modal-header">
                        <h5 class="modal-title">Role Permissions</h5>
                    </div>


                    <div class="modal-body">

                        <div id="selectedPermissionsSection-{{ $role->id }}" style="display: flex; gap: 10px; ">
                            @if ($role->permissions)
                                @foreach ($role->permissions as $role_permission)
                                    {{-- <span>{{ $role_permission->name }}</span> --}}
                                    <form
                                        action="{{ route('superadmin.roles.permissions.revoke', ['role' => $role->id, 'permission' => $role_permission->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-item">
                                            {{ $role_permission->name }}
                                        </button>
                                    </form>
                                @endforeach
                            @endif
                            <!-- Selected permission names will be displayed here -->
                        </div>
                        <form action="{{ route('superadmin.roles.permissions', $role->id) }}" method="POST">
                            @csrf
                            {{-- hindi tayu gagamit ng put dahil post yung nasa route --}}
                            <div class="col-md-6 mb-3">
                                <label for="permission" class="form-label"></label>
                                <select name="permission" id="permission-{{ $role->id }}" class="form-select"
                                    aria-describedby="helpId">
                                    <option value="">Select Permission</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}"
                                            {{ $permission === $permission->name ? 'selected' : '' }}>
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach

                                    <!-- Add more options as needed -->
                                </select>
                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                    style="float: left;">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#permission-{{ $role->id }}').on('change', function() {

                var selectedPermission = $(this).val();
                var selectedPermissionsSection = $('#selectedPermissionsSection-{{ $role->id }}');

                // Check if a permission is selected
                if (selectedPermission) {
                    // Append the selected permission name to the section
                    selectedPermissionsSection.html('<p>Selected Permissions:</p><ul><li>' +
                        selectedPermission + '</li></ul>');
                } else {
                    // Clear the section if no permission is selected
                    selectedPermissionsSection.empty();
                }
            });
        });
    </script>
@endpush
