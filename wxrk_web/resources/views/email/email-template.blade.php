<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta http-equiv="Content-Type" content="text/html charset=UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>SUR-MESURE</title>
	    <link rel="stylesheet" href="{{ config('app.web_url_font') }}">
	    <style type="text/css">
	        @media screen and (max-width:767px) {
	            table {
	                width: 100% !important;
	                table-layout: fixed!important;
	            }
	            .innerTable td {
	                padding-left: 20px!important;
	                padding-right: 20px!important;
	            }
	            .creditBenefitTable > tbody > tr > td {
	                height: 238px !important;
	                vertical-align: !important;
	            }
	            #theImage,
	            #theRect {
	                height: 238px !important;
	            }
	            .creditBenefit td {
	                width: 100%!important;
	                padding-left: 20px!important;
	                padding-right: 20px!important;
	                display: block!important;
	                text-align: center!important;
	            }
	            .creditBenefit td h1 {
	                padding-bottom: 10px!important;
	            }
	        }
	        
	        .msgbody {
	            color: #505050;
	            font-family: Verdana;
	            font-size: 11px;
	            padding: 20px;
	        }
	    </style>
	</head>
	<body style="background-color:rgb(250,250,250);font-family: Verdana;line-height: 150%;font-size: 14px;">
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" bgcolor="#ececec" style="border-collapse:collapse!important;margin:0px;padding:0px;height:100%!important;width:100%!important;background-color:rgb(250,250,250);">
	        <tr>
	            <td align="center" style="height: 100%!important;width: 100%!important;padding: 20px;">
	                <table border="0" cellpadding="0" cellspacing="0" id="m_-5364118287750524320x_templateContainer" style="/* border-collapse:collapse!important; *//* width:100%; */border:1px solid rgb(221,221,221);background-color:rgb(255,255,255);width:100%;">
	                    <tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
	                        <td align="center" valign="top" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
	                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="innerTable" style="border-collapse:collapse!important;width:100%;background-color: rgb(250,250,250);">
	                                <tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
	                                    <td align="center" valign="middle" style="border-bottom: 1px solid rgb(221,221,221);">
	                                        <p>
	                                        	<img style="display: block;" src="http://staging-hugrs.staqo.com/wxrk_html/images/logo.png" alt="logo" />
	                                        </p>
	                                        {{ $mailSubject }}
	                                    </td>
	                                </tr>
	                            </table>
	                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="innerTable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:100%;max-width:100%;margin:auto;">
	                                <tbody>
	                                    <td class="msgbody" style="padding:20px;font-family:Verdana;font-size:11px">
	                                        {!! $description !!}
	                                    </td>
	                                </tbody>
	                            </table>
	                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="innerTable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:100%;max-width:100%;margin:auto;">
	                                <tr>
	                                    <td style="padding-left: 24px;font-family:Verdana;font-size:11px;"></td>
	                                </tr>
	                            </table>
	                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="innerTable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;width:100%;max-width:100%;margin:auto;margin-top: 2% !important;">
	                                <tbody>
	                                    <tr>
	                                        <td style="width: 637px;background-color: #0a203f;color: white;">
	                                            <p class="text-center" style="font-size: 12px; text-align: center;">&copy; 2021 Staqo All rights reserved</p>
	                                        </td>
	                                    </tr>
	                                </tbody>
	                            </table>
	                        </td>
	                    </tr>
	                </table>
	            </td>
	        </tr>
	    </table>
	</body>
</html>