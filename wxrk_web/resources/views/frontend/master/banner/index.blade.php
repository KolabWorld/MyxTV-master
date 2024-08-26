@extends('frontend.app')

{{-- Web site Title --}}
@section('title')  :: @parent @stop


@section('content')

@include('frontend.partials.nav', [
    'title' => 'All Banners',
    'description' => '254 Records',
])

<section class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-12">
                
                <div class="row align-items-center">
                    <div class="col-4 d-none d-sm-block">
                         <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                    </div>
                    <div class="col-12 col-md-8 text-sm-right"> 
                        <a href="/banner/create" class="btn btn-secondary btn-filter mr-2"><i class="far fa-plus-square mr-1"></i> Add New</a>
                        <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i> Export to Excel</a>
                    </div> 
                </div>

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
                                            <th>Date</th>
                                            <th>Category</th>
                                            <th>Banner Text</th>
                                            <th>Button Text</th>  
                                            <th>Action</th> 
                                          </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                <td><span class="badge badge-warning">Inactive</span></td>
                                                <td><strong>18-07-2022</strong></td>
                                                <td>Service</td>
                                                <td>New Offer for Netflix</td>
                                                <td>Show More</td> 
                                                <td><a href="#"><i class="fas fa-pencil-alt"></i></a> <a href="#"><i class="fas fa-trash-alt"></i></a></td>
                                              </tr>
                                            <tr>
                                                <td><span class="badge badge-success">Active</span></td>
                                                <td><strong>18-07-2022</strong></td>
                                                <td>Service</td>
                                                <td>New Offer for Netflix</td>
                                                <td>Show More</td> 
                                                <td><a href="#"><i class="fas fa-pencil-alt"></i></a> <a href="#"><i class="fas fa-trash-alt"></i></a></td>
                                              </tr>
                                             
                                              
                                        </tbody>
                                      </table>

                                </div>
                                
                                <div class="pagination_rounded pr-4">
                                    <ul>
                                        <li>
                                            <a href="#" class="prev"> <i class="fa fa-chevron-left"></i> </a>
                                        </li>
                                        <li><a href="#" class="active">1</a> </li>
                                        <li><a href="#">2</a> </li>
                                        <li class="d-none d-sm-inline-block"><a href="#">3</a> </li>
                                        <li class="d-none d-sm-inline-block"><a href="#">4</a> </li>
                                        <li><a href="#" class="pdots">...</a> </li>
                                        <li><a href="#">5</a> </li>
                                        <li>
                                            <a href="#" class="prev next"> <i class="fa fa-chevron-right"></i></a>
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
</section>

@endsection

@section('scripts')
    @parent

    </script>
@endsection
