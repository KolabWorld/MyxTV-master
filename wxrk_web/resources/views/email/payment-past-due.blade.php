@extends('email.main')

@section('content')
<h3>Your monthly parking payment is past due and your vehicle should already be on hold</h3>
    <ul>
    <li>All monthly parking charges are due on the 1st day of each month.</li>
    <li>Payments not received by the 10th day of the month are subject to daily rates and/or late fees and your vehicle may be placed on hold until full payment is received.</li>
    <li>You must bring payment or proof of payment to the garage in order for your vehicle to be released.</li>
    <li>A $25.00 late fee has been added to your account balance.</li>

    </ul>

    <p><strong style="color:#d04801;">Pay Online:</strong><br>
    Visit our website, <a href="{{config('app.web_url')}}">{{config('app.web_url')}}</a>, to make your payment immediately. Online payments will post to your account within 24-48 hours. </p>

    <p><strong style="color:#d04801;">Pay By Phone:</strong> <br>
    Call (855) 880 4941. Please note that you will not receive a receipt when you pay by phone and your car may still be held.</p>

    <p>This is an auto generated email. Please do not respond to this email.</p>

    <p>
    We thank you for your continued patronage.</p>
    <p><strong>Sincerely,</strong><br> Your {{ config('icon.name') }} Team
</p>
@endsection
