<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" id="editModal" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Student Applicant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>



                <div class="modal-body">
                    <!-- Navigation Tabs -->
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item active" id="edit_page_1">
                                <a class="page-link" onclick="toggleEditTabs('edit_page_1')">Basic
                                    Personal Information</a>
                            </li>
                            <li class="page-item" id="edit_page_2">
                                <a class="page-link" onclick="toggleEditTabs('edit_page_2')">Last
                                    School
                                    Attended</a>
                            </li>
                            <li class="page-item" id="edit_page_3">
                                <a class="page-link" onclick="toggleEditTabs('edit_page_3')">Credentials
                                    Presented</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- Form -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Please do not abbreviate all entries.</h4>
                                <form action="" id="edit_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="row" id="edit_page_1_tab">
                                        <div class="col-md-2 mb-6">
                                            <label for="image" class="form-label">Student Image</label>
                                            <input type="file" name="image" id="image" class="form-control"
                                                placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" name="last_name" id="edit_last_name"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="middle_name" class="form-label">Middle Name</label>
                                            <input type="text" name="middle_name" id="edit_middle_name"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" name="first_name" id="edit_first_name"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="prefix" class="form-label">Prefix</label>
                                            <select name="prefix" id="edit_prefix" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="Jr">Jr.</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                                <option value="III">III</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" name="email" id="edit_email" class="form-control"
                                                placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="date_of_birth" class="form-label">Date of
                                                Birth</label>
                                            <input type="date" name="date_of_birth" id="edit_date_of_birth"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="place_of_birth" class="form-label">Place of
                                                Birth</label>
                                            <input type="text" name="place_of_birth" id="edit_place_of_birth"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>


                                        <div class="col-md-2 mb-3">
                                            <label for="religion" class="form-label">Religion</label>
                                            <input type="text" name="religion" id="edit_religion"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="nationality" class="form-label">Nationality</label>
                                            <input type="text" name="nationality" id="edit_nationality"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select name="gender" id="edit_gender" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="civil_status" class="form-label">Civil Status</label>
                                            <select name="civil_status" id="edit_civil_status" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="widow">Widow</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="dialect" class="form-label">Dialect</label>
                                            <select name="dialect" id="edit_dialect" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="Ilokano">Ilokano</option>
                                                <option value="Ybanag">Ybanag</option>
                                                <option value="Itawes">Itawes</option>
                                                <option value="Isneg">Isneg</option>
                                                <option value="tagalog">Tagalog</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="contact_number" class="form-label">Contact
                                                Number</label>
                                            <input type="number" name="contact_number" id="edit_contact_number"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="complete_address" class="form-label">Complete
                                                Address</label>
                                            <input type="text" name="complete_address" id="edit_complete_address"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="fathers_fullname" class="form-label">Father's
                                                Fullname</label>
                                            <input type="text" name="fathers_fullname" id="edit_fathers_fullname"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="fathers_occupation" class="form-label">Father's
                                                Occupation</label>
                                            <input type="text" name="fathers_occupation"
                                                id="edit_fathers_occupation" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="mothers_fullname" class="form-label">Mother's
                                                Fullname</label>
                                            <input type="text" name="mothers_fullname" id="edit_mothers_fullname"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="mothers_occupation" class="form-label">Mother's
                                                Occupation</label>
                                            <input type="text" name="mothers_occupation"
                                                id="edit_mothers_occupation" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="parents_address" class="form-label">Parent's
                                                Address</label>
                                            <input type="text" name="parents_address" id="edit_parents_address"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="parents_contact_number" class="form-label">Parent's
                                                Contact Number</label>
                                            <input type="text" name="parents_contact_number"
                                                id="edit_parents_contact_number" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <h4 class="card-title">Guardian Information.</h4>

                                        <div class="col-md-4 mb-3">
                                            <label for="guardian_fullname" class="form-label">
                                                Guardian Fullname</label>
                                            <input type="text" name="guardian_fullname"
                                                id="edit_guardian_fullname" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="guardian_address" class="form-label">
                                                Guardian Address</label>
                                            <input type="text" name="guardian_address" id="edit_guardian_address"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="employer_details" class="form-label">
                                                Employer Details</label>
                                            <input type="text" name="employer_details" id="edit_employer_details"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <!-- Add more tabs and fields as needed -->
                                    </div>
                                    <div class="row" id="edit_page_2_tab">
                                        {{-- Last School Attended --}}
                                        <div class="col-md-4 mb-3">
                                            <label for="primary_school" class="form-label">Primary School
                                            </label>
                                            <input type="text" name="primary_school" id="edit_primary_school"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="secondary_school" class="form-label">Secondary School
                                            </label>
                                            <input type="text" name="secondary_school" id="edit_secondary_school"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="junior_highschool" class="form-label">Junior High
                                                School
                                            </label>
                                            <input type="text" name="junior_highschool"
                                                id="edit_junior_highschool" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="senior_highschool" class="form-label">Senior High
                                                School
                                            </label>
                                            <input type="text" name="senior_highschool"
                                                id="edit_senior_highschool" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="last_school_attended" class="form-label">Last School
                                                Attended
                                            </label>
                                            <input type="text" name="last_school_attended"
                                                id="edit_last_school_attended" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lastschool_name" class="form-label">Last School Name
                                            </label>
                                            <input type="text" name="lastschool_name" id="edit_lastschool_name"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lastschool_address" class="form-label">Last School
                                                Address
                                            </label>
                                            <input type="text" name="lastschool_address"
                                                id="edit_lastschool_address" class="form-control" placeholder=""
                                                aria-describedby="helpId">
                                        </div>
                                        <h4 class="card-title">Course Details</h4>
                                        <div class="col-md-6 mb-6">
                                            <label for="course_id" class="form-label">Course</label>
                                            <select name="course_id" id="edit_course_id" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="currirulum_id" class="form-label">Curriculum ID
                                            </label>
                                            <input type="text" name="currirulum_id" id="edit_currirulum_id"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label for="student_type" class="form-label">Student Type
                                            </label>
                                            <input type="text" name="student_type" id="edit_student_type"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label for="year_level" class="form-label">Year Level</label>
                                            <select name="year_level" id="edit_year_level" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Irregular">Irregular</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row" id="edit_page_3_tab">
                                        <div class="col-md-4 mb-6">
                                            <label for="form_138" class="form-label">Form 138
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="form138checkbox1" id="form138checkbox1" name="form_138">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="form138checkbox1"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="transcript_of_record" class="form-label">Transcipt of Record
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="torcheckbox1" id="torcheckbox1"
                                                    onchange="toggleStatus()" name="transcript_of_record">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="honorable_dismissal" class="form-label">Honorable Dismissal
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="hdcheckbox1" id="hdcheckbox1" onchange="toggleStatus()"
                                                    name="honorable_dismissal">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="birth_certificate" class="form-label">Birth Certificate
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="bccheckbox1" id="bccheckbox1" onchange="toggleStatus()"
                                                    name="birth_certificate">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="ncae_copt" class="form-label">Ncae Copy
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="ncaecheckbox1" id="ncaecheckbox1"
                                                    onchange="toggleStatus()" name="ncae_copt">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="good_moral" class="form-label">Good Moral
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="goodmoralcheckbox1" id="goodmoralcheckbox1"
                                                    onchange="toggleStatus()" name="good_moral">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>


                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="true_copy_of_grades" class="form-label">True Copy of Grades
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input "
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="tcgcheckbox1" id="tcgcheckbox1"
                                                    onchange="toggleStatus()" name="true_copy_of_grades">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="true_copy_of_grades" class="form-label">Police Clearance
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="policeclearance1" id="policeclearance1"
                                                    onchange="toggleStatus()" name="police_clearance">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light ">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@push('scripts')
    <script>
        $(document).ready(() => {
            toggleEditTabs("edit_page_1");
        })
        const editTabs = ['edit_page_1', 'edit_page_2', 'edit_page_3'];

        function toggleEditTabs(currentTab) {
            editTabs.forEach(tab => {
                const id = "#" + tab;
                const tab_id = id + "_tab";
                if (tab == currentTab) {
                    const add_active = document.getElementById(tab);
                    add_active.classList.add("active");
                    $(tab_id).show();
                } else {
                    const remove_active = document.getElementById(tab);
                    remove_active.classList.remove("active");
                    $(tab_id).hide();
                }
            });
        }
    </script>
    <script>
        function editStudents(id, first_name, middle_name, last_name, prefix, email, date_of_birth, place_of_birth,
            religion,
            nationality, gender, civil_status, dialect, contact_number, complete_address, fathers_fullname,
            fathers_occupation, mothers_fullname, mothers_occupation, parents_address, parents_contact_number,
            guardian_fullname, guardian_address, employer_details, primary_school, secondary_school, junior_highschool,
            senior_highschool, last_school_attended, lastschool_name, lastschool_address, course_id, currirulum_id,
            student_type, year_level, fullname, form_138, transcript_of_record, honorable_dismissal, birth_certificate,
            ncae_copt, good_moral, true_copy_of_grades, police_clearance, image, status) {
            $("#edit_id").val(id);
            // console.log('testing');

            // page 1
            $('#edit_first_name').val(first_name);
            $('#edit_middle_name').val(middle_name);
            $('#edit_last_name').val(last_name);
            $('#edit_prefix').val(prefix);
            $('#edit_email').val(email);
            $('#edit_date_of_birth').val(date_of_birth);
            $('#edit_place_of_birth').val(place_of_birth);
            $('#edit_religion').val(religion);
            $('#edit_nationality').val(nationality);
            $('#edit_gender').val(gender);
            $('#edit_civil_status').val(civil_status);
            $('#edit_dialect').val(dialect);
            $('#edit_contact_number').val(contact_number);
            $('#edit_complete_address').val(complete_address);
            $('#edit_fathers_fullname').val(fathers_fullname);
            $('#edit_fathers_occupation').val(fathers_occupation);
            $('#edit_mothers_fullname').val(mothers_fullname);
            $('#edit_mothers_occupation').val(mothers_occupation);
            $('#edit_parents_address').val(parents_address);
            $('#edit_parents_contact_number').val(parents_contact_number);
            $('#edit_guardian_fullname').val(guardian_fullname);
            $('#edit_guardian_address').val(guardian_address);
            $('#edit_employer_details').val(employer_details);

            // page 2
            $('#edit_primary_school').val(primary_school);
            $('#edit_secondary_school').val(secondary_school);
            $('#edit_junior_highschool').val(junior_highschool);
            $('#edit_senior_highschool').val(senior_highschool);
            $('#edit_last_school_attended').val(last_school_attended);
            $('#edit_lastschool_name').val(lastschool_name);
            $('#edit_lastschool_address').val(lastschool_address);
            $('#edit_course_id').val(course_id);
            $('#edit_currirulum_id').val(currirulum_id);
            $('#edit_student_type').val(student_type);
            $('#edit_year_level').val(year_level);

            if (form_138 == 1) {
                $('#form138checkbox1').prop('checked', true);

            } else {
                $('#form138checkbox1').prop('checked', false);
            }

            if (transcript_of_record == 1) {
                $('#torcheckbox1').prop('checked', true);
            } else {
                $('#torcheckbox1').prop('checked', false);
            }
            if (honorable_dismissal == 1) {
                $('#hdcheckbox1').prop('checked', true);
            } else {
                $('#hdcheckbox1').prop('checked', false);
            }
            if (birth_certificate == 1) {
                $('#bccheckbox1').prop('checked', true);
            } else {
                $('#bccheckbox1').prop('checked', false);
            }
            if (ncae_copt == 1) {
                $('#ncaecheckbox1').prop('checked', true);
            } else {
                $('#ncaecheckbox1').prop('checked', false);
            }
            if (good_moral == 1) {
                $('#goodmoralcheckbox1').prop('checked', true);
            } else {
                $('#goodmoralcheckbox1').prop('checked', false);
            }
            if (true_copy_of_grades == 1) {
                $('#tcgcheckbox1').prop('checked', true);
            } else {
                $('#tcgcheckbox1').prop('checked', false);
            }


            if (police_clearance == 1) {
                $('#policeclearance1').prop('checked', true);
            } else {
                $('#policeclearance1').prop('checked', false);
            }

            $('#form138checkbox1').data('id', id);

            $("#edit_form").attr('action', window.location.href + '/' + id);



        }
    </script>
    <script></script>
@endpush
