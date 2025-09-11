@extends('cpanel.layouts.app')

@section('title', 'Quản lý VIP Levels')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý VIP Levels</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" id="updateAllUsersBtn">
                <i class="fas fa-sync-alt"></i> Cập nhật VIP cho tất cả User
            </button>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addVipModal">
                <i class="fas fa-plus"></i> Thêm VIP Level
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4" id="statsCards">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng VIP Levels</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalVipLevels">{{ $vipLevels->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-crown fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Levels Đang Hoạt Động</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeVipLevels">{{ $vipLevels->where('is_active', true)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng User VIP</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalVipUsers">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Level Cao Nhất</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vipLevels->max('level') ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIP Levels Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách VIP Levels</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="vipLevelsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>Tên</th>
                            <th>Yêu cầu nạp</th>
                            <th>Số User</th>
                            <th>Màu sắc</th>
                            <th>Icon</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vipLevels as $vipLevel)
                        <tr data-id="{{ $vipLevel->id }}">
                            <td>
                                <span class="badge badge-primary badge-pill">{{ $vipLevel->level }}</span>
                            </td>
                            <td>
                                <strong style="color: {{ $vipLevel->color }}">{{ $vipLevel->name }}</strong>
                            </td>
                            <td>
                                <span class="text-success font-weight-bold">${{ number_format($vipLevel->required_deposit, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $vipLevel->users->count() }} users</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="color-box mr-2" style="width: 20px; height: 20px; background-color: {{ $vipLevel->color }}; border-radius: 3px; border: 1px solid #ddd;"></div>
                                    <small>{{ $vipLevel->color }}</small>
                                </div>
                            </td>
                            <td>
                                @if($vipLevel->icon)
                                    <img src="{{ $vipLevel->icon_url }}" alt="{{ $vipLevel->name }}" style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    <i class="fas fa-crown text-muted"></i>
                                @endif
                            </td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input status-toggle" 
                                           id="status{{ $vipLevel->id }}" 
                                           data-id="{{ $vipLevel->id }}" 
                                           {{ $vipLevel->is_active ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status{{ $vipLevel->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info edit-btn" data-id="{{ $vipLevel->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning upload-icon-btn" data-id="{{ $vipLevel->id }}">
                                        <i class="fas fa-image"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $vipLevel->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add VIP Modal -->
<div class="modal fade" id="addVipModal" tabindex="-1" role="dialog" aria-labelledby="addVipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVipModalLabel">Thêm VIP Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addVipForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên VIP Level <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="VIP 1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level">Level <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="level" name="level" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="required_deposit">Yêu cầu nạp tiền ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="required_deposit" name="required_deposit" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">Màu sắc</label>
                                <input type="color" class="form-control" id="color" name="color" value="#ffffff">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="benefits">Đặc quyền (mỗi dòng một đặc quyền)</label>
                        <textarea class="form-control" id="benefits" name="benefits" rows="4" placeholder="Giảm phí giao dịch 10%&#10;Hỗ trợ ưu tiên&#10;Rút tiền nhanh"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                            <label class="custom-control-label" for="is_active">Kích hoạt</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm VIP Level</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit VIP Modal -->
<div class="modal fade" id="editVipModal" tabindex="-1" role="dialog" aria-labelledby="editVipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVipModalLabel">Chỉnh sửa VIP Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editVipForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_vip_id" name="vip_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name">Tên VIP Level <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_level">Level <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_level" name="level" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_required_deposit">Yêu cầu nạp tiền ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_required_deposit" name="required_deposit" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_color">Màu sắc</label>
                                <input type="color" class="form-control" id="edit_color" name="color">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_benefits">Đặc quyền (mỗi dòng một đặc quyền)</label>
                        <textarea class="form-control" id="edit_benefits" name="benefits" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="edit_is_active" name="is_active">
                            <label class="custom-control-label" for="edit_is_active">Kích hoạt</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Icon Modal -->
<div class="modal fade" id="uploadIconModal" tabindex="-1" role="dialog" aria-labelledby="uploadIconModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadIconModalLabel">Tải lên Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadIconForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="icon_vip_id" name="vip_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="icon">Chọn file icon</label>
                        <input type="file" class="form-control-file" id="icon" name="icon" accept="image/*" required>
                        <small class="form-text text-muted">Chỉ chấp nhận file ảnh (jpeg, png, jpg, gif). Tối đa 2MB.</small>
                    </div>
                    <div id="iconPreview" class="text-center" style="display: none;">
                        <img id="previewImage" src="" alt="Preview" style="max-width: 100px; max-height: 100px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#vipLevelsTable').DataTable({
        order: [[0, 'asc']],
        pageLength: 25,
        responsive: true
    });

    // Load stats
    loadStats();

    // Add VIP Level
    $('#addVipForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const benefits = $('#benefits').val().split('\n').filter(benefit => benefit.trim() !== '');
        
        // Convert benefits to array
        formData.delete('benefits');
        benefits.forEach((benefit, index) => {
            formData.append(`benefits[${index}]`, benefit.trim());
        });

        $.ajax({
            url: '/cpanel/vip',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#addVipModal').modal('hide');
                showAlert('success', response.message);
                location.reload();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.error;
                let errorMessage = 'Có lỗi xảy ra';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                showAlert('error', errorMessage);
            }
        });
    });

    // Edit VIP Level
    $(document).on('click', '.edit-btn', function() {
        const vipId = $(this).data('id');
        
        $.ajax({
            url: `/cpanel/vip/${vipId}`,
            method: 'GET',
            success: function(response) {
                // Populate edit form with current data
                $('#edit_vip_id').val(response.id);
                $('#edit_name').val(response.name);
                $('#edit_level').val(response.level);
                $('#edit_required_deposit').val(response.required_deposit);
                $('#edit_color').val(response.color);
                $('#edit_is_active').prop('checked', response.is_active);
                
                // Handle benefits array
                if (response.benefits && Array.isArray(response.benefits)) {
                    $('#edit_benefits').val(response.benefits.join('\n'));
                }
                
                $('#editVipModal').modal('show');
            },
            error: function(xhr) {
                showAlert('error', 'Không thể tải thông tin VIP Level');
            }
        });
    });

    // Update VIP Level
    $('#editVipForm').on('submit', function(e) {
        e.preventDefault();
        
        const vipId = $('#edit_vip_id').val();
        const formData = new FormData(this);
        const benefits = $('#edit_benefits').val().split('\n').filter(benefit => benefit.trim() !== '');
        
        // Convert benefits to array
        formData.delete('benefits');
        benefits.forEach((benefit, index) => {
            formData.append(`benefits[${index}]`, benefit.trim());
        });

        $.ajax({
            url: `/cpanel/vip/${vipId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editVipModal').modal('hide');
                showAlert('success', response.message);
                location.reload();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.error;
                let errorMessage = 'Có lỗi xảy ra';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                showAlert('error', errorMessage);
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.status-toggle', function() {
        const vipId = $(this).data('id');
        
        $.ajax({
            url: `/cpanel/vip/${vipId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                showAlert('success', response.message);
                loadStats();
            },
            error: function(xhr) {
                showAlert('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
                // Revert toggle
                $(this).prop('checked', !$(this).prop('checked'));
            }
        });
    });

    // Delete VIP Level
    $(document).on('click', '.delete-btn', function() {
        const vipId = $(this).data('id');
        
        if (confirm('Bạn có chắc chắn muốn xóa VIP Level này?')) {
            $.ajax({
                url: `/cpanel/vip/${vipId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('success', response.message);
                    location.reload();
                },
                error: function(xhr) {
                    const error = xhr.responseJSON.error || 'Có lỗi xảy ra';
                    showAlert('error', error);
                }
            });
        }
    });

    // Upload Icon
    $(document).on('click', '.upload-icon-btn', function() {
        const vipId = $(this).data('id');
        $('#icon_vip_id').val(vipId);
        $('#uploadIconModal').modal('show');
    });

    // Preview icon before upload
    $('#icon').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#iconPreview').show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Upload Icon Form
    $('#uploadIconForm').on('submit', function(e) {
        e.preventDefault();
        
        const vipId = $('#icon_vip_id').val();
        const formData = new FormData(this);

        $.ajax({
            url: `/cpanel/vip/${vipId}/upload-icon`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#uploadIconModal').modal('hide');
                showAlert('success', response.message);
                location.reload();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.error;
                let errorMessage = 'Có lỗi xảy ra';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                showAlert('error', errorMessage);
            }
        });
    });

    // Update All Users VIP
    $('#updateAllUsersBtn').on('click', function() {
        if (confirm('Bạn có chắc chắn muốn cập nhật VIP level cho tất cả người dùng dựa trên tổng tiền nạp?')) {
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...');
            
            $.ajax({
                url: '/cpanel/vip/update-all-users',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('success', response.message);
                    loadStats();
                },
                error: function(xhr) {
                    showAlert('error', 'Có lỗi xảy ra khi cập nhật');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Cập nhật VIP cho tất cả User');
                }
            });
        }
    });

    function loadStats() {
        $.ajax({
            url: '/cpanel/vip/stats',
            method: 'GET',
            success: function(response) {
                $('#totalVipLevels').text(response.total_vip_levels);
                $('#activeVipLevels').text(response.active_vip_levels);
                $('#totalVipUsers').text(response.total_vip_users);
            }
        });
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert
        $('.container-fluid').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
});
</script>
@endpush
@endsection