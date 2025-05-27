<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Account</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png">
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>

    <!--plugins-->
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/mm-vertical.css') }}">
    <!--bootstrap css-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/main.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/blue-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/responsive.css') }}" rel="stylesheet">

</head>

<body>


    <!--authentication-->

    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">

                <div
                    class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

                    <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/auth/login1.png') }}" class="img-fluid auth-img-cover-login"
                                width="650" alt="">
                        </div>
                    </div>

                </div>

                <div
                    class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center border-top border-4 border-primary border-gradient-1">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                        <div class="card-body p-sm-5">
                            <img src="{{ asset('assets/images/logo-icon4.png') }}" class="mb-4" width="145" alt="">
                            <h4 class="fw-bold small">Get Started Now</h4>
                            <p class="mb-0 small">Enter your credentials to login your account</p>

                            <div class="row g-3 my-4 small">
                                <div class="col-12 col-lg-6">
                                    <a href="{{ route('google.login') }}"
                                        class="btn btn-light py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100">
                                        <img src="{{ asset('assets/images/apps/05.png') }}" width="20"
                                            class="me-2" alt="">Google
                                    </a>
                                </div>
                             

                            <div class="col col-lg-6">
                                <button
                                    class="btn btn-light py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100"><img
                                        src="{{ asset('assets/images/apps/17.png') }}" width="20" class="me-2"
                                        alt="">Facebook</button>
                            </div>
                        </div>

                        <div class="separator section-padding">
                            <div class="line"></div>
                            <p class="mb-0 fw-bold">OR</p>
                            <div class="line"></div>
                        </div>

                        <div class="form-body small">
                            {{-- Display validation errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Display success message --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Display login failure or custom error --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="mb-4 small">
                                <label class="form-label fw-bold d-block text-center mb-3">Quick Login As</label>
                                <div class="row g-3 text-center">
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary quick-login w-100 py-2"
                                            data-email="a1@a" data-password="a1">Admin1</button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-secondary quick-login w-120 py-2"
                                            data-email="e1@e" data-password="e1">Employer1</button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-success quick-login w-100 py-2"
                                            data-email="ag1@a" data-password="ag1">Agent1</button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-warning quick-login w-120 py-2"
                                            data-email="c1@c" data-password="c1">Candidate1</button>
                                    </div>
                                </div>


                                 <div class="row g-3 text-center">
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary quick-login w-100 py-2"
                                            data-email="a2@a" data-password="a2">Admin2</button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-secondary quick-login w-120 py-2"
                                            data-email="e2@e" data-password="e2">Employer2</button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-success quick-login w-100 py-2"
                                            data-email="ag2@a" data-password="ag2">Agent2</button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-warning quick-login w-120 py-2"
                                            data-email="c2@c" data-password="c2">Candidate2</button>
                                    </div>
                                </div>
                            </div>
                            
                            <form method="POST" action="{{ route('login') }}" class="row g-3" id="login-form">
    
                                @csrf

                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="jhon@example.com" required value="{{ old('email') }}">
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter Password" required>
                                        <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                class="bi bi-eye-slash-fill"></i></a>
                                    </div>
                                </div>



                                <div class="col-md-12 text-end">
                                    <a href="#">Forgot Password?</a>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-grd-primary">Login</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-start">
                                        <p class="mb-0">Don't have an account yet? <a
                                                href="{{ route('register') }}">Sign up here</a></p>
                                    </div>
                                </div>
                            </form>



                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!--end row-->
    </div>
    </div>

    <!--authentication-->




    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // Toggle password visibility
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                const input = $('#show_hide_password input');
                const icon = $('#show_hide_password i');

                if (input.attr("type") === "password") {
                    input.attr('type', 'text');
                    icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
                } else {
                    input.attr('type', 'password');
                    icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
                }
            });

            // Quick login button click: fill email & password and auto submit
            $('.quick-login').on('click', function() {
                const email = $(this).data('email');
                const password = $(this).data('password');

                $('#email').val(email);
                $('#password').val(password);

                // Auto-submit the form after filling
             $('#login-form').submit(); // Use a specific ID

            });

        });
    </script>


</body>

</html>
