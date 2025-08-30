@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.bank_list') }}</h1>
                <button type="button" class="btn btn-alt-success my-2" id="btn-add-symbol" data-toggle="modal" data-target="#modal-add-bank">
                    <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_bank') }}
                </button>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 8%;">#</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.bank_name') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.bank_number') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.bank_owner') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.type') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banks as $bank)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="font-w600">{{ $bank->bank_name }}</td>
                            <td class="font-w600">{{ $bank->bank_number }}</td>
                            <td class="font-w600">{{ $bank->bank_owner }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $bank->type == 'bank' ? 'success' : 'danger' }}">{{ $bank->type == 'bank' ? __('index.bank') : __('index.usdt') }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $bank->status == 'show' ? 'success' : 'danger' }}">{{ App\Helper::getBankStatus($bank->status) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" data-id="{{ $bank->id }}" data-name="{{ $bank->bank_name }}" class="btn btn-sm btn-primary btn-edit" title="{{ __('index.edit') }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" data-id="{{ $bank->id }}" data-name="{{ $bank->bank_name }}" class="btn btn-sm btn-primary btn-delete" title="{{ __('index.delete') }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal thêm mới -->
    <div class="modal fade" id="modal-add-bank" tabindex="-1" role="dialog" aria-labelledby="modal-add-bank" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-bank-title">{{ __('index.add_bank') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.banks.store') }}" method="post" id="form-add-bank">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_name">{{ __('index.bank_name') }}</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_number">{{ __('index.bank_number') }}</label>
                            <input type="text" class="form-control" id="bank_number" name="bank_number" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_owner">{{ __('index.bank_owner') }}</label>
                            <input type="text" class="form-control" id="bank_owner" name="bank_owner" required>
                        </div>
                        <div class="form-group">
                            <label for="type">{{ __('index.type') }}</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="bank">{{ __('index.bank') }}</option>
                                <option value="usdt">{{ __('index.usdt') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="show">{{ __('index.show') }}</option>
                                <option value="hide">{{ __('index.hide') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.add') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- modal edit -->
    <div class="modal fade" id="modal-edit-bank" tabindex="-1" role="dialog" aria-labelledby="modal-edit-bank" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-bank-title">{{ __('index.edit_bank') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.banks.update', ['bank' => ':bank']) }}" method="post" id="form-edit-bank">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_name">{{ __('index.bank_name') }}</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_number">{{ __('index.bank_number') }}</label>
                            <input type="text" class="form-control" id="bank_number" name="bank_number" required>
                        </div>
                        <div class="form-group">
                            <label for="bank_owner">{{ __('index.bank_owner') }}</label>
                            <input type="text" class="form-control" id="bank_owner" name="bank_owner" required>
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="show">{{ __('index.show') }}</option>
                                <option value="hide">{{ __('index.hide') }}</option>
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

</main>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
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

        $('#form-add-bank').submit(function(e) {
            e.preventDefault();
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
                    reloadPage("{{ route('cpanel.banks') }}", '#dataTable', '#dataTable');
                    $('#modal-add-bank').modal('hide');
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

        $('#dataTable').on('click', '.btn-delete', function() {
            const url = "{{ route('cpanel.banks.destroy', ['bank' => ':bank']) }}".replace(':bank', $(this).data('id'));
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
                            reloadPage("{{ route('cpanel.banks') }}", '#dataTable', '#dataTable');
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

        $('#dataTable').on('click', '.btn-edit', function() {
            let bank = $(this).data('id');
            $('.loading').show();

            $.ajax({
                url: "{{ route('cpanel.banks.show', ['bank' => ':bank']) }}".replace(':bank', bank),
                type: 'get',
                success: function(response) {
                    $('#modal-edit-bank').modal('show');
                    $('#modal-edit-bank').find('input[name="bank_name"]').val(response.bank_name);
                    $('#modal-edit-bank').find('input[name="bank_number"]').val(response.bank_number);
                    $('#modal-edit-bank').find('input[name="bank_owner"]').val(response.bank_owner);
                    $('#modal-edit-bank').find('select[name="status"]').val(response.status);
                    $('#form-edit-bank').attr('action', "{{ route('cpanel.banks.update', ['bank' => ':bank']) }}".replace(':bank', bank));
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

        $('#form-edit-bank').submit(function(e) {
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
                    reloadPage("{{ route('cpanel.banks') }}", '#dataTable', '#dataTable');
                    $('#modal-edit-bank').modal('hide');
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