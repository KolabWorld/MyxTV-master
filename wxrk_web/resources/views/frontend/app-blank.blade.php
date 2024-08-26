<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Work Study</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <link href="/assets/admin/css/material.css" rel="stylesheet"> 
        <link href="/assets/admin/css/style.css" rel="stylesheet">
        <link href="/assets/admin/css/responsive.css" rel="stylesheet">
        @yield('styles')
    </head>

    <body>
        <div class="wrapper">
            <div class="" style="margin:0px 180px">
                @include('frontend.partials.flash-message')     
                <!-- Content Wrapper. Contains page content -->
                @yield('content')
            </div>
        </div>

        <!-- jQuery -->
        <script src="/assets/admin/js/jquery.min.js"></script>
        <script src="/assets/admin/js/jquery-ui.min.js"></script>
        <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <script src="/assets/admin/js/main.js"></script>
        @yield('scripts')
    </body>
</html>