@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')
    @include('frontend.partials.nav', [
        'title' => 'All Transactions',
        'description' => $txns->total().' Records',
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
                            {{-- <a href="/marketplace/create" class="btn btn-secondary btn-filter mr-2"><i
                                    class="far fa-plus-square mr-1"></i> Add New</a> --}}
                            {{--  <a href="#filter" data-toggle="modal" class="btn btn-primary btn-filter mr-2"><i
                                    class="fas fa-filter mr-1"></i> Filter</a>
                            <a href="#" class="btn btn-success btn-filter"><i class="far fa-file-excel mr-1"></i>
                                Export to Excel</a>  --}}
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
                                                    <th>Created Date</th>
                                                    <th>Amount</th>
                                                    <th>Channel Order ID</th>
                                                    <th>Vendor Name</th>
                                                    <th>Plan Name</th>
                                                    <th>Plan Expires At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($txns as $txn)
                                                    <tr>
                                                        <td>
                                                            <span class="badge 
                                                            @if($txn->status == 'paid')
                                                                badge-success
                                                            @elseif($txn->status == 'created')
                                                                badge-warning
                                                            @else
                                                                badge-danger
                                                            @endif
                                                            ">
                                                                {{ ucWords($txn->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ date('d M-Y', strtotime($txn->created_at)) }}
                                                        </td>
                                                        <td>
                                                            {{ $txn->amount }}
                                                        </td>
                                                        <td>
                                                            {{ $txn->channel_order_id }}
                                                        </td>
                                                        <td>
                                                            {{ @$txn->admin->contact_person_name }}
                                                        </td>
                                                        <td>
                                                            {{ @$txn->subscriptionPlanLog->subscriptionPlan ? @$txn->subscriptionPlanLog->subscriptionPlan->name : '' }}
                                                        </td>
                                                        <td>
                                                            {{ @$txn->subscriptionPlanLog->plan_expires_at }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $txns->links('frontend.layouts.pagination') }}
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
