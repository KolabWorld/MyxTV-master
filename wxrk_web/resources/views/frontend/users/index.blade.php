@extends('frontend.app')

{{-- Web site Title --}}
@section('title')  :: @parent @stop


@section('content')

@include('frontend.partials.nav', [
    'title' => 'All Users',
    'description' => $users->total().' Records',
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
                        {{--  <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i class="fas fa-filter mr-1/"></i> Filter</a>  --}}
                        {{--  <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i> Export to Excel</a>  --}}
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
                                            <th>User ID</th>
                                            <th>Name</th>
                                            <th>Email ID</th>
                                            <th>Mobile No.</th>
                                            <th>Country</th>
                                            <th>Token Balance</th>
                                            <th>Today's Collection</th> 
                                            <th>Action</th> 
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <span class="badge 
                                                        @if($user->status == 'active')
                                                            badge-success
                                                        @elseif($user->status == 'inactive')
                                                            badge-danger
                                                        @else
                                                            badge-warning
                                                        @endif
                                                        ">
                                                            {{ ucWords($user->status) }}
                                                        </span>
                                                    </td>
                                                    <td><strong>{{ $user->user_name }}</strong></td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                    <td>{{ $user->country ? $user->country->name : ''  }}</td>
                                                    <td>2000</td>
                                                    <td>200</td> 
                                                    <td><a href="/user/{{ $user->id }}/view">
                                                        <i class="fas fa-eye"></i></a> 
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                      </table>

                                </div>
                                
                                {{ $users->links('frontend.layouts.pagination') }}

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
