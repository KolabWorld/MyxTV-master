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
                        <strong>Product Service Pricing</strong>
                    </h3>
                    <div class="box-tools">
                        <a class="btn btn-primary btn-sm close_popup" href="/admin/setup/product-services/">
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
                                        <ul class="nav nav-tabs">
                                            <li>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/edit" >
                                                    <b>Details</b>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/pricing">
                                                    <b>Pricing</b>
                                                </a>
                                            </li>
                                            <li class="active">
                                                <a href="#">
                                                    <b>Attributes</b>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/admin/setup/product-service/{{$productService->id}}/config-options" >
                                                    <b>Configurable Options</b>
                                                </a>
                                            </li>
																							 <li class="">
                                                    <a href="/admin/setup/product-service/{{$productService->id}}/seo-details">
                                                        <b>SEO</b>
                                                    </a>
                                                </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active">
                                                <div v-bind:class="{ 'active': activeTab == 'attribute' }" id="attributes" class="tab-pane">
                                                    <div class="box-body" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <add-attribute-panel>
                                                                            <div class="form-group">
                                                                                <label class="control-label" style="margin: 5px !important;">
                                                                                    <b>Attribute</b>
                                                                                </label> 
                                                                                <input type="text" name="name" v-model="attribute.inputs.name" class="form-control" placeholder="Enter Attribute !!">   
                                                                            </div>
                                                                            <div class="form-group text-right" style="border: none">
                                                                                <button type="submit" id="submitButton" value="Save" v-on:click="saveProductServiceAttribute()" class="btn btn-primary">
                                                                                    <span class="glyphicon glyphicon-ok-circle"></span>
                                                                                    Save
                                                                                </button>
                                                                                <a type="reset" class="btn btn-warning close_popup" href="/admin/setup/product-service/{{$productService->id}}/view">
                                                                                    <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                                                                                </a>
                                                                            </div>
                                                                        </add-attribute-panel>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <view-attribute-panel>
                                                                            <ul class="conversation-list slimscroll " v-for="atr in attribute.data">
                                                                                <li class="clearfix" style="list-style-type:none;box-shadow:0 1px 5px #333;padding:1%;">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-10 col-sm-10 col-md-10">
                                                                                            <div class="conversation-text">
                                                                                                <div class="ctext-wrap">
                                                                                                    <p style="display:flex;clear: both;float: left;padding-right:">
                                                                                                        <span style="font-size: 16px; line-height: 20px; padding-left: 5px;">@{{atr.name}}</span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                                                            <a v-on:click="deleteProductServiceAttribute(atr.id)" data-toggle="tooltip" title="delete" class="btn btn-danger btn-xs pull-right"> 
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </view-attribute-panel>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.box-body -->
                                                </div>
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
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="/assets/js/vue.min.js"></script>
    <script src="/assets/js/axios.min.js"></script>
    <script src="https://unpkg.com/vue-scrollto@2.7.9/vue-scrollto.js"></script>
    <script type='text/javascript' src='/assets/plugins/ez-schedule-manager/js/moment.locales.min.js?ver=4.3.5'></script>
    <script type="text/javascript">
        axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
	    var app = new Vue({
            el: '#app',
            data: {
                attribute : {
                    inputs : [],
                    data : []
                },
                activeTab : 'tab_1',
                addPanel: '',
                fileName : '',
                mainView: true,
                eventButton:true,
                productServiceId: '{{ $productService->id }}',
            },
            mounted: function() {
                this.fetchProductServiceAttributes();
            },    
            methods:{
                saveProductServiceAttribute() {
                    console.log(this.attribute.inputs.name);
                    if(!this.attribute.inputs.name || this.attribute.inputs.name == ''){
                            swal("", "Name is required","error");
                            return false;
                    }
                    var self = this
                    axios.post('/admin/api/product-service/attribute', {
                            'product_service_id' : self.productServiceId,
                            'name' : self.attribute.inputs.name
                    })
                    .then(function (response) {
                        self.attribute.inputs = [];
                        self.fetchProductServiceAttributes();
                    })
                    .catch(function (error) {
                        swal('Something went wrong..', error.response.data.message, 'error')
                    });
                },
                fetchProductServiceAttributes() {
                    var self = this;
                    axios.get('/admin/api/product-service/'+this.productServiceId+'/attributes'
                    )
                    .then(function (response) {
                        self.attribute.data = response.data.data;
                    })
                    .catch(function (error) {
                        swal('Something went wrong..', error.response.data.message, 'error')
                    });
                },
                deleteProductServiceAttribute(id) {
                    var self = this
                    axios.get('/admin/api/product-service/attribute/' + id + '/delete')
                    .then(function(response) {
                        swal('1 Record Deleted !!');
                        self.fetchProductServiceAttributes();
                    })
                    .catch(function(error) {
                        swal('Something went wrong..', error.response.data.message, 'error')
                    });
                },
            }
        });
    </script>    
@endsection

