<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} </title>
    <link rel="shortcut icon" href="{{ asset('backend/login/images/logo-light.png') }}">
    <link rel="icon" href="{{ asset('backend/login/images/logo-light.png') }}">
    <link href="{{ asset('backend/login/FreezeUi/freeze-ui.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('backend/login/js/layout.js') }}"></script>
    <link href="{{ asset('backend/login/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/login/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/login/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/login/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Cloudflare Turnstile Script -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        .btn-primary,
        .bg-primary {
            background: #27211f !important;
            border: 1px solid #141312;
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay" style="background:#172c4b"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="javascript:void(0)" class="d-inline-block auth-logo">
                                    <img src="{{ asset('backend/login/images/width_550.png') }}" width="390">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                @error('invalid')
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="alert text-center alert-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        </div>
                    </div>
                @enderror

                <div class="row justify-content-center">
                    <div class="col-md-5 col-12">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back!</h5>
                                    <p class="text-muted">Login in to continue.</p>

                                </div>
                                <div class="p-2 mt-4">
                                    <form class="form-horizontal mt-3" method="POST" action="{{ route('login') }}"
                                        id="loginForm">
                                        @csrf
                                        <div class="form-group mb-3 row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" required=""
                                                    placeholder="Email" value="{{ old('email') ?? '' }}"
                                                    name="email">
                                            </div>
                                            @if ($errors->has('email'))
                                                <code>{{ $errors->first('email') }}</code>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <div class="col-12">
                                                <input class="form-control" type="password" required=""
                                                    placeholder="Password" name="password">
                                            </div>
                                            @if ($errors->has('password'))
                                                <code>{{ $errors->first('password') }}</code>
                                            @endif
                                        </div>

                                        {{-- <div class="cf-turnstile"
                                            data-sitekey="{{ config('services.turnstile.site_key') }}"
                                            data-callback="onTurnstileSuccess" data-theme="light" data-action="login">
                                        </div> --}}

                                        <div class="form-group mb-3 text-center row mt-3 pt-1">
                                            <div class="col-12">
                                                <button class="btn btn-info w-100 waves-effect waves-light"
                                                    type="submit" id="login_btn" style="background-color: #525faf;">
                                                    Log In
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ config('app.name') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="{{ asset('backend/login/FreezeUi/freeze-ui.min.js') }}"></script>
    <script src="{{ asset('backend/login/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/login/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/login/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/login/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/login/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('backend/login/js/plugins.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        flatpickr("#datepicker-range", {
            mode: "range",
            dateFormat: "Y/m/d"
        })
    </script>
    @if (Session::has('message'))
        <script>
            Swal.fire({
                title: "{{ Session::get('title') }}",
                text: "{{ Session::get('message') }}",
                icon: "{{ Session::get('type') }}"
            });
        </script>
    @endif

    <script>
        function confirmation(message, icon, url) {
            Swal.fire({
                title: 'System Notification',
                text: message,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = url
                }
            });
        }
        $(document).ready(function() {
            $('.select-2').select2();

            function updateClock() {
                var now = new Date();
                var hours = now.getHours();
                var minutes = now.getMinutes().toString().padStart(2, '0');
                var seconds = now.getSeconds().toString().padStart(2, '0');
                var ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;
                hours = hours ? hours : 12; // The hour '0' should be '12'
                hours = hours.toString().padStart(2, '0');

                var timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

                $('#clock').text(timeString);
            }

            // Initial call to set the clock immediately
            updateClock();

            // Update the clock every second
            setInterval(updateClock, 1000);
        });

        $('#topnav-hamburger-icon').click(function() {
            if ($(this).data('closed') == undefined || $(this).data('closed') == 0) {
                $('.navbar-menu').hide();
                $('.main-content').attr('style', 'margin-left:0 !important;');
                $('#page-topbar').attr('style', 'left:0 !important;');
                $(this).data('closed', 1);
            } else {
                $('.navbar-menu').show();
                $('.main-content').attr('style', 'var(--vz-vertical-menu-width);');
                $('#page-topbar').attr('style', 'var(--vz-vertical-menu-width);');
                $(this).data('closed', 0);
            }
        });
    </script>
    <script src="{{ asset('backend/login/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('backend/login/js/pages/particles.app.js') }}"></script>
    <script src="{{ asset('backend/login/js/pages/password-addon.init.js') }}"></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const submitButton = document.getElementById('login_btn');
            let isVerified = false;

            window.onTurnstileSuccess = function(token) {
                isVerified = true;
            };

            form.addEventListener('submit', function(e) {
                if (!isVerified) {
                    e.preventDefault();
                    // Manually trigger Turnstile
                    turnstile.execute('#cf-turnstile');
                }
            });
        });
    </script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginBtn = document.getElementById('login_btn');

            window.onTurnstileSuccess = function(token) {
                if (token) {
                    loginBtn.removeAttribute('disabled');
                }
            };

            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const turnstileResponse = document.querySelector('[name="cf-turnstile-response"]');
                if (!turnstileResponse || !turnstileResponse.value) {
                    e.preventDefault();
                    alert('Please complete the Turnstile challenge');
                }
            });
        });
    </script> --}}
</body>

</html>
