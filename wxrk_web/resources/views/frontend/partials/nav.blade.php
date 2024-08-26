<div class="content-header d-none d-sm-block">
    <div class="container-fluid mt-3">
        <div class="row mb-2">
            <div class="col-1 d-block d-sm-none order-1">
                <a data-widget="pushmenu" href="#" role="button">
                    <img src="/assets/admin/images/menu-left-alt.svg" width="15px" />
                </a>
            </div>
            <div class="col-sm-4 col-12 mt-3 mt-sm-0 order-3 order-sm-1">
                <div class="head-title">
                    <h2>{{ $title }}</h2>
                    <h5>{!! $description !!}</h5>
                </div>
            </div>
            <div class="col-sm-8 col-11 order-2 order-sm-2">              	 
                <ul class="topheadSett">
                    <li>
                        <a href="#" class="userfullname">
                            {{ \Auth::user()->contact_person_name }}<br>
                            <span class="fw-bold">
                                @foreach (\Auth::user()->roles as $role)
                                        {{ $role->name }}@if(!$loop->last), @endif
                                @endforeach
                            </span>
                        </a>
                    </li>
                    <li>
                        <a  href="/profile" class="d-flex align-items-center">
                            <span class="username">
                                <img src="{{ \Auth::user()->logo ?: '/assets/admin/images/user.jpg' }}" />
                            </span> 
                            <img src="/assets/admin/images/dot.png" class="ml-2">
                        </a> 
                    </li>  
                    <li>
                        <a href="#"> 
                            <div class="coinbox">
                                <span>1</span>x <span>= {{ @$tokenSetting->value }} </span> <img src="/assets/admin/images/dollar.png" />
                            </div>
                        </a>
                   </li>
                    <li>
                        <a data-toggle="dropdown" href="#">
                            <img src="/assets/admin/images/notification.png" /> 
                            <span class="notiy">12</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="top-dropdown">
                                <li>
                                    <a href="#">
                                        <h2>Your Application No. <span>SM001</span> has been approved.</h2>
                                        <p><i class="far fa-calendar-alt"></i> 10 mins ago</p>
                                    </a> 
                                </li>
                                <li>
                                    <a href="#">
                                        <h2>Your Application No. <span>SM001</span> has been rejected.</h2>
                                        <p><i class="far fa-calendar-alt"></i> 10 mins ago</p>
                                    </a> 
                                </li>
                                <li>
                                    <a href="#">
                                        <h2>Your Application No. <span>SM001</span> has been approved.</h2>
                                        <p><i class="far fa-calendar-alt"></i> 10 mins ago</p>
                                    </a> 
                                </li>
                                <li>
                                    <a href="#">
                                        <h2>Your Application No. <span>SM001</span> has been rejected.</h2>
                                        <p><i class="far fa-calendar-alt"></i> 10 mins ago</p>
                                    </a> 
                                </li>
                            </ul>
                        </div>
                    </li>							  
                    <li>
                        <a href="/main-logout">
                            <img src="/assets/admin/images/logout.png" />
                        </a>
                    </li>							  
                </ul> 
            </div> 
        </div> 
    </div>
</div>


<div class="content-header d-block d-sm-none pb-2 mob-contentheader">
    <div class="container-fluid">
        <div class="row align-items-center mb-1">
              <div class="col-2">
                <a href="javascript:history.back()" ><img src="/assets/admin/images/popup-close.svg" width="16px" /></a>
              </div>
              <div class="col-8 text-center">
                  <div class="head-title"> 
                    <h5>{{ $title }}</h5>
                  </div>
              </div>
        </div>  
    </div>
</div>