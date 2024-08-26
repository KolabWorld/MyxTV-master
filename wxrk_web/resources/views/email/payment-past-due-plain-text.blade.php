@extends('email.main-plain-text')

@section('content')
Your monthly parking payment is past due and your vehicle should already be on hold
     All monthly parking charges are due on the 1st day of each month.
    Payments not received by the 10th day of the month are subject to daily rates and/or late fees and your vehicle may be placed on hold until full payment is received.
    You must bring payment or proof of payment to the garage in order for your vehicle to be released.
    A $25.00 late fee has been added to your account balance.

    Pay Online:
    Visit our website, {{config('app.web_url')}}, to make your payment immediately. Online payments will post to your account within 24-48 hours. 

    Pay By Phone:
    Call (855) 880 4941. Please note that you will not receive a receipt when you pay by phone and your car may still be held.
    This is an auto generated email. Please do not respond to this email.
    We thank you for your continued patronage.
    Sincerely,Your {{ config('icon.name') }} Team

@endsection
