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
                                        <img src="/assets/admin/img/women.jpg" class="d-none d-sm-block left-img" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <div class="loginPanel">
                                        <div class="mb-1"><img src="/assets/frontend/img/logo/logo-black.png"></div>
                                        <div class="subTitle">Forgot Password</div>
                                        <div class="loginForm">
                                            <!-- Form -->
                                            <form autocomplete="off" id="login-form" method="POST" action="/seller/forget-password">
                                                @csrf
                                                <input type="hidden" name="type" value="designer">
                                                <!-- Email -->
                                                <div class="md-form">
                                                    <input type="email" id="materialLoginFormEmail" class="form-control" name="email" value="" placeholder="Enter Email address">
                                                    <label for="materialLoginFormEmail">Email address</label>
                                                    
                                                </div>
                                                @error('email')
                                                    <label class="text-danger">{{ $message }}</label>
                                                @enderror

                                                @if(isset($errorMessage) && $errorMessage)
                                                    <p>
                                                        <div class="form-group">
                                                            <h5 style="color:red;">{{$errorMessage}}</h5>
                                                        </div>
                                                    </p>    
                                                @endif 

                                                @if(isset($successMessage) && $successMessage)
                                                    <p>
                                                        <div class="form-group">
                                                            <h5 style="color:green;">{{$successMessage}}</h5>
                                                        </div>
                                                    </p>    
                                                @endif 

                                                <div class="lgBtn">
                                                    <!-- Sign in button -->
                                                    <button type="submit" class="btn btn-outline-dark btn-rounded btn-block my-4 z-depth-0 new-paddLogin">RECOVER PASSWORD</button>
                                                    <button type="button" onclick="window.location.href='/seller/login'" class="btn btn-link mt-3 btn-block">DIDN’T FORGET ? LOGIN HERE</button>
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