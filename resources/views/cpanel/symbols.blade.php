@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.symbol_list') }}</h1>
                <div class="d-flex gap-2">
                    <!-- Filter buttons -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary filter-btn" data-category="">Tất cả</button>
                        <button type="button" class="btn btn-outline-primary filter-btn" data-category="crypto">Crypto</button>
                        <button type="button" class="btn btn-outline-primary filter-btn" data-category="usa">USA</button>
                        <button type="button" class="btn btn-outline-primary filter-btn" data-category="forex">Forex</button>
                    </div>
                    <button type="button" class="btn btn-alt-success my-2" id="btn-add-symbol" data-toggle="modal" data-target="#modal-add-symbol">
                        <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_symbol') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.name') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.symbol') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.image') }}</th>
                            <th class="text-center" style="width: 10%;">Loại</th>
                            <th class="text-center" style="width: 8%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($symbols as $symbol)
                        <tr data-category="{{ $symbol->category }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="font-w600">{{ $symbol->name }}</td>
                            <td class="font-w600">{{ $symbol->symbol }}</td>
                            <td>
                                <img src="{{ $symbol->image }}" alt="{{ $symbol->name }}" style="width: 30px; height: 30px;">
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $symbol->category == 'crypto' ? 'warning' : ($symbol->category == 'usa' ? 'success' : 'primary') }}">
                                    <i class="{{ $symbol->category_icon }}"></i> {{ $symbol->category_name }}
                                </span>
                            </td>
                            <td class="text-center">{{ $symbol->status_name }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" data-id="{{ $symbol->id }}" data-name="{{ $symbol->name }}" class="btn btn-sm btn-primary btn-edit" title="{{ __('index.edit') }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" data-id="{{ $symbol->id }}" data-name="{{ $symbol->name }}" class="btn btn-sm btn-primary btn-delete" title="{{ __('index.delete') }}">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('index.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="symbol">{{ __('index.symbol') }}</label>
                                    <input type="text" class="form-control" id="symbol" name="symbol" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Loại</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="crypto">Crypto</option>
                                        <option value="usa">USA</option>
                                        <option value="forex">Forex</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('index.status') }}</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active">{{ __('index.active') }}</option>
                                        <option value="inactive">{{ __('index.inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="base_currency">Tiền tệ cơ sở</label>
                                    <input type="text" class="form-control" id="base_currency" name="base_currency" placeholder="VD: USD, EUR">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quote_currency">Tiền tệ định giá</label>
                                    <input type="text" class="form-control" id="quote_currency" name="quote_currency" placeholder="VD: VND, USD">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tick_size">Kích thước tick</label>
                                    <input type="number" step="0.00001" class="form-control" id="tick_size" name="tick_size" value="0.00001">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lot_size">Kích thước lot</label>
                                    <input type="number" step="0.01" class="form-control" id="lot_size" name="lot_size" value="1.00">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_leverage">Đòn bẩy tối đa</label>
                                    <input type="number" class="form-control" id="max_leverage" name="max_leverage" value="1" min="1" max="1000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check mt-4">
                                        <input type="checkbox" class="form-check-input" id="is_margin_trading" name="is_margin_trading">
                                        <label class="form-check-label" for="is_margin_trading">
                                            Cho phép giao dịch ký quỹ
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">{{ __('index.image') }}</label>
                            <input type="file" class="form-control" id="image" name="image" required>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('index.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="symbol">{{ __('index.symbol') }}</label>
                                    <input type="text" class="form-control" id="symbol" name="symbol" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Loại</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="crypto">Crypto</option>
                                        <option value="usa">USA</option>
                                        <option value="forex">Forex</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('index.status') }}</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active">{{ __('index.active') }}</option>
                                        <option value="inactive">{{ __('index.inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="base_currency">Tiền tệ cơ sở</label>
                                    <input type="text" class="form-control" id="base_currency" name="base_currency" placeholder="VD: USD, EUR">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quote_currency">Tiền tệ định giá</label>
                                    <input type="text" class="form-control" id="quote_currency" name="quote_currency" placeholder="VD: VND, USD">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tick_size">Kích thước tick</label>
                                    <input type="number" step="0.00001" class="form-control" id="tick_size" name="tick_size" value="0.00001">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lot_size">Kích thước lot</label>
                                    <input type="number" step="0.01" class="form-control" id="lot_size" name="lot_size" value="1.00">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_leverage">Đòn bẩy tối đa</label>
                                    <input type="number" class="form-control" id="max_leverage" name="max_leverage" value="1" min="1" max="1000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check mt-4">
                                        <input type="checkbox" class="form-check-input" id="is_margin_trading" name="is_margin_trading">
                                        <label class="form-check-label" for="is_margin_trading">
                                            Cho phép giao dịch ký quỹ
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">{{ __('index.image') }}</label>
                            <input type="file" class="form-control image-input" name="image">
                            <img src="" id="image-preview" style="width: 100px; height: 100px;">
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
        var table = $('#dataTable').DataTable({
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

        // Filter functionality
        $('.filter-btn').click(function() {
            var category = $(this).data('category');
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            if (category === '') {
                table.column(4).search('').draw();
            } else {
                table.column(4).search(category).draw();
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
                    $('#modal-edit-symbol').find('select[name="category"]').val(response.category);
                    $('#modal-edit-symbol').find('textarea[name="description"]').val(response.description);
                    $('#modal-edit-symbol').find('input[name="base_currency"]').val(response.base_currency);
                    $('#modal-edit-symbol').find('input[name="quote_currency"]').val(response.quote_currency);
                    $('#modal-edit-symbol').find('input[name="tick_size"]').val(response.tick_size);
                    $('#modal-edit-symbol').find('input[name="lot_size"]').val(response.lot_size);
                    $('#modal-edit-symbol').find('input[name="max_leverage"]').val(response.max_leverage);
                    $('#modal-edit-symbol').find('input[name="is_margin_trading"]').prop('checked', response.is_margin_trading);
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