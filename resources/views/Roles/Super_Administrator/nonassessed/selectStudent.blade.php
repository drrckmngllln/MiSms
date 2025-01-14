<!--  Modal content for the above example -->
<div id="ehee"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Students:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="d-flex justify-content-center">
                    </div>
                    <table id="feeCollection-select-table"
                        class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        $('#feeCollection-select-table').DataTable().destroy();
        //initialize datatable 
        $('#feeCollection-select-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('superadmin.feeCollection.select') }}',
                type: 'GET',
                error: function(xhr, error, thrown) {
                    // Handle the Ajax error here
                    toastr.error('Enroll Student First or Check if there is a pending students');
                }
            },
            columns: [{
                    data: 'id_number',
                    name: 'id_number'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'first_name',
                    name: 'first_name'
                },
                {
                    data: 'middle_name',
                    name: 'middle_name'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        var totalAssessmentValue;
        var idValue;

        function addSelectStudent(id, id_number, status, last_name, first_name, middle_name, code, year_level, semester,
            downpayment, premils, midterms, semi_finals, finals, total_assessment, computation) {
            event.preventDefault();
            totalAssessmentValue = total_assessment;
            idValue = id;
            // console.log(code);
            // var computationArray = JSON.parse(computation);
            // console.log(computation);
            //ServerSide
            // other id stuff on other page
            $('#hahii').text(semester);
            $('#yahuu').text(year_level);
            $('#holeee').text(code);
            var fullName = last_name + ' ' + first_name + ' ' + (middle_name ? ' ' + middle_name : ' ');
            $('#hiii').text(fullName);
            $('#hoyy').text(status);
            $('#heyy').val(id_number);

            $('#ehee').modal('hide');
            // console.log($('#fee-breakdown-table tbody tr:eq(4) td:eq(1)').text(finals));

            //throw the content of downpayment prelims ang other on other table


            $('#assesment-Breakdownsss').DataTable().destroy();
            $('#assesment-Breakdownsss').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/getFeeTypeComputation/' + id_number,
                    type: 'GET',
                },
                data: {
                    id_number: id_number,
                },
                columns: [{
                        data: 'fee_type',
                        name: 'fee_type'
                    },
                    {
                        data: 'computation',
                        name: 'computation'
                    },
                ],
            });
        }
    </script>
    <script></script>
@endpush
