@extends('cpanel.layouts.app')
@section('title', 'Transfer Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Transfer Management</h3>
                    <div>
                        <a href="{{ route('cpanel.transfers.export', request()->query()) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-exchange-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Transfers</span>
                                    <span class="info-box-number">{{ number_format($stats->total_transfers ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Amount</span>
                                    <span class="info-box-number">{{ number_format($stats->total_amount ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Average Amount</span>
                                    <span class="info-box-number">{{ number_format($stats->avg_amount ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Unique Users</span>
                                    <span class="info-box-number">{{ number_format($stats->unique_users ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <form method="GET" action="{{ route('cpanel.transfers.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>User</label>
                                    <select name="user_id" class="form-control form-control-sm">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name ?? $user->username }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select name="currency" class="form-control form-control-sm">
                                        <option value="">All Currencies</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency }}" {{ request('currency') == $currency ? 'selected' : '' }}>
                                                {{ $currency }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">All Status</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('cpanel.transfers.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Transfers Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $transfer)
                                    <tr>
                                        <td>{{ $transfer->id }}</td>
                                        <td>
                                            <div>
                                                <strong>{{ $transfer->user->name ?? $transfer->user->username }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $transfer->user->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($transfer->symbol)
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $transfer->symbol->image }}" alt="{{ $transfer->symbol->symbol }}" class="img-circle img-size-32 mr-2">
                                                    {{ $transfer->symbol->symbol }}
                                                </div>
                                            @else
                                                <span class="badge badge-info">USDT</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ number_format($transfer->amount, 8) }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $fromAccount = 'N/A';
                                                if($transfer->note) {
                                                    $parts = explode(' ', $transfer->note);
                                                    if(count($parts) >= 3) {
                                                        $fromAccount = ucfirst($parts[1]);
                                                    }
                                                }
                                            @endphp
                                            <span class="badge badge-secondary">{{ $fromAccount }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $toAccount = 'N/A';
                                                if($transfer->note) {
                                                    $parts = explode(' ', $transfer->note);
                                                    if(count($parts) >= 3) {
                                                        $toAccount = ucfirst($parts[3]);
                                                    }
                                                }
                                            @endphp
                                            <span class="badge badge-primary">{{ $toAccount }}</span>
                                        </td>
                                        <td>
                                            @if($transfer->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($transfer->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                {{ $transfer->created_at->format('Y-m-d') }}
                                                <br>
                                                <small class="text-muted">{{ $transfer->created_at->format('H:i:s') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('cpanel.transfers.show', $transfer->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No transfers found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $transfers->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when filters change
    $('select[name="user_id"], select[name="currency"], select[name="status"]').change(function() {
        $(this).closest('form').submit();
    });
});
</script>
@endpush
