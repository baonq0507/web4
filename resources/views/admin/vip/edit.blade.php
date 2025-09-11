@extends('admin.layout.app')

@section('title', 'Chỉnh sửa VIP Level')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa VIP Level</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vip.index') }}">VIP Levels</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chỉnh sửa VIP Level: {{ $vipLevel->name }}</h3>
                        </div>
                        
                        <form method="POST" action="{{ route('admin.vip.update', $vipLevel) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tên VIP Level <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $vipLevel->name) }}" 
                                                   placeholder="VD: V1, V2, V3">
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="display_name">Tên hiển thị <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                                   id="display_name" name="display_name" value="{{ old('display_name', $vipLevel->display_name) }}" 
                                                   placeholder="VD: Member, Premium, VIP">
                                            @error('display_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_deposit">Nạp tiền tối thiểu ($) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('min_deposit') is-invalid @enderror" 
                                                   id="min_deposit" name="min_deposit" value="{{ old('min_deposit', $vipLevel->min_deposit) }}">
                                            @error('min_deposit')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_deposit">Nạp tiền tối đa ($)</label>
                                            <input type="number" step="0.01" class="form-control @error('max_deposit') is-invalid @enderror" 
                                                   id="max_deposit" name="max_deposit" value="{{ old('max_deposit', $vipLevel->max_deposit) }}" 
                                                   placeholder="Để trống nếu không giới hạn">
                                            @error('max_deposit')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="color">Màu sắc <span class="text-danger">*</span></label>
                                            <input type="color" class="form-control @error('color') is-invalid @enderror" 
                                                   id="color" name="color" value="{{ old('color', $vipLevel->color) }}">
                                            @error('color')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sort_order">Thứ tự sắp xếp <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $vipLevel->sort_order) }}">
                                            @error('sort_order')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="icon">Icon (Class CSS)</label>
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" name="icon" value="{{ old('icon', $vipLevel->icon) }}" 
                                           placeholder="VD: fas fa-crown">
                                    @error('icon')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Quyền lợi</label>
                                    <div id="benefits-container">
                                        @if($vipLevel->benefits_list && count($vipLevel->benefits_list) > 0)
                                            @foreach($vipLevel->benefits_list as $benefit)
                                            <div class="benefit-item mb-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="benefits[]" 
                                                           value="{{ $benefit }}" placeholder="Nhập quyền lợi...">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger remove-benefit">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="benefit-item mb-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="benefits[]" 
                                                           placeholder="Nhập quyền lợi...">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger remove-benefit">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm" id="add-benefit">
                                        <i class="fas fa-plus"></i> Thêm quyền lợi
                                    </button>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                               {{ old('is_active', $vipLevel->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Kích hoạt</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('admin.vip.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Preview</h3>
                        </div>
                        <div class="card-body">
                            <div class="vip-preview text-center p-3 border rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="vip-badge mb-3">
                                    <span id="preview-badge" class="badge badge-lg px-3 py-2" style="background-color: {{ $vipLevel->color }}; color: white; font-size: 16px;">
                                        {{ $vipLevel->name }}
                                    </span>
                                </div>
                                <h4 id="preview-display-name" class="text-white mb-2">{{ $vipLevel->display_name }}</h4>
                                <p class="text-light mb-3">
                                    Nạp từ: $<span id="preview-min">{{ number_format($vipLevel->min_deposit, 0) }}</span>
                                    <span id="preview-max-text">
                                        @if($vipLevel->max_deposit)
                                        - $<span id="preview-max">{{ number_format($vipLevel->max_deposit, 0) }}</span>
                                        @endif
                                    </span>
                                </p>
                                <div id="preview-benefits" class="text-left">
                                    <small class="text-light">Quyền lợi:</small>
                                    <ul id="preview-benefits-list" class="text-light mt-1" style="font-size: 12px;">
                                        @foreach($vipLevel->benefits_list as $benefit)
                                        <li>{{ $benefit }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-users"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Số người dùng</span>
                                    <span class="info-box-number">{{ $vipLevel->users()->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Add benefit
    $('#add-benefit').click(function() {
        const benefitItem = `
            <div class="benefit-item mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="benefits[]" placeholder="Nhập quyền lợi...">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-benefit">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#benefits-container').append(benefitItem);
        updatePreview();
    });

    // Remove benefit
    $(document).on('click', '.remove-benefit', function() {
        $(this).closest('.benefit-item').remove();
        updatePreview();
    });

    // Update preview on input change
    $('#name, #display_name, #min_deposit, #max_deposit, #color').on('input', updatePreview);
    $(document).on('input', 'input[name="benefits[]"]', updatePreview);

    function updatePreview() {
        const name = $('#name').val() || 'V1';
        const displayName = $('#display_name').val() || 'Member';
        const minDeposit = $('#min_deposit').val() || '0';
        const maxDeposit = $('#max_deposit').val();
        const color = $('#color').val() || '#FFD700';
        
        $('#preview-badge').text(name).css('background-color', color);
        $('#preview-display-name').text(displayName);
        $('#preview-min').text(parseFloat(minDeposit).toLocaleString());
        
        if (maxDeposit) {
            $('#preview-max').text(parseFloat(maxDeposit).toLocaleString());
            $('#preview-max-text').show();
        } else {
            $('#preview-max-text').hide();
        }
        
        // Update benefits
        const benefits = [];
        $('input[name="benefits[]"]').each(function() {
            if ($(this).val().trim()) {
                benefits.push($(this).val().trim());
            }
        });
        
        $('#preview-benefits-list').empty();
        benefits.forEach(function(benefit) {
            $('#preview-benefits-list').append(`<li>${benefit}</li>`);
        });
        
        if (benefits.length === 0) {
            $('#preview-benefits').hide();
        } else {
            $('#preview-benefits').show();
        }
    }

    // Initial preview update
    updatePreview();
});
</script>
@endpush
@endsection