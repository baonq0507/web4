@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<style>
    .dropdown-menu {
        position: absolute;
        left: 0;
        right: auto;
        min-width: 200px;
        max-width: 300px;
        z-index: 1000;
        transform: translateX(0);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .dropdown {
        position: relative;
    }

    @media (max-width: 768px) {
        .dropdown-menu {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 300px;
        }
    }
</style>
@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.user_list') }}</h1>
            </div>
        </div>
    </div>
    <div class="content" style="width: 100%;">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;">#</th>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.name') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.phone') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.total_deposit') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.total_withdraw') }}</th>
                            <!-- <th class="text-center" style="width: 10%;">{{ __('index.role') }}</th> -->
                            <th class="text-center" style="width: 10%;">{{ __('index.balance') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.created_at') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $user->id }}
                            </td>
                            <td class="font-w600">
                                <a href="{{ route('cpanel.user.show', ['user' => $user->id]) }}" title="{{ __('index.show') }}">
                                    {{ $user->email ?? $user->phone }}
                                </a>
                            </td>
                            <td class="font-w600">{{ $user->phone }}</td>
                            <td class="font-w600">{{ number_format($user->total_deposit, 2, '.', ',') }}</td>
                            <td class="font-w600">{{ number_format($user->total_withdraw, 2, '.', ',') }}</td>
                            <!-- <td class="font-w600">
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-primary">{{ App\Helper::getRoleName($role->name) }}</span>
                                @endforeach
                            </td> -->
                            <td class="font-w600">{{ number_format($user->balance, 2, '.', ',') }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'secondary' : 'danger') }}">{{ $user->status == 'active' ? __('index.active') : ($user->status == 'inactive' ? __('index.inactive') : __('index.band')) }}</span>
                            </td>
                            <td class="text-center">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-around">
                                    <button title="{{ __('index.update_balance') }}" class="btn btn-sm btn-primary btn-update-balance" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-balance="{{ $user->balance }}">
                                        <i class="fa fa-money-bill"></i>
                                    </button>
                                    <button title="{{ __('index.update_ratio') }}" class="btn btn-sm {{ $user->ratio == 50 ? 'btn-warning' : ($user->ratio == 0 ? 'btn-danger' : 'btn-success') }} btn-update-ratio" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-ratio="{{ $user->ratio }}">
                                        <i class="fa fa-percentage"></i>
                                    </button>
                                    <div class="dropdown dropleft">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('cpanel.user.show', ['user' => $user->id]) }}" title="{{ __('index.show') }}">
                                                <i class="fa fa-eye text-primary"></i> {{ __('index.show') }}
                                            </a>
                                            <button class="dropdown-item btn-change-password" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.change_password') }}">
                                                <i class="fa fa-key text-primary"></i> {{ __('index.change_password') }}
                                            </button>
                                            <!-- //change password withdraw -->
                                            <button class="dropdown-item btn-change-password-withdraw" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.change_password_withdraw') }}">
                                                <i class="fa fa-key text-primary"></i> {{ __('index.change_password_withdraw') }}
                                            </button>
                                            @if ($user->block_trade == false)
                                            <button class="dropdown-item btn-block-trade" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.block_trade') }}">
                                                <i class="fa fa-lock text-danger"></i> {{ __('index.block_trade') }}
                                            </button>
                                            @else
                                            <button class="dropdown-item btn-unblock-trade" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.unblock_trade') }}">
                                                <i class="fa fa-unlock text-success"></i> {{ __('index.unblock_trade') }}
                                            </button>
                                            @endif
                                            @if ($user->block_withdraw == false)
                                            <button class="dropdown-item btn-block-withdraw" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.block_withdraw') }}">
                                                <i class="fa fa-lock text-danger"></i> {{ __('index.block_withdraw') }}
                                            </button>
                                            @else
                                            <button class="dropdown-item btn-unblock-withdraw" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.unblock_withdraw') }}">
                                                <i class="fa fa-unlock text-success"></i> {{ __('index.unblock_withdraw') }}
                                            </button>
                                            @endif
                                            <button class="dropdown-item btn-logout" data-id="{{ $user->id }}" title="{{ __('index.logout_user') }}">
                                                <i class="fa fa-sign-out-alt text-danger"></i> {{ __('index.logout_user') }}
                                            </button>
                                            <button class="dropdown-item btn-delete" type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}" title="{{ __('index.delete_account') }}">
                                                <i class="fa fa-times text-danger"></i> {{ __('index.delete_account') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Update Balance -->
    <div class="modal fade" id="modal-update-balance" tabindex="-1" role="dialog" aria-labelledby="modal-update-balance" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-update-balance-title">{{ __('index.update_balance') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-update-balance" action="{{ route('cpanel.user.update-balance', ['user' => ':user']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="balance">{{ __('index.balance') }}</label>
                            <input type="number" step="0.01" class="form-control" id="balance" name="balance" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update Ratio -->
    <div class="modal fade" id="modal-update-ratio" tabindex="-1" role="dialog" aria-labelledby="modal-update-ratio" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-update-ratio-title">{{ __('index.update_ratio') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-update-ratio" action="{{ route('cpanel.user.update-ratio', ['user' => ':user']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ratio">{{ __('index.ratio') }}</label>
                            <select class="form-control" id="ratio" name="ratio">
                                <option value="50">{{ __('index.medium') }}</option>
                                <option value="0">{{ __('index.lose') }}</option>
                                <option value="100">{{ __('index.win') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal change password -->
    <div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-labelledby="modal-change-password" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-change-password-title">{{ __('index.change_password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-change-password" action="{{ route('cpanel.user.change-password', ['user' => ':user']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">{{ __('index.password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('index.password_confirmation') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.change_password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal change password withdraw -->
    <div class="modal fade" id="modal-change-password-withdraw" tabindex="-1" role="dialog" aria-labelledby="modal-change-password-withdraw" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-change-password-withdraw-title">{{ __('index.change_password_withdraw') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-change-password-withdraw" action="{{ route('cpanel.user.password.update-withdraw', ['user' => ':user']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password_withdraw">{{ __('index.password_withdraw') }}</label>
                            <input type="password" class="form-control" id="password_withdraw" name="password_withdraw" required>
                        </div>
                        <div class="form-group">
                            <label for="password_withdraw_confirmation">{{ __('index.password_withdraw_confirmation') }}</label>
                            <input type="password" class="form-control" id="password_withdraw_confirmation" name="password_withdraw_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-change-password-withdraw">{{ __('index.change_password_withdraw') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            "language": {
                "search": "{{ __('index.search') }}",
                "lengthMenu": "{{ __('index.show') }} _MENU_ {{ __('index.entries') }}",
                "zeroRecords": "{{ __('index.no_data') }}",
                "info": "{{ __('index.showing') }} _START_ {{ __('index.to') }} _END_ {{ __('index.of') }} _TOTAL_ {{ __('index.entries') }}",
                "infoEmpty": "{{ __('index.showing') }} 0 {{ __('index.to') }} 0 {{ __('index.of') }} 0 {{ __('index.entries') }}",
                "infoFiltered": "({{ __('index.filtered_from') }} _MAX_ {{ __('index.total_entries') }})",
                "paginate": {
                    "first": "{{ __('index.first') }}",
                    "last": "{{ __('index.last') }}",
                    "next": "{{ __('index.next') }}",
                    "previous": "{{ __('index.previous') }}"
                }
            }
        });
        let idChoose = null;

        $('#dataTable').on('click', '.btn-delete', function() {
            const url = "{{ route('cpanel.user.destroy', ['user' => ':user']) }}".replace(':user', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.delete') }}",
                text: "{{ __('index.delete_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: url,
                        method: 'post',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "{{ __('index.error') }}",
                                text: response.responseJSON.message || "{{ __('index.error') }}",
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-change-password-withdraw', function() {
            idChoose = $(this).data('id');
            $('#modal-change-password-withdraw-title').text("{{ __('index.change_password_withdraw') }} " + $(this).data('name'));
            $('#form-change-password-withdraw').attr('action', "{{ route('cpanel.user.password.update-withdraw', ['user' => ':user']) }}".replace(':user', idChoose));
            $('#modal-change-password-withdraw').modal('show');
        });

        $('#dataTable').on('click', '.btn-change-password', function() {
            idChoose = $(this).data('id');
            $('#modal-change-password-title').text("{{ __('index.change_password') }} " + $(this).data('name'));
            $('#form-change-password').attr('action', "{{ route('cpanel.user.change-password', ['user' => ':user']) }}".replace(':user', idChoose));
            $('#modal-change-password').modal('show');
        });

        $('#form-change-password-withdraw').submit(function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    $('#form-change-password-withdraw')[0].reset();
                    $('#modal-change-password-withdraw').modal('hide');
                    reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message || "{{ __('index.error') }}",
                        icon: 'error'
                    });
                    $('#form-change-password-withdraw')[0].reset();
                    $('#modal-change-password-withdraw').modal('hide');
                },
                complete: function() {
                    $('.loading').hide();
                }
            });
        });

        $('#form-change-password').submit(function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    $('#form-change-password')[0].reset();
                    $('#modal-change-password').modal('hide');
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message || "{{ __('index.error') }}",
                        icon: 'error'
                    });
                },
                complete: function() {
                    $('.loading').hide();
                }
            });
        });

        $('#dataTable').on('click', '.btn-logout', function() {
            const url = "{{ route('cpanel.user.logout', ['user' => ':user']) }}".replace(':user', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.logout') }}",
                text: "{{ __('index.logout_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: $(this).data('id')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "{{ __('index.error') }}",
                                text: response.responseJSON.message || "{{ __('index.error') }}",
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-block-trade', function() {
            const url = "{{ route('cpanel.user.block-trade', ['user' => ':user']) }}".replace(':user', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.block_trade') }}",
                text: "{{ __('index.block_trade_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: $(this).data('id')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "{{ __('index.error') }}",
                                text: response.responseJSON.message || "{{ __('index.error') }}",
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-block-withdraw', function() {
            const url = "{{ route('cpanel.user.block-withdraw', ['user' => ':user']) }}".replace(':user', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.block_withdraw') }}",
                text: "{{ __('index.block_withdraw_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: $(this).data('id')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "{{ __('index.error') }}",
                                text: response.responseJSON.message || "{{ __('index.error') }}",
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-unblock-trade', function() {
            const url = "{{ route('cpanel.user.unblock-trade', ['user' => ':user']) }}".replace(':user', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.unblock_trade') }}",
                text: "{{ __('index.unblock_trade_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: $(this).data('id')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "{{ __('index.error') }}",
                                text: response.responseJSON.message || "{{ __('index.error') }}",
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-unblock-withdraw', function() {
            const url = "{{ route('cpanel.user.unblock-withdraw', ['user' => ':user']) }}".replace(':user', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.unblock_withdraw') }}",
                text: "{{ __('index.unblock_withdraw_confirm') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: $(this).data('id')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "{{ __('index.error') }}",
                                text: response.responseJSON.message || "{{ __('index.error') }}",
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-update-balance', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const currentBalance = $(this).data('balance');

            $('#modal-update-balance-title').text("{{ __('index.update_balance') }} " + userName);
            $('#form-update-balance').attr('action', "{{ route('cpanel.user.update-balance', ['user' => ':user']) }}".replace(':user', userId));
            $('#balance').val(currentBalance);
            $('#modal-update-balance').modal('show');
        });

        $('#form-update-balance').submit(function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    $('#modal-update-balance').modal('hide');
                    reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message || "{{ __('index.error') }}",
                        icon: 'error'
                    });
                },
                complete: function() {
                    $('.loading').hide();
                }
            });
        });

        $('#dataTable').on('click', '.btn-update-ratio', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const currentRatio = $(this).data('ratio');

            $('#modal-update-ratio-title').text("{{ __('index.update_ratio') }} " + userName);
            $('#form-update-ratio').attr('action', "{{ route('cpanel.user.update-ratio', ['user' => ':user']) }}".replace(':user', userId));
            $('#ratio').val(currentRatio);
            $('#modal-update-ratio').modal('show');
        });

        $('#form-update-ratio').submit(function(e) {
            e.preventDefault();
            $('.loading').show();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    $('#modal-update-ratio').modal('hide');
                    reloadPage("{{ route('cpanel.user') }}", '#dataTable', '#dataTable');
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message || "{{ __('index.error') }}",
                        icon: 'error'
                    });
                },
                complete: function() {
                    $('.loading').hide();
                }
            });
        });
    });
</script>
@endpush