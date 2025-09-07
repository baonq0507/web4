@extends('cpanel.layouts.app')
@section('title', 'Transfer Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Transfer Details #{{ $transfer->id }}</h3>
                    <a href="{{ route('cpanel.transfers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Transfer Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Transfer Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Transfer ID:</strong></td>
                                            <td>{{ $transfer->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Code:</strong></td>
                                            <td>{{ $transfer->code }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Currency:</strong></td>
                                            <td>
                                                @if($transfer->symbol)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $transfer->symbol->image }}" alt="{{ $transfer->symbol->symbol }}" class="img-circle img-size-32 mr-2">
                                                        {{ $transfer->symbol->symbol }} ({{ $transfer->symbol->name }})
                                                    </div>
                                                @else
                                                    <span class="badge badge-info">USDT</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount:</strong></td>
                                            <td><strong class="text-primary">{{ number_format($transfer->amount, 8) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>From Account:</strong></td>
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
                                        </tr>
                                        <tr>
                                            <td><strong>To Account:</strong></td>
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
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($transfer->status == 'completed')
                                                    <span class="badge badge-success">Completed</span>
                                                @elseif($transfer->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @else
                                                    <span class="badge badge-danger">Failed</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At:</strong></td>
                                            <td>{{ $transfer->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated At:</strong></td>
                                            <td>{{ $transfer->updated_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">User Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>User ID:</strong></td>
                                            <td>{{ $transfer->user->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $transfer->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Username:</strong></td>
                                            <td>{{ $transfer->user->username ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $transfer->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $transfer->user->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Current Spot Balance:</strong></td>
                                            <td><strong class="text-success">{{ number_format($transfer->user->balance, 2) }} USDT</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Current Wallet Balance:</strong></td>
                                            <td><strong class="text-info">{{ number_format($transfer->user->balance_usdt ?? 0, 2) }} USDT</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Registration Date:</strong></td>
                                            <td>{{ $transfer->user->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Transaction Details</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Description:</strong></td>
                                            <td>{{ $transfer->description }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Note:</strong></td>
                                            <td>{{ $transfer->note }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Before Balance:</strong></td>
                                            <td>{{ number_format($transfer->before_balance, 8) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>After Balance:</strong></td>
                                            <td>{{ number_format($transfer->after_balance, 8) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Actions</h4>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('cpanel.user.show', $transfer->user->id) }}" class="btn btn-info">
                                        <i class="fas fa-user"></i> View User Profile
                                    </a>
                                    <a href="{{ route('cpanel.transfers.export', ['user_id' => $transfer->user->id]) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i> Export User Transfers
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
