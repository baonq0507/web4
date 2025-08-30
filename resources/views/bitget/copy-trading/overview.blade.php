@extends('user.layouts.app')
@section('title', __('index.copy_trading.title'))
@section('content')
<div class="container mx-auto px-4 pt-20">
    <!-- Phần Hero -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16">
        <!-- Nội dung bên trái -->
        <div class="w-full md:w-1/2">
            <h1 class="text-2xl font-bold text-white mb-6">
                {{ __('index.copy_trading.title') }}
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                {{ __('index.copy_trading.description') }}
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-cyan-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-cyan-500 transition duration-300">
                {{ __('index.copy_trading.start_now') }}
            </a>
        </div>

        <!-- Nội dung bên phải -->
        <div class="w-full md:w-1/2">
            <div class="bg-black rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-center h-[300px] relative">
                    <img src="{{ asset('images/overview.png') }}" alt="Bitget" class="w-35 h-full">
                </div>
            </div>
        </div>
    </div>

    <!-- Lưới tính năng -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="text-center">
            <div class="text-4xl font-bold mb-4">190,000+</div>
            <div class="text-gray-400 text-sm">{{ __('index.copy_trading.elite_traders') }}</div>
        </div>
        <div class="text-center">
            <div class="text-4xl font-bold mb-4">800,000+</div>
            <div class="text-gray-400 text-sm">{{ __('index.copy_trading.copiers') }}</div>
        </div>
        <div class="text-center">
            <div class="text-4xl font-bold mb-4">$530,000,000+</div>
            <div class="text-gray-400 text-sm">{{ __('index.copy_trading.monthly_benefits') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-gradient-to-br bg-[#232425] rounded-lg p-6 shadow-lg hover:shadow-xl transition duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-orange-100 to-orange-200 rounded-full p-4 shadow-md">
                    <i class="fas fa-chart-line text-orange-500 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('index.copy_trading.quick_start') }}</h3>
                    <p class="text-gray-400">{{ __('index.copy_trading.quick_start_desc') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br bg-[#232425] rounded-lg p-6 shadow-lg hover:shadow-xl transition duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-full p-4 shadow-md">
                    <i class="fas fa-chart-pie text-blue-500 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('index.copy_trading.increase_profit') }}</h3>
                    <p class="text-gray-400">{{ __('index.copy_trading.increase_profit_desc') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br bg-[#232425] rounded-lg p-6 shadow-lg hover:shadow-xl transition duration-300">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-cyan-100 to-cyan-200 rounded-full p-4 shadow-md">
                    <i class="fas fa-user-tie text-cyan-500 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">{{ __('index.copy_trading.expert_knowledge') }}</h3>
                    <p class="text-gray-400">{{ __('index.copy_trading.expert_knowledge_desc') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cách thức hoạt động -->
    <div class="bg-gray-50 rounded-xl p-8 mb-12">
        <h2 class="text-3xl font-bold text-center mb-8">{{ __('index.copy_trading.smart_trading') }}</h2>
        <p class="text-center text-gray-600 mb-8">{{ __('index.copy_trading.smart_trading_desc') }}</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="bg-[#232425] rounded-lg p-6 shadow-md">
                    <i class="fas fa-chart-line text-blue-500 text-2xl mb-4"></i>
                    <h3 class="font-semibold mb-2">{{ __('index.copy_trading.copy_futures') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('index.copy_trading.copy_futures_desc') }}</p>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-[#232425] rounded-lg p-6 shadow-md">
                    <i class="fas fa-sync text-blue-500 text-2xl mb-4"></i>
                    <h3 class="font-semibold mb-2">{{ __('index.copy_trading.copy_spot') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('index.copy_trading.copy_spot_desc') }}</p>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-[#232425] rounded-lg p-6 shadow-md">
                    <i class="fas fa-robot text-blue-500 text-2xl mb-4"></i>
                    <h3 class="font-semibold mb-2">{{ __('index.copy_trading.copy_bot') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('index.copy_trading.copy_bot_desc') }}</p>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-[#232425] rounded-lg p-6 shadow-md">
                    <i class="fas fa-chart-bar text-blue-500 text-2xl mb-4"></i>
                    <h3 class="font-semibold mb-2">{{ __('index.copy_trading.insights') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('index.copy_trading.insights_desc') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần lợi ích -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-center mb-8">{{ __('index.copy_trading.benefits') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#232425] rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold mb-4">{{ __('index.copy_trading.for_followers') }}</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>{{ __('index.copy_trading.learn_from_experts') }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>{{ __('index.copy_trading.diversify_portfolio') }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>{{ __('index.copy_trading.save_time') }}</span>
                    </li>
                </ul>
            </div>
            <div class="bg-[#232425] rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-semibold mb-4">{{ __('index.copy_trading.for_traders') }}</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>{{ __('index.copy_trading.earn_extra') }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>{{ __('index.copy_trading.build_reputation') }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>{{ __('index.copy_trading.grow_followers') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Phần Hướng dẫn -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-center mb-8">{{ __('index.copy_trading.new_user_guide') }}</h2>
        <div class="rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-4">{{ __('index.copy_trading.experience_copy') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-300 mb-4">{{ __('index.copy_trading.copy_futures_desc_2') }}</p>
                    <p class="text-gray-300 mb-4">{{ __('index.copy_trading.copy_spot_desc_2') }}</p>
                    <div class="flex items-center mt-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <p class="text-sm text-gray-400">{{ __('index.copy_trading.risk_warning') }}</p>
                    </div>
                </div>
                <div class="flex justify-center items-center">
                    <img src="{{ asset('images/overview.png') }}" alt="Copy Trading Guide" class="max-w-full h-auto rounded-lg">
                </div>
            </div>
        </div>
    </div>

    <section class="earning-tab-content" data-tab="overview">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h2 class="text-xl font-bold mb-4 text-bitget-dark">{{ __('index.copy_trading.futures_trading') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($symbols as $symbol)
                <div class="rounded-lg bg-[#1f2023] shadow p-6 flex flex-col items-start">
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
                @endforeach
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const symbols = @json($symbols);
    const charts = {};
    const wsConnections = {};

    // Function to fetch historical data from Binance
    async function fetchHistoricalData(symbol) {
        try {
            const response = await fetch(`https://api.binance.com/api/v3/klines?symbol=${symbol}&interval=1m&limit=20`);
            const data = await response.json();
            return data.map(kline => ({
                timestamp: new Date(kline[0]),
                price: parseFloat(kline[4]) // Close price
            }));
        } catch (error) {
            console.error(`Error fetching historical data for ${symbol}:`, error);
            return [];
        }
    }

    // Function to fetch initial 24h volume
    async function fetch24hVolume(symbol) {
        try {
            const response = await fetch(`https://api.binance.com/api/v3/ticker/24hr?symbol=${symbol}`);
            const data = await response.json();
            return {
                volume: parseFloat(data.volume),
                priceChange: parseFloat(data.priceChangePercent)
            };
        } catch (error) {
            console.error(`Error fetching 24h volume for ${symbol}:`, error);
            return { volume: 0, priceChange: 0 };
        }
    }

    // Function to initialize chart with historical data
    async function initializeChart(symbol) {
        const ctx = document.getElementById(`chart-${symbol.symbol}`).getContext('2d');
        const [historicalData, volumeData] = await Promise.all([
            fetchHistoricalData(symbol.symbol),
            fetch24hVolume(symbol.symbol)
        ]);
        
        // Update price and volume display with initial data
        if (historicalData.length > 0) {
            const latestPrice = historicalData[historicalData.length - 1].price;
            document.getElementById(`price-${symbol.symbol}`).textContent = latestPrice.toFixed(2);
        }
        
        // Update volume and price change
        document.getElementById(`volume-${symbol.symbol}`).textContent = volumeData.volume.toFixed(2);
        const changeElement = document.getElementById(`change-${symbol.symbol}`);
        changeElement.textContent = volumeData.priceChange.toFixed(2) + '%';
        changeElement.className = volumeData.priceChange >= 0 ? 'text-green-500' : 'text-red-500';

        charts[symbol.symbol] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: historicalData.map(d => d.timestamp),
                datasets: [{
                    label: symbol.symbol,
                    data: historicalData.map(d => d.price),
                    borderColor: '#00ff00',
                    borderWidth: 1,
                    pointRadius: 0,
                    tension: 0.4
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

        // Initialize WebSocket connections after chart is created
        initializeWebSockets(symbol);
    }

    // Function to initialize WebSocket connections
    function initializeWebSockets(symbol) {
        // WebSocket for kline data
        const klineWs = new WebSocket(`wss://stream.binance.com:9443/ws/${symbol.symbol.toLowerCase()}@kline_1m`);
        wsConnections[`${symbol.symbol}_kline`] = klineWs;

        klineWs.onmessage = (event) => {
            const data = JSON.parse(event.data);
            const price = parseFloat(data.k.c);
            const timestamp = new Date(data.k.t);
            
            // Update price display
            document.getElementById(`price-${symbol.symbol}`).textContent = price.toFixed(2);
            
            // Update chart
            const chart = charts[symbol.symbol];
            if (chart.data.labels.length > 20) {
                chart.data.labels.shift();
                chart.data.datasets[0].data.shift();
            }
            
            chart.data.labels.push(timestamp);
            chart.data.datasets[0].data.push(price);
            chart.update('none');
        };

        // WebSocket for 24hr ticker data
        const tickerWs = new WebSocket(`wss://stream.binance.com:9443/ws/${symbol.symbol.toLowerCase()}@ticker`);
        wsConnections[`${symbol.symbol}_ticker`] = tickerWs;

        tickerWs.onmessage = (event) => {
            const data = JSON.parse(event.data);
            const volume = parseFloat(data.v);
            const priceChange = parseFloat(data.P);
            
            // Update volume and price change
            document.getElementById(`volume-${symbol.symbol}`).textContent = volume.toFixed(2);
            const changeElement = document.getElementById(`change-${symbol.symbol}`);
            changeElement.textContent = priceChange.toFixed(2) + '%';
            changeElement.className = priceChange >= 0 ? 'text-green-500' : 'text-red-500';
        };

        // Error handling for both WebSockets
        [klineWs, tickerWs].forEach(ws => {
            ws.onerror = (error) => {
                console.error(`WebSocket error for ${symbol.symbol}:`, error);
            };

            ws.onclose = () => {
                console.log(`WebSocket connection closed for ${symbol.symbol}`);
                // Attempt to reconnect after 5 seconds
                setTimeout(() => {
                    if (ws === klineWs) {
                        wsConnections[`${symbol.symbol}_kline`] = new WebSocket(`wss://stream.binance.com:9443/ws/${symbol.symbol.toLowerCase()}@kline_1m`);
                    } else {
                        wsConnections[`${symbol.symbol}_ticker`] = new WebSocket(`wss://stream.binance.com:9443/ws/${symbol.symbol.toLowerCase()}@ticker`);
                    }
                }, 5000);
            };
        });
    }

    // Initialize charts and WebSocket connections for all symbols
    symbols.forEach(symbol => {
        initializeChart(symbol);
    });

    // Cleanup WebSocket connections when page is unloaded
    window.addEventListener('beforeunload', () => {
        Object.values(wsConnections).forEach(ws => {
            if (ws.readyState === WebSocket.OPEN) {
                ws.close();
            }
        });
    });
});
</script>
@endsection