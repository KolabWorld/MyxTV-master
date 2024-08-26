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
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"> @if (isset($configGroupService) && $configGroupService->id) Edit @else Create @endif</h3>
                    <div class="box-tools">
                        <a class="btn btn-primary btn-sm close_popup" href="/admin/master/config-group/{{$configGroupService->config_group_id}}/view">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($configGroupService, ['method' => isset($configGroupService) && $configGroupService->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', 
                                        isset($configGroupService) && $configGroupService->name ? $configGroupService->name : old('name'), 
                                        ['class' => 'form-control',
                                        'id' => 'name']) 
                                    !!}
                                    {!! $errors->first('name', '<label class="control-label"  for="name">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{{ $errors->has('option_type') ? 'has-error' : '' }}}">
                                    {!! Form::label('option_type', 'Option Types') !!}
                                    <select class="form-control select2" data-live-search="true" name="option_type" id="option_type">
                                        <option value="">-- Select Option Type --</option>
                                        @foreach($optionTypes as $val)
                                            <option value="{{$val}}" @if(($configGroupService && ($configGroupService->option_type == $val)) || (old('option_type') == $val)) selected @endif>
                                                {{$val}}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('option_type', '<label class="control-label"  for="option_type">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($configGroupService) && $configGroupService->id)
                                {{ trans("admin/modal.edit") }}
                            @else
                                {{trans("admin/modal.create") }}
                            @endif
                        </button>
                    </div>
                {!! Form::close() !!}
                <br><br>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
<section class="content">
    <div class="row" id="app">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"> Config Service Option</h3>
                </div><!-- /.box-header -->
                <div class="box-body" >
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <add-attribute-panel>
                                        <div class="form-group">
                                            <label class="control-label" style="margin: 5px !important;">
                                                <b>Name</b>
                                            </label> 
                                            <input type="text" name="name" v-model="serviceoption.inputs.name" class="form-control" placeholder="Enter Name !!">   
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" style="margin: 5px !important;">
                                                <b>Indexing</b>
                                            </label> 
                                            <input type="number" name="indexing" v-model="serviceoption.inputs.indexing" class="form-control" placeholder="Enter Indexing !!">   
                                        </div>
                                        <div class="form-group text-right" style="border: none">
                                            <button type="submit" id="submitButton" value="Save" v-on:click="saveServiceOption()" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-ok-circle"></span>
                                                Save
                                            </button>
                                            <a type="reset" class="btn btn-warning close_popup" href="/admin/master/config-group/{{$configGroupService->id}}/view">
                                                <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                                            </a>
                                        </div>
                                    </add-attribute-panel>
                                </div>
                                <div class="col-md-6">
                                    <view-attribute-panel>
                                        <ul class="conversation-list slimscroll " v-for="atr in serviceoption.data">
                                            <li class="clearfix" style="list-style-type:none;box-shadow:0 1px 5px #333;padding:1%;">
                                                <div class="row">
                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <p style="display:flex;clear: both;float: left;padding-right:">
                                                                    <span style="font-size: 16px; line-height: 20px; padding-left: 5px;">
                                                                        Name : @{{atr.name}}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <p style="display:flex;clear: both;float: left;padding-right:">
                                                                    <span style="font-size: 16px; line-height: 20px; padding-left: 5px;">
                                                                       Indexing : @{{atr.indexing}}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                        <a :href="'/admin/master/config-service-option/'+atr.id+'/pricing'" data-toggle="tooltip" title="update" class="btn btn-info btn-xs pull-left"> 
                                                            <i class="fa fa-plus"></i> Add Pricing
                                                        </a>
                                                        <a v-on:click="deleteServiceOption(atr.id)" data-toggle="tooltip" title="delete" class="btn btn-danger btn-xs pull-right"> 
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
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>
@stop 

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
                serviceoption : {
                    inputs : [],
                    data : []
                },
                addPanel: '',
                fileName : '',
                mainView: true,
                eventButton:true,
                configServiceId: '{{ $configGroupService->id }}',
            },
            mounted: function() {
                this.fetchserviceOptions();
            },    
            methods:{
                saveServiceOption() {
                    console.log(this.serviceoption.inputs.name);
                    if(!this.serviceoption.inputs.name || this.serviceoption.inputs.name == ''){
                        swal("", "Name is required","error");
                        return false;
                    }
                    if(!this.serviceoption.inputs.indexing || this.serviceoption.inputs.indexing == ''){
                        swal("", "Indexing is required","error");
                        return false;
                    }
                    var self = this
                    axios.post('/admin/api/config-service/option', {
                        'config_service_id' : self.configServiceId,
                        'name' : self.serviceoption.inputs.name,
                        'indexing' : self.serviceoption.inputs.indexing
                    })
                    .then(function (response) {
                        self.serviceoption.inputs = [];
                        self.fetchserviceOptions();
                    })
                    .catch(function (error) {
                        swal('Something went wrong..', error.response.data.message, 'error')
                    });
                },
                fetchserviceOptions() {
                    var self = this;
                    axios.get('/admin/api/config-service/'+self.configServiceId+'/options'
                    )
                    .then(function (response) {
                        self.serviceoption.data = response.data.data;
                    })
                    .catch(function (error) {
                        swal('Something went wrong..', error.response.data.message, 'error')
                    });
                },
                deleteServiceOption(id) {
                    var self = this
                    axios.get('/admin/api/config-service/'+self.configServiceId+'/option/' + id + '/delete')
                    .then(function(response) {
                        swal('1 Record Deleted !!');
                        self.fetchserviceOptions();
                    })
                    .catch(function(error) {
                        swal('Something went wrong..', error.response.data.message, 'error')
                    });
                },
            }
        });
    </script>    
@endsection