@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>

</style>
@endpush
@section('content')
<main id="main-container" class="withdraw-page">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.transaction_list') }}</h1>
                <!-- <button type="button" class="btn btn-alt-success my-2" id="btn-add-transaction" data-toggle="modal" data-target="#modal-add-transaction">
                    <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_transaction') }}
                </button> -->
            </div>
        </div>
    </div>
    <div class="content" style="width: 100%;">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.user') }}</th>
                            <th class="text-center" style="width: 7%;">{{ __('index.type') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.amount') }}</th>
                            <th class="text-center" style="width: 5%;">{{ __('index.fee_withdraw') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.amount_withdraw') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.payment_type') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.before_balance') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.after_balance') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.created_at') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $transaction->user->id }}</td>
                            <td class="font-w600">
                                <a href="{{ route('cpanel.user.show', $transaction->user->id) }}" class="text-primary">{{ $transaction->user->name }}</a>
                            </td>
                            <td class="font-w600">{{ App\Helper::getTransactionType($transaction->type) }}</td>
                            <td class="text-center">{{ number_format($transaction->amount, 2, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($config_fee_withdraw->value, 2, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($transaction->amount - $config_fee_withdraw->value, 2, ',', '.') }}</td>
                            <td class="text-center">{{ $transaction->payment_type == 'bank' ? __('index.bank') : __('index.usdt') }}</td>
                            <td class="text-center">{{ number_format($transaction->before_balance, 2, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($transaction->after_balance, 2, ',', '.') }}</td>
                            <td class="text-center">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'failed' ? 'danger' : ($transaction->status == 'canceled' ? 'warning' : 'secondary')) }}">{{ App\Helper::getTransactionStatus($transaction->status) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" data-id="{{ $transaction->id }}" data-payment-type="{{ $transaction->payment_type }}" class="btn btn-sm btn-primary btn-view" title="{{ __('index.bill_image') }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @if($transaction->status == 'pending')
                                    <form action="{{ route('cpanel.transactions.update', $transaction->id) }}" method="POST" class="d-inline btn-approve">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="success">
                                        <button type="submit" class="btn btn-sm btn-success" title="{{ __('index.approve') }}">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('cpanel.transactions.update', $transaction->id) }}" method="POST" class="d-inline btn-reject">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="failed">
                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ __('index.reject') }}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <button type="button" data-id="{{ $transaction->id }}" data-name="{{ $transaction->user->name }}" class="btn btn-sm btn-danger btn-delete" title="{{ __('index.delete') }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $transactions->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- modal-view-bill-image -->
    <div class="modal fade" id="modal-view-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-view-transaction" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-view-transaction-title">{{ __('index.transaction_detail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-view-transaction-content">
                        <div class="row">
                            <div class="col-md-6">
                                <p>{{ __('index.payment_type') }}: <span id="modal-view-transaction-payment-type"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ __('index.bank_name') }}: <span id="modal-view-transaction-bank-name"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>{{ __('index.bank_owner') }}: <span id="modal-view-transaction-bank-owner"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ __('index.bank_number') }}: <span id="modal-view-transaction-bank-number"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>{{ __('index.usdt_address') }}: <span id="modal-view-transaction-usdt-address"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ __('index.usdt_network') }}: <span id="modal-view-transaction-usdt-network"></span></p>
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    $(document).ready(function() {

        $(document).on('submit', '#form-add-transaction', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);

            $('.loading').show();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    reloadPage("{{ route('cpanel.transactions') }}", '#dataTable', '#dataTable');
                    $('#modal-add-transaction').modal('hide');
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

        $(document).on('click', '.btn-delete', function() {
            const url = "{{ route('cpanel.transactions.destroy', ['transaction' => ':transaction']) }}".replace(':transaction', $(this).data('id'));
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
                            reloadPage("{{ route('cpanel.transactions') }}", '#dataTable', '#dataTable');
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

        $(document).on('submit', '.btn-approve', function(e) {
            e.preventDefault();
            const url = $(this).attr('action');
            const formData = $(this).serialize();
            Swal.fire({
                title: "{{ __('index.approve') }}",
                text: "{{ __('index.approve_confirm') }}",
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
                        data: formData,
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.transactions.withdraw') }}", '#dataTable', '#dataTable');
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

        $(document).on('submit', '.btn-reject', function(e) {
            e.preventDefault();
            const url = $(this).attr('action');
            const formData = $(this).serialize();
            Swal.fire({
                title: "{{ __('index.reject') }}",
                text: "{{ __('index.reject_confirm') }}",
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
                        data: formData,
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('index.success') }}",
                                text: response.message,
                                icon: 'success'
                            });
                            reloadPage("{{ route('cpanel.transactions.withdraw') }}", '#dataTable', '#dataTable');
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

        $('#form-edit-transaction').submit(function(e) {
            e.preventDefault();
            $('.loading').show();
            var formData = new FormData(this);
            $('.loading').show();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false, // Bắt buộc phải có khi sử dụng FormData
                contentType: false, // Bắt buộc phải có khi sử dụng FormData
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    reloadPage("{{ route('cpanel.transactions.withdraw') }}", '#dataTable', '#dataTable');
                    $('#modal-edit-transaction').modal('hide');
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

        $(document).on('click', '.btn-view', function() {
            const id = $(this).data('id');
            $('.loading').show();
            $.ajax({
                url: "{{ route('cpanel.transactions.show', ['transaction' => ':transaction']) }}".replace(':transaction', id),
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#modal-view-transaction').modal('show');
                    $('#modal-view-transaction-payment-type').text(response.payment_type == 'bank' ? "{{ __('index.bank') }}" : "{{ __('index.usdt') }}");
                    if(response.payment_type == 'bank'){
                        $('#modal-view-transaction-bank-name').text(response.user.banks[0].bank_name);
                        $('#modal-view-transaction-bank-owner').text(response.user.banks[0].bank_owner);
                        $('#modal-view-transaction-bank-number').text(response.user.banks[0].bank_number);
                    }else{
                        $('#modal-view-transaction-usdt-address').text(response.user.usdt[0].usdt_address);
                        $('#modal-view-transaction-usdt-network').text(response.user.usdt[0].usdt_network);
                    }
                },
                complete: function() {
                    $('.loading').hide();
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message || "{{ __('index.error') }}",
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>
@endpush