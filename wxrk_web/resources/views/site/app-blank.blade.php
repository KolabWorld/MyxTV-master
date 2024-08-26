<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>@section('title') MidiTech @show</title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="robots" content="NOINDEX,NOFOLLOW">

		<link rel="icon" type="image/png" href="/assets/site/img/favicon.png">

		<link rel="stylesheet" href="/assets/site/css/style.css">
		<link rel="stylesheet" href="/assets/site/css/custom.css">
	    <!-- Font Awesome Icons -->
	    <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	    <!-- Ionicons -->
    	<link href="/assets/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
		@yield('styles')
	</head>

	<body class="hidden-sidebar">

		<div id="main-area">
			@yield('content')
		</div>

		<script src="/assets/site/js/libs/jquery-1.12.0.min.js"></script>
		<script src="/assets/site/js/libs/bootstrap-3.3.6.min.js"></script>
		<script src="/assets/site/js/libs/jquery-ui-1.11.4.min.js"></script>
		<script src="/assets/site/js/libs/select2-4.0.1.full.min.js"></script>
		<script src="/assets/site/js/libs/dropzone-4.2.0.min.js"></script>

		<script defer="" src="/assets/site/js/plugins.js"></script>
		<script defer="" src="/assets/site/js/scripts.min.js"></script>
		<script src="/assets/site/js/libs/bootstrap-datepicker.min.js"></script>

		<!-- page script -->
    	@yield('scripts')
	</body>

</html>
