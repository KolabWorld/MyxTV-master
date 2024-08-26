@extends('admin.app')

{{-- Web site Title --}}
@section('title') My Workspace | Salon agreements :: @parent @stop

@section('content')
    <section class="content-header">
        <h1>Salon Agreements</h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Salon Agreements</li>
        </ol>
        <br>
    </section>
    <!-- Main content -->
    <section class="content" ng-app="salonAgreements" ng-controller="salonAgreementsController">
        <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-2">
                            
                            <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-search"></i></div>

                                    <input type="text" class="form-control" placeholder="Salon Name" ng-model="agreementSearchSalonName">

                                  </div>      
                                </div>
                                <div class="form-group">
                                <label>Agreement Status</label><br/>
                                <span style="display:block;" ng-repeat="option in allStatus">
                                  <input type="checkbox" value="@{{option}}" ng-checked="filterStatus.indexOf(option) > -1" ng-click="toggle('filterStatus',option)"> @{{option | camelCase}}
                                </span>
                            </div>

                        </div>
                        <div class="col-xs-12 col-md-10">
                            <div class="row">
                                <div id="fpdiv" ng-init="expanded=false" class="col-md-12 expandableTable" style="position: @{{expanded?'fixed':'relative'}};z-index: @{{expanded?'100000':'1'}}">
                                    <table id="fp" class="table table-bordered table-bordered-ddd table-striped table-responsive table-condensed">
                                        <thead>
                                            <tr class="info">
                                                <th style="width: 200px" rowspan="2"><button class="" style="position:absolute;left:0;top:0;" ng-click="expanded=!expanded"><span class="fa fa-@{{expanded?'compress':'arrows-alt'}}"></span></button><br/>Salon Name</th>
                                                <th>Commission<br/> Model</th>
                                                <th>%age</th>
                                                <th>Frenchise<br/>Fee</th>
                                                <th>Monthly<br/>Fee</th>
                                                <th>Effective<br/>Period</th>
                                                <th style="width: 100px">Status</th>
                                                <th style="width: 100px">Action</th>
                                            </tr>
                                               
                                        </thead>
                                      
                                        <tbody>
                                            
                                            <tr ng-repeat="agreement in agreements |filter:{'salon_name':agreementSearchSalonName}">
                                              <td>@{{agreement.salon_name}}</td>
                                              <td >@{{agreement.commission_model | camelCase}}</td>
                                              <td class="text-right">@{{agreement.commission_perc}}</td>
                                              <td class="text-right" >@{{agreement.frenchise_fee}}</td>
                                              <td class="text-right" >@{{agreement.monthly_fee}}</td>
                                               <td>@{{agreement.effective_from}}
                                               @{{agreement.effective_to ? ' To '+agreement.effective_to : ''}}
                                               </td>

                                               <td>
                                        <small ng-if="agreement.status=='CREATED'" class="label bg-teal pull-left" style="width: 98%;margin:2px">Created</small>
                                        <small style="width: 98%;margin:2px" ng-if="agreement.status=='APPROVED'" class="label bg-green-active pull-left">Approved</small>
                                            <small style="width: 98%;margin:2px" ng-if="agreement.status=='SENT_FOR_REVIEW'" class="label bg-orange pull-left">Sent for review</small>
                                            <small style="width: 98%;margin:2px" ng-if="agreement.status=='REJECTED'" class="label bg-red pull-left">Rejected</small>
                                        
                                            <small style="width: 98%;margin:2px" ng-if="agreement.status=='REOPENED'" class="label bg-lime-active pull-left">Reopened</small></td>
                                               
                                                <td>
                                                 <small ng-show="agreement.status == 'SENT_FOR_REVIEW'" class="label bg-green-active pull-left" style="margin: 2px;width: 98%">
                                                 <a ng-click="changeStatus(agreement.id,'APPROVED')" style="cursor: pointer;color: inherit;"><i class="fa fa-check"></i>Approve </a></small>

                                                  <small ng-show="agreement.status == 'SENT_FOR_REVIEW'" class="label bg-red-active pull-left" style="margin: 2px;width: 98%">
                                                 <a ng-click="changeStatus(agreement.id,'REJECTED')" href="#" style="cursor: pointer;color: inherit;"><i class="fa fa-times"></i>Reject </a></small>   

                                                <small class="label bg-orange-active pull-left" style="margin: 2px;width: 98%">
                                                <a target="_blank" href="/admin/salons/@{{agreement.salon_id}}/agreements" style="cursor: pointer;color: inherit;"><i class="fa fa-eye"></i>View </a></small>  
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

{{-- Scripts --}}
@section('scripts')
    @parent
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
<script>

var salonAgreements = angular.module("salonAgreements",[]).filter( 'camelCase', function() {
        return function(input){
            input = input.toLowerCase();
            var words = input.split( '_' );
            for ( var i = 0, len = words.length; i < len; i++ )
                words[i] = words[i].charAt( 0 ).toUpperCase() + words[i].slice( 1 );
            return words.join( ' ' );
        }
     }).controller('salonAgreementsController',function($scope,$http,$q,filterFilter){
    $scope.agreementSortType     = 'id';
    $scope.agreementSortReverse  = false;
    $scope.agreementSearchName   = '';

    var agreementUrl = "/admin/workspace/data_salon_agreements";
    
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

    $scope.reloadData = function(){
        var filters = ""
        if($scope.filterStatus){
            angular.forEach($scope.filterStatus,function(value){
                filters+="filter_status[]="+value+"&"
            });
        }

        $http.get(agreementUrl+"?"+filters).then(function(response){
            $scope.agreements = response.data.agreements;
            $scope.allStatus = response.data.all_status;
            $scope.filterStatus = response.data.filter_status;
            $scope.initFreeze();
            /*setTimeout(function() {$("#filterStatus").trigger("chosen:updated");$("#filterChannel").trigger("chosen:updated");}, 500);*/
        });
    }


    $scope.changeStatus= function changeStatus(agreement_id,status) {
       
        $http.get('/admin/workspace/salon_agreements/'+agreement_id+'/'+status).then(function(response){
            $scope.reloadData();
        });
        
    };

    $scope.reloadData();

});
$(document).ready(function(){


});
</script>
@endsection