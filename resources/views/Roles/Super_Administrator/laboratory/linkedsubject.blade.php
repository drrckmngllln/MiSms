<!--  Modal content for the above example -->
<div id="linkedSubjectModal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
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
                    <table id="linked-Subject-table" class="table table-striped table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Year Level</th>
                                <th>Section</th>
                                <th>Code</th>
                                <th>Descriptive Title</th>
                                <th>Semester</th>
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
        let linked_id;

        function subjectLinked(id) {
            linked_id = id;
            $('#linked_id').val(id);
        }
    </script>
    <script>
        $(document).ready(function() {
            // const curr_id = 7;
            // let url = "{{ route('superadmin.get.LikedSubeject', ['curriculum_id' => ':curr_id']) }}";
            // url.replace(":curr_id", curr_id);
            $('#linked-Subject-table').DataTable().destroy();
            $('#linked-Subject-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('superadmin.get.LikedSubeject') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'year_level',
                        name: 'year_level',
                    },
                    {
                        data: 'section',
                        name: 'section',
                    },
                    {
                        data: 'code',
                        name: 'code',
                    },
                    {
                        data: 'descriptive_tittle',
                        name: 'descriptive_tittle',
                    },
                    {
                        data: 'semester_id',
                        name: 'semester_id',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
            });
        });
    </script>
    <script>
        function saveLaboratory(id) {
            $.ajax({
                url: '{{ route('superadmin.save.linkedSubject') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    lab_id: linked_id,
                    id: id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success('Saved successfully');
                    } else if (response.status === 'error') {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    </script>
@endpush
