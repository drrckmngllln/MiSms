@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Curriculum Subjects</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Curriculum</a></li>
                                <li class="breadcrumb-item active">All Subjects</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
            <div class="card-body">
                <div class="">
                    <div class="progress" style="display: none">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="col-md-6 mb-3 d-flex gap-3 align-items-end">

                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target=".bs-example-modal-xl">
                            <i class="ri-add-line"></i> Add Subjects
                        </button>

                        <form action="{{ route('superadmin.importsubjects.store') }}" method="POST" id="form-id"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="curriculum_id" value="{{ request('curriculum') }}">
                            <div class="d-flex gap-3 align-items-end">
                                <div class="form-group">
                                    <label>Import Subject</label>
                                    <input type="file" class="form-control" name="excel_file" id="excel_file"
                                        value="">
                                </div>
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2" style=""
                                    id="saveButton">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body" id="curriculumList">
                            {{-- {{ $dataTable->table() }} --}}
                            <h4 class="card-title">Curriculum List</h4>
                            <form action="" method="get" id="form-id">
                                <input type="hidden" name="id" id="id">
                            </form>
                            <table id="curriculumSubject" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th><button class="btn btn-danger" id="deleteSelected">DELETE</button>
                                    <th> <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i
                                                class="ri-add-line"></i>
                                            ADD DEPARTMENT
                                        </button>

                                    </th>
                                    <tr>
                                        <th>Check Box</th>
                                        <th>Semester</th>
                                        <th>Year Level</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Total Units</th>
                                        <th>Lecture Units</th>
                                        <th>Lab Units</th>
                                        <th>Pre Requisite</th>
                                        <th>Total Hours</th>
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
    @include('Roles.Super_Administrator.curriculum_subjects.create')
    @include('Roles.Super_Administrator.curriculum_subjects.editCurriculumSubject')

    <!-- End Page-content -->
@endsection
@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }} --}}
    <script>
        $(document).ready(function() {
            $("#saveButton").click(function() {
                // Show the progress bar
                $(".progress").show();


                let progress = 0;
                let progressBar = $(".progress-bar");

                function updateProgressBar() {
                    progress += 5;
                    progressBar.width(progress + "%");
                    progressBar.text(progress + "%");

                    if (progress < 100) {

                        setTimeout(updateProgressBar, 500);
                    } else {

                        $(".progress").hide();
                    }
                }

                // Start updating the progress bar
                updateProgressBar();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#curriculumSubject").DataTable().destroy();
            var table = $("#curriculumSubject").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('superadmin.curriculum.getSubjectss') }}',
                    type: 'POST',
                    data: {
                        curriculum_id: {{ request('curriculum') }}
                    }
                },
                columns: [{
                        data: 'Check Box',
                        name: 'Check Box',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'semester_id',
                        name: 'semester_id'
                    },
                    {
                        data: 'year_level',
                        name: 'year_level'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'descriptive_tittle',
                        name: 'descriptive_tittle'
                    },
                    {
                        data: 'total_units',
                        name: 'total_units'
                    },
                    {
                        data: 'lecture_units',
                        name: 'lecture_units'
                    },
                    {
                        data: 'lab_units',
                        name: 'lab_units'
                    },
                    {
                        data: 'pre_requisite',
                        name: 'pre_requisite'
                    },
                    {
                        data: 'total_hrs_per_week',
                        name: 'total_hrs_per_week'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
            $('#checkAll').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('input[type="checkbox"].check-item', rows).prop('checked', this.checked);
            });

            $('#curriculumSubject').on('change', 'input[type="checkbox"].check-item', function() {
                if (!this.checked) {
                    var el = $('#checkAll').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });
            //DELETE
            $('#deleteSelected').on('click', function() {
                var id = [];
                table.$('input[type="checkbox"].check-item:checked').each(function() {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('superadmin.curriculum.alldeleteSubjects') }}',
                                type: 'POST',
                                data: {
                                    id: id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                    // Reload the DataTable
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "An error occurred while deleting the records.",
                                        icon: "error"
                                    });
                                }
                            });
                        }
                    });
                }
            });

        });
    </script>
@endpush
