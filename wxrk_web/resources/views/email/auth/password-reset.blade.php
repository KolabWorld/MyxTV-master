@extends('email.main')
@section('content')
	<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:40px;padding-left:40px;padding-right:40px;padding-bottom:20px;text-align:left;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<h2 class="text-primary text-uppercase" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;font-size:24px;line-height:1.1;font-weight:600;margin:0;color:#ed8222;text-transform:uppercase;"><font face="'Open Sans', Helvetica, Arial, sans-serif">Forget something? No sweat.</font></h2>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:0px;padding-left:40px;padding-right:40px;padding-bottom:10px;text-align:left;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<p style="font-size:15px;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0;line-height:1.2;"><font face="'Open Sans', Helvetica, Arial, sans-serif">A password reset has been requested for an {{ config('icon.name') }} account with this email address.</font></p>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:0px;padding-left:40px;padding-right:40px;padding-bottom:0px;text-align:left;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.2;">
								<p style="font-size:15px;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0;"><font face="'Open Sans', Helvetica, Arial, sans-serif">If you did not request this, or you requested this by accident, you can ignore this email.</font></p>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-top:30px;padding-bottom:30px;background-color:#fff;padding-left:40px;padding-right:40px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<a type="button" href="{{ $resetLink }}" class="btn btn-primary btn-fill" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration:none;padding:7.5px 25px;font-size:15px;border:2px solid #ddd;text-transform:uppercase;letter-spacing:1px;font-weight:600;line-height:1.42857143;box-shadow:none;outline:0;color:#000;border-color:#ED8222;display:inline-block;white-space:nowrap;box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;"><font face="'Open Sans', Helvetica, Arial, sans-serif">Reset Password</font></a>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-top:0px;padding-bottom:20px;background-color:#fff;padding-left:40px;padding-right:40px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<p style="font-size:15px;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;"><font face="'Open Sans', Helvetica, Arial, sans-serif">If clicking the button does not work, copy and paste the following link into your browser address bar.</font></p>
							</td>
						</tr>
						<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
							<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding-top:0px;padding-bottom:40px;background-color:#fff;padding-left:40px;padding-right:40px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
								<p class="breakAll selectable" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;margin:0; -webkit-user-select:text;-moz-user-select:text;-ms-user-select:text;-o-user-select:text;user-select:text;-ms-word-break:break-all;word-break:break-all;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:13px;color:#000;word-break:break-all;">
									<font face="'Open Sans', Helvetica, Arial, sans-serif">{{ $resetLink }}</font>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
@endsection
