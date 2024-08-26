<!doctype html>
<html lang="en-US" class="no-js" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="/assets/site/images/favicon.png">

    <title>@section('title') SUR-MESURE @show</title>
    
    <meta name="description" content="@section('meta_description')  MidiTech @show" />
    <meta name="Language" content="en-US"/>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Georgia:300,400,700">
    <link rel="stylesheet" href="/assets/frontend/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/frontend/css/magnific-popup.css">
    <link rel="stylesheet" href="/assets/frontend/css/jquery-ui.css">
    <link rel="stylesheet" href="/assets/frontend/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/frontend/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/assets/frontend/css/aos.css">
    <link rel="stylesheet" href="/assets/frontend/css/style.css">
    <link rel="stylesheet" href="/assets/frontend/css/responsive.css" type="text/css">
    <link rel="stylesheet" href="/assets/frontend/css/select2.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="/assets/frontend/css/mdb.min.css" rel="stylesheet" />

</head>

<body>
    @include('partials.header')

    @yield('content')
    @include('partials.footer')

    <!-- jQuery library -->
    <script src="/assets/frontend/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/frontend/js/jquery-ui.js"></script>
    <script src="/assets/frontend/js/popper.min.js"></script>
    <script src="/assets/frontend/js/bootstrap.min.js"></script>
    <script src="/assets/frontend/js/owl.carousel.min.js"></script>
    <script src="/assets/frontend/js/jquery.magnific-popup.min.js"></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <script src="/assets/frontend/js/aos.js"></script>
    <script src="/assets/frontend/js/slick.min.js"></script>
    <script src="/assets/frontend/js/slick-custom.js"></script>

    <script src="/assets/frontend/js/main.js"></script>

    <script src="/assets/frontend/js/select2.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    @yield('scripts')

</body>
</html>
