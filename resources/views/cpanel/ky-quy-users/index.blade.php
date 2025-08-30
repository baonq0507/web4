@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container" class="ky-quy-users-page">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.ky_quy_user_list') }}</h1>
                <!-- <a href="{{ route('cpanel.ky-quies.create') }}" class="btn btn-alt-success my-2">
                    <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_ky_quy') }}
                </a> -->
            </div>
        </div>
    </div>
    <div class="content" style="width: 100%;">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 7%;">{{ __('index.user') }}</th>
                            <th class="text-center" style="width: 15%;">{{ __('index.ky_quy_name') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.amount') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.before_balance') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.after_balance') }}</th>
                            <th class="text-center" style="width: 5%;">{{ __('index.progress') }}</th>
                            <th class="text-center" style="width: 5%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 7%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kyQuyUsers as $kyQuyUser)
                        <tr>
                            <td class="text-center">{{ $kyQuyUser->user->id }}</td>
                            <td class="text-center">
                                <a href="{{ route('cpanel.user.show', $kyQuyUser->user->id) }}" class="text-primary">
                                    {{ $kyQuyUser->user->name }}
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('cpanel.ky-quies.edit', $kyQuyUser->kyQuy->id) }}" class="text-primary">
                                    {{ $kyQuyUser->kyQuy->name_vi }}: {{ $kyQuyUser->value }} {{ $kyQuyUser->unit == 'mm' ? __('index.minute') : ($kyQuyUser->unit == 'd' ? __('index.day') : ($kyQuyUser->unit == 'm' ? __('index.month') : __('index.year'))) }} - {{__('index.profit')}}: {{ $kyQuyUser->profit }} USDT
                                </a>
                            </td>
                            <td class="text-center">{{ number_format($kyQuyUser->balance, 2) }}</td>
                            <td class="text-center">{{ number_format($kyQuyUser->before_balance, 2) }}</td>
                            <td class="text-center">{{ number_format($kyQuyUser->after_balance, 2) }}</td>
                            <td class="text-center">
                                @if($kyQuyUser->status == 'approve')
                                <div class="progress" style="height: 10px;">
                                    <div data-start-time="{{ $kyQuyUser->approve_date }}" data-end-time="{{ $kyQuyUser->end_date }}" class="progress-bar progress-bar-striped progress-bar-animated progress-kyquy" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                @else
                                <span class="badge badge-{{ $kyQuyUser->status == 'pending' ? 'warning' : ($kyQuyUser->status == 'approve' ? 'success' : ($kyQuyUser->status == 'cancel' ? 'danger' : 'secondary')) }}">
                                    {{ $kyQuyUser->status == 'pending' ? __('index.pending') : ($kyQuyUser->status == 'approve' ? __('index.approve') : ($kyQuyUser->status == 'cancel' ? __('index.cancel') : ($kyQuyUser->status == 'finish' ? __('index.finish') : ($kyQuyUser->status == 'stop' ? __('index.stop') : ($kyQuyUser->status == 'failed' ? __('index.failed') : __('index.false')))))) }}
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $kyQuyUser->status == 'pending' ? 'warning' : ($kyQuyUser->status == 'approve' ? 'success' : ($kyQuyUser->status == 'cancel' ? 'danger' : 'secondary')) }}">
                                    {{ $kyQuyUser->status == 'pending' ? __('index.pending') : ($kyQuyUser->status == 'approve' ? __('index.approve') : ($kyQuyUser->status == 'cancel' ? __('index.cancel') : ($kyQuyUser->status == 'finish' ? __('index.finish') : ($kyQuyUser->status == 'stop' ? __('index.stop') : ($kyQuyUser->status == 'failed' ? __('index.failed') : __('index.false')))))) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown dropleft">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-fw fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">

                                        @if($kyQuyUser->status == 'pending')
                                        <button class="dropdown-item text-success btn-approve" data-id="{{ $kyQuyUser->id }}">
                                            <i class="fa fa-fw fa-check"></i>
                                            {{ __('index.approve') }}
                                        </button>
                                        <button class="dropdown-item text-danger btn-reject" data-id="{{ $kyQuyUser->id }}">
                                            <i class="fa fa-fw fa-times"></i>
                                            {{ __('index.reject') }}
                                        </button>
                                        @endif
                                        @if($kyQuyUser->status == 'approve')
                                        <button class="dropdown-item text-danger btn-stop" data-id="{{ $kyQuyUser->id }}">
                                            <i class="fa fa-fw fa-pause"></i>
                                            {{ __('index.stop') }}
                                        </button>
                                        <button class="dropdown-item text-success btn-finish" data-id="{{ $kyQuyUser->id }}">
                                            <i class="fa fa-fw fa-check"></i>
                                            {{ __('index.finish') }}
                                        </button>
                                        @endif
                                        @if($kyQuyUser->status == 'stop')
                                        <button class="dropdown-item text-success btn-finish" data-id="{{ $kyQuyUser->id }}">
                                            <i class="fa fa-fw fa-check"></i>
                                            {{ __('index.finish') }}
                                        </button>
                                        <button class="dropdown-item text-danger btn-approve" data-id="{{ $kyQuyUser->id }}">
                                            <i class="fa fa-fw fa-check"></i>
                                            {{ __('index.approve') }}
                                        </button>
                                        @endif
                                        <form action="{{ route('cpanel.ky-quy-users.destroy', $kyQuyUser->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('{{ __('index.confirm_delete') }}')">
                                                <i class="fa fa-fw fa-trash"></i>
                                                {{ __('index.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $kyQuyUsers->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">{{ __('index.approve') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('index.approve_ky_quy_user') }}</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('index.close') }}</button>
                <button type="button" class="btn btn-success btn-approve-confirm">{{ __('index.approve') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">{{ __('index.reject') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('index.reject_ky_quy_user') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('index.close') }}</button>
                <button type="button" class="btn btn-danger btn-reject-confirm">{{ __('index.reject') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stopModal" tabindex="-1" role="dialog" aria-labelledby="stopModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stopModalLabel">{{ __('index.stop') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('index.stop_ky_quy_user') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('index.close') }}</button>
                <button type="button" class="btn btn-danger btn-stop-confirm">{{ __('index.stop') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finishModalLabel">{{ __('index.finish') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('index.finish_ky_quy_user') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('index.close') }}</button>
                <button type="button" class="btn btn-success btn-finish-confirm">{{ __('index.finish') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let id = '';
        $(document).on('click', '.btn-approve', function() {
            id = $(this).data('id');
            $('#approveModal').modal('show');
        });
        $(document).on('click', '.btn-approve-confirm', function() {
            $(this).html('<i class="fa fa-fw fa-spinner fa-spin"></i> {{ __("index.approving") }}');
            $(this).prop('disabled', true);

            let url = "{{ route('cpanel.ky-quy-users.approve', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.success,
                        icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message,
                        icon: "error"
                    });
                },
                complete: function() {
                    $(this).html("{{ __('index.approve') }}");
                    $(this).prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.btn-reject', function() {
            id = $(this).data('id');
            $('#rejectModal').modal('show');
        });

        $(document).on('click', '.btn-reject-confirm', function() {
            $(this).html('<i class="fa fa-fw fa-spinner fa-spin"></i> {{ __("index.rejecting") }}');
            $(this).prop('disabled', true);

            let url = "{{ route('cpanel.ky-quy-users.reject', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.success,
                        icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message,
                        icon: "error"
                    });
                },
                complete: function() {
                    $(this).html("{{ __('index.reject') }}");
                    $(this).prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.btn-stop', function() {
            id = $(this).data('id');
            $('#stopModal').modal('show');
        });

        $(document).on('click', '.btn-stop-confirm', function() {
            $(this).html('<i class="fa fa-fw fa-spinner fa-spin"></i> {{ __("index.stopping") }}');
            $(this).prop('disabled', true);

            let url = "{{ route('cpanel.ky-quy-users.stop', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.success,
                        icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message,
                        icon: "error"
                    });
                },
                complete: function() {
                    $(this).html("{{ __('index.stop') }}");
                    $(this).prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.btn-finish', function() {
            id = $(this).data('id');
            $('#finishModal').modal('show');
        });

        $(document).on('click', '.btn-finish-confirm', function() {
            $(this).html('<i class="fa fa-fw fa-spinner fa-spin"></i> {{ __("index.finishing") }}');
            $(this).prop('disabled', true);

            let url = "{{ route('cpanel.ky-quy-users.finish', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.success,
                        icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message,
                        icon: "error"
                    });
                },
                complete: function() {
                    $(this).html("{{ __('index.finish') }}");
                    $(this).prop('disabled', false);
                }
            });
        });

        setInterval(function() {
            $('.progress-kyquy').each(function() {
                let start_time = new Date($(this).data('start-time'));
                let end_time = new Date($(this).data('end-time'));
                let now = new Date();
                let total_duration = Math.ceil((end_time - start_time) / (1000 * 60 * 60 * 24)); // Tính tổng thời gian theo ngày
                let elapsed_time = Math.ceil((now - start_time) / (1000 * 60 * 60 * 24)); // Tính thời gian đã trôi qua theo ngày
                let progress = (elapsed_time / total_duration) * 100;
                if (!isFinite(progress) || progress < 0) {
                    progress = 0;
                } else if (progress > 100) {
                    progress = 100;
                }
                console.log(progress);
                $(this).css('width', progress + '%');

                // Thay đổi màu sắc dựa trên tiến độ
                if (progress < 50) {
                    $(this).css('background-color', 'red');
                } else if (progress < 75) {
                    $(this).css('background-color', 'yellow');
                } else {
                    $(this).css('background-color', 'green');
                }
            });
        }, 1000); // Cập nhật mỗi giây

    });
</script>
@endpush