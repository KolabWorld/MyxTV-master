<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="/assets/web/images/favicon.png" type="image/png" sizes="16x16">
        <title>MyxTV</title>
        <link rel="stylesheet" href="/assets/web/css/style.css">
        <link rel="stylesheet" href="/assets/web/css/font-awesome.css">
        <link rel="stylesheet" href="/assets/web/css/fontawesome-free/css/fontawesome.min.css">
        @yield('styles')
    </head>
    
    <body>
        @include('frontend.partials.web-header')
        
        <div class="main"> 
            @include('frontend.partials.flash-message')
            @yield('content')
            @yield('modals')
        </div>

        @include('frontend.partials.loader')
        @include('frontend.partials.web-footer')
        
        <script src="/assets/web/js/jquery-3.5.1.min.js"></script>
        <script src="/assets/web/js/propper.min.js"></script>
        <script src="/assets/web/js/bootstrap.min.js"></script> 
        <script src="/assets/web/js/owl.carousel.min.js"></script>   
        <script src="/assets/web/js/main.js"></script>
        <script>
            var app_url = "{{ config('app.api_url') }}";
            var base_url = "{{ config('app.url') }}";
            var bearer_token = 'Bearer <?= session('auth_access_token') ?>';

            $.ajaxSetup({
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Authorization': bearer_token,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('scripts')
    </body>
</html>