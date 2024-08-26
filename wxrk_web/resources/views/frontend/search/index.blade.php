@extends('admin.app')

{{-- Web site Title --}}
@section('title') Invoices :: @parent @stop

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
    <h1>Data Retrieval</h1>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search
        </li>
    </ol>
    <br>
</section>
<!-- Main content -->
<section class="content" ng-app="salonInvoices" ng-controller="salonInvoicesController">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

              <div class="overlay" ng-show="loader">
                <i class="fa fa-refresh fa-spin"></i>
              </div>

                <div class="box-header">
                    <ul class="nav nav-tabs" style="clear:both;">
                        <li class="active" ><a href="">Search Main Data</a></li>
                        <li><a href="">Search SEIAA Data</a></li>
                         <li><a href="">Search Show Cause Data</a></li>
                         <li><a href="">VIP Search</a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-3">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-search"></i></div>

                                    <input type="text" class="form-control" placeholder="Salon Name" ng-model="invoiceSearchSalonName">

                                  </div>
                            </div>
                            <div class="form-group">
                                <select  class="form-control" ng-change="reloadData()" >
                                    <option>Select Filter</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <select  class="form-control" ng-change="reloadData()" >
                                    <option>Select Filter</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <select  class="form-control" ng-change="reloadData()" >
                                    <option>Select Filter</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <select  class="form-control" ng-change="reloadData()" >
                                    <option>Select Filter</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <select  class="form-control" ng-change="reloadData()" >
                                    <option>Select Filter</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <div class="row">
                                <div id="fpdiv" ng-init="expanded=false" class="col-md-12 expandableTable @{{expanded?'expanded':''}}">
                                    <table id="fp" class="table table-bordered table-bordered-ddd table-striped table-responsive table-condensed">
                                        <thead>
                                            <tr class="info">
                                                <th style="width: 200px" rowspan="2"><button class="" style="position:absolute;left:0;top:0;" ng-click="expanded=!expanded"><span class="fa fa-@{{expanded?'compress':'arrows-alt'}}"></span></button><br/>Salon Name</th>
                                                <th>Invoice<br/>No</th>
                                                <th>Recorded<br/>Business</th>
                                                <th>Reported<br/>Business</th>
                                                <th>Glam<br/>Genrated</th>
                                                <th>Commission<br/>Model</th>
                                                <th>Subtotal</th>
                                                <th>TAX<br/>Amount</th>
                                                <th>Voucher<br/>Amount</th>
                                                <th>Prepaid<br/>Amount</th>
                                                <th>Invoice<br/>Amount</th>
                                                <th>Previous<br/>Amount</th>
                                                <th>Previous<br/>Discount</th>
                                                <th>Previous<br/>Paid</th>
                                                <th>Grand<br/>Total</th>

                                                <th style="width: 100px">Action</th>
                                            </tr>

                                        </thead>

                                        <tfoot class="">
                                          <tr class="info">
                                          <th>Total</th>
                                          <th>---</th>
                                          <th class="text-right">@{{total.recorded_revenue}}</th>
                                          <th class="text-right">@{{total.reported_revenue}}</th>
                                         <th class="text-right">@{{total.glam_generated_revenue}}</th>
                                         <th class="text-right">--</th>
                                         <th class="text-right">@{{total.total_amount | intVal}}</th>
                                         <th class="text-right">@{{total.total_tax | intVal}}</th>
                                          <th class="text-right">@{{total.voucher_amount | intVal}}</th>
                                          <th class="text-right">@{{total.prepaid_amount | intVal}}</th>
                                          <th class="text-right">@{{total.invoice_total | intVal}}</th>
                                          <th class="text-right">@{{total.prev_amount | intVal}}</th>
                                          <th class="text-right">@{{total.prev_discount | intVal}}</th>
                                          <th class="text-right">@{{total.prev_paid | intVal}}</th>
                                          <th class="text-right">@{{(total.grand_total? total.grand_total :  total.invoice_total) | intVal}}</th>
                                          <th class="text-right"></th>

                                          </tr>
                                      </tfoot>

                                        <tbody>

                                            <!-- <tr ng-hide="salonInvoices.length"> -->
                                            <tr >
                                              <td colspan="15" style="text-align: center;">
                                                No record found..
                                              </td>
                                            </tr>

                                            
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('styles')
    <link href="/assets/admin/css/angular-confirm.css" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts --}}
@section('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>

<script type="text/javascript" src="/assets/admin/js/angular-confirm.js"></script>
<script>

var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var today = new Date();
var d;
var month;

var salonInvoices = angular.module("salonInvoices",['cp.ngConfirm']).filter( 'camelCase', function() {
        return function(input){
            input = input.toLowerCase();
            var words = input.split( '_' );
            for ( var i = 0, len = words.length; i < len; i++ )
                words[i] = words[i].charAt( 0 ).toUpperCase() + words[i].slice( 1 );
            return words.join( ' ' );
        }
   }).filter( 'intVal', function() {
      return function(input){
          return Math.round(input);
      }
   }).controller('salonInvoicesController',function($scope,$http,$q,filterFilter,$ngConfirm){

       $(".iframe").colorbox({
        iframe:true, width:"80%", height:"80%"
        });

    $scope.toggle= function toggle(filter,option) {
        var idx = $scope[filter].indexOf(option);
        if (idx > -1) {
          $scope[filter].splice(idx, 1);
        }else {
          $scope[filter].push(option);
        }
        $scope.reloadData();
    };

    $scope.initFreeze = function(){
        setTimeout(function(){$("#fp").tableHeadFixer({'left':1});},500);
    }

    $scope.reloadDataByMonth = function(){
        $scope.reloadData();
    }

    $scope.reloadData = function(){

        $scope.loader = false;

        // var month = $scope.selectedMonth;
        // var invoiceUrl = "/admin/invoice/"+month+"/data";

        // var filters = ""
        // if($scope.filterStatus){
        //     angular.forEach($scope.filterStatus,function(value){
        //         filters+="filter_status[]="+value+"&";
        //     });
        // }

        // $http.get(invoiceUrl+"?"+filters).then(function(response){
        //     $scope.salonInvoices = response.data.salon_invoices;
        //     $scope.total = response.data.total;
        //     $scope.allStatus = response.data.all_status;
        //     $scope.filterStatus = response.data.filter_status;
        //     $scope.loader = false;
        //     $scope.initFreeze();
        // });
    }
    $scope.reloadData();

    $scope.reset = function(id) {
        $scope.loader = true;
        var month = $('#month').val()

        $http.get('/admin/invoice/create/'+month+'/'+id).then(function(response){

            $scope.reloadData();
            $('.notify > .alert-success > .alert-msg').html(response.data.messages);
            $('.notify > .alert-success').show();
            setTimeout(function(d){
             $('.notify > .alert-success').hide();
            }, 10000);
        });
    }

});

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle=confirmation]').confirmation({
      rootSelector: '[data-toggle=confirmation]',
      // other options
    });

  })
</script>
@endsection
