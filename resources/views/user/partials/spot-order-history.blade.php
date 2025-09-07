@if($history->count() > 0)
    @foreach($history as $trade)
    <div class="spot-trade-item bg-[#181a20] rounded-lg p-4 mb-3 border-l-4 {{ $trade->type === 'buy' ? 'border-[#3ddeea]' : 'border-[#e04b48]' }} hover:bg-[#2a2d38] transition-all duration-200">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#232428] flex items-center justify-center">
                    <img src="{{ $trade->symbol->image ?? asset('images/symbols/default.png') }}" 
                         alt="{{ $trade->symbol->symbol ?? 'N/A' }}" 
                         class="w-6 h-6 rounded-full">
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm">{{ $trade->symbol->symbol ?? 'N/A' }}/USDT</h4>
                    <p class="text-gray-400 text-xs">Order #{{ $trade->id }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $trade->type === 'buy' ? 'bg-[#3ddeea]/20 text-[#3ddeea]' : 'bg-[#e04b48]/20 text-[#e04b48]' }}">
                    {{ ucfirst($trade->type) }}
                </span>
                <div class="mt-1">
                    <span class="inline-block px-2 py-1 rounded text-xs font-medium 
                        {{ $trade->status === 'completed' ? 'bg-green-500/20 text-green-400' : 
                           ($trade->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                        {{ ucfirst($trade->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-3">
            <div class="text-center">
                <p class="text-gray-400 text-xs mb-1">Amount</p>
                <p class="text-white font-semibold text-sm">{{ number_format($trade->amount, 6) }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-400 text-xs mb-1">Price</p>
                <p class="text-white font-semibold text-sm">${{ number_format($trade->price, 2) }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-400 text-xs mb-1">Total Value</p>
                <p class="text-white font-semibold text-sm">${{ number_format($trade->total_value, 2) }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-400 text-xs mb-1">Commission</p>
                <p class="text-white font-semibold text-sm">${{ number_format($trade->commission, 2) }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between text-xs text-gray-400">
            <div class="flex items-center gap-4">
                <span>Order Type: <span class="text-white">{{ ucfirst($trade->order_type) }}</span></span>
                @if($trade->limit_price)
                <span>Limit: <span class="text-white">${{ number_format($trade->limit_price, 2) }}</span></span>
                @endif
            </div>
            <div class="text-right">
                <p>Trade Date: {{ $trade->trade_at ? $trade->trade_at->format('M d, Y H:i') : 'N/A' }}</p>
                <p>Created: {{ $trade->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        @if($trade->status === 'pending')
        <div class="mt-3 pt-3 border-t border-[#232428]">
            <div class="flex items-center justify-between">
                <span class="text-yellow-400 text-sm">Order is pending...</span>
                <button class="cancel-order-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors duration-200"
                        data-order-id="{{ $trade->id }}">
                    Cancel Order
                </button>
            </div>
        </div>
        @endif
    </div>
    @endforeach

    @if($history->hasMorePages())
    <div class="text-center mt-6">
        <button class="load-more-spot-orders bg-[#3ddeea] text-[#181a20] py-3 px-6 rounded-lg font-semibold hover:bg-[#2bb8c4] transition-colors duration-300" 
                data-page="{{ $history->currentPage() + 1 }}">
            <i class="fas fa-sync-alt mr-2"></i>Load More Orders
        </button>
    </div>
    @endif
@else
<div class="text-center py-12">
    <div class="w-20 h-20 mx-auto mb-4 bg-[#232428] rounded-full flex items-center justify-center">
        <i class="fas fa-chart-line text-3xl text-gray-400"></i>
    </div>
    <h3 class="text-white text-lg font-semibold mb-2">No Orders Found</h3>
    <p class="text-gray-400 text-sm">You haven't placed any spot trading orders yet.</p>
    <p class="text-gray-400 text-sm">Start trading to see your order history here.</p>
</div>
@endif
