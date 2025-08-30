@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>

</style>
@endpush
@section('content')
<main id="main-container" class="deposit-page">
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
    <div class="content" style="width: 100%;" id="content">
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
                            <th class="text-center" style="width: 10%;">{{ __('index.before_balance') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.after_balance') }}</th>
                            <!-- <th class="text-center" style="width: 15%;">{{ __('index.note') }}</th> -->
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
                            <td class="text-center">{{ $transaction->amount }}</td>
                            <td class="text-center">{{ $transaction->before_balance }}</td>
                            <td class="text-center">{{ $transaction->after_balance }}</td>
                            <!-- <td class="text-center">{{ $transaction->note }}</td> -->
                            <td class="text-center">{{ $transaction->created_at }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'failed' ? 'danger' : ($transaction->status == 'canceled' ? 'warning' : 'secondary')) }}">{{ App\Helper::getTransactionStatus($transaction->status) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    @if($transaction->status == 'pending')
                                    <button type="button" data-id="{{ $transaction->id }}" data-name="{{ $transaction->user->name }}" class="btn btn-sm btn-success btn-success" title="{{ __('index.success') }}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button type="button" data-id="{{ $transaction->id }}" data-name="{{ $transaction->user->name }}" class="btn btn-sm btn-danger btn-reject" title="{{ __('index.reject') }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    @endif
                                    <button type="button" data-id="{{ $transaction->id }}" data-name="{{ $transaction->user->name }}" class="btn btn-sm btn-primary btn-edit" title="{{ __('index.edit') }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" data-id="{{ $transaction->id }}" data-name="{{ $transaction->user->name }}" class="btn btn-sm btn-danger btn-delete" title="{{ __('index.delete') }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <button type="button" data-id="{{ $transaction->id }}" data-image="{{ $transaction->bill_image }}" class="btn btn-sm btn-primary btn-view-bill" title="{{ __('index.view_bill') }}">
                                        <i class="fa fa-eye"></i>
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

    <!-- modal thêm mới -->
    <!-- <div class="modal fade" id="modal-add-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-add-transaction" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-transaction-title">{{ __('index.add_transaction') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.transactions.store') }}" method="post" id="form-add-transaction" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_id">{{ __('index.user') }}</label>
                            <select class="form-control select2" id="user_id" name="user_id" required>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">{{ __('index.type_transaction') }}</label>
                            <select class="form-control select2" id="type" name="type" required>
                                <option value="deposit">{{ __('index.deposit') }}</option>
                                <option value="withdraw">{{ __('index.withdraw') }}</option>
                                <option value="transfer">{{ __('index.transfer') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">{{ __('index.amount') }}</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_id">{{ __('index.bank') }}</label>
                            <select class="form-control" id="bank_id" name="bank_id" required>
                                @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bank_name . ' - ' . $bank->bank_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">{{ __('index.note') }}</label>
                            <textarea class="form-control" id="note" name="note" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">{{ __('index.pending') }}</option>
                                <option value="success">{{ __('index.success') }}</option>
                                <option value="failed">{{ __('index.failed') }}</option>
                                <option value="canceled">{{ __('index.canceled') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.add') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div> -->
    <!-- modal edit -->
    <div class="modal fade" id="modal-edit-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-edit-transaction" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-transaction-title">{{ __('index.edit_transaction') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.transactions.update', ['transaction' => ':transaction']) }}" method="post" id="form-edit-transaction" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_id">{{ __('index.user') }}</label>
                            <select class="form-control select2" name="user_id" required>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">{{ __('index.type_transaction') }}</label>
                            <select class="form-control select2" id="type" name="type" required>
                                <option value="deposit">{{ __('index.deposit') }}</option>
                                <option value="withdraw">{{ __('index.withdraw') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">{{ __('index.amount') }}</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="note">{{ __('index.note') }}</label>
                            <textarea class="form-control" id="note" name="note" ></textarea>
                        </div> -->
                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control select2" id="status" name="status" required>
                                <option value="pending">{{ __('index.pending') }}</option>
                                <option value="success">{{ __('index.success') }}</option>
                                <option value="failed">{{ __('index.failed') }}</option>
                                <option value="canceled">{{ __('index.canceled') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.edit') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- modal view bill -->
    <div class="modal fade" id="modal-view-bill" tabindex="-1" role="dialog" aria-labelledby="modal-view-bill" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-view-bill-title">{{ __('index.view_bill') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="bill-image" alt="" class="img-fluid">
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
        // $('#dataTable').DataTable({
        //     "language": {
        //         "search": "{{ __('index.search') }}",
        //         "lengthMenu": "{{ __('index.show') }} _MENU_ {{ __('index.entries') }}",
        //         "zeroRecords": "{{ __('index.no_data') }}",
        //         "info": "{{ __('index.showing') }} _START_ {{ __('index.to') }} _END_ {{ __('index.of') }} _TOTAL_ {{ __('index.entries') }}",
        //         "infoEmpty": "{{ __('index.showing') }} 0 {{ __('index.to') }} 0 {{ __('index.of') }} 0 {{ __('index.entries') }}",
        //         "infoFiltered": "({{ __('index.filtered_from') }} _MAX_ {{ __('index.total_entries') }})",
        //         "paginate": {
        //             "first": "{{ __('index.first') }}",
        //             "last": "{{ __('index.last') }}",
        //             "next": "{{ __('index.next') }}",
        //             "previous": "{{ __('index.previous') }}"
        //         }
        //     }
        // });

        // $('#form-add-transaction').submit(function(e) {
        //     e.preventDefault();
        //     var formData = $(this).serialize();
        //     console.log(formData);
            
        //     $('.loading').show();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         success: function(response) {
        //             Swal.fire({
        //                 title: "{{ __('index.success') }}",
        //                 text: response.message,
        //                 icon: 'success'
        //             });
        //             reloadPage("{{ route('cpanel.transactions') }}", '#dataTable', '#dataTable');
        //             $('#modal-add-transaction').modal('hide');
        //         },
        //         error: function(response) {
        //             Swal.fire({
        //                 title: "{{ __('index.error') }}",
        //                 text: response.responseJSON.message || "{{ __('index.error') }}",
        //                 icon: 'error'
        //             });
        //         },
        //         complete: function() {
        //             $('.loading').hide();
        //         }
        //     });
        // });

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

        $(document).on('click', '.btn-edit', function() {
            let transaction = $(this).data('id');
            $('.loading').show();

            $.ajax({
                url: "{{ route('cpanel.transactions.show', ['transaction' => ':transaction']) }}".replace(':transaction', transaction),
                type: 'get',
                success: function(response) {
                    $('#modal-edit-transaction').modal('show');
                    $('#modal-edit-transaction').find('select[name="user_id"]').val(response.user_id);
                    $('#modal-edit-transaction').find('select[name="type"]').val(response.type);
                    $('#modal-edit-transaction').find('input[name="amount"]').val(response.amount);
                    // $('#modal-edit-transaction').find('textarea[name="note"]').val(response.note);
                    $('#modal-edit-transaction').find('select[name="status"]').val(response.status);
                    $('#form-edit-transaction').attr('action', "{{ route('cpanel.transactions.update', ['transaction' => ':transaction']) }}".replace(':transaction', transaction));
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
                    reloadPage("{{ route('cpanel.transactions') }}", '#dataTable', '#dataTable');
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

        $(document).on('click', '.btn-reject', function() {
            const url = "{{ route('cpanel.transactions.update', ['transaction' => ':transaction']) }}".replace(':transaction', $(this).data('id'));
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
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'PUT',
                            status: 'failed'
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
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-success', function() {
            const url = "{{ route('cpanel.transactions.update', ['transaction' => ':transaction']) }}".replace(':transaction', $(this).data('id'));
            Swal.fire({
                title: "{{ __('index.success') }}",
                text: "{{ __('index.success_confirm') }}",
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
                            _method: 'PUT',
                            status: 'success'
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
                            });
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-view-bill', function() {
            $('#modal-view-bill').modal('show');
            $('#modal-view-bill').find('img').attr('src', $(this).data('image'));
        });
    });
</script>
@endpush
