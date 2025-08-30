<div class="bg-[#0a0b0c] p-4 mb-2 rounded-md text-white cursor-pointer view-detail border-2 border-gray-700"
    data-id="{{ $item->id }}"
    data-amount="{{ $item->amount ? number_format(floatval($item->amount), 2) : 0 }}"
    data-type="{{ $item->type }}"
    data-symbol="{{ $item->symbol->name }}"
    data-status="{{ $item->status }}"
    data-open-price="{{ number_format($item->open_price, 2) }}"
    data-open-time="{{ $item->trade_at->format('Y-m-d H:i:s') }}"
    data-close-price="{{ strtotime($item->trade_end) > time() ? '∞' : number_format($item->close_price, 2) }}"
    data-close-time="{{ $item->trade_end->format('Y-m-d H:i:s') }}"
    data-profit="{{ strtotime($item->trade_end) > time() ? '∞' : number_format((float)$item->profit, 2) }}"
    data-result="{{ $item->result }}"
    data-time-unit="{{ $item->time_session->unit }}"
    data-time-session="{{ $item->time_session->time }}"
    data-after-balance="{{ number_format($item->after_balance, 2) }}"
    data-reward-time="{{ $item->trade_end }}">
    <div class="flex items-center justify-between mb-2">
        <span class="{{ $item->type === 'buy' ? 'text-[#3ddeea]' : 'text-[#e04b48]' }} font-medium">
            {{ $item->type === 'buy' ? __('index.buy') : __('index.sell') }}
        </span>
        <span class="text-gray-400">{{ $item->symbol->name }}</span>
        <a href="#" class="text-[#3ddeea]">
            @if(strtotime($item->trade_end) > time())
            <span class="text-red-500">{{ __('index.waiting_payment') }}</span>
            <i class="fa-solid fa-arrow-right"></i>
            @else
            <span class="text-cyan-500">{{ __('index.paid') }}</span>
            <i class="fa-solid fa-arrow-right"></i>

            @endif
        </a>
    </div>

    <div class="grid grid-cols-3 gap-4 text-sm">
        <div>
            <div class="text-gray-400 text-xs">{{ __('index.amount') }}</div>
            <div class="text-white">{{ number_format($item->amount, 2) }}</div>
        </div>
        <div>
            <div class="text-gray-400 text-xs" >{{ __('index.open_price') }}</div>
            <div class="text-white open-price-{{ $item->symbol->symbol }}">{{ number_format($item->open_price, 2) }}</div>
        </div>
        <div>
            <div class="text-gray-400 text-xs">{{ __('index.open_time') }}</div>
            <div class="text-white">{{ $item->trade_at->format('m-d H:i') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 text-sm mt-4">
        <div>
            <div class="text-gray-400 text-xs">{{ __('index.profit') }}</div>
            <div class="{{ $item->profit > 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}">
                @if (strtotime($item->trade_end) > time())
                <span class="text-[#3ddeea] text-1xl">∞</span>
                @else
                <span class="{{ $item->result == 'win' ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}">
                    {{ $item->result == 'win' ? '+' : '-' }}{{ number_format($item->profit, 2) }}
                </span>
                @endif
            </div>
        </div>
        <div>
            <div class="text-gray-400 text-xs">{{ __('index.current_price') }}</div>
            <div class="{{ strtotime($item->trade_end) > time() ? 'last-price-' . $item->symbol->symbol : '' }} {{ $item->open_price > $item->close_price ? 'text-red-500' : 'text-cyan-500' }}" data-symbol="{{ $item->symbol->symbol }}">{{ strtotime($item->trade_end) > time() ? '∞' : number_format($item->close_price, 2) }}</div>
        </div>
        <div>
            <div class="text-gray-400 text-xs">{{ __('index.close_time') }}</div>
            <div class="text-white">{{ $item->trade_end->format('m-d H:i') }}</div>
        </div>
    </div>

    <!-- <div class="grid grid-cols-1 gap-4 text-sm mt-4">
        <div>
            <div class="text-gray-400 text-xs">Số dư</div>
            <div class="text-white">{{ number_format(floatval($item->after_balance), 2) }}</div>
        </div>
    </div> -->

    @if (strtotime($item->trade_end) > time())
    <div class="mt-4">
        <div class="text-left p-2 {{ strtotime($item->trade_end) > time() ? 'profit-column' : 'text-[#3ddeea]' }}"
            data-trade-at="{{ $item->trade_at }}"
            data-reward-time="{{ $item->trade_end }}"
            data-profit="{{ $item->profit }}">
        </div>
    </div>
    @endif
</div> 