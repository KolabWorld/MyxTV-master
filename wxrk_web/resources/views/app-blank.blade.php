<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@section('title') MidiTech</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    @section('meta_keywords')
        <meta name="keywords" content="MidiTech"/>
    @show @section('meta_author')
        <meta name="author" content="Ashish Chauhan"/>
    @show @section('meta_description')
        <meta name="description" content="MidiTech"/>
    @show
    
    @yield('styles')
    <link rel="shortcut icon" href="{{{ asset('assets/admin/ico/favicon.ico') }}}">
</head>
<body>
@yield('content')

@yield('scripts')
</body>
</html>
