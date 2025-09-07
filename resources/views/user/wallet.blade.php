@extends('user.layouts.app')
@section('title', __('index.wallet'))
@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16 pb-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Wallet Overview Card -->
        <section class="flex-1 min-w-0 rounded-2xl border border-[#232425] px-1 flex flex-col gap-6" style="background-image: url('{{ asset('assets/images/bg-card.png?v=' . time()) }}'); background-size: cover; background-position: center;">
            <div class=" p-4 rounded-lg text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold">{{ __('index.total_assets') }} (USDT)
                            <i class="fa fa-info-circle text-base"></i>
                        </h2>
                        <p class="text-xl font-bold">{{ number_format(Auth::user()->balance, 2, ',', '.') }} USDT</p>
                    </div>
                </div>
                <div class="flex justify-between mt-4">
                @if(config('on_security_deposit') == 'off')
                    <a href="{{ route('deposit') }}" class="rounded-full border border-white px-4 py-2">
                        <i class="fa fa-arrow-up"></i>
                        {{ __('index.deposit') }}
                    </a>
                    @else
                    <button class="rounded-full border border-white px-4 py-2 on_security_deposit">
                        <i class="fa fa-arrow-up"></i>
                        {{ __('index.deposit') }}
                    </button>
                    @endif
                    <a href="{{ route('ky-quy') }}" class="rounded-full border border-white px-4 py-2">
                        <i class="fas fa-exchange-alt"></i>
                        {{ __('index.ky_quy') }}
                    </a>
                    <a href="{{ route('withdraw') }}" class="rounded-full border border-white px-4 py-2">
                        <i class="fa fa-arrow-down"></i>
                        {{ __('index.withdraw') }}
                    </a>
                </div>
            </div>

        </section>
        
        <!-- Asset List Section -->
        <div class="flex-1">
            <h3 class="text-xl text-white mb-4">{{ __('index.asset_list') }}</h3>
            
            <!-- USDT Asset -->
            <div class="p-4 rounded-lg text-white bg-[#181a1d] border border-gray-700 mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-xl font-semibold">USDT</span>
                    <span class="text-sm text-gray-400">Stable Coin</span>
                </div>
                <div class="flex justify-between mt-2">
                    <span class="text-sm">{{ __('index.available') }}
                        <br>
                        <span class="text-sm font-semibold">{{ number_format(Auth::user()->balance, 2, ',', '.') }}</span>
                    </span>
                    {{-- <span class="text-sm text-center">{{ __('index.frozen') }}
                        <br>
                        <span class="text-sm text-center">0</span>
                    </span> --}}
                    <span class="text-right text-sm">~(USDT)
                        <br>
                        <span class="text-sm font-semibold">{{ number_format(Auth::user()->balance, 2, ',', '.') }}</span>
                    </span>
                </div>
            </div>

            <!-- Crypto Assets -->
            @if(isset($wallets) && count($wallets) > 0)
                @foreach($wallets as $wallet)
                    <div class="p-4 rounded-lg text-white bg-[#181a1d] border border-gray-700 mb-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img src="{{ $wallet->symbol->image }}" alt="{{ $wallet->symbol->name }}" class="w-6 h-6 rounded-full">
                                <span class="text-xl font-semibold">{{ $wallet->symbol->symbol }}</span>
                            </div>
                            <span class="text-sm text-gray-400">{{ $wallet->symbol->name }}</span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-sm">{{ __('index.available') }}
                                <br>
                                <span class="text-sm font-semibold">{{ number_format($wallet->balance, 8, ',', '.') }}</span>
                            </span>
                            {{-- <span class="text-sm text-center">{{ __('index.frozen') }}
                                <br>
                                <span class="text-sm text-center">{{ number_format($wallet->frozen_balance, 8, ',', '.') }}</span>
                            </span> --}}
                            <span class="text-right text-sm">~(USDT)
                                <br>
                                <span class="text-sm font-semibold" id="wallet-value-{{ $wallet->id }}">--</span>
                            </span>
                        </div>
                        <div class="mt-2 text-xs text-gray-400">
                            <span>Avg Buy: ${{ number_format($wallet->average_buy_price, 2, ',', '.') }}</span>
                            <span class="float-right">Total Bought: {{ number_format($wallet->total_bought, 8, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-4 rounded-lg text-white bg-[#181a1d] border border-gray-700 text-center">
                    <span class="text-gray-400">Chưa có coin nào</span>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/wallet.js') }}"></script>
@endpush