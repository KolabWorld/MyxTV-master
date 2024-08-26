<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>B2B Ecommerce | Seller Panel</title>

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
                                    <div class="subTitle">Secure Seller Panel</div>
                                    <div class="loginForm">
                                        <!-- Form -->
                                        <form autocomplete="off" id="login-form" method="POST" action="{{ route('designer-login') }}">
                                            @csrf
                                            <!-- Email -->
                                            <div class="md-form">
                                                <input type="email" id="materialLoginFormEmail" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Email address">
                                                <label for="materialLoginFormEmail">Email address</label>
                                                
                                            </div>
                                            @error('email')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror

                                            <!-- Password -->
                                            <div class="md-form">
                                                <input type="password" id="materialLoginFormInputPassword" name="password" class="form-control" value="{{ old('password') }}" placeholder="Enter Password">
                                                <label for="materialLoginFormInputPassword">Password</label>
                                                <a href="#"><img src="/assets/admin/img/eye.svg"  width="20" class="eyeIcon" id="materialLoginFormShowPassword" onclick="showPassword('materialLoginForm')" /></a>
                                                <a href="#"><img src="/assets/admin/img/eyeclose.svg" width="20" class="eyeIcon" id="materialLoginFormHidePassword" onclick="hidePassword('materialLoginForm')" style="display : none;" /></a>
                                            </div>
                                            @error('password')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror

                                            @if(isset($errorMsg) && $errorMsg)
                                                <p>
                                                    <div class="form-group">
                                                        <h5 style="color:red;">{{$errorMsg}}</h5>
                                                    </div>
                                                </p>    
                                            @endif 
                                            @if (Session::has('flash_notification.message'))
                                                <p>
                                                    <div class="form-group">
                                                        <h5 style="color:{{ Session::get('flash_notification.level') == 'success' ? 'green':'red' }};">{{ Session::get('flash_notification.message') }}</h5>
                                                    </div>
                                                </p>    
                                            @endif 
                                            

                                            <!-- Remember me -->
                                            <input class="filled-in" name="remember" type="checkbox" id="d1" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="d1">Remember Me</label>
                                            <div class="lgBtn">
                                                <!-- Sign in button -->
                                                <button type="submit" onclick="window.location.href='otp.html'" class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 new-paddLogin text-uppercase">LOGIN TO B2B Marketplace</button>
                                                <button type="button" onclick="window.location.href='/seller/forget-password'" class="btn btn-link mt-3 btn-block">FORGOT YOUR PASSWORD</button>
                                                <button type="button" onclick="window.location.href='/seller/sign-up'" class="btn btn-link mt-3 btn-block">REGISTER YOURSELF AS SELLER</button>
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
    <script>
        function showPassword(tabModule) {
            $('#' + tabModule + 'InputPassword').attr('type','text');
            $('#' + tabModule + 'ShowPassword').hide();
            $('#' + tabModule + 'HidePassword').show();
        }

        function hidePassword(tabModule) {
            $('#' + tabModule + 'InputPassword').attr('type','password');
            $('#' + tabModule + 'ShowPassword').show();
            $('#' + tabModule + 'HidePassword').hide();
        }

    </script>
    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/assets/admin/js/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/admin/js/adminlte.js"></script>
    <!-- <script src="/js/custom-script.js"></script> -->
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
</body>

</html>