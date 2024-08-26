@extends('admin.app')
<!-- Main Container  -->
@section('content')
@include('admin.partials.header',['title'=>''.$designer->name.'','description'=>'Sales trends'])
<section class="content mb-5">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <!-- <div class="filterarea">
                        <div class="sortlink">
                            <a href="#" class="text-dark"><img src="/assets/designer/img/export.svg" /> Export CSV</a>
                        </div>
                    </div> -->
                    <div>
                        <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Total Sales</strong></h3>
                        {{-- <p class="home-card-small">Jan 2021 - Feb 2021</p> --}}
                        <p class="home-card-small">{{ $start_date_month }}</p>
                        <div class="ordeRow1">
                            <div class="f-60 text-dark">${{ (int)$totalSale }}</div>
                            <div class="mt-3 f-10"><img src="/assets/common/img/arrow-down-circle.svg" class="marroh"> 
                                <span class="f-14 theme-Dtext">
                                @if($totalSalePreviousMonth && $totalSale)
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
                        <h3 class="card-title"><strong>Total Sales via Discounts</strong></h3>
                        <p class="home-card-small">{{ $start_date_month }}</p>
                        <div class="ordeRow1">
                            <div class="f-60 text-dark">$5</div>
                            <div class="mt-3 f-10"><img src="/assets/common/img/arrow-down-circle.svg" class="marroh"> <span class="f-14 theme-Dtext">8.2%</span> since past month</div>
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
                            <div class="f-60 text-dark">{{ $totalAppointments }}</div>
                            <div class="mt-3 f-10">
                                <img src="/assets/common/img/arrow-down-circle.svg" class="marroh"> 
                                <span class="f-14 theme-Dtext">
                                    @if($totalSalePreviousMonth && $totalSale && $totalAppointments)
                                        @php
                                            $appointmentDiff = $totalAppointments - $totalAppointmentsPreviousMonth;
                                            $lastMonthAppointment = $appointmentDiff/$totalAppointments;
                                        @endphp

                                        {{ round($lastMonthAppointment*100, 2) }}%
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
                        <h3 class="card-title"><strong>Sales</strong></h3>
                        <p>By month</p>
                        <table class="table table-sm admintable border-0">
                            <tbody>
                                @foreach($lastFiveMonthSale as $key=>$value)
                                <tr>
                                    <td class="pl-0"><strong>#{{$key+1}}</strong></td>
                                    <td><strong>{{$value['month_year']}}</strong>month</td>
                                    <td><strong>{{$value['total_items']}}</strong>items</td>
                                    <td><strong>$ {{$value['total_amount']}}</strong>Sales</td>
                                </tr>
                                @endforeach
                                <!-- <tr>
                                    <td class="pl-0"><strong>#2</strong></td>
                                    <td><strong>WELCOME20</strong>Code</td>
                                    <td><strong>739</strong>Used</td>
                                    <td><strong>$ 8.33k</strong>Sales</td>
                                </tr>
                                <tr>
                                    <td class="pl-0"><strong>#3</strong></td>
                                    <td><strong>WELCOME20</strong>Code</td>
                                    <td><strong>739</strong>Used</td>
                                    <td><strong>$ 8.33k</strong>Sales</td>
                                </tr>
                                <tr>
                                    <td class="pl-0"><strong>#4</strong></td>
                                    <td><strong>WELCOME20</strong>Code</td>
                                    <td><strong>739</strong>Used</td>
                                    <td><strong>$ 8.33k</strong>Sales</td>
                                </tr>
                                <tr>
                                    <td class="pl-0"><strong>#5</strong></td>
                                    <td><strong>WELCOME20</strong>Code</td>
                                    <td><strong>739</strong>Used</td>
                                    <td><strong>$ 8.33k</strong>Sales</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Top Customers</strong></h3>
                        <p>{{ $start_date_month }}</p>
                        <table class="table table-sm admintable border-0">
                            <tbody>
                                @foreach ($topCustomers as $customer)
                                <tr>
                                    <td class="pl-0"><strong>#{{ $loop->iteration }}</strong></td>
                                    <td><strong>{{ $customer->name }}</strong>Customer</td>
                                    <td><strong>{{ (int)$customer->total_quantity }}</strong>Bought</td>
                                    <td><strong>$ {{ (int)$customer->total_amount }}</strong>Spent</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </section>

            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-body pt-2">
                        <h3 class="card-title"><strong>Top Products</strong></h3>
                        <p>{{ $start_date_month }}</p>
                        <table class="table table-sm admintable border-0">
                            <tbody>
                                @foreach ($topProducts as $products)
                                <tr>
                                    <td class="pl-0"><strong>#{{ $loop->iteration }}</strong></td>
                                    <td><strong>{{ $products->title }}</strong>Collection</td>
                                    <td><strong>{{ (int)$products->total_quantity }}</strong>Bought</td>
                                    <td><strong>$ {{ (int)$products->total_amount }}</strong>Spent</td>
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
@endsection