@extends('admin.app') 

@section('content')

@if (isset($status))
<div class="pad margin no-print">
    <div class="alert alert-{{$status['code']}} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4><i class="icon fa fa-ban"></i> {{ $status['header'] }}</h4>
        <ul>
            @foreach ($status['messages'] as $m)
                <li>{{$m}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<section class="content">
    <div class="row" id="app">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        <strong>Config service option pricing</strong>
                    </h3>
                    <div class="box-tools">
                        <a class="btn btn-primary btn-sm close_popup" href="/admin/master/config-group/service/{{$serviceOption->config_service_id}}/edit">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="nav-tabs-custom">
                                        <div class="tab-content">
                                            <div class="tab-pane active">
                                                <form method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="config_service_option_id" value="{{$serviceOption->id}}">	
                                                    <div class="box-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    {{--  <div class="col-sm-6">
                                                                        <div class="form-group {{{ $errors->has('payment_type') ? 'has-error' : '' }}}">
                                                                            {!! Form::label('payment_type', 'Product Type') !!}

                                                                            <div class="checkbox icheck" >
                                                                                <label>
                                                                                    <input type="radio" name="payment_type" value="free" v-model="paymentType"> Free
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="payment_type" value="once" v-model="paymentType" > Once
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="payment_type" value="recurring" v-model="paymentType"> Recurring
                                                                                </label>
                                                                            </div>
                                                                            {!! $errors->first('payment_type', '<label class="control-label" for="payment_type">:message</label>')!!}
                                                                        </div>
                                                                    </div>  --}}
                                                                    <div class="col-sm-12">
                                                                        <table id="pricingtbl" class="table table-condensed">
                                                                            <tbody>
                                                                                <tr style="text-align:center;font-weight:bold" bgcolor="#efefef">
                                                                                    <td>Currency</td>
                                                                                    <td></td>
                                                                                    <td>One Time/Monthly</td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">Quarterly</td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">Semi-Annually</td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">Annually</td>
                                                                                </tr>
                                                                                @foreach($currencyData as $cid => $priceRecord)
                                                                                <tr style="text-align:center" bgcolor="#ffffff">
                                                                                    <td rowspan="3" bgcolor="#efefef"><b>{{ $priceRecord['currency'] }}</b></td>
                                                                                    <td>Setup Fee</td>
                                                                                    <td>
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-monthly') !== -1" type="text" name="currency[{{$cid}}][monthly_setup_fee]"  value="@if($priceRecord['monthly_setup_fee']){{$priceRecord['monthly_setup_fee']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input  v-if="paymentEnables.indexOf('{{$cid}}-quarterly') !== -1" type="text" name="currency[{{$cid}}][quarterly_setup_fee]" value="@if($priceRecord['quarterly_setup_fee']){{$priceRecord['quarterly_setup_fee']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-half_yearly') !== -1" type="text" name="currency[{{$cid}}][half_yearly_setup_fee]"  value="@if($priceRecord['half_yearly_setup_fee']){{$priceRecord['half_yearly_setup_fee']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-yearly') !== -1" type="text" name="currency[{{$cid}}][yearly_setup_fee]"  value="@if($priceRecord['yearly_setup_fee']){{$priceRecord['yearly_setup_fee']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="text-align:center" bgcolor="#ffffff">
                                                                                    <td>Price</td>
                                                                                    <td>
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-monthly') !== -1" type="text" name="currency[{{$cid}}][monthly_price]"  size="10" value="@if($priceRecord['monthly_price']){{$priceRecord['monthly_price']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-quarterly') !== -1" type="text" name="currency[{{$cid}}][quarterly_price]" size="10" value="@if($priceRecord['quarterly_price']){{$priceRecord['quarterly_price']}}@else 0.00 @endif" style="display: inline-block;" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-half_yearly') !== -1" type="text" name="currency[{{$cid}}][half_yearly_price]"  size="10" value="@if($priceRecord['half_yearly_price']){{$priceRecord['half_yearly_price']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-if="paymentEnables.indexOf('{{$cid}}-yearly') !== -1"  type="text" name="currency[{{$cid}}][yearly_price]"  size="10" value="@if($priceRecord['yearly_price']){{$priceRecord['yearly_price']}}@else 0.00 @endif" class="form-control input-inline input-100 text-center">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="text-align:center" bgcolor="#ffffff">
                                                                                    <td>Enable</td>
                                                                                    <td>
                                                                                        <input v-model="paymentEnables" value="{{$cid}}-monthly" name="currency[{{$cid}}][is_monthly]" type="checkbox" @if($priceRecord["is_monthly"]) class="precheck" @endif>
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-model="paymentEnables" value="{{$cid}}-quarterly" name="currency[{{$cid}}][is_quarterly]" type="checkbox" @if($priceRecord["is_quarterly"]) class="precheck" @endif>
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-model="paymentEnables" value="{{$cid}}-half_yearly" name="currency[{{$cid}}][is_half_yearly]" type="checkbox" @if($priceRecord["is_half_yearly"]) class="precheck" @endif>
                                                                                    </td>
                                                                                    <td class="prod-pricing-recurring" style="display: table-cell;">
                                                                                        <input v-model="paymentEnables" value="{{$cid}}-yearly" name="currency[{{$cid}}][is_yearly]" type="checkbox" @if($priceRecord["is_yearly"]) class="precheck" @endif>
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
                                                    </div>
                                                </form>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@endsection 

@section('scripts')
    @parent
    <script src="/assets/js/vue.min.js"></script>
    <script src="/assets/js/axios.min.js"></script>
    <script src="https://unpkg.com/vue-scrollto@2.7.9/vue-scrollto.js"></script>

    <script type="text/javascript">
     
        axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
	    var app = new Vue({
            el: '#app',
            data: {
                paymentEnables : [],
                productServiceId: '{{ $serviceOption->id }}',
            },
            mounted: function() {
                // this.fetchProductServiceAttributes();
                // this.paymentEnables.push(this.$refs.precheck.value)
                var self = this;
                $(".precheck").each(function(e, th) {
                    self.paymentEnables.push($(th).val());
                });
            },    
            methods:{
                paymentEnableEvent(cid, value, $event){
                    const checked = $event.target.checked;
                    if (checked)
                        this.paymentEnables[cid + '-' + value] = 1;
                    else
                        this.paymentEnables[cid + '-' + value] = 0;

                    console.log(this.paymentEnables);
                }
            }
        });
    </script>    
@endsection

