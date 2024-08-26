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
                            <h2>Pending Approvals</h2>
                            <div class="subTitle">Products / portfolios</div>
                        </div>
                        <div class="headpanel">
                            <div class="setting">
                                <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                            </div>									
                            <div class="notify">
                                <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                            </div>
                            {{-- <div class="setting">
                                <a href="login.html"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8" /></a>
                            </div> --}}
                            <div class="adlogo d-inline-block"><img src="/assets/admin/img/logo.svg" /></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="tableHead">
                        <div class="row">
                            <div class="col-sm-5 col-md-5">
                                <div class="filterarea">
                                    <div class="sel_all">
                                        <input class="filled-in" name="group1" type="checkbox" id="news">
                                        <label for="news" class="text-dark">Select All</label>
                                    </div>
                                    <div class="sortlink">
                                        <a href="#" class="text-dark"><img src="/assets/admin/img/filter.svg" /> Sort & Filter</a> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-7 textM-right">
                                <a href="{{ url('/admin') }}" class="btn btn-md mb-0 btn-auto btn-outline-dark waves-effect waves-light">Back</a>
                                <div class="searchTb">
                                    <div class="input-group custom-search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    
                    <h5 class="playfair f-15 mb-0">Products</h5>
                    <div class="border-top mt-2 mb-3"></div> 
                        
                    <div class="table-responsive">
                        <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                            @foreach ($pendingProducts as $pendingProduct)
                            <tr>
                                <td>
                                    <input class="filled-in" name="group1" type="checkbox" id="news1">
                                    <label for="news1"></label>
                                </td>
                                <td>
                                    <div class="tb_status light">{{ ucfirst($pendingProduct->status) }}</div>
                                </td>
                                <td><strong>{{ $pendingProduct->code }}</strong>Product code</td>
                                <td><strong>{{ $pendingProduct->title }}</strong>Item</td>
                                <td>
                                    <strong>
                                    @if(count($pendingProduct->categories)>0)
                                        @foreach ($pendingProduct->categories as $key => $category)
                                            {{ $key == 0 ?'':',' }}{{ $category->name }}
                                        @endforeach
                                    @endif
                                    </strong>Categories
                                </td>
                                <td>
                                    <strong>
                                    @if(count($pendingProduct->subCategories)>0)
                                        @foreach ($pendingProduct->subCategories as $key => $sub)
                                            {{ $key == 0 ?'':',' }}{{ $sub->name }}
                                        @endforeach
                                    @endif
                                    </strong>Sub Categories
                                </td>
                                <td><strong>{{ $pendingProduct->avg_lead_time }}</strong>Lead time</td>
                                <td><strong> $ {{(int)$pendingProduct->min_cost}} - $ {{(int)$pendingProduct->max_cost}}</strong>Amount</td>
                                <td class="textM-right">
                                    <a href="{{ url('admin/products/'.$pendingProduct->id) }}" class="btn btn-sm btn-outline-dark">View Details</a>
                                </td>
                            </tr>        
                            @endforeach
                        </table>
                    </div>

                    
                    <h5 class="playfair f-15 mb-0 mt-2">Portfolios</h5>
                    <div class="border-top mt-2 mb-3"></div> 
                    <div class="table-responsive">
                        <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                            @foreach ($pendingPortfolios as $portfolio)
                            <tr>
                                <td>
                                    <input class="filled-in" name="group1" type="checkbox" id="news1">
                                    <label for="news1"></label>
                                </td>
                                <td>
                                    <div class="tb_status light">{{ ucfirst($portfolio->status) }}</div>
                                </td>
                                <td><strong>{{ $portfolio->designer ? $portfolio->designer->name :'-' }}</strong>Designer</td>
                                <td><strong>{{ $portfolio->title }}</strong>Portfolio</td>
                                <td><strong>{{ $portfolio->attachment_type }}</strong>Type</td> 
                                <td>
                                    @if($portfolio->attachment_type == 'image')
                                    <div class="img-wh40"><img src="{{ $portfolio->attachment ? $portfolio->attachment :'/assets/admin/img/image.svg' }}" style="border: 0.5px solid #7070705a; "></div>
                                    @else
                                    <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                        <source src="{{ $portfolio->attachment ? $portfolio->attachment :'' }}">
                                    </video>
                                    @endif
                                </td>
                                <td class="textM-right">
                                    <a href="{{ url('admin/portfolio/'.$portfolio->id.'/view') }}" class="btn btn-sm btn-outline-dark">View Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <!-- <h5 class="playfair f-15 mb-0 mt-2">Designers</h5>
                    <div class="border-top mt-2 mb-3"></div> 
                    <div class="table-responsive">
                        <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                            @foreach ($pendingDesigners as $designer)
                            <tr>
                                <td>
                                    <input class="filled-in" name="group1" type="checkbox" id="news1">
                                    <label for="news1"></label>
                                </td>
                                <td>
                                    <div class="tb_status light">{{ ucfirst($designer->status) }}</div>
                                </td>
                                <td><strong>{{ $designer->name }}</strong>Designer</td>
                                <td><strong>{{ $designer->designer_id }}</strong>Designer ID#</td>
                                <td><strong>{{ $designer->email }}</strong>Contact</td>
                                <td><strong>{{ $designer->avg_lead_time }} days</strong>Lead time</td>
                              
                                <td>
                                    <a href="{{ url('admin/designers/'.$designer->id) }}" class="btn btn-sm btn-outline-dark">View Details</a>
                                </td>
                            </tr>                           
                            @endforeach
                        </table>
                    </div> -->

                </section>
            </div>
        </div>
    </section>

@stop

@section('styles')
    <style type="text/css"></style>
@stop 

@section('scripts')
    <script type="text/javascript"></script>
@stop
