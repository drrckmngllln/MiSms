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
                            <input type="hidden" id="section_iddd" value="{{ $section->id }}">


                            <h4 class="card-title">Subjects Set For/ <span id="full_name"></span></h4>
                            <table id="sectionSubject" class="table table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Students Enrolled on this Subject</th>
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
            var sectionId = $('#section_iddd').val();

            // console.log(sectionId); // Initialize DataTable
            $("#sectionSubject").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/SecWithSub/',
                    type: 'GET',
                    data: function(d) {
                        d.id = $('#section_iddd').val();
                        d.instructor_id = localStorage.getItem('instructor_id');
                    },
                },
                columns: [{
                    data: 'section',
                    name: 'section'
                }, {
                    data: 'action',
                    name: 'action'
                }],

            });

        });

        // Function to reload DataTable when sectionId changes
        function reloadDataTable() {
            if ($("#sectionSubject").DataTable()) {
                $("#sectionSubject").DataTable().ajax.reload();
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let instructorId = localStorage.getItem('full_name');
            if (instructorId) {
                document.getElementById('full_name').textContent = instructorId;
            } else {
                document.getElementById('full_name').textContent = 'No instructor selected';
            }
        });
    </script>
    <script>
        function editMiscFee(id) {
            console.log(id);
        }
    </script>
@endpush
