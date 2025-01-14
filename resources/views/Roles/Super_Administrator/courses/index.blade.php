@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Courses</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Courses</a></li>
                                <li class="breadcrumb-item active">All Courses</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">

                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl"><i class="ri-add-line"></i>
                        Create New
                    </button>

                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Courses List</h4>

                            {{-- {{ $dataTable->table() }} --}}

                            <table class="table" id="course-table">
                                <thead>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Campus</th>
                                    <th>Department</th>
                                    <th>Max Units</th>
                                    <th>Offered</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- End Page-content -->
@endsection
@include('Roles.Super_Administrator.courses.create')
@include('Roles.Super_Administrator.courses.edit')
@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }} --}}

    <script>
        $("#course-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('superadmin.courses.index') }}",
            },
            columns: [{
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'campus_id',
                    name: 'campus_id'
                },
                {
                    data: 'department_id',
                    name: 'department_id'
                },
                {
                    data: 'max_units',
                    name: 'max_units'
                },
                {
                    data: 'is_offered',
                    name: 'is_offered'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    </script>
@endpush
