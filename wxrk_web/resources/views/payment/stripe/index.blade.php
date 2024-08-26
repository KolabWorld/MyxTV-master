<!DOCTYPE html>
<html>
   <body>
      <div class="container">         
         <div class="row">
            <div class="col-md-6 col-md-offset-3">
               <div class="panel panel-default credit-card-box">
                     <form role="form" action="{{ route('make-stripe-payment') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-6 form-group required'>
                              <label class='control-label'>payable id </label> 
                              <input class='form-control' name='payable_id' size='4' type='text' value=1>
                           </div>
                           <div class='col-xs-12 col-md-6 form-group required'>
                              <label class='control-label'>Payable Type</label> 
                              <input autocomplete='off' class='form-control card-number' size='20' type='text' name='payable_type' value='App\Models\Appointment'>
                           </div>                           
                        </div>                        
                        
                        <div class="form-row row">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      
   </body>   
</html>
