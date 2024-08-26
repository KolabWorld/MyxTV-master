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

		@include('site.partials.nav')

		<div id="main-area">

			<div id="modal-placeholder">@yield('modal')</div>

			@yield('content')
		</div>

		<!-- <div id="fullpage-loader" style="display: none">
			<div class="loader-content">
				<i class="fa fa-cog fa-spin"></i>
				<div id="loader-error" style="display: none">
					It seems that the application stuck because of an error.<br>
					<a href="/faq" class="btn btn-primary btn-sm" target="_blank">
						<i class="fa fa-support"></i> Get Help </a>
				</div>
			</div>
		</div> -->

		@include('site.partials.right-side')

		<script src="/assets/site/js/libs/jquery-1.12.0.min.js"></script>
		<script src="/assets/site/js/libs/bootstrap-3.3.6.min.js"></script>
		<script src="/assets/site/js/libs/jquery-ui-1.11.4.min.js"></script>
		<script src="/assets/site/js/libs/select2-4.0.1.full.min.js"></script>
		<script src="/assets/site/js/libs/dropzone-4.2.0.min.js"></script>

		<script type="text/javascript">
			Dropzone.autoDiscover = false;

			$(function () {
				$('.nav-tabs').tab();
				$('.tip').tooltip();

				$('.select2').select2();

				$('body').on('focus', ".datepicker", function () {
					$(this).datepicker({
						autoclose: true,
						format: 'dd-M-yyyy',
						language: 'en',
						weekStart: '1',
						todayBtn: true
					});
				});

			});

		</script>
		<script defer="" src="/assets/site/js/plugins.js"></script>
		<script defer="" src="/assets/site/js/scripts.min.js"></script>
		<script src="/assets/site/js/libs/bootstrap-datepicker.min.js"></script>

		<!-- page script -->
		@yield('scripts')
	</body>

</html>
