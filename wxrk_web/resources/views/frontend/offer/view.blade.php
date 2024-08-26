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
                        <h2>View Offer</h2>
                        <div class="subTitle">View offers & assign designers and categories</div>
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
        <div class="row mb-2">
            <div class="col-sm-12">
                <div class="backbtnPanel">
                    <div>
                        <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                        <a href="{{ url('admin/offers/'.$offer->id.'/edit') }}" class="btn btn-sm btn-auto btn-outline-dark">Edit Details</a>
                    </div>
                    <div>
                        {{-- <a id="save" class="btn btn-sm btn-dark btn-auto">Update Offer</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="myordersData">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="md-form">
                                        <input type="text" name="title" placeholder="Enter the Title here" readonly value="{{ $offer->title }}" class="form-control">
                                        <label for="stitle">Offer title</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="form-group textarea-group">
                                        <label for="exampleFormControlTextarea2">Description</label>
                                        <p rows="3" >{{ $offer->descriptions }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Image</h3>
                                            <p>Featured Image</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img src="{{ $offer->featured_image ? $offer->featured_image :'/assets/admin/img/image.svg' }}" id="preview_featured" class="border w-100 mb-2" style="display: {{ $offer->featured_image ? '' :'none' }}">
                                                    {{-- <a href="#" class="delImageNew mr-1"><img src="/assets/admin/img/closered.svg" width="25" /></a> --}}
                                                </div>
                                            </div> 
                                            
                                            @error('featured_image')
                                            <label class="label">
                                                <strong class="text-danger"> {{ $message }}</strong>
                                            </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    &nbsp;
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="allTitle">
                                                    <h2>Offer discounts</h2>
                                                    <div class="subTitle mb-3">Define cart discounts</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="form-group">
                                                    <div class="md-form">
                                                        <input type="text" readonly placeholder="Enter here" name="value" value="{{ ucfirst($offer->offer_type) }}" class="form-control">
                                                        <label class="active" for="stitle">Type</label>
                                                    </div>
                                                    {{-- <select class="form-control" name="offer_type">
                                                        <option value="">Select</option>
                                                        @foreach ($offer_types as $offer_type)
                                                        <option value="{{ $offer_type }}" {{ $offer_type ==$offer->offer_type ? 'selected':''  }}>{{ ucfirst($offer_type) }}</option>
                                                        @endforeach
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="md-form">
                                                    <input type="text" readonly placeholder="Enter here" name="value" value="{{ $offer->value }}" class="form-control">
                                                    <label class="active" for="stitle">Value (%)</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="md-form">
                                                    <input readonly name="from_date" value="{{ $offer->from_date }}" class="form-control">
                                                    <label class="active" class="active" for="stitle">From Date</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="md-form">
                                                    <input readonly name="end_date" value="{{ $offer->end_date }}" class="form-control">
                                                    <label class="active" for="stitle">End Date</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="md-form">
                                                    <input readonly placeholder="Enter here" name="usage_limit" value="{{ $offer->usage_limit }}" class="form-control">
                                                    <label class="active" for="stitle">Usage limit</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="md-form">
                                                    <input readonly placeholder="Enter here" name="min_spend" value="{{ $offer->min_spend }}" class="form-control">
                                                    <label class="active" for="stitle">Min. Spend (USD)</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="md-form">
                                                    <input readonly placeholder="Enter here" name="max_spend" value="{{ $offer->max_spend }}" class="form-control">
                                                    <label class="active" for="stitle">Max. Spend (USD)</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">&nbsp;</div>

                                        </div>

                                        <div class="row mt-4 mb-2">
                                            <div class="col-sm-5">
                                                <div class="allTitle">
                                                    <h2>Specific products</h2>
                                                    <div class="subTitle mb-3">Select</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7 textM-right mb-2">
                                                {{-- <a class="btn btn-md btn-dark btn-auto mt-2" onclick="getCategoriesProducts();">Fetch from the selected categories</a> --}}
                                            </div>
                                        </div>
                                        <div class="row my-2" style="display: {{ count($mappedProducts) > 0 ? '':'none' }}" id="specific_products">
                                            {{-- append specific products --}}
                                            @foreach ($mappedProducts as $product)
                                                <div class="col-md-3 col-6">
                                                    <input class="filled-in" disabled name="products[{{ $product->id }}]" value="" type="checkbox" id="products_'{{ $product->id }}" {{ is_array($offerableProducts) && in_array($product->id, $offerableProducts) ? 'checked' : '' }}>
                                                    <label for="products_{{ $product->id }}">{{ $product->title }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product Category</h3>
                        <p>Select category & sub category</p>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach ($productCategories as $productCategory)
                            <div class="col-12">
                                <input disabled class="filled-in" onclick="checkChild(this);" name="category_id[]"
                                    value="{{ $productCategory->id }}" type="checkbox"
                                    id="cat_{{ $productCategory->id }}" {{ is_array($offerableCategories) && in_array($productCategory->id, $offerableCategories) ? 'checked' : '' }}>
                                <label for="cat_{{ $productCategory->id }}">{{ $productCategory->name }}</label>
                            </div>
                            @if (count($productCategory->childs)>0)
                            @foreach ($productCategory->childs as $child)
                            <div class="col-11 offset-1">
                                <input disabled class="filled-in sub_category parent_check_{{ $productCategory->id }}"
                                    name="sub_category_id[]" value="{{ $child->id }}" type="checkbox"
                                    id="child_{{ $child->id }}" {{ is_array($offerableSubCategories) && in_array($child->id, $offerableSubCategories) ? 'checked' : '' }}>
                                <label for="child_{{ $child->id }}">{{ $child->name }}</label>
                            </div>
                            @endforeach
                            @endif
                            @endforeach
                        </div>
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
<script type="text/javascript">
// 
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection