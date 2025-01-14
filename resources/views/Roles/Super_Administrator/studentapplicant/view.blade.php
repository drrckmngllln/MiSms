<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->
    </div>

    <!-- Modal content for the above example -->

    <div class="modal fade bs-example-modal-xl" tabindex="-1" id="viewModal" role="dialog"
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
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="row" id="edit_page_1_view">

                                        <div class="d-flex justify-content-center">

                                            <div class="row mx-1">
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; ">
                                                        <b>Name: <span id="view_name"></span></b>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        ID Number: <span id="view_id_number"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Gender: <span id="view_gender"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Date of Birth: <span id="view_date_of_birth"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Place of birth: <span id="view_place_of_birth"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Nationality: <span id="view_nationality"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Religion: <span id="view_religion"></span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">Enrolled Subject</h4>
                                                    <p class="card-title-desc" id="view_section_code">
                                                    </p>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0" id="curriculum_id_datatable">

                                                            <thead class="table-light">
                                                                <tr>

                                                                    <th>Code</th>
                                                                    <th>Description</th>
                                                                    <th>Total Units</th>
                                                                    <th>Lecture Units</th>
                                                                    <th>Lab Units</th>
                                                                    <th>Pre Requisite</th>
                                                                    <th>Total Hours</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input change-status"
                                            style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                            name="status" data-id="checkbox1" id="checkbox1">
                                        <label class="form-check-label" style="font-size: 1.2em;"
                                            for="statusToggle1"></label>
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
    {{-- <script>
        function viewUser(id, first_name, middle_name, last_name, prefix, email, date_of_birth, place_of_birth, religion,
            nationality, gender, civil_status, dialect, contact_number, complete_address, fathers_fullname,
            fathers_occupation, mothers_fullname, mothers_occupation, parents_address, parents_contact_number,
            guardian_fullname, guardian_address, employer_details, primary_school, secondary_school, junior_highschool,
            senior_highschool, last_school_attended, lastschool_name, lastschool_address, course_id, currirulum_id,
            student_type, year_level, fullname, form_138, image, transcript_of_record, honorable_dismissal,
            birth_certificate, ncae_copt, good_moral, true_copy_of_grades, police_clearance, status) {
            // alert("{{ asset('studentimage/StudentPicture_65235bf2ab2d0.j') }}")

            //image
            if (image == "") {
                $('#view_Studentimage').attr('src', "{{ asset('backend/assets/images/person-7243410_1280.png') }}");
            } else {

                $('#view_Studentimage').attr('src', location.origin + '/' + image);
            }
            //credentials
            // check natin status if true siya using if para na sync yung nasa database
            if (status == 1) {
                $('#checkbox1').prop('checked', true);
            } else {
                $('#checkbox1').prop('checked', false);
            }


            $('#view_Form138i').attr('src', location.origin + '/' + form_138);
            $('#view_Form138a').attr('href', location.origin + '/' + form_138);
            $('#view_TORi').attr('src', location.origin + '/' + transcript_of_record);
            $('#view_TORa').attr('href', location.origin + '/' + transcript_of_record);

            $('#view_HDi').attr('src', location.origin + '/' + honorable_dismissal);
            $('#view_HDa').attr('href', location.origin + '/' + honorable_dismissal);

            $('#view_bcerti').attr('src', location.origin + '/' + birth_certificate);
            $('#view_bcerta').attr('href', location.origin + '/' + birth_certificate);

            $('#view_ncaei').attr('src', location.origin + '/' + ncae_copt);
            $('#view_ncaea').attr('href', location.origin + '/' + ncae_copt);

            $('#view_goddmorali').attr('src', location.origin + '/' + good_moral);
            $('#view_goddmorala').attr('href', location.origin + '/' + good_moral);

            $('#view_tcgi').attr('src', location.origin + '/' + true_copy_of_grades);
            $('#view_tcga').attr('href', location.origin + '/' + true_copy_of_grades);

            $('#view_policeclearancei').attr('src', location.origin + '/' + police_clearance);
            $('#view_policeclearancea').attr('href', location.origin + '/' + police_clearance);

            $('#view_name').text(fullname);
            $('#view_email').text(email);
            $('#view_dateofbirth').text(date_of_birth);
            $('#view_placeofbirth').text(place_of_birth);
            $('#view_religion').text(religion);
            $('#view_nationality').text(nationality);
            $('#view_gender').text(gender);
            $('#view_civilstatus').text(civil_status);
            $('#view_dialect').text(dialect);
            $('#view_contactnumber').text(contact_number);
            $('#view_complete_address').text(complete_address);
            $('#view_fathers_fullname').text(fathers_fullname);
            $('#view_fathers_occupation').text(fathers_occupation);
            $('#view_mothers_fullname').text(mothers_fullname);
            $('#view_mothers_occupation').text(mothers_occupation);
            $('#view_parents_address').text(parents_address);
            $('#view_parents_number').text(parents_contact_number);
            $('#view_guardian_fullname').text(guardian_fullname);
            $('#view_guardian_address').text(guardian_address);
            $('#view_employer_details').text(employer_details);
            $('#view_primary_school').text(primary_school);
            $('#view_secondary_school').text(secondary_school);
            $('#view_juniorHS').text(junior_highschool);
            $('#view_senior_highschool').text(senior_highschool);
            $('#view_last_school_attended').text(last_school_attended);
            $('#view_last_school_name').text(lastschool_name);
            $('#view_last_school_address').text(lastschool_address);
            $('#view_course').text(course_id);
            $('#view_curriculum').text(currirulum_id);
            $('#view_student_type').text(student_type);
            $('#view_year_level').text(year_level);
            //para mag trigger yung id niya ma save
            $('#checkbox1').data('id', id);
        }
    </script> --}}

    <script>
        function viewUser(id, id_number, gender, date_of_birth, place_of_birth, nationality, religion, last_name,
            first_name, middle_name, suffix, status, section_code, curriculum_id) {

            if (status == 1) {
                $('#checkbox1').prop('checked', true);
            } else {
                $('#checkbox1').prop('checked', false);
            }

            $('#view_id_number').text(id_number);
            $('#view_gender').text(gender);
            $('#view_date_of_birth').text(date_of_birth);
            $('#view_place_of_birth').text(place_of_birth);
            $('#view_nationality').text(nationality);
            $('#view_religion').text(nationality);
            if (section_code) {
                $('#view_section_code').text(section_code);
            } else {
                $('#view_section_code').text('N/A');
            }
            var fullName = last_name + ' ' + middle_name + ' ' + first_name;
            $('#view_name').text(fullName);

            $('#checkbox1').data('id', id);

            const url = location.origin + '/superadmin/curriculum_courses/' + curriculum_id;
            curriculum_id;
            $("#curriculum_id_datatable").DataTable().destroy();
            $("#curriculum_id_datatable").DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
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
                    }
                ],
            });
        }
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('body').on('change', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('superadmin.studentapp.changeStatus') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        toastr.success(data.message);

                        if (data.admittedStudents) {

                            var StudentsAdmittedDataTable = $('#StudentsAdmitted').DataTable();
                            StudentsAdmittedDataTable.clear().rows.add(data.admittedStudents)
                                .draw();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });

        // 

        // console.log('Toggle changed. Initiating Ajax request...');
        // $.ajax({
        //     // ... your Ajax settings
        //     var admittedStudentsTable = $('#StudentsAdmitted').DataTable();
        // });
        // 
    </script> --}}
    <script>
        $(document).ready(function() {
            $('body').on('change', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                // Determine the appropriate title and confirmation text based on the current toggle state
                const title = isChecked ? 'Are you sure you want to approve this item?' :
                    'Are you sure you want to disapprove this item?';
                const buttonText = isChecked ? 'Approve' : 'Disapprove';
                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: buttonText
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('superadmin.studentapp.changeStatus') }}",
                            method: 'PUT',
                            data: {
                                status: isChecked,
                                id: id
                            },
                            success: function(data) {
                                toastr.success(data.message);

                                // Show an additional Swal alert for successful status change
                                if (data.status == 'success') {
                                    Swal.fire({
                                        title: 'Status Changed!',
                                        text: data.message,
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    } else {
                        // Reset the checkbox to its original state if the user clicks Cancel
                        $(this).prop('checked', !isChecked);
                    }
                });
            });
        });
    </script>
@endpush
