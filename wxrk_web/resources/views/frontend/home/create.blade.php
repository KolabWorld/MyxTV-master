@extends('admin/app')
{{-- Web site Title --}}
@section('title') Home Section :: @parent @stop
@section('content')

	<div class="content-header">
        <div class="container-fluid mt-3">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 col-12">
                    <div class="tophead">
                        <div class="allTitle">
                            <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button">
                                <img src="/assets/admin/img/menu-left-alt.svg" width="18px" />
                            </a>
                            @if($type == 'deals-of-the-day')
                                <h2>Deals Of The Day</h2>
                            @elseif($type == 'top-selling-product') 
                                <h2>Top Selling products</h2>
                            @elseif($type == 'top-rated-product') 
                                <h2>Top Rated products</h2>
                            @elseif($type == 'onsale-product') 
                                <h2>Onsale products</h2>
                            @elseif($type == 'best-selling-product') 
                                <h2>Best Selling products</h2>
                            @else 
                                <h2>New products</h2>
                            @endif
                        </div>
                        <div class="headpanel">
                            <div class="setting">
                                <a href="#">
                                    <img src="/assets/admin/img/settings.svg" />
                                </a>
                            </div>
                            <div class="notify">
                                <a href="#">
                                    <img src="/assets/admin/img/notify.svg" />
                                </a>
                            </div>
                            <div class="adlogo d-inline-block">
                                <img src="/assets/frontend/img/logo/logo-black.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="backbtnPanel nonflex">
                        <div>
                            <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                        </div>
                        <div>
                            <button type="button" id="save" class="btn btn-sm btn-dark btn-auto">Update Section</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <section class="content mb-5">
        {!! Form::open(['action' => 'Admin\HomeController@save', 'id'=>"post-data", 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-8 connectedSortable">
                        <input type="hidden" name="type" value="{{$type}}">
                        @if($type == 'deals-of-the-day')
                            <input type="hidden" name="id" value="{{$dealsOfTheDaySection ? $dealsOfTheDaySection->id : 0}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="text" id="stitle2" placeholder="Enter here" class="form-control" name="content" value="{{$dealsOfTheDaySection ? $dealsOfTheDaySection->content : '' }}">
                                                    {{-- <label for="stitle2">What’s new description</label> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p class="playfair f-14 theme-Dtext">Data Query:</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @for($i = 0; $i < 30; $i++)
                                                <div class="col-sm-6">
                                                    <div class="md-form">
                                                        @if(isset($dealsOfTheDaySection->homeFeatures[$i]->product->code))
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control" value="{{$dealsOfTheDaySection->homeFeatures[$i]->product->code}}">
                                                        @else 
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control">
                                                        @endif
                                                        <label for="stitle1" class="active">Product code</label>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code7" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code8" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div> 
                                            </div> 
                                        </div> -->
                                        <!-- <button class="btn btn-outline-dark btn-md z-depth-0">Add More</button> -->
                                    </div>
                                </div>
                            </div>
                        @elseif($type == 'top-selling-product')
                            <input type="hidden" name="id" value="{{$topSellingProductSection ? $whatsNewProduct->id : 0}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="text" id="stitle2" placeholder="Enter here" class="form-control" name="content" value="{{$topSellingProductSection ? $topSellingProductSection->content : '' }}">
                                                    {{-- <label for="stitle2">What’s new description</label> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p class="playfair f-14 theme-Dtext">Data Query:</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @for($i = 0; $i < 30; $i++)
                                                <div class="col-sm-6">
                                                    <div class="md-form">
                                                        @if(isset($topSellingProductSection->homeFeatures[$i]->product->code))
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control" value="{{$topSellingProductSection->homeFeatures[$i]->product->code}}">
                                                        @else 
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control">
                                                        @endif
                                                        <label for="stitle1" class="active">Product code</label>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code7" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code8" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div> 
                                            </div> 
                                        </div> -->
                                        <!-- <button class="btn btn-outline-dark btn-md z-depth-0">Add More</button> -->
                                    </div>
                                </div>
                            </div>
                        @elseif($type == 'top-rated-product')
                            <input type="hidden" name="id" value="{{$topRatedProductSection ? $topRatedProductSection->id : 0}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="text" id="stitle2" placeholder="Enter here" class="form-control" name="content" value="{{$topRatedProductSection ? $topRatedProductSection->content : '' }}">
                                                    {{-- <label for="stitle2">What’s new description</label> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p class="playfair f-14 theme-Dtext">Data Query:</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @for($i = 0; $i < 5; $i++)
                                                <div class="col-sm-6">
                                                    <div class="md-form">
                                                        @if(isset($topRatedProductSection->homeFeatures[$i]->product->code))
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control" value="{{$topRatedProductSection->homeFeatures[$i]->product->code}}">
                                                        @else 
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control">
                                                        @endif
                                                        <label for="stitle1" class="active">Product code</label>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code7" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code8" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div> 
                                            </div> 
                                        </div> -->
                                        <!-- <button class="btn btn-outline-dark btn-md z-depth-0">Add More</button> -->
                                    </div>
                                </div>
                            </div>
                        @elseif($type == 'onsale-product')
                            <input type="hidden" name="id" value="{{$onSaleProductSection ? $onSaleProductSection->id : 0}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="text" id="stitle2" placeholder="Enter here" class="form-control" name="content" value="{{$onSaleProductSection ? $onSaleProductSection->content : '' }}">
                                                    {{-- <label for="stitle2">What’s new description</label> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p class="playfair f-14 theme-Dtext">Data Query:</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @for($i = 0; $i < 30; $i++)
                                                <div class="col-sm-6">
                                                    <div class="md-form">
                                                        @if(isset($onSaleProductSection->homeFeatures[$i]->product->code))
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control" value="{{$onSaleProductSection->homeFeatures[$i]->product->code}}">
                                                        @else 
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control">
                                                        @endif
                                                        <label for="stitle1" class="active">Product code</label>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code7" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code8" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div> 
                                            </div> 
                                        </div> -->
                                        <!-- <button class="btn btn-outline-dark btn-md z-depth-0">Add More</button> -->
                                    </div>
                                </div>
                            </div>
                        @elseif($type == 'best-selling-product')
                            <input type="hidden" name="id" value="{{$bestSellingProductSection ? $bestSellingProductSection->id : 0}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="text" id="stitle2" placeholder="Enter here" class="form-control" name="content" value="{{$bestSellingProductSection ? $bestSellingProductSection->content : '' }}">
                                                    {{-- <label for="stitle2">What’s new description</label> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p class="playfair f-14 theme-Dtext">Data Query:</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @for($i = 0; $i < 30; $i++)
                                                <div class="col-sm-6">
                                                    <div class="md-form">
                                                        @if(isset($bestSellingProductSection->homeFeatures[$i]->product->code))
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control" value="{{$bestSellingProductSection->homeFeatures[$i]->product->code}}">
                                                        @else 
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control">
                                                        @endif
                                                        <label for="stitle1" class="active">Product code</label>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code7" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="md-form">
                                                    <input type="text" id="stitle1" placeholder="Enter here" name="code8" class="form-control">
                                                    <label for="stitle1">Product code</label>
                                                    <a href="#" class="delBtn"><img src="/assets/admin/img/delete.svg"></a>
                                                </div> 
                                            </div> 
                                        </div> -->
                                        <!-- <button class="btn btn-outline-dark btn-md z-depth-0">Add More</button> -->
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="myordersData">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="md-form">
                                                    <input type="hidden" name="id" value="{{$newProductSection ? $newProductSection->id : 0}}">
                                                    <input type="text" id="stitle2" placeholder="Enter here" class="form-control" name="collection_content" value="{{$newProductSection ? $newProductSection->content : '' }}">
                                                    <label for="stitle2">Collections description</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <p class="playfair f-14 theme-Dtext">Data Query:</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @for($i = 0; $i < 5; $i++)
                                                <div class="col-sm-6">
                                                    <div class="md-form">
                                                        @if(isset($newProductSection->homeFeatures[$i]->product->code))
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control" value="{{$newProductSection->homeFeatures[$i]->product->code}}">
                                                        @else 
                                                            <input type="text" id="stitle1" placeholder="Enter here" name="code[]" class="form-control">
                                                        @endif
                                                        <label for="stitle1" class="active">Product code</label>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </section>
                    <section class="col-lg-4 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Update</h3>
                                <p>Status</p>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status" required="">
                                        @foreach ($status as $value)
                                        <option value="{{ $value }}" {{ old('status') == $value ? 'selected':'' }}>{{ ucfirst($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        {!! Form::close() !!} 
    </section>
@stop

@section('styles')
    <style type="text/css">
    
    </style>
@stop

@section('scripts')
    <script type="text/javascript">
        $('#save').on('click', function (e) { 
            $('#post-data').submit();
        });
    </script>
@stop


