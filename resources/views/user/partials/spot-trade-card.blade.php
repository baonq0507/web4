<div class="bg-[#0a0b0c] p-4 mb-3 rounded-md text-white cursor-pointer view-detail border-2 border-gray-700 hover:border-[#3ddeea] transition-all duration-300"
    data-id="{{ $item->id }}"
    data-amount="{{ $item->amount ? number_format(floatval($item->amount), 2) : 0 }}"
    data-type="{{ $item->type }}"
    data-symbol="{{ $item->symbol->name ?? 'Unknown' }}"
    data-status="{{ $item->status }}"
    data-open-price="{{ number_format($item->open_price ?? 0, 2) }}"
    data-open-time="{{ $item->trade_at ? $item->trade_at->format('Y-m-d H:i:s') : 'N/A' }}"
    data-close-price="{{ $item->trade_end && strtotime($item->trade_end) > time() ? '∞' : number_format($item->close_price ?? 0, 2) }}"
    data-close-time="{{ $item->trade_end ? $item->trade_end->format('Y-m-d H:i:s') : 'N/A' }}"
    data-profit="{{ $item->trade_end && strtotime($item->trade_end) > time() ? '∞' : number_format((float)($item->profit ?? 0), 2) }}"
    data-result="{{ $item->result ?? 'pending' }}"
    data-time-session="{{ $item->time_session->time ?? 60 }}"
    data-after-balance="{{ number_format($item->after_balance ?? 0, 2) }}"
    data-reward-time="{{ $item->trade_end ?? '' }}">
    
    <!-- Header với loại giao dịch và symbol -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-2">
            <span class="{{ $item->type === 'buy' ? 'text-[#3ddeea]' : 'text-[#e04b48]' }} font-semibold text-sm">
                {{ $item->type === 'buy' ? __('index.buy') : __('index.sell') }}
            </span>
            <span class="text-gray-400 text-xs">{{ $item->symbol->name ?? 'Unknown' }}</span>
        </div>
        
        <!-- Status badge -->
        <div class="flex items-center space-x-2">
            @if($item->trade_end && strtotime($item->trade_end) > time())
            <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs font-medium">
                {{ __('index.waiting_payment') }}
            </span>
            @else
            <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs font-medium">
                {{ __('index.completed') }}
            </span>
            @endif
            <i class="fas fa-chevron-right text-[#3ddeea] text-xs"></i>
        </div>
    </div>

    <!-- Thông tin chính -->
    <div class="grid grid-cols-2 gap-3 text-sm mb-3">
        <div class="bg-[#181a20] p-2 rounded">
            <div class="text-gray-400 text-xs mb-1">{{ __('index.amount') }}</div>
            <div class="text-white font-medium">{{ number_format($item->amount ?? 0, 2) }} USDT</div>
        </div>
        <div class="bg-[#181a20] p-2 rounded">
            <div class="text-gray-400 text-xs mb-1">{{ __('index.open_price') }}</div>
            <div class="text-white font-medium open-price-{{ $item->symbol->symbol ?? 'unknown' }}">
                {{ number_format($item->open_price ?? 0, 2) }}
            </div>
        </div>
    </div>

    <!-- Thông tin thời gian -->
    <div class="grid grid-cols-2 gap-3 text-sm mb-3">
        <div class="bg-[#181a20] p-2 rounded">
            <div class="text-gray-400 text-xs mb-1">{{ __('index.open_time') }}</div>
            <div class="text-white text-xs">
                {{ $item->trade_at ? $item->trade_at->format('m-d H:i') : 'N/A' }}
            </div>
        </div>
        <div class="bg-[#181a20] p-2 rounded">
            <div class="text-gray-400 text-xs mb-1">{{ __('index.close_time') }}</div>
            <div class="text-white text-xs">
                {{ $item->trade_end ? $item->trade_end->format('m-d H:i') : 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Kết quả và giá hiện tại -->
    <div class="grid grid-cols-2 gap-3 text-sm mb-3">
        <div class="bg-[#181a20] p-2 rounded">
            <div class="text-gray-400 text-xs mb-1">{{ __('index.profit') }}</div>
            <div class="{{ ($item->profit ?? 0) > 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }} font-medium">
                @if ($item->trade_end && strtotime($item->trade_end) > time())
                <span class="text-[#3ddeea]">∞</span>
                @else
                <span class="{{ ($item->result ?? '') == 'win' ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}">
                    {{ ($item->result ?? '') == 'win' ? '+' : '-' }}{{ number_format($item->profit ?? 0, 2) }}
                </span>
                @endif
            </div>
        </div>
        <div class="bg-[#181a20] p-2 rounded">
            <div class="text-gray-400 text-xs mb-1">{{ __('index.current_price') }}</div>
            <div class="{{ $item->trade_end && strtotime($item->trade_end) > time() ? 'last-price-' . ($item->symbol->symbol ?? 'unknown') : '' }} {{ ($item->open_price ?? 0) > ($item->close_price ?? 0) ? 'text-red-500' : 'text-cyan-500' }}" 
                 data-symbol="{{ $item->symbol->symbol ?? 'unknown' }}">
                {{ $item->trade_end && strtotime($item->trade_end) > time() ? '∞' : number_format($item->close_price ?? 0, 2) }}
            </div>
        </div>
    </div>

    <!-- Progress bar cho giao dịch đang chờ -->
    @if ($item->trade_end && strtotime($item->trade_end) > time())
    <div class="mt-3">
        <div class="text-left p-2 profit-column bg-[#181a20] rounded"
            data-trade-at="{{ $item->trade_at ? $item->trade_at->format('Y-m-d H:i:s') : '' }}"
            data-reward-time="{{ $item->trade_end }}"
            data-profit="{{ $item->profit ?? 0 }}">
            <!-- Progress bar sẽ được tạo bằng JavaScript -->
        </div>
    </div>
    @endif
</div>
