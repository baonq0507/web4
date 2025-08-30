<div class="bg-[#232425] p-4 rounded-lg">
    <div class="flex justify-between items-center mb-2">
        <span class="text-white font-medium">{{ __('index.code') }}: </span>
        <span class="text-sm text-white/70">{{ $item->code }}</span>
    </div>
    <div class="flex justify-between items-center mb-2">
        <span class="text-white/70">{{ __('index.phone') }}:</span>
        <span class="text-white">{{ $item->user->phone }}</span>
    </div>
    <div class="flex justify-between items-center mb-2">
        <span class="text-white/70">{{ __('index.method') }}:</span>
        <span class="text-white">{{ $item->payment_type == 'bank' ? __('index.bank') : __('index.usdt') }}</span>
    </div>
    <div class="flex justify-between items-center mb-2">
        <span class="text-white/70">{{ __('index.amount') }}:</span>
        <span class="text-white">{{ number_format($item->amount, 2, ',', '.') }} USDT</span>
    </div>
    <div class="flex justify-between items-center">
        <span class="text-white/70">{{ __('index.status') }}:</span>
        <span class="font-bold {{ $item->status == 'pending' ? 'text-yellow-500' : ($item->status == 'success' ? 'text-green-500' : 'text-red-500') }}">
            <i class="fa-solid fa-{{ $item->status == 'pending' ? 'clock' : ($item->status == 'success' ? 'check' : 'xmark') }}"></i>
            {{ $item->status == 'pending' ? __('index.pending') : ($item->status == 'success' ? __('index.success') : __('index.failed')) }}
        </span>
    </div>
</div> 