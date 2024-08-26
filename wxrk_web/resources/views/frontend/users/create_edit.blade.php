@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop


@section('content')

    @include('frontend.partials.nav', [
        'title' => 'View Profile',
        'description' => 'Add/Edit',
    ])

    <section class="content mb-3">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center position-top-sticky">
                        <div class="col-5 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-7 text-sm-right">
                            <a href="dashboard.html" class="btn btn-success mr-2">Update</a>
                            <a href="dashboard.html" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>


                    <div class="dashbed-border-bottom mt-2 mb-3"></div>

                    <div class="row">
                        <div class="col-md-12">
                             <div class="card formCard">
                                <div class="card-body">
                                     <div class="row justify-content-between">
                                        <div class="col-md-7">
                                            <div class="head-title form-head mb-4">
                                                <h2>View user details</h2>
                                                <h5>Logged in user details</h5>
                                            </div>

                                            <div class="row"> 
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Full name</label>
                                                         <input type="text" class="form-control" value="John Doe" placeholder="Enter Full Name" disabled />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Date of Joining</label>
                                                         <input type="date" class="form-control"  disabled />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Email address</label>
                                                         <input type="text" class="form-control" value="emaill@example.com" placeholder="Enter Email address" disabled />
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Phone number</label>
                                                         <input type="text" class="form-control" value="+00 9876543210" placeholder="Enter Phone No." disabled />
                                                    </div>
                                                </div>  
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Country</label>
                                                         <select class="form-control" disabled>
                                                            <option>Select</option>
                                                            <option selected>India</option> 
                                                         </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Date of Birth</label>
                                                         <input type="date" class="form-control"  disabled />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>Total Idle time</label>
                                                         <input type="text" class="form-control" value="20 hrs" disabled   />
                                                    </div>
                                                </div>  
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>$CX Earned</label>
                                                         <input type="number" class="form-control" value="1500" disabled />
                                                    </div>
                                                </div> 
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>$CX Spent</label>
                                                         <input type="number" class="form-control" value="1000" disabled />
                                                    </div>
                                                </div> 
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group innerappform">
                                                         <label>$CX Balance</label>
                                                         <input type="number" class="form-control" value="500" disabled />
                                                    </div>
                                                </div> 

                                            </div> 
                                            
                                              
                                            
                                        </div>
                                         
                                        
                                        <div class="col-md-4">
                                            <div class="head-title form-head mb-4">
                                                <h2>Profile image</h2>
                                                <h5>Update your image</h5>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                 
                                                    <div class="profileuploadded">
                                                        <img src="/assets/admin/images/avtar.jpg">
                                                        <span class="btncross"><img src="/assets/admin/images/closeimg.svg" /></span>
                                                    </div>
                                                 
                                                    <div class="upload-btn-wrapper upload-popimg ">
                                                        <button class="uploadBtn">
                                                            <p class="f-14 fw-bold text-theme mb-0">Upload profile image</p>
                                                            <p class="fw-medium f-12 text-darkgrey mb-0">Tap to browse</p>
                                                        </button>
                                                        <input type="file">
                                                   </div>  
                                              </div>
                                            
                                            <div class="head-title form-head my-4">
                                                <h2>Status</h2>
                                                <h5>Select and update the status</h5>
                                            </div>
                                            <div class="">
                                                <div class="activechkbox">
                                                    <input class="filled-in" name="group1" type="radio" id="active" checked="">
                                                    <label for="active">ACTIVE</label>
                                                </div>
                                                <div class="activechkbox">
                                                    <input class="filled-in" name="group1" type="radio" id="inactive">
                                                    <label for="inactive">INACTIVE</label>
                                                </div>
                                                <div class="activechkbox">
                                                    <input class="filled-in" name="group1" type="radio" id="black">
                                                    <label for="black">BLACKLIST</label>
                                                </div> 

                                            </div>
                                        </div>
                                    
                                    </div>
                                 
                                </div>
                            
                             </div> 
                        
                        </div>
                    
                         
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="accordion addformaccordian" id="addAccordian">
                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#Equipment" aria-expanded="false">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="head-title form-head">
                                                            <h2>Day wise Collection</h2>
                                                            <h5>Details</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="Equipment" class="collapse show" data-parent="#addAccordian"
                                        style="">
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table datatbalennew">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.NO</th>
                                                                    <th>Date</th>
                                                                    <th>Collection Coin</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>200</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>200</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>200</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>4</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>200</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>5</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>200</td>
                                                                </tr>


                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    <div class="pagination_rounded pr-4">
                                                        <ul>
                                                            <li>
                                                                <a href="#" class="prev"> <i
                                                                        class="fa fa-chevron-left"></i> </a>
                                                            </li>
                                                            <li><a href="#" class="active">1</a> </li>
                                                            <li><a href="#">2</a> </li>
                                                            <li class="d-none d-sm-inline-block"><a href="#">3</a>
                                                            </li>
                                                            <li class="d-none d-sm-inline-block"><a href="#">4</a>
                                                            </li>
                                                            <li><a href="#" class="pdots">...</a> </li>
                                                            <li><a href="#">5</a> </li>
                                                            <li>
                                                                <a href="#" class="prev next"> <i
                                                                        class="fa fa-chevron-right"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>

                        <div class="col-md-6">

                            <div class="accordion addformaccordian" id="addAccordian">


                                <div class="card formCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#EquipmentDocuments">
                                                <div class="head-title form-head">
                                                    <h2>Daily app Usage statistics</h2>
                                                    <h5>Details</h5>
                                                </div>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="EquipmentDocuments" class="collapse show" data-parent="#addAccordian">
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table datatbalennew">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Date</th>
                                                                    <th>App Name</th>
                                                                    <th>Usage Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>Youtube</td>
                                                                    <td>2 hrs</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>Facebook</td>
                                                                    <td>1 hrs 20 min</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>Whatsapp</td>
                                                                    <td>4 hrs 20 min</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>4</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>Linkdin</td>
                                                                    <td>2 hrs</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>5</td>
                                                                    <td><strong>18-07-2022</strong></td>
                                                                    <td>Facebook</td>
                                                                    <td>1 hrs 20 min</td>
                                                                </tr>


                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    <div class="pagination_rounded pr-4">
                                                        <ul>
                                                            <li>
                                                                <a href="#" class="prev"> <i
                                                                        class="fa fa-chevron-left"></i> </a>
                                                            </li>
                                                            <li><a href="#" class="active">1</a> </li>
                                                            <li><a href="#">2</a> </li>
                                                            <li class="d-none d-sm-inline-block"><a href="#">3</a>
                                                            </li>
                                                            <li class="d-none d-sm-inline-block"><a href="#">4</a>
                                                            </li>
                                                            <li><a href="#" class="pdots">...</a> </li>
                                                            <li><a href="#">5</a> </li>
                                                            <li>
                                                                <a href="#" class="prev next"> <i
                                                                        class="fa fa-chevron-right"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>


                        </div>
                    </div>







                </div>

            </div>


        </div>
    </section>

@endsection

@section('scripts')
    @parent

    </script>
@endsection
