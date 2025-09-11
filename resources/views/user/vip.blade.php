@extends('user.layouts.app')

@section('title', 'VIP Center')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white">
    <!-- Header Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-purple-900 via-blue-900 to-indigo-900">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="relative container mx-auto px-6 py-16">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-600 bg-clip-text text-transparent">
                    VIP CENTER
                </h1>
                <p class="text-xl text-gray-300 mb-8">Trải nghiệm đẳng cấp với những đặc quyền độc quyền</p>
            </div>

            <!-- Current VIP Status -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center">
                                @if($currentVipLevel && $currentVipLevel->icon)
                                    <img src="{{ $currentVipLevel->icon_url }}" alt="{{ $currentVipLevel->name }}" class="w-10 h-10">
                                @else
                                    <i class="fas fa-crown text-2xl text-white"></i>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">{{ $currentVipLevel ? $currentVipLevel->name : 'VIP 0' }}</h2>
                                <p class="text-gray-300">Cấp độ hiện tại của bạn</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-400">Tổng nạp tiền</p>
                            <p class="text-2xl font-bold text-green-400">${{ number_format($totalDeposit, 2) }}</p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @if($nextLevel)
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-300">Tiến độ đến {{ $nextLevel->name }}</span>
                            <span class="text-sm text-gray-300">{{ number_format($progressPercentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-1000" 
                                 style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm text-gray-400">
                            <span>${{ number_format($currentVipLevel ? $currentVipLevel->required_deposit : 0) }}</span>
                            <span>${{ number_format($nextLevel->required_deposit) }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Next Level Info -->
                    @if($nextLevel)
                    <div class="bg-gradient-to-r from-blue-500/20 to-purple-600/20 rounded-2xl p-6 border border-blue-500/30">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-blue-300">{{ $nextLevel->name }}</h3>
                                <p class="text-gray-300">Cần nạp thêm: <span class="font-bold text-yellow-400">${{ number_format($amountNeededForNext, 2) }}</span></p>
                            </div>
                            @if($canUpgrade)
                            <button id="upgradeBtn" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                                Nâng cấp ngay
                            </button>
                            @else
                            <a href="{{ route('deposit') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                                Nạp tiền
                            </a>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="bg-gradient-to-r from-yellow-500/20 to-orange-600/20 rounded-2xl p-6 border border-yellow-500/30 text-center">
                        <div class="text-2xl mb-2">🎉</div>
                        <h3 class="text-lg font-semibold text-yellow-300 mb-2">Chúc mừng!</h3>
                        <p class="text-gray-300">Bạn đã đạt cấp độ VIP cao nhất</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- VIP Levels Section -->
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4">Các Cấp Độ VIP</h2>
            <p class="text-gray-400 text-lg">Khám phá những đặc quyền độc quyền tại mỗi cấp độ</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($allVipLevels as $vipLevel)
            <div class="relative group">
                <!-- Card -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 border border-gray-700 hover:border-{{ $vipLevel->color ?? 'purple' }}-500/50 transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-{{ $vipLevel->color ?? 'purple' }}-500/25 {{ $currentVipLevel && $currentVipLevel->id == $vipLevel->id ? 'ring-2 ring-yellow-400 bg-gradient-to-br from-yellow-500/10 to-orange-600/10' : '' }}">
                    
                    <!-- VIP Badge -->
                    @if($currentVipLevel && $currentVipLevel->id == $vipLevel->id)
                    <div class="absolute -top-3 -right-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-black px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                        HIỆN TẠI
                    </div>
                    @endif

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-{{ $vipLevel->color ?? 'purple' }}-500 to-{{ $vipLevel->color ?? 'blue' }}-600 flex items-center justify-center shadow-lg">
                            @if($vipLevel->icon)
                                <img src="{{ $vipLevel->icon_url }}" alt="{{ $vipLevel->name }}" class="w-12 h-12">
                            @else
                                <i class="fas fa-crown text-3xl text-white"></i>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold mb-2" style="color: {{ $vipLevel->color ?? '#ffffff' }}">{{ $vipLevel->name }}</h3>
                        <div class="text-3xl font-bold text-white mb-2">${{ $vipLevel->formatted_required_deposit }}</div>
                        <p class="text-gray-400 text-sm">Yêu cầu nạp tối thiểu</p>
                    </div>

                    <!-- Benefits -->
                    @if($vipLevel->benefits)
                    <div class="space-y-3">
                        <h4 class="font-semibold text-gray-300 mb-4 text-center">🎁 Đặc Quyền</h4>
                        @foreach($vipLevel->benefits as $benefit)
                        <div class="flex items-center space-x-3 text-gray-300">
                            <div class="w-2 h-2 rounded-full bg-gradient-to-r from-{{ $vipLevel->color ?? 'purple' }}-500 to-{{ $vipLevel->color ?? 'blue' }}-600"></div>
                            <span class="text-sm">{{ $benefit }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Action Button -->
                    <div class="mt-8 text-center">
                        @if($currentVipLevel && $currentVipLevel->id == $vipLevel->id)
                            <div class="bg-gradient-to-r from-green-500/20 to-emerald-600/20 border border-green-500/30 text-green-400 px-6 py-3 rounded-xl font-semibold">
                                ✓ Đã đạt được
                            </div>
                        @elseif($totalDeposit >= $vipLevel->required_deposit)
                            <button class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg" onclick="upgradeToLevel({{ $vipLevel->id }})">
                                Nâng cấp
                            </button>
                        @else
                            <div class="bg-gray-700/50 border border-gray-600 text-gray-400 px-6 py-3 rounded-xl font-semibold">
                                Cần ${{ number_format($vipLevel->required_deposit - $totalDeposit, 2) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Benefits Overview Section -->
    <div class="bg-gradient-to-r from-purple-900/30 to-blue-900/30 py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Tại Sao Chọn VIP?</h2>
                <p class="text-gray-400 text-lg">Những lợi ích độc quyền dành riêng cho thành viên VIP</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-percentage text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Phí Giao Dịch Thấp</h3>
                    <p class="text-gray-400">Giảm đến 50% phí giao dịch cho thành viên VIP cao cấp</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-headset text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Hỗ Trợ Ưu Tiên</h3>
                    <p class="text-gray-400">Đội ngũ hỗ trợ chuyên biệt 24/7 dành riêng cho VIP</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bolt text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Rút Tiền Nhanh</h3>
                    <p class="text-gray-400">Xử lý rút tiền ưu tiên trong vòng 1 giờ</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-pink-400 to-red-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gift text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Quà Tặng Độc Quyền</h3>
                    <p class="text-gray-400">Nhận quà tặng và bonus đặc biệt hàng tháng</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Upgrade button functionality
    const upgradeBtn = document.getElementById('upgradeBtn');
    if (upgradeBtn) {
        upgradeBtn.addEventListener('click', function() {
            upgradeVip();
        });
    }
});

function upgradeVip() {
    fetch('{{ route("vip.upgrade") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            if (typeof Toastify !== 'undefined') {
                Toastify({
                    text: data.message,
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #10b981, #059669)",
                    }
                }).showToast();
            } else {
                alert(data.message);
            }
            
            // Reload page after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            // Show error message
            if (typeof Toastify !== 'undefined') {
                Toastify({
                    text: data.message,
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #ef4444, #dc2626)",
                    }
                }).showToast();
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Toastify !== 'undefined') {
            Toastify({
                text: "Có lỗi xảy ra. Vui lòng thử lại.",
                duration: 3000,
                gravity: "top",
                style: {
                    background: "linear-gradient(to right, #ef4444, #dc2626)",
                }
            }).showToast();
        } else {
            alert("Có lỗi xảy ra. Vui lòng thử lại.");
        }
    });
}

function upgradeToLevel(levelId) {
    // This function can be implemented if you want direct level upgrade functionality
    upgradeVip();
}
</script>
@endpush
@endsection