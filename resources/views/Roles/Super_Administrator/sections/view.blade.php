<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" id="view" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="">
                <h5 class="modal-title" id="myExtraLargeModalLabel">View Subject With Instructors</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit_form_sections">
                @csrf
                <input type="hidden" name="subject_id" id="detailsofsubject_id">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body row">
                    <table id="view-subject-with-additionaldetails"
                        class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Instructor</th>
                                <th>Time</th>
                                <th>Day</th>
                                <th>Room</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        function view(id) {
            $('#edit_id').val(id);
            // console.log(id);
            $(document).ready(function() {
                $("#view-subject-with-additionaldetails").DataTable().destroy();
                $('#view-subject-with-additionaldetails').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('superadmin.get.subjectWithInstructor') }}',
                        data: {
                            subject_id: id
                        }
                    },
                    columns: [{
                            data: 'instructor',
                            name: 'instructor'
                        },
                        {
                            data: 'time',
                            name: 'time'
                        },
                        {
                            data: 'day',
                            name: 'day'
                        },
                        {
                            data: 'room',
                            name: 'room'
                        },
                        {
                            data: 'semester',
                            name: 'semester'
                        },
                    ]
                });
            });


        }
    </script>
@endpush
