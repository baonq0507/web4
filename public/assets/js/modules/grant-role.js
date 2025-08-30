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