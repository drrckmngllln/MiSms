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
                                            <img src="" style="width: 140px; height: 150px; border-radius: 10px"
                                                class="mx-auto" id="view_Studentimage">

                                            <div class="row mx-1">
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; ">
                                                        <b>Name: <span id="view_name"></span></b>
                                                    </p>
                                                </div>


                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; ">
                                                        <b>Student ID: <span id="view_student_id"></span></b>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; ">
                                                        <b>Section: <span id="view_student_section"></span></b>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; ">
                                                        <b>Enrollment Status: <span id="view_student_status"></span></b>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Email: <span id="view_email"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Date of Birth: <span id="view_dateofbirth"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Place of Birth: <span id="view_placeofbirth"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Religion: <span id="view_religion"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Nationality: <span id="view_nationality"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Gender: <span id="view_gender"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Civil Status: <span id="view_civilstatus"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold;">
                                                        Dialect: <span id="view_dialect"></span>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Contact Number: <span id="view_contactnumber"></span>
                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Complete Address: <span id="view_complete_address"></span>

                                                    </p>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Father's Fullname: <span id="view_fathers_fullname"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Father's Occupation: <span id="view_fathers_occupation"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Mother's Fullname: <span id="view_mothers_fullname"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Mother's Occupation: <span id="view_mothers_occupation"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Parents Address: <span id="view_parents_address"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Parents Contact Number: <span id="view_parents_number"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Guardian Fullname: <span id="view_guardian_fullname"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Guardian Address: <span id="view_guardian_address"></span>

                                                    </p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p style="font-size: 16px; font-weight: bold; ">
                                                        Employer Details: <span id="view_employer_details"></span>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="row">
                                        <h4 class="card-title">Last School Attended</h4>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Primary School: <span id="view_primary_school"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Secondary School: <span id="view_secondary_school"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Junior High School: <span id="view_juniorHS"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Senior High School: <span id="view_senior_highschool"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Last School Attended: <span id="view_last_school_attended"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Last School Name: <span id="view_last_school_name"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Last School Address: <span id="view_last_school_address"></span>

                                            </p>
                                        </div>
                                        <h4 class="card-title">Course Details</h4>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Course: <span id="view_course"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Currirulum: <span id="view_curriculum"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Student type: <span id="view_student_type"></span>

                                            </p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <p style="font-size: 16px; font-weight: bold; ">
                                                Year Level: <span id="view_year_level"></span>

                                            </p>
                                        </div>
                                        <h4 class="card-title">Credentials</h4>
                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_Form138a">VIEW
                                                FORM
                                                138
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_Form138i">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_TORa">VIEW
                                                Transcipt of Record
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_TORi">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_HDa">VIEW
                                                HonDis
                                                <iframe src="" style="width: 100%; height: 300px;"
                                                    id="view_HDi">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_bcerta">VIEW
                                                Bcert
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_bcerti">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_ncaea">VIEW
                                                NCAE
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_ncaei">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_goodmorala">VIEW
                                                GoodMoral
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_goddmorali">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_tcga">VIEW
                                                TCG
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_tcgi">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <a href="" target="_blank" id="view_policeclearancea">VIEW
                                                Police Clearance
                                                <iframe src="" frameborder="0"
                                                    style="width: 100%; height: 300px;" id="view_policeclearancei">
                                                </iframe>
                                            </a>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary mx-2"
                                                data-bs-dismiss="modal">Close</button>


                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="checkbox1" id="checkbox1">
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
            birth_certificate, ncae_copt, good_moral, true_copy_of_grades, police_clearance, enrollmentStatus, status,
            student_id, section_id,

        ) {
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
            $('#view_student_status').text(enrollmentStatus);
            $('#view_student_id').text(student_id);
            $('#view_student_section').text(section_id);
            //para mag trigger yung id niya ma save
            $('#checkbox1').data('id', id);
        }
    </script> --}}
    <script>
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
    </script>
@endpush
