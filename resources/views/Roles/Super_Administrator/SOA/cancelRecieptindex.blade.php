@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Students</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Students</a></li>
                                <li class="breadcrumb-item active">Cancel Reciept</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
            <div class="card-body">

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="col-md-6 mb-3 d-flex gap-3 align-items-end">

                    </div>
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body" id="curriculumList">
                            </form>
                            <table id="cancelReciept" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $("#cancelReciept").DataTable().destroy();
        $("#cancelReciept").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/superadmin/cancelRecipt',
                type: 'GET',
            },
            columns: [{
                    data: 'id_number',
                    name: 'id_number'
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
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'cancelRecieptStatus',
                    name: 'cancelRecieptStatus',

                },
                {
                    data: 'action',
                    name: 'action'
                },

            ],
        });
    </script>
    <script>
        $(document).on('click', '.delete-item-cancel', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');

            Swal.fire({
                title: 'Are you sure to cancel Receipt?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The record has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Reload DataTable to reflect changes
                                    $('#cancelReciept').DataTable().ajax.reload(null,
                                        false);
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again later.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endpush
