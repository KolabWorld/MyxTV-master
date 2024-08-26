@extends('layouts.modal') 

@section('content')

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Delete User</h3>
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm close_popup">
                        <span class="glyphicon glyphicon-backward"></span> {{{trans('admin/admin.back') }}}
                        </button>
                    </div>
                </div>
                <form id="deleteForm" class="form-horizontal" method="post" action="@if (isset($user)){{ URL::to('admin/users/' . $user->id . '/delete') }}@endif" autocomplete="off">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> 
                    <input type="hidden" name="id" value="{{ $user->id }}" />
                    <div class="controls" style='text-align:center;'>
                        {{ trans("admin/modal.delete_message") }}<br><br><br>
                        <element class="btn btn-warning btn-sm close_popup">
                            <span class="glyphicon glyphicon-ban-circle"></span> 
                            {{trans("admin/modal.cancel") }}
                        </element>
                        <button type="submit" class="btn btn-sm btn-danger">
                            <span class="glyphicon glyphicon-trash"></span> {{ trans("admin/modal.delete") }}
                        </button>
                    </div>
                    <br><br>
                </form>
            </div>
        </div>
    </div>
</section>
@stop
