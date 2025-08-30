@extends('user.layouts.app')
@section('title', __('index.market.title'))
@section('content')

<!-- Breadcrumbs & Title -->
<div class="max-w-7xl mx-auto px-6 pt-20">
    <h1 class="text-4xl mb-8 text-white">{{ __('index.market.title') }}</h1>
</div>

<div class="max-w-7xl mx-auto px-4 pb-16">
    <!-- <div class="flex gap-4 mb-6 text-gray-400">
        <a href="#" class="px-4 py-2 bg-gray-800 rounded-md">{{ __('index.market.usdt_m_futures') }}</a>
        <a href="#" class="px-4 py-2">{{ __('index.market.coin_m_futures') }}</a>
        <a href="#" class="px-4 py-2">{{ __('index.market.usdc_m_futures') }}</a>
    </div> -->

    <div class="overflow-x-auto rounded-lg bg-[#1a1b1e]">
        <table class="w-full">
            <thead>
                <tr class="text-gray-400 border-b border-gray-700">
                    <th class="text-center py-2 font-medium text-xl">{{ __('index.market.trading_pair') }}</th>
                    <th class="text-center py-2 font-medium text-xl">{{ __('index.market.last_price') }}</th>
                    <th class="text-center py-2 font-medium text-xl">{{ __('index.market.fluctuation') }}</th>
                    <th class="text-center py-2 font-medium text-xl xs:hidden">{{ __('index.market.volume') }}</th>
                    <th class="text-center py-2 font-medium text-xl xs:hidden">{{ __('index.market.fluctuation_24h') }}</th>
                    <th class="text-center py-2 font-medium text-xl xs:hidden">{{ __('index.market.activity') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($symbols as $item)
                <tr class="border-b border-gray-700 hover:bg-gray-800/30 transition-colors">
                    <td class="px-2 py-2">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-yellow-400 transition-colors" onclick="toggleFavorite('{{ $item->symbol }}')">
                                    <i class="fa-regular fa-star"></i>
                                </button>
                                <img src="{{ $item->image }}" alt="{{ $item->symbol }}" class="w-6 h-6">
                                <div class="flex flex-col">
                                    <span class="text-white">{{ $item->symbol }}</span>
                                    <span class="text-gray-400 text-xs rounded-full" style="font-size: 10px; background-color: #232627; width: fit-content; padding: 2px 4px;">{{ __('index.market.forever') }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-2 py-4 text-center">
                        <span class="text-white text-xl" id="price-{{ $item->symbol }}">{{ __('index.market.loading') }}</span>
                    </td>
                    <td class="px-2 py-4 text-center">
                        <span id="change-{{ $item->symbol }}" class="text-red-500 text-xl">{{ __('index.market.loading') }}</span>
                    </td>
                    <td class="px-2 py-4 text-center xs:hidden">
                        <span class="text-white text-xl" id="volume-{{ $item->symbol }}">{{ __('index.market.loading') }}</span>
                    </td>
                    <td class="px-2 py-4 text-center w-40 xs:hidden">
                        <div class="w-32 h-16 text-center">
                            <canvas id="chart-{{ $item->symbol }}" class="w-8 h-8"></canvas>
                        </div>
                    </td>
                    <td class="px-2 py-4 text-center xs:hidden">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('trading', ['symbol' => $item->symbol]) }}" class="text-cyan-400 hover:underline text-xl">{{ __('index.market.trade') }}</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleFavorite(symbol) {
        const button = event.currentTarget;
        const icon = button.querySelector('i');
        if (icon.classList.contains('fa-regular')) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
        }
    }

    $(document).ready(function() {
        let page = 1;
        const perPage = 10;
        let ws = null;
        let subscribedSymbols = new Set();
        let charts = {};
        let priceHistory = {};

        // Initialize charts for each symbol
        function initializeCharts() {
            const symbols = @json($symbols->pluck('symbol'));
            symbols.forEach(symbol => {
                const ctx = document.getElementById(`chart-${symbol}`).getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 60);

                charts[symbol] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Array(20).fill(''),
                        datasets: [{
                            data: Array(20).fill(0),
                            borderColor: '#3ddeea',
                            borderWidth: 1.5,
                            backgroundColor: gradient,
                            fill: false,
                            tension: 0.4,
                            pointRadius: 0
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
                        animation: false
                    }
                });

                // Initialize price history
                priceHistory[symbol] = Array(20).fill(0);
            });
        }

        // Fetch historical data for a symbol
        async function fetchHistoricalData(symbol) {
            try {
                const response = await fetch(`https://api.binance.com/api/v3/klines?symbol=${symbol}&interval=1m&limit=50`);
                const data = await response.json();
                return data.map(candle => ({
                    time: new Date(candle[0]),
                    price: parseFloat(candle[4])
                }));
            } catch (error) {
                console.error(`Error fetching historical data for ${symbol}:`, error);
                return [];
            }
        }

        // Update chart with new data
        function updateChart(symbol, price) {
            const chart = charts[symbol];
            if (chart) {
                const now = new Date();
                const data = chart.data.datasets[0].data;
                const lastPrice = data.length > 0 ? data[data.length - 1] : price;

                // Update color based on price movement
                const color = price >= lastPrice ? '#22c55e' : '#ef4444';
                chart.data.datasets[0].borderColor = color;

                chart.data.labels.push(now);
                chart.data.datasets[0].data.push(price);

                // Keep only last 30 points for smaller chart
                if (chart.data.labels.length > 30) {
                    chart.data.labels.shift();
                    chart.data.datasets[0].data.shift();
                }

                chart.update('none');
            }
        }

        function connectWebSocket() {
            if (ws) {
                ws.close();
            }

            const symbols = @json($symbols->pluck('symbol'));
            ws = new WebSocket(`{{env('WEBSOCKET_URL')}}?symbols=${JSON.stringify(symbols)}`);

            ws.onopen = function() {
                console.log('WebSocket Connected');
                const symbols = Array.from(subscribedSymbols);
                if (symbols.length > 0) {
                    const subscribeMsg = {
                        method: 'SUBSCRIBE',
                        params: symbols.map(symbol => symbol.toLowerCase() + '@ticker'),
                        id: 1
                    };
                    ws.send(JSON.stringify(subscribeMsg));
                }
            };

            ws.onmessage = function(event) {
                const data = JSON.parse(event.data);
                if (data.type === 'marketData') {
                    const symbol = data.symbol;
                    const marketData = data.data1;
                    console.log(marketData);
                    
                    
                    // Update price
                    const priceElement = $(`#price-${symbol}`);
                    if (priceElement.length && marketData && typeof marketData.price !== 'undefined') {
                        priceElement.text(marketData.price.toFixed(2));
                        priceElement.addClass('flash');
                        setTimeout(() => priceElement.removeClass('flash'), 1000);
                    }

                    // Update price change
                    const changeElement = $(`#change-${symbol}`);
                    if (changeElement.length && marketData && typeof marketData.priceChange !== 'undefined') {
                        changeElement.text(`${marketData.priceChange.toFixed(2)}%`);
                        changeElement.removeClass('text-red-500 text-[#3ddeea]');
                        changeElement.addClass(marketData.priceChange >= 0 ? 'text-[#3ddeea]' : 'text-red-500');
                    }

                    // Update volume
                    if (marketData && typeof marketData.volume !== 'undefined') {
                        $(`#volume-${symbol}`).text(marketData.volume.toFixed(2));
                    }

                    // Update chart
                    if (marketData && typeof marketData.price !== 'undefined') {
                        updateChart(symbol, marketData.price);
                    }
                }
            };

            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
            };

            ws.onclose = function() {
                console.log('WebSocket connection closed');
                setTimeout(connectWebSocket, 5000);
            };
        }

        // Initialize charts and fetch historical data
        initializeCharts();
        const initialSymbols = @json($symbols->pluck('symbol'));
        initialSymbols.forEach(async symbol => {
            subscribedSymbols.add(symbol);
            const historicalData = await fetchHistoricalData(symbol);
            const chart = charts[symbol];
            if (chart) {
                chart.data.labels = historicalData.map(d => d.time);
                chart.data.datasets[0].data = historicalData.map(d => d.price);
                chart.update();
            }
        });

        // Initialize WebSocket connection
        connectWebSocket();

        // Load more functionality
        $('#load-more-symbols').click(function() {
            page++;
            $.ajax({
                url: '{{ route("load.more.symbols") }}',
                type: 'GET',
                data: {
                    page: page,
                    per_page: perPage
                },
                success: async function(response) {
                    if (response.symbols.length > 0) {
                        const newSymbols = response.symbols.map(s => s.symbol);
                        newSymbols.forEach(symbol => subscribedSymbols.add(symbol));

                        // Subscribe to new symbols
                        const subscribeMsg = {
                            method: 'SUBSCRIBE',
                            params: newSymbols.map(symbol => symbol.toLowerCase() + '@ticker'),
                            id: page
                        };
                        ws.send(JSON.stringify(subscribeMsg));

                        // Add new rows to table
                        response.symbols.forEach(function(symbol) {
                            const newRow = `
                                <tr class="border-b border-[#232627] hover:bg-[#181a1b] text-white symbol-item" data-symbol="${symbol.symbol}">
                                    <td class="flex items-center gap-2 py-4">
                                        <img src="${symbol.image}" alt="${symbol.name}" class="w-6 h-6 rounded-full" />
                                        <span>${symbol.name}</span>
                                    </td>
                                    <td class="py-2" style="width: 80px;">
                                        <canvas id="chart-${symbol.symbol}" width="80" height="30"></canvas>
                                    </td>
                                    <td class="text-center">
                                        <div class="last-price text-sm" id="price-${symbol.symbol}">Loading...</div>
                                        <div class="text-xs profit" id="change-${symbol.symbol}">Loading...</div>
                                    </td>
                                    <td class="text-center" id="volume-${symbol.symbol}">Loading...</td>
                                    <td class="text-center" id="high-${symbol.symbol}">Loading...</td>
                                    <td class="text-center" id="low-${symbol.symbol}">Loading...</td>
                                    <td class="text-center">
                                        <a href="/trading/${symbol.symbol}" class="text-[#45b9b4] hover:underline cursor-pointer ml-2">Giao dịch</a>
                                    </td>
                                </tr>
                            `;
                            $('table tbody').append(newRow);
                        });

                        // Initialize charts for new symbols
                        newSymbols.forEach(async symbol => {
                            const ctx = document.getElementById(`chart-${symbol}`).getContext('2d');
                            charts[symbol] = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: [],
                                    datasets: [{
                                        label: 'Price',
                                        data: [],
                                        borderColor: '#3ddeea',
                                        borderWidth: 1.5,
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

                            // Fetch and set historical data
                            const historicalData = await fetchHistoricalData(symbol);
                            const chart = charts[symbol];
                            if (chart) {
                                chart.data.labels = historicalData.map(d => d.time);
                                chart.data.datasets[0].data = historicalData.map(d => d.price);
                                chart.update();
                            }
                        });
                    } else {
                        $('#load-more-symbols').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading more symbols:', error);
                    $('#load-more-symbols').prop('disabled', false);
                }
            });
        });
    });
</script>

<style>
    .flash {
        animation: flash-animation 1s ease-out;
    }

    /* @keyframes flash-animation {
        0% { background-color: rgba(61, 222, 234, 0.3); }
        100% { background-color: transparent; }
    } */
</style>
@endsection