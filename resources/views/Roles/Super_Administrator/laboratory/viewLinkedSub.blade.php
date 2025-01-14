<!--  Modal content for the above example -->
<div id="viewLinkedSubject" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Linked Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" id="linked_id">
                    <table id="linked-SubjectView-tables" class="table table-striped table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Descriptive Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        function viewsubjectLinked(labId) {

            $('#linked-SubjectView-tables').DataTable().destroy();
            $('#linked-SubjectView-tables').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "getLinkedSubjects/" + labId,
                    data: {
                        labId: labId
                    },
                },
                columns: [{
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'descriptive_tittle',
                        name: 'descriptive_tittle'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
            });
        }
    </script>
    <script>
        function removeLabId(subjectId) {

            const deleteUrl = '{{ route('superadmin.remove.lab.id', ':id') }}'.replace(':id', subjectId);


            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: deleteUrl,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: data.message,
                                    icon: "success",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "OK",
                                }).then(() => {
                                    $('#linked-SubjectView-tables').DataTable().ajax.reload();
                                });
                            } else if (data.status == "error") {
                                Swal.fire("Cannot Delete", data.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("Error", "Something went wrong!", "error");
                            console.log(error);
                        }
                    });
                }
            });
        }
    </script>
@endpush
