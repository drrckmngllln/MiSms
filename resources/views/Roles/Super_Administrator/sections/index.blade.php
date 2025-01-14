@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Sections</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Sections</a></li>
                                <li class="breadcrumb-item active">All Sections</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
            <div class="row">
                <div class="col-12">
                    @include('Roles.Super_Administrator.sections.create')
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl"><i class="ri-add-line"></i>
                        Create New Section
                    </button>

                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Sections List</h4>
                            {{-- {{ $dataTable->table() }} --}}
                            <table class="table" id="section-table">
                                <thead>
                                    <th>Code</th>
                                    <th>Semester</th>
                                    <th>Course</th>
                                    <th>Year Level</th>
                                    <th>Number of Students</th>
                                    <th>Maximum Number of Students</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @include('Roles.Super_Administrator.sections.edit')
                @include('Roles.Super_Administrator.sections.showsubject')
                @include('Roles.Super_Administrator.sections.adddetails')
                @include('Roles.Super_Administrator.sections.addSubjectOnSection')
                @include('Roles.Super_Administrator.sections.editadddetails')
                @include('Roles.Super_Administrator.sections.view')
                @include('Roles.Super_Administrator.sections.viewStudentSection')
                @include('Roles.Super_Administrator.sections.addSubject')

                {{-- @include('Roles.Super_Administrator.sections.editCurriculumSubject') --}}
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@endsection

@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }} --}}
    <script>
        $("#section-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('superadmin.sections.index') }}",
            },
            columns: [{
                    data: 'section_code',
                    name: 'section_code'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'course_id',
                    name: 'course_id'
                },
                {
                    data: 'year_level',
                    name: 'year_level'
                },

                {
                    data: 'number_of_students',
                    name: 'number_of_students'
                },
                {
                    data: 'max_number_of_students',
                    name: 'max_number_of_students'
                },
                {
                    data: 'from',
                    name: 'from',
                },
                {
                    data: 'to',
                    name: 'to'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'remarks',
                    name: 'remarks'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    </script>

    <script>
        function throwID(id) {
            // console.log('hello!!');
            $('#id').val(location.href);
            window.location.href = location.href + '/' + id;
        }
    </script>
    <script type="module">
        $(document).ready(function() {

            $.fn.dataTable.ext.errMode = 'none';

            // Catch DataTables AJAX error
            $(document).on('warning.dt', function(e, settings, techNote, message) {
                console.error('DataTables error:', message);
                toastr.warning(
                    'Just Continue'
                );
            });
        });
    </script>
@endpush
