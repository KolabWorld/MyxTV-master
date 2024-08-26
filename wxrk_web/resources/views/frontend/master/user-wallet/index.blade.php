@extends('frontend.app')

{{-- Web site Title --}}
@section('title') :: @parent @stop

@section('content')

    @include('frontend.partials.nav', [
        'title' => 'User Wallets',
        'description' => $userWallets->total() . ' Records',
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-4 d-none d-sm-block">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">Go Back</a>
                        </div>
                        <div class="col-12 col-md-7 text-sm-right">
                            <h4>
                                <b>
                                    Total Balance : 
                                    <span class="badge badge-success">
                                        {{$totalBalance}}
                                    </span>
                                </b>
                            </h4>
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
                                                    <th style="text-align: center">User Name</th>
                                                    <th style="text-align: center">Watch  Time</th>
                                                    <th style="text-align: center">WXRK Earned</th>
                                                    <th style="text-align: center">WXRK Spent</th>
                                                    <th style="text-align: center">WXRK Balance</th>
                                                    <th style="text-align: center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($userWallets as $wallet)
                                                    <tr>
                                                        <td style="text-align: center">
                                                            <span class="badge 
                                                            @if(!$wallet->status || ($wallet->status == 'active'))
                                                                badge-success
                                                            @elseif($wallet->status == 'inactive')
                                                                badge-danger
                                                            @else
                                                                badge-warning
                                                            @endif
                                                            ">
                                                                {{ ucWords($wallet->status) }}
                                                            </span>
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ @$wallet->user->name }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $wallet->watch_time }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $wallet->wxrk_earned }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $wallet->wxrk_spent }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $wallet->wxrk_balance }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            <a class="btn btn-success" href="/user-wallet/{{ $wallet->id }}/day-wise-summary" style="color:#fff;">
                                                                View
                                                            </a>
                                                            <a class="btn btn-warning" href="/user-wallet/{{ $wallet->id }}/transactions/whole" style="color:#fff;">
                                                                Transactions
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $userWallets->links('frontend.layouts.pagination') }}
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
