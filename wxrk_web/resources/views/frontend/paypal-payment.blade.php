@extends('frontend.app')
@section('content')
	<!-- Main Container  -->
	<div class="main-container container">
		<div id=content>     
		    <div class="product-view row">
				<div class="col-xs-12 col-sm-12 col-md-12 right-part" style="background: #fff;margin-top:1%;box-shadow: 0 1px 3px rgba(0,0,0,.2);">
                    @if(isset($message))
                        <h4 style="font-style: italic;color:green">
                            {{$message}}
                        </h4>
                    @endif    
					<div class="right-part">
				        <div class="invoice" style="margin-top: 25px;"> 
                            <div class="jumbotron text-center">
                                <h2 class="display-3"><strong>Payment Through paypal.</strong></h2>
                                <br/>
                                <h3> Please click on paypal checkout button..</h3>
                                <hr>
                                <div id="paypal-button"></div>
                            </div>
                        </div>
					</div>

                    <form action="/paypal-response" method="post" id="responseForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="transaction_id" value="{{$paymentTransaction->id}}">
                        <input type="hidden" name="subscription_log_id" value="{{ isset($subscriptionPlanLog) && $subscriptionPlanLog ? $subscriptionPlanLog->id : ''}}">
                        <input type="hidden" name="response" id="paypalResponse" value="">
                    </form>
                    {{--  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmTransaction" id="frmTransaction">
                        <input type="hidden" name="business" value="{{$paypal_id}}">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="item_name" value="{{$product->name}}">
                        <input type="hidden" name="item_number" value="{{$product->id}}">
                        <input type="hidden" name="amount" value="{{$product->price}}">   
                        <input type="hidden" name="currency_code" value="USD">   
                        <input type="hidden" name="cancel_return" value="http://demo.expertphp.in/payment-cancel">
                        <input type="hidden" name="return" value="http://demo.expertphp.in/payment-status">
                    </form>  --}}
                     
                    {{-- <script>document.frmTransaction.submit();</script> --}}
		        </div>
		    </div>
		</div>    
	</div>
	<!-- //Main Container  -->  
@endsection 

@section('styles')
    <style type="text/css">
        .side-main {
            /*padding: 0 0 12px 20px;*/
            text-transform: uppercase;
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }
        .hrline{
            height: 10px;
            width:100%;
        }
        #hrline
        {
            width: 100%;
            color: #ffffff; 
            margin-left: -50px; 
        }

        th { font-size: 11px;
            text-align: center;
        }
        td { font-size: 10px !important; }
        .heading1 {
            font-size: 20px; font-weight: bold;
        }
        .heading2{
            font-size: 15px; 
            font-weight: bold;   
            margin-bottom: 10px;
        }
        .f15 {
            font-size: 15px;
        }
        .f12 {
            font-size: 12px;
        }
        .f10 {
            font-size: 10px;
        }
        .logo {
            height: 70px;
        }

        #addresses
        {
            margin-bottom: 15px;
            margin-top: 5px;
        }

        .address {
            margin-left: 15px;
            float: left;
            line-height: 15px;
            border: 1px solid #000;
            padding: 10px;
            height: 125px;
            width: 45%;
        }

        #table{
            border: 1px solid #000 !important;
        }

        th, td  {
            border-right: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
        }
    </style>
@endsection

@section('scripts')
    @parent

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <script type="text/javascript">

        paypal.Button.render({
            // Configure environment
            env: 'sandbox',
            client: {
                sandbox: 'AdvCddelJXaiGp8oi-rtRxndZgXh_bXgzmSnOkfnquX54znnD1JyGqY9acKiCSnFbZLtmyogtc3NbcrJ',
                production: 'AQrSD1nmdqOiVwoINTK3TkF1V5spxcXZhHYJtla6MxVR8jLMcx6Bz6JtNUu9I4hTVFL8O1Ufg2F2lMtK'
            },
            // Customize button (optional)
            locale: 'en_US',
            style: {
                size: 'small',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,
            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: '{{$paymentTransaction ? $paymentTransaction->amount : ""}}',
                            currency: '{{$paymentTransaction ? $paymentTransaction->currency_code : ""}}',
                        },
                        description: 'The payment transaction description.',
                        invoice_number: '{{$paymentTransaction ? $paymentTransaction->channel_order_id : ""}}', 
                    }],
                    note_to_payer: 'Contact us for any questions on your order.'
                });
            },

            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function(response) {
                    // Show a confirmation message to the buyer
                    // console.log(response);
                    $('#paypalResponse').val(JSON.stringify(response));
                    $('#responseForm').submit();
                    // window.alert('Thank you for your purchase!');
                });
            }
        }, '#paypal-button');

        $(document).ready(function () { 
            // $('button.paypal-button.large').click();
            // $('#paymentForm').submit();
        });
    </script>
@endsection   