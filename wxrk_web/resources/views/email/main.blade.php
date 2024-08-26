<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>AIMS Buildmart</title>
		<link rel="stylesheet" href="{{ config('app.web_url_font') }}">
		<style type="text/css">
			@media screen and (max-width:767px){
				table{width:100% !important;table-layout:fixed!important;}
				.innerTable td{padding-left:20px!important;padding-right:20px!important;}
				.creditBenefitTable > tbody > tr > td {height:238px !important;vertical-align:!important;}
				#theImage,#theRect{height:238px !important;}
				.creditBenefit td{width:100%!important;padding-left:20px!important;padding-right:20px!important;display:block!important;text-align:center!important;}
				.creditBenefit td h1{padding-bottom:10px!important;}
			}
		</style>
	</head>
	<body style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#000;font-weight:500;text-rendering:optimizeLegibility;font-size:14px;word-break:break-word;-ms-word-break:break-word;margin:0;background:#ececec;">
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" bgcolor="#ececec" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:600px;max-width:100%;margin:auto;-webkit-box-shadow:0px 0px 4px 8px rgba(0,0,0,0.4);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.4);background:#ececec;">
			<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
				<td align="center" valign="top" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
					<table border="0" cellpadding="0" cellspacing="0" width="600" class="innerTable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:600px;max-width:100%;margin:auto;">
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td align="center" valign="middle" bgcolor="#222222" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:20px;padding-bottom:20px;">
								<img src="{{ URL::asset('assets/media/images/logo.png')}}" width="95" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;vertical-align:middle;">
							</td>
						</tr>
            @yield('content')
        <tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
				<td align="center" valign="top" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
					<table border="0" cellpadding="20" cellspacing="0" width="600" class="innerTable footer" bgcolor="#222222" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:600px;max-width:100%;margin:auto;background:#fff;background:#222222;color:#fff;padding-top:0px;padding-bottom:0px;">
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td align="center" valign="middle" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:30px;padding-bottom:10px;">
								<img src="{{ URL::asset('assets/media/images/logo.png')}}" alt="IconParking" height="34" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">&nbsp;&nbsp;&nbsp;
								<img src="{{ URL::asset('assets/media/images/quiklogo.png')}}" alt="QuikPark" height="34" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td align="center" valign="middle" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-weight:normal;">
								<font face="'Open Sans', Helvetica, Arial, sans-serif">WE PARK NEW YORK&trade;</font><br style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;"/>
								<a href="https://www.facebook.com/IconParkingNYC" target="_blank" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;color:#ED8222;cursor:pointer;text-decoration:none;"><img src="{{ URL::asset('assets/media/images/fb.png')}}" alt="" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;"></a>&nbsp;&nbsp;&nbsp;<a href="https://twitter.com/IconParkingNYC" target="_blank" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;color:#ED8222;cursor:pointer;text-decoration:none;"><img src="{{ URL::asset('assets/media/images/tw.png')}}" alt="" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;"></a>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td align="center" valign="middle" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-weight:normal;">
								<font face="'Open Sans', Helvetica, Arial, sans-serif">Download the Icon GO app for iPhone and Android now.</font>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td align="center" valign="middle" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;padding-top:10px;">
								<img src="{{ URL::asset('assets/media/images/app_icon.png')}}" alt="" height="30" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">&nbsp;&nbsp;
								<a href="https://itunes.apple.com/us/app/icon-parking/id394377820?mt=8" target="_blank" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;color:#ED8222;cursor:pointer;text-decoration:none;"><img src="{{ URL::asset('assets/media/images/appstore.png')}}" alt="" height="30" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;"></a>&nbsp;&nbsp;
								<a href="https://play.google.com/store/apps/details?id=com.iconparking&hl=en" target="_blank" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;color:#ED8222;cursor:pointer;text-decoration:none;"><img src="{{ URL::asset('assets/media/images/google-play.png')}}" alt="" height="30" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;"></a>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td align="center" valign="middle" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:30px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;color:#fff;font-weight:normal;">
								<font face="'Open Sans', Helvetica, Arial, sans-serif">This email was sent by Icon Parking Systems.</font><br style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;text-decoration: none !important;"/>
								<a style="color: #fff!important; text-decoration: none!important;" href="mailto:{{ config('app.web_url') }}">
									<font face="'Open Sans', Helvetica,'Helvetica Neue', Arial, sans-serif"  color="#FFFFFF">{{ config('app.web_url') }}</font>
								</a>
								<br style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;text-decoration: none !important;"/>
								<a style="color: #fff!important; text-decoration: none!important;" href="mailto:{{ config('icon.customer_service_email') }}">

								<font  face="'Open Sans', 'Helvetica Neue', Helvetica,  Arial, sans-serif" color="#FFFFFF" >{{ config('icon.customer_service_email') }}</font></a>

								 or <a href="tel:{{ config('icon.webphone') }}" style="color: #fff!important; text-decoration: none!important;">
								 <font   face="'Open Sans', Helvetica, Arial, sans-serif" color="#FFFFFF"> {{ config('icon.webphone') }}</font></a>

							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>