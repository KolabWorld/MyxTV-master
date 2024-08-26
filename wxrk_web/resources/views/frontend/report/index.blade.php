@extends('admin.app')

{{-- Web site Title --}}
@section('title') Report Dashboard :: @parent @stop


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
        <!-- <h1>Reports</h1> -->
        <ol class="breadcrumb">
            <li>
                <a href="/admin">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
            <li class="active">Reports</li>
        </ol>
        <br>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3>Reports</h3>
                <p>
                    The reports below provide both data analysis and in many cases graphical insights into the data held in the system. You can also create your own reports should you have custom needs. Click the Help icon for more details.
                </p>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <h2>General</h2>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="/admin/report/daily-wise-reports" class="btn btn-info">Daily Performance</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-info">Disk Usage Summary</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-info">Monthly Orders</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-info">Product Suspensions</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-info">Promotions Usage</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;"></div>
                        </div>    
                    </div><!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <h2>Billing</h2>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Aging Invoices</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Credits Reviewer</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Direct Debit Processing</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Sales Tax Liability</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Vat Moss</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;"></div>
                        </div>    
                    </div><!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <h2>Income</h2>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Annual Income Report</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Income Forecast</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Income by Product</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Monthly Transactions</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Server Revenue Forecasts</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;"></div>
                        </div>    
                    </div><!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <h2>Clients</h2>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">New Customers</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Client Sources</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Client Statement</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Clients by Country</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Top 10 Clients by Income</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Affiliates Overview</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Domain Renewal Emails</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Customer Retention Time</a>        
                            </div>
                        </div>    
                    </div><!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <h2>Support</h2>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Support Ticket Replies</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Ticket Feedback Scores</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Ticket Feedback Comments</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Ticket Ratings Reviewer</a>        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-default">Ticket Tags</a>        
                            </div>
                        </div>    
                    </div><!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <h2>Exports</h2>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-primary">Clients</a>        
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-primary">Domains</a>        
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-primary">Invoices</a>        
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-primary">Services</a>        
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-primary">Transactions</a>        
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-bottom:1%;">
                                <a href="#" class="btn btn-primary">Pdf Batch</a>        
                            </div>
                        </div>    
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>         
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

@endsection
