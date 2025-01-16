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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Students</a></li>
                                <li class="breadcrumb-item active">Report</li>
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
                        <div class="card-body" id="masterlistID">
                            <h4 class="card-title"><b>Student Data Masterlist</b></h4>


                            <form id="masterlistForm">
                                <div class="row">

                                    {{-- <label for="id">Select Period:</label>
                                        <select id="school_year" name="school_year" class="form-select"
                                            aria-describedby="helpId" required>
                                            <option value="select">Select</option>
                                            @foreach ($schoolYear as $sy)
                                                <option value="{{ $sy->id }}">{{ $sy->code }}</option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select> --}}

                                    <div class="col-md-3 mb-3">
                                        <label for="course" class="form-label">School Year</label>
                                        <select name="school_year" id="school_year" class="form-select" required>
                                            <option value="" disabled selected>--Select One--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="course">Campus:</label>
                                        <select id="campus_id_masterlist" name="campus" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="all">Campus</option>
                                            @foreach ($campus as $cm)
                                                <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="id">Select All Student:</label>
                                        <select id="id_number" name="id_number" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="select">Select</option>
                                            <option value="select_all">College</option>
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <div class="form-check" style="margin-top: 30px;">
                                            <input class="form-check-input" type="checkbox" id="selectWithGrades">
                                            <label class="form-check-label" for="includeInactive">
                                                With Grades
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px" onclick="generateExcelMaterList()">Generate to
                                            Excel</button>
                                    </div>
                                </div>

                            </form>

                            <h4 class="card-title"><b>Student Data Masterlist CHED FORMAT</b></h4>


                            <form id="masterlistFormChedFormat">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="course" class="form-label">School Year</label>
                                        <select name="school_year" id="school_year_ched" class="form-select" required>
                                            <option value="" disabled selected>--Select One--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <label for="course">Campus:</label>
                                        <select id="campus_id" name="campus" class="form-select" aria-describedby="helpId">
                                            <option value="all">Campus</option>
                                            @foreach ($campus as $cm)
                                                <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="id">Select All Student:</label>
                                        <select id="id_number_ched" name="id_number" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="select">Select</option>
                                            <option value="select_all">College</option>
                                            < </select>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="id">Semester:</label>
                                        <select id="semester_ched" name="semester" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="select">Select Sem</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            < </select>
                                    </div>

                                    <div class="col-md-1 mb-3">
                                        <label for="id">Year Level:</label>
                                        <select id="yearlevel_ched" name="year_level" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="select">Select Year</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px" onclick="generateExcelMaterListChedFormat()">Generate
                                            to
                                            Excel</button>
                                    </div>
                                </div>

                            </form>
                            <form id="excelForm">
                                <div class="row">
                                    <h4 class="card-title"><b>Print Student Masterlist according to SECTION</b></h4>
                                    <div class="col-md-3 mb-3">
                                        <label for="course">Course:</label>
                                        <select id="course" name="course" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="all">All Courses</option>
                                            @foreach ($course as $cs)
                                                <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="course">Section:</label>
                                        <select id="section" name="section" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="all">All Section</option>
                                            @foreach ($section as $sc)
                                                <option value="{{ $sc->id }}">{{ $sc->section_code }}</option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="year">Year Level:</label>
                                        <select id="year_level" name="year_level" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="">All Year Levels</option>
                                            <option value="1">1st Year</option>
                                            <option value="2">2nd Year</option>
                                            <option value="3">3rd Year</option>
                                            <option value="4">4th Year</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="year">Gender:</label>
                                        <select id="gender" name="gender" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px" onclick="generateExcel()">Generate to
                                            Excel</button>
                                    </div>
                                </div>
                                {{-- <button type="button" id="previewButton">Preview Excel</button> --}}

                            </form>
                            <form id="excelFormBarangay">
                                <h4 class="card-title"><b>Student Barangay</b></h4>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="municipality" class="form-label">Select Region</label>
                                        <select id="municipality" name="regioncode" class="form-select">
                                            <option value="">Select region</option>
                                        </select>
                                        <input type="hidden" id="hidden-region-name" name="regionname">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="municipality" class="form-label">Select Province/Municipality</label>
                                        <select id="cities-province" name="municipality_code" class="form-select">
                                            <option value="">Select province</option>
                                        </select>
                                        <input type="hidden" id="hidden-municipality-name" name="municipality">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="municipality" class="form-label">Select Barangay</label>
                                        <label for="barangays" class="form-label">Province</label>
                                        <select id="barangays" name="barangay_code" class="form-select">
                                            <option value="">Select barangay</option>
                                        </select>
                                        <input type="hidden" id="hidden-barangay-name" name="barangay">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px" onclick="excelFormBarangay()">Generate to
                                            Excel</button>
                                    </div>
                                </div>
                            </form>
                            <div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <form id="excelFormOccupation">
                                            <h4 class="card-title"><b>Students Parents Work</b></h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="occupation_mother" class="form-label">Occupation</label>
                                                    <select name="occupation_mother" id="occupation_mother"
                                                        class="form-select id-number" aria-describedby="helpId">
                                                        <option value="">Select</option>
                                                        <option value="Government">Government</option>
                                                        <option value="Private">Private</option>
                                                        <option value="OFW">OFW</option>
                                                        <option value="Farmer">Farmer</option>
                                                        <option value="Housewife">Housewife</option>
                                                        <option value="Retired Government">Retired Government</option>
                                                        <option value="Retired Private">Retired Private</option>
                                                        <option value="Unemployed">Unemployed</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <button type="button"
                                                        class="btn btn-success waves-effect waves-light"
                                                        style="margin-top: 30px" onclick="excelOccupation()">Generate to
                                                        Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <form id="excelFormGender">
                                            <h4 class="card-title"><b>Select Gender</b></h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <select id="gender_id" name="gender" class="form-select">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <button type="button"
                                                        class="btn btn-success waves-effect waves-light"
                                                        style="margin-top: 30px" onclick="excelGender()">Generate to
                                                        Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="card" style="margin-top: 20px;">
                            <div class="card-body">
                                <h4 class="card-title"><b>Student With Subject/Certificate of Enrollment and CERTIFICATE OF
                                        GRADES</b></h4>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="students">Student Name:</label>
                                        <select id="studentss_id" name="id_number" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="all">All Student</option>
                                            @foreach ($Students as $student)
                                                <option value="{{ $student->id }}">{{ $student->first_name }}
                                                    {{ $student->middle_name }} {{ $student->last_name }},
                                                    {{ $student->id_number }}</option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-1">
                                        <label for="year">Semester:</label>
                                        <select id="semester_id" name="semester" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="">Select Semester</option>
                                            <option value="all">Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <label for="year">Year Level:</label>
                                        <select id="year_level_id" name="year_level" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="">Select Semester</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>

                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <label for="students">School Year:</label>
                                        <select id="schoolYearID" name="school_year" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="all">School Year</option>
                                            @foreach ($schoolYear as $sy)
                                                <option value="{{ $sy->id }}">{{ $sy->code }}
                                                </option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <label for="students">Campus:</label>
                                        <select id="campusID" name="campus_id" class="form-select"
                                            aria-describedby="helpId">
                                            <option value="all">Select Campus</option>
                                            @foreach ($campus as $cp)
                                                <option value="{{ $cp->id }}">{{ $cp->code }}
                                                </option>
                                            @endforeach
                                            <!-- Idagdag ang iba pang mga kurso dito -->
                                        </select>
                                    </div>

                                    <div class="col-md-1 mb-2">
                                        <div class="form-check" style="margin-top: 30px;">
                                            <input class="form-check-input" type="checkbox" id="selectWithGradesCOE">
                                            <label class="form-check-label" for="includeInactive">
                                                With Grades
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px" onclick="generateCOE()">Generate to PDF</button>
                                    </div>
                                </div>
                                {{-- <table id="Print-student-with-subject"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID Number</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Course</th>
                                            <th>Gender</th>
                                            <th>Year Level</th>
                                            <th>Section</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table> --}}
                                <form action="Instructor_Side">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="course" class="form-label">School Year</label>
                                            <select name="school_year" id="school_year_instructor" class="form-select"
                                                required>
                                                <option value="" disabled selected>--Select One--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="students">Instructor Name:</label>
                                            <select id="instructor_IDD" name="instructor_id" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="all">All Instructor</option>

                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Semester</label>
                                            <input type="text" class="form-control" id="semesterID" placeholder=""
                                                aria-describedby="helpId" name="semester">
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="section_id">Section:</label>
                                            <select id="sectionSelect" class="form-select" name="section_id">
                                                <option value="">Select Section</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="subjects">Subjects:</label>
                                            <select id="subjects" class="form-select" name="section_id">
                                                <option value="">Subjects</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px" onclick="generateTeacherbySection()">Generate to
                                                Excel</button>
                                        </div>
                                    </div>
                                </form>

                                <form action="IndividuaLStudents">
                                    <h4 class="card-title"><b>Student Report</b></h4>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="students">Student Name:</label>
                                            <select id="studentss_id_individual" name="id_number" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="all">All Student</option>
                                                @foreach ($Students as $student)
                                                    <option value="{{ $student->id }}">
                                                        {{ $student->first_name }}
                                                        {{ $student->middle_name }} {{ $student->last_name }},
                                                        {{ $student->id_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="course" class="form-label">School Year</label>
                                            <select name="school_year" id="school_year_individual" class="form-select"
                                                required>
                                                <option value="" disabled selected>--Select One--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Semester</label>
                                            <input type="text" class="form-control" id="semesterID_individual"
                                                placeholder="" aria-describedby="helpId" name="semester">
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <div class="form-check" style="margin-top: 30px;">
                                                <input class="form-check-input" type="checkbox"
                                                    id="selectWithGradesIdividual">
                                                <label class="form-check-label" for="includeInactive">
                                                    With Grades
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-1 mb-1">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px; margin-right: 5px;"
                                                onclick="generateIndividualStudent()">Generate</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="IndividuaLStudents">
                                    <h4 class="card-title"><b>Student View Subjects</b></h4>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="students">Student Name:</label>
                                            <select id="studentss_id_individual2" name="id_number" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="all">All Student</option>
                                                @foreach ($Students as $student)
                                                    <option value="{{ $student->id_number }}">
                                                        {{ $student->first_name }}
                                                        {{ $student->middle_name }} {{ $student->last_name }},
                                                        {{ $student->id_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="course" class="form-label">School Year</label>
                                            <select name="school_year" id="school_year_individual2" class="form-select"
                                                required>
                                                <option value="" disabled selected>--Select One--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Semester</label>
                                            <input type="text" class="form-control" id="semesterID_view"
                                                placeholder="" aria-describedby="helpId" name="semester">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="course">Course:</label>
                                            <select id="course_1" name="course" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="all">All Courses</option>
                                                @foreach ($course as $cs)
                                                    <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                                                @endforeach
                                                <!-- Idagdag ang iba pang mga kurso dito -->
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-1 d-flex align-items-center justify-content-start">
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="checkbox" id="selectAll5"
                                                    value="1" onchange="this.value = this.checked ? 1 : 0;">
                                                <label class="form-check-label" for="all">
                                                    All
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-secondary waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"
                                                id="viewSubModal">
                                                <i class="ri-eye-fill"></i>
                                            </button>
                                        </div>




                                    </div>
                                </form>

                                <form action="Assessement">
                                    <h4 class="card-title"><b>Student Assessment</b></h4>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="students">Student Name:</label>
                                            <select id="studentss_id_individual7" name="id_number" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="all">All Student</option>
                                                @foreach ($Students as $student)
                                                    <option value="{{ $student->id_number }}">
                                                        {{ $student->first_name }}
                                                        {{ $student->middle_name }} {{ $student->last_name }},
                                                        {{ $student->id_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="course" class="form-label">School Year</label>
                                            <select name="school_year" id="school_year_individual7" class="form-select"
                                                required>
                                                <option value="" disabled selected>--Select One--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <label for="">Semester</label>
                                            <input type="text" class="form-control" id="semesterID_view_7"
                                                placeholder="" aria-describedby="helpId" name="semester">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="course">Course:</label>
                                            <select id="course_7" name="course" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="all">All Courses</option>
                                                @foreach ($course as $cs)
                                                    <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px; margin-right: 5px;"
                                                onclick="generateStudentAssessment()">Generate Pdf</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@endsection
@include('Roles.Super_Administrator.studentReports.viewSub')

@push('scripts')
    <script>
        function generateExcel() {
            var section = $('#section').val();
            var course = $('#course').val();
            var yearlevel = $('#year_level').val();
            var gender = $('#gender').val();
            // console.log("testing");
            // console.log(yearlevel);
            window.location.href = "{{ route('superadmin.generate.excel') }}?course=" + course +
                "&year_level=" +
                yearlevel + "&gender=" + gender + "&section=" + section;

        }
    </script>

    <script>
        function generateExcelMaterList() {
            var idnumber = $('#id_number').val();
            var schoolYear = $('#school_year').val();
            var campus = $('#campus_id_masterlist').val();
            var withGrade = $('#selectWithGrades').is(':checked') ? 1 : 0;
            window.location.href = "{{ route('superadmin.generate.excelMaterlist') }}?id_number=" + idnumber +
                "&school_year=" + schoolYear + "&selectWithGrades=" + withGrade + "&campus_id_masterlist=" + campus;
        }
    </script>
    <script>
        function generateExcelMaterListChedFormat() {
            var idnumberched = $('#id_number_ched').val();
            var schoolYearched = $('#school_year_ched').val();
            var withGradeched = $('#selectWithGrades_ ched').is(':checked') ? 1 : 0;
            var semesterched = $('#semester_ched').val();
            var yearlevelched = $('#yearlevel_ched').val();
            var campus = $('#campus_id').val();


            window.location.href = "{{ route('superadmin.generate.excelMaterlistched') }}?id_number=" + idnumberched +
                "&school_year=" + schoolYearched + "&selectWithGrades=" + withGradeched + "&semester_ched=" + semesterched +
                "&yearlevel_ched=" + yearlevelched + "&campus_id=" + campus;
        }
    </script>
    <script>
        function excelFormBarangay() {
            var region = $('#municipality').val();
            var city = $('#cities-province').val();
            var barangay = $('#barangays').val();
            window.location.href = "{{ route('superadmin.generate.excelBarangay') }}?region=" + region +
                "&city=" + city + "&barangay=" + barangay;
        }
    </script>
    <script>
        function excelOccupation() {
            var occupation = $('#occupation_mother').val();
            window.location.href = "{{ route('superadmin.generate.excelOccupation') }}?occupation=" + occupation;
        }
    </script>
    <script>
        function excelGender() {
            var gender = $('#gender_id').val();
            window.location.href = "{{ route('superadmin.generate.excelGender') }}?gender=" + gender;
        }
    </script>
    <script>
        function generateTeacherbySection() {
            var schoolyear = $('#school_year_instructor').val();
            var instructor = $('#instructor_IDD').val();
            var semester = $('#semesterID').val();
            var section = $('#sectionSelect').val();
            var subjects = $('#subjects').val();

            window.location.href = "{{ route('superadmin.generate.IWSH') }}?instructor=" + instructor + "&semester=" +
                semester +
                "&section=" + section + "&schoolyear=" + schoolyear + "&subjects=" + subjects;
        }
    </script>
    <script>
        function generateIndividualStudent() {
            var studentName = $('#studentss_id_individual').val();
            var schoolYear = $('#school_year_individual').val();
            var semester = $('#semesterID_individual').val();
            var checkbox = $('#selectWithGradesIdividual').is(':checked') ? 1 : 0;

            window.location.href = "{{ route('superadmin.get.individualStudents') }}?studentName=" + studentName +
                "&schoolYear=" +
                schoolYear +
                "&semester=" + semester + "&checkbox=" + checkbox;
        }
    </script>

    {{-- <script>
        const data2 = {
            labels: [
                'BSIT',
                'NURSING',
                'ACCOUNTANCY'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };

        const config2 = {
            type: 'doughnut',
            data: data2,
        };


        const ctxDoughnut = document.getElementById('myDoughnutChart').getContext('2d');


        const myDoughnutChart = new Chart(ctxDoughnut, config2);
    </script> --}}
    <script>
        function generateCOE() {
            var student = $('#studentss_id').val();
            var semester = $('#semester_id').val();
            var schoolYear = $('#schoolYearID').val();
            var yearLevel = $('#year_level_id').val();
            var campus = $('#campusID').val();
            var cog = $('#selectWithGradesCOE').is(':checked') ? 1 : 0;
            // console.log(cog);
            window.location.href = "{{ route('superadmin.generate.certificateofgrades') }}" +
                "?studentss_id=" + student +
                "&semester_id=" + semester +
                "&schoolYearID=" + schoolYear +
                "&year_level_id=" + yearLevel +
                "&campusID=" + campus +
                "&selectWithGradesCOE=" + cog;
        }
    </script>
    <script>
        function generateStudentAssessment() {
            var student = $('#studentss_id_individual7').val();
            var semester = $('#semesterID_view_7').val();
            var schoolYear = $('#school_year_individual7').val();
            var course = $('#course_7').val();

            var url = "{{ route('superadmin.generate.studentAssessment') }}" +
                "?studentss_id_individual7=" + student +
                "&semesterID_view_7=" + semester +
                "&school_year_individual7=" + schoolYear +
                "&course_7=" + course;


            window.location.href = url;
        }
    </script>
    <script>
        // Ilipat mo ito sa iyong JavaScript file o script tag
        document.addEventListener('DOMContentLoaded', function() {
            // Inisyal na data para sa chart
            const data = {
                labels: [],
                datasets: [{
                    label: 'My First Dataset',
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            };


            const config = {
                type: 'doughnut',
                data: data,
            };

            // Gawa ng Chart instance
            const ctxDoughnut = document.getElementById('myDoughnutChart').getContext('2d');
            const myDoughnutChart = new Chart(ctxDoughnut, config);

            function fetchAccountChartData() {
                $.ajax({
                    url: '{{ route('superadmin.get.courseData') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {

                        myDoughnutChart.data.labels = data.labels;
                        myDoughnutChart.data.datasets[0].data = data.data;
                        myDoughnutChart.update()
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            fetchAccountChartData();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = {
                labels: ['Female', 'Male'],
                datasets: [{
                    label: 'Gender Distribution',
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'
                    ],
                    hoverOffset: 4
                }]
            };
            const config = {
                type: 'doughnut',
                data: data,
            };
            const ctxDoughnut = document.getElementById('myDoughnutChart2').getContext('2d');
            const myDoughnutChart = new Chart(ctxDoughnut, config);

            function fetchAccountChartData() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('superadmin.get.MaleFemale') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const total = response.data;
                        const maleCount = response.Male;
                        const femaleCount = response.Female;

                        myDoughnutChart.data.datasets[0].data = [femaleCount, maleCount];
                        myDoughnutChart.update();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            fetchAccountChartData();
        });
    </script>
    <script>
        //get Create Account
        $(document).ready(function() {
            $("#Print-student-with-subject").DataTable().destroy();
            $("#Print-student-with-subject").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('superadmin.get.createAccounts') }}',
                    type: 'GET',
                },
                columns: [{
                        data: 'id_number',
                        name: 'id_number'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'course',
                        name: 'course'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'year_level',
                        name: 'year_level'
                    },
                    {
                        data: 'section',
                        name: 'section'
                    }, {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
        });
    </script>
    <script>
        document.getElementById('department_idd').addEventListener('change', function() {
            var departmentSelect = document.getElementById('department_idd');
            var codeDescriptionInput = document.getElementById('codeDescription');
            var selectedOption = departmentSelect.options[departmentSelect.selectedIndex];
            var description = selectedOption.getAttribute('data-description');
            codeDescriptionInput.value = description;
        });
    </script>
    <script>
        $('#department_idd').on('change', function() {
            var departmentId = $(this).val();

            $("#subject-list-section").DataTable().destroy();
            $("#subject-list-section").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('superadmin.class.list') }}',
                    type: 'GET',
                    data: {
                        department_id: departmentId
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'descriptive_tittle',
                        name: 'descriptive_tittle'
                    }
                ],
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            instructorEdit = $('#studentss_id').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
        $(document).ready(function() {
            instructorEdit = $('#schoolYearID').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
        $(document).ready(function() {
            instructorEdit = $('#studentss_id_individual').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Populate regions in the first dropdown
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/superadmin/region',
                type: 'GET',
                success: function(response) {
                    let regionSelect = $('#municipality');
                    regionSelect.empty();
                    regionSelect.append(`<option value="">Select region</option>`);

                    response.forEach(function(region) {
                        regionSelect.append(
                            `<option value="${region.code}">${region.name}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Refresh again the page.');
                }
            });


            $('#municipality').on('change', function() {
                let selectedRegionCode = $(this).val();
                let selectedRegionName = $(this).find('option:selected').text();

                $('#hidden-region-name').val(selectedRegionName);


                $.ajax({
                    url: '/superadmin/cities-province',
                    type: 'GET',
                    data: {
                        regionCode: selectedRegionCode
                    },
                    success: function(response) {
                        let citiesProvinceSelect = $('#cities-province');
                        citiesProvinceSelect.empty(); // Clear existing options
                        citiesProvinceSelect.append(
                            `<option value="">Select province</option>`);

                        // Filter provinces based on selected regionCode
                        response.forEach(function(cityProvince) {
                            if (cityProvince.regionCode === selectedRegionCode) {
                                citiesProvinceSelect.append(
                                    `<option value="${cityProvince.code}">${cityProvince.name}</option>`
                                );
                            }
                        });
                    },
                    error: function() {
                        alert('Error fetching cities/provinces.');
                    }
                });
            });


            $('#cities-province').on('change', function() {
                let selectedMunicipalityCode = $(this).val();
                let selectedRegionCode = $('#municipality').val();
                let selectedMunicipalityName = $(this).find('option:selected').text();

                $('#hidden-municipality-name').val(selectedMunicipalityName);

                $.ajax({
                    url: '/superadmin/barangay',
                    type: 'GET',
                    data: {
                        regionCode: selectedRegionCode,
                        municipalityCode: selectedMunicipalityCode
                    },
                    success: function(response) {
                        let barangaySelect = $('#barangays');


                        barangaySelect.empty();
                        barangaySelect.append(`<option value="">Select barangay</option>`);

                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(function(barangay) {
                                console.log('Adding barangay:', barangay.name);
                                barangaySelect.append(
                                    `<option value="${barangay.code}">${barangay.name}</option>`
                                );
                            });

                        } else {
                            console.log('No barangays found or invalid response format');
                            barangaySelect.append(
                                `<option value="">No barangays found</option>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching barangays:', error);
                        console.error('Response:', xhr.responseText);
                        alert(
                            'Error fetching barangays. Please check the console for details.'
                        );
                    }
                });
            });
            $('#barangays').on('change', function() {
                let selectedBarangayName = $(this).find('option:selected').text();
                $('#hidden-barangay-name').val(selectedBarangayName);


            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#school_year_ched');
                    select.empty();
                    if (data.activeYears.length === 1) {
                        select.append('<option value="' + data.activeYears[0].id +
                            '" selected>' + data.activeYears[0].code + '</option>');
                    } else {
                        select.append(
                            '<option value="" disabled selected>--Select One--</option>'
                        );

                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('superadmin.get.activeYearInsturctor') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {


                    let schoolYearSelect = $('#school_year_instructor');
                    schoolYearSelect.empty();

                    if (data.activeYears.length === 1) {
                        schoolYearSelect.append('<option value="' + data.activeYears[0].id +
                            '" selected>' + data.activeYears[0].code + '</option>');
                    } else {
                        schoolYearSelect.append(
                            '<option value="" disabled selected>--Select One--</option>');
                        $.each(data.activeYears, function(index, schoolYear) {
                            schoolYearSelect.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    }

                    let instructorSelect = $('#instructor_IDD');
                    instructorSelect.empty();
                    instructorSelect.append('<option value="all">All Instructors</option>');


                    let instructorArray = Object.values(data.instructors);



                    if (instructorArray.length > 0) {
                        $.each(instructorArray, function(index, instructor) {
                            instructorSelect.append('<option value="' + instructor + '">' +
                                instructor + '</option>');
                        });
                    } else {
                        instructorSelect.append(
                            '<option value="" disabled selected>--No Instructors Available--</option>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years and instructors:', error);
                }
            });

            $('#school_year_instructor, #instructor_IDD, #semesterID').change(function() {

                let schoolYearId = $('#school_year_instructor').val();
                let instructorId = $('#instructor_IDD').val();
                let semester = $('#semesterID').val();

                if (schoolYearId && instructorId && semester) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('superadmin.get.sectionBySchoolYearInstructor') }}',
                        type: 'GET',
                        data: {
                            school_year_id: schoolYearId,
                            instructor_id: instructorId,
                            semester: semester
                        },
                        success: function(data) {
                            let sectionField = $('#sectionSelect');
                            sectionField.empty();

                            if (data.sections.length > 0) {
                                $.each(data.sections, function(index, section) {
                                    let sectionLabel = section.section_code + ' (' +
                                        section.subject_count + ' subjects)';
                                    sectionField.append('<option value="' + section
                                        .section_id + '">' + sectionLabel +
                                        '</option>');
                                });
                            } else {
                                sectionField.append(
                                    '<option value="" disabled>No Sections Available</option>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching sections:', error);
                        }
                    });
                }
            });

            $('#sectionSelect').change(function() {
                let sectionId = $(this).val();
                let instructorId = $('#instructor_IDD').val();

                if (sectionId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('superadmin.get.subjectbybSection') }}',
                        type: 'GET',
                        data: {
                            section_id: sectionId,
                            instructor_id: instructorId,

                        },
                        success: function(data) {
                            let subjectField = $('#subjects');
                            subjectField.empty();
                            subjectField.append('<option value="">Select Subject</option>');

                            if (data.subjects.length > 0) {
                                $.each(data.subjects, function(index, subject) {
                                    console.log(subjects);
                                    subjectField.append('<option value="' + subject
                                        .subject_id + '">' + subject.subject_name +
                                        '</option>');
                                });
                            } else {
                                subjectField.append(
                                    '<option value="" disabled>No Subjects Available</option>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching subjects:', error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#school_year_individual');
                    select.empty();

                    select.append('<option value="" disabled selected>--Select One--</option>');

                    if (data.activeYears.length > 0) {
                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    } else {
                        select.append('<option value="" disabled>No active school year found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#school_year');
                    select.empty();
                    if (data.activeYears.length === 1) {
                        select.append('<option value="' + data.activeYears[0].id +
                            '" selected>' + data.activeYears[0].code + '</option>');
                    } else {
                        select.append(
                            '<option value="" disabled selected>--Select One--</option>'
                        );

                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>
    <script>
        document.getElementById('semester_id').addEventListener('change', function() {
            const selectedValue = this.value;
            const form = this.closest('form');

            if (selectedValue === 'all') {
                // Create a temporary container for all semester values
                const semesterValues = [];
                console.log(semesterValues);

                // Get all option values except the empty and 'all' options
                Array.from(this.options).forEach(option => {
                    if (option.value && option.value !== 'all') {
                        semesterValues.push(option.value);
                    }
                });

                // If it's a form submission
                if (form) {
                    // Remove existing semester input if any
                    const existingInputs = form.querySelectorAll('input[name="semester[]"]');
                    existingInputs.forEach(input => input.remove());

                    // Create hidden inputs for each semester value
                    semesterValues.forEach(value => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'semester[]';
                        hiddenInput.value = value;
                        form.appendChild(hiddenInput);
                    });
                }

                // You can also store the values in a variable for other uses
                console.log('Selected semesters:', semesterValues);
            } else {
                // If single selection, remove any existing hidden inputs
                if (form) {
                    const existingInputs = form.querySelectorAll('input[name="semester[]"]');
                    existingInputs.forEach(input => input.remove());

                    // Add single hidden input if a specific semester is selected
                    if (selectedValue) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'semester';
                        hiddenInput.value = selectedValue;
                        form.appendChild(hiddenInput);
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#school_year_individual2');
                    select.empty();

                    select.append('<option value="" disabled selected>--Select One--</option>');

                    if (data.activeYears.length > 0) {
                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    } else {
                        select.append('<option value="" disabled>No active school year found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('superadmin.get.activeYear') }}',
                type: 'GET',
                success: function(data) {
                    let select = $('#school_year_individual7');
                    select.empty();
                    if (data.activeYears.length === 1) {
                        select.append('<option value="' + data.activeYears[0].id +
                            '" selected>' + data.activeYears[0].code + '</option>');
                    } else {
                        select.append(
                            '<option value="" disabled selected>--Select One--</option>'
                        );

                        $.each(data.activeYears, function(index, schoolYear) {
                            select.append('<option value="' + schoolYear.id + '">' +
                                schoolYear.code + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching school years:', error);
                }
            });
        });
    </script>
@endpush
