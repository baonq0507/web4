<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <a class="font-w600 text-white tracking-wide" href="index.html">
                <span class="smini-visible">
                    Hi<span class="opacity-75">{{ config('app_name') }}</span>
                </span>
                <span class="smini-hidden">
                    Hi<span class="opacity-75">{{ config('app_name') }}</span>
                </span>
            </a>
            <div>
                <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');" href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                @if (auth()->user()->hasPermissionTo('view_dashboard'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('cpanel.dashboard') }}">
                        <i class="nav-main-link-icon fa fa-location-arrow"></i>
                        <span class="nav-main-link-name">{{ __('index.dashboard') }}</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('view_users'))
                <li class="nav-main-heading">{{ __('index.account') }}</li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/user') ? 'active' : '' }}" href="{{ route('cpanel.user') }}">
                        <i class="nav-main-link-icon fas fa-user-alt"></i>
                        <span class="nav-main-link-name">{{ __('index.customer') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/vip*') ? 'active' : '' }}" href="{{ route('cpanel.vip.index') }}">
                        <i class="nav-main-link-icon fas fa-crown"></i>
                        <span class="nav-main-link-name">VIP Management</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->roles->first()->name == 'admin')
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.employee') }}">
                        <i class="nav-main-link-icon fas fa-user-alt"></i>
                        <span class="nav-main-link-name">{{ __('index.employee') }}</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('grant_role'))
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fas fa-boxes"></i>
                        <span class="nav-main-link-name">{{ __('index.permission') }}</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('cpanel.grant-role') }}">
                                <span class="nav-main-link-name fas fa-user-alt"> {{ __('index.grant_role') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-main-heading">{{ __('index.transaction') }}</li>
                @if (auth()->user()->hasPermissionTo('view_orders'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/orders') ? 'active' : '' }}" href="{{ route('cpanel.orders') }}">
                        <i class="nav-main-link-icon fas fa-list"></i>
                        <span class="nav-main-link-name">{{ __('index.order_list') }}</span>
                    </a>
                </li>
                @endif
                <li class="nav-main-heading">{{ __('index.finance') }}</li>
                @if (auth()->user()->hasPermissionTo('view_transactions'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/transactions') ? 'active' : '' }}" href="{{ route('cpanel.transactions') }}">
                        <i class="nav-main-link-icon fas fa-list"></i>
                        <span class="nav-main-link-name">{{ __('index.transaction') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/transfers*') ? 'active' : '' }}" href="{{ route('cpanel.transfers.index') }}">
                        <i class="nav-main-link-icon fas fa-exchange-alt"></i>
                        <span class="nav-main-link-name">Lịch sử chuyển đổi</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('view_banks'))
                <!-- <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('cpanel/banks') ? 'active' : '' }}" href="{{ route('cpanel.banks') }}">
                        <i class="nav-main-link-icon fa fa-university"></i>
                        <span class="nav-main-link-name">{{ __('index.bank') }}</span>
                    </a>
                </li> -->
                @endif
                @if (auth()->user()->hasPermissionTo('view_users'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/kycs') ? 'active' : '' }}" href="{{ route('cpanel.kycs') }}">
                        <i class="nav-main-link-icon fa fa-university"></i>
                        <span class="nav-main-link-name">{{ __('index.kyc') }}</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('view_deposits'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/transactions/deposit') ? 'active' : '' }}" href="{{ route('cpanel.transactions.deposit') }}">
                        <i class="nav-main-link-icon fas fa-credit-card"></i>
                        <span class="nav-main-link-name">{{ __('index.deposit_request') }}</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('view_withdrawals'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/transactions/withdraw') ? 'active' : '' }}" href="{{ route('cpanel.transactions.withdraw') }}">
                        <i class="nav-main-link-icon fas fa-credit-card"></i>
                        <span class="nav-main-link-name">{{ __('index.withdrawal_request') }}</span>
                    </a>
                </li>
                @endif

                <li class="nav-main-heading" style="display: none;">{{ __('index.report') }}</li>
                <li class="nav-main-item" style="display: none;">
                    <a class="nav-main-link " href="">
                        <i class="nav-main-link-icon fa fa-chart-pie"></i>
                        <span class="nav-main-link-name">{{ __('index.general_report') }}</span>
                    </a>
                </li>
                @if (auth()->user()->hasPermissionTo('view_config_system'))
                <li class="nav-main-heading">{{ __('index.system') }}</li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/system-configuration') ? 'active' : '' }}" href="{{ route('cpanel.system-configuration') }}">
                        <i class="nav-main-link-icon fa fa-wrench"></i>
                        <span class="nav-main-link-name">{{ __('index.system_configuration') }}</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('view_config_system'))
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->is('admin/banks') ? 'active' : '' }}" href="{{ route('cpanel.banks') }}">
                        <i class="nav-main-link-icon fa fa-wrench"></i>
                        <span class="nav-main-link-name">{{ __('index.payment_configuration') }}</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasPermissionTo('view_symbols'))
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.symbols') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.adjust_game') }}</span>
                    </a>
                </li>
                @endif
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.time-sessions.index') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.time_session') }}</span>
                    </a>
                </li>
                <li class="nav-main-heading">{{ __('index.project') }}</li>
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.projects.index') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.project') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.investments.index') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.investment') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.posts.index') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.post') }}</span>
                    </a>
                </li>

                <li class="nav-main-heading">{{ __('index.ky_quy') }}</li>
                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.ky-quies.index') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.ky_quy') }}</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link " href="{{ route('cpanel.ky-quy-users.index') }}">
                        <i class="nav-main-link-icon fa fa-database"></i>
                        <span class="nav-main-link-name">{{ __('index.ky_quy_user') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>