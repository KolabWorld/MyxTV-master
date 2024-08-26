@extends('admin.layouts.modal') 

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
                    <h3 class="box-title"> @if(isset($city) && ($city->id)) Edit @else Create @endif City</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->
                 {!! Form::model($city, ['method' => isset($city) && $city->id ? 'put' : 'post']) !!}
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('country', 'Country') !!}
                                <select class="form-control select2" id="country_id" name="country_id" data-live-search="true" onchange="getStates(this,'states')">
                                    <option>
                                        --Select Country--
                                    </option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if(isset($city->state) && (($city->state->country_id == $country->id) || (old('country_id') == $country->id))) selected @endif>
                                            {{$country->name}}
                                        </option>
                                    @endforeach 
                                </select>
                                {!! $errors->first('country_id', '<label class="control-label"  for="country_id">:message</label>')!!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="states" style="display:none;"></div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'City Name') !!}
                                {!! Form::text('name', 
                                    isset($city) && $city->name ? $city->name : old('name'), 
                                    ['class' => 'form-control',
                                    'id' => 'name']) 
                                !!}
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($city) && $city->id)
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
@stop 

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@stop

@section('scripts')
	@parent
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script type="text/javascript">
		var cityId = '';
        var stateId = '';
        $('#country_id').select2();
		function getStates() {
		    var countryId = $('#country_id').val();
		    // console.log(catId);
		    var data = {
		        country_id : countryId,
		        '_token' : '{{{csrf_token()}}}'
		    }
		    $.ajax({
		        url: '/admin/master/location/country/'+countryId+'/states' ,
				type: 'GET',
		        data: data,
		        success:function(data) {
		            var selectbox = '';
		            if(data)
		            {
		                selectbox = '<label class="control-label">State</label>';
		                selectbox += '<select name="state_id" class="form-control select2" data-live-search="true" id="state_id">';
		                selectbox += '<option value="">--Select State--</option>';
		                $.each(data, function (i, item) {
		                	var selected = '';
		                	if(stateId && stateId == i){
		                		selected = 'selected';
		                	}
		                    selectbox += '<option value="'+i+'" '+selected+'>'+item+'</option>';
		                });
		                selectbox += '</select>';
		            }

		            $('#state_id').select2('destroy');
		            $('#states').css('display','block');
		            $('#states').html(selectbox);
		            $('#state_id').select2();
		        }
		    });
		}
		$(document).ready(function(){
			$( ".select2" ).select2();
			@if(isset($city->id)) 
			 	stateId = {!! $city->state_id !!}
			 	getStates();
			@endif
		});
	</script>
@stop
