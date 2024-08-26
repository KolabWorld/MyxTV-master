@extends('admin/app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')
<div class="content-header">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="tophead">
                    <div class="allTitle">
                        <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                        <h2>{{ $customer->name }}</h2>
                        <div class="subTitle">Sales trends</div>
                    </div>
                    <div class="headpanel">
                        <div class="setting">
                            <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                        </div>									
                        <div class="notify">
                            <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                        </div>
                        <div class="setting">
                            <a href="login.html"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8" /></a>
                        </div>
                        <div class="adlogo d-inline-block"><img src="/assets/admin/img/logo.svg" /></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div class="filterarea">
                        <div class="sortlink">
                            <a href="#" class="text-dark"><img src="/assets/admin/img/filter.svg" /> Sort & Filter</a>
                        </div>
                    </div>
                    <div>
                        <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content mb-5">
    <div class="container-fluid">
        <div class="row"> 
            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Total Sales</strong></h3>
                        <p class="home-card-small">{{ $start_date_month }}</p>
                        <div class="ordeRow1">
                            <div class="f-60 text-dark">${{ (int)$totalSale }}</div>
                            <div class="mt-3 f-10">
                                <img src="/assets/admin/img/arrow-down-circle.svg" class="marroh"> 
                                <span class="f-14 theme-Dtext">
                                @if($totalSalePreviousMonth>0 && $totalSale>0)
                                    @php
                                        $saleDiff = $totalSale - $totalSalePreviousMonth;
                                        $lastMonthDividing = $saleDiff/$totalSale;
                                    @endphp

                                    {{ round($lastMonthDividing*100, 2) }}%
                                    @else
                                    0%
                                @endif
                                </span> since past month
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Total Saved on discounts</strong></h3>
                        <p class="home-card-small">{{ $start_date_month }}</p>
                        <div class="ordeRow1">
                            <div class="f-60 text-dark">${{ (int)$totalDiscount }}</div>
                            <div class="mt-3 f-10">
                                <img src="/assets/admin/img/arrow-down-circle.svg" class="marroh"> 
                                <span class="f-14 theme-Dtext">
                                    @if($totalDiscountPreviousMonth>0 && $totalDiscount>0)
                                    @php
                                        $discountDiff = $totalDiscount - $totalDiscountPreviousMonth;
                                        $lastMonthDividingDiscount = $discountDiff/$totalDiscount;
                                    @endphp

                                    {{ round($lastMonthDividingDiscount*100, 2) }}%
                                    @else
                                    0%
                                @endif
                                </span> 
                                since past month
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            
            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Total Appointments</strong></h3>
                        <p class="home-card-small">{{ $start_date_month }}</p>
                        <div class="ordeRow1">
                            <div class="f-60 text-dark">{{ $totalAppointmet }}</div>
                            <div class="mt-3 f-10">
                                <img src="/assets/admin/img/arrow-down-circle.svg" class="marroh"> 
                                <span class="f-14 theme-Dtext">
                                @if($totalAppointmetPreviousMonth>0 && $totalAppointmet>0)
                                    @php
                                        $appDiff = $totalAppointmet - $totalAppointmetPreviousMonth;
                                        $lastMonthDividingApp = $appDiff/$totalAppointmet;
                                    @endphp

                                    {{ round($lastMonthDividingApp*100, 2) }}%
                                    @else
                                    0%
                                @endif
                                </span> 
                                since past month
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="col-lg-8 connectedSortable">
                <div class="card h-100">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Sales graph</strong></h3>
                        <!-- <p>Jan 2020 - Feb 2021</p> -->
                        <p>{{$graphData['date']}}</p>
                        <div id="container" style="height:300px"></div>
                         <!-- <img src="/assets/admin/img/bar-graph.jpg" /> -->
                    </div>
                </div>
            </section>

            <section class="col-lg-4 connectedSortable">
                <div class="card h-100">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Favourite Designers</strong></h3>
                        <p>{{ $start_date_month }}</p>
                        <table class="table table-sm admintable border-0">
                            <tbody>
                              @foreach ($favouriteDesigners as $designers)
                                <tr>
                                    <td class="pl-0"><strong>#{{ $loop->iteration }}</strong></td>
                                    <td><strong>{{ $designers->name }}</strong>Designer</td>
                                    <td><strong>{{ (int)$designers->total_quantity }}</strong>Bought</td>
                                    <td><strong>$ {{ (int)$designers->total_amount }}</strong>Spent</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
    Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    credits: {
        enabled: false
    },
	 exporting: {
		enabled: false
	  },
    xAxis: {
        categories: {!! json_encode($graphData['month_year'])!!},
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        },
        gridLineColor: '#ffffff',
        lineColor: '#ffffff',
    },
    yAxis: {
        title: {
            text: 'Dollars'
        },
        labels: {
             
        },
        gridLineColor: '#ffffff',
        lineColor: '#ffffff',
    },
    tooltip: {
        split: true,
        valueSuffix: ' Dollars'
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#333333',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#333333'
            }
        }
    },
    legend: {
        enabled: false 

    },
    series: [{
        name: '',
        data: {{json_encode($graphData['total_amount'])}},
        color: "#e7e7e75a"
    }]
});
</script>
@stop

@section('styles')
<style type="text/css">
 .highcharts-point { fill: #333333 !important}
 
</style>
@endsection