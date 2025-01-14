@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Curriculum</h4>






                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Curriculum</a></li>
                                <li class="breadcrumb-item active">All Curriculum</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
            <div class="row">
                <div class="col-12">

                    @include('Roles.Super_Administrator.functionality.offerings.curriculum.create')
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl"><i class="ri-add-line"></i>
                        Create New
                    </button>

                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Curriculum List</h4>
                            {{-- {{ $dataTable->table() }} --}}
                            <table class="table" id="curriculum-table">
                                <thead>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Campus</th>
                                    <th>Course</th>
                                    <th>Effective</th>
                                    <th>Expires</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @include('Roles.Super_Administrator.functionality.offerings.curriculum.edit')
            </div>

        </div>
    </div>
    <!-- End Page-content -->
@endsection

@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }} --}}

    <script>
        $("#curriculum-table").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('superadmin.curriculum.index') }}",
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
                    data: 'course_id',
                    name: 'course_id'
                },
                {
                    data: 'effective',
                    name: 'effective'
                },
                {
                    data: 'expires',
                    name: 'expires'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },

            ]
        });

        function throwID(id) {
            $("#id").val(location.href);
            window.location.href = location.href + '/' + id;
        }
    </script>
@endpush
