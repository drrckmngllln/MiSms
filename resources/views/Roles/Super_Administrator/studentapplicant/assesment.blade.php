<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->
    </div>

    <!-- Modal content for the above example -->

    <div class="modal fade bs-example-modal-xl" tabindex="-1" id="viewForAssesment" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">View Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Navigation Tabs -->
                    <!-- Form -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Basic Information</h4>
                                <form action="" id="edit_form" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="view_assesment" name="id">
                                    <div class="row" id="edit_page_1_view">

                                        <div class="d-flex justify-content-center">

                                            <div class="row mx-1">
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; ">
                                                        <b>Name: <span id="view_name_assesment"></span></b>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        ID Number: <span id="view_id_number_assesment"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Course: <span id="view_course_id"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Year Level: <span id="view_year_level"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Section: <span id="view_section"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Semester: <span id="view_semester"></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Fees</h4>
                                                    <p class="card-title-desc" id="view_section_code">
                                                    </p>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0" id="curriculum_id_datatable">

                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Free Type</th>
                                                                    <th>Amount</th>
                                                                    <th>Units</th>
                                                                    <th>Computation</th>
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
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        function viewAssesment(id, last_name, first_name, middle_name, id_number, code, year_level, section_code,
            semester) {
            $('#view_id_number_assesment').text(id_number);
            $('#view_course_id').text(code);
            $('#view_year_level').text(year_level);
            $('#view_section').text(section_code);
            $('#view_semester').text(semester);

            var fullName = last_name + ' ' + first_name + ' ' + middle_name;
            $('#view_name_assesment').text(fullName);

        }
    </script>
@endpush
