@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container" class="kyc-page">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.symbol_list') }}</h1>
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
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.phone') }}</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.type_identity') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.identity_front') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.identity_back') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.fullname') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 7%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kycs as $kyc)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $kyc->user->id }}</td>
                            <td class="font-w600">
                                <a href="{{ route('cpanel.user.show', ['user' => $kyc->user->id]) }}">{{ $kyc->user->phone ?? $kyc->user->email }}</a>
                            </td>
                            <td class="font-w600">{{ $kyc->type == 'passport' ? __('index.passport') : ($kyc->type == 'national_id' ? __('index.national_id') : ($kyc->type == 'driver_license' ? __('index.driver_license') : __('index.residence_card'))) }}</td>
                            <td>
                                <img src="{{ $kyc->identity_front }}" alt="{{ $kyc->type }}" style="width: 30px; height: 30px;">
                            </td>
                            <td>
                                @if ($kyc->identity_back)
                                <img src="{{ $kyc->identity_back }}" alt="{{ $kyc->type }}" style="width: 30px; height: 30px;">
                                @endif
                            </td>
                            <td class="text-center">{{ $kyc->fullname }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $kyc->status == 'approved' ? 'success' : ($kyc->status == 'rejected' ? 'danger' : ($kyc->status == 'sent_again' ? 'warning' : 'secondary')) }}">{{ $kyc->status == 'approved' ? __('index.approved') : ($kyc->status == 'rejected' ? __('index.rejected') : ($kyc->status == 'sent_again' ? __('index.sent_again') : __('index.pending'))) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $kyc->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $kyc->id }}">
                                        <button class="dropdown-item btn-view btn-sm btn-primary" data-id="{{ $kyc->id }}" data-name="{{ $kyc->user->username }}" data-image-back="{{ $kyc->identity_back }}" data-image-front="{{ $kyc->identity_front }}">
                                            <i class="fa fa-eye mr-2 text-primary"></i> {{ __('index.view') }}
                                        </button>
                                        <button class="dropdown-item btn-accept btn-sm btn-success" data-id="{{ $kyc->id }}" data-name="{{ $kyc->user->username }}">
                                            <i class="fa fa-check mr-2 text-success"></i> {{ __('index.accept') }}
                                        </button>
                                        <button class="dropdown-item btn-reject btn-sm btn-danger" data-id="{{ $kyc->id }}" data-name="{{ $kyc->user->username }}">
                                            <i class="fa fa-times mr-2 text-danger"></i> {{ __('index.reject') }}
                                        </button>
                                        <button class="dropdown-item btn-sent-again btn-sm btn-warning" data-id="{{ $kyc->id }}" data-name="{{ $kyc->user->username }}">
                                            <i class="fa fa-sync mr-2 text-warning"></i> {{ __('index.sent_again') }}
                                        </button>
                                        <button class="dropdown-item btn-delete btn-sm btn-danger" data-id="{{ $kyc->id }}" data-name="{{ $kyc->user->username }}">
                                            <i class="fa fa-trash mr-2 text-danger"></i> {{ __('index.delete') }}
                                        </button>
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

    <!-- modal view -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-view" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-view-title">{{ __('index.view') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="image-back" alt="" class="img-fluid">
                    <img src="" id="image-front" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
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

        $('#dataTable').on('click', '.btn-view', function() {
            $('#modal-view').modal('show');
            $('#modal-view').find('img#image-back').attr('src', $(this).data('image-back'));
            $('#modal-view').find('img#image-front').attr('src', $(this).data('image-front'));
        });

        $('#dataTable').on('click', '.btn-accept', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: "{{ __('index.accept') }}",
                text: "{{ __('index.are_you_sure_to_accept') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: "{{ route('cpanel.kycs.update', ['kyc' => ':kyc']) }}".replace(':kyc', id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: "approved",
                            _method: "PUT"
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire("{{ __('index.success') }}", response.message, "success");
                            reloadPage("{{ route('cpanel.kycs') }}" , '#dataTable', '#dataTable');

                        },
                        error: function(xhr, status, error) {
                            Swal.fire("{{ __('index.error') }}", xhr.responseJSON.message, "error");
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-reject', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: "{{ __('index.reject') }}",
                text: "{{ __('index.are_you_sure_to_reject') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: "{{ route('cpanel.kycs.update', ['kyc' => ':kyc']) }}".replace(':kyc', id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: "rejected",
                            _method: "PUT"
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire("{{ __('index.success') }}", response.message, "success");
                            reloadPage("{{ route('cpanel.kycs') }}" , '#dataTable', '#dataTable');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("{{ __('index.error') }}", xhr.responseJSON.message, "error");
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });

        $('#dataTable').on('click', '.btn-sent-again', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: "{{ __('index.sent_again') }}",
                text: "{{ __('index.are_you_sure_to_sent_again') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: "{{ route('cpanel.kycs.update', ['kyc' => ':kyc']) }}".replace(':kyc', id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: "sent_again",
                            _method: "PUT"
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire("{{ __('index.success') }}", response.message, "success");
                            reloadPage("{{ route('cpanel.kycs') }}" , '#dataTable', '#dataTable');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("{{ __('index.error') }}", xhr.responseJSON.message, "error");
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }
            });
        });
        $('#dataTable').on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: "{{ __('index.delete') }}",
                text: "{{ __('index.are_you_sure_to_delete') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();
                    $.ajax({
                        url: "{{ route('cpanel.kycs.destroy', ['kyc' => ':kyc']) }}".replace(':kyc', id),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(response) {
                            Swal.fire("{{ __('index.success') }}", response.message, "success");
                            reloadPage("{{ route('cpanel.kycs') }}" , '#dataTable', '#dataTable');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("{{ __('index.error') }}", xhr.responseJSON.message, "error");
                        },
                        complete: function() {
                            $('.loading').hide();
                        }
                    });
                }

            });
        });

    });
</script>
@endpush