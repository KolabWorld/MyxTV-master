@extends('frontend.app')
{{-- Web site Title --}}
@section('title') Dashboard :: @parent @stop
@section('content')
    @include('frontend.partials.nav', [
        'title' => 'Dashboard',
        'description' =>
            'Welcome back, 
            <span class="theme-Dtext">' .
            $auth->contact_person_name .
            '</span>',
    ])

    <section class="content">
        <div class="container-fluid">
            <form action="" method="get">
                <div class="row mb-2">
                    <div class="col-md-3 col-6 d-none d-sm-block">
                        <div class="form-group innerappform top-dateformat">
                            <label>From</label>
                            <input type="date" name="from_date" class="form-control bg-white" value="{{ $fromDate }}"
                                placeholder="Enter Capacity (in TON)">
                        </div>
                        @error('from_date')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-3 col-6 d-none d-sm-block">
                        <div class="form-group innerappform top-dateformat">
                            <label>To</label>
                            <input type="date" name="to_date" class="form-control bg-white" value="{{ $toDate }}"
                                placeholder="Enter Capacity (in TON)">
                        </div>
                        @error('to_date')
                        <strong class="text-danger">{{ $message }}</strong> 
                        @enderror
                    </div>
                    <div class="col-md-2  mt-2 mt-sm-2 mb-2 mb-sm-0 justify-content-mobbetween">
                        <button type="submit" class="btn btn-primary btn-filter mr-2"><i class="fas fa-search mr-1"></i>
                            Search</button>
                        <!--<a href="#" class="btn btn-outline-secondary"><i class="far fa-times-circle mr-1"></i> Clear</a>
                                 -->
                    </div>
                </div>
            </form>
            @if (!$auth->hasRoles(['vendor']))
                <div class="row">
                    <div class="col-md-4">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="card dashcard">
                                    <div class="card-header">
                                        <div class="row align-items-end">
                                            <div class="col-9">
                                                <h2>Users</h2>
                                                <h3>Top 5 Countries</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body approdashstat">
                                        <canvas id="InspectionStatus" height="130px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="card dashcard">
                                    <div class="card-header">
                                        <div class="row align-items-end">
                                            <div class="col-9">
                                                <h2>Vendors Count</h2>
                                                <h3>Top 5 Countries</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body approdashstat">
                                        <canvas id="Vendorstatus" height="130px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="card dashcard">
                                    <div class="card-header">
                                        <div class="row align-items-end">
                                            <div class="col-9">
                                                <h2>Vendors Performace</h2>
                                                <h3>Top 5 Vendor</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body approdashstat">
                                        <canvas id="Vendorperfor" height="130px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="card dashcard">
                        <div class="card-header">
                            <div class="row align-items-end mt-2">
                                <div class="col-9">
                                    <h2>Offers Listed</h2>
                                    <h3>Total</h3>
                                </div>
                                <div class="col-3 text-right">
                                    <img src="/assets/admin/images/folder-open.png" height="43px" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body approdashstat">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h4>
                                        {{ count($offers) }}
                                    </h4>
                                    <p>Offers</p>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h4>
                                        {{ count($promoCodes) }}
                                    </h4>
                                    <p>Coupons</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashcard">
                        <div class="card-header">
                            <div class="row align-items-end mt-2">
                                <div class="col-9">
                                    <h2>Offers Sold</h2>
                                    <h3>Total</h3>
                                </div>
                                <div class="col-3 text-right">
                                    <img src="/assets/admin/images/folder-open.png" height="43px" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body approdashstat">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h4>
                                        {{ count($soldOffers) }}
                                    </h4>
                                    <p>Offers</p>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h4>
                                        {{ count($soldPromoCodes) }}
                                    </h4>
                                    <p>Coupons</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!$auth->hasRoles(['vendor']))
                    <div class="col-md-4">
                        <div class="card dashcard">
                            <div class="card-header">
                                <div class="row align-items-end mt-2">
                                    <div class="col-9">
                                        <h2>Earnings</h2>
                                        <h3>Total</h3>
                                    </div>
                                    <div class="col-3 text-right">
                                        <img src="/assets/admin/images/folder-open.png" height="43px" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body approdashstat">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $earning }}</h4>
                                        <p>USD</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="card dashcard">
                                <div class="card-header">
                                    <div class="row align-items-end">
                                        <div class="col-9">
                                            <h2>Performing offers</h2>
                                            <h3>Top 5 offers</h3>
                                        </div>
                                        <div class="col-3 text-right">
                                            <img src="/assets/admin/images/folder-open-fade.png" height="43px" />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body approdashstat">
                                    <div class="row align-items-center">
                                        @foreach ($offersTop5 as $key => $item)
                                            <div class="col-6 col-sm-2">
                                                <h4>{{ $item['sold_value'] }}</h4>
                                                <p class="text-black">{{ $item['offer_name'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
{{-- {{dd(json_encode($constantCountries))}} --}}
@section('styles')
    <style type="text/css"></style>
@stop

@section('scripts')
    <script src="/assets/admin/js/jquery.min.js"></script>
    <script src="/assets/admin/js/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/assets/admin/js/main.js"></script>
    <script src="/assets/admin/js/chart.js"></script>
    <script>
        var e = document.getElementById('InspectionStatus').getContext('2d');
        var weightChart = new Chart(e, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labelUserCountries) ?>,
                datasets: [{
                    label: 'Users',
                    data: <?= json_encode($totalUsers) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)'
                    ],
                    barThickness: 15,
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });


        var e = document.getElementById('Vendorstatus').getContext('2d');
        var weightChart = new Chart(e, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labelVendorCountries) ?>,
                datasets: [{
                    label: 'Vendors',
                    data: <?= json_encode($totalVendors) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)'
                    ],
                    barThickness: 15,
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }

            }
        });


        var e = document.getElementById('Vendorperfor').getContext('2d');
        var weightChart = new Chart(e, {
            type: 'bar',
            data: {
                labels: [@foreach ($vendorsTop5 as $item)'{{ $item['vendor_name'] }}', @endforeach],
                datasets: [{
                    label: 'Sold Value',
                    data: [@foreach ($vendorsTop5 as $item)'{{ $item['offers_sold_value'] }}', @endforeach],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)'
                    ],
                    barThickness: 15,
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }

            }
        });
    </script>
@stop
