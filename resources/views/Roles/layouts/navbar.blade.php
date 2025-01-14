<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index-2.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/2.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/2.png') }}" alt="logo-light" height="20">
                    </span>
                </a>

                <a href="index-2.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/2.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/2.png') }}" alt="logo-light" height="90">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>



        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>





            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img class="rounded-circle header-profile-user"
                        src="{{ asset('backend/assets/images/noun-admin-1046334.png') }}" alt="Header Avatar">

                    <span class="d-none d-xl-inline-block ms-1">
                        @if (Auth::user()->hasRole('Super_Administrator'))
                            Super Administrator
                        @elseif(Auth::user()->hasRole('Finance'))
                            Finance
                        @elseif (Auth::user()->hasRole('Registrar'))
                            Registrar
                        @elseif (Auth::user()->hasRole('High School Department Super Administrator'))
                            High School Department
                        @elseif (Auth::user()->hasRole('Finance Cashier'))
                            Finance Cashier
                        @elseif (Auth::user()->hasRole('Super Admin for Finance'))
                            Finance Super Admin
                        @elseif (Auth::user()->hasRole('Super Admin for Accounting'))
                            Accounting Super Admin
                        @elseif (Auth::user()->hasRole('Evaluator'))
                            Evaluator
                        @else
                            No Role Assigned
                        @endif
                    </span>


                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a class="dropdown-item" href=""><i class="ri-user-line align-middle me-1"></i>
                        Profile</a>



                    <div class="dropdown-divider"></div>

                    {{-- logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                    this.closest('form').submit();"><i
                                class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                    </form>
                </div>
            </div>



        </div>
    </div>

</header>
