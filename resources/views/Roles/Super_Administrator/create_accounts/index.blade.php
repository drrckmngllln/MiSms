@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"></h4>

                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Create Account</a></li>
                                <li class="breadcrumb-item active">School Year:</li>
                                @if ($activeSchoolYear && $activeSchoolYear->status == 1)
                                    <li class="breadcrumb-item active">Semester: <span
                                            id="semester_idd">{{ $activeSchoolYear->semester }}</span></li>
                                    <input type="text" class="form-control" name="code" id="code"
                                        value="{{ $activeSchoolYear->code }}" readonly>
                                @else
                                    <p> No active School Year found.</p>
                                @endif
                            </ol>

                            </ol>
                        </div> --}}

                        {{-- <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Create Account</a></li>
                                <li class="breadcrumb-item active">School Year:</li>

                                <li class="breadcrumb-item active">Semester: <span id="semester_idd"></span></li>
                                <select name="type_of_students" id="type_of_students_idd" class="form-select id-number"
                                    aria-describedby="helpId" required>
                                    <option value="">Select School Year</option>
                                    @foreach ($sch_years as $sy)
                                        <option value="{{ $sy->id }}">{{ $sy->code }}</option>
                                    @endforeach
                                </select>
                            </ol>

                            </ol>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('superadmin.studentList.store') }}" method="POST" id="form-id"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="d-flex gap-3 align-items-end">
                            @if (auth()->check() &&
                                    !auth()->user()->hasAnyRole(['Super Admin for Accounting', 'Super Admin for Finance']))
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">
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


                            <div class="form-group">
                                <label>Import Student</label>
                                <input type="file" class="form-control" name="excel_file" id="excel_file" value="">
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2" style=""
                                id="saveButton">Save</button>
                        </div>
                    </form>



                    {{-- @include('Roles.Super_Administrator.create_accounts.promoteStudent') --}}

                    <div class="card" style="margin-top: 20px;">

                        <div class="card-body">

                            <h4 class="card-title" style="margin-top: 10px">Create Account</h4>

                            {{ $dataTable->table(['id' => 'createaccount-table']) }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('Roles.Super_Administrator.create_accounts.create')
@include('Roles.Super_Administrator.create_accounts.edit')
@include('Roles.Super_Administrator.create_accounts.enrollStudent')
@include('Roles.Super_Administrator.create_accounts.addSubject')
@include('Roles.Super_Administrator.create_accounts.accounting')
@include('Roles.Super_Administrator.create_accounts.viewSub')
@include('Roles.Super_Administrator.create_accounts.selectCurriullumEachStudent')
@include('Roles.Super_Administrator.create_accounts.addonViewSubject')
@include('Roles.Super_Administrator.create_accounts.interSession')



@push('scripts')
    {{-- Include DataTable scripts --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }}


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
        var idNumberValue;

        function printStudentAssessment(id, id_number, campus_id, semester) {
            // console.log(semester);
            idNumberValue = id_number;
            var PrintRoute =
                "{{ route('superadmin.pdf.printStudentAssessment', ['id_number' => ':id_number']) }}";
            PrintRoute = PrintRoute.replace(':id_number', id_number);
            var newWindow = window.open(PrintRoute, '_blank');
            if (newWindow) {
                newWindow.focus();
            }
        }
    </script>
    {{-- <script>
        $(document).ready(function() {

            $('#school_year_idd').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var selectedSemester = selectedOption.data('semester');

                //set  the selected semester pass to create page
                $('#semester').val(selectedSemester);

                $('#semester_idd').text(selectedSemester);

                //generate id to id_number on create page
                var currentYear = new Date().getFullYear();
                var generateID = currentYear + '-' + selectedSemester + Math.floor(Math.random() * 10000);
                $('#id_number').val(generateID);
            });
            //tas trgigger lang natin para mapasa siya
            $('#school_year_idd').trigger('change');
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('#cancel-account').click(function() {
                var checkedData = [];
                const title = 'Are you sure you want to cancel this account?';

                $('input[name="check[]"]:checked').each(function() {
                    var data = $(this).val().split(',');
                    checkedData.push({
                        id: data[0],
                        id_number: data[1],
                        year_level: data[2]
                    });
                    // console.log(checkedData);
                });

                if ($('input[name="check[]"]:checked').length > 0) {
                    Swal.fire({
                        title: title,
                        icon: 'warning',
                        html: `
                    • Delete Student Subject <br>
                    
  `,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'YES',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // console.log(id);
                            $.ajax({
                                url: '{{ route('superadmin.cancel.enrollment') }}',
                                type: 'DELETE',
                                // processData: false,
                                // contentType: false,
                                data: {
                                    checkedData: checkedData
                                },
                                success: function(data) {
                                    // console.log(data);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                    toastr.success(data.message);

                                    // console.log(data);
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                }
                            });
                        }
                    });
                }
                $('input[name="check[]"]:checked').each(function() {
                    // var id = $(this).val();
                    // var id_number = $(this).val();
                    // $.ajax({
                    //     url: '/superadmin/cancel_enrollment/' + id + '/' + id_number,
                    //     type: 'DELETE',
                    //     success: function(response) {},
                    //     error: function(xhr, status, error) {

                    //     }
                    // });

                });
            });
        });
    </script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });
        @if (Session::has('error'))
            $(document).ready(function() {
                // console.log('Hello promises!');
                (() => {
                    Toast.fire({
                        icon: 'error',
                        title: '{{ Session::get('error') }}',
                    });
                })();
            });
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('#createaccount-table').change(function() {
                var schoolYearId = $(this).val();
                if (schoolYearId) {
                    $.ajax({
                        url: '{{ route('superadmin.get.semesteronSchoolYear', '') }}/' +
                            schoolYearId,
                        type: 'GET',
                        success: function(data) {
                            $('#semester_idd').text(data.semester);
                            // Access the DataTable instance

                            // Now you can use the 'table' variable to perform actions on your DataTable

                        },
                        error: function(error) {
                            console.error("There was an error fetching the semester:", error);
                        }
                    });
                } else {
                    $('#semester_idd').text('');
                }
            });
        });
    </script>
@endpush
