<form action="/admin/setup/product-service/price/update" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="product_service_id" value="{{$productService->id}}">	
    <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group {{{ $errors->has('payment_type') ? 'has-error' : '' }}}">
                            {!! Form::label('payment_type', 'Product Type') !!}

                            <div class="checkbox icheck" >
                                <label>
                                    <input type="radio" name="payment_type" value="free" v-on:click="{ paymentType = 'free' }" :checked="{{ $productService->payment_type == 'free' ? 'true' : 'false'  }}"> Free
                                </label>
                                <label>
                                    <input type="radio" name="payment_type" value="once" v-on:click="{ paymentType = 'once' }" :checked="{{ $productService->payment_type == 'once' ? 'true' : 'false'  }}"> Once
                                </label>
                                <label>
                                    <input type="radio" name="payment_type" value="recurring" v-on:click="{ paymentType = 'recurring' }" :checked="{{ $productService->payment_type == 'recurring' ? 'true' : 'false'  }}"> Recurring
                                </label>
                            </div>
                            {!! $errors->first('payment_type', '<label class="control-label" for="payment_type">:message</label>')!!}
                        </div>
                    </div>
                    <div class="col-sm-12" v-bind:class="{ 'hide': paymentType == 'free' }">
                        <table id="pricingtbl" class="table table-condensed">
                            <tbody>
                                <tr style="text-align:center;font-weight:bold" bgcolor="#efefef">
                                    <td>Currency</td>
                                    <td></td>
                                    <td>One Time/Monthly</td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">Quarterly</td>
                                    <td class="prod-pricing-recurring"  v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">Semi-Annually</td>
                                    <td class="prod-pricing-recurring" style="display: table-cell;" v-bind:class="{ 'hide': paymentType == 'once' }">Annually</td>
                                </tr>
                                @foreach($currencyData as $cid => $priceRecord)
                                <tr style="text-align:center" bgcolor="#ffffff">
                                    <td rowspan="3" bgcolor="#efefef"><b>{{ $priceRecord['currency'] }}</b></td>
                                    <td>Setup Fee</td>
                                    <td>
                                        <input v-if="paymentEnables['{{$cid}}-monthly']" type="text" name="currency[{{$cid}}][monthly_setup_fee]" id="setup_INR_monthly" value="@if($priceRecord['monthly_setup_fee']){{$priceRecord['monthly_setup_fee']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-if="paymentEnables['{{$cid}}-quarterly']" type="text" name="currency[{{$cid}}][quarterly_setup_fee]" id="setup_INR_quarterly" value="@if($priceRecord['quarterly_setup_fee']){{$priceRecord['quarterly_setup_fee']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-if="paymentEnables['{{$cid}}-half_yearly']" type="text" name="currency[{{$cid}}][half_yearly_setup_fee]" id="setup_INR_semiannually" value="@if($priceRecord['half_yearly_setup_fee']){{$priceRecord['half_yearly_setup_fee']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-if="paymentEnables['{{$cid}}-yearly']" type="text" name="currency[{{$cid}}][yearly_setup_fee]" id="setup_INR_annually" value="@if($priceRecord['yearly_setup_fee']){{$priceRecord['yearly_setup_fee']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                    </td>
                                </tr>
                                <tr style="text-align:center" bgcolor="#ffffff">
                                    <td>Price</td>
                                    <td>
                                        <input v-if="paymentEnables['{{$cid}}-monthly']" type="text" name="currency[{{$cid}}][monthly_price]" id="pricing_INR_monthly" size="10" value="@if($priceRecord['monthly_price']){{$priceRecord['monthly_price']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-if="paymentEnables['{{$cid}}-quarterly']" type="text" name="currency[{{$cid}}][quarterly_price]" id="pricing_INR_quarterly" size="10" value="@if($priceRecord['quarterly_price']){{$priceRecord['quarterly_price']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-if="paymentEnables['{{$cid}}-half_yearly']" type="text" name="currency[{{$cid}}][half_yearly_price]" id="pricing_INR_semiannually" size="10" value="@if($priceRecord['half_yearly_price']){{$priceRecord['half_yearly_price']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-if="paymentEnables['{{$cid}}-yearly']" type="text" name="currency[{{$cid}}][yearly_price]" id="pricing_INR_annually" size="10" value="@if($priceRecord['yearly_price']){{$priceRecord['yearly_price']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                    </td>
                                </tr>
                                <tr style="text-align:center" bgcolor="#ffffff">
                                    <td>Enable</td>
                                    <td>
                                        <input value="1" name="currency[{{$cid}}][is_monthly]" type="checkbox" checked>
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-model="paymentEnables['{{$cid}}-quarterly']" name="currency[{{$cid}}][is_quarterly]" type="checkbox" value="1" class="pricingtgl" cycle="quarterly">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-model="paymentEnables['{{$cid}}-half_yearly']" name="currency[{{$cid}}][is_half_yearly]" type="checkbox" value="1" class="pricingtgl" cycle="semiannually">
                                    </td>
                                    <td class="prod-pricing-recurring" v-bind:class="{ 'hide': paymentType == 'once' }" style="display: table-cell;">
                                        <input v-model="paymentEnables['{{$cid}}-yearly']" name="currency[{{$cid}}][is_yearly]" type="checkbox" value="1"  class="pricingtgl" cycle="annually">
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
    
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok-circle"></span>
            Save Changes
        </button>
        <a type="reset" class="btn btn-warning close_popup" href="/admin/setup/product-service/{{$productService->id}}/view">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancel Changes
        </a>
    </div>
</form>