@extends('email.main')

@section('content')
<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
	<td style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background-color:#fff;padding-top:40px;padding-left:40px;padding-right:40px;padding-bottom:40px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
		<table border="0" cellpadding="0" cellspacing="0" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;max-width:520px;width:100%;margin:auto;background:#fff;border-collapse:collapse;">
			<tr style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">
				<td align="left" valign="middle" bgcolor="#ffffff" style="box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:0px!important;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-weight:normal;font-size:15px;">
					{!! $body !!}
				</td>
			</tr>
		</table>
	</td>
</tr>
@endsection