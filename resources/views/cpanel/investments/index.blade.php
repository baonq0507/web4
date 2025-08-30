@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush    
@section('content')
<main id="main-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('index.investment_list') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('index.username') }}</th>
                                    <th>{{ __('index.project') }}</th>
                                    <th>{{ __('index.amount') }}</th>
                                    <th>{{ __('index.status') }}</th>
                                    <th>{{ __('index.created_at') }}</th>
                                    <th>{{ __('index.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($investments as $investment)
                                <tr>
                                    <td>
                                        <a href="{{ route('cpanel.user.show', $investment->user) }}" class="text-blue-500 hover:text-blue-700">
                                            {{ $investment->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('cpanel.projects.edit', $investment->project) }}" class="text-blue-500 hover:text-blue-700">
                                            {{ $investment->project->name }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($investment->amount, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $investment->status === 'approved' ? 'success' : ($investment->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($investment->status === 'pending' ? 'Đang đầu tư' : ($investment->status === 'success' ? 'Đã hoàn thành' : 'Đã dừng')) }}
                                        </span>
                                    </td>
                                    <td>{{ $investment->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('cpanel.investments.show', $investment) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('cpanel.investments.destroy', $investment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this investment?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $investments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection 
@push('scripts')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush