@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'Day Wise Summary',
        'description' => $dayWiseSummary->total() . ' Records',
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
                            {{@$userWallet->user->name [@$userWallet->wxrk_balance]}}
                        </div>
                    </div>
                    <div class="dashbed-border-bottom mt-2 mb-3"></div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table dashtable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center"></th>
                                                    <th style="text-align: center">Date</th>
                                                    <th style="text-align: center">Watch  Time</th>
                                                    <th style="text-align: center">WXRK Earned</th>
                                                    <th style="text-align: center">WXRK Spent</th>
                                                    <th style="text-align: center">WXRK Balance</th>
                                                    <th style="text-align: center">WXRK/Mintute</th>
                                                    <th style="text-align: center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dayWiseSummary as $val)
                                                    <tr>
                                                        <td style="text-align: center">
                                                            <span class="badge 
                                                            @if($val->status == 'active')
                                                                badge-success
                                                            @elseif($val->status == 'inactive')
                                                                badge-danger
                                                            @else
                                                                badge-warning
                                                            @endif
                                                            ">
                                                                {{ ucWords($val->status) }}
                                                            </span>
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ date('d M-Y', strtotime($val->created_at)) }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $val->watch_time }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $val->wxrk_earned }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $val->wxrk_spent }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $val->wxrk_balance }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $val->wxrk_per_minute }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            <a class="btn btn-warning" href="/user-wallet/{{ $val->id }}/transactions/day-wise" style="color:#fff;">
                                                                Transactions
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $dayWiseSummary->links('frontend.layouts.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    @parent
                   </form>
            </div>
        </div>
    </div> 
@endsection

@section('scripts')
    @parent

@endsection
