<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Select Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                    </div>


                    <table id="students-discounts-table" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Student Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">

            </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        $("#students-discounts-table").DataTable().destroy();
        // Initialize DataTable with dynamic id_number
        $("#students-discounts-table").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('superadmin.students.Adddiscounts') }}',
                type: 'GET',
            },
            columns: [{
                    data: 'id_number',
                    name: 'id_number'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.last_name + ' ' + row.first_name;
                    },
                    name: 'full_name'
                },
                {
                    data: 'id_number',
                    name: 'id_number',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // Add natin yung route ng landing page para maipasa yung id sa another page samay index
                        return '<a href="{{ route('superadmin.student.discount') }}?id=' + row.id_number +
                            '&name=' + row.last_name + ' ' + row.first_name + '&school_year=' + row
                            .school_year + '" class="btn btn-primary btn-add">Add</a>';
                    }
                },
            ],
        });
    </script>
@endpush
