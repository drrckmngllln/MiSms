@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"></h4>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if (auth()->check() &&
                            !auth()->user()->hasAnyRole(['Super Admin for Accounting', 'Super Admin for Finance']))
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target=".bs-example-modal-xl">
                            <i class="ri-add-line"></i> Create New
                        </button>
                    @endif
                    @if (auth()->check() &&
                            !auth()->user()->hasAnyRole(['Super Admin for Accounting', 'Super Admin for Finance']))
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle=""
                            data-bs-target="" id="cancel-account">
                            <i class="ri-close-line"></i> Cancel Account
                        </button>
                    @endif

                    {{-- @include('Roles.Super_Administrator.create_accounts.promoteStudent') --}}

                    <div class="card" style="margin-top: 20px;">

                        <div class="card-body">

                            <h4 class="card-title" style="margin-top: 10px">Create Account</h4>

                            {{-- {{ $dataTable->table() }} --}}
                            <table id="highSchoolTable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Admission Date</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>ID Number</th>
                                        <th>Department</th>
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
@include('Roles.Super_Administrator.highschool.create')
@include('Roles.Super_Administrator.highschool.edit')
@include('Roles.Super_Administrator.highschool.selectCurriullumEachStudent')
@include('Roles.Super_Administrator.highschool.enrollStudent')
@include('Roles.Super_Administrator.highschool.addSubject')
@include('Roles.Super_Administrator.highschool.accounting')





@push('scripts')
    <script type="module">
        $(document).ready(function() {

            $.fn.dataTable.ext.errMode = 'none';

            // Catch DataTables AJAX error
            $(document).on('warning.dt', function(e, settings, techNote, message) {
                console.error('DataTables error:', message);
                toastr.error(
                    'Check the curriculum if you already set the course you want to assign to the student'
                );
            });
        });
    </script>
    <script>
        $("#highSchoolTable").DataTable().destroy();
        $("#highSchoolTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('superadmin.highSchool.create') }}",
            columns: [{
                    data: 'admission_date',
                    name: 'admission_date'
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
                    data: 'id_number',
                    name: 'id_number'
                },
                {

                    data: 'course',
                    name: 'course'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],

        });
    </script>
    <script>
        var idNumberValue;

        function printStudentAssessment(id, id_number, campus_id, semester) {
            // console.log(semester);
            idNumberValue = id_number;
            var PrintRoute =
                "{{ route('superadmin.pdf.printStudentAssessmentHS', ['id_number' => ':id_number']) }}";
            PrintRoute = PrintRoute.replace(':id_number', id_number);
            var newWindow = window.open(PrintRoute, '_blank');
            if (newWindow) {
                newWindow.focus();
            }
        }
    </script>
@endpush
