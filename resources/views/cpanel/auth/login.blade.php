<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - {{ env('app_name') }}</title>
    <meta name="description" content="Login - {{ env('app_name') }} Platform">
    <meta name="author" content="{{ env('app_name') }}">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="Login - {{ env('app_name') }} Platform">
    <meta property="og:site_name" content="Login - {{ env('app_name') }} Platform">
    <meta property="og:description" content="Login - {{ env('app_name') }} Platform">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="{{ asset('cpanel/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('cpanel/assets/css/dashmix.min-3.1.css') }}">
    <style>
        #bg-image {
            background-image: url("{{ asset('cpanel/assets/images/bg-login.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            <div class="bg-image" id="bg-image">
                <div class="row no-gutters bg-primary-op">
                    <div class="hero-static col-md-6 d-flex align-items-center bg-white">
                        <div class="p-3 w-100">
                            <div class="mb-3 text-center">
                                <a class="link-fx font-w700 font-size-h1" href="index.html">
                                    <span class="text-dark">{{ env('APP_NAME') }}</span><span class="text-primary">{{ __('index.admin') }}</span>
                                </a>
                                <p class="text-uppercase font-w700 font-size-sm text-muted">{{ __('index.login') }}</p>
                            </div>
                            <div class="row no-gutters justify-content-center">
                                <div class="col-sm-8 col-xl-6">
                                    <form id="admin-login-form" action="{{ route('cpanel.postLogin') }}" method="POST">
                                        @csrf
                                        <div class="py-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-lg form-control-alt" id="login-username" name="username" placeholder="{{ __('index.username') }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-lg form-control-alt" id="login-password" name="password" placeholder="{{ __('index.password') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                                                {{ __('index.login') }}
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
                        <div class="p-3">
                            <p class="display-4 font-w700 text-white mb-3">
                                {{ env('APP_NAME') }}
                            </p>
                            <p class="font-size-lg font-w600 text-white-75 mb-0">
                                Copyright &copy; <span data-toggle="year-copy"></span> by {{ env('APP_NAME') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('cpanel/assets/js/dashmix.core.min-3.1.js') }}"></script>
    <script src="{{ asset('cpanel/assets/js/dashmix.app.min-3.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $("#admin-login-form").on("submit", function() {
                event.preventDefault();
                $('#admin-login-form').find('.btn-hero-primary').prop('disabled', true);
                $('#admin-login-form').find('.btn-hero-primary').text("{{ __('index.logging_in') }}...");
                var formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success'
                        }).then(function() {
                            window.location.href = "{{ route('cpanel.dashboard') }}";
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Error',
                            text: response.responseJSON.message,
                            icon: 'error'
                        });
                    },
                    complete: function() {
                        $('#admin-login-form').find('.btn-hero-primary').prop('disabled', false);
                        $('#admin-login-form').find('.btn-hero-primary').text("{{ __('index.login') }}");
                    }
                });
            });

        });
    </script>
</body>

</html>