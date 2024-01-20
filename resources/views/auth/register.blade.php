<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Feedback Tool</title>

    <!-- Global stylesheets -->
    <link href="{{asset('css/inter.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
</head>
<body>
<div class="page-content">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="page-content">
                <div class="content-wrapper">
                    <div class="content-inner">
                        <div class="content d-flex justify-content-center align-items-center">
                            <form class="login-form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <div class="d-inline-flex align-items-center justify-content-center mb-2 mt-2">
                                                <img src="{{asset('logo/img.png')}}" class="h-80px" alt="">
                                            </div>
                                            <h5 class="mb-0">Register your account.</h5>
                                            <span class="d-block text-muted">Enter your details below</span>
                                        </div>
                                        @error('email')
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="ph-x-circle me-2"></i>
                                            <span class="fw-semibold">Email error!</span>
                                        </div>
                                        @enderror
                                        @error('password')
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="ph-x-circle me-2"></i>
                                            <span class="fw-semibold">{{ $message }}</span>
                                        </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph-person text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph-at text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph-lock text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password-confirm" class="form-label">Confirm Password</label>
                                            <div class="form-control-feedback form-control-feedback-start">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                <div class="form-control-feedback-icon">
                                                    <i class="ph-lock text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">Register</button>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-link" href="{{ route('login') }}">
                                                {{ __('Login?') }}
                                            </a>
                                        </div>
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

<!-- Core JS files -->
<script src="{{asset('js/demo_configurator.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- /core JS files -->
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>



