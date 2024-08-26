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
                    <h3 class="box-title"> Repay Invoice {{$invoice->invoice_number}}</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                @if($wallet && $wallet->amount)
                <form method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" class="form-control" name="invoice_id" placeholder="Amount" value="{{ $invoice->id }}">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                               <label>Payable Total: {{$invoice->currency}} {{$invoice->amount_pending}}</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                               <label> Available Amount in wallet: {{$wallet ? $wallet->amount : 0}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning close_popup">
                        <span class="glyphicon glyphicon-ban-circle"></span> {{trans("admin/modal.cancel") }}
                        </button>
                        @if ($wallet && $wallet->amount > 0)
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok-circle"></span>
                                Submit
                            </button>
                        @endif
                    </div>
                </form>
                @else 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> User Don't have enough {{$invoice->currency}} Balance in his wallet</label>
                        </div>
                    </div>
                @endif
            </div>
		</div>
	</div>
</section>
@endsection