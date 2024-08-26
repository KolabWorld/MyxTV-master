@extends('email.main-plain-text')

@section('content')

FORGET SOMETHING? NO SWEAT.

A password reset has been requested for an {{ config('icon.name') }} account with this email address.
If you did not request this, or you requested this by accident, you can ignore this email.

Reset Password, Please copy and paste the following link into your browser address bar.
{{ $resetLink }}

@endsection
