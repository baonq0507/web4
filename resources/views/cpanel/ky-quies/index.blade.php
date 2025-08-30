@extends('cpanel.layouts.app')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.post_list') }}</h1>
                <a href="{{ route('cpanel.ky-quies.create') }}" class="btn btn-alt-success my-2">
                    <i class="fa fa-fw fa-plus mr-1"></i> {{ __('index.add_ky_quy') }}
                </a>
            </div>
        </div>
    </div>
    <div class="content">
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
                            <th class="text-center" style="width: 20%;">{{ __('index.name_ky_quy') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.image') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.loai') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.status') }}</th>
                            <th class="text-center" style="width: 20%;">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kyQuies as $kyQuy)
                        <tr>
                            <td class="text-center">{{ $kyQuy->name_vi }}</td>
                            <td class="text-center">
                                <img src="{{ asset('images/' . $kyQuy->image) }}" alt="{{ $kyQuy->name_vi }}" style="width: 100px; height: 100px;">
                            </td>
                            <td class="text-center">
                                {{ $kyQuy->loai == 'co_dinh' ? __('index.co_dinh') : __('index.linh_hoat') }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $kyQuy->show === 'show' ? 'success' : 'secondary' }}">
                                    {{ $kyQuy->show === 'show' ? __('index.show') : __('index.hide') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-fw fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item text-primary" href="{{ route('cpanel.ky-quies.edit', $kyQuy->id) }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                            {{ __('index.edit') }}
                                        </a>
                                        <form action="{{ route('cpanel.ky-quies.destroy', $kyQuy->id) }}" method="POST" class="d-inline">
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
                    {{ $kyQuies->links('vendor.pagination.bootstrap-4') }}
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