<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Create Student Applicant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Navigation Tabs -->
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item active" id="page_1">
                                <a class="page-link" onclick="toggleTabs('page_1')">Basic Personal
                                    Information</a>
                            </li>
                            <li class="page-item" id="page_2">
                                <a class="page-link" onclick="toggleTabs('page_2')">Last School
                                    Attended</a>
                            </li>
                            <li class="page-item" id="page_3">
                                <a class="page-link" onclick="toggleTabs('page_3')">Credentials Presented
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Form -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Please do not abbreviate all entries.</h4>

                                <form action="{{ route('superadmin.admit_students.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row" id="page_1_tab">
                                        <div class="col-md-2 mb-6">
                                            <label for="image" class="form-label">Student Image</label>
                                            <input type="file" name="image" id="image" class="form-control"
                                                placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                placeholder="" aria-describedby="helpId" value="{{ old('last_name') }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="middle_name" class="form-label">Middle Name</label>
                                            <input type="text" name="middle_name" id="middle_name"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('middle_name') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                placeholder="" aria-describedby="helpId"
                                                value="{{ old('first_name') }}">
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="prefix" class="form-label">Prefix</label>
                                            <select name="prefix" id="prefix" class="form-select "
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
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="" aria-describedby="helpId" value="{{ old('email') }}">
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                            <input type="date" name="date_of_birth" id="date_of_birth"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('date_of_birth') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="place_of_birth" class="form-label">Place of Birth</label>
                                            <input type="text" name="place_of_birth" id="place_of_birth"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('place_of_birth') }}">
                                        </div>


                                        <div class="col-md-2 mb-3">
                                            <label for="religion" class="form-label">Religion</label>
                                            <input type="text" name="religion" id="religion"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('religion') }}">
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="nationality" class="form-label">Nationality</label>
                                            <input type="text" name="nationality" id="nationality"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('nationality') }}">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select name="gender" id="gender" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="civil_status" class="form-label">Civil Status</label>
                                            <select name="civil_status" id="civil_status" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="widow">Widow</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="dialect" class="form-label">Dialect</label>
                                            <select name="dialect" id="dialect" class="form-select "
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
                                            <label for="contact_number" class="form-label">Contact Number</label>
                                            <input type="number" name="contact_number" id="contact_number"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('contact_number') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="complete_address" class="form-label">Complete Address</label>
                                            <input type="text" name="complete_address" id="complete_address"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('complete_address') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="fathers_fullname" class="form-label">Father's Fullname</label>
                                            <input type="text" name="fathers_fullname" id="fathers_fullname"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('fathers_fullname') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="fathers_occupation" class="form-label">Father's
                                                Occupation</label>
                                            <input type="text" name="fathers_occupation" id="fathers_occupation"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('fathers_occupation') }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="mothers_fullname" class="form-label">Mother's
                                                Fullname</label>
                                            <input type="text" name="mothers_fullname" id="mothers_fullname"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('mothers_fullname') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="mothers_occupation" class="form-label">Mother's
                                                Occupation</label>
                                            <input type="text" name="mothers_occupation" id="mothers_occupation"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('mothers_occupation') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="parents_address" class="form-label">Parent's
                                                Address</label>
                                            <input type="text" name="parents_address" id="parents_address"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('parents_address') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="parents_contact_number" class="form-label">Parent's
                                                Contact Number</label>
                                            <input type="text" name="parents_contact_number"
                                                id="parents_contact_number" class="form-control" placeholder=""
                                                aria-describedby="helpId"
                                                value="{{ old('parents_contact_number') }}">
                                        </div>
                                        <h4 class="card-title">Guardian Information.</h4>

                                        <div class="col-md-4 mb-3">
                                            <label for="guardian_fullname" class="form-label">
                                                Guardian Fullname</label>
                                            <input type="text" name="guardian_fullname" id="guardian_fullname"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('guardian_fullname') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="guardian_address" class="form-label">
                                                Guardian Address</label>
                                            <input type="text" name="guardian_address" id="guardian_address"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('guardian_address') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="guardian_address" class="form-label">
                                                Employer Details</label>
                                            <input type="text" name="employer_details" id="employer_details"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('employer_details') }}">
                                        </div>
                                        <!-- Add more tabs and fields as needed -->
                                    </div>
                                    <div class="row" id="page_2_tab">
                                        {{-- Last School Attended --}}
                                        <div class="col-md-4 mb-3">
                                            <label for="primary_school" class="form-label">Primary School
                                            </label>
                                            <input type="text" name="primary_school" id="primary_school"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('primary_school') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="secondary_school" class="form-label">Secondary School
                                            </label>
                                            <input type="text" name="secondary_school" id="secondary_school"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('secondary_school') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="junior_highschool" class="form-label">Junior High School
                                            </label>
                                            <input type="text" name="junior_highschool" id="junior_highschool"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('junior_highschool') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="senior_highschool" class="form-label">Senior High School
                                            </label>
                                            <input type="text" name="senior_highschool" id="senior_highschool"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('senior_highschool') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="last_school_attended" class="form-label">Last School Attended
                                            </label>
                                            <input type="text" name="last_school_attended"
                                                id="last_school_attended" class="form-control" placeholder=""
                                                aria-describedby="helpId" value="{{ old('last_school_attended') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lastschool_name" class="form-label">Last School Name
                                            </label>
                                            <input type="text" name="lastschool_name" id="lastschool_name"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('lastschool_name') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lastschool_address" class="form-label">Last School Address
                                            </label>
                                            <input type="text" name="lastschool_address" id="lastschool_address"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('lastschool_address') }}">
                                        </div>
                                        <h4 class="card-title">Course Details</h4>
                                        <div class="col-md-6 mb-6">
                                            <label for="course_id" class="form-label">Course</label>
                                            <select name="course_id" id="course_id" class="form-select "
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
                                            <input type="text" name="currirulum_id" id="currirulum_id"
                                                class="form-control" placeholder="" aria-describedby="helpId">
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="student_type" class="form-label">Student Type
                                            </label>
                                            <input type="text" name="student_type" id="student_type"
                                                class="form-control" placeholder="" aria-describedby="helpId"
                                                value="{{ old('student_type') }}">
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label for="year_level" class="form-label">Year Level</label>
                                            <select name="year_level" id="year_level" class="form-select "
                                                aria-describedby="helpId">
                                                <option value="">Select</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Irregular">Irregular</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row" id="page_3_tab">
                                        <div class="col-md-4 mb-6">
                                            <label for="form_138" class="form-label">Form 138
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="form138checkbox1" id="form138checkbox2" name="form_138"
                                                    value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"s
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="transcript_of_record" class="form-label">Transcipt of Record
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="torcheckbox1" id="torcheckbox2"
                                                    onchange="toggleStatus()" name="transcript_of_record"
                                                    value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="honorable_dismissal" class="form-label">Honorable Dismissal
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="hdcheckbox1" id="hdcheckbox2" onchange="toggleStatus()"
                                                    name="honorable_dismissal" value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="birth_certificate" class="form-label">Birth Certificate
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="bccheckbox1" id="bccheckbox2" onchange="toggleStatus()"
                                                    name="birth_certificate" value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="ncae_copt" class="form-label">Ncae Copy
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="ncaecheckbox1" id="ncaecheckbox2"
                                                    onchange="toggleStatus()" name="ncae_copt" value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="good_moral" class="form-label">Good Moral
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="goodmoralcheckbox1" id="goodmoralcheckbox2"
                                                    onchange="toggleStatus()" name="good_moral" value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-6">
                                            <label for="true_copy_of_grades" class="form-label">True Copy of
                                                Grades</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="tcgcheckbox1" id="tcgcheckbox1"
                                                    onchange="toggleStatus()" name="true_copy_of_grades"
                                                    value="1">
                                                <label class="form-check-label" style="font-size: 1.2em;"
                                                    for="statusToggle1"></label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label for="true_copy_of_grades" class="form-label">Police Clearance
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status"
                                                    style="transform: scale(1.5); margin-right: 10px;" type="checkbox"
                                                    data-id="policeclearance1" id="policeclearance2"
                                                    onchange="toggleStatus()" name="police_clearance" value="1">
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {
            toggleTabs("page_1");
        })

        const tabs = ['page_1', 'page_2', 'page_3'];

        function toggleTabs(currentTab) {
            tabs.forEach(tab => {
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


    {{-- add clear button --}}
@endpush
