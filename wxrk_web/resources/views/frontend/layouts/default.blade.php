@extends('app')
@section('content')
    <div class="row">
        @yield('top')
    </div>
    <div class="row">
        <div class="col-sm-9 col-md-10 main">
            @yield('main')
        </div>
    </div>
@endsection

{{-- Web site Title --}}
@section('title')
    Administration :: @parent
@endsection

{{-- Styles --}}
@section('styles')
    @parent
    {{--<link href="{{asset('assets/admin/css/plugins/metisMenu/metisMenu.min.css')}}"--}}
    {{--rel="stylesheet">--}}
    {{--<link href="{{asset('assets/admin/css/sb-admin-2.css')}}"--}}
    {{--rel="stylesheet">--}}
    {{--<link href="{{asset('assets/admin/css/jquery.dataTables.css')}}"--}}
    {{--rel="stylesheet">--}}
    {{--<link href="{{asset('assets/admin/css/dataTables.bootstrap.css')}}"--}}
    {{--rel="stylesheet">--}}
    {{--<link href="{{asset('assets/admin/css/colorbox.css')}}" rel="stylesheet">--}}


@endsection

{{-- Sidebar --}}
@section('sidebar')
    @include('admin.partials.nav')
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

    {{-- Not yet a part of Elixir workflow --}}
    {{--<script src="{{asset('assets/admin/js/jquery-migrate-1.2.1.min.js')}}"></script>--}}
    {{--<script src="{{asset('assets/admin/js/jquery-ui.1.11.2.min.js')}}"></script>--}}
    {{--<script src="{{asset('assets/admin/js/plugins/metisMenu/metisMenu.min.js')}}"></script>--}}
    {{--<script src="{{asset('assets/admin/js/sb-admin-2.js')}}"></script>--}}

    {{--<script src="{{asset('assets/admin/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--<script src="{{asset('assets/admin/js/dataTables.bootstrap.js')}}"></script>--}}



@endsection
