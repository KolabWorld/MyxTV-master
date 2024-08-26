<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>B2B Ecommerce | Reset Password Panel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="/assets/admin/css/font-awesome.css" rel="stylesheet">
    <link href="/assets/admin/css/font.css" rel="stylesheet">
    <link href="/assets/admin/css/style.css" rel="stylesheet">
    <link href="/assets/admin/css/responsive.css" rel="stylesheet">
    <!-- MDB -->
    <link href="/assets/admin/css/mdb.min.css" rel="stylesheet" />

   

</head>

<body class="">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-box">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 px-0">
                                <div class="loginImg">
                                    <img src="/assets/admin/img/women.jpg" class="d-none d-sm-block left-img"/>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <div class="loginPanel">
                                    <div class="mb-1"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                                    <div class="subTitle">Set New Password</div>
                                    <div class="loginForm">
                                        <!-- Form -->
                                        <form autocomplete="off" id="login-form" method="POST" action="{{ url('designer/reset-password') }}">
                                            @csrf
                                            <!-- Password -->
                                            <div class="md-form">
                                                <input type="hidden" name="token" value="{{ Request::get('token') }}">
                                                <input type="password" id="materialLoginFormPassword" name="password" class="form-control">
                                                <label for="materialLoginFormPassword">New Password</label>
                                            </div>

                                            @error('password')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror

                                            <div class="md-form">
                                                <input type="password" id="materialLoginFormPassword" name="password_confirmation" class="form-control">
                                                <label for="materialLoginFormPassword">Confirm Password</label>
                                            </div>

                                            @error('password_confirmation')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                            
                                            <!-- Remember me -->
                                            <input class="filled-in" name="group1" type="checkbox" id="d1">
                                            {{-- <label for="d1">Remember Me</label> --}}
                                            <div class="lgBtn">
                                                <!-- Sign in button -->
                                                <button type="submit" class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 new-paddLogin text-uppercase">SET NEW PASSWORD</button>
                                                <!-- <button type="button" onclick="window.location.href='/designer/forget-password'" class="btn btn-link mt-3 btn-block">FORGOT YOUR PASSWORD</button> -->
                                            </div>
                                        </form>
                                        <!-- Form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/assets/admin/js/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/admin/js/adminlte.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
</body>

</html>