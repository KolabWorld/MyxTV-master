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
                            <h2>Home Section</h2>
                            <div class="subTitle">Manage Home Section</div>
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
            <!-- <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="backbtnPanel nonflex">
                        <div>
                            <a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
	</div>

    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-color table-bordered admintable border-0 mb-2" cellspacing="0" cellpadding="0">
                                    {{-- <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">Hero section</h3>
                                                <h3 class="f-12 theme-Ltext playfair">Image / Video</h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($heroSection && count($heroSection))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @foreach($heroSection as $key => $slider)
                                                @if($slider->attachment_type == 'video')                                                    
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                    <div class="img-wh40 float-left mr-2"><img src="{{$slider->attachment}}" style="border: 0.5px solid #7070705a;"></div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=hero-section" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Banner section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($bannerSection && count($bannerSection))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @foreach($bannerSection as $key => $slider)
                                                @if($slider->attachment_type == 'video')\
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=banner-section" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Seller Promotion Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($storySection && count($storySection))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider </strong>Type
                                        </td>
                                        <td>
                                            @foreach($storySection as $key => $slider)
                                                @if($slider->attachment_type == 'video')
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=story-section" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Item Promotion Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($storySection1 && count($storySection1))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider </strong>Type
                                        </td>
                                        <td>
                                            @foreach($storySection1 as $key => $slider)
                                                @if($slider->attachment_type == 'video')
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=story-section-1" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Offer Promotion Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($storySection2 && count($storySection2))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider </strong>Type
                                        </td>
                                        <td>
                                            @foreach($storySection2 as $key => $slider)
                                                @if($slider->attachment_type == 'video')
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=story-section-2" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Scheme Wise Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($storySection3 && count($storySection3))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider </strong>Type
                                        </td>
                                        <td>
                                            @foreach($storySection3 as $key => $slider)
                                                @if($slider->attachment_type == 'video')
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=story-section-3" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Top Trending Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($storySection4 && count($storySection4))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider </strong>Type
                                        </td>
                                        <td>
                                            @foreach($storySection4 as $key => $slider)
                                                @if($slider->attachment_type == 'video')
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=story-section-4" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Deals Of The Day Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Content & Query
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$dealsOfTheDaySection || empty($dealsOfTheDaySection->homeFeatures) || ($dealsOfTheDaySection->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @if($dealsOfTheDaySection && ($dealsOfTheDaySection->homeFeatures))
                                                @foreach($dealsOfTheDaySection->homeFeatures as $key => $p)
                                                    <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=deals-of-the-day" class="btn btn-sm btn-outline-dark">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Top Selling Products
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Content & Query
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$topSellingProductSection || empty($topSellingProductSection->homeFeatures) || ($topSellingProductSection->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @if($topSellingProductSection && ($topSellingProductSection->homeFeatures))
                                                @foreach($topSellingProductSection->homeFeatures as $key => $p)
                                                    <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=top-selling-product" class="btn btn-sm btn-outline-dark">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Top Rated Products
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Content & Query
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$topRatedProductSection || empty($topRatedProductSection->homeFeatures) || ($topRatedProductSection->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @if($topRatedProductSection && ($topRatedProductSection->homeFeatures))
                                                @foreach($topRatedProductSection->homeFeatures as $key => $p)
                                                    <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=top-rated-product" class="btn btn-sm btn-outline-dark">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Onsale Products
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Content & Query
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$onSaleProductSection || empty($onSaleProductSection->homeFeatures) || ($onSaleProductSection->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @if($onSaleProductSection && ($onSaleProductSection->homeFeatures))
                                                @foreach($onSaleProductSection->homeFeatures as $key => $p)
                                                    <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=onsale-product" class="btn btn-sm btn-outline-dark">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Best Selling Section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Content & Query
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$bestSellingProductSection || empty($bestSellingProductSection->homeFeatures) || ($bestSellingProductSection->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider</strong>Type
                                        </td>
                                        <td>
                                            @if($bestSellingProductSection && ($bestSellingProductSection->homeFeatures))
                                                @foreach($bestSellingProductSection->homeFeatures as $key => $p)
                                                <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=best-selling-product" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">New Products</h3>
                                                <h3 class="f-12 theme-Ltext playfair">Carasole products</h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$newProductSection || empty($newProductSection->homeFeatures) || ($newProductSection->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Links</strong>Type
                                        </td>
                                        <td>
                                            @if($newProductSection && ($newProductSection->homeFeatures))
                                                @foreach($newProductSection->homeFeatures as $key => $p)
                                                <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" width="40px" class="mr-2" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=new-product" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">Featured designer</h3>
                                                <h3 class="f-12 theme-Ltext playfair">Designer & Carousel</h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if(!$featuredDesigner || empty($featuredDesigner->homeFeatures) || ($featuredDesigner->status == 'inactive'))
                                                <div class="tb_status light">Inactive</div>
                                            @else 
                                                <div class="tb_status dark">Active</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Links</strong>Type
                                        </td>
                                        <td>
                                            @if($featuredDesigner && ($featuredDesigner->homeFeatures))
                                                @foreach($featuredDesigner->homeFeatures as $key => $p)
                                                <div class="img-wh40 float-left mr-2"><img src="{{$p->product->featured_image}}" width="40px" class="mr-2" style="border: 0.5px solid #7070705a;" /></div>
                                                @endforeach
                                            @endif
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/home/create?type=featured-designer" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-white pl-0">
                                            <div>
                                                <h3 class="f-18 playfair mb-1">
                                                    Story section
                                                </h3>
                                                <h3 class="f-12 theme-Ltext playfair">
                                                    Image / Video & Content
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            @if($storySection && count($storySection))
                                                <div class="tb_status dark">Active</div>
                                            @else 
                                                <div class="tb_status light">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>Slider </strong>Type
                                        </td>
                                        <td>
                                            @foreach($storySection as $key => $slider)
                                                @if($slider->attachment_type == 'video')
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <video muted width="40px" height="40px"  style="object-fit:cover; border: 0.5px solid #7070705a" autoplay="1">
                                                            <source src="{{$slider->attachment}}">
                                                        </video>
                                                    </a> 
                                                @else
                                                    <a href="{{$slider->attachment}}" target="new">
                                                        <div class="img-wh40 float-left mr-2">
                                                            <img src="{{$slider->attachment}}" height="40px" class="mr-2" style="border: 0.5px solid #7070705a;">
                                                        </div>
                                                    </a> 
                                                @endif
                                            @endforeach
                                        </td> 
                                        <td class="textM-right">
                                            <a href="/admin/sliders?type=story-section" class="btn btn-sm btn-outline-dark">View Details</a>
                                        </td>
                                    </tr> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@stop

@section('styles')
    <style type="text/css"></style>
@stop

@section('scripts')
    <script src="{{ asset('js/custom-script.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script type="text/javascript"></script>
@stop


