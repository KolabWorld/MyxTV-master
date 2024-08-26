@extends('email.main-plain-text')

@section('content')

WE PARK NEW YORK

HI {{ strtoupper($username) }}, THANKS FOR JOINING US.

Before you can access your account, you need to confirm your email address.

Confirm Your Email by copy and paste the following link into your browser address bar.

{{ $link }}

@endsection
