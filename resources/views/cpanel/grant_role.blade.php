@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.role_list') }}</h1>
                <button type="button" class="btn btn-alt-success my-2" id="btn-add-role" data-toggle="modal" data-target="#modal-add-role">
                    <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_role') }}
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
                            <th class="text-center" style="width: 20%;">{{ __('index.role_name') }}</th>
                            <th class="text-center" style="width: 60%;">{{ __('index.permission') }}</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="font-w600">{{ App\Helper::getRoleName($role->name) }}</td>
                            <td>
                                @foreach ($role->permissions as $permission)
                                <span class="badge badge-primary">{{ App\Helper::convertNamePermission($permission->name) }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" data-id="{{ $role->id }}" data-name="{{ $role->name }}" class="btn btn-sm btn-primary btn-assign" title="{{ __('index.assign_permission') }}">
                                        <i class="fa fa-atom"></i>
                                    </button>
                                    <button type="button" data-id="{{ $role->id }}" data-name="{{ $role->name }}" class="btn btn-sm btn-primary btn-edit" title="{{ __('index.edit') }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" data-id="{{ $role->id }}" data-name="{{ $role->name }}" class="btn btn-sm btn-primary btn-delete" title="{{ __('index.delete') }}">
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
    <div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog" aria-labelledby="modal-add-role" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-role-title">Thêm vai trò</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.grant-role.store') }}" method="post" id="form-add-role">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('index.role_name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" required>
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
    <div class="modal fade" id="modal-edit-role" tabindex="-1" role="dialog" aria-labelledby="modal-edit-role" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-role-title">{{ __('index.edit_role') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.grant-role.update', ['role' => ':role']) }}" method="post" id="form-edit-role">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('index.role_name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.edit') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- modal assign permission -->
    <div class="modal fade" id="modal-assign-permission" tabindex="-1" role="dialog" aria-labelledby="modal-assign-permission" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-assign-permission-title">{{ __('index.assign_permission') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cpanel.grant-role.assign', ['role' => ':role']) }}" method="post" id="form-assign-permission">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($permissions->chunk(2) as $chunk)
                                @foreach ($chunk as $permission)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                        <label for="name">{{ App\Helper::convertNamePermission($permission->name) }}</label>
                                    </div>
                                </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('index.assign') }}</button>
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

        $('#form-add-role').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
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
                    reloadPage("{{ route('cpanel.grant-role') }}", '#dataTable', '#dataTable');
                    $('#modal-add-role').modal('hide');
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

        $('#dataTable').on('click', '.btn-delete', function() {
            const url = "{{ route('cpanel.grant-role.destroy', ['role' => ':role']) }}".replace(':role', $(this).data('id'));
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
                            reloadPage("{{ route('cpanel.grant-role') }}", '#dataTable', '#dataTable');
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
            let role = $(this).data('id');
            $('.loading').show();

            $.ajax({
                url: "{{ route('cpanel.grant-role.show', ['role' => ':role']) }}".replace(':role', role),
                type: 'get',
                success: function(response) {
                    $('#modal-edit-role').modal('show');
                    $('#modal-edit-role').find('input[name="name"]').val(response.role.name);
                    $('#form-edit-role').attr('action', "{{ route('cpanel.grant-role.update', ['role' => ':role']) }}".replace(':role', role));
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

        $('#form-edit-role').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
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
                    reloadPage("{{ route('cpanel.grant-role') }}", '#dataTable', '#dataTable');
                    $('#modal-edit-role').modal('hide');
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

        $('#dataTable').on('click', '.btn-assign', function() {
            let role = $(this).data('id');
            let name = $(this).data('name');
            const url = "{{ route('cpanel.grant-role.show', ['role' => ':role']) }}".replace(':role', role);
            $('.loading').show();

            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    $('#modal-assign-permission').modal('show');

                    $('#modal-assign-permission').find('input[name="permissions[]"]').each(function() {
                        let permissionId = parseInt($(this).val());
                        if (response.role.permissions.map(permission => permission.id).includes(permissionId)) {
                            $(this).prop('checked', true);
                        }
                    });

                    $('#form-assign-permission').attr('action', "{{ route('cpanel.grant-role.assign', ['role' => ':role']) }}".replace(':role', role));
                },
                error: function(response) {
                    $('.loading').hide();
                },
                complete: function() {
                    $('.loading').hide();
                }
            });
        });

        $('#form-assign-permission').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
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
                    reloadPage("{{ route('cpanel.grant-role') }}", '#dataTable', '#dataTable');
                    $('#modal-assign-permission').modal('hide');
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