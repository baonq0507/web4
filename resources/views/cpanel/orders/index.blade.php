@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<style>
    .progress {
        height: 5px;
        margin-top: 5px;
    }

    .progress-bar {
        transition: width 1s linear;
    }
</style>
@endpush
@section('content')
<main id="main-container" class="order-page">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.order_list') }}</h1>
            </div>
        </div>
    </div>
    <div class="content" style="width: 100%;">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;">#</th>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.customer') }}</th>
                            <th class="text-center" style="width: 12%;">{{ __('index.phone') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.session_code') }}</th>
                            <th class="text-center" style="width: 7%;">{{ __('index.time') }}</th>
                            <th class="text-center" style="width: 10%;">{{ __('index.after_balance') }}</th>
                            <th class="text-center" style="width: 7%;">{{ __('index.order_type') }}</th>
                            <th class="text-center">{{ __('index.order_type_system') }}</th>
                            <th class="text-center">{{ __('index.amount') }}</th>
                            <th class="text-center">{{ __('index.profit') }}</th>
                            <th class="text-center">{{ __('index.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user_trades as $user_trade)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $user_trade->user->id }}</td>
                            <td class="text-center">{{ $user_trade->user->name }}</td>
                            <td class="font-w600 text-center">
                                <a href="{{ route('cpanel.user.show', $user_trade->user->id) }}">
                                    {{ $user_trade->user->phone }}
                                </a>
                            </td>
                            <td class="font-w600">
                                <img src="{{ $user_trade->symbol->image }}" alt="{{ $user_trade->symbol->name }}" class="img-fluid" style="width: 20px; height: 20px;">
                                <span>
                                    {{ $user_trade->symbol->name }}/{{ $user_trade->code }}
                                </span>
                            </td>
                            <td class="text-center">{{ $user_trade->time_session->unit == 'm' ? $user_trade->time_session->time * 60 : ($user_trade->time_session->unit == 'h' ? $user_trade->time_session->time * 3600 : $user_trade->time_session->time * 86400) }}s</td>
                            <td class="text-center">{{ $user_trade->after_balance ? number_format(floatval($user_trade->after_balance), 2, '.', ',') : '-' }}</td>
                            <td class="text-center">
                                <span class="badge text-white bg-{{ $user_trade->type == 'buy' ? 'success' : 'danger' }}">{{ $user_trade->type == 'buy' ? __('index.buy') : __('index.sell') }}</span>
                            </td>
                            <td class="text-center" id="btn-edit-result-{{ $user_trade->id }}" data-result="{{ floatval($user_trade->open_price) < floatval($user_trade->close_price) ? 'buy' : 'sell' }}">
                                @if($user_trade->trade_end >= now())
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-xs {{ floatval($user_trade->open_price) < floatval($user_trade->close_price) ? 'btn-success' : 'btn-outline-success' }}"
                                        onclick="editResult('{{ $user_trade->id }}', 'buy')">
                                        {{ __('index.buy') }}
                                    </button>
                                    <button class="btn btn-xs {{ floatval($user_trade->open_price) > floatval($user_trade->close_price) ? 'btn-danger' : 'btn-outline-danger' }}"
                                        onclick="editResult('{{ $user_trade->id }}', 'sell')">
                                        {{ __('index.sell') }}
                                    </button>
                                </div>
                                @else
                                <span class="badge text-white bg-{{ floatval($user_trade->open_price) < floatval($user_trade->close_price) ? 'success' : 'danger' }}">{{ floatval($user_trade->open_price) < floatval($user_trade->close_price) ? __('index.buy') : __('index.sell') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ number_format((float) str_replace(',', '', $user_trade->amount), 2, '.', ',') }}
                            </td>
                            <td class="text-center {{ $user_trade->result === 'win' ? 'text-success' : 'text-danger' }}">
                                {{ $user_trade->result === 'win' ? '+' . number_format((float) str_replace(',', '', $user_trade->profit), 2, '.', ',') : '-' . number_format((float) str_replace(',', '', $user_trade->profit), 2, '.', ',') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $user_trade->trade_end >= now() ? 'warning' : 'success' }} text-white">
                                    {{ $user_trade->trade_end >= now() ? __('index.pending') : __('index.success') }}
                                </span>
                                @if($user_trade->trade_end >= now())
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        data-trade-id="{{ $user_trade->id }}"
                                        data-start="{{ $user_trade->trade_at }}"
                                        data-end="{{ $user_trade->trade_end }}"
                                        style="width: 0%"></div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $user_trades->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    function editResult(id, type) {
        const result = type;
        Swal.fire({
            title: '{{ __("index.edit_result") }}',
            text: `{{ __("index.confirm_result") }} ${type === 'buy' ? '{{ __("index.buy") }}' : '{{ __("index.sell") }}'}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ __("index.save") }}',
            cancelButtonText: '{{ __("index.cancel") }}',
            preConfirm: () => {
                return $.ajax({
                    url: `{{ route('cpanel.orders.edit-result', ['id' => ':id']) }}`.replace(':id', id),
                    method: 'PUT', 
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        result: result,
                    },
                    success: function(response) {
                        reloadPage("{{ route('cpanel.orders') }}", '#dataTable', '#dataTable');
                        return response;
                    },
                    error: function(xhr) {
                        Swal.showValidationMessage(
                            `Request failed: ${xhr.statusText}`
                        );
                    }
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    '{{ __("index.success") }}!',
                    '{{ __("index.result_updated") }}',
                    'success'
                )
                reloadPage("{{ route('cpanel.orders') }}", '#dataTable', '#dataTable');
            }
        })
    }
</script>
<script>
    $(document).ready(function() {
        // const table = $('#dataTable').DataTable({
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

        // Initialize WebSocket connection
        const ws = new WebSocket("{{env('WEBSOCKET_URL')}}");


        // Update progress bars every second
        setInterval(function() {
            $('.progress-bar').each(function() {
                const id = $(this).data('trade-id');
                const result = $(this).data('result');
                const start = new Date($(this).data('start'));
                const end = new Date($(this).data('end'));
                const now = new Date();

                const total = end - start;
                const elapsed = now - start;
                const progress = Math.min(Math.max((elapsed / total) * 100, 0), 100);

                $(this).css('width', `${progress}%`);

                // Change color based on progress
                if (progress < 33) {
                    $(this).removeClass('bg-warning bg-success').addClass('bg-danger');
                } else if (progress < 66) {
                    $(this).removeClass('bg-danger bg-success').addClass('bg-warning');
                } else {
                    $(this).removeClass('bg-danger bg-warning').addClass('bg-success');
                }

                if (progress >= 100) {
                    const statusCell = $(this).closest('td');
                    statusCell.find('.badge')
                        .removeClass('bg-danger bg-warning')
                        .addClass('bg-success')
                        .text('{{ __("index.success") }}');
                    $(this).closest('.progress').remove();

                    // Hide action column when progress complete
                    if(result === 'buy') {
                        $('#btn-edit-result-' + id).html('<span class="badge bg-success">{{ __("index.buy") }}</span>');
                    } else {
                        $('#btn-edit-result-' + id).html('<span class="badge bg-danger">{{ __("index.sell") }}</span>');
                    }
                }
            });
        }, 1000);
    });
</script>
@endpush