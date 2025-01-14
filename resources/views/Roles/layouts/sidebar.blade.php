<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div>
                <img src="{{ asset('backend/assets/images/noun-admin-1046334.png') }}" alt=""
                    class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ Auth::user()->name }}</h4>
                <span class="text-muted">
                    <i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online
                </span>
            </div>
        </div>
        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Functionality</li>
                @role(['Super_Administrator', 'Administrator'])
                    <li>
                        <a href="{{ route('superadmin.sadmindashboard') }}" class="waves-effect">
                            <i class="ri-dashboard-line"></i>
                            <span class="badge rounded-pill bg-success float-end">3</span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endrole

                @role(['Super_Administrator'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-user-follow-fill"></i>
                            <span>Manage User</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('superadmin.role.index') }}">Role</a></li>
                            <li><a href="{{ route('superadmin.permission.index') }}">Permissions</a></li>
                        </ul>
                    </li>
                @endrole

                @role(['Super_Administrator'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-user-follow-fill"></i>
                            <span>User</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('superadmin.create_user.index') }}">Create User</a></li>

                        </ul>
                    </li>
                @endrole
                @role(['Super_Administrator'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-ticket-alt"></i>
                            <span>Admission</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('superadmin.create_account.index') }}">College Student Account</a>
                            </li>
                            <li><a href="{{ route('superadmin.highSchool.index') }}">High School Student Account</a>
                            </li>
                            <li><a href="{{ route('superadmin.student.discount') }}">Apply Discount</a>
                            </li>
                            <li><a href="{{ route('superadmin.fee_collection.index') }}">Fee Collection/Scholarship</a>
                            </li>
                    </li>
                </ul>
                </li>
            @endrole

            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-gear"></i>
                        <span>General</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.campuses.index') }}">Campus</a></li>
                        <li><a href="{{ route('superadmin.departments.index') }}">Departments</a></li>
                        {{-- <li><a href="{{ route('superadmin.feesCategory.index') }}">Fee Category</a></li>
                        <li><a href="{{ route('superadmin.feetype.index') }}">Fee Type</a></li> --}}
                        <li><a href="{{ route('superadmin.otherfees.index') }}">Other Fees</a></li>
                        <li><a href="{{ route('superadmin.tuition_fees.index') }}">Tuition Fee</a></li>
                        <li><a href="{{ route('superadmin.school_year.index') }}">School Year</a></li>
                        <li><a href="{{ route('superadmin.misc_fees.index') }}">Miscellaneous
                                Fee</a></li>
                        <li><a href="{{ route('superadmin.laboratory.index') }}">Laboratory</a></li>
                        <li><a href="{{ route('superadmin.instructor.index') }}">Instructor</a></li>
                        <li><a href="{{ route('superadmin.discount.index') }}">Discount</a></li>
                        <li><a href="{{ route('superadmin.fullPackage.index') }}">Full Package</a></li>
                        {{-- <li><a href="">Cashier Logs</a></li> --}}
                        {{-- <li><a href="">OR Number</a></li> --}}
                    </ul>
                </li>
            @endrole
            @role('Registrar')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Admission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.create_account.index') }}">College Student Account</a>
                        </li>
                        <li><a href="{{ route('superadmin.highSchool.index') }}">High School Student Account</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-gear"></i>
                        <span>General</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('superadmin.campuses.index') }}">Campus</a>
                        </li>
                        <li><a href="{{ route('superadmin.departments.index') }}">Departments</a></li>
                        <li><a href="{{ route('superadmin.school_year.index') }}">School Year</a></li>
                        <li><a href="{{ route('superadmin.instructor.index') }}">Instructor</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-graduation"></i>
                        <span>Offerings</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.curriculum.index') }}">Curriculum</a></li>
                        <li><a href="{{ route('superadmin.courses.index') }}">Courses</a></li>
                        {{-- <li><a href="{{ route('superadmin.subjects.index') }}">Subjects</a></li> --}}
                        <li><a href="{{ route('superadmin.sections.index') }}">Sections</a></li>
                        <li><a href="{{ route('superadmin.student.report') }}">Generate Reports</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-chat-history-fill"></i>
                        <span>Activity Logs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.activityLogs.index') }}">Logs</a></li>

                    </ul>
                </li>
            @endrole

            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-graduation"></i>
                        <span>Offerings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.curriculum.index') }}">Curriculum</a></li>
                        <li><a href="{{ route('superadmin.courses.index') }}">Courses</a></li>
                        {{-- <li><a href="{{ route('superadmin.subjects.index') }}">Subjects</a></li> --}}
                        <li><a href="{{ route('superadmin.sections.index') }}">Sections</a></li>
                    </ul>
                </li>
            @endrole
            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-chat-history-fill"></i>
                        <span>Activity Logs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.activityLogs.index') }}">Logs</a></li>

                    </ul>
                </li>
            @endrole
            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-bar-chart-box-fill"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.student.report') }}">Generate Reports</a></li>

                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.finance.report') }}">Finance</a></li>

                    </ul>
                </li>
            @endrole
            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-record-mail-fill"></i>
                        <span>Statement of Account </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.statementof.account') }}">SOA</a></li>

                    </ul>
                </li>
            @endrole
            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-forbid-2-line"></i>
                        <span>Non-Assessed</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.non.assessed') }}">Non-Assessed</a></li>

                    </ul>
                </li>
            @endrole
            @role(['Super_Administrator'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-award-line"></i>
                        <span>Grades Internal Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.student.internalData') }}">Student Grades</a></li>

                    </ul>
                </li>
            @endrole

            <!-- High School Super_Admnistrator -->
            @role(['High School Department Super Administrator'])
                <li>
                    <a href="{{ route('superadmin.sadmindashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Transactions</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Admission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.create_account.index') }}">Students Account</a>
                        </li>


                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-gear"></i>
                        <span>General</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('superadmin.campuses.index') }}">Campus</a>
                        </li>
                        <li><a href="{{ route('superadmin.departments.index') }}">Departments</a></li>
                        <li><a href="{{ route('superadmin.school_year.index') }}">School Year</a></li>
                        <li><a href="{{ route('superadmin.instructor.index') }}">Instructor</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-graduation"></i>
                        <span>Offerings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.curriculum.index') }}">Curriculum</a></li>
                        <li><a href="{{ route('superadmin.courses.index') }}">Courses</a></li>
                        {{-- <li><a href="{{ route('superadmin.subjects.index') }}">Subjects</a></li> --}}
                        <li><a href="{{ route('superadmin.sections.index') }}">Sections</a></li>
                        {{-- <li><a href="{{ route('superadmin.student.report') }}">Generate Reports</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-chat-history-fill"></i>
                        <span>Activity Logs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.activityLogs.index') }}">Logs</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-bar-chart-box-fill"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.student.report') }}">Generate Reports</a></li>

                    </ul>
                </li>
            @endrole
            @role('Super Admin for Finance')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-money-cny-circle-line"></i>
                        <span>Finance</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.non.assessed') }}">Non-Assessed</a></li>
                        <li><a href="{{ route('superadmin.fee_collection.index') }}">Fee Collection</a>

                        </li>
                    </ul>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-record-mail-fill"></i>
                        <span>Statement of Account </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.statementof.account') }}">SOA</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-chat-history-fill"></i>
                        <span>Activity Logs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.activityLogs.index') }}">Logs</a></li>

                    </ul>
                </li>
            @endrole
            @role('Super Admin for Accounting')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Admission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.create_account.index') }}">College Students</a>
                        </li>
                        <li><a href="{{ route('superadmin.highSchool.index') }}">High School Student Account</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-gear"></i>
                        <span>General</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.otherfees.index') }}">Other Fees</a></li>
                        <li><a href="{{ route('superadmin.tuition_fees.index') }}">Tuition Fee</a></li>
                        <li><a href="{{ route('superadmin.misc_fees.index') }}">Miscellaneous</a></li>
                        <li><a href="{{ route('superadmin.laboratory.index') }}">Laboratory</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-money-cny-circle-line"></i>
                        <span>Finance</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.student.discount') }}">Apply Discount</a>
                        <li><a href="{{ route('superadmin.discount.index') }}">Discount</a></li>
                        <li><a href="{{ route('superadmin.fee_collection.index') }}">Fee Collection</a>
                        <li><a href="{{ route('superadmin.non.assessed') }}">Non-Assessed</a></li>
                </li>
                </ul>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-record-mail-fill"></i>
                        <span>Statement of Account </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.statementof.account') }}">SOA</a></li>

                    </ul>
                </li>
            @endrole
            <!-- Fincance Cashier Roles -->
            @role('Finance Cashier')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-money-cny-circle-line"></i>
                        <span>Finance</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.fee_collection.index') }}">Fee Collection</a>
                        <li><a href="{{ route('superadmin.non.assessed') }}">Non-Assessed</a></li>
                        <li><a href="{{ route('superadmin.finance.report') }}">Report</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-chat-history-fill"></i>
                        <span>Activity Logs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.activityLogs.index') }}">Logs</a></li>

                    </ul>
                </li>
            @endrole
            @role('Evaluator')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Admission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('superadmin.create_account.index') }}">College Student Account</a>
                        </li>
                        <li><a href="{{ route('superadmin.highSchool.index') }}">High School Student Account</a>
                        </li>
                    </ul>
                </li>
            @endrole
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
