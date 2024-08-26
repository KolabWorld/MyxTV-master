

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Miditech</title>
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
							<td align="center" valign="middle" bgcolor="#0c4ca3" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-left:40px;padding-right:40px;padding-top:20px;padding-bottom:20px;">

								<p><img style="display: block; margin-left: auto; margin-right: auto;" src="/frontend/images/logo.png" alt="logo" /></p>
								<h1 style="text-align: center;color: white">Miditech</h1>
							</td>
						</tr>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="600" class="innerTable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:600px;max-width:100%;margin:auto;">
						<tbody>
							<td align="center" valign="middle" >
								<h3>
									<b> Dear {{$body->name}} {{$body->message}}</b>
								</h3>
								<h4>
									<b>Name : </b> {{$body->name}}
								</h4>
								<h4>
									<b>Contact Number : </b> {{$body->mobile}}
								</h4>
								<h4>
									<b>Email Id : </b> {{$body->email}}
								</h4>
							</td>
						</tbody>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" width="600" class="innerTable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:600px;max-width:100%;margin:auto;">
						<tbody>
							<tr>
								<td style="width: 637px;background-color: #0a203f;color: white;">
									<p class="text-center" style="font-size: 14px; text-align: center;">&copy; 2020 Miditech All rights reserved</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
