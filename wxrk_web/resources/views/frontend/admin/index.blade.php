@extends('frontend.app')
{{-- Web site Title --}}
@section('title') ucFirst{{$role}} :: @parent @stop
@section('content')
@if($role == 'contractor')
    @include('frontend.partials.nav',['title'=> 'Coordinator Master' ,'description'=> 'Total Records '. $records->total() .''])
@else 
    @include('frontend.partials.nav',['title'=> 'User Master' ,'description'=> 'Total Records '. $records->total() .''])
@endif
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="row align-items-center"> 
                        @if($type == 'admins')
                        <div class="col-md-2">
                        </div>
                        @endif
                        <div class="col-md-4 text-right">
                            <a href="/main/{{$type}}/create" class="btn btn-secondary btn-filter mr-2">
                                <i class="far fa-plus-square mr-1"></i> Add New
                            </a>
                            {{-- <a href="#" class="btn btn-success btn-filter">
                                <i class="far fa-file-excel mr-1"></i> Export to Excel
                            </a> --}}
                        </div>
                        <div class="col-md-2"> 
                            <div class="inner-group custom-search  custom-search-inner">                                                
                                <select class="form-control" name="status" onchange="this.form.submit()">
                                <option value="">Select Status</option>
                                <option value="active" @if(Request::get('status') == 'active') selected @endif>Active</option>
                                <option value="inactive" @if(Request::get('status') == 'inactive') selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                        @if($type == 'contractors')
                        <div class="col-md-2"> 
                            <div class="inner-group custom-search  custom-search-inner">                                                
                                <select class="form-control" name="company_name" onchange="this.form.submit()">
                                <option value="">Select Company</option>
                                @php
                                    $companies = MenuHelper::companies();
                                @endphp
                                @foreach ($companies as $key => $company)
                                <option value="{{ $key }}" @if(Request::get('company_name') == $key) selected @endif>{{ $key }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4"> 
                            <div class="input-group custom-search custom-search-inner">                                                
                                <input type="text" name="search" value="{{ Request::get('search') }}" class="form-control" placeholder="Search list" aria-label="Username" aria-describedby="basic-addon1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <button type="submit" style="border:0;background:transparent"> <img src="/assets/admin/images/search.svg"> </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="dashbed-border-bottom mt-2 mb-3"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table dashtable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Email-Id</th>
                                                <th>Mobile No.</th>
                                                <th>Role</th> 
                                                @if($type == 'contractors')
                                                <th>Company Name</th>
                                                @endif
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($records as $key => $admin)
                                                <tr>
                                                    <td>
                                                        @if($admin->status == 'active')
                                                            <span class="badge badge-success">
                                                                {{ucfirst($admin->status)}}
                                                            </span>
                                                        @elseif($admin->status == 'inactive')
                                                            <span class="badge badge-danger">
                                                                {{ucfirst($admin->status)}}
                                                            </span>
                                                        @else 
                                                            <span class="badge badge-warning">
                                                                {{ucfirst($admin->status)}}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>
                                                            {{ucfirst($admin->name)}}
                                                        </strong>
                                                    </td> 
                                                    <td>
                                                        {{ucfirst($admin->email)}}
                                                    </td>  
                                                    <td>
                                                        {{ucfirst($admin->mobile)}}
                                                    </td>  
                                                    <td>
                                                        @foreach($admin->roles as $adminRole)
                                                            <badge>
                                                                {{$adminRole->name}} 
                                                            </badge> @if(!$loop->last),@endif
                                                        @endforeach
                                                    </td>  
                                                    @if($type == 'contractors')
                                                    <td>
                                                        {{ $admin->company_name ? ucfirst($admin->company_name) : '-'}}
                                                    </td> 
                                                    @endif 
                                                    <td>
                                                        <a href="/main/{{$type}}/{{ $admin->id }}/edit" class="btn btn-sm btn-outline-dark">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a> 
                                                        {{-- <a href="#" data-url="/main/{{$type}}/{{ $admin->id }}" data-request="remove" data-redirect="/main/{{$type}}" class="btn btn-sm btn-outline-dark">
                                                            <i class="far fa-trash-alt text-danger"></i>
                                                        </a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $records->appends(request()->except('page'))->links('frontend.layouts.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('scripts')
<script src="{{ asset('js/custom-script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    function getChilds(th) {
        var parentId = $('#parent_id').val();
        
        var data = {
            parent_id : parentId,
            '_token' : '{{{csrf_token()}}}'
        }
        $.ajax({
            url: '/admin/get-category-childs' ,
            type: 'POST',
            data: data,
            success:function(data) {
                var selectbox = '';
                if(data)
                {
                    selectbox = '<label for="child_id">Child</label>';
                    selectbox += '<select name="child_id" id="child_id" class="form-control">';
                    selectbox += '<option value="">Select Child</option>';
                    $.each(data, function (i, item) {
                        selectbox += '<option value="'+i+'">'+item+'</option>';
                    });
                    selectbox += '</select>';
                }
                $('#blank_child_id').css('display','none');
                $('#childs').css('display','block');
                $('#childs').html(selectbox);
            }
        });
    }
</script>
<script type="text/javascript">
    function setEditForm(data) {
        console.log(data);
        var isDisabled = false;
        $('#variable_form_action').show();
        $(".has-error").removeClass('has-error');
        $('.help-block').remove();
        $("#add-edit-category").html('Edit Category');
        $('#method').val("PUT");
        $('#category_name').val(data.name);
        $('#category_alias').val(data.alias);
        if(data.parent_id) {
            $("#parent_id option[value="+data.parent_id+"]").attr('selected', 'selected');
        }
        else{
            $("#parent_id option").removeAttr('selected');
        }

        if(data.childs && ((data.childs).length > 0)){
            isDisabled = true;
            $("#parent_id").prop('disabled', 'disabled');
        }
        else{
            $("#parent_id").prop('disabled', '');
        }

        $('#submit').html('Update Category');
       
        $('#form_action').attr('action', '/admin/categories/'+data.id);
    }
</script>
@stop

@section('styles')
<style type="text/css">
 
</style>
@endsection