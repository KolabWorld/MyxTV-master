<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyxTV</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/admin/images/favicon.png">

    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="/assets/admin/css/material.css" rel="stylesheet">
    <link href="/assets/admin/css/style.css" rel="stylesheet">
    <link href="/assets/admin/css/responsive.css" rel="stylesheet">
</head>

<body class="">
    <div class="wrapper">
        <div class="container mt-4 mt-md-5">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <img src="/assets/admin/images/logo.png" class="login-logo" alt="" />
                </div>
                <div class="col-md-5">
                    <div class="login-bg">
                        <div class="row">
                            <div class="col-md-12">
                                <form autocomplete="off" id="login-form" method="POST" action="/forget-password">
                                    @csrf
                                    <input type="hidden" name="type" value="admin">
                                    <div class="head-title mb-4">
                                        <h2>Forgot password</h2>
                                        <h5>Enter your registered email address to verify</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email address</label>
                                                <input type="text" name="email" class="form-control"
                                                    value="{{ old('email') }}"
                                                    placeholder="Enter your Email-Address" />
                                                <i class="fas fa-envelope"></i>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @if (Session::has('flash_notification.message'))
                                        <p>
                                        <div class="form-group">
                                            <h5 style="color:{{ Session::get('flash_notification.level') == 'success' ? 'green' : 'red' }};"
                                                class="f-16">
                                                {{ Session::get('flash_notification.message') }}</h5>
                                        </div>
                                        </p>
                                    @endif
                                    <div class="row mt-2">
                                        <div class="col-12 text-right">
                                            <a href="/" class="forgetlink">Back to login</a>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-7">
                                            <button type="submit" class="btn login-btn btn-block btn-primary">
                                                Send an OTP
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="col-md-7 d-none d-md-block">
                                <img alt="" src="/assets/admin/images/login-img.png" class="login-img" />
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center login-foot">
                    <a href="#">Terms of Use</a> <a href="/privacy-policy">Privacy Policy</a>
                    <p>© Copyright 2023 MyxTV Media. All rights reserved.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/assets/admin/js/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/admin/js/main.js"></script>
</body>

</html>
