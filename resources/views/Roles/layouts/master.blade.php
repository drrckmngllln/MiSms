<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesdesign" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MCNP-ISAP</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/zvdkK-s0_400x400.jpg') }}">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <!-- Advance Forms -->
    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('backend/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet"
        type="text-css">
    <link href="{{ asset('backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet">
    <!-- Yajra DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!-- Icons CSS -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App CSS -->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/assets/Datatables/DataTables-1.13.8/css/dataTables.bootstrap5.css') }}"
        rel="stylesheet">
    <link href="{{ asset('backend/assets/Datatables/Responsive-2.5.0/css/responsive.bootstrap5.css') }}"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection__arrow {
            height: 38px !important;
            margin-right: .5rem;
        }

        .select2-container {
            display: block !important;
        }

        .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-selection {
            height: unset !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
        }
    </style>
</head>


<body data-topbar="dark">
    <!-- Loader -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Navbar -->
        @include('Roles.layouts.navbar')
        <!-- Sidebar -->
        @include('Roles.layouts.sidebar')
        <!-- Main content -->
        <div class="main-content">
            @yield('content')
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> MCNP-ISAP
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                <a target="_blank"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End main content -->
    </div>
    <!-- END layout-wrapper -->

    <!-- JavaScript -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplesbar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Dashboard init js -->

    <script src="{{ asset('backend/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Dynamic Delete Alert --}}
    <script src="{{ asset('backend/assets/js/deletefunctionforall.js') }}"></script>
    <script src="{{ asset('backend/assets/js/deleteforViewSub.js') }}"></script>
    <script src="{{ asset('backend/assets/js/sectionsubjectDelete.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('backend/assets/Datatables/DataTables-1.13.8/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend/assets/Datatables/DataTables-1.13.8/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('backend/assets/Datatables/Responsive-2.5.0/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('backend/assets/Datatables/Responsive-2.5.0/js/responsive.bootstrap5.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/chart.js/Chart.bundle.min.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>





    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

    @stack('scripts')

    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });
        @if (Session::has('success'))
            $(document).ready(function() {
                // console.log('Hello promises!');
                (() => {
                    Toast.fire({
                        icon: 'success',
                        title: '{{ Session::get('success') }}',
                    });
                })();
            });
        @endif
    </script>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    <script>
        @if (Session::has('alert'))
            $(document).ready(function() {
                (() => {
                    Toast.fire({
                        icon: 'error',
                        title: '{{ Session::get('alert') }}',
                    });
                })();
            });
        @endif
    </script>
</body>

</html>
