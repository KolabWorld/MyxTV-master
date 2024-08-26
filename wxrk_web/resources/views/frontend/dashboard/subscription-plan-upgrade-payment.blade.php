@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Subscription Plan Payment',
        'description' => 'Make Payment',
    ])

    <section class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="login-bg">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="/subscription-plan-upgrade-payment"
                                enctype="multipart/form-data">
                                    @csrf
                                    <div class="head-title mb-4" style="text-align: center">
                                        <h2>Subscription Plan Payment</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input type="hidden" name="subscription_plan_log_id" value="{{$subscriptionPlanLog->id}}"/>
                                                <h6>
                                                    <strong>Vendor : </strong> {{$auth->contact_person_name}}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Plan Type : </strong> 
                                                    {{ ucWords($subscriptionPlan->plan_type) }}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Plan Name : </strong> 
                                                    {{$subscriptionPlan->name ? 
                                                        $subscriptionPlan->name : ''}}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Allowed Offers in a Month : </strong> 
                                                    {{ $subscriptionPlan->offers_in_a_month }}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Premium days in a Month : </strong> 
                                                    {{ $subscriptionPlan->premium_days }}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>New Plan Price : $</strong> 
                                                    {{ $subscriptionPlan->price}}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Current Plan Price : $</strong> 
                                                    {{ $planAmount}}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Current Plan Used : </strong> 
                                                    {{ $usedDays }} Days
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Remaining Paid Price : $</strong> 
                                                    {{ $remainingAmount}}
                                                </h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>
                                                    <strong>Amount to be paid : $</strong> 
                                                    {{ $amountToBePaid }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <button type="submit" id="save" class="btn login-btn btn-block btn-primary">
                                                Make Payment
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
