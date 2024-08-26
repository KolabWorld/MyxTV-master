@extends('admin/app')

{{-- Web site Title --}}
@section('title') Appointment Edit Permissions :: @parent @stop

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
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Enable Salon Business</h3>
                </div>
                <div class="box-body form-group voucher_code">
                    <form role="form" method="post" id="form_appointment" action="{{ URL::to('/admin/workspace/enable_business_updates') }}" onsubmit ="return validateValue()">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    

                    <div class="row">

                    <div class="col-md-6">

                      <div class="form-group">
                        <label>Start date</label>
                        <input type="text" class="form-control" tabindex="1" placeholder="Start date" name="start_date" id="start_date" onkeydown='return false' >
                       <label class="error-label"  for="start_date" style="display: none"></label>
                       </div>

                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                        <label>End date</label>
                        <input type="text" class="form-control" tabindex="1" placeholder="End date" name="end_date" id="end_date" onkeydown='return false' >
                       <label class="error-label"  for="end_date" style="display: none"></label>
                       </div>

                     </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12 checkbox">
                             <label>
                                 <input type="checkbox" id="select_salon">
                                 Apply to All Salons
                             </label>
                         </div>
                     </div>
                    <div class="row salon_div" style="margin-top:10px;">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>City</label>
                            {!! Form::select('city_id', $city_array, Input::old('city_id', isset($salon) ? $salon->city_id : 0) , ['class' => 'form-control', 'id'=>'city_id' ,'tabindex' => '3' ]) !!}
                            <label class="error-label"  for="city_id" style="display: none"></label>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Select salon</label>
                             {!! Form::select('salon_id', $salon_array, Input::old('salon_id', isset($salon) ? $salon->id : 0) , ['class' => 'form-control', 'id'=>'salon_id', 'tabindex' => '4' ]) !!}
                            <label class="error-label"  for="salon_id" style="display: none"></label>
                        </div>
                    </div>
                   </div>
                 
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                        <label>Reason</label>
                        <textarea class="form-control" id="reason" placeholder="Reason" name="reason"></textarea>

                         <label class="error-label"  for="reason" style="display: none"></label>
                        </div>
                        </div>

                    <div class="col-xs-12"> 
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit_form" value="Submit" class="form-control btn btn-primary" tabindex="9">
                        </div>
                    </div>
                    </div>

                    </form>
                </div>
            </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
@stop 

@section('styles')
    <link rel="stylesheet" href="/assets/site/css/plugins.css">

    <link href="/assets/plugins/select2/select2.min.css" type="text/css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <style type="text/css">
        .checkbox{
        margin-top: 1px !important;
        margin-bottom: 1px !important;
    </style>

@endsection

@section('scripts')

<script type='text/javascript' src='/assets/plugins/ez-schedule-manager/js/moment.locales.min.js?ver=4.3.5'></script>
<script src="/assets/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>

 <!-- <script src="/assets/site/js/jquery.datetimepicker.full.min.js"></script> -->
<script type="text/javascript" src="/assets/plugins/select2/select2.full.js"></script>


<script type="text/javascript">

 function validateValue(){

    $('.error-label').css('display','none');
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-success');

    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var reason = $.trim($('#reason').val());
    var salon_id = $('#salon_id').val();

    if(start_date == '') {
        $('#start_date').closest('.form-group').addClass('has-error');
        $('label[for="start_date"]').html('Date field is required');
        $('label[for="start_date"]').css('display','block');
        return false;
    }

    if(!$('#select_salon').is(':checked') && salon_id == '') {
        $('#salon_id').closest('.form-group').addClass('has-error');
        $('label[for="salon_id"]').html('salon_id field is required');
        $('label[for="salon_id"]').css('display','block');
        return false;
    }
    if(reason == '') {
        $('#reason').closest('.form-group').addClass('has-error');
        $('label[for="reason"]').html('Reason field is required');
        $('label[for="reason"]').css('display','block');
        return false;
    }

}

$(document).ready(function() {

     $('#select_salon').change(function() {
        if (!$(this).is(':checked')) {
            $('.salon_div').css('display','block');

        } else {
            $('.salon_div').css('display','none');
       }
    });

    $('#end_date').datepicker({
        format: 'yyyy-mm-dd',
        endDate: 'now',
        autoclose: true,
    });
    $('#start_date').datepicker({
        format: 'yyyy-mm-dd',
        endDate: 'now',
        autoclose: true,
    }).on('changeDate', function(){
        $('#end_date').datepicker('setStartDate', new Date($(this).val()));
    });

   $("#city_id").change(function () {
        $.getJSON("/salons/"+$('#city_id').val(), {
            city_id: $(this).val()
        }, function (json) {

            if($('#salon_id').val()) 
                $("#salon_id").select2('destroy'); 

            $('#salon_id').text('');

            for (var i = 0; i < json.length; i++) {
                $('#salon_id').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
            }

            $('#salon_id').select2();
        });
    });

});

		
</script>
@stop
