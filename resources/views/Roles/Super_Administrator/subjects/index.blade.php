@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Subjects</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Subjects</a></li>
                                <li class="breadcrumb-item active">All Subjects</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">

                    @include('Roles.Super_Administrator.subjects.create')
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl"><i class="ri-add-line"></i>
                        Create New
                    </button>

                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">

                            {{ $dataTable->table() }}
                            {{-- <h4 class="card-title">Subjects List</h4>

                            <table id="subjectsDT" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Semester</th>
                                        <th>Code</th>
                                        <th>Descriptive Tittle</th>
                                        <th>Total Units</th>
                                        <th>Lecture Units</th>
                                        <th>Lab Units</th>
                                        <th>Total Hours/Week</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                            </table> --}}
                        </div>
                    </div>
                    @include('Roles.Super_Administrator.subjects.edit')
                </div>
            </div>

        </div>
    </div>
    <!-- End Page-content -->
@endsection

@push('scripts')

{{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }}
    {{-- <script>
        $("#subjectsDT").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('superadmin.subjects.index') }}"
            },
            columns: [
                {data: 'semester_id', name: 'semester_id'},
                {data: 'code', name: 'code'},
                {data: 'descriptive_tittle', name: 'descriptive_tittle'},
                {data: 'total_units', name: 'total_units'},
                {data: 'lecture_units', name: 'lecture_units'},
                {data: 'lab_units', name: 'lab_units'},
                {data: 'pre_requisite', name: 'pre_requisite'},
                {data: 'total_hrs_per_week', name: 'total_hrs_per_week'},
                {data: 'action', name: 'action'},
                
            ]
        });
    </script> --}}

    
@endpush