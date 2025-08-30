@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.system_configuration') }}</h1>
            </div>
        </div>
    </div>
    <div class="content">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <form action="{{ route('cpanel.system-configuration.save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach ($config as $index => $item)

                            @switch($item->key)
                            @case('app_name')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_name') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('app_logo')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_logo') }}</label>
                                <input type="file" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                <img src="{{ $item->app_logo }}" alt="{{ __('index.app_logo') }}" style="width: 100px; height: 100px;">
                            </div>
                            @break
                            @case('app_logo2')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_logo2') }}</label>
                                <input type="file" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                <img src="{{ $item->app_logo2 }}" alt="{{ __('index.app_logo2') }}" style="width: 100px; height: 100px;">
                            </div>
                            @break
                            @case('app_description')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_description') }}</label>
                                <textarea class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">{{ $item->value }}</textarea>
                            </div>
                            @break
                            @case('app_thumbnail')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_thumbnail') }}</label>
                            <input type="file" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                <img src="{{ $item->app_thumbnail }}" alt="{{ __('index.app_thumbnail') }}" style="width: 100px; height: 100px;">
                            </div>
                            @break
                            @case('app_favicon')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_favicon') }}</label>
                                <input type="file" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                <img src="{{ $item->app_favicon }}" alt="{{ __('index.app_favicon') }}" style="width: 100px; height: 100px;">
                            </div>
                            @break
                            @case('app_keywords')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_keywords') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('min_deposit')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.min_deposit') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('min_withdraw')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.min_withdraw') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('telegram_bot_token_trade')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.telegram_bot_token_trade') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('telegram_bot_chatid_trade')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.telegram_bot_chatid_trade') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('telegram_bot_token_account')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.telegram_bot_token_account') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('telegram_bot_chatid_account')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.telegram_bot_chatid_account') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('system_email')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.system_email') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('on_security_deposit')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.on_security_deposit') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="on" {{ $item->value == 'on' ? 'selected' : '' }}>{{ __('index.on') }}</option>
                                    <option value="off" {{ $item->value == 'off' ? 'selected' : '' }}>{{ __('index.off') }}</option>
                                </select>
                            </div>
                            @break
                            @case('convert_usdt')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.convert_usdt') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('on_required_ref')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.on_required_ref') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="on" {{ $item->value == 'on' ? 'selected' : '' }}>{{ __('index.on') }}</option>
                                    <option value="off" {{ $item->value == 'off' ? 'selected' : '' }}>{{ __('index.off') }}</option>
                                </select>
                            </div>
                            @break
                            @case('fee_withdraw')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.fee_withdraw') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('bonus_f1')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.bonus_f1') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('bonus_f2')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.bonus_f2') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('bonus_f3')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.bonus_f3') }}</label>
                                <input type="number" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('chart_background')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.chart_background') }}</label>
                                <input type="file" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                <img src="{{ asset('images/app/' . $item->value) }}" alt="{{ __('index.chart_background') }}" style="width: 100px; height: 100px;">
                            </div>
                            @break
                            @case('on_change_chart')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.on_change_chart') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="on" {{ $item->value == 'on' ? 'selected' : '' }}>{{ __('index.on') }}</option>
                                    <option value="off" {{ $item->value == 'off' ? 'selected' : '' }}>{{ __('index.off') }}</option>
                                </select>
                            </div>
                            @break
                            @case('image_notification')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.image_notification') }}</label>
                                <input type="file" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                <img src="{{ asset('images/app/' . $item->value) }}" alt="{{ __('index.image_notification') }}" style="width: 100px; height: 100px;">
                            </div>
                            @break
                            @case('trade_multiple')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.trade_multiple') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="1" {{ $item->value == '1' ? 'selected' : '' }}>{{ __('index.multiple_trade') }}</option>
                                    <option value="0" {{ $item->value == '0' ? 'selected' : '' }}>{{ __('index.single_trade') }}</option>
                                </select>
                            </div>
                            @break
                            @case('disabled_referal')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.disabled_referal') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="on" {{ $item->value == 'on' ? 'selected' : '' }}>{{ __('index.on') }}</option>
                                    <option value="off" {{ $item->value == 'off' ? 'selected' : '' }}>{{ __('index.off') }}</option>
                                </select>
                            </div>
                            @break
                            @case('verify')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.verify_required') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="on" {{ $item->value == 'on' ? 'selected' : '' }}>{{ __('index.on') }}</option>
                                    <option value="off" {{ $item->value == 'off' ? 'selected' : '' }}>{{ __('index.off') }}</option>
                                </select>
                            </div>
                            @break
                            @case('password2')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.password2') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('app_author')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.app_author') }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @default
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ $item->key }}</label>
                                <input type="text" class="form-control" id="{{ $item->key }}" name="{{ $item->key }}" value="{{ $item->value }}">
                            </div>
                            @break
                            @case('on_security_withdraw')
                            <div class="form-group col-md-6 mb-3">
                                <label for="{{ $item->key }}">{{ __('index.on_security_withdraw') }}</label>
                                <select class="form-control" id="{{ $item->key }}" name="{{ $item->key }}">
                                    <option value="on" {{ $item->value == 'on' ? 'selected' : '' }}>{{ __('index.on') }}</option>
                                    <option value="off" {{ $item->value == 'off' ? 'selected' : '' }}>{{ __('index.off') }}</option>
                                </select>
                            </div>
                            @break
                            @endswitch

                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">{{ __('index.save_configuration') }}</button>
                </form>
            </div>
        </div>
    </div>

    <!-- modal thêm mới -->
    <div class="modal fade" id="modal-add-symbol" tabindex="-1" role="dialog" aria-labelledby="modal-add-symbol" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-symbol-title">{{ __('index.add_symbol') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.symbols.store') }}" method="post" id="form-add-symbol" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('index.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="symbol">{{ __('index.symbol') }}</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" required>
                        </div>
                        <div class="form-group">
                            <label for="image">{{ __('index.image') }}</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">{{ __('index.active') }}</option>
                                <option value="inactive">{{ __('index.inactive') }}</option>
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
    <div class="modal fade" id="modal-edit-symbol" tabindex="-1" role="dialog" aria-labelledby="modal-edit-symbol" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-symbol-title">{{ __('index.edit_symbol') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.symbols.update', ['symbol' => ':symbol']) }}" method="post" id="form-edit-symbol" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('index.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="symbol">{{ __('index.symbol') }}</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" required>
                        </div>
                        <div class="form-group">
                            <label for="image">{{ __('index.image') }}</label>
                            <input type="file" class="form-control image-input" name="image">
                            <img src="" id="image-preview" style="width: 100px; height: 100px;">
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">{{ __('index.active') }}</option>
                                <option value="inactive">{{ __('index.inactive') }}</option>
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

        $('#form-add-symbol').submit(function(e) {
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
                    reloadPage("{{ route('cpanel.symbols') }}", '#dataTable', '#dataTable');
                    $('#modal-add-symbol').modal('hide');
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
            const url = "{{ route('cpanel.symbols.destroy', ['symbol' => ':symbol']) }}".replace(':symbol', $(this).data('id'));
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
                            reloadPage("{{ route('cpanel.symbols') }}", '#dataTable', '#dataTable');
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
            let symbol = $(this).data('id');
            $('.loading').show();

            $.ajax({
                url: "{{ route('cpanel.symbols.show', ['symbol' => ':symbol']) }}".replace(':symbol', symbol),
                type: 'get',
                success: function(response) {
                    $('#modal-edit-symbol').modal('show');
                    $('#modal-edit-symbol').find('input[name="name"]').val(response.name);
                    $('#modal-edit-symbol').find('input[name="symbol"]').val(response.symbol);
                    $('#modal-edit-symbol').find('img').attr('src', response.image);
                    $('#modal-edit-symbol').find('select[name="status"]').val(response.status == 'active' ? 'active' : 'inactive');
                    $('#form-edit-symbol').attr('action', "{{ route('cpanel.symbols.update', ['symbol' => ':symbol']) }}".replace(':symbol', symbol));
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

        $('#form-edit-symbol').submit(function(e) {
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
                    reloadPage("{{ route('cpanel.symbols') }}", '#dataTable', '#dataTable');
                    $('#modal-edit-symbol').modal('hide');
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

        $('.image-input').change(function() {
            //preview image
            var file = $(this)[0].files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush