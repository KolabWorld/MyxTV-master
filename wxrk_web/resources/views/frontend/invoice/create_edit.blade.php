@extends('admin.app')
@section('title') Edit Invoice :: @parent @stop
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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary" style="padding:5%">
                <div class="box-header">
                    <h3 class="box-title"> Create Invoice</h3>
                    <div class="box-tools">
                        <a href="/admin/invoices" class="btn btn-primary btn-sm close_popup">
                            <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </a>
                    </div>
                </div>
                {!! Form::model($invoice, ['method' => isset($invoice) && $invoice->id ? 'put' : 'post','files' => true]) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('user_id') ? 'has-error' : '' }}}">
                                    <label for="user_id">
                                        <strong>Client
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <select class="form-control select2" id="user_id" name="user_id" data-live-search="true" required>
                                        <option value="">-- Select Client --</option>
                                        @foreach($users as $val)
                                            <option value="{{$val->id}}" @if(isset($invoice) && ($invoice->user_id == $val->id) || (old('user_id') == $val->id)) selected @endif>{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('user_id', '<label class="control-label"  for="user_id">:message</label>')!!}
                                </div>
                            </div> 
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('due_date') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong>From Date
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="date" class="form-control" id="input-created_at" name="created_at" required >
                                    {!! $errors->first('created_at', '<label class="control-label"  for="created_at">:message</label>')!!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group required {{{ $errors->has('due_date') ? 'has-error' : '' }}}">
                                    <label for="message">
                                        <strong>Due Date
                                            <span class="mendatory" style="color:red"> *</span>
                                        </strong>
                                    </label>
                                    <input type="date" class="form-control" id="input-due_date" name="due_date" required >
                                    {!! $errors->first('due_date', '<label class="control-label"  for="due_date">:message</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="/admin/invoices" type="reset" class="btn btn-warning close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if ($invoice && $invoice->id)
                                Update
                            @else
                                Submit
                            @endif    
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
		</div>
	</div>
</section>
@endsection
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@stop
@section('scripts')
	@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$('#user_id').select2();
</script>
@stop