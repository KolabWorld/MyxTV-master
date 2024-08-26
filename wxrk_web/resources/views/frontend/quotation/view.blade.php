@extends('admin.app')

{{-- Web site Title --}}
@section('title') Quotation #{{$quotation->uid}} :: @parent @stop


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

    <section class="content-header">
        <!--<h1>Users <small>Platform Users</small></h1>-->
        <h1>
            Quotation #{{$quotation->uid}} 
            @if($quotation->status == 1)
            <small class="label bg-green">Sent</small>
            @elseif($quotation->status == 2)
            <small class="label bg-red">Cancelled</small>
            @elseif($quotation->status == 3)
            <small class="label bg-red">Rejected</small>
            @elseif($quotation->status == 0)
            <small class="label bg-yellow">Draft</small>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Quotations</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="/quotation/{{$quotation->id}}/pdf" target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Generate PDF</a>

                @if($quotation->status == 0)
                    <a href="/admin/quotation/{{$quotation->id}}/status/sent" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-check"></i> Sent
                    </a>
                    <a href="/admin/quotation/{{$quotation->id}}/status/reject"  class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-times"></i> Reject
                    </a>
                    <a href="/admin/quotation/{{$quotation->id}}/status/cancel"  class="btn btn-primary pull-right" style="margin-right: 5px;">
                        <i class="fa fa-trash"></i> Cancel
                    </a>
                @else 
                    <a href="/admin/quotation/{{$quotation->id}}/status/draft"  class="btn btn-info pull-right" style="margin-right: 5px;">
                        <i class="fa fa-refresh"></i> Reset Status
                    </a>
                @endif
            </div>
        </div>
        <div class="invoice"> 
            @include($partialView, array(
                'quotation' => $quotation,
                'items' => $quotation->items,
                'stamp' => '/assets/img/aims-stamp.png',
                'logo' => '/assets/invoice/img/Logo.png',
                'line' => '/assets/invoice/img/Line.png'
            ))
        </div>
    </section>     
@endsection


@section('styles')
    <style type="text/css">
        .hrline{
            height: 10px;
            width:100%;
        }
        #hrline
        {
            width: 100%;
            color: #ffffff; 
            margin-left: -50px; 
        }

        th { font-size: 11px;
            text-align: center;
        }
        td { font-size: 10px !important; }
        .heading1 {
            font-size: 20px; font-weight: bold;
        }
        .heading2{
            font-size: 15px; 
            font-weight: bold;   
            margin-bottom: 10px;
        }
        .f15 {
            font-size: 15px;
        }
        .f12 {
            font-size: 12px;
        }
        .f10 {
            font-size: 10px;
        }
        .logo {
            height: 70px;
        }

        #addresses
        {
            margin-bottom: 15px;
            margin-top: 5px;
        }

        .address {
            margin-left: 15px;
            float: left;
            line-height: 15px;
            border: 1px solid #000;
            padding: 10px;
            height: 125px;
            width: 45%;
        }

        #table{
            border: 1px solid #000 !important;
        }

        th, td  {
            border-right: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
        }
    </style>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

@endsection
