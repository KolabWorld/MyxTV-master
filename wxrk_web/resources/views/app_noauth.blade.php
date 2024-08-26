<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>@section('title') MidiTech @show</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="/assets/site/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
    <link href="/assets/site/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <!--<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
    <link href="/assets/site/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="/assets/site/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/assets/site/css/glamstudios.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/site/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/site/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <link href="/assets/site/css/custom.css" rel="stylesheet" type="text/css" />

    @yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
/* Colorbox corrections
-------------------------------------------------- */

#colorbox, #cboxOverlay, #cboxWrapper{position:absolute; top:0; left:0; z-index:9999; overflow:hidden;}
#cboxWrapper {max-width:none;}
#cboxOverlay{position:fixed; width:100%; height:100%;}
#cboxMiddleLeft, #cboxBottomLeft{clear:left;}
#cboxContent{position:relative;}
#cboxLoadedContent{overflow:auto; -webkit-overflow-scrolling: touch;}
#cboxTitle{margin:0;}
#cboxLoadingOverlay, #cboxLoadingGraphic{position:absolute; top:0; left:0; width:100%; height:100%;}
#cboxPrevious, #cboxNext, #cboxClose, #cboxSlideshow{cursor:pointer;}
.cboxPhoto{float:left; margin:auto; border:0; display:block; max-width:none; -ms-interpolation-mode:bicubic;}
.cboxIframe{width:100%; height:100%; display:block; border:0; padding:0; margin:0;}
#colorbox, #cboxContent, #cboxLoadedContent{box-sizing:content-box; -moz-box-sizing:content-box; -webkit-box-sizing:content-box;}

/* 
    User Style:
    Change the following styles to modify the appearance of Colorbox.  They are
    ordered & tabbed in a way that represents the nesting of the generated HTML.
*/
#cboxOverlay{background:#000; opacity: 0.9; filter: alpha(opacity = 90);}
#colorbox{outline:0;}
    #cboxContent{margin-top:20px;background:#000;}
        .cboxIframe{background:#fff;}
        #cboxError{padding:50px; border:1px solid #ccc;}
        #cboxLoadedContent{border:5px solid #000; background:#fff;}
        #cboxTitle{position:absolute; top:-20px; left:0; color:#ccc;}
        #cboxCurrent{position:absolute; top:-20px; right:0px; color:#ccc;}
        #cboxLoadingGraphic{background:url(images/loading.gif) no-repeat center center;}

        /* these elements are buttons, and may need to have additional styles reset to avoid unwanted base styles */
        #cboxPrevious, #cboxNext, #cboxSlideshow, #cboxClose {border:0; padding:0; margin:0; overflow:visible; width:auto; background:none; }
        
        /* avoid outlines on :active (mouseclick), but preserve outlines on :focus (tabbed navigating) */
        #cboxPrevious:active, #cboxNext:active, #cboxSlideshow:active, #cboxClose:active {outline:0;}
        
        #cboxSlideshow{position:absolute; top:-20px; right:90px; color:#fff;}
        #cboxPrevious{position:absolute; top:50%; left:5px; margin-top:-32px; background:url(images/controls.png) no-repeat top left; width:28px; height:65px; text-indent:-9999px;}
        #cboxPrevious:hover{background-position:bottom left;}
        #cboxNext{position:absolute; top:50%; right:5px; margin-top:-32px; background:url(images/controls.png) no-repeat top right; width:28px; height:65px; text-indent:-9999px;}
        #cboxNext:hover{background-position:bottom right;}
        #cboxClose{position:absolute; top:5px; right:5px; display:block; background:url(images/controls.png) no-repeat top center; width:38px; height:19px; text-indent:-9999px;}
        #cboxClose:hover{background-position:bottom center;}

#cboxLoadingGraphic {
  background: url(/img/loading.gif) no-repeat center center; }

#cboxPrevious {
  position: absolute;
  top: 50%;
  left: 5px;
  margin-top: -32px;
  background: url(/img/controls.png) no-repeat top left;
  width: 28px;
  height: 65px;
  text-indent: -9999px; }

#cboxNext {
  position: absolute;
  top: 50%;
  right: 5px;
  margin-top: -32px;
  background: url(/img/controls.png) no-repeat top right;
  width: 28px;
  height: 65px;
  text-indent: -9999px; }

#cboxClose {
  position: absolute;
  top: 5px;
  right: 5px;
  display: block;
  background: url(/img/controls.png) no-repeat top center;
  width: 38px;
  height: 19px;
  text-indent: -9999px; }

    </style>
  </head>
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">
        @include('partials.nav_noauth')
        @include('flash::message')
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('partials.footer')
        @include('partials.right-side')
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="/assets/site/js/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="/assets/site/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="/assets/site/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/site/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="/assets/site/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/assets/site/plugins/fastclick/fastclick.min.js'></script>
    <script src="/assets/site/js/app.min.js" type="text/javascript"></script>
    <script src="/assets/site/js/demo.js" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-dataTables-paging.js')}}"></script>
<script src="{{asset('assets/admin/js/datatables.fnReloadAjax.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.colorbox.js')}}"></script>
<script src="{{asset('assets/admin/js/modal.js')}}"></script>
    <!-- page script -->
    @yield('scripts')
    </body>
</html>
