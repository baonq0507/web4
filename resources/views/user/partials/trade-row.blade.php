<tr class="text-white py-2">
    <td class="text-left p-2">
        <span class="flex items-center gap-2">
            <img src="{{ $item->symbol->image }}" alt="coin" class="w-4 h-4 rounded-full">
            <span class="text-gray-400">{{ $item->symbol->name }}</span>
            <span class="text-gray-400">{{ $item->code }}</span>
        </span>
    </td>
    <td class="text-left p-2">{{ $item->amount }}</td>
    <td class="text-left p-2">{{ $item->time_session->unit == 'm' ? $item->time_session->time * 60 : ($item->time_session->unit == 'h' ? $item->time_session->time * 3600 : $item->time_session->time * 86400) }}s</td>
    <td class="text-left p-2">{{ number_format($item->after_balance, 2) }}</td>

    <td class="text-left p-2 {{ $item->type === 'buy' ? 'text-cyan-500' : 'text-red-500' }}">{{ $item->type === 'buy' ? __('index.buy') : __('index.sell') }}</td>
    <td class="text-left p-2">
        <div class="flex flex-col">
            <span class="{{ 'text-white' }} open-price-{{ $item->symbol->symbol }}">{{ number_format($item->open_price, 2) }}</span>
        </div>
    </td>
    <td class="text-left p-2">
        <div class="flex flex-col">
            <span class="
            {{ strtotime($item->trade_end) < time() &&  floatval($item->open_price) < floatval($item->close_price) ? 'text-cyan-500' : 'text-red-500' }}
            {{ strtotime($item->trade_end) > time() ? 'last-price-'. $item->symbol->symbol : '' }}" data-symbol="{{ $item->symbol->symbol }}">{{ strtotime($item->trade_end) > time() ? '∞' : number_format($item->close_price, 2) }}</span>
        </div>
    </td>
    <td class="text-left p-2 {{ $item->status === 'pending' ? 'text-[#3ddeea]' : ($item->status === 'success' ? 'text-[#3ddeea]' : 'text-[#e04b48]') }}">
        {{ $item->status === 'pending' ? __('index.pending') : ($item->status === 'success' ? __('index.success') : __('index.failed')) }}
    </td>
    <td class="text-left p-2 {{ strtotime($item->trade_end) > time() ? 'profit-column' : 'text-[#3ddeea]' }}"
        data-trade-at="{{ $item->trade_at }}"
        data-reward-time="{{ $item->trade_end }}"
        data-profit="{{ $item->profit }}">
        @if (strtotime($item->trade_end) > time())
        <span class="text-[#3ddeea] text-2xl">∞</span>
        @else
        <span class="{{ $item->result == 'win' ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}">
            {{ $item->result == 'win' ? '+' : '-' }}{{ number_format((float)$item->profit, 2) }}
        </span>
        @endif
    </td>
    <td class="text-left p-2">{{ $item->trade_end->format('d/m/Y H:i:s') }}</td>
</tr>