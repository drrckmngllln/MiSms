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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Students Discounts</a></li>
                                <li class="breadcrumb-item active">Discounts</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="col-md-6 mb-3 d-flex gap-3 align-items-end">
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target=".bs-example-modal-xl">
                            <i class="ri-add-line"></i> Add Students
                        </button>
                        <form action="" method="post" id="form_id" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex gap-3 align-items-end">
                                <div class="form-group">
                                    <label>ID Number</label>
                                    <input type="text" class="form-control" name="id_number" id="student_id_number"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Student Name:</label>
                                    <input type="text" class="form-control" name="name" id="student_name" readonly>
                                </div>




                                <button type="button" class="btn btn-secondary waves-effect waves-light"
                                    data-bs-toggle="modal" id="addDiscountButton" style="display: none">
                                    Add Discount
                                </button>
                            </div>
                        </form>
                    </div>
                    {{-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl">
                        <i class="ri-add-line"></i> Create New
                    </button> --}}
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Student Discount</h4>
                            <table id="students-all-discounts"
                                class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Code</th>
                                        <th>Discount Target</th>
                                        <th>Remarks</th>
                                        <th>School Year</th>
                                        <th>Semester</th>
                                        <th>Discount Percentage</th>
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
    <!-- End Page-content -->
    @include('Roles.Super_Administrator.studentDiscount.addStudents')
    @include('Roles.Super_Administrator.studentDiscount.addDiscounts')
@endsection

@push('scripts')
    {{-- Include DataTable scripts --}}
    <script>
        $(document).ready(function() {
            // Check if the 'id' query parameter is present in the URL
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('id') && urlParams.has('name')) {
                var idNumber = urlParams.get('id');
                var studentName = urlParams.get('name');

                $('#student_id_number').val(idNumber);
                $('#student_name').val(studentName);
                //mag papakita yung add discount button kapag nag triggered window.location
                $('#addDiscountButton').show();

                $('#addDiscountButton').click(function() {
                    $('#AddStudentDiscounts').modal(
                        'show'); // eto naman yung id ng modal pag na click yung button or na trigger
                });
            }
        });
    </script>
    <script>
        $("#students-all-discounts").DataTable().destroy();
        // Initialize DataTable with dynamic id_number
        $("#students-all-discounts").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('superadmin.students.Getdiscounts') }}',
                type: 'GET',
            },
            columns: [{
                    data: 'id_number',
                    name: 'id_number'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'discount_target',
                    name: 'discount_target'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'school_year',
                    name: 'school_year'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'discount_percentage',
                    name: 'discount_percentage'
                },
                {
                    data: 'action',
                    name: 'action'
                },

            ],
        });
    </script>
@endpush
