@extends('user.layouts.app')
@section('title', __('index.bitget_earning.title'))
@section('content')
<div class="border-b border-bitget-light pt-20">
    <div class="mx-auto max-w-7xl px-4 flex gap-2 sm:gap-6 overflow-auto whitespace-nowrap">
        <button class="earning-tab px-4 sm:px-6 py-3 text-bitget-dark border-b-2 border-bitget font-semibold bg-transparent transition" data-tab="overview">{{ __('index.bitget_earning.overview') }}</button>
        <button class="earning-tab px-4 sm:px-6 py-3 text-bitget-dark hover:border-bitget/70 border-b-2 border-transparent font-semibold bg-transparent transition" data-tab="flex">{{ __('index.bitget_earning.flexible') }}</button>
        <button class="earning-tab px-4 sm:px-6 py-3 text-bitget-dark hover:border-bitget/70 border-b-2 border-transparent font-semibold bg-transparent transition" data-tab="fixed">{{ __('index.bitget_earning.fixed') }}</button>
        <button class="earning-tab px-4 sm:px-6 py-3 text-bitget-dark hover:border-bitget/70 border-b-2 border-transparent font-semibold bg-transparent transition" data-tab="staking">{{ __('index.bitget_earning.staking') }}</button>
        <button class="earning-tab px-4 sm:px-6 py-3 text-bitget-dark hover:border-bitget/70 border-b-2 border-transparent font-semibold bg-transparent transition" data-tab="launchpool">{{ __('index.bitget_earning.launchpool') }}</button>
    </div>
</div>
<section class="earning-tab-content mt-16" data-tab="overview">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-[#1f2023] to-[#2a2d31] rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center gap-8 p-8">
                <div class="flex-1 min-w-0">
                    <h1 class="text-1xl md:text-4xl font-bold mb-4 bg-gradient-to-r from-bitget to-[#2ecc71] bg-clip-text text-transparent">
                        {{ __('index.bitget_earning.banner_title') }}
                    </h1>
                    <ul class="mb-6 text-white/90 space-y-3">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-bitget" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('index.bitget_earning.feature_1') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-bitget" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('index.bitget_earning.feature_2') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-bitget" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('index.bitget_earning.feature_3') }}</span>
                        </li>
                    </ul>
                    <div class="flex flex-wrap gap-4 py-3">
                        <button class="bg-cyan-400 px-6 py-3 text-white font-semibold rounded-lg shadow-lg hover:bg-cyan-500 transition transform hover:scale-105">
                            {{ __('index.bitget_earning.start_now') }}
                        </button>
                    </div>
                </div>
                <div class="flex-shrink-0 relative md:block hidden">
                    <div class="absolute -inset-4 bg-bitget/20 blur-xl rounded-full"></div>
                    <img src="{{ asset('images/banner-heo.png') }}" 
                         alt="{{ __('index.bitget_earning.title') }}" 
                         class="relative w-80 max-w-full rounded-2xl transform hover:scale-105 transition-transform duration-500" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="earning-tab-content" data-tab="overview">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-xl font-bold mb-4 text-bitget-dark">{{ __('index.bitget_earning.featured_products') }}</h2>
        <div class="swiper earning-swiper">
            <div class="swiper-wrapper">
                @foreach($symbols as $symbol)
                <div class="swiper-slide">
                    <div class="rounded-lg bg-[#1f2023] shadow p-6 min-w-[250px] w-full flex flex-col items-start">
                        <div class="flex items-center gap-2 mb-2">
                            <img src="{{$symbol->image}}" alt="{{$symbol->symbol}}" class="h-8 w-8" />
                            <span class="font-bold text-white text-lg">{{$symbol->symbol}}</span>
                            <span class="text-bitget bg-bitget/10 px-2 py-0.5 rounded text-xs ml-2">{{ __('index.bitget_earning.flexible_tag') }}</span>
                        </div>
                        <div class="flex w-full gap-4">
                            <div class="flex-1">
                                <div class="text-gray-400 mb-2">{{ __('index.bitget_earning.price') }} <span class="text-bitget font-semibold text-lg" id="price-{{$symbol->symbol}}">--</span></div>
                                <div class="text-gray-400 mb-2">{{ __('index.bitget_earning.24h_change') }} <span class="text-bitget font-semibold text-lg" id="change-{{$symbol->symbol}}">--</span></div>
                                <div class="text-xs text-gray-400">{{ __('index.bitget_earning.volume') }}: <span id="volume-{{$symbol->symbol}}">--</span></div>
                            </div>
                            <div class="flex-1 h-24">
                                <canvas id="chart-{{$symbol->symbol}}" class="w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex items-center justify-center gap-2 mt-4">
                <button class="swiper-prev rounded-full p-2 bg-bitget-light hover:bg-bitget transition" aria-label="Previous slide"><svg width="16" height="16" fill="none" aria-hidden="true">
                        <path d="M10 12L6 8L10 4" stroke="#19b488" stroke-width="2" stroke-linecap="round" />
                    </svg></button>
                <button class="swiper-next rounded-full p-2 bg-bitget-light hover:bg-bitget transition" aria-label="Next slide"><svg width="16" height="16" fill="none" aria-hidden="true">
                        <path d="M6 4L10 8L6 12" stroke="#19b488" stroke-width="2" stroke-linecap="round" />
                    </svg></button>
            </div>
        </div>
    </div>
</section>

<!-- Realtime Table -->
<section class="earning-tab-content" data-tab="overview">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase">{{ __('index.bitget_earning.pair') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase">{{ __('index.bitget_earning.price') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase">{{ __('index.bitget_earning.24h_change') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase">{{ __('index.bitget_earning.chart') }}</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase">{{ __('index.bitget_earning.action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="" id="binance-table-body">
                        @foreach($symbols as $symbol)
                        <tr class="hover:bg-gray-800/50 transition-colors border-b border-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-white flex items-center">
                                        <img src="{{$symbol->image}}" alt="{{$symbol->symbol}}" class="w-4 h-4 mr-2">
                                        {{$symbol->symbol}}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-white" id="table-price-{{$symbol->symbol}}">--</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm" id="table-change-{{$symbol->symbol}}">--</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-32 h-16">
                                    <canvas id="table-chart-{{$symbol->symbol}}" class="w-full h-full"></canvas>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('trading', ['symbol' => $symbol->symbol]) }}" class="text-sm hover:text-cyan-400 text-white px-4 py-2 rounded hover:bg-bitget-dark">{{ __('index.bitget_earning.trading') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const setActiveTab = (tab) => {
        document.querySelectorAll('.earning-tab').forEach(btn => {
            if (btn.dataset.tab === tab) {
                btn.classList.add('border-bitget', 'text-bitget');
                btn.classList.remove('border-transparent', 'text-bitget-dark');
            } else {
                btn.classList.remove('border-bitget', 'text-bitget');
                btn.classList.add('border-transparent', 'text-bitget-dark');
            }
        });
    };

    document.querySelectorAll('.earning-tab').forEach(btn => {
        btn.addEventListener('click', () => setActiveTab(btn.dataset.tab));
    });

    window.addEventListener('DOMContentLoaded', async () => {
        setActiveTab('overview');

        if (document.querySelector('.earning-swiper')) {
            const swiper = new Swiper('.earning-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                grabCursor: true,
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
                navigation: {
                    nextEl: '.swiper-next',
                    prevEl: '.swiper-prev',
                },
            });
        }

        // Initialize charts
        const symbols = {!! json_encode($symbols) !!};
        const charts = {};
        const priceHistory = {};

        // Initialize charts with empty data
        symbols.forEach(symbol => {
            // Initialize swiper chart
            const ctx = document.getElementById(`chart-${symbol.symbol}`);
            if (ctx) {
                priceHistory[symbol.symbol] = [];
                charts[symbol.symbol] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Price',
                            data: [],
                            borderColor: '#19b488',
                            borderWidth: 2,
                            pointRadius: 0,
                            tension: 0.4,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                        animation: {
                            duration: 0
                        }
                    }
                });
            }

            // Initialize table chart
            const tableCtx = document.getElementById(`table-chart-${symbol.symbol}`);
            if (tableCtx) {
                charts[`table-${symbol.symbol}`] = new Chart(tableCtx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Price',
                            data: [],
                            borderColor: '#19b488',
                            borderWidth: 2,
                            pointRadius: 0,
                            tension: 0.4,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                        animation: {
                            duration: 0
                        }
                    }
                });
            }
        });

        // Fetch initial historical data for each symbol
        try {
            const fetchPromises = symbols.map(async (symbol) => {
                const response = await fetch(`https://api.binance.com/api/v3/klines?symbol=${symbol.symbol}&interval=1m&limit=50`);
                const data = await response.json();
                
                // Extract closing prices
                const prices = data.map(candle => parseFloat(candle[4]));
                priceHistory[symbol.symbol] = prices;

                // Update swiper chart with historical data
                const chart = charts[symbol.symbol];
                if (chart) {
                    chart.data.labels = Array(prices.length).fill('');
                    chart.data.datasets[0].data = prices;
                    chart.update();
                }

                // Update table chart with historical data
                const tableChart = charts[`table-${symbol.symbol}`];
                if (tableChart) {
                    tableChart.data.labels = Array(prices.length).fill('');
                    tableChart.data.datasets[0].data = prices;
                    tableChart.update();
                }

                // Update initial price display
                const priceElement = document.getElementById(`price-${symbol.symbol}`);
                if (priceElement) {
                    priceElement.textContent = prices[prices.length - 1].toFixed(2);
                }
            });

            await Promise.all(fetchPromises);
        } catch (error) {
            console.error('Error fetching historical data:', error);
        }

        // Binance WebSocket connection
        const ws = new WebSocket('wss://stream.binance.com:9443/ws');

        // Subscribe to ticker streams for all symbols
        const subscribeMsg = {
            method: 'SUBSCRIBE',
            params: symbols.map(symbol => symbol.symbol.toLowerCase() + '@ticker'),
            id: 1
        };

        ws.onopen = () => ws.send(JSON.stringify(subscribeMsg));

        // Handle incoming WebSocket messages
        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            if (data.s) { // Ticker data
                const symbol = data.s;
                const price = parseFloat(data.c).toFixed(2);
                const priceChange = parseFloat(data.P).toFixed(2);
                const high = parseFloat(data.h).toFixed(2);
                const low = parseFloat(data.l).toFixed(2);
                const volume = (parseFloat(data.v) * parseFloat(data.c)).toFixed(2);

                // Update price history and charts
                if (priceHistory[symbol]) {
                    // Append new price to history
                    priceHistory[symbol].push(price);
                    if (priceHistory[symbol].length > 20) {
                        priceHistory[symbol].shift();
                    }

                    // Update swiper chart
                    const chart = charts[symbol];
                    if (chart) {
                        chart.data.labels = Array(priceHistory[symbol].length).fill('');
                        chart.data.datasets[0].data = priceHistory[symbol];
                        chart.update('none'); // Disable animation for smoother updates
                    }

                    // Update table chart
                    const tableChart = charts[`table-${symbol}`];
                    if (tableChart) {
                        tableChart.data.labels = Array(priceHistory[symbol].length).fill('');
                        tableChart.data.datasets[0].data = priceHistory[symbol];
                        tableChart.update('none'); // Disable animation for smoother updates
                    }
                }

                // Update swiper cards
                const priceElement = document.getElementById(`price-${symbol}`);
                if (priceElement) {
                    priceElement.textContent = price;
                    priceElement.classList.add('flash');
                    setTimeout(() => priceElement.classList.remove('flash'), 1000);
                }

                const changeElement = document.getElementById(`change-${symbol}`);
                if (changeElement) {
                    changeElement.textContent = (priceChange >= 0 ? '+' : '') + priceChange + '%';
                    changeElement.className = 'text-bitget font-semibold text-lg ' + (priceChange >= 0 ? 'text-green-500' : 'text-red-500');
                }

                const volumeElement = document.getElementById(`volume-${symbol}`);
                if (volumeElement) volumeElement.textContent = formatVolume(volume);

                // Update table
                const tablePriceElement = document.getElementById(`table-price-${symbol}`);
                if (tablePriceElement) {
                    tablePriceElement.textContent = price;
                    tablePriceElement.classList.add('flash');
                    setTimeout(() => tablePriceElement.classList.remove('flash'), 1000);
                }

                const tableChangeElement = document.getElementById(`table-change-${symbol}`);
                if (tableChangeElement) {
                    tableChangeElement.textContent = (priceChange >= 0 ? '+' : '') + priceChange + '%';
                    tableChangeElement.className = 'text-sm ' + (priceChange >= 0 ? 'text-green-500' : 'text-red-500');
                }

                const tableHighElement = document.getElementById(`table-high-${symbol}`);
                if (tableHighElement) tableHighElement.textContent = high;

                const tableLowElement = document.getElementById(`table-low-${symbol}`);
                if (tableLowElement) tableLowElement.textContent = low;

                const tableVolumeElement = document.getElementById(`table-volume-${symbol}`);
                if (tableVolumeElement) tableVolumeElement.textContent = formatVolume(volume);
            }
        };

        function formatVolume(num) {
            if (num >= 1000000000) {
                return (num / 1000000000).toFixed(2) + 'B';
            }
            if (num >= 1000000) {
                return (num / 1000000).toFixed(2) + 'M';
            }
            if (num >= 1000) {
                return (num / 1000).toFixed(2) + 'K';
            }
            return num.toFixed(2);
        }
    });
</script>
@endsection