<tr>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $item->code }}</td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $item->user->phone }}</td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $item->payment_type == 'bank' ? __('index.bank') : USDT }}</td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ number_format($item->amount, 2, ',', '.') }} USDT</td>
    <td class="px-4 py-4 whitespace-nowrap text-sm
    {{ $item->status == 'pending' ? 'text-yellow-500' : ($item->status == 'success' ? 'text-green-500' : 'text-red-500') }}
    ">
        <span class="font-bold">
            <i class="fa-solid fa-{{ $item->status == 'pending' ? 'clock' : ($item->status == 'success' ? 'check' : 'xmark') }}"></i>
            {{ $item->status == 'pending' ? __('index.pending') : ($item->status == 'success' ? __('index.success') : __('index.failed')) }}
        </span>
    </td>
</tr> 