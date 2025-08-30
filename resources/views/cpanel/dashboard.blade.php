@extends('cpanel.layouts.app')

@section('content')

<main id="main-container">
    <div class="content content-full">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="h3 font-w400 mb-0">{{ __('index.dashboard_report') }}</h2>
            <div class="dropdown">
                <button type="button" class="btn btn-sm btn-light px-3" id="dropdown-analytics-overview" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-angle-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right font-size-sm" aria-labelledby="dropdown-analytics-overview">
                    <a class="dropdown-item" href="{{ route('cpanel.dashboard', ['range' => 'today']) }}">{{ __('index.today') }}</a>
                    <a class="dropdown-item" href="{{ route('cpanel.dashboard', ['range' => 'last30day']) }}">{{ __('index.last_30_days') }}</a>
                    <a class="dropdown-item" href="{{ route('cpanel.dashboard', ['range' => 'thisweek']) }}">{{ __('index.this_week') }}</a>
                    <a class="dropdown-item" href="{{ route('cpanel.dashboard', ['range' => 'lastweek']) }}">{{ __('index.last_week') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('cpanel.dashboard', ['range' => 'thismonth']) }}">{{ __('index.this_month') }}</a>
                    <a class="dropdown-item" href="{{ route('cpanel.dashboard', ['range' => 'lastmonth']) }}">{{ __('index.last_month') }}</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fa fa-2x fa-user-circle text-primary"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="font-size-h3 font-w300 mb-0">
                                {{ $count_user }} </p>
                            <p class="text-muted mb-0">
                                {{ __('index.customer') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="far fa-2x fa-arrow-up text-success"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="font-size-h3 font-w300 mb-0">
                                {{ $count_trade }} </p>
                            <p class="text-muted mb-0">
                                {{ __('index.transaction') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="mr-3">
                            <p class="font-size-h3 font-w300 mb-0">
                                {{ $count_trade_win }} </p>
                            <p class="text-muted mb-0">
                                {{ __('index.order_win') }}
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-chart-area text-danger"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="mr-3">
                            <p class="font-size-h3 font-w300 mb-0">
                                {{ $count_trade_lose }} </p>
                            <p class="text-muted mb-0">
                                {{ __('index.order_lose') }}
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-box text-warning"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-primary" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fa fa-2x fa-arrow-alt-circle-up text-primary-lighter"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-white font-size-h3 font-w300 mb-0">
                                {{ number_format($count_transaction_deposit, 0, ',', '.') }} </p>
                            <p class="text-white-75 mb-0">
                                {{ __('index.deposit') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-success" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div>
                            <i class="far fa-2x fa-arrow-alt-circle-down text-danger"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-white font-size-h3 font-w300 mb-0">
                                {{ number_format($count_transaction_withdraw, 0, ',', '.') }} </p>
                            <p class="text-white-75 mb-0">
                                {{ __('index.withdrawal') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-link-shadow bg-warning" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="mr-3">
                            <p class="text-white font-size-h3 font-w300 mb-0">
                                {{ number_format($total_transaction, 0, ',', '.') }} </p>
                            <p class="text-white-75 mb-0">
                                {{ __('index.total_revenue') }}
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-2x fa-boxes text-black-50"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="block block-rounded js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('index.top_customer') }}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="fa fa-sync"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 8%;">#</th>
                                <th>{{ __('index.customer') }}</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 20%;">{{ __('index.deposit') }}</th>
                                <th class="text-center d-none d-sm-table-cell" style="width: 20%;">{{ __('index.withdrawal') }}</th>
                                <th class="text-center" style="width: 20%;">{{ __('index.total_revenue') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($top_user_deposit as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-w600">
                                    <a href="{{ route('cpanel.user.show', $user->user->id) }}">
                                        {{ $user->user->name }}
                                    </a>
                                </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    {{ number_format($user->user->total_deposit, 0, ',', '.') }} </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    {{ number_format($user->user->total_withdraw, 0, ',', '.') }} </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    {{ number_format($user->user->total_deposit - $user->user->total_withdraw, 0, ',', '.') }} </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection