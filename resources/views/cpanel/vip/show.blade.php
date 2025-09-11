@extends('cpanel.layouts.app')

@section('title', 'Chi tiết VIP Level')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết VIP Level</h1>
        <a href="{{ route('cpanel.vip.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <!-- VIP Level Info -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin VIP Level</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Hành động:</div>
                            <a class="dropdown-item" href="#" onclick="editVipLevel({{ $vipLevel->id }})">
                                <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                Chỉnh sửa
                            </a>
                            <a class="dropdown-item" href="#" onclick="uploadIcon({{ $vipLevel->id }})">
                                <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i>
                                Tải lên Icon
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" onclick="deleteVipLevel({{ $vipLevel->id }})">
                                <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="font-weight-bold">Tên VIP Level:</label>
                                <p class="text-gray-800" style="color: {{ $vipLevel->color }} !important; font-weight: bold;">
                                    {{ $vipLevel->name }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Level:</label>
                                <p class="text-gray-800">
                                    <span class="badge badge-primary badge-pill">{{ $vipLevel->level }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Yêu cầu nạp tiền:</label>
                                <p class="text-gray-800">
                                    <span class="text-success font-weight-bold">${{ number_format($vipLevel->required_deposit, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="font-weight-bold">Màu sắc:</label>
                                <p class="text-gray-800">
                                    <div class="d-flex align-items-center">
                                        <div class="color-box mr-2" style="width: 30px; height: 30px; background-color: {{ $vipLevel->color }}; border-radius: 5px; border: 1px solid #ddd;"></div>
                                        <code>{{ $vipLevel->color }}</code>
                                    </div>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Icon:</label>
                                <p class="text-gray-800">
                                    @if($vipLevel->icon)
                                        <img src="{{ $vipLevel->icon_url }}" alt="{{ $vipLevel->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <i class="fas fa-crown text-muted fa-2x"></i>
                                        <small class="text-muted d-block">Chưa có icon</small>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Trạng thái:</label>
                                <p class="text-gray-800">
                                    @if($vipLevel->is_active)
                                        <span class="badge badge-success">Đang hoạt động</span>
                                    @else
                                        <span class="badge badge-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($vipLevel->benefits && count($vipLevel->benefits) > 0)
                    <div class="mb-3">
                        <label class="font-weight-bold">Đặc quyền:</label>
                        <ul class="list-group list-group-flush">
                            @foreach($vipLevel->benefits as $benefit)
                            <li class="list-group-item px-0">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                {{ $benefit }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="font-weight-bold">Ngày tạo:</label>
                                <p class="text-gray-800">{{ $vipLevel->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="font-weight-bold">Cập nhật cuối:</label>
                                <p class="text-gray-800">{{ $vipLevel->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <div class="h4 mb-0 font-weight-bold text-primary">{{ $vipLevel->users->count() }}</div>
                        <div class="text-xs font-weight-bold text-uppercase text-gray-500">Số người dùng</div>
                    </div>
                    
                    @php
                        $totalUsers = \App\Models\User::count();
                        $percentage = $totalUsers > 0 ? ($vipLevel->users->count() / $totalUsers) * 100 : 0;
                    @endphp
                    
                    <div class="mb-3">
                        <div class="small text-gray-500">Tỷ lệ so với tổng user</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="small text-gray-500 mt-1">{{ number_format($percentage, 1) }}%</div>
                    </div>

                    @if($vipLevel->users->count() > 0)
                    <div class="mb-3">
                        <div class="small text-gray-500 mb-2">Tổng tiền nạp của nhóm này:</div>
                        <div class="h6 mb-0 font-weight-bold text-success">
                            ${{ number_format($vipLevel->users->sum('total_deposit'), 0, ',', '.') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hành động nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm btn-block" onclick="editVipLevel({{ $vipLevel->id }})">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </button>
                        <button class="btn btn-info btn-sm btn-block" onclick="uploadIcon({{ $vipLevel->id }})">
                            <i class="fas fa-image"></i> Cập nhật Icon
                        </button>
                        <button class="btn btn-warning btn-sm btn-block" onclick="toggleStatus({{ $vipLevel->id }})">
                            <i class="fas fa-toggle-{{ $vipLevel->is_active ? 'on' : 'off' }}"></i> 
                            {{ $vipLevel->is_active ? 'Tắt' : 'Bật' }} hoạt động
                        </button>
                        <button class="btn btn-success btn-sm btn-block" onclick="updateUsersForThisLevel({{ $vipLevel->id }})">
                            <i class="fas fa-sync-alt"></i> Cập nhật Users
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users List -->
    @if($vipLevel->users->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng ({{ $vipLevel->users->count() }})</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Tổng nạp</th>
                            <th>Ngày tham gia</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vipLevel->users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="text-success font-weight-bold">
                                    ${{ number_format($user->total_deposit, 2) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('cpanel.user.show', $user->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable for users
    $('#usersTable').DataTable({
        pageLength: 25,
        responsive: true,
        order: [[4, 'desc']] // Order by join date
    });
});

function editVipLevel(id) {
    // Redirect to edit page or open modal
    window.location.href = `{{ route('cpanel.vip.index') }}#edit-${id}`;
}

function uploadIcon(id) {
    // Open upload modal
    $('#uploadIconModal').modal('show');
}

function toggleStatus(id) {
    if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái của VIP Level này?')) {
        $.ajax({
            url: `/cpanel/vip/${id}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra khi cập nhật trạng thái');
            }
        });
    }
}

function updateUsersForThisLevel(id) {
    if (confirm('Bạn có chắc chắn muốn cập nhật lại VIP level cho tất cả người dùng?')) {
        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...';
        
        $.ajax({
            url: '{{ route("cpanel.vip.update-all-users") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra khi cập nhật');
            },
            complete: function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt"></i> Cập nhật Users';
            }
        });
    }
}

function deleteVipLevel(id) {
    if (confirm('Bạn có chắc chắn muốn xóa VIP Level này? Hành động này không thể hoàn tác.')) {
        $.ajax({
            url: `/cpanel/vip/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                window.location.href = '{{ route("cpanel.vip.index") }}';
            },
            error: function(xhr) {
                const error = xhr.responseJSON.error || 'Có lỗi xảy ra';
                alert(error);
            }
        });
    }
}
</script>
@endpush
@endsection