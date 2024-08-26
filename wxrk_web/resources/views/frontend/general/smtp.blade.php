@extends('admin.app')

{{-- Web site Title --}}
@section('title') Smtp Details :: @parent @stop


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
                    <h3 class="box-title">Edit Smtp Details</h3>

                </div><!-- /.box-header -->
                <!-- form start 
                 {!! Form::model($smtpdetails, ['method' => isset($smtpdetails) && $smtpdetails->id ? 'put' : 'post']) !!}-->
				 <form method="POST" action="{{ route('smtpdetails.edit') }}" accept-charset="UTF-8">
				 <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{{ $errors->has('host') ? 'has-error' : '' }}}">
                                    {!! Form::label('host', 'Host') !!}
                                    {!! Form::text('host', 
                                        isset($smtpdetails) && $smtpdetails->host ? $smtpdetails->host : old('host'), 
                                        ['class' => 'form-control',
                                        'id' => 'host']) 
                                    !!}
                                    {!! $errors->first('host', '<label class="control-label"  for="host">:host</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 nopadding">
                                <div class="form-group {{{ $errors->has('username') ? 'has-error' : '' }}}">
                                    {!! Form::label('username', 'Username') !!}
                                    {!! Form::text('username', 
                                        isset($smtpdetails) && $smtpdetails->username ? $smtpdetails->username : old('username'), 
                                        ['class' => 'form-control',
                                        'id' => 'username']) 
                                    !!}
                                    {!! $errors->first('username', '<label class="control-label"  for="username">:username</label>')!!}
                                </div>
                            </div>
							                            <div class="col-sm-6 nopadding">
                                <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
                                    {!! Form::label('password', 'Password') !!}
                                    {!! Form::text('password', 
                                        isset($smtpdetails) && $smtpdetails->password ? $smtpdetails->password : old('password'), 
                                        ['class' => 'form-control',
                                        'id' => 'password']) 
                                    !!}
                                    {!! $errors->first('password', '<label class="control-label"  for="password">:password</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 nopadding">
                                <div class="form-group {{{ $errors->has('secure') ? 'has-error' : '' }}}">
                                    {!! Form::label('secure', 'Secure') !!}
                                    {!! Form::text('secure', 
                                        isset($smtpdetails) && $smtpdetails->secure ? $smtpdetails->secure : old('secure'), 
                                        ['class' => 'form-control',
                                        'id' => 'secure']) 
                                    !!}
                                    {!! $errors->first('Secure', '<label class="control-label"  for="Secure">:Secure</label>')!!}
                                </div>
                            </div>
							                            <div class="col-sm-6 nopadding">
                                <div class="form-group {{{ $errors->has('port') ? 'has-error' : '' }}}">
                                    {!! Form::label('port', 'port') !!}
                                    {!! Form::text('port', 
                                        isset($smtpdetails) && $smtpdetails->port ? $smtpdetails->port : old('port'), 
                                        ['class' => 'form-control',
                                        'id' => 'port']) 
                                    !!}
                                    {!! $errors->first('port', '<label class="control-label"  for="port">:port</label>')!!}
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="box-footer">

                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            @if (isset($smtpdetails) && $smtpdetails->id)
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

@endsection


