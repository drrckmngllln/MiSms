@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    {{-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl">
                        <i class="ri-add-line"></i> Create New
                    </button> --}}
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <input type="hidden" id="subject_idddd" value="{{ $studentEnrolledSubject->subject_id }}">
                            <p>Subject ID: {{ $studentEnrolledSubject->subject_id }}</p>
                            <h4 class="card-title">Students <span id="full_name"></span></h4>
                            <table id="subjectstudentenrolled" class="table table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Course</th>
                                        <th>Semester</th>
                                        <th>School Year</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Final Grade</th>
                                    </tr>
                                </thead>
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
        $(document).ready(function() {

            var subjectID = $('#subject_idddd').val();
            // console.log(subjectID);
            $("#subjectstudentenrolled").DataTable().destroy();
            $("#subjectstudentenrolled").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/enrolledStudentsSubject',
                    type: 'GET',
                    data: function(d) {
                        d.id = $('#subject_idddd').val();
                        d.instructor_id = localStorage.getItem('instructor_id');
                    },
                },
                columns: [{
                        data: 'id_number',
                        name: 'id_number'
                    },
                    {
                        data: 'course_id',
                        name: 'course_id'
                    },
                    {
                        data: 'semester',
                        name: 'semester'
                    },
                    {
                        data: 'school_year',
                        name: 'school_year'
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
                        data: 'grade',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control grade-input" data-id="' +
                                row.id_number + '" data-field="grade" value="' + (data ? data :
                                    '') + '" placeholder="Enter grade">';
                        }
                    },

                ],

            });
            $('#subjectstudentenrolled').on('change', '.grade-input', function() {
                var idNumber = $(this).data('id');
                var field = $(this).data('field');
                var value = $(this).val();
                var subjectId = window.location.pathname.split('/').pop();
                var semester = $(this).closest('tr').find('td:eq(2)')
                    .text();
                $.ajax({
                    url: '{{ route('superadmin.save.grade') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_number: idNumber,
                        field: field,
                        value: value,
                        subject_id: subjectId,
                        semester: semester
                    },
                    success: function(response) {
                        // Handle success (e.g., show a success message)
                        console.log('Grade updated successfully');
                    },
                    error: function(xhr, status, error) {
                        // Handle error (e.g., show an error message)
                        console.log('Failed to update grade');
                    }
                });
            });
        });
    </script>
@endpush
