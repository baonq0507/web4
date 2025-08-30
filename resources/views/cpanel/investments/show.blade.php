@extends('cpanel.layouts.app')

@section('content')
<main id="main-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('index.investment_details') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('cpanel.investments.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> {{ __('index.back_to_list') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>{{ __('index.investment_id') }}</th>
                                    <td>{{ $investment->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('index.username') }}</th>
                                    <td>{{ $investment->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('index.project') }}</th>
                                    <td>{{ $investment->project->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('index.amount') }}</th>
                                    <td>{{ number_format($investment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('index.status') }}</th>
                                    <td>
                                        <span class="badge badge-{{ $investment->status === 'success' ? 'success' : ($investment->status === 'failed' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($investment->status === 'pending' ? __('index.pending_investment') : ($investment->status === 'success' ? __('index.success') : __('index.failed'))) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('index.created_at') }}</th>
                                    <td>{{ $investment->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('index.updated_at') }}</th>
                                    <td>{{ $investment->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Update Status</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('cpanel.investments.update', $investment) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="status">{{ __('index.status') }}</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="pending" {{ $investment->status === 'pending' ? 'selected' : '' }}>{{ __('index.pending_investment') }}</option>
                                                <option value="success" {{ $investment->status === 'success' ? 'selected' : '' }}>{{ __('index.success') }}</option>
                                                <option value="failed" {{ $investment->status === 'failed' ? 'selected' : '' }}>{{ __('index.failed') }}</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('index.update') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection 