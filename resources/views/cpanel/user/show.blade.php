@extends('cpanel.layouts.app')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <main id="main-container">

        <div class="content">

            <div class="block block-rounded">
                <div class="block-content text-center">
                    <div class="py-4">
                        <h1 class="font-size-lg mb-0">
                            {{ $user->name ?? 'Không tên' }}
                        </h1>
                    </div>
                </div>
                <div class="block-content bg-body-light text-center">
                    <div class="row items-push text-uppercase">
                        <div class="col-6 col-md-4">
                            <div class="font-w600 text-dark mb-1">{{ __('index.balance') }}</div>
                            <a class="link-fx font-size-h3" id="user_balance"
                                href="javascript:void(0)">{{ number_format($user->balance ?? 0) }}</a>
                        </div>


                        <div class="col-6 col-md-4">
                            <div class="font-w600 text-dark mb-1">{{ __('index.total_deposit') }}</div>
                            <a class="link-fx font-size-h3" id="user_total_deposite" href="javascript:void(0)">0</a>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="font-w600 text-dark mb-1">{{ __('index.total_withdraw') }}</div>
                            <a class="link-fx font-size-h3" href="javascript:void(0)">0</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('index.customer_info') }}</h3>
                </div>
                <div class="block-content">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="block block-rounded block-bordered">
                                <form action="{{ route('cpanel.user.update', $user->id) }}" id="form-update-user"
                                    method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="block-header border-bottom">
                                        <h3 class="block-title">{{__('index.account_info')}}</h3>
                                        <button type="submit" id="btn-update-data" class="btn btn-sm btn-primary mx-1">
                                            <i class="fa fa-check opacity-50 me-1"></i> {{__('index.save')}}
                                        </button>
                                    </div>
                                    <div class="block-content">
                                        <div class="form-group readonly">
                                            <label for="username">{{ __('index.username') }}</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ $user->username ?? 'Không username' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ __('index.name') }}</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name ?? 'Không họ tên' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="ratio">{{ __('index.ratio') }}</label>
                                            <input type="number" class="form-control" id="ratio" name="ratio" 
                                                value="{{ $user->ratio ?? 0 }}"  min="0" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label for="role">{{ __('index.role') }}</label>
                                            <select class="select2 form-control" id="roles" name="roles[]"
                                                multiple="multiple">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ App\Helper::covertNameRole($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ __('index.status') }}</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>{{ __('index.active') }}</option>
                                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>{{ __('index.inactive') }}</option>
                                                <option value="band" {{ $user->status == 'band' ? 'selected' : '' }}>{{ __('index.band') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="vip_level_id">VIP Level</label>
                                            <select id="vip_level_id" name="vip_level_id" class="form-control">
                                                <option value="">Không có VIP</option>
                                                @foreach($vipLevels as $vipLevel)
                                                    <option value="{{ $vipLevel->id }}" 
                                                        {{ $user->vip_level_id == $vipLevel->id ? 'selected' : '' }}
                                                        style="color: {{ $vipLevel->color }}">
                                                        {{ $vipLevel->name }} (Yêu cầu: ${{ number_format($vipLevel->required_deposit, 0) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">
                                                Tổng nạp hiện tại: <strong class="text-success">${{ number_format($user->total_deposit, 2) }}</strong>
                                                @if($user->vipLevel)
                                                    | VIP hiện tại: <strong style="color: {{ $user->vipLevel->color }}">{{ $user->vipLevel->name }}</strong>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="referral">{{ __('index.referral') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="referral"
                                                    value="{{ $user->referral }}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="copyToClipboard('{{ $user->referral }}')">
                                                        <i class="fa fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="referral_link">{{ __('index.referral_link') }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly="" id="referral_link"
                                                        value="{{ $user->referral_link }}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="copyToClipboard('{{ $user->referral_link }}')">
                                                            <i class="fa fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group readonly">
                                            <label for="phone">{{ __('index.phone') }}</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ $user->phone }}">
                                        </div>
                                        <div class="form-group readonly">
                                            <label for="ip_address">{{ __('index.ip_address') }}</label>
                                            <input type="text" class="form-control" id="ip_address" readonly="">
                                        </div>
                                        <div class="form-group readonly">
                                            <label for="last_login">{{ __('index.last_login') }}</label>
                                            <input type="text" class="form-control" id="last_login" readonly="">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="block block-rounded block-bordered">
                                <div class="block-header border-bottom">
                                    <h3 class="block-title">{{__('index.bank_info')}}</h3>
                                    <!-- <select id="bank_status" name="bank_status" class="form-control" style="width: 200px;">
                                        <option value="0" selected="">Chưa liên kết</option>
                                    </select> -->
                                </div>
                                <div class="block-content">
                                    <div class="form-group readonly">
                                        <label for="balance">{{ __('index.balance') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control" id="balance" readonly
                                                value="{{ number_format($user->balance) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group readonly">
                                        <label for="identity_front">{{ __('index.identity_front') }}</label>
                                        @if ($user->identity_front_link)
                                            <div style="width: 100%;padding: 10px;">
                                                <img id="identity_front" style="width: 100%;max-height: auto;"
                                                    src="{{ $user->identity_front_link }}">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group readonly">
                                        <label for="identity_back">{{ __('index.identity_back') }}</label>
                                        @if ($user->identity_back_link)
                                            <div style="width: 100%;padding: 10px;">
                                                <img id="identity_back" style="width: 100%;max-height: auto;"
                                                    src="{{ $user->identity_back_link }}">
                                            </div>
                                        @endif
                                    </div>
                                    <h3>{{__('index.bank_account')}}</h3>
                                    @if ($user->banks->count() > 0)
                                        <div class="form-group">
                                            <label for="bank_number">{{ __('index.bank_number') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->banks->first()->bank_number }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="bank_name">{{ __('index.bank_name') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->banks->first()->bank_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="bank_owner">{{ __('index.bank_owner') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->banks->first()->bank_owner }}">
                                        </div>
                                    @else
                                        <div class="alert alert-danger">{{__('index.no_bank_account')}}</div>
                                    @endif
                                    <h3>{{__('index.usdt_account')}}</h3>
                                    @if ($user->usdt->count() > 0)
                                        <div class="form-group">
                                            <label for="usdt_number">{{ __('index.usdt_number') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->usdt->first()->bank_number }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="usdt_name">{{ __('index.usdt_name') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->usdt->first()->bank_owner }}">
                                        </div>
                                    @else
                                        <div class="alert alert-danger">{{__('index.no_usdt_account')}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="view_content">
                <div class="block block-rounded" style="display: block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{__('index.transaction_new')}}</h3>
                    </div>
                    <div class="block-content">
                        <div class="table-responsive">
                            <div class="">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table
                                            class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination dataTable">
                                            <thead>
                                                <tr>
                                                    <th>{{__('index.transaction_code')}}</th>
                                                    <th>{{__('index.transaction_type')}}</th>
                                                    <th>{{__('index.transaction_amount')}}</th>
                                                    <th>{{__('index.transaction_time')}}</th>
                                                    <th>{{__('index.transaction_status')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="trans-table">
                                                @foreach ($user->transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->code }}</td>
                                                        <td>{{ $transaction->type == 'deposit' ? __('index.deposit') : __('index.withdraw') }}
                                                        </td>
                                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                                        <td>{{ $transaction->created_at }}</td>
                                                        <td>
                                                            @if ($transaction->status == 'pending')
                                                                <span class="badge badge-warning">{{__('index.pending')}}</span>
                                                            @elseif ($transaction->status == 'success')
                                                                <span class="badge badge-success">{{__('index.success')}}</span>
                                                            @else
                                                                <span class="badge badge-danger">{{__('index.failed')}}</span>
                                                            @endif
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
                <div id="block-deposit-withdraw-content">
                    <div class="block block-rounded" id="block-deposit-withdraw" style="display: block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{__('index.total_deposit_withdraw_referral')}}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row row-deck">
                                <div class="col-lg-6">
                                    <div class="block block-rounded">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">{{__('index.total_deposit')}}</h3>
                                        </div>
                                        <div class="block-content">
                                            <h3 class="block-title">{{ number_format($user->total_deposit_referral) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="block block-rounded">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">{{__('index.total_withdraw')}}</h3>
                                        </div>
                                        <div class="block-content">
                                            <h3 class="block-title">{{ number_format($user->total_withdraw_referral) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block block-rounded" id="block-refusers">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{__('index.referral_users')}}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row row-deck">
                                <table class="table table-bordered table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th>{{__('index.name')}}</th>
                                            <th>{{__('index.balance')}}</th>
                                            <th>{{__('index.total_deposit')}}</th>
                                            <th>{{__('index.total_withdraw')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->referrals as $refuser)
                                            <tr>
                                                <td>{{ $refuser->name }}</td>
                                                <td>{{ number_format($refuser->balance, 2) }}</td>
                                                <td>{{ number_format($refuser->total_deposit, 2) }}</td>
                                                <td>{{ number_format($refuser->total_withdraw, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{__('index.last_order')}}</h3>
                    </div>
                    <div class="block-content">
                        <div class="table-responsive">
                            <div id="" class="dataTables_wrapper">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-borderless table-striped table-vcenter dataTable" id="">
                                            <thead>
                                                <tr role="row">
                                                    <th>{{__('index.session_code')}}</th>
                                                    <th>{{__('index.order_type')}}</th>
                                                    <th>{{__('index.order_type_system')}}</th>
                                                    <th>{{__('index.after_balance')}}</th>
                                                    <th>{{__('index.amount')}}</th>
                                                    <th>{{__('index.profit')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('#form-update-user').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                console.log(formData);
                $('.loading').show();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: "{{ __('index.success') }}",
                            text: response.message,
                            icon: 'success'
                        });
                    },
                    error: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: "{{ __('index.error') }}",
                            text: response.responseJSON.message,
                            icon: 'error'
                        });
                    },
                    complete: function () {
                        console.log('complete');
                        $('.loading').hide();
                    }
                });
            });
        });
    </script>
@endpush