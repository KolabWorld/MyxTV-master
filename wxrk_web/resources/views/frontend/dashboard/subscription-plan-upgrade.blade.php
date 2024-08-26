@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Subscription Plan Upgrade',
        'description' => 'Upgrade your plan',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table dashtable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Plan Name</th>
                                            <th>Plan Type</th>
                                            <th>Offers In A Month</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptionPlans as $plan)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="badge 
                                                            @if ($plan->status == 'active') badge-success
                                                            @elseif($plan->status == 'blacklist')
                                                                badge-warning
                                                            @else
                                                                badge-danger @endif
                                                            ">
                                                        {{ ucWords($plan->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $plan->name }}
                                                </td>
                                                <td>
                                                    {{ $plan->plan_type }}
                                                </td>
                                                <td>
                                                    {{ $plan->offers_in_a_month }}
                                                </td>
                                                <td>
                                                    {{ $plan->price }}
                                                </td>
                                                <td>
                                                    <a href="/subscribe-plan/{{ $plan->id }}" class="btn btn-sm btn-secondary">
                                                        Upgrade
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
@endsection
