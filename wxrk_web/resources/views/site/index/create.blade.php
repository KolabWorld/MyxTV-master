@extends('invoice/app')

{{-- Web site Title --}}
@section('title') Create Invoice :: @parent @stop

@section('content')
<div id="create-invoice" class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
    <form class="modal-content" method="post" action="">
        {!! Form::token() !!}
        <div class="modal-header">
            @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade in">
                There were some problems adding client.<br />
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (isset($status))
            <div class="alert alert-{{$status['code']}} alert-dismissible fade in">
                <!-- <h3>{{$status['header']}}</h3><br /> -->
                <ul>
                    @foreach ($status['messages'] as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

            <h3>Create Invoice</h3>
        </div>
        <div class="modal-body">

             <div class="form-group">
                <label for="type">Invoice Type</label>
                <select name="type" id="type" class="form-control select2" >
                    @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Invoice State</label>
                <select name="state_id" id="state_id" class="form-control select2">
                    <option>--select state--</option>
                    @foreach($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                   
                </select>
            </div>

            <div class="form-group">
                <label>Select Client</label>
                <select name="client_id" id="client_id" class="form-control select2">
                    <option>--select client--</option>
                    @foreach($clients as $client)
                        <option value="{{$client->id}}">{{$client->name}} ({{$client->alias}})</option>
                    @endforeach
                   
                </select>
            </div>

        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button class="btn btn-success ajax-loader" id="invoice_create_confirm" type="submit">
                    <i class="fa fa-check"></i> Submit
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        

    </script>
@endsection