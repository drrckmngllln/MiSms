@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Section Subjects</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Sections Subject</a></li>
                                <li class="breadcrumb-item active">All Subjects</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->
            <div class="row">
                <div class="col-12">

                    @include('Roles.Super_Administrator.section_subjects.create')
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl"><i class="ri-add-line"></i>
                        Add Subjects
                    </button>


                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body" id="curriculumList">
                            {{-- {{ $dataTable->table() }} --}}
                            <h4 class="card-title">Subjects</h4>
                            <form action="" method="get" id="form-id">
                                <input type="hidden" name="id" id="id">

                            </form>
                            <table id="sectionSubject" class="table">
                                <thead>
                                    <th>Semester</th>
                                    <th>Code</th>
                                    <th>Descriptive Title</th>
                                    <th>Total Units</th>
                                    <th>Lecture Units</th>
                                    <th>Lab Units</th>
                                    <th>Pre-requisite</th>
                                    <th>Total Hours Per Week</th>
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

@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }} --}}
    <script>
        $("#sectionSubject").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: location.href,
            },
            columns: [{
                    data: 'semester_id',
                    name: 'semester_id'
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
