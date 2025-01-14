<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\ActivityLogsController;
use App\Http\Controllers\Backend\AddDetailsController;
use App\Http\Controllers\Backend\AdmissionController;
use App\Http\Controllers\Backend\AdmittedStudentsController;
use App\Http\Controllers\Backend\CampusController;
use App\Http\Controllers\Backend\CancelEnrollementController;
use App\Http\Controllers\Backend\ClasslistController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\CreateAccountController;
use App\Http\Controllers\Backend\CreateUserController;
use App\Http\Controllers\Backend\CurriculumCoursesController;
use App\Http\Controllers\Backend\CurriculumSubjectController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\DiscountController;
use App\Http\Controllers\Backend\EnrolledStudents;
use App\Http\Controllers\Backend\FeeCollectionController;
use App\Http\Controllers\Backend\FeesCategoryController;
use App\Http\Controllers\Backend\FeeSummaries;
use App\Http\Controllers\Backend\FreeTypeController;
use App\Http\Controllers\Backend\FullPackageController;
use App\Http\Controllers\Backend\Functionality\Offerings\CurriculumController;
use App\Http\Controllers\Backend\GradesInternalDataController;
use App\Http\Controllers\Backend\HighSchoolController;
use App\Http\Controllers\Backend\ImportStudentList;
use App\Http\Controllers\Backend\ImportSubjects;
use App\Http\Controllers\Backend\InputGradeController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\LaboratoryController;
use App\Http\Controllers\Backend\LevelController;
use App\Http\Controllers\Backend\MasterListController;
use App\Http\Controllers\Backend\MiscFeeController;
use App\Http\Controllers\Backend\MunicipalityController;
use App\Http\Controllers\Backend\NonAssessedController;
use App\Http\Controllers\Backend\OtherFeesController;
use App\Http\Controllers\Backend\PdfStudentAssessmentController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PrintReciptController;
use App\Http\Controllers\Backend\PrintStudentSubject;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SchoolYearController;
use App\Http\Controllers\Backend\SectionController;
use App\Http\Controllers\Backend\SectionSubjectController;
use App\Http\Controllers\Backend\StatementofAccountController;
use App\Http\Controllers\Backend\StatusController;
use App\Http\Controllers\Backend\StudentapplicantController;
use App\Http\Controllers\Backend\StudentDiscount;
use App\Http\Controllers\Backend\StudentInfo;
use App\Http\Controllers\Backend\StudentInfoController;
use App\Http\Controllers\Backend\StudentSubjectController;
use App\Http\Controllers\Backend\SubjectController;
use App\Http\Controllers\Backend\SuperAdminController;
use App\Http\Controllers\Backend\TuitionFeeController;
use App\Http\Controllers\Backend\ViewPdfController;
use App\Http\Controllers\ProfileController;
use App\Livewire\LaboratoryCreate;
use App\Models\adddetails;
use App\Models\AdmittedStudents;
use App\Models\CurriculumSubject;
use App\Models\EnrolledStudent;
use App\Models\Level;
use App\Models\StudentApplicant;
use Database\Seeders\AdminSeeder;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;
use Psy\SuperglobalsEnv;
use Spatie\Permission\Contracts\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
//StudentInformation Frontend
// Route::get('/studentInformation', [StudentInfoController::class, 'studentInformation'])->name('student.information');
// Route::post('/studentInformation', [StudentInfoController::class, 'saveStudentInfo'])->name('studentSave.info');
// Route::get('/getTotalAssessmentEachStudent/{id_number}', [StatementofAccountController::class, 'getTotalAssessment'])->name('get.total');

Route::get('/studentinfo', [StudentInfo::class, 'studentinfo'])->name('student.info');

Route::post('/student', [StudentInfo::class, 'student'])->name('student.save');

// Route::resource('student_admission', AdmissionController::class);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::group([
        'middleware' => ['role:Super_Administrator'],
    ], function () {});
});
Route::post('/login', [AuthenticatedSessionController::class, 'login'])
    ->middleware(['web', 'guest', 'turnstile'])
    ->name('login');
Route::post('/addStudentSubject/{subject_id}', [StudentSubjectController::class, 'addSubjectWithComputation'])->name('add.StudentSubject');

Route::delete('/delete_subject/{id}', [StudentSubjectController::class, 'deleteSubject'])->name('delete.subject');




//view pdf controller
Route::get('/view-pdf', [ViewPdfController::class, 'viewPdf'])->name('view-pdf');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:Super_Administrator'])->group(function () {
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            // Super Admin Dashboard
            Route::get('/', [SuperAdminController::class, 'superAdminDashboard'])->name('sadmindashboard');
            // Roles and Permissions

            Route::post('/roles/{role}/permissions', [RolesController::class, 'givePermission'])->name('roles.permissions');
            Route::delete('/roles/{role}/permissions/{permission}', [RolesController::class, 'revokePermission'])->name('roles.permissions.revoke');
            Route::resource('/role', RolesController::class);
            Route::resource('/permission', PermissionController::class);

            Route::get('addpermission', [RolesController::class, 'addPermissionsToRoles'])->name('permission.roles');

            //givepermissiontorole
            Route::put('/rolesPermission/{role}', [RolesController::class, 'givePermissiontoRole'])->name('roles.givepermission');


            // Student Applicant
            //change status for approval of students

            Route::get('totalunits/by_studentsapplicant/{curriculum_id}', [StudentapplicantController::class, 'total_units'])->name('total.units');
            Route::get('get-last-id', [StudentapplicantController::class, 'getLastId'])->name('studentapp.getLastId');

            Route::resource('studentapplicant', StudentapplicantController::class);

            // Curriculum route
            Route::resource('curriculum', CurriculumController::class);
            Route::get('curriculum/by_course/{course_id}', [CurriculumController::class, 'getCurriculumByCourse']);

            // Campus
            Route::resource('campuses', CampusController::class);
            // Courses
            Route::resource('courses', CourseController::class);
            // Departments
            Route::resource('departments', DepartmentController::class);

            // Levels Route
            Route::resource('levels', LevelController::class);
            // Subjects Route
            Route::post('add-details', [AddDetailsController::class, 'add_details_on_sucjects'])->name('add.details');
            Route::resource('subjects', SubjectController::class);
            // Curriculum Subjects Route

            Route::get('curriculum/curriculum_semester/{semester_id}', [CurriculumSubjectController::class, 'getSemesterbByCurriculum']);
            Route::resource('curriculum_subjects', CurriculumSubjectController::class);
            // Admitted Student

            // Sections
            Route::resource('sections', SectionController::class);
            Route::get('section/by_course/{course_id}', [SectionController::class, 'getSectionByCourse']);

            Route::put('admitstudentchangestatus', [AdmittedStudentsController::class, 'changeStatus'])->name('admitstudent.changeStatus');
            Route::resource('admit_students', AdmittedStudentsController::class);

            Route::get('/curriculum_courses/{curriculum_id}/{year_level}/{semester_id}/{section_code}', [CurriculumCoursesController::class, 'getCoursesByCurriculum'])->name('superadmin.curriculum_courses.get_courses');
            // Route::get('/curriculum_HS/{curriculum_id}/{year_level}/{semester_id}/{section_code}', [CurriculumCoursesController::class, 'getCurriculumHs'])->name('get.curriculumHS');

            //enrolled Student
            //
            Route::get('/semester_subject/{semester_id}/{curriculum_id}/{year_level}/{section_code}', [SubjectController::class, 'getSubjectBySemester'])->name('subject_section.get_semester');

            Route::post('enrolled-students', [EnrolledStudents::class, 'enrolled_students'])->name('enrolled.students');
            Route::get('getSectionName', [EnrolledStudents::class, 'get_Section'])->name('enrolled.section');

            Route::resource('feesCategory', FeesCategoryController::class);

            //feetype
            Route::get('course/by_feetype/{course_id}', [FreeTypeController::class, 'get_feetype'])->name('get.feetype');

            Route::resource('feetype', FreeTypeController::class);

            //tuition fees
            Route::resource('tuition_fees', TuitionFeeController::class);
            //Misc Fee
            Route::resource('misc_fees', MiscFeeController::class);
            //section subject
            Route::resource('section_subject', SectionSubjectController::class);

            Route::resource('instructor', InstructorController::class);

            //import excel
            Route::resource('importsubjects', ImportSubjects::class);

            //other fees
            Route::resource('otherfees', OtherFeesController::class);

            //School Year
            Route::resource('school_year', SchoolYearController::class);

            //Discount
            Route::resource('discount', DiscountController::class);

            //create account
            Route::resource('create_account', CreateAccountController::class);

            Route::get('get-last-id', [CreateAccountController::class, 'getLastId'])->name('studentapp.getLastId');
            Route::post('approval/{id}', [CreateAccountController::class, 'changeStatus'])->name('studentapp.changeStatus');
            // Route::get('/section_subject/{section_id}/{curriculum_id}/{year_level}', [CreateAccountController::class, 'getSectionWithSubject'])->name('curriculum.get_section');
            //get curriculum by section
            Route::get('curriculum/curriculum_section/{curriculum_id}', [CreateAccountController::class, 'getSectionByCurriculum']);

            //save student subject
            Route::post('student_subject', [CreateAccountController::class, 'studentSub'])->name('student.subjectSave');
            //get subject in curriculum subject
            Route::get('/curriculum_courses/{curriculum_id}/{year_level}/{semester_id}', [CurriculumCoursesController::class, 'getCoursesByCurriculum'])->name('superadmin.curriculum_courses.get_courses');

            //accounting route purposes
            Route::post('create_account/fees', [CreateAccountController::class, 'fees']);

            Route::post('student_fees', [CreateAccountController::class, 'studentFee'])->name('student.feeSave');

            //get subject // routes/web.php

            Route::post('/curriculum_subjectss', [CreateAccountController::class, 'get'])->name('curriculum.getSubjectss');
            //view Student Subject
            Route::get('/view_student_subject', [CreateAccountController::class, 'getSubjectEnrolled'])->name('your-datatable-endpoint');

            Route::get('/calculate_units/{id_number}', [CreateAccountController::class, 'calculateUnits']);

            // Student Discount
            Route::get('student_discount/save', [StudentDiscount::class, 'studentDiscountIndex'])->name('student.discount');


            //Add Students on Discount
            Route::get('/add_student_discount', [StudentDiscount::class, 'getStudents'])->name('students.Adddiscounts');
            Route::get('/select_student_discount', [StudentDiscount::class, 'selectStudents'])->name('students.Selectdiscounts');
            Route::post('/save-discount', [StudentDiscount::class, 'saveStudentDiscount'])->name('save.discount');
            //get students discounts on database using yajra
            Route::get('/get_student_discount', [StudentDiscount::class, 'getStudentsDiscount'])->name('students.Getdiscounts');
            Route::delete('/delete_save_discount/{id}', [StudentDiscount::class, 'deleteDiscount'])->name('deleteSaved.Discount');
            //fee collectio
            Route::resource('fee_collection', FeeCollectionController::class);
            //fee Collection Select Student
            Route::get('/feecollection_select', [FeeCollectionController::class, 'feeCollectionselectStudents'])->name('feeCollection.select');
            // Route::get('/student-details/{id}', [FeeCollectionController::class, 'showStudentDetails']);
            //fee Summaries
            Route::post('fee_summaries', [FeeSummaries::class, 'feesummaries'])->name('save.FeeSummaries');
            Route::get('fee_summaries_all', [FeeSummaries::class, 'fee_summaries_all'])->name('FeeSummaries.all');


            //PDF StudentAssessment Print
            Route::get('/student-print-assessment/{id_number}', [PdfStudentAssessmentController::class, 'generateStudentAssessment'])->name('pdf.printStudentAssessment');
            //get school year id
            Route::get('/getSemester/{semester}', [CreateAccountController::class, 'getsemester']);

            //get Curriculum base on course
            Route::get('/getCurriculum', [CreateAccountController::class, 'getCurriculum'])->name('get.CurrculumCourses');

            //laboratory set up
            Route::resource('laboratory', LaboratoryController::class);

            Route::get('likedSubject', [LaboratoryController::class, 'likedSubject'])->name('get.LikedSubeject');
            Route::post('/saveLinkedSubject', [LaboratoryController::class, 'saveLinkedSubject'])->name('save.linkedSubject');

            Route::get('getLinkedSubjects/{labId}', [LaboratoryController::class, 'likedSubjectview']);

            //get fee type and computation
            Route::get('getFeeTypeComputation/{id_number}', [FeeCollectionController::class, 'getfeetypecomputation']);
            //get fee summaries based on id_number
            Route::get('getFeesummaries/{id_number}', [FeeCollectionController::class, 'getFeeSummariesOnIdnumber']);

            Route::resource('StudentSubject', StudentSubjectController::class);

            Route::delete('/delete_subject/{id}', [StudentSubjectController::class, 'deleteSubject'])->name('delete.subject');

            Route::get('addSubject_view', [CreateAccountController::class, 'addSubjectView'])->name('addSubject.view');

            Route::resource('create_user', CreateUserController::class);

            Route::get('activityLogs', [ActivityLogsController::class, 'index'])->name('activityLogs.index');

            //testing for pringting purposes
            Route::get('printRecipt/{id}', [PrintReciptController::class, 'printrecipt']);

            //Get Enrolled Student
            Route::get('report', [ReportController::class, 'studentrepots'])->name('student.report');
            Route::get('/generate-excel', [ReportController::class, 'generateExcel'])->name('generate.excel');
            Route::get('/generate-excel-masterlist', [MasterListController::class, 'generateExcelMasterList'])->name('generate.excelMaterlist');

            // Route::get('/preview-excel', ReportController::class, 'previewExcel')->name('preview.excel');

            //get how may courses
            Route::get('/get-course-data', [CourseController::class, 'getCourseData'])->name('get.courseData');
            Route::get('/get-maleandfemale-data', [CourseController::class, 'getMaleFemale'])->name('get.MaleFemale');
            Route::get('/createAccount', [CourseController::class, 'createaccount'])->name('get.createAccounts');
            //Print Student With Subject
            Route::get('/PrintStudentSubject/{id}', [PrintStudentSubject::class, 'printStudentSubject'])->name('generate.printStudentSubject');

            //Cancel Enrollment
            Route::delete('/cancel_enrollment', [CancelEnrollementController::class, 'cancelEnrollment'])->name('cancel.enrollment');

            Route::get('studentInternalData', [GradesInternalDataController::class, 'getStudentSubjects'])->name('student.internalData');

            //Input Grade
            Route::post('input_grade', [InputGradeController::class, 'inputGrade'])->name('input.grade');

            Route::post('update_grade', [InputGradeController::class, 'updateGrade'])->name('update.grade');

            //classlist
            Route::get('/classlist', [ClasslistController::class, 'classList'])->name('class.list');

            //delete curriculum_subject
            Route::delete('/delete_curriculum_subject/{id}', [CurriculumSubjectController::class, 'deleteCurriculumSubject'])->name('delete.CSubject');

            //edit adddetails
            Route::put('/editDetails/{id?}', [SectionController::class, 'updateDetails'])->name('update.details');

            Route::put('/editCurriculumSubject/{id?}', [CurriculumSubjectController::class, 'updateCurriculumSubject'])->name('update.CurriculumSubject');

            //id number auto increament
            Route::get('/get_last_id_number', [CreateAccountController::class, 'getLastIDNumber'])->name('get.LastIdNumber');

            //statement of account
            Route::get('/statement_of_account', [StatementofAccountController::class, 'soa'])->name('statementof.account');
            Route::get('getFeesummariessoa/', [StatementofAccountController::class, 'getFeeSummaries']);

            //non assessed
            Route::get('/non_assessed', [NonAssessedController::class, 'nonAssessed'])->name('non.assessed');
            Route::post('/non_assessed', [NonAssessedController::class, 'saveNonAssessed'])->name('save.NonAssessed');
            Route::get('/get_non_assessed', [NonAssessedController::class, 'get_non_assessed']);
            //get last or_number
            Route::get('/get_last_ornumber', [CreateAccountController::class, 'getLastORNumber'])->name('get.LastorNumber');

            Route::get('/get_role_id', [CreateAccountController::class, 'getRoleID'])->name('get.RoleId');

            //label on create account index
            Route::get('/get-semester/{id}', [SchoolYearController::class, 'getSemester'])->name('get.semesteronSchoolYear');
            //save status on interssesion
            Route::post('studentIntersession/{id}', [CreateAccountController::class, 'changeStatusIntersssion'])->name('studentapp.changeStatusIntersession');

            //get Subject With Instructors and etc
            Route::get('/get_subject_with_instructor', [SectionController::class, 'getSubjectWithInstructor'])->name('get.subjectWithInstructor');

            Route::post('/addStudentSubject/{subject_id}', [StudentSubjectController::class, 'addSubjectWithComputation'])->name('add.StudentSubject');
            //delete all subject
            Route::post('/curriculum/subjects/delete', [CurriculumSubjectController::class, 'deleteSubjects'])->name('curriculum.alldeleteSubjects');
            //high school
            Route::resource('highSchool', HighSchoolController::class);

            //StudentSection
            Route::get('/studentSection', [SectionController::class, 'getStudentSection'])->name('get.studentSection');
            //save student section with subject
            Route::post('/sectionSubject', [SectionController::class, 'getSectionSub'])->name('save.sectionSubject');
            //datatable
            Route::get('/getSectionSubject/{section_code}/{year_level}/{semester_id}/{school_year_id}', [SectionController::class, 'getSectionSubs'])->name('get.SectionSubject');
            Route::post('/addSectionSubject', [SectionController::class, 'addSectionSub'])->name('save.addSectionSubject');

            Route::delete('/deleteSubject/{id}', [SectionController::class, 'deleteSubject'])->name('delete.Subject');
            Route::get('/curriculum_courses/{year_level}/{section_id}/{semester_id}/', [CurriculumCoursesController::class, 'getCoursesByCurriculum'])->name('superadmin.curriculum_courses.get_courses');

            Route::post('approvalHighSchool/{id}', [HighSchoolController::class, 'changeStatus'])->name('studentappHS.changeStatusHighSchool');
            Route::get('/getCurriculumHighSchool', [HighSchoolController::class, 'getCurriculumHS'])->name('get.CurrculumCoursesHS');
            Route::post('student_subject_highSchhol', [HighSchoolController::class, 'studentSubHs'])->name('student.subjectSaveHs');

            //accounting for HS
            Route::post('hs/fees', [HighSchoolController::class, 'fees'])->name('get.accountingHS');

            //Certificate of Grades
            Route::get('/generateCOE', [ReportController::class, 'generateCertofGrade'])->name('generate.certificateofgrades');


            //sectionHandledByInstructor
            Route::get('/sectionHandled', [SectionController::class, 'instructorHandles'])->name('datatable-endpoint');

            Route::get('/SectionController/{id}', [SectionController::class, 'secSub'])->name('sec.sub');
            //sectionWithSubject
            Route::get('/SecWithSub', [SectionController::class, 'secwithSub'])->name('secwith.sub');
            Route::get('/SectionController/enrolledStudentsSubject/{id}', [SectionController::class, 'studentsSubjectEnrolled'])->name('students.enrolledSub');

            Route::get('/enrolledStudentsSubject', [SectionController::class, 'enrolledStudentonSubject'])->name('ess.sub');
            //save subject Grade
            Route::post('/saveGrade', [SectionController::class, 'savegrade'])->name('save.grade');

            //add additional fees
            Route::post('/addOtherFees', [OtherFeesController::class, 'addotherFees'])->name('store.AddtionalFees');
            //add dates on section
            Route::post('/SectionDate', [SectionController::class, 'adddates'])->name('add.date');


            //get course id and display department
            Route::get('/courseIDwithDepartment', [DepartmentController::class, 'getDepartmentByCourse'])->name('courseId.department');
            Route::get('/generateExcelBarangay', [ReportController::class, 'generateExcelBarangay'])->name('generate.excelBarangay');
            Route::get('/generateExcelOccupation', [ReportController::class, 'generateExcelOccupation'])->name('generate.excelOccupation');
            Route::get('/generateExcelGender', [ReportController::class, 'generateExcelGender'])->name('generate.excelGender');

            Route::get('/region', [MunicipalityController::class, 'municipalities'])->name('municipalities.index');
            Route::get('/cities-province', [MunicipalityController::class, 'citiesProvince'])->name('citiesProvince.index');
            Route::get('/barangay', [MunicipalityController::class, 'barangay'])->name('barangay.index');

            //adding subject
            Route::get('/addSubjectenrolledstudent', [CreateAccountController::class, 'addSubjectenrolledstudent'])->name('add.subjectEnrollstudent');
            Route::get('/getActiveYear', [SchoolYearController::class, 'getActiveYear'])->name('get.activeYear');

            Route::get('/chedFormat', [MasterListController::class, 'chedMasterList'])->name('generate.excelMaterlistched');

            Route::post('/getSectionsubject', [SectionController::class, 'sectionSubject'])->name('get.sectionSubjects');

            Route::get('/get-section-id', [SectionController::class, 'getSectionId'])->name('get.section-idwithinsid');

            Route::get('/getInstructorWithSectionHandled', [SectionController::class, 'getIWSH'])->name('generate.IWSH');
            Route::get('/getActiveYearInstructor', [SchoolYearController::class, 'getActiveYearins'])->name('get.activeYearInsturctor');
            Route::get('/sectionBySchoolYearInstructor', [SchoolYearController::class, 'getSectionBySchoolYearInstructor'])->name('get.sectionBySchoolYearInstructor');

            Route::get('/sectionBySchoolYearInstructor/individualStudents', [SchoolYearController::class, 'individualStudents'])->name('get.individualStudents');
            //subjects
            Route::get('/getinstructorSubject', [InstructorController::class, 'getinsSub'])->name('get.instructorSubject');

            //get subject according to section
            Route::get('/getinstructorSubject/getsubjectby section', [SectionController::class, 'getsubsec'])->name('get.subjectbybSection');

            Route::post('/activeallSchoolYear', [SchoolYearController::class, 'activedeactiveschoolyear'])->name('store.allActiveschoolyear');

            Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');


            Route::resource('fullPackage', FullPackageController::class);

            Route::get('/getTotalAssessmentEachStudent/{id_number}', [StatementofAccountController::class, 'getTotalAssessment'])->name('get.total');


            Route::get('/fee-summary/latest-or-number', [FullPackageController::class, 'getLatestOrNumber']);

            Route::resource('studentList', ImportStudentList::class);

            //accounting part add other fees
            Route::post('/addotherfees', [FullPackageController::class, 'addOtherFees'])->name('add.otherFeestoStudent');
        });
    });
    //registrar side
    Route::group(['middleware' => ['role:Registrar|Super_Administrator|High School Department Super Administrator|Registrar Window']], function () {
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            // Route::get('/', [SuperAdminController::class, 'superAdminDashboard'])->name('sadmindashboard');
            Route::resource('campuses', CampusController::class);
            Route::resource('departments', DepartmentController::class);
            Route::resource('school_year', SchoolYearController::class);
            Route::resource('instructor', InstructorController::class);
            Route::resource('curriculum', CurriculumController::class);
            Route::get('curriculum/by_course/{course_id}', [CurriculumController::class, 'getCurriculumByCourse']);
            // Route::get('curriculum/curriculum_semester/{semester_id}', [CurriculumSubjectController::class, 'getSemesterbByCurriculum']);
            Route::resource('curriculum_subjects', CurriculumSubjectController::class);
            Route::get('/curriculum_subjects', [CreateAccountController::class, 'get'])->name('curriculum.getSubjects');

            Route::resource('courses', CourseController::class);
            Route::resource('sections', SectionController::class);
            Route::get('section/by_course/{course_id}', [SectionController::class, 'getSectionByCourse']);
            Route::get('curriculum/curriculum_semester/{semester_id}', [CurriculumSubjectController::class, 'getSemesterbByCurriculum']);
            Route::get('/semester_subject/{semester}/{curriculum_id}/{year_level}/{section_code}', [SubjectController::class, 'getSubjectBySemester'])->name('subject_section.get_semester');
            Route::post('/add-details/{id}', [AddDetailsController::class, 'add_details_on_sucjects'])->name('add.details');



            Route::get('report', [ReportController::class, 'studentrepots'])->name('student.report');
            Route::get('/generate-excel', [ReportController::class, 'generateExcel'])->name('generate.excel');
            Route::get('/generate-excel-masterlist', [MasterListController::class, 'generateExcelMasterList'])->name('generate.excelMaterlist');

            Route::get('/createAccount', [CourseController::class, 'createaccount'])->name('get.createAccounts');
            Route::get('/get-course-data', [CourseController::class, 'getCourseData'])->name('get.courseData');
            Route::get('/get-maleandfemale-data', [CourseController::class, 'getMaleFemale'])->name('get.MaleFemale');
            Route::get('/createAccount', [CourseController::class, 'createaccount'])->name('get.createAccounts');

            Route::get('/PrintStudentSubject/{id}', [PrintStudentSubject::class, 'printStudentSubject'])->name('generate.printStudentSubject');

            //registrar side
            Route::resource('create_account', CreateAccountController::class);
            Route::get('/getCurriculum', [CreateAccountController::class, 'getCurriculum'])->name('get.CurrculumCourses');
            Route::post('approval/{id}', [CreateAccountController::class, 'changeStatus'])->name('studentapp.changeStatus');
            Route::get('curriculum/curriculum_section/{curriculum_id}', [CreateAccountController::class, 'getSectionByCurriculum']);
            Route::post('student_subject', [CreateAccountController::class, 'studentSub'])->name('student.subjectSave');
            Route::get('/curriculum_courses/{year_level}/{section_id}/{semester_id}/', [CurriculumCoursesController::class, 'getCoursesByCurriculum'])->name('superadmin.curriculum_courses.get_courses');
            Route::get('/calculate_units/{id_number}/{semester}', [CreateAccountController::class, 'calculateUnits']);
            Route::get('/view_student_subject', [CreateAccountController::class, 'getSubjectEnrolled'])->name('your-datatable-endpoint');
            Route::put('/editDetails/{id?}', [SectionController::class, 'updateDetails'])->name('update.details');

            Route::post('studentIntersession/{id}', [CreateAccountController::class, 'changeStatusIntersssion'])->name('studentapp.changeStatusIntersession');
            Route::put('/editCurriculumSubject/{id?}', [CurriculumSubjectController::class, 'updateCurriculumSubject'])->name('update.CurriculumSubject');
            Route::delete('/delete_subject/{id}', [StudentSubjectController::class, 'deleteSubject'])->name('delete.subject');


            Route::get('/view_student_subject', [CreateAccountController::class, 'getSubjectEnrolled'])->name('your-datatable-endpoint');

            Route::resource('highSchool', HighSchoolController::class);
            Route::post('approvalHighSchool/{id}', [HighSchoolController::class, 'changeStatus'])->name('studentappHS.changeStatusHighSchool');
            Route::get('/getCurriculumHighSchool', [HighSchoolController::class, 'getCurriculumHS'])->name('get.CurrculumCoursesHS');
            Route::post('student_subject_highSchhol', [HighSchoolController::class, 'studentSubHs'])->name('student.subjectSaveHs');

            //accounting for HS
            Route::post('hs/fees', [HighSchoolController::class, 'fees'])->name('get.accountingHS');

            //registrar part
            Route::get('/studentSection', [SectionController::class, 'getStudentSection'])->name('get.studentSection');

            Route::delete('/deleteSubject/{id}', [SectionController::class, 'deleteSubject'])->name('delete.Subject');
            Route::post('/sectionSubject', [SectionController::class, 'getSectionSub'])->name('save.sectionSubject');
            Route::get('/getSectionSubject/{section_code}/{year_level}/{semester_id}/{school_year_id}', [SectionController::class, 'getSectionSubs'])->name('get.SectionSubject');
            Route::post('/addSectionSubject', [SectionController::class, 'addSectionSub'])->name('save.addSectionSubject');
            Route::get('/get_subject_with_instructor', [SectionController::class, 'getSubjectWithInstructor'])->name('get.subjectWithInstructor');
            Route::post('/SectionDate', [SectionController::class, 'adddates'])->name('add.date');

            //sectionHandledByInstructor
            Route::get('/sectionHandled', [SectionController::class, 'instructorHandles'])->name('datatable-endpoint');
            Route::get('/SectionController/{id}', [SectionController::class, 'secSub'])->name('sec.sub');
            //sectionWithSubject
            Route::get('/SecWithSub', [SectionController::class, 'secwithSub'])->name('secwith.sub');
            Route::get('/SectionController/enrolledStudentsSubject/{id}', [SectionController::class, 'studentsSubjectEnrolled'])->name('students.enrolledSub');
            Route::get('/enrolledStudentsSubject', [SectionController::class, 'enrolledStudentonSubject'])->name('ess.sub');
            Route::post('/saveGrade', [SectionController::class, 'savegrade'])->name('save.grade');


            //get course id and display department
            Route::get('/courseIDwithDepartment', [DepartmentController::class, 'getDepartmentByCourse'])->name('courseId.department');
            Route::get('/generateExcelBarangay', [ReportController::class, 'generateExcelBarangay'])->name('generate.excelBarangay');
            Route::get('/generateExcelOccupation', [ReportController::class, 'generateExcelOccupation'])->name('generate.excelOccupation');
            Route::get('/generateExcelGender', [ReportController::class, 'generateExcelGender'])->name('generate.excelGender');

            Route::get('/region', [MunicipalityController::class, 'municipalities'])->name('municipalities.index');
            Route::get('/cities-province', [MunicipalityController::class, 'citiesProvince'])->name('citiesProvince.index');
            Route::get('/barangay', [MunicipalityController::class, 'barangay'])->name('barangay.index');

            //adding subject
            Route::get('/addSubjectenrolledstudent', [CreateAccountController::class, 'addSubjectenrolledstudent'])->name('add.subjectEnrollstudent');
            Route::get('/getActiveYear', [SchoolYearController::class, 'getActiveYear'])->name('get.activeYear');


            Route::get('/chedFormat', [MasterListController::class, 'chedMasterList'])->name('generate.excelMaterlistched');
            Route::post('/getSectionsubject', [SectionController::class, 'sectionSubject'])->name('get.sectionSubjects');

            Route::post('/getSectionsubject/view/sectionsub', [SectionController::class, 'sectionSubjectview'])->name('get.viewsectionSubjects');
            Route::get('/generateCOE', [ReportController::class, 'generateCertofGrade'])->name('generate.certificateofgrades');

            Route::get('/addSubjectenrolledstudent', [CreateAccountController::class, 'addSubjectenrolledstudent'])->name('add.subjectEnrollstudent');
            Route::get('/getActiveYear', [SchoolYearController::class, 'getActiveYear'])->name('get.activeYear');

            Route::get('/chedFormat', [MasterListController::class, 'chedMasterList'])->name('generate.excelMaterlistched');

            Route::post('/getSectionsubject', [SectionController::class, 'sectionSubject'])->name('get.sectionSubjects');

            Route::get('/get-section-id', [SectionController::class, 'getSectionId'])->name('get.section-idwithinsid');

            Route::get('/getInstructorWithSectionHandled', [SectionController::class, 'getIWSH'])->name('generate.IWSH');
            Route::get('/getActiveYearInstructor', [SchoolYearController::class, 'getActiveYearins'])->name('get.activeYearInsturctor');
            Route::get('/sectionBySchoolYearInstructor', [SchoolYearController::class, 'getSectionBySchoolYearInstructor'])->name('get.sectionBySchoolYearInstructor');

            Route::get('/sectionBySchoolYearInstructor/individualStudents', [SchoolYearController::class, 'individualStudents'])->name('get.individualStudents');
            Route::post('/activeallSchoolYear', [SchoolYearController::class, 'activedeactiveschoolyear'])->name('store.allActiveschoolyear');
            Route::get('/getinstructorSubject', [InstructorController::class, 'getinsSub'])->name('get.instructorSubject');

            Route::get('/getinstructorSubject/getsubjectbysection', [SectionController::class, 'getsubsec'])->name('get.subjectbybSection');

            Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');
            Route::resource('studentList', ImportStudentList::class);

            Route::get('/fee-summary/latest-or-number', [FullPackageController::class, 'getLatestOrNumber']);
        });
    });
    // finance
    Route::group(['middleware' => ['role:High School Department Super Administrator|Super_Administrator|Finance Cashier|Super Admin for Finance|Super Admin for Accounting']], function () {
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::resource('fee_collection', FeeCollectionController::class);
            Route::get('/feecollection_select', [FeeCollectionController::class, 'feeCollectionselectStudents'])->name('feeCollection.select');
            Route::get('getFeesummaries/{id_number}', [FeeCollectionController::class, 'getFeeSummariesOnIdnumber']);
            Route::get('getFeeTypeComputation/{id_number}', [FeeCollectionController::class, 'getfeetypecomputation']);
            Route::post('fee_summaries', [FeeSummaries::class, 'feesummaries'])->name('save.FeeSummaries');

            Route::get('/statement_of_account', [StatementofAccountController::class, 'soa'])->name('statementof.account');
            Route::get('getFeesummariessoa/', [StatementofAccountController::class, 'getFeeSummaries']);

            //non assessed
            Route::get('/non_assessed', [NonAssessedController::class, 'nonAssessed'])->name('non.assessed');
            Route::post('/non_assessed', [NonAssessedController::class, 'saveNonAssessed'])->name('save.NonAssessed');
            Route::get('/get_non_assessed', [NonAssessedController::class, 'get_non_assessed']);
            Route::get('/get_last_ornumber', [CreateAccountController::class, 'getLastORNumber'])->name('get.LastorNumber');

            Route::get('/courseIDwithDepartment', [DepartmentController::class, 'getDepartmentByCourse'])->name('courseId.department');
            Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');

            // Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');


            Route::resource('fullPackage', FullPackageController::class);

            Route::get('/getTotalAssessmentEachStudent/{id_number}', [StatementofAccountController::class, 'getTotalAssessment'])->name('get.total');


            Route::get('/fee-summary/latest-or-number', [FullPackageController::class, 'getLatestOrNumber']);
        });
    });
    //Super Admin for finance
    Route::group(['middleware' => ['role:High School Department Super Administrator|Super_Administrator|Finance Cashier|Super Admin for Finance|Super Admin for Accounting']], function () {
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::resource('otherfees', OtherFeesController::class);
            Route::resource('tuition_fees', TuitionFeeController::class);
            Route::resource('misc_fees', MiscFeeController::class);
            Route::resource('laboratory', LaboratoryController::class);

            Route::resource('fee_collection', FeeCollectionController::class);
            Route::get('/feecollection_select', [FeeCollectionController::class, 'feeCollectionselectStudents'])->name('feeCollection.select');
            Route::get('getFeesummaries/{id_number}', [FeeCollectionController::class, 'getFeeSummariesOnIdnumber']);
            Route::get('getFeeTypeComputation/{id_number}', [FeeCollectionController::class, 'getfeetypecomputation']);
            Route::post('fee_summaries', [FeeSummaries::class, 'feesummaries'])->name('save.FeeSummaries');

            Route::get('/add_student_discount', [StudentDiscount::class, 'getStudents'])->name('students.Adddiscounts');
            Route::get('/get_student_discount', [StudentDiscount::class, 'getStudentsDiscount'])->name('students.Getdiscounts');
            Route::get('student_discount/save', [StudentDiscount::class, 'studentDiscountIndex'])->name('student.discount');


            Route::resource('highSchool', HighSchoolController::class);
            Route::post('approvalHighSchool/{id}', [HighSchoolController::class, 'changeStatus'])->name('studentappHS.changeStatusHighSchool');
            Route::get('/getCurriculumHighSchool', [HighSchoolController::class, 'getCurriculumHS'])->name('get.CurrculumCoursesHS');
            Route::post('student_subject_highSchhol', [HighSchoolController::class, 'studentSubHs'])->name('student.subjectSaveHs');

            //accounting for HS
            Route::post('hs/fees', [HighSchoolController::class, 'fees'])->name('get.accountingHS');
            Route::get('/courseIDwithDepartment', [DepartmentController::class, 'getDepartmentByCourse'])->name('courseId.department');
            Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');
        });
    });
    //evaluator
    Route::group(['middleware' => ['role:High School Department Super Administrator|Super_Administrator|Finance Cashier|Super Admin for Finance|Super Admin for Accounting|Evaluator']], function () {
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::resource('create_account', CreateAccountController::class);
        });
    });

    //High School Department
    Route::group(['middleware' => ['role:High School Department Super Administrator|Super_Administrator|Registrar|Finance Cashier|Super Admin for Finance|Super Admin for Accounting|Evaluator']], function () {
        Route::prefix('superadmin')->name('superadmin.')->group(function () {
            Route::get('/', [SuperAdminController::class, 'superAdminDashboard'])->name('sadmindashboard');
            // Roles and Permissions
            Route::post('/roles/{role}/permissions', [RolesController::class, 'givePermission'])->name('roles.permissions');
            Route::delete('/roles/{role}/permissions/{permission}', [RolesController::class, 'revokePermission'])->name('roles.permissions.revoke');
            Route::resource('/role', RolesController::class);
            Route::resource('/permission', PermissionController::class);

            Route::get('addpermission', [RolesController::class, 'addPermissionsToRoles'])->name('permission.roles');

            //givepermissiontorole
            Route::put('/rolesPermission/{role}', [RolesController::class, 'givePermissiontoRole'])->name('roles.givepermission');
            // Student Applicant
            //change status for approval of students
            Route::get('totalunits/by_studentsapplicant/{curriculum_id}', [StudentapplicantController::class, 'total_units'])->name('total.units');
            Route::get('get-last-id', [StudentapplicantController::class, 'getLastId'])->name('studentapp.getLastId');

            Route::resource('studentapplicant', StudentapplicantController::class);

            // Curriculum route
            Route::resource('curriculum', CurriculumController::class);
            Route::get('curriculum/by_course/{course_id}', [CurriculumController::class, 'getCurriculumByCourse']);

            // Campus
            Route::resource('campuses', CampusController::class);
            // Courses
            Route::resource('courses', CourseController::class);
            // Departments
            Route::resource('departments', DepartmentController::class);

            // Levels Route
            Route::resource('levels', LevelController::class);
            // Subjects Route
            Route::post('add-details', [AddDetailsController::class, 'add_details_on_sucjects'])->name('add.details');
            Route::resource('subjects', SubjectController::class);
            // Curriculum Subjects Route

            Route::get('curriculum/curriculum_semester/{semester_id}', [CurriculumSubjectController::class, 'getSemesterbByCurriculum']);
            Route::resource('curriculum_subjects', CurriculumSubjectController::class);
            // Admitted Student

            // Sections
            Route::resource('sections', SectionController::class);
            Route::get('section/by_course/{course_id}', [SectionController::class, 'getSectionByCourse']);

            Route::put('admitstudentchangestatus', [AdmittedStudentsController::class, 'changeStatus'])->name('admitstudent.changeStatus');
            Route::resource('admit_students', AdmittedStudentsController::class);

            Route::get('/curriculum_courses/{curriculum_id}/{year_level}/{semester_id}/{section_code}', [CurriculumCoursesController::class, 'getCoursesByCurriculum'])->name('superadmin.curriculum_courses.get_courses');

            //enrolled Student
            //
            Route::get('/semester_subject/{semester_id}/{curriculum_id}/{year_level}/{section_code}', [SubjectController::class, 'getSubjectBySemester'])->name('subject_section.get_semester');

            Route::post('enrolled-students', [EnrolledStudents::class, 'enrolled_students'])->name('enrolled.students');
            Route::get('getSectionName', [EnrolledStudents::class, 'get_Section'])->name('enrolled.section');

            Route::resource('feesCategory', FeesCategoryController::class);

            //feetype
            Route::get('course/by_feetype/{course_id}', [FreeTypeController::class, 'get_feetype'])->name('get.feetype');

            Route::resource('feetype', FreeTypeController::class);

            //tuition fees
            Route::resource('tuition_fees', TuitionFeeController::class);
            //Misc Fee
            Route::resource('misc_fees', MiscFeeController::class);
            //section subject
            Route::resource('section_subject', SectionSubjectController::class);

            Route::resource('instructor', InstructorController::class);

            //import excel
            Route::resource('importsubjects', ImportSubjects::class);

            //other fees
            Route::resource('otherfees', OtherFeesController::class);

            //School Year
            Route::resource('school_year', SchoolYearController::class);

            //Discount
            Route::resource('discount', DiscountController::class);

            //create account
            Route::resource('create_account', CreateAccountController::class);

            Route::get('get-last-id', [CreateAccountController::class, 'getLastId'])->name('studentapp.getLastId');
            Route::post('approval/{id}', [CreateAccountController::class, 'changeStatus'])->name('studentapp.changeStatus');
            // Route::get('/section_subject/{section_id}/{curriculum_id}/{year_level}', [CreateAccountController::class, 'getSectionWithSubject'])->name('curriculum.get_section');
            //get curriculum by section
            Route::get('curriculum/curriculum_section/{curriculum_id}', [CreateAccountController::class, 'getSectionByCurriculum']);

            //save student subject
            Route::post('student_subject', [CreateAccountController::class, 'studentSub'])->name('student.subjectSave');
            //get subject in curriculum subject
            Route::get('/curriculum_courses/{curriculum_id}/{year_level}/{semester_id}', [CurriculumCoursesController::class, 'getCoursesByCurriculum'])->name('superadmin.curriculum_courses.get_courses');

            //accounting route purposes
            Route::post('create_account/fees', [CreateAccountController::class, 'fees']);

            Route::post('student_fees', [CreateAccountController::class, 'studentFee'])->name('student.feeSave');

            //get subject // routes/web.php

            Route::post('/curriculum_subjectss', [CreateAccountController::class, 'get'])->name('curriculum.getSubjectss');
            //view Student Subject
            Route::get('/view_student_subject', [CreateAccountController::class, 'getSubjectEnrolled'])->name('your-datatable-endpoint');

            Route::get('/calculate_units/{id_number}', [CreateAccountController::class, 'calculateUnits']);

            // Student Discount
            Route::get('student_discount/save', [StudentDiscount::class, 'studentDiscountIndex'])->name('student.discount');


            //Add Students on Discount
            Route::get('/add_student_discount', [StudentDiscount::class, 'getStudents'])->name('students.Adddiscounts');
            Route::get('/select_student_discount', [StudentDiscount::class, 'selectStudents'])->name('students.Selectdiscounts');
            Route::post('/save-discount', [StudentDiscount::class, 'saveStudentDiscount'])->name('save.discount');
            //get students discounts on database using yajra
            Route::get('/get_student_discount', [StudentDiscount::class, 'getStudentsDiscount'])->name('students.Getdiscounts');
            Route::delete('/delete_save_discount/{id}', [StudentDiscount::class, 'deleteDiscount'])->name('deleteSaved.Discount');
            //fee collection
            Route::resource('fee_collection', FeeCollectionController::class);
            //fee Collection Select Student
            Route::get('/feecollection_select', [FeeCollectionController::class, 'feeCollectionselectStudents'])->name('feeCollection.select');
            // Route::get('/student-details/{id}', [FeeCollectionController::class, 'showStudentDetails']);
            //fee Summaries
            Route::post('fee_summaries', [FeeSummaries::class, 'feesummaries'])->name('save.FeeSummaries');
            Route::get('fee_summaries_all', [FeeSummaries::class, 'fee_summaries_all'])->name('FeeSummaries.all');


            //PDF StudentAssessment Print
            Route::get('/student-print-assessment/{id_number}', [PdfStudentAssessmentController::class, 'generateStudentAssessment'])->name('pdf.printStudentAssessment');
            Route::get('/student-print-assessmentHS/{id_number}', [PdfStudentAssessmentController::class, 'generateStudentAssessmentHS'])->name('pdf.printStudentAssessmentHS');

            //get school year id
            Route::get('/getSemester/{semester}', [CreateAccountController::class, 'getsemester']);

            //get Curriculum base on course
            Route::get('/getCurriculum', [CreateAccountController::class, 'getCurriculum'])->name('get.CurrculumCourses');

            //laboratory set up
            Route::resource('laboratory', LaboratoryController::class);

            Route::get('likedSubject', [LaboratoryController::class, 'likedSubject'])->name('get.LikedSubeject');
            Route::post('/saveLinkedSubject', [LaboratoryController::class, 'saveLinkedSubject'])->name('save.linkedSubject');

            Route::get('getLinkedSubjects/{labId}', [LaboratoryController::class, 'likedSubjectview']);

            //get fee type and computation
            Route::get('getFeeTypeComputation/{id_number}/{semester}', [FeeCollectionController::class, 'getfeetypecomputation']);
            //get fee summaries based on id_number
            Route::get('getFeesummaries/{id_number}', [FeeCollectionController::class, 'getFeeSummariesOnIdnumber']);

            Route::resource('StudentSubject', StudentSubjectController::class);

            Route::delete('/delete_subject/{id}', [StudentSubjectController::class, 'deleteSubject'])->name('delete.subject');

            Route::get('addSubject_view', [CreateAccountController::class, 'addSubjectView'])->name('addSubject.view');

            Route::resource('create_user', CreateUserController::class);

            Route::get('activityLogs', [ActivityLogsController::class, 'index'])->name('activityLogs.index');

            //testing for pringting purposes
            Route::get('printRecipt/{id}', [PrintReciptController::class, 'printrecipt']);
            Route::get('printReciptNonAssessed/{id}', [PrintReciptController::class, 'printreciptnonassessed']);


            //Get Enrolled Student
            Route::get('report', [ReportController::class, 'studentrepots'])->name('student.report');
            Route::get('financeReport', [ReportController::class, 'financerepots'])->name('finance.report');

            Route::get('/generate-excel', [ReportController::class, 'generateExcel'])->name('generate.excel');
            Route::get('/generate-excel-masterlist', [MasterListController::class, 'generateExcelMasterList'])->name('generate.excelMaterlist');
            Route::get('/generate-pdf-finance', [MasterListController::class, 'generatePDFFinancedailyreport'])->name('generate.PDFFinancedailyreport');

            // Route::get('/preview-excel', ReportController::class, 'previewExcel')->name('preview.excel');
            //get how may courses
            Route::get('/get-course-data', [CourseController::class, 'getCourseData'])->name('get.courseData');
            Route::get('/get-maleandfemale-data', [CourseController::class, 'getMaleFemale'])->name('get.MaleFemale');
            Route::get('/createAccount', [CourseController::class, 'createaccount'])->name('get.createAccounts');
            //Print Student With Subject
            Route::get('/PrintStudentSubject/{id}', [PrintStudentSubject::class, 'printStudentSubject'])->name('generate.printStudentSubject');

            //Cancel Enrollment
            Route::delete('/cancel_enrollment', [CancelEnrollementController::class, 'cancelEnrollment'])->name('cancel.enrollment');
            Route::get('studentInternalData', [GradesInternalDataController::class, 'getStudentSubjects'])->name('student.internalData');
            //Input Grade
            Route::post('input_grade', [InputGradeController::class, 'inputGrade'])->name('input.grade');

            Route::post('update_grade', [InputGradeController::class, 'updateGrade'])->name('update.grade');

            //classlist
            Route::get('/classlist', [ClasslistController::class, 'classList'])->name('class.list');

            //delete curriculum_subject
            Route::delete('/delete_curriculum_subject/{id}', [CurriculumSubjectController::class, 'deleteCurriculumSubject'])->name('delete.CSubject');

            Route::put('/editDetails/{id?}', [SectionController::class, 'updateDetails'])->name('update.details');

            Route::resource('highSchool', HighSchoolController::class);
            Route::post('approvalHighSchool/{id}', [HighSchoolController::class, 'changeStatus'])->name('studentappHS.changeStatusHighSchool');
            Route::get('/getCurriculumHighSchool', [HighSchoolController::class, 'getCurriculumHS'])->name('get.CurrculumCoursesHS');
            Route::post('student_subject_highSchhol', [HighSchoolController::class, 'studentSubHs'])->name('student.subjectSaveHs');

            //accounting for HS
            Route::post('hs/fees', [HighSchoolController::class, 'fees'])->name('get.accountingHS');

            Route::get('/courseIDwithDepartment', [DepartmentController::class, 'getDepartmentByCourse'])->name('courseId.department');

            Route::get('/region', [MunicipalityController::class, 'municipalities'])->name('municipalities.index');
            Route::get('/cities-province', [MunicipalityController::class, 'citiesProvince'])->name('citiesProvince.index');
            Route::get('/barangay', [MunicipalityController::class, 'barangay'])->name('barangay.index');

            Route::get('/getActiveYear', [SchoolYearController::class, 'getActiveYear'])->name('get.activeYear');
            Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');

            Route::delete('/remove-lab-id/{id}', [LaboratoryController::class, 'removeLabId'])->name('remove.lab.id');


            Route::resource('fullPackage', FullPackageController::class);

            Route::get('/getTotalAssessmentEachStudent/{id_number}', [StatementofAccountController::class, 'getTotalAssessment'])->name('get.total');


            Route::get('/fee-summary/latest-or-number', [FullPackageController::class, 'getLatestOrNumber']);
        });
    });
});
require __DIR__ . '/auth.php';