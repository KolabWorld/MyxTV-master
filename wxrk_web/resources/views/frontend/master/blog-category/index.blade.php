@extends('admin/app')
{{-- Web site Title --}}
@section('title') Blog Categories :: @parent @stop
@section('content')

   <div class="content-header">
        <div class="container-fluid mt-3">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-12 col-12">
                    <div class="tophead">
                        <div class="allTitle">
                            <a class="d-block d-lg-none" data-widget="pushmenu" href="#" role="button"><img src="/assets/admin/img/menu-left-alt.svg" width="18px" /></a>
                            <h2>Blog Categories ({{ $blogCategories->total() }})</h2>
                            <div class="subTitle">Manage Blog Categories</div>
                        </div>
                        <div class="headpanel">
                            <div class="setting">
                                <a href="account-setting.html"><img src="/assets/admin/img/settings.svg" /></a>
                            </div>
                            <div class="notify">
                                <a href="#"><img src="/assets/admin/img/notify.svg" /></a>
                            </div>
                            <!-- <div class="setting">
                                <a href="{{ url('admin/admin-logout') }}"><img src="/assets/admin/img/logout.png" width="23" style="opacity: 0.8"></a>
                            </div>  -->
                            <div class="adlogo d-inline-block">
                                <img src="/assets/frontend/img/logo/logo-black.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="backbtnPanel">
                        <div><a href="javascript:history.back()" class="btn btn-sm btn-auto btn-outline-dark">Back</a></div>
                        <div>
                            <div class="searchTb">
                                <form action="" method="GET">
                                    <div class="input-group custom-search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Search by name" value="{{ Request::get('search') }}" name="search" aria-label="Search" aria-describedby="basic-addon1">
                                    </div>
                                </form>
                            </div>
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
                    <div class="tableHead">
                        <div class="row">
                            <div class="col-md-12">
                                {{-- <div class="filterarea">
                                    <div class="sel_all">
                                        <input class="filled-in" name="group1" type="checkbox" id="news">
                                        <label for="news" class="text-dark">Select All</label>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-color table-bordered admintable border-0" cellspacing="0" cellpadding="0">
                            @foreach ($blogCategories as $key => $blogCategory)
                            <tr>
                                {{-- <td colspan="2">
                                    <input class="filled-in" name="group1" type="checkbox" id="news1">
                                    <label for="news1"></label>
                                </td> --}}
                                <td><strong>{{ $blogCategory->name }}</strong>Category Name</td>
                                <td><strong>{{ $blogCategory->alias }}</strong>Category Alias</td>
                                <td>
                                    <a onclick="setEditForm({{json_encode($blogCategory)}})" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <a href="#" data-url="/admin/blog-categories/{{ $blogCategory->id }}" data-request="remove" data-redirect="/admin/blog-categories" class="btn btn-sm btn-outline-dark">Remove</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                  {{ $blogCategories->appends(request()->except('page'))->links('admin.layouts.pagination') }}
                </section>

                <section class="col-lg-4 connectedSortable">
                    <form role="post-data" id="form_action" method="POST" redirect="/admin/blog-categories" action="/admin/blog-categories" enctype="multipart/form-data">
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" id="add-edit-category">Add New</h3>
                                <p>Blog Categories</p>
                            </div>

                            <div class="card-body">
                                <div class="md-form">
                                    <input type="text" id="product_type_name" name="name" pattern="[A-Za-z\s]" placeholder="Enter Name" class="form-control">
                                    <label for="stitle">Category Name</label>
                                </div>
                                
                                <div class="md-form">
                                    <input type="text" id="product_type_alias" name="alias" placeholder="Enter Alias" class="form-control">
                                    <label for="stitle">Category Alias</label>
                                </div>
                                
                                <div class="mt-2">
                                    <button type="button" id="submit" data-request="ajax-submit" data-target="[role=post-data]" class="btn btn-sm btn-dark">Publish Blog Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    function setEditForm(data) {
        console.log(data);
        var isDisabled = false;
        $('#variable_form_action').show();
        $(".has-error").removeClass('has-error');
        $('.help-block').remove();
        $("#add-edit-category").html('Edit Blog Category');
        $('#method').val("PUT");
        $('#product_type_name').val(data.name);
        $('#product_type_alias').val(data.alias);

        $('#submit').html('Update Blog Category');
       
        $('#form_action').attr('action', '/admin/blog-categories/'+data.id);
    }
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection