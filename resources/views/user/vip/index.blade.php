@extends('user.layout.app')

@section('title', 'VIP Welfare')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="relative inline-block">
                <img src="{{ asset('images/app/vip-astronaut.png') }}" alt="VIP Astronaut" class="w-64 h-64 mx-auto mb-6">
                <div class="absolute inset-0 bg-gradient-to-t from-transparent to-cyan-500/20 rounded-full"></div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">VIPWelfare</h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                Warm reminder: as long as you reach the recharge amount, you can click the receive button to receive VIPWelfare rewards
            </p>
        </div>

        <!-- Current VIP Status -->
        @if($currentVipLevel)
        <div class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 border border-cyan-500/30 rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-white" 
                         style="background: {{ $currentVipLevel->color }}">
                        {{ $currentVipLevel->name }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $currentVipLevel->display_name }}</h3>
                        <p class="text-cyan-400">Cấp độ hiện tại của bạn</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-400">Tổng nạp tiền</p>
                    <p class="text-2xl font-bold text-white">${{ number_format($user->total_deposit, 2) }}</p>
                </div>
            </div>
            
            @if($nextVipLevel)
            <div class="mt-6">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-400">Tiến độ lên {{ $nextVipLevel->display_name }}</span>
                    <span class="text-cyan-400">{{ number_format($progressPercent, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $progressPercent }}%"></div>
                </div>
                <p class="text-gray-400 text-sm mt-2">
                    Cần thêm ${{ number_format($nextVipLevel->min_deposit - $user->total_deposit, 2) }} để lên cấp tiếp theo
                </p>
            </div>
            @endif
        </div>
        @endif

        <!-- VIP Levels Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vipLevels as $vipLevel)
            <div class="relative group">
                <!-- VIP Card -->
                <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-2xl p-6 border border-gray-700 hover:border-cyan-500/50 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <!-- VIP Level Badge -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold text-white"
                                 style="background: {{ $vipLevel->color }}">
                                {{ $vipLevel->name }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $vipLevel->display_name }}</h3>
                                <p class="text-gray-400 text-sm">Member</p>
                            </div>
                        </div>
                        @if($currentVipLevel && $currentVipLevel->id === $vipLevel->id)
                        <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full">Hiện tại</span>
                        @elseif($user->qualifiesForVipLevel($vipLevel->id))
                        <span class="bg-cyan-500 text-white text-xs px-3 py-1 rounded-full">Đủ điều kiện</span>
                        @endif
                    </div>

                    <!-- Requirements -->
                    <div class="mb-6">
                        <div class="text-center">
                            <p class="text-gray-400 text-sm mb-2">Nạp tiền cần đạt</p>
                            <p class="text-2xl font-bold text-white">
                                ${{ number_format($vipLevel->min_deposit, 0) }}
                                @if($vipLevel->max_deposit)
                                - ${{ number_format($vipLevel->max_deposit, 0) }}
                                @endif
                                <span class="text-yellow-400">USDT</span>
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-400 text-sm mb-2">Phần thưởng VIPWelfare</p>
                            <p class="text-lg font-bold text-cyan-400">
                                ${{ number_format($vipLevel->min_deposit * 0.1, 0) }}.00 USDT
                            </p>
                        </div>
                    </div>

                    <!-- Benefits -->
                    @if($vipLevel->benefits_list && count($vipLevel->benefits_list) > 0)
                    <div class="mb-6">
                        <h4 class="text-white font-semibold mb-3">Quyền lợi:</h4>
                        <ul class="space-y-2">
                            @foreach($vipLevel->benefits_list as $benefit)
                            <li class="flex items-center text-gray-300 text-sm">
                                <i class="fas fa-check text-green-400 mr-2"></i>
                                {{ $benefit }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Action Button -->
                    <div class="text-center">
                        @if($user->qualifiesForVipLevel($vipLevel->id))
                            @if($currentVipLevel && $currentVipLevel->id === $vipLevel->id)
                            <button class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold">
                                <i class="fas fa-crown mr-2"></i>
                                Cấp độ hiện tại
                            </button>
                            @else
                            <button class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 receive-reward-btn" 
                                    data-level-id="{{ $vipLevel->id }}">
                                <i class="fas fa-gift mr-2"></i>
                                Nhận thưởng
                            </button>
                            @endif
                        @else
                        <button class="w-full bg-gray-600 text-gray-400 py-3 px-6 rounded-lg font-semibold cursor-not-allowed" disabled>
                            <i class="fas fa-lock mr-2"></i>
                            Chưa đủ điều kiện
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Glow Effect for Current Level -->
                @if($currentVipLevel && $currentVipLevel->id === $vipLevel->id)
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-2xl blur-xl -z-10"></div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Footer Info -->
        <div class="mt-12 text-center">
            <p class="text-gray-400 text-sm">
                Multi-platform terminal transactions anytime, anywhere. Perfectly compatible with multiple terminals, it can meet the transaction needs of various scenarios at any time.
            </p>
        </div>
    </div>
</div>

<!-- Receive Reward Modal -->
<div id="rewardModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-2xl p-8 max-w-md w-full mx-4 border border-cyan-500/30">
        <div class="text-center">
            <div class="w-20 h-20 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-gift text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Chúc mừng!</h3>
            <p class="text-gray-300 mb-6">Bạn đã nhận được phần thưởng VIP Welfare</p>
            
            <div class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 rounded-lg p-4 mb-6">
                <p class="text-cyan-400 text-lg font-bold" id="rewardAmount">+$0.00 USDT</p>
            </div>
            
            <button id="closeRewardModal" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300">
                Tuyệt vời!
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const receiveButtons = document.querySelectorAll('.receive-reward-btn');
    const rewardModal = document.getElementById('rewardModal');
    const closeRewardModal = document.getElementById('closeRewardModal');
    const rewardAmount = document.getElementById('rewardAmount');
    
    receiveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const levelId = this.dataset.levelId;
            
            // Simulate API call
            fetch(`/vip/receive-reward/${levelId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    rewardAmount.textContent = `+$${data.amount} USDT`;
                    rewardModal.classList.remove('hidden');
                    rewardModal.classList.add('flex');
                    
                    // Update button state
                    this.innerHTML = '<i class="fas fa-check mr-2"></i>Đã nhận';
                    this.classList.remove('bg-gradient-to-r', 'from-cyan-500', 'to-blue-500', 'hover:from-cyan-600', 'hover:to-blue-600');
                    this.classList.add('bg-green-600', 'cursor-not-allowed');
                    this.disabled = true;
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra');
            });
        });
    });
    
    closeRewardModal.addEventListener('click', function() {
        rewardModal.classList.add('hidden');
        rewardModal.classList.remove('flex');
        location.reload(); // Refresh to update user balance
    });
});
</script>
@endpush
@endsection