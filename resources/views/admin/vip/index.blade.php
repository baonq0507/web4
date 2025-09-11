@extends('admin.layout.app')

@section('title', 'Quản lý VIP Levels')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý VIP Levels</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">VIP Levels</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách VIP Levels</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.vip.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Thêm VIP Level
                                </a>
                                <button type="button" class="btn btn-info btn-sm" onclick="updateAllVipLevels()">
                                    <i class="fas fa-sync"></i> Cập nhật VIP cho tất cả user
                                </button>
                                <a href="{{ route('admin.vip.statistics') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-chart-bar"></i> Thống kê
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('error') }}
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>VIP Level</th>
                                            <th>Tên hiển thị</th>
                                            <th>Nạp tối thiểu</th>
                                            <th>Nạp tối đa</th>
                                            <th>Màu sắc</th>
                                            <th>Số người dùng</th>
                                            <th>Trạng thái</th>
                                            <th>Thứ tự</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vipLevels as $index => $vipLevel)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge badge-lg" style="background-color: {{ $vipLevel->color }}; color: white;">
                                                    {{ $vipLevel->name }}
                                                </span>
                                            </td>
                                            <td>{{ $vipLevel->display_name }}</td>
                                            <td>${{ number_format($vipLevel->min_deposit, 2) }}</td>
                                            <td>
                                                @if($vipLevel->max_deposit)
                                                    ${{ number_format($vipLevel->max_deposit, 2) }}
                                                @else
                                                    <span class="text-muted">Không giới hạn</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="color-preview d-inline-block" 
                                                      style="width: 30px; height: 30px; background-color: {{ $vipLevel->color }}; border-radius: 50%; border: 2px solid #ddd;"></span>
                                                <small class="ml-2">{{ $vipLevel->color }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $vipLevel->users()->count() }}</span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.vip.toggle', $vipLevel) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $vipLevel->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                        {{ $vipLevel->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $vipLevel->sort_order }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.vip.show', $vipLevel) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.vip.edit', $vipLevel) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteVipLevel({{ $vipLevel->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Chưa có VIP Level nào</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa VIP Level này không?</p>
                <p class="text-warning"><small>Lưu ý: Chỉ có thể xóa VIP Level không có người dùng nào sử dụng.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteVipLevel(id) {
    $('#deleteForm').attr('action', `/admin/vip/${id}`);
    $('#deleteModal').modal('show');
}

function updateAllVipLevels() {
    if (confirm('Bạn có chắc chắn muốn cập nhật VIP level cho tất cả người dùng?')) {
        $.post('{{ route("admin.vip.update-all") }}', {
            _token: '{{ csrf_token() }}'
        })
        .done(function(data) {
            location.reload();
        })
        .fail(function() {
            alert('Có lỗi xảy ra!');
        });
    }
}
</script>
@endpush
@endsection