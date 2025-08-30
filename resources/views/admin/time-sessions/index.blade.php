@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush

@section('content')
<main id="main-container" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('index.time_session') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('cpanel.time-sessions.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('index.add_new') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('index.time') }}</th>
                                <th>{{ __('index.unit') }}</th>
                                <th>{{ __('index.win_rate') }}</th>
                                <th>{{ __('index.lose_rate') }}</th>
                                <th>{{ __('index.status') }}</th>
                                <th>{{ __('index.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timeSessions as $session)
                            <tr>
                                <td>{{ $session->time }}</td>
                                <td>{{ $session->unit == 'm' ? 'Phút' : ($session->unit == 'h' ? 'Giờ' : 'Ngày') }}</td>
                                <td>{{ $session->win_rate }}%</td>
                                <td>{{ $session->lose_rate }}%</td>
                                <td>
                                    <span class="badge badge-{{ $session->status ? 'success' : 'danger' }}">
                                        {{ $session->status ? __('index.active') : __('index.inactive') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('cpanel.time-sessions.edit', $session) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cpanel.time-sessions.destroy', $session) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $timeSessions->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection 