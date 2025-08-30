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
                <button type="button" class="btn btn-alt-success my-2" id="btn-add-symbol" data-toggle="modal" data-target="#modal-add-symbol">
                    <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_symbol') }}
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
                            <th class="text-center" style="width: 20%;">{{ __('index.name') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.symbol') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.image') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($symbols as $symbol)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="font-w600">{{ $symbol->name }}</td>
                            <td class="font-w600">{{ $symbol->symbol }}</td>
                            <td>
                                <img src="{{ $symbol->image }}" alt="{{ $symbol->name }}" style="width: 30px; height: 30px;">
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
                    $('#modal-edit-symbol').find('input[name="profit_win"]').val(response.profit_win);
                    $('#modal-edit-symbol').find('input[name="profit_lose"]').val(response.profit_lose);
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