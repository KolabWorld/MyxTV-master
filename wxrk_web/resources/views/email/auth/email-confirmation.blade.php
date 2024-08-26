@extends('email.main')

@section('content')
<tr style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
							<td align="center" valign="top" bgcolor="#222222" id="signup-td" height="150" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:0px;position:relative;background:#222222 url('<?php echo $message->embed(public_path('assets/media/images/sign-up-bg_backup.jpg')); ?>') no-repeat center;background-size:cover;color:#fff;">
							<!--[if gte mso 9]>
									<v:image xmlns:v="urn:schemas-microsoft-com:vml" id="theImage" style="behavior: url(#default#VML); display: inline-block; position: absolute; width: 600px; height: 150px; top: 0; left: 0; border: 0; z-index: 1;" src="<?php echo $message->embed(public_path('assets/media/images/sign-up-bg_backup.jpg')); ?>" />
									<v:rect id="theRect" xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="display: inline-block; position: absolute; width: 600px; height: 150px; top: 0; left: 0; border: 0; z-index: 2;">
									<v:fill opacity="0%" style="z-index: 1;"/>
									<div>
									<![endif]-->
								<table width="100%" cellpadding="0" cellspacing="0" border="0" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;vertical-align:middle!important;">
										<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;vertical-align:middle;">
											<td align="center" valign="middle" style="background:transparent;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:0px!important;vertical-align:middle!important;height:150px;">
												<h2 class="text-primary text-uppercase" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;font-size:30px;font-weight:600;margin:0;color:#fff;text-transform:uppercase;line-height:1.2;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;"><font face="'Open Sans', Helvetica, Arial, sans-serif">WE PARK New york</font><!--{{ config('icon.name') }}--></h2>
											</td>
										</tr>
									</table>
									<!--[if gte mso 9]>
									</div>
									</v:fill>
									</v:rect>
								<![endif]-->
									</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:40px;padding-left:40px;padding-right:40px;padding-bottom:20px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<h2 class="text-primary text-uppercase" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;font-size:24px;font-weight:600;margin:0;color:#ed8222;text-transform:uppercase;line-height:1.2;"><font face="'Open Sans', Helvetica, Arial, sans-serif">Hi {{ $username }}, thanks for joining us.</font></h2>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:0px;padding-left:40px;padding-right:40px;padding-bottom:30px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<p style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0;font-size:15px;line-height:1.2;"><font face="'Open Sans', Helvetica, Arial, sans-serif">Before you can access your account, you need to confirm your email address.</font></p>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:0px;padding-left:40px;padding-right:40px;padding-bottom:30px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<a type="button" href="{{ $link }}" class="btn btn-primary btn-fill" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration:none;padding:0px;font-size:15px;border:9.5px solid #ED8222;border-width:9.5px 25px;text-transform:uppercase;letter-spacing:1px;font-weight:600;line-height:1.42857143;box-shadow:none;outline:0;color:#fff;background-color:#ED8222;display:inline-block;white-space:nowrap;box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;"><font face="'Open Sans', Helvetica, Arial, sans-serif">Confirm Your Email</font></a>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:0px;padding-left:40px;padding-right:40px;padding-bottom:30px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<p style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0;line-height:1.2;font-size:15px;"><font face="'Open Sans', Helvetica, Arial, sans-serif">If clicking the button does not work, copy and paste the following link into your browser address bar.</font></p>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:0px;padding-left:40px;padding-right:40px;padding-bottom:40px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<p style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0;line-height:1.2;word-break:break-all;">
									<small style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;font-size:13px;word-break: break-all;"><font face="'Open Sans', Helvetica, Arial, sans-serif">{{ $link }}</font></small>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
@endsection
