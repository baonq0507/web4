<div class="bg-[#181a1d] rounded-lg border border-[#232425] p-4 mb-4">
    <div class="flex justify-between items-center mb-2">
        <div class="text-white font-medium">{{ $user->name }}</div>
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $user->status_name }}
        </span>
    </div>
    <div class="text-gray-400 text-sm">
        <div class="mb-1">{{ __('index.name') }}: {{ $user->name }}</div>
        <div class="mb-1">{{ __('index.phone') }}: {{ substr($user->phone, 0, -4) . '****' }}</div>

    </div>
</div> 