@extends('frontend.app-blank')
@extends('admin/app')
{{-- Web site Title --}}
@section('title') Unauthorized :: @parent @stop
@section('content')

<div class="content-header scanboxbox-shadow pb-2 mob-contentheader">
    <div class="container-fluid">
        <div class="row align-items-center mb-1">
              <div class="col-2">
                <a href="javascript:history.back()" ><img src="/assets/admin/images/popup-close.svg" width="16px" /></a>
              </div>
              <div class="col-8 text-center">
                  <img src="/assets/admin/images/logo.png" />
              </div>
        </div>  
    </div>
</div>
<!-- <div class="content-header scanboxbox-shadow pb-2 mob-contentheader">
    <div class="container-fluid">
        <div class="row align-items-center mb-1">
            <div class="col-2">
                <a href="/unauthorized/view"><img src="/assets/admin/images/popup-close.svg" width="16px" /></a>
            </div>
            <div class="col-8 text-center"> -->
                <img src="/assets/admin/images/logo.png" />
            <!-- </div>
        </div>
    </div>
</div> -->
<br><br>
<h2> This Page doesn't exiss.</h2>
</div>


@endsection

    





