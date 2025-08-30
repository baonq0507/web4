@extends('user.layouts.app')
@section('title', __('index.trading'))
@section('style')
<style>
    .grid-cols-4{
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
</style>
@endsection

@section('content')
<!-- Hidden inputs for JavaScript data -->
<input type="hidden" id="symbol-active-data" value="{{ $symbolActive->symbol }}">
<input type="hidden" id="symbols-data" value="{{ json_encode($symbols) }}">

<!-- TICKER DẢI GIÁ COIN -->
<section class="w-full bg-[#191a1d] py-2 px-6 flex space-x-6 overflow-x-auto text-xs border-b border-[#232428] pt-20">
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M11.3211 6.42547C11.0608 5.83944 10.6824 5.31342 10.2096 4.88031L9.81911 4.52222C9.80588 4.51031 9.78992 4.50184 9.77263 4.49756C9.75535 4.49329 9.73728 4.49333 9.72002 4.49769C9.70276 4.50206 9.68683 4.51061 9.67366 4.52258C9.66049 4.53456 9.65047 4.5496 9.64448 4.56637L9.47035 5.06671C9.36194 5.38064 9.1618 5.70096 8.87877 6.01637C8.86446 6.03182 8.84483 6.04128 8.82383 6.04286C8.81334 6.04389 8.80275 6.04268 8.79277 6.03929C8.78279 6.03591 8.77364 6.03044 8.76595 6.02324C8.75683 6.01523 8.74969 6.00521 8.74509 5.99398C8.74049 5.98274 8.73857 5.97059 8.73946 5.95849C8.78851 5.15108 8.54766 4.24017 8.01887 3.2493C7.58181 2.42521 6.97405 1.78311 6.2152 1.33526L5.66091 1.00906C5.64418 0.999618 5.62524 0.99481 5.60604 0.995132C5.58684 0.995455 5.56807 1.0009 5.55167 1.01089C5.53527 1.02089 5.52184 1.03509 5.51276 1.05201C5.50368 1.06893 5.49928 1.08797 5.50001 1.10717L5.52945 1.75074C5.54956 2.19074 5.49854 2.57973 5.37787 2.90348C5.22971 3.30016 5.01671 3.66948 4.74754 3.99637C4.55722 4.22692 4.34384 4.43491 4.11035 4.61444C3.5448 5.04938 3.08498 5.60663 2.76532 6.24446C2.46683 6.84684 2.30207 7.50663 2.28234 8.17862C2.26262 8.85061 2.38838 9.51893 2.65103 10.1378C3.13378 11.2625 4.03518 12.1553 5.16449 12.6272C5.74594 12.8713 6.37042 12.9964 7.00103 12.9951C7.63131 12.9962 8.25549 12.8716 8.83707 12.6287C9.39771 12.3954 9.90754 12.0552 10.3381 11.627C10.7771 11.1945 11.1256 10.6788 11.3633 10.1102C11.6009 9.54156 11.723 8.93129 11.7224 8.31498C11.7224 7.66062 11.5884 7.02489 11.3211 6.42547Z" fill="url(#paint0_linear_6455_70835)"></path>
            <defs>
                <linearGradient id="paint0_linear_6455_70835" x1="7.00135" y1="0.995117" x2="7.00135" y2="12.9951" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#F45F4F"></stop>
                    <stop offset="1" stop-color="#F1493F"></stop>
                </linearGradient>
            </defs>
        </svg>
    </span>
    @foreach ($symbols as $item)
    <span class="text-white font-semibold">
        {{ $item->name }}
        <span class="text-[#3ddeea] font-semibold price-change" id="price-change-{{ $item->symbol }}">{{ $item->price_change }}%</span>
    </span>
    @endforeach

</section>
<div class="flex flex-wrap md:flex-nowrap items-center gap-3 bg-[#181a20] rounded-md px-3 py-2 w-full">
    <!-- Dropdown symbol -->
    <div class="relative inline-block text-left" id="symbol-dropdown">
        <div class="flex items-center gap-2 cursor-pointer bg-[#181a20] p-2 rounded-md" id="selected-symbol">
            <img src="{{ $symbolActive->image }}" alt="{{ $symbolActive->name }}" class="w-6 h-6">
            <span class="text-white font-bold text-sm" data-id="{{ $symbolActive->id }}">
                {{ $symbolActive->name }}
            </span>
            <i class="fa-solid fa-chevron-down text-white"></i>
        </div>

        <div class="absolute mt-2 w-40 bg-[#1f222b] rounded-md shadow-lg z-50 hidden" id="symbol-options">
            @foreach ($symbols as $item)
            <div class="flex items-center gap-2 p-2 hover:bg-[#2a2d38] cursor-pointer" data-symbol="{{ $item->symbol }}" data-icon="{{ $item->image }}" data-id="{{ $item->id }}">
                <img src="{{ $item->image }}" class="w-5 h-5"> <span class="text-white text-sm">{{ $item->name }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Giá hiện tại -->
    <div class="flex flex-wrap md:flex-nowrap items-center gap-4">
        <span class="text-[#e04b48] font-semibold text-sm hidden md:block" id="current-price">86,206.65586</span>
        <span class="text-[#e04b48] text-xs hidden md:block" id="current-price-change">-3.90%</span>
        <span class="text-sm text-gray-400">{{ __('index.high_price_24h') }}: <span class="text-white" id="high-price"></span></span>
        <span class="text-sm text-gray-400">{{ __('index.low_price_24h') }}: <span class="text-white" id="low-price"></span></span>
        <span class="text-sm text-gray-400">{{ __('index.volume_24h_btc') }}: <span class="text-white" id="volume"></span></span>
        <span class="text-sm text-gray-400">{{ __('index.volume_24h') }}: <span class="text-white" id="volume-usdt"></span></span>
    </div>
    <div class="w-full md:hidden block">
        @if (!auth()->check())
        <button class="bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold btn-login w-full">{{ __('index.login') }}</button>
        @else
        <button class="bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold btn-trading w-full">{{ __('index.trading') }}</button>
        @endif
    </div>
</div>
<!-- MAIN TRADING AREA -->
<main class="flex flex-col md:flex-row w-full px-3 pt-3 gap-2 h-auto md:pb-0">
    <!-- LEFT: CHART/INFO -->
    <div class="flex-1 h-full md:flex hidden">
        <div class="bg-[#101113] rounded-md w-full h-full" id="trading_view">
            <iframe
                src="https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22{{ $symbolActive->symbol }}%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D{{ $symbolActive->symbol }}%22%7D"
                frameborder="0"
                allowfullscreen="true"
                scrolling="no"
                style="height: 480px"
                class="w-full">
            </iframe>
        </div>
    </div>
    <div class="w-full md:w-[370px] flex flex-col gap-2 h-full relative min-h-[480px]">
        <div class="bg-[#101112] rounded-md p-2 h-full overflow-y-auto relative" style="height: 480px;">
            <div class="flex gap-8 mb-2 top-0 bg-[#101112] z-10 bg-opacity-50 backdrop-blur-sm items-center">
                <div class="tab-header text-gray-400 pb-1 cursor-pointer change-tab md:hidden block border-[#3ddeea] border-b-2 text-[#3ddeea] active-tab" data-tab="chart">{{ __('index.chart') }}</div>
                <div class="tab-header text-gray-400 pb-1 font-semibold cursor-pointer change-tab md:active-tab md:border-[#3ddeea] md:border-b-2 md:text-[#3ddeea] md:block" data-tab="order-book">{{ __('index.order_book') }}</div>
                <!-- <div class="tab-header text-gray-400 pb-1 cursor-pointer change-tab md:hidden block" data-tab="history">Lịch sử lệnh ({{ $history->count() }})</div> -->
            </div>
        
            <hr class="border-[#232428] mb-2">
            <!-- Tab Content -->
            <div class="tab-content block md:hidden" id="chart">
                <!-- Nội dung biểu đồ -->
                <div class="h-full text-gray-400" id="chart-content">
                    <iframe
                        src="https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22{{ $symbolActive->symbol }}%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D{{ $symbolActive->symbol }}%22%7D"
                        frameborder="0"
                        allowfullscreen="true"
                        scrolling="no"
                        style="height: 420px;"
                        class="w-full">
                    </iframe>
                </div>
            </div>
            <div class="tab-content hidden md:block" id="order-book">
                <!-- ĐƠN LỆNH -->
                <div class="flex text-md mb-1">
                    <span class="w-1/3 text-gray-400">{{ __('index.price') }} (USDT)</span>
                    <span class="w-1/3 text-gray-400">{{ __('index.quantity') }} (BTC)</span>
                    <span class="w-1/3 text-gray-400 text-right">{{ __('index.volume') }}</span>
                </div>
                <div class="h-full overflow-y-auto text-xs" id="order-book-content">
                    <!-- Order book content will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- ORDERBOOK & ĐẶT LỆNH -->
    <div class="w-full md:w-[370px] flex flex-col gap-2 md:block hidden">
        <div class="bg-[#101112] rounded-md p-2 h-full sticky top-0 ">
            <div class="flex gap-3 mb-3">
                <button data-type="buy" class="cursor-pointer flex-1 rounded-l-full bg-[#232325] font-semibold py-3 btn-trade active:bg-[#3ddeea] btn-buy trade-active text-white">{{ __('index.buy') }}</button>
                <button data-type="sell" class="cursor-pointer flex-1 rounded-r-full bg-[#232325] font-semibold py-3 btn-trade active:bg-[#e04b48] btn-sell text-white">{{ __('index.sell') }}</button>
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="text-white">
                        {{ __('index.available_balance') }}
                        <span class="text-[#3ddeea]">
                            <span class="balance-value">
                                {{auth()->check() ? number_format(Auth::user()->balance, 2) : '--'}}$
                            </span>
                            <!-- <i class="fa-solid fa-coins"></i> -->
                        </span>
                    </span>
                    <div class="flex gap-2 items-center">
                        <button class="rounded-full w-5 h-5 bg-[#181a20] text-[#3ddeea] border flex items-center justify-center">+</button>
                        <button class="rounded-full w-5 h-5 bg-[#181a20] text-[#3ddeea] border flex items-center justify-center">-</button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="grid gap-2 md:grid-cols-4 justify-center w-full">
                        @foreach ($time_session as $item)
                        <div class="col-span-1 flex justify-center">
                            <button data-time-id="{{ $item->id }}" data-win-rate="{{ $item->win_rate }}" class="cursor-pointer text-sm btn-time rounded-md px-4 py-2 w-full h-20 flex flex-col items-center justify-center bg-[#3ddeea]">
                                <span class="text-black font-semibold">
                                    @php
                                        $seconds = $item->time;
                                        switch(strtolower($item->unit)) {
                                            case 'm':
                                                $seconds *= 60;
                                                break;
                                            case 'h':
                                                $seconds *= 3600;
                                                break;
                                            case 'd':
                                                $seconds *= 86400;
                                                break;
                                        }
                                    @endphp
                                    {{ $seconds }}s
                                </span>
                                <span class="text-black font-semibold">{{ $item->win_rate }}%</span>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <h2 class="text-white text-sm font-semibold mt-4">{{ __('index.select_amount') }}</h2>
            <div class="flex items-center justify-between mt-4">
                <div class="grid grid-cols-5 gap-2">
                    <div class="col-span-1">
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-20 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="100">
                            100
                            <span class="text-xs">USDT</span>
                        </button>
                    </div>
                    <div class="col-span-1">
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-20 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="500">
                            500
                            <span class="text-xs">USDT</span>
                        </button>
                    </div>
                    <div class="col-span-1">
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-20 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="1000">
                            1000
                            <span class="text-xs">USDT</span>
                        </button>
                    </div>
                    <div class="col-span-1">
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-20 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="5000">
                            5000
                            <span class="text-xs">USDT</span>
                        </button>
                    </div>
                    <div class="col-span-1">
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-20 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="all">
                            All
                            <span class="text-xs">USDT</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center w-full rounded-full bg-[#181a20] mt-4">
                <input type="text" class="flex-1 rounded-full px-4 py-2 bg-[#181a20] text-white focus:outline-none amount" placeholder="{{ __('index.enter_amount_trading') }}">
                <span class="px-4 py-2 text-white">USDT</span>
            </div>
           

            @if (!auth()->check())
            <button class="cursor-pointer mt-4 w-full bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold btn-login">{{ __('index.login') }}</button>
            @else
            <button class="
            transition-all duration-300 cursor-pointer mt-4 w-full bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold submit-order">{{ __('index.buy') }}</button>
            @endif
        </div>

    </div>

    <!-- Modal -->
    <div class="bg-[#101112] rounded-md p-2 md:hidden block fixed inset-x-0 bottom-0 z-50 transition-transform transform translate-y-full border border-gray-700" id="mobile-modal">
        <div class="w-full md:w-[370px] flex flex-col gap-2 md:hidden block">
            <div class="bg-[#101112] rounded-md p-2 relative">
                <button class="absolute top-2 right-2 text-white text-xl cursor-pointer mb-4" id="close-modal">
                    <i class="fa-solid fa-times"></i>
                </button>
                <div class="flex gap-3 mt-6 mb-4">
                    <button data-type="buy" class="cursor-pointer flex-1 rounded-l-full bg-[#232325] font-semibold py-3 btn-trade active:bg-[#3ddeea] btn-buy trade-active text-white">{{ __('index.buy') }}</button>
                    <button data-type="sell" class="cursor-pointer flex-1 rounded-r-full bg-[#232325] font-semibold py-3 btn-trade active:bg-[#e04b48] btn-sell text-white">{{ __('index.sell') }}</button>
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-white">
                            {{ __('index.available_balance') }}
                            <span class="text-[#3ddeea]">
                                <!-- <i class="fa-solid fa-coins"></i> -->
                                <span class="balance-value">
                                    {{auth()->check() ? number_format(Auth::user()->balance, 2) : '--'}}
                                </span>
                            </span>
                        </span>
                        <div class="flex gap-2 items-center">
                            <button class="rounded-full w-5 h-5 bg-[#181a20] text-[#3ddeea] border flex items-center justify-center">+</button>
                            <button class="rounded-full w-5 h-5 bg-[#181a20] text-[#3ddeea] border flex items-center justify-center">-</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="grid gap-2 grid-cols-4 justify-center w-full">
                            @foreach ($time_session as $item)
                            <div class="col-span-1 flex justify-center">
                                <button data-time-id="{{ $item->id }}" data-time="{{ $item->time }}" data-win-rate="{{ $item->win_rate }}" class="cursor-pointer text-sm btn-time rounded-md px-4 py-2 w-full flex flex-col items-center justify-center bg-[#3ddeea]">
                                    <span class="text-black font-semibold">
                                        @php
                                            $seconds = $item->time;
                                            switch(strtolower($item->unit)) {
                                                case 'm':
                                                    $seconds *= 60;
                                                    break;
                                                case 'h':
                                                    $seconds *= 3600;
                                                    break;
                                                case 'd':
                                                    $seconds *= 86400;
                                                    break;
                                            }
                                        @endphp
                                        {{ $seconds }}s
                                    </span>
                                    <span class="text-black font-semibold">{{ $item->win_rate }}%</span>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <h2 class="text-white text-sm font-semibold mt-4">{{ __('index.select_amount') }}</h2>
                <div class="flex items-center justify-between mt-4">
                    <div class="grid grid-cols-5 gap-2 w-full">
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-15 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="100">
                            100
                            <span class="text-xs">USDT</span>
                        </button>
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-15 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="500">
                            500
                            <span class="text-xs">USDT</span>
                        </button>
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-15 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="1000">
                            1000
                            <span class="text-xs">USDT</span>
                        </button>
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-15 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="5000">
                            5000
                            <span class="text-xs">USDT</span>
                        </button>
                        <button class="cursor-pointer text-black font-semibold btn-amount text-sm rounded-md px-4 py-3 w-full h-15 flex flex-col items-center justify-center bg-[#3ddeea]" data-amount="all">
                            All
                            <span class="text-xs">USDT</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center w-full rounded-full bg-[#181a20] mt-4">
                    <input type="text" name="amount-mobile" class="flex-1 rounded-full px-4 py-2 bg-[#181a20] text-white focus:outline-none amount-mobile" placeholder="{{ __('index.enter_amount_trading') }}">
                    <span class="px-4 py-2 text-white">USDT</span>
                </div>

            </div>

                @if (!auth()->check())
                <button class="cursor-pointer mt-2 w-full bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold btn-login mb-4">{{ __('index.login') }}</button>
                @else
                <button class="
            transition-all duration-300 cursor-pointer w-full bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold submit-order mb-4">{{ __('index.buy') }}</button>
                @endif
            </div>

        </div>
    </div>
</main>
<!-- TABS LỆNH BÊN DƯỚI -->
<section class="mt-2 px-6 pb-2 hidden md:block">
    <div class="flex gap-8 border-b border-[#232428]">
        <div class="border-b-2 border-[#3ddeea] pb-1 font-semibold text-[#3ddeea] cursor-pointer">{{ __('index.history_order') }}</div>
    </div>
    <!-- Content tab lệnh (dạng bảng placeholder) -->
    <div class="bg-[#101112] mt-2 rounded-md min-h-24 p-2">
        <!-- Table for desktop view -->
        <div class="hidden md:block">
            <table class="w-full" id="history-table">
                <thead class="bg-[#181a20]">
                    <tr class="text-white py-2">
                        <th class="text-left p-2">{{ __('index.session_code') }}</th>
                        <th class="text-left p-2">{{ __('index.amount') }}</th>
                        <th class="text-left p-2">{{ __('index.time') }}</th>
                        <th class="text-left p-2">{{ __('index.after_balance') }}</th>
                        <th class="text-left p-2">{{ __('index.order_type') }}</th>
                        <th class="text-left p-2">{{ __('index.open_price') }}</th>
                        <th class="text-left p-2">{{ __('index.close_price') }}</th>
                        <th class="text-left p-2">{{ __('index.status') }}</th>
                        <th class="text-left p-2">{{ __('index.profit') }}</th>
                        <th class="text-left p-2">{{ __('index.trade_at') }}</th>
                    </tr>
                </thead>
                <tbody id="history-table-body">
                    @if ($history->count() > 0)
                    @foreach ($history as $item)
                    @include('user.partials.trade-row', ['item' => $item])
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center text-white">{{ __('index.no_data') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            
            @if(auth()->check() && $history->hasMorePages())
            <div class="text-center mt-4">
                <button id="load-more-desktop" class="bg-[#3ddeea] text-[#181a20] py-2 px-4 rounded-full font-semibold" data-page="2">
                    {{ __('index.load_more') }}
                </button>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Card view for mobile -->
<div class="block md:hidden history-card bg-[#0a0b0c] mx-4 pb-16" id="history-card">
    <h2 class="text-white text-lg font-bold mb-2">{{ __('index.history_order') }}</h2>
    <div id="history-card-body">
        @if ($history->count() > 0)
        @foreach ($history as $item)
        @include('user.partials.trade-card', ['item' => $item])
        @endforeach
        @else
        <div class="text-center text-white">{{ __('index.no_data') }}</div>
        @endif
    </div>
    @if(auth()->check() && $history->hasMorePages())
    <div class="text-center mt-4">
        <button id="load-more-mobile" class="bg-[#3ddeea] text-[#181a20] py-2 px-4 rounded-full font-semibold" data-page="2">
            {{ __('index.load_more') }}
        </button>
    </div>
    @endif
</div>


<div id="tradeing-success" class="border border-gray-700 fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="bg-[#1f2023] rounded-lg p-6 w-full max-w-sm relative">
        <div class="flex flex-col items-center mb-6" id="tradeing-icon">
            <h2 class="text-xl font-bold text-center text-cyan-500 mb-2" id="symbol-name"></h2>
            <div id="circle-progress" class="circle-progress-value relative"></div>
        </div>

        <!-- Trading Details -->
        <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.period') }}</span>
                <span class="text-white text-xl" id="trade-period">60<span class="text-sm">s</span></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.type') }}</span>
                <span class="text-red-500 text-xl" id="trade-type">{{ __('index.buy') }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.amount') }}</span>
                <span class="text-white text-xl" id="trade-amount">1000.00</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.open_price') }}</span>
                <span class="text-white text-xl" id="entry-price">77599.00</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.current_price') }}</span>
                <span class="text-white text-xl last-price-mobile">00</span>
            </div>
        </div>

        <!-- Action Button -->
        <button class="text-xl cursor-pointer w-full bg-[#3ddeea] mt-6 text-[#181a20] hover:bg-[#3ddeea] text-white font-medium py-3 px-4 rounded-lg transition-colors" id="close-tradeing-success">
            {{ __('index.continue_order') }}
        </button>
    </div>
</div>

<!-- Modal Confirm Order -->
<div id="confirm-order-modal" class="border border-gray-700 fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="bg-[#1f2023] rounded-lg w-full max-w-sm relative border border-gray-700">
        <div class="px-4 py-3 border-b border-gray-700">
            <h2 class="text-2xl font-bold text-cyan-500" id="confirm-trade-type-1"></h2>
        </div>
        <!-- Trading Details -->
        <div class="space-y-3 text-sm p-6">
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.account_balance') }}</span>
                <span class="text-white text-xl" id="confirm-balance">1000.00</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.trading_pair') }}</span>
                <span class="text-white text-xl" id="confirm-symbol-name">BTC/USDT</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.direction') }}</span>
                <span class="text-white text-xl" id="confirm-trade-type">{{ __('index.buy') }}</span>
            </div>
            <!-- <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.open_price') }}</span>
                <span class="text-white text-xl" id="confirm-open-price">1000.00</span>
            </div> -->
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.current_price') }}</span>
                <span class="text-white text-xl" id="confirm-current-price">1000.00</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.amount') }}</span>
                <span class="text-white text-xl" id="confirm-trade-amount">1000.00</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.expected_profit') }}</span>
                <span class="text-green-500 text-xl" id="confirm-expected-profit">100</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 p-3 mb-3">
            <button class="text-xl flex-1 bg-[#181a20] text-[#3ddeea] font-medium py-2 px-3 rounded-lg transition-colors text-sm" id="cancel-confirm-order">
                {{ __('index.cancel') }}
            </button>
            <button class="text-xl flex-1 bg-[#3ddeea] text-[#181a20] font-medium py-2 px-3 rounded-lg transition-colors text-sm" id="confirm-order">
                {{ __('index.confirm') }}
            </button>
        </div>
    </div>
</div>

<!-- Modal Chi tiết hợp đồng -->
<div id="contractDetailModal" class="border border-gray-700 fixed inset-0 z-50 hidden p-2">
    <div class="absolute inset-0 bg-[#000] bg-opacity-100 backdrop-blur-sm"></div>
    <div class="relative w-full h-full flex items-end">
        <div class="w-full bg-[#1e2026] text-white transform transition-transform duration-300 translate-y-full modal-content border border-gray-700">
            <!-- Header -->
            <div class="bg-[#1e2026] text-white p-4 flex items-center border-b border-gray-700">
                <button class="mr-2" id="close-contract-detail">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="text-lg font-medium contract-symbol">BTC/USDT</span>
                <span class="ml-2">{{ __('index.contract_detail') }}</span>
            </div>

            <!-- Content -->
            <div class=" text-white overflow-y-auto" style="max-height: 100vh; background-color: #000; height: 100vh;">
                <div class="p-4 space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_amount') }}</span>
                        <span class="contract-amount text-xl">15000.00USDT</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_time') }}</span>
                        <span class="text-xl" id="contract-time-unit">1phút</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_type') }}</span>
                        <span class="contract-type text-[#3ddeea] text-xl">{{ __('index.buy') }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_status') }}</span>
                        <span class="text-[#3ddeea] text-xl">{{ __('index.success') }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.open_price') }}</span>
                        <span class="contract-open-price text-xl" id="contract-open-price">95478.79</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_open') }}</span>
                        <span class="contract-open-time text-xl" id="contract-open-time">2025-04-25 22:08:46</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.close_price') }}</span>
                        <span class="contract-close-price text-xl" id="contract-close-price">95479.62</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_close') }}</span>
                        <span class="contract-close-time text-xl" id="contract-close-time">2025-04-25 22:09:46</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.profit') }}</span>
                        <span class="contract-profit text-[#3ddeea] text-xl">+1500.00</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-700 bg-[#181a20] p-2 rounded-md">
                        <span class="text-gray-400 text-xl">{{ __('index.contract_balance') }}</span>
                        <span class="contract-balance text-xl" id="contract-balance">15000.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Trade Result -->
<div id="tradeResultModal" class="border border-gray-700 fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="bg-[#1f2023] rounded-lg p-6 w-full max-w-sm relative border border-gray-700">
        <div class="flex flex-col items-center mb-6">
            <h2 class="text-xl font-bold text-center text-cyan-500 mb-2" id="result-symbol-name"></h2>
            <!-- <div class="rounded-full w-32 h-32 flex items-center justify-center mb-4 border border-gray-700">
                <span id="result-profit" class="text-6xl"></span>
            </div> -->
            <div id="circle-progress-status" class="w-full h-32 border rounded-lg flex items-center justify-center" style="border-width: 7px;">
                <strong id="profilt-trade-result" style="font-size: 30px;"></strong>
            </div>
        </div>

        <!-- Trading Details -->
        <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.period') }}</span>
                <span id="result-period" class="font-semibold text-xl"></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.type') }}</span>
                <span id="result-type" class="font-semibold text-xl"></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.amount') }}</span>
                <span id="result-amount" class="font-semibold text-xl"></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl" id="result-entry-type">{{ __('index.open_price') }}</span>
                <span id="result-open-price" class="font-semibold text-xl"></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-700">
                <span class="text-gray-400 text-xl">{{ __('index.current_price') }}</span>
                <span id="result-close-price" class="font-semibold text-xl"></span>
            </div>
        </div>
        <!-- Action Button -->
        <button class="text-xl cursor-pointer w-full bg-[#3ddeea] mt-6 text-[#181a20] hover:bg-[#3ddeea] text-white font-medium py-3 px-4 rounded-lg transition-colors" id="close-trade-result">
            {{ __('index.continue_order') }}
        </button>
    </div>
</div>

@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/jquery-circle-progress/dist/circle-progress.min.js"></script>

<script>
    $(document).ready(function() {
        let reconnectAttempts = 0;
        const maxReconnectAttempts = 5;
        const reconnectDelay = 3000; // 3 seconds

        function connectWebSocket() {
            ws = new WebSocket("{{env('WEBSOCKET_URL')}}");
            
            ws.onopen = function() {
                // console.log('WebSocket connected');
                reconnectAttempts = 0; // Reset reconnect attempts on successful connection
                
                // Subscribe to trades for current user
                ws.send(JSON.stringify({
                    type: 'subscribe_trades',
                    user_id: @js(auth()->id() ?? 0),
                    is_admin: false
                }));
            };

            ws.onmessage = function(event) {
                const data = JSON.parse(event.data);
                if (data.type === 'trade_completed') {
                    const trade = data.trade;
                    
                    // Update history table/card
                    if (window.innerWidth > 768) {
                        // Desktop view - update table row
                        const row = $(`tr[data-trade-id="${trade.id}"]`);
                        if (row.length) {
                            row.find('.status-badge')
                                .removeClass('bg-warning')
                                .addClass('bg-success')
                                .text('{{ __("index.success") }}');
                            
                            row.find('.profit-column').html(
                                `<span class="text-${trade.result === 'win' ? 'success' : 'danger'}">
                                    ${trade.result === 'win' ? '+' : '-'}${trade.profit}
                                </span>`
                            );
                        }
                    } else {
                        // Mobile view - update card
                        const card = $(`.trade-card[data-trade-id="${trade.id}"]`);
                        if (card.length) {
                            card.find('.status-badge')
                                .removeClass('bg-warning')
                                .addClass('bg-success')
                                .text('{{ __("index.success") }}');
                            
                            card.find('.profit-value').html(
                                `<span class="text-${trade.result === 'win' ? 'success' : 'danger'}">
                                    ${trade.result === 'win' ? '+' : '-'}${trade.profit}
                                </span>`
                            );
                        }
                    }

                    // Show success notification
                    Toastify({
                        text: `Trade completed! ${trade.result === 'win' ? 'You won!' : 'You lost!'}`,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: trade.result === 'win' ? 
                                "linear-gradient(to right, #3ddeea, #3ddeea)" :
                                "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();

                    // Update user balance
                    if (trade.after_balance) {
                        $('.balance-value').text(formatAmount(trade.after_balance));
                    }
                } else if (data.type === 'reward') {
                    // Show trade result modal
                    $('#tradeing-success').addClass('hidden');
                    
                    $('#tradeResultModal').removeClass('hidden');

                    $('#profilt-trade-result').text(`${data.status === 'win' ? '+' : '-'}${formatAmount(data.profit)}`);
                    $('#profilt-trade-result').addClass(data.status === 'win' ? 'text-success' : 'text-danger');
                    $('#circle-progress-status').css('border-color', data.status === 'win' ? '#3ddeea' : '#e04b48');

                    // Update modal content
                    $('#result-symbol-name').text(data.symbol);


                    $('#result-amount').text(formatAmount(data.amount));
                    $('#result-period').text(data.period + 's');
                    $('#result-type').text(data.order_type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
                    $('#result-type').removeClass('text-red-500 text-cyan-500')
                        .addClass(data.order_type === 'buy' ? 'text-cyan-500' : 'text-red-500');
                    $('#result-close-price').text(formatAmount(data.current_price));
                    $('#result-open-price').text(formatAmount(data.open_price));
                    $('#result-close-price').removeClass('text-cyan-500 text-red-500')
                        .addClass(parseFloat(data.current_price) > parseFloat(data.open_price) ? 'text-cyan-500' : 'text-red-500');
                    reloadPage(['.balance-value', '.history-card', '#history-table', '#history-card-body'], ['.balance-value', '.history-card', '#history-table', '#history-card-body']);
                }
            };

            ws.onclose = function(e) {
                console.log(e);
                // console.log('WebSocket closed');
                if (reconnectAttempts < maxReconnectAttempts) {
                    reconnectAttempts++;
                    // console.log(`Kết nối lại (${reconnectAttempts}/${maxReconnectAttempts})...`);
                    setTimeout(connectWebSocket, reconnectDelay);
                } else {
                    // console.log('Max reconnection attempts reached');
                    Toastify({
                        text: "{{ __('index.connection_lost') }}",
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();

                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                }
            };

            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
            };
        }

        // Initial connection
        connectWebSocket();

        const getProfit = (amount) => {
            const winRate = parseInt($('.btn-time.active').data('win-rate'));
            const profit = (amount * winRate) / 100;
            console.log(winRate, profit);
            
            return profit;
        }

        let lastPrice = 0;
        let lastPriceChange = 0;
        let symbolActive = document.getElementById('symbol-active-data').value;
        symbolActive = symbolActive.toLowerCase();
        let socket = null;
        let socketTickerMap = new Map();
        let cp = null;

        function connectDepthSocket() {
            socket = new WebSocket("{{env('WEBSOCKET_URL')}}?symbols=" + JSON.stringify([symbolActive]) + "&depth=true");
            
            socket.onmessage = handleOrderBookMessage;
            
            socket.onclose = function() {
                console.log('Depth WebSocket closed');
                setTimeout(connectDepthSocket, 1000);
            };

            socket.onerror = function(error) {
                console.error('Depth WebSocket error:', error);
            };
        }

        function connectTickerSocket(symbol) {
            if (socketTickerMap.has(symbol)) {
                socketTickerMap.get(symbol).close();
            }

            const ws = new WebSocket(`{{env('WEBSOCKET_URL')}}?symbols=${JSON.stringify([symbol.toLowerCase()])}`);
            
            ws.onmessage = (event) => {
                let data = JSON.parse(event.data);
                if (data.type == 'marketData') {
                    data = data.data;
                    $('#price-change-' + symbol).text(data.P);
                    $('#price-change-' + symbol).addClass('text-[#e04b48]');
                    if (symbol.toLowerCase() == symbolActive) {
                        handleTickerMessage(data);
                        lastPrice = parseFloat(data.c);
                        let difference = parseFloat(data.c) - parseFloat(data.o);
                        let percentage = (difference / parseFloat(data.o)) * 100;
                        lastPriceChange = percentage;
                    }

                    $(`.last-price-${symbol}`).each(function() {
                        let symbol1 = $(this).data('symbol');
                        if(symbol1 == symbol) {
                            const closePrice = parseFloat(data.c);
                            const openPrice = parseFloat($('.open-price-'+symbol).text().replace(/,/g, ''));
                            $(this).text(parseFloat(data.c).toFixed(2));
                            $(this).removeClass('text-cyan-500 text-red-500');
                            $(this).addClass(closePrice < openPrice ? 'text-red-500' : 'text-cyan-500');
                            $(this).css('transition', 'all 0.3s ease');
                        }
                    });
                }
            };

            ws.onclose = function() {
                console.log(`Ticker WebSocket closed for ${symbol}`);
                setTimeout(() => connectTickerSocket(symbol), 1000);
            };

            ws.onerror = function(error) {
                console.error(`Ticker WebSocket error for ${symbol}:`, error);
            };

            socketTickerMap.set(symbol, ws);
        }

        // Initialize connections
        connectDepthSocket();
        const symbols = JSON.parse(document.getElementById('symbols-data').value);
        for (const symbol of symbols) {
            connectTickerSocket(symbol.symbol);
        }

        $('#selected-symbol').click(function() {
            $('#symbol-options').removeClass('hidden');
        });

        // Update symbol selection handler
        $('#symbol-options div').click(function() {
            const symbol = $(this).data('symbol');
            const icon = $(this).data('icon');
            const id = $(this).data('id');
            symbolActive = symbol.toLowerCase();
            $('#selected-symbol img').attr('src', icon);
            $('#selected-symbol span').text(symbol);
            $('#selected-symbol span').attr('data-id', id);

            $('#symbol-options').addClass('hidden');
            const randomParam = Math.random().toString(36).substring(7);
            const newSrc = 'https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22' + symbol + '%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D' + symbol + '%22%7D';

            $('#trading_view').find('iframe').remove();
            $('#trading_view').append('<iframe src="' + newSrc + '" frameborder="0" allowfullscreen="true" scrolling="no" class="w-full" style="height: 480px;"></iframe>');
            $('#chart-conten').find('iframe').remove();
            $('#chart-content').html('<iframe src="' + newSrc + '" frameborder="0" allowfullscreen="true" scrolling="no" class="w-full h-full" style="height: 380px;"></iframe>');

            // Reconnect depth socket for new symbol
            if (socket) {
                socket.close();
            }
            connectDepthSocket();

            // Fetch new order book data
            fetchOrderBook(symbolActive);
        });

        let typeTrade = 'buy';
        let timeTrade = 60;
        $('.btn-trade').click(function() {
            $(this).addClass('trade-active');
            $(this).siblings().removeClass('trade-active');
            const type = $(this).data('type');
            typeTrade = type;
            if (type == 'buy') {
                $('.btn-time').addClass('bg-[#3ddeea]');
                $('.btn-time').removeClass('bg-[#e04b48]');
                $('.btn-amount').removeClass('bg-[#e04b48]');
                $('.btn-amount').addClass('bg-[#3ddeea]');
                $('.submit-order').text("{{ __('index.buy') }}");
                $('.submit-order').removeClass('bg-[#e04b48]');
                $('.submit-order').addClass('bg-[#3ddeea]');

            } else {
                $('.btn-time').removeClass('bg-[#3ddeea]');
                $('.btn-time').addClass('bg-[#e04b48]');
                $('.btn-amount').removeClass('bg-[#3ddeea]');
                $('.btn-amount').addClass('bg-[#e04b48]');
                $('.submit-order').text("{{ __('index.sell') }}");
                $('.submit-order').removeClass('bg-[#3ddeea]');
                $('.submit-order').addClass('bg-[#e04b48]');
            }
        });

        $('.btn-time').click(function() {
            $(this).addClass('border-white border-2 active');
            $('.btn-time').not(this).removeClass('border-white border-2 active');
            timeTrade = $(this).data('time');
        });

        $('.btn-amount').click(function() {
            const amount = $(this).data('amount');
            $(this).addClass('active');
            $('.btn-amount').not(this).removeClass('active');
            if (amount == 'all') {
                $('.amount').val(parseFloat($('.balance-value').text().replace(/,/g, '')));
                $('.amount-mobile').val(parseFloat($('.balance-value').text().replace(/,/g, '')));
            } else {
                $('.amount').val(amount);
                $('.amount-mobile').val(amount);
            }
            $('.amount').trigger('input');
            $('.amount-mobile').trigger('input');
        });

        // $('#slider').on('input', function() {
        //     const value = $(this).val();
        //     const balance = parseFloat($('.balance-value').text().replace(/,/g, '')) || 0;
        //     const amount = (balance * value / 100).toFixed(2);
        //     $('.amount').val(amount);
        // });


        $('.set-value').click(function() {
            const value = $(this).data('value');
            $('#slider').val(value).trigger('input');
        });

        function formatAmount(amount){
            return amount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        $('.submit-order').click(function() {
            const time = $('.btn-time.active').data('time-id');
            const amount = window.innerWidth > 768 ? $('.amount').val() : $('.amount-mobile').val();
            const type = typeTrade;
            const symbol = $('#selected-symbol span').data('id');
            
            // Validate inputs
            if (amount == '' || amount == null || amount == undefined || amount <= 0) {
                Toastify({
                    text: "{{ __('index.please_enter_amount') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return;
            }

            if (time == null || time == undefined) {
                Toastify({
                    text: "{{ __('index.please_select_time') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return;
            }

            if (type == null || type == undefined) {
                Toastify({
                    text: "{{ __('index.please_select_order_type') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return;
            }

            // Show confirmation modal with trading-success style
            $('#confirm-order-modal').removeClass('hidden');
            $('#confirm-balance').text(formatAmount(parseFloat($('.balance-value').text().replace(/,/g, ''))));
            $('#confirm-symbol-name').text($('#selected-symbol span').text() + 'USDT');
            $('#confirm-trade-type').text(type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('#confirm-trade-type').removeClass('text-red-500 text-cyan-500 text-white')
                .addClass(type === 'buy' ? 'text-cyan-500' : 'text-red-500');
            $('#confirm-trade-type-1').text(type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('#confirm-trade-type-1').removeClass('text-red-500 text-cyan-500 text-white')
                .addClass(type === 'buy' ? 'text-cyan-500' : 'text-red-500');
            $('#confirm-trade-period').text($('.btn-time.active').find('span:first').text());
            $('#confirm-current-price').text(formatAmount(lastPrice));
            // $('#confirm-open-price').text(formatAmount(lastPrice));
            $('#confirm-trade-amount').text(formatAmount(parseFloat(amount)));
            $('#confirm-expected-profit').text(formatAmount(getProfit(parseFloat(amount))));
        });

        // Handle cancel button
        $('#cancel-confirm-order').click(function() {
            $('#confirm-order-modal').addClass('hidden');
        });

        // Handle confirm button
        $('#confirm-order').click(function() {
            const time = $('.btn-time.active').data('time-id');
            const amount = window.innerWidth > 768 ? $('.amount').val() : $('.amount-mobile').val();
            const type = typeTrade;
            const symbol = $('#selected-symbol span').data('id');

            // Hide confirmation modal
            $('#confirm-order-modal').addClass('hidden');

            // Disable button and show loading
            $('.submit-order').prop('disabled', true);
            $('.submit-order').html("<i class='fa-solid fa-spinner fa-spin'></i> {{ __('index.processing') }}...");

            // Make API call
            $.ajax({
                url: "{{ route('tradingPlace') }}",
                type: "POST",
                data: {
                    time: time,
                    amount: amount,
                    type: type,
                    symbol: symbol,
                    last_price: lastPrice,
                    last_price_change: lastPriceChange,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                    $('#tradeing-success').removeClass('hidden');
                    cp = $('#circle-progress').circleProgress({
                        value: 100,
                        size: 150,
                        startAngle: -Math.PI / 2,
                        emptyFill: 'rgba(255, 0, 0, 0.5)', // màu đổ
                        fill: {
                            color: '#3ddeea',
                        }
                    })
                    $('#entry-price').text(formatAmount(parseFloat(response.trade.open_price).toFixed(2)));
                    $('.last-price-mobile').removeClass('text-white');
                    $('.last-price-mobile').addClass('last-price-'+response.trade.symbol.symbol);
                    $('.last-price-mobile').attr('data-symbol', response.trade.symbol.symbol);
                    $('#trade-period').text(response.time + 's');
                    $('#trade-type').text(response.trade.type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
                    $('#trade-type').removeClass('text-red-500 text-cyan-500 text-white text-black')
                        .addClass(response.trade.type === 'buy' ? 'text-cyan-500' : 'text-red-500');
                    $('#trade-amount').text(formatAmount(response.trade.amount));
                    $('#trade-open-price').text(formatAmount(response.trade.open_price));
                    $('#circle-progress').attr('data-trade-at', response.trade.trade_at);
                    $('#circle-progress').attr('data-trade-end', response.trade.trade_end);
                    $('#circle-progress').append('<strong style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);font-size:30px;color:#fff;font-weight:bold;"></strong>');
                    reloadPage(['.balance-value', '.history-card', '#history-table', '#history-card-body', '.last-price-mobile'], ['.balance-value', '.history-card', '#history-table', '#history-card-body', '.last-price-mobile']);
                },
                error: function(response) {
                    Toastify({
                        text: response.responseJSON.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();
                },
                complete: function() {
                    $('.submit-order').prop('disabled', false);
                    $('.submit-order').html("{{ __('index.buy') }}");
                }
            });
        });

        function updateBetStatus() {
            function convertToTimestamp(dateStr) {
                return new Date(dateStr).getTime(); // Chuyển thành milliseconds
            }
            $('.profit-column').each(function() {
                const startTime = convertToTimestamp($(this).data('trade-at'));
                const endTime = convertToTimestamp($(this).data('reward-time'));
                const progressDiv = document.createElement('div');
                progressDiv.className = 'w-full h-4 bg-gray-700 rounded relative';
                const progressBarDiv = document.createElement('div');
                progressBarDiv.className = 'h-full rounded transition-all duration-500';
                const percentText = document.createElement('span');
                percentText.className = 'absolute inset-0 flex items-center justify-center text-xs text-white font-semibold';
                progressDiv.appendChild(progressBarDiv);
                progressDiv.appendChild(percentText);
                $(this).html(progressDiv);
                const column = $(this);
                let interval;

                function updateProgressBar() {
                    const now = Date.now();
                    const diff = endTime - startTime;
                    const elapsed = now - startTime;
                    let progress = Math.min(elapsed / diff, 1);
                    let percent = Math.round(progress * 100);

                    progressBarDiv.style.width = percent + '%';
                    percentText.textContent = percent + '%';
                    if (percent <= 33) {
                        progressBarDiv.className += ' bg-red-500'; // Đỏ
                    } else if (percent <= 66) {
                        progressBarDiv.className += ' bg-yellow-500'; // Vàng
                    } else if (percent <= 100) {
                        progressBarDiv.className += ' bg-green-500'; // Xanh lá
                    } else {
                        progressBarDiv.className += ' bg-gray-200'; // Xám
                    }

                    if (progress >= 1) {
                        clearInterval(interval);
                        if(window.innerWidth > 768){
                            column.html('<span class="text-white text-1xl">' + column.data('profit') + '</span>');
                        }else{
                            column.html('');
                        }
                    }

                }

                updateProgressBar();
                interval = setInterval(updateProgressBar, 1000);
            })
        }
        updateBetStatus()
        setInterval(updateBetStatus, 1000);

        function updateCircleProgress() {
            const now = Date.now();

            function convertToTimestamp(dateStr) {
                return new Date(dateStr).getTime(); // Chuyển thành milliseconds
            }
            if (cp != null) {
                const tradeEnd = convertToTimestamp($('#circle-progress').attr('data-trade-end'));
                const tradeAt = convertToTimestamp($('#circle-progress').attr('data-trade-at'));

                const diff = tradeEnd - tradeAt;
                const elapsed = now - tradeAt;
                let progress = Math.min(elapsed / diff, 1);
                let percent = Math.round(progress * 100);
                let seconds = Math.round((diff - elapsed) / 1000);
                if(seconds < 0 || seconds == null || seconds == undefined){
                    seconds = 0;
                }
                // $('#circle-progress').circleProgress('value', progress);
                $('#circle-progress strong').text(seconds + 's');
            }
        }
        updateCircleProgress();
        setInterval(updateCircleProgress, 1000);

        function showTab(tab) {
            $('.active-tab').removeClass('active-tab');
            $(`#${tab}`).addClass('active-tab');
        }

        $('.change-tab').click(function() {
            const tab = $(this).data('tab');
            if (tab == 'order-book') {
                $('#order-book').show();
                $('#chart').hide();
                $('#history').hide();
                $(this).addClass('border-[#3ddeea] border-b-2 text-[#3ddeea]');
                $('.change-tab').not(this).removeClass('border-[#3ddeea] border-b-2 text-[#3ddeea]').addClass('text-gray-400');

            } else if (tab == 'chart') {
                $('#order-book').hide();
                $('#chart').show();
                $('#history').hide();
                $(this).addClass('border-[#3ddeea] border-b-2 text-[#3ddeea]');
                $('.change-tab').not(this).removeClass('border-[#3ddeea] border-b-2 text-[#3ddeea]').addClass('text-gray-400');
            } else if (tab == 'history') {
                $('#order-book').hide();
                $('#chart').hide();
                $('#history').show();
                $(this).addClass('border-[#3ddeea] border-b-2 text-[#3ddeea]');
                $('.change-tab').not(this).removeClass('border-[#3ddeea] border-b-2 text-[#3ddeea]').addClass('text-gray-400');
            }
        });

        function handleOrderBookMessage(event) {
            const data = JSON.parse(event.data);
            if (data.type == 'depthData') {
                updateOrderBookWebSocket(data.data);
            }
        };

        function formatNumber(num) {
            if (num === null || num === undefined) return '0';

            const units = ['', 'K', 'M', 'B', 'T', 'Q'];
            let unitIndex = 0;

            while (Math.abs(num) >= 1000 && unitIndex < units.length - 1) {
                num /= 1000;
                unitIndex++;
            }

            return num % 1 === 0 ?
                num + units[unitIndex] :
                num.toFixed(1).replace(/\.0$/, '') + units[unitIndex];
        }

        function handleTickerMessage(data) {
            // Update ticker information here
            $('.last-price').text(parseFloat(data.c).toFixed(2));
            $('.last-price').css('color', data.P > 0 ? '#3ddeea' : '#e04b48');
            $('.last-price').css('transition', 'all 0.3s ease');
            $('#current-price').text(parseFloat(data.c).toFixed(2));
            $('#current-price').css('color', data.P > 0 ? '#3ddeea' : '#e04b48');
            $('#current-price').css('transition', 'all 0.3s ease');
            $('#current-price-change').text(data.P + '%');
            $('#current-price-change').css('color', parseFloat(data.P) > 0 ? '#3ddeea' : '#e04b48');
            $('#current-price-change').css('transition', 'all 0.3s ease');
            $('#high-price').text(parseFloat(data.h).toFixed(2));
            $('#low-price').text(parseFloat(data.l).toFixed(2));
            $('#high-price').css('color', parseFloat(data.P) > 0 ? '#3ddeea' : '#e04b48');
            $('#low-price').css('color', parseFloat(data.P) > 0 ? '#3ddeea' : '#e04b48');
            $('#high-price').css('transition', 'all 0.3s ease');
            $('#low-price').css('transition', 'all 0.3s ease');
            $('#volume').text(formatNumber(data.v));
            $('#volume').css('color', parseFloat(data.P) > 0 ? '#3ddeea' : '#e04b48');
            $('#volume').css('transition', 'all 0.3s ease');
            $('#volume-usdt').text(formatNumber(data.q));
            $('#volume-usdt').css('color', parseFloat(data.P) > 0 ? '#3ddeea' : '#e04b48');
            $('#volume-usdt').css('transition', 'all 0.3s ease');
            $('#last-update-id').text(parseFloat(data.c).toFixed(2));
            if (parseFloat(data.P) > 0) {
                $('#last-update-id').css('color', '#3ddeea');
            } else {
                $('#last-update-id').css('color', '#e04b48');
            }
            $('#icon-arrow').css('transition', 'all 0.3s ease');
            $('#icon-arrow').css('color', parseFloat(data.P) > 0 ? '#3ddeea' : '#e04b48');
            $('#icon-arrow').find('i').removeClass('fa-arrow-up');
            $('#icon-arrow').find('i').addClass(parseFloat(data.P) > 0 ? 'fa-arrow-up' : 'fa-arrow-down');
        }

        function fetchOrderBook(symbol) {
            $.ajax({
                url: `{{env('API_URL')}}/binance/depth/${symbol.toUpperCase()}`,
                method: 'GET',
                success: function(data) {
                    updateOrderBook(data);

                },
                error: function(error) {
                    console.error('Error fetching order book:', error);
                }
            });
        }
        let lastUpdateId = 0;

        function updateOrderBook(data) {
            const orderBookContent = document.getElementById('order-book-content');
            if (!orderBookContent) {
                console.warn('Order book content element not found');
                return;
            }

            const bids = data.bids.map(bid => ({
                price: parseFloat(bid[0]),
                quantity: parseFloat(bid[1])
            })) || [];
            const asks = data.asks.map(ask => ({
                price: parseFloat(ask[0]),
                quantity: parseFloat(ask[1])
            })) || [];
            let orderBookHtml = '';

            const maxVolume = Math.max(
                ...asks.map(ask => ask.quantity),
                ...bids.map(bid => bid.quantity)
            );

            asks.forEach(ask => {
                const volume = ask.quantity;
                const widthPercent = (volume / maxVolume) * 100;
                const price = ask.price;
                if (isNaN(price)) {
                    return;
                }
                orderBookHtml += `
                    <div class="flex mb-2 rounded-md relative overflow-hidden">
                        <span class="w-1/3 text-[#e04b48] z-10 text-1xl">${price.toFixed(2)}</span>
                        <span class="w-1/3 z-10 text-1xl text-white">${volume.toFixed(6)}</span>
                        <span class="w-1/3 z-10 text-1xl text-white text-right">${(price * volume).toFixed(2)}</span>
                        <div class="absolute top-0 right-0 h-full bg-gradient-to-r from-[#CD5C5C]/50 to-[#e04b48]/50 rounded-md animate-slide z-0" style="width: ${widthPercent}%;"></div>
                    </div>
                `;
            });

            orderBookHtml += `
                <div class="font-bold text-base my-2">
                    <span class="w-1/3 text-gray-400" id="last-update-id">${data.currentPrice ? data.currentPrice.toFixed(2) : lastPrice.toFixed(2)}</span>
                    <span class="w-1/3 text-right text-gray-400" id="icon-arrow">
                        <i class="fa-solid fa-arrow-up"></i>
                    </span>
                </div>
            `;

            bids.forEach(bid => {
                const volume = bid.quantity;
                const widthPercent = (volume / maxVolume) * 100;
                orderBookHtml += `
                    <div class="flex mb-2 rounded-md relative overflow-hidden">
                        <span class="w-1/3 text-[#3ddeea] z-10 text-1xl">${bid.price.toFixed(2)}</span>
                        <span class="w-1/3 z-10 text-1xl text-white">${volume.toFixed(6)}</span>
                        <span class="w-1/3 z-10 text-1xl text-white text-right">${(bid.price * volume).toFixed(2)}</span>
                        <div class="absolute top-0 right-0 h-full bg-gradient-to-r from-[#3ddeea]/50 to-[#3ddeea]/50 rounded-md animate-slide z-0" style="width: ${widthPercent}%;"></div>
                    </div>
                `;
            });

            try {
                orderBookContent.innerHTML = orderBookHtml;
            } catch (error) {
                console.error('Error updating order book content:', error);
            }
        }

        function updateOrderBookWebSocket(data) {
            const orderBookContent = document.getElementById('order-book-content');
            if (!orderBookContent) {
                console.warn('Không tìm thấy phần tử nội dung sổ lệnh');
                return;
            }
            if(!data || !data.b || !data.a) return;
            const bids = data?.b.slice(0, 8).map(bid => ({
                price: parseFloat(bid[0]),
                quantity: parseFloat(bid[1])
            })) || [];
            const asks = data?.a.slice(0, 8).map(ask => ({
                price: parseFloat(ask[0]),
                quantity: parseFloat(ask[1])
            })) || [];
            let orderBookHtml = '';

            const maxVolume = Math.max(
                ...asks.map(ask => ask.quantity),
                ...bids.map(bid => bid.quantity)
            );

            asks.forEach(ask => {
                const volume = ask.quantity;
                const widthPercent = (volume / maxVolume) * 100;
                const price = ask.price;
                if (isNaN(price)) {
                    return;
                }
                orderBookHtml += `
                    <div class="flex mb-2 rounded-md relative overflow-hidden">
                        <span class="w-1/3 text-[#e04b48] z-10 text-sm">${price.toFixed(2)}</span>
                        <span class="w-1/3 z-10 text-sm text-white">${volume.toFixed(6)}</span>
                        <span class="w-1/3 z-10 text-sm text-white text-right">${(price * volume).toFixed(2)}</span>
                        <div class="absolute top-0 right-0 h-full bg-gradient-to-r from-[#CD5C5C]/50 to-[#e04b48]/50 rounded-md animate-slide z-0" style="width: ${widthPercent}%;"></div>
                    </div>
                `;
            });

            orderBookHtml += `
                <div class="font-bold text-base my-2">
                    <span class="w-1/3 text-gray-400" id="last-update-id">${data.currentPrice ? data.currentPrice.toFixed(2) : lastPrice.toFixed(2)}</span>
                    <span class="w-1/3 text-right text-gray-400" id="icon-arrow">
                        <i class="fa-solid fa-arrow-up"></i>
                    </span>
                </div>
            `;

            bids.forEach(bid => {
                const volume = bid.quantity;
                const widthPercent = (volume / maxVolume) * 100;
                orderBookHtml += `
                    <div class="flex mb-2 rounded-md relative overflow-hidden">
                        <span class="w-1/3 text-[#3ddeea] z-10 text-sm">${bid.price.toFixed(2)}</span>
                        <span class="w-1/3 z-10 text-sm text-white">${volume.toFixed(6)}</span>
                        <span class="w-1/3 z-10 text-sm text-white text-right">${(bid.price * volume).toFixed(2)}</span>
                        <div class="absolute top-0 right-0 h-full bg-gradient-to-r from-[#3ddeea]/50 to-[#3ddeea]/50 rounded-md animate-slide z-0" style="width: ${widthPercent}%;"></div>
                    </div>
                `;
            });

            try {
                orderBookContent.innerHTML = orderBookHtml;
            } catch (error) {
                console.error('Lỗi khi cập nhật nội dung sổ lệnh:', error);
            }
        }



        $('.btn-trading').click(function() {
            $('#mobile-modal').toggleClass('translate-y-full');
        });

        $('#close-modal').click(function() {
            $('#mobile-modal').addClass('translate-y-full');
        });

        // Thêm xử lý click outside để đóng modal
        $(document).on('click', function(e) {
            if ($(e.target).closest('#mobile-modal').length === 0 && !$(e.target).closest('.btn-trading').length) {
                $('#mobile-modal').addClass('translate-y-full');
            }
        });

        function handleTickerAllMessage(event) {
            const data = JSON.parse(event.data);;
        }

        $(document).on('click', '#close-tradeing-success', function() {
            $('#tradeing-success').addClass('hidden');
        });

        // Click handler for viewing contract details
        $(document).on('click', '.view-detail', function() {
            const data = $(this).data();
            console.log(data);
            
            // Update modal content
            $('.contract-symbol').text(data.symbol);
            $('.contract-amount').text(data.amount);
            $('.contract-time').text(data.time);
            $('.contract-type').text(data.type == 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('.contract-type').removeClass('text-[#3ddeea] text-[#e04b48]')
                .addClass(data.type === 'buy' ? 'text-[#3ddeea]' : 'text-[#e04b48]');
            $('.contract-open-price').text(data.openPrice);
            $('.contract-open-time').text(data.openTime);
            if (data.profit == '∞') {
                $('.contract-close-price').text(parseFloat(lastPrice).toFixed(2));
                $('.contract-profit').text('∞');
            } else {
                $('.contract-close-price').text(data.closePrice);
                $('.contract-profit').text((data.result == 'win' ? '+' : '-') + data.profit);
                $('.contract-profit').removeClass('text-[#3ddeea] text-[#e04b48]').addClass(data.result == 'win' ? 'text-[#3ddeea]' : 'text-[#e04b48]');
            }
            $('.contract-close-time').text(data.closeTime);
            $('.contract-balance').text(data.afterBalance);
           
            $('#contract-time-unit').text((data.timeUnit === 'm' ? data.timeSession * 60 : (data.timeUnit === 'h' ? data.timeSession * 3600 : data.timeSession * 86400)) + 's');

            // Show modal with animation
            $('#contractDetailModal').removeClass('hidden');
            setTimeout(() => {
                $('.modal-content').removeClass('translate-y-full');
            }, 10);
        });

        // Close modal with animation
        function closeContractDetail() {
            $('.modal-content').addClass('translate-y-full');
            setTimeout(() => {
                $('#contractDetailModal').addClass('hidden');
            }, 300);
        }

        // Close modal when clicking overlay
        $('#close-contract-detail').click(function(e) {
            closeContractDetail();
        });

        // Load more functionality
        function loadMoreTrades(page, isMobile) {
            console.log(page, isMobile);
            
            $.ajax({
                url: "{{ route('loadMoreTrades') }}",
                type: "GET",
                data: {
                    page: page,
                    is_mobile: isMobile
                },
                success: function(response) {
                    if (isMobile) {
                        // For mobile view - append cards
                        if (response.html) {
                            $('#history-card-body').append(response.html);
                            // Reinitialize any necessary event handlers for new cards
                            $('.view-detail').off('click').on('click', function() {
                                const data = $(this).data();
                                $('.contract-symbol').text(data.symbol);
                                $('.contract-amount').text(data.amount);
                                $('.contract-type').text(data.type == 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
                                $('.contract-type').removeClass('text-[#3ddeea] text-[#e04b48]')
                                    .addClass(data.type === 'buy' ? 'text-[#3ddeea]' : 'text-[#e04b48]');
                                $('.contract-open-price').text(data.openPrice);
                                $('.contract-open-time').text(data.openTime);
                                if (data.profit == '∞') {
                                    $('.contract-close-price').text(parseFloat(lastPrice).toFixed(2));
                                    $('.contract-profit').text('∞');
                                } else {
                                    $('.contract-close-price').text(data.closePrice);
                                    $('.contract-profit').text((data.result == 'win' ? '+' : '-') + data.profit);
                                    $('.contract-profit').removeClass('text-[#3ddeea] text-[#e04b48]').addClass(data.result == 'win' ? 'text-[#3ddeea]' : 'text-[#e04b48]');
                                }
                                $('.contract-close-time').text(data.closeTime);
                                $('#contract-time-unit').text(data.timeSession + ' ' + data.timeUnit);
                                $('#contractDetailModal').removeClass('hidden');
                                setTimeout(() => {
                                    $('.modal-content').removeClass('translate-y-full');
                                }, 10);
                            });
                        }
                        if (!response.hasMorePages) {
                            $('#load-more-mobile').hide();
                        } else {
                            $('#load-more-mobile').data('page', response.nextPage);
                        }
                    } else {
                        // For desktop view - append rows
                        if (response.html) {
                            // Remove the "no data" row if it exists
                            $('#history-table-body tr td[colspan="6"]').parent().remove();
                            $('#history-table-body').append(response.html);
                            
                            // Reinitialize any necessary event handlers for new rows
                            $('.profit-column').each(function() {
                                const startTime = convertToTimestamp($(this).data('trade-at'));
                                const endTime = convertToTimestamp($(this).data('reward-time'));
                                const progressDiv = document.createElement('div');
                                progressDiv.className = 'w-full h-4 bg-gray-700 rounded relative';
                                const progressBarDiv = document.createElement('div');
                                progressBarDiv.className = 'h-full rounded transition-all duration-500';
                                const percentText = document.createElement('span');
                                percentText.className = 'absolute inset-0 flex items-center justify-center text-xs text-white font-semibold';
                                progressDiv.appendChild(progressBarDiv);
                                progressDiv.appendChild(percentText);
                                $(this).html(progressDiv);
                                const column = $(this);
                                let interval;

                                function updateProgressBar() {
                                    const now = Date.now();
                                    const diff = endTime - startTime;
                                    const elapsed = now - startTime;
                                    let progress = Math.min(elapsed / diff, 1);
                                    let percent = Math.round(progress * 100);

                                    progressBarDiv.style.width = percent + '%';
                                    percentText.textContent = percent + '%';
                                    if (percent <= 33) {
                                        progressBarDiv.className += ' bg-red-500';
                                    } else if (percent <= 66) {
                                        progressBarDiv.className += ' bg-yellow-500';
                                    } else if (percent <= 100) {
                                        progressBarDiv.className += ' bg-green-500';
                                    } else {
                                        progressBarDiv.className += ' bg-gray-200';
                                    }

                                    if (progress >= 1) {
                                        clearInterval(interval);
                                        if(window.innerWidth > 768){
                                            column.html('<span class="text-[#3ddeea] text-1xl">' + column.data('profit') + '</span>');
                                        }else{
                                            column.html('');
                                        }
                                    }
                                }

                                updateProgressBar();
                                interval = setInterval(updateProgressBar, 1000);
                            });
                        }
                        if (!response.hasMorePages) {
                            $('#load-more-desktop').hide();
                        } else {
                            $('#load-more-desktop').data('page', response.nextPage);
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error loading more trades:', xhr);
                }
            });
        }

        $('#load-more-desktop').click(function() {
            const page = $(this).data('page');
            loadMoreTrades(page, false);
        });

        $('#load-more-mobile').click(function() {
            const page = $(this).data('page');
            loadMoreTrades(page, true);
        });

        // Close trade result modal
        $('#close-trade-result').click(function() {
            $('#tradeResultModal').addClass('hidden');
        });


    });
</script>
@endsection
<!-- End of Selection -->