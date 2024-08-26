	<div class="col-md-3">
			<!-- Profile Image -->
			<div class="box box-primary">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center">{{$user->name}}</h3>

              <p class="text-muted text-center">{{$user->email}}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Company</b> <a class="pull-right">{{$user->company_name}}</a>
                </li>
                <li class="list-group-item">
                  <b>Contact Number</b> <a class="pull-right">{{$user->mobile}}</a>
                </li>
              </ul>

              <span class="btn btn-primary btn-block"><b>{{$user->status}}</b></span>
            </div>
            <!-- /.box-body -->
          </div>
			<!-- /.box -->

			<!-- About Me Box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">About Me</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<strong>
						<i class="fa fa-map-marker margin-r-5"></i> Location
					</strong>
					<p class="text-muted">{{$user->address->line_1 ?? ''}}, {{$user->address->line_2 ?? ''}}, {{$user->address->city->name ?? ''}}, {{ $user->address->state->name ?? ''}}, {{$user->address->country->name ?? ''}}, {{$user->address->postal_code ?? ''}}</p>
					<hr>
					<strong>
						<i class="fa fa-pencil margin-r-5"></i> Social Links
					</strong>
					@if($user->socialLink)
						<p>
							@if($user->socialLink->name == 'Facebook')
								<span class="label label-info">
									{{$user->socialLink->name}}
								</span>
							@elseif($user->socialLink->name == 'Linkedin')
								<span class="label label-success">
									{{$user->socialLink->name}}
								</span>	
							@elseif($user->socialLink->name == 'Twitter')
								<span class="label label-primary">
									{{$user->socialLink->name}}
								</span>	
							@elseif($user->socialLink->name == 'Google')
								<span class="label label-warning">
									{{$user->socialLink->name}}
								</span>		
							@else
								<span class="label label-danger">
									{{$user->socialLink->name}}
								</span>	
							@endif
						</p>
					@endif	
					<hr>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		