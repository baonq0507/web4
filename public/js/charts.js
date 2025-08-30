// Chart configurations
const chartConfigs = {};
let ws = null;

// Initialize chart for ROI visualization
function initializeChart(symbol, canvasId) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        console.error(`Canvas element not found for ${canvasId}`);
        return null;
    }

    if (chartConfigs[symbol]) {
        chartConfigs[symbol].destroy();
    }

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 100);
    gradient.addColorStop(0, 'rgba(69, 185, 180, 0.2)');
    gradient.addColorStop(1, 'rgba(69, 185, 180, 0)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array(30).fill(''),
            datasets: [{
                label: 'Price',
                data: Array(30).fill(0),
                borderColor: '#45b9b4',
                borderWidth: 2,
                pointRadius: 0,
                fill: true,
                backgroundColor: gradient,
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
                    display: false,
                    grid: {
                        display: false
                    }
                },
                y: {
                    display: false,
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 0
            }
        }
    });

    chartConfigs[symbol] = chart;
    return chart;
}

// Initialize data and connect WebSocket
async function initializeData() {
    try {
        for (const symbol of symbols) {
            try {
                const apiSymbol = symbol.replace('/', '');
                const response = await fetch(`https://api.binance.com/api/v3/ticker/24hr?symbol=${apiSymbol}`);
                if (!response.ok) continue;
                
                const data = await response.json();
                if (!data) continue;

                // Update table data
                updateTableRow(symbol, {
                    c: data.lastPrice,
                    h: data.highPrice,
                    l: data.lowPrice,
                    P: data.priceChangePercent,
                    v: data.volume
                });

                // Initialize chart
                const chart = initializeChart(symbol, `chart-${symbol}`);
                if (!chart) continue;

                // Get historical data
                const historicalResponse = await fetch(`https://api.binance.com/api/v3/klines?symbol=${apiSymbol}&interval=1m&limit=30`);
                if (!historicalResponse.ok) continue;

                const historicalData = await historicalResponse.json();
                const prices = historicalData.map(kline => parseFloat(kline[4]));

                // Update chart data
                chart.data.datasets[0].data = prices;
                chart.data.labels = Array(prices.length).fill('');
                
                // Set y-axis range
                const min = Math.min(...prices) * 0.999;
                const max = Math.max(...prices) * 1.001;
                chart.options.scales.y.min = min;
                chart.options.scales.y.max = max;
                
                chart.update('none');
            } catch (error) {
                console.error(`Error processing ${symbol}:`, error);
            }
        }

        connectWebSocket();
    } catch (error) {
        console.error('Error initializing data:', error);
    }
}

// Update table row with new data
function updateTableRow(symbol, data) {
    const priceElement = document.getElementById(`price-${symbol}`);
    const highElement = document.getElementById(`high-${symbol}`);
    const lowElement = document.getElementById(`low-${symbol}`);
    const changeElement = document.getElementById(`change-${symbol}`);
    const volumeElement = document.getElementById(`volume-${symbol}`);
    const profitElement = document.getElementById(`profit-${symbol}`);

    if (priceElement) priceElement.textContent = parseFloat(data.c).toFixed(2);
    if (highElement) highElement.textContent = parseFloat(data.h).toFixed(2);
    if (lowElement) lowElement.textContent = parseFloat(data.l).toFixed(2);
    if (changeElement) {
        const change = parseFloat(data.P);
        changeElement.textContent = `${change >= 0 ? '+' : ''}${change.toFixed(2)}%`;
        changeElement.className = `change-value ${change >= 0 ? 'text-green-500' : 'text-red-500'}`;
    }
    if (volumeElement) volumeElement.textContent = parseFloat(data.v).toFixed(2);
    if (profitElement) {
        const profit = parseFloat(data.P);
        profitElement.textContent = `${profit >= 0 ? '+' : ''}${profit.toFixed(2)}%`;
    }
}

// Connect to WebSocket for real-time updates
function connectWebSocket() {
    if (ws) {
        ws.close();
    }

    const wsUrl = `wss://stream.binance.com:9443/ws/${symbols.map(s => s.toLowerCase().replace('/', '') + '@ticker').join('/')}`;
    ws = new WebSocket(wsUrl);

    ws.onmessage = (event) => {
        const data = JSON.parse(event.data);
        const symbol = data.s;
        updateTableRow(symbol, {
            c: data.c,
            h: data.h,
            l: data.l,
            P: data.P,
            v: data.v
        });

        // Update chart if it exists
        const chart = chartConfigs[symbol];
        if (chart) {
            const newPrice = parseFloat(data.c);
            chart.data.datasets[0].data.push(newPrice);
            chart.data.datasets[0].data.shift();
            chart.data.labels.push('');
            chart.data.labels.shift();

            // Update y-axis range
            const prices = chart.data.datasets[0].data;
            const min = Math.min(...prices) * 0.999;
            const max = Math.max(...prices) * 1.001;
            chart.options.scales.y.min = min;
            chart.options.scales.y.max = max;

            chart.update('none');
        }
    };

    ws.onerror = (error) => {
        console.error('WebSocket error:', error);
        setTimeout(connectWebSocket, 5000);
    };

    ws.onclose = () => {
        console.log('WebSocket connection closed');
        setTimeout(connectWebSocket, 5000);
    };
}

// Initialize data when document is ready
document.addEventListener('DOMContentLoaded', initializeData);

// WebSocket connection setup
const ws = new WebSocket('wss://stream.binance.com:9443/ws');

// Store previous prices for color animation
const previousPrices = {};

// Subscribe to all symbol streams
const subscribeToSymbols = (symbols) => {
    symbols.forEach(symbol => {
        const lowercaseSymbol = symbol.toLowerCase();
        ws.send(JSON.stringify({
            "method": "SUBSCRIBE",
            "params": [
                `${lowercaseSymbol}@ticker`
            ],
            "id": 1
        }));
    });
};

// Format number with commas
const formatNumber = (number) => {
    return new Intl.NumberFormat('en-US').format(number);
};

// Format price change
const formatPriceChange = (priceChange) => {
    const isPositive = parseFloat(priceChange) >= 0;
    return `<span class="${isPositive ? 'text-green-500' : 'text-red-500'}">${isPositive ? '+' : ''}${parseFloat(priceChange).toFixed(2)}%</span>`;
};

// Update table data
const updateTableData = (data) => {
    const symbol = data.s;
    const row = document.getElementById(`row-${symbol}`);
    
    if (row) {
        // Update price with color animation
        const priceElement = document.getElementById(`price-${symbol}`);
        if (priceElement) {
            const currentPrice = parseFloat(data.c);
            const previousPrice = previousPrices[symbol] || currentPrice;
            
            priceElement.innerHTML = formatNumber(currentPrice);
            priceElement.className = currentPrice > previousPrice ? 'text-green-500' : currentPrice < previousPrice ? 'text-red-500' : '';
            
            previousPrices[symbol] = currentPrice;
        }

        // Update 24h volume
        const volumeElement = document.getElementById(`volume-${symbol}`);
        if (volumeElement) {
            volumeElement.innerHTML = formatNumber(parseFloat(data.v).toFixed(2));
        }

        // Update price change percentage
        const changeElement = document.getElementById(`change-${symbol}`);
        if (changeElement) {
            changeElement.innerHTML = formatPriceChange(data.P);
        }
    }
};

// WebSocket message handler
ws.onmessage = (event) => {
    const data = JSON.parse(event.data);
    if (data.e === '24hrTicker') {
        updateTableData(data);
    }
};

// Initialize WebSocket connection when symbols are available
if (typeof symbols !== 'undefined') {
    subscribeToSymbols(symbols);
} 