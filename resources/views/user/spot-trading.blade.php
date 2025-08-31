@extends('user.layouts.app')
@section('title', 'Spot Trading')
@section('style')
<style>
    .grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    /* Custom scrollbar styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #181a20;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #3ddeea;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #2bb8c4;
    }

    /* Ensure symbols list is visible */
    .symbol-item {
        min-height: 60px;
        display: flex;
        align-items: center;
    }

    /* Active symbol styling */
    .symbol-item.symbol-active {
        background-color: #2a2d38;
        border: 1px solid #3ddeea;
    }

    /* Hover state for symbol items */
    .symbol-item:hover {
        background-color: #2a2d38;
    }

    /* Custom slider styling */
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        cursor: pointer;
        height: 20px;
        width: 100%;
    }

    input[type="range"]::-webkit-slider-track {
        width: 100%;
        height: 8px;
        cursor: pointer;
        background: transparent;
        border-radius: 4px;
        border: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #ffffff;
        cursor: pointer;
        border: 2px solid #3ddeea;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 20;
    }

    input[type="range"]::-webkit-slider-thumb:hover {
        background: #f0f0f0;
        transform: scale(1.1);
    }

    /* Buy Down slider specific styling */
    input[type="range"]#slider-buy-down::-webkit-slider-thumb {
        border-color: #e04b48;
    }

    input[type="range"]#slider-buy-down::-webkit-slider-thumb:hover {
        background: #f0f0f0;
    }

    /* Focus states */
    input[type="range"]:focus {
        outline: none;
    }

    input[type="range"]:focus::-webkit-slider-thumb {
        box-shadow: 0 0 0 3px rgba(61, 222, 234, 0.3);
    }

    input[type="range"]#slider-buy-down:focus::-webkit-slider-thumb {
        box-shadow: 0 0 0 3px rgba(224, 75, 72, 0.3);
    }

    /* Firefox support */
    input[type="range"]::-moz-range-track {
        width: 100%;
        height: 8px;
        cursor: pointer;
        background: transparent;
        border-radius: 4px;
        border: none;
    }

    input[type="range"]::-moz-range-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background: #ffffff;
        cursor: pointer;
        border: 2px solid #3ddeea;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    input[type="range"]#slider-buy-down::-moz-range-thumb {
        border-color: #e04b48;
    }

    /* Mobile responsive styles */
    @media (max-width: 1024px) {
        .trading-pairs-desktop {
            display: none !important;
        }

        .currency-selector-mobile {
            display: block !important;
        }

        .trading-pairs-mobile {
            display: block !important;
        }

        /* Ẩn các phần không cần thiết trên mobile */
        .main-trading-layout {
            display: none !important;
        }

        /* Hiển thị giao diện mobile */
        .mobile-trading-interface {
            display: block !important;
        }
    }

    @media (min-width: 1025px) {
        .trading-pairs-desktop {
            display: block !important;
        }

        .currency-selector-mobile {
            display: none !important;
        }

        .trading-pairs-mobile {
            display: none !important;
        }

        /* Ẩn giao diện mobile trên desktop */
        .mobile-trading-interface {
            display: none !important;
        }
    }

    /* Mobile currency selector styling */
    .currency-selector-mobile {
        background: #191a1d;
        border-bottom: 1px solid #232428;
        padding: 0.75rem;
        margin-bottom: 1rem;
        display: none;
        /* Ẩn mặc định, chỉ hiện trên mobile */
    }

    /* Mobile Trading Header */
    .mobile-trading-header {
        /* margin-bottom: 0.75rem; */
        padding: 0 0.75rem;
    }

    .currency-selector-mobile .currency-pair {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
    }

    .currency-selector-mobile .currency-pair img {
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }

    .currency-selector-mobile .currency-pair .dropdown-icon {
        color: #6b7280;
        transition: transform 0.2s;
    }

    .currency-selector-mobile .currency-pair .dropdown-icon.rotated {
        transform: rotate(180deg);
    }

    /* Current Price Display */
    .current-price-display {
        margin-bottom: 0.75rem;
    }

    .price-main-value {
        font-size: 1rem;
        font-weight: 700;
        color: #e04b48;
        margin-bottom: 0.25rem;
    }

    .price-change-indicator {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .price-change-indicator.positive {
        color: #3ddeea;
    }

    .price-change-indicator.negative {
        color: #e04b48;
    }

    /* Stats 24H */
    .stats-24h {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.7rem;
    }

    .stat-value {
        color: #3ddeea;
        font-weight: 600;
        font-size: 0.7rem;
    }

    /* Navigation Tabs */
    .mobile-nav-tabs {
        display: flex;
        background: #101112;
        border-radius: 0.5rem;
        padding: 0.25rem;
        margin-bottom: 0.75rem;
    }

    .mobile-nav-tabs .tab-item {
        flex: 1;
        text-align: center;
        padding: 0.5rem 0.25rem;
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 0.375rem;
    }

    .mobile-nav-tabs .tab-item.active {
        background: #3ddeea;
        color: #181a20;
    }

    .mobile-nav-tabs .tab-item:not(.active):hover {
        color: white;
    }

    /* Timeframe Selector */
    .timeframe-selector {
        display: flex;
        gap: 0.375rem;
        margin-bottom: 0.75rem;
        overflow-x: auto;
        padding: 0.25rem 0;
    }

    .timeframe-item {
        padding: 0.375rem 0.75rem;
        background: #101112;
        border: 1px solid #232428;
        border-radius: 0.5rem;
        color: white;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .timeframe-item.active {
        background: #3ddeea;
        border-color: #3ddeea;
        color: #181a20;
    }

    .timeframe-item:not(.active):hover {
        border-color: #3ddeea;
        color: #3ddeea;
    }

    /* Chart Container */
    .mobile-chart-container {
        background: #000;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 1rem;
        min-height: 250px;
    }

    /* Order Book Container */
    .mobile-order-book-container {
        background: #101112;
        border-radius: 0.5rem;
        padding: 1.5rem 1rem;
        margin-bottom: 1rem;
        min-height: 250px;
        border: 1px solid #232428;
    }

    .order-book-header {
        animation: fadeInDown 0.4s ease-out;
    }

    .order-book-header h3 {
        color: white;
        font-size: 1rem;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    /* Order Book Tabs */
    .order-book-tabs {
        display: flex;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    .order-book-tabs .order-tab-item {
        text-align: center;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 0.25rem;
        position: relative;
        overflow: hidden;
    }

    .order-book-tabs .order-tab-item.active {
        color: #181a20;
        transform: scale(1.05);
        animation: tabActivate 0.3s ease-out;
    }

    .order-book-tabs .order-tab-item:not(.active):hover {
        color: #3ddeea;
        transform: translateY(-1px);
    }

    /* Trading Form Styles */
    .trading-form {
        background: #1e2026;
        border: 1px solid #2a2d38;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .trading-form input,
    .trading-form select {
        background: #2a2d38;
        border: 1px solid #3a3d48;
        color: white;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
        margin-bottom: 15px;
    }

    .trading-form input:focus,
    .trading-form select:focus {
        outline: none;
        border-color: #3ddeea;
    }

    .trading-form label {
        color: #a0a0a0;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }

    .trading-buy-btn {
        background: #00c851;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        margin-bottom: 10px;
    }

    .trading-sell-btn {
        background: #ff4444;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
    }

    .trading-buy-btn:hover {
        background: #00a843;
    }

    .trading-sell-btn:hover {
        background: #cc3333;
    }

    .order-summary {
        background: #2a2d38;
        border-radius: 4px;
        padding: 15px;
        margin-top: 15px;
        border: 1px solid #3a3d48;
    }

    .order-summary h4 {
        color: #3ddeea;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .order-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        color: #a0a0a0;
        font-size: 14px;
    }

    .order-summary-row.total {
        color: white;
        font-weight: bold;
        border-top: 1px solid #3a3d48;
        padding-top: 8px;
        margin-top: 8px;
    }

    /* Slider Container */
    .slider-container {
        position: relative;
        padding: 1rem 0;
    }

    .form-slider {
        width: 100%;
        height: 0.5rem;
        background: transparent;
        appearance: none;
        outline: none;
        position: relative;
        z-index: 10;
    }

    .form-slider::-webkit-slider-thumb {
        appearance: none;
        width: 1.5rem;
        height: 1.5rem;
        background: #3ddeea;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(61, 222, 234, 0.3);
        transition: all 0.2s ease;
    }

    .form-slider::-webkit-slider-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(61, 222, 234, 0.4);
    }

    .slider-track {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 0.5rem;
        background: #181a20;
        border-radius: 0.25rem;
        transform: translateY(-50%);
    }

    .slider-active-track {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: #3ddeea;
        border-radius: 0.25rem;
        transition: width 0.2s ease;
        width: 0%;
    }

    .slider-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 0.75rem;
        font-size: 0.75rem;
        color: #6b7280;
    }

    .trading-info {
        background: #181a20;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .info-value {
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .btn-submit {
        width: 100%;
        background: #3ddeea;
        color: #181a20;
        border: none;
        border-radius: 0.75rem;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-submit:hover {
        background: #2bb8c4;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(61, 222, 234, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-submit .hidden {
        display: none;
    }

    .investment-limits {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 1rem;
    }

    /* Button variants */
    .btn-submit.btn-buy {
        background: #3ddeea;
        color: #181a20;
    }

    .btn-submit.btn-sell {
        background: #e04b48;
        color: white;
    }

    .btn-submit.btn-buy:hover {
        background: #2bb8c4;
    }

    .btn-submit.btn-sell:hover {
        background: #c73e3a;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Mobile Currency Selector -->
    <div class="currency-selector-mobile">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/symbols/btc.png') }}" alt="BTC" class="w-6 h-6">
                <span class="text-white font-medium">BTC/USDT</span>
            </div>
            <div class="text-right">
                <div class="text-white font-bold text-lg">$43,250.50</div>
                <div class="text-green-400 text-sm">+2.45%</div>
            </div>
        </div>
    </div>

    <!-- Desktop Trading Layout -->
    <div class="main-trading-layout">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar - Symbols -->
            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-lg p-4">
                    <h3 class="text-lg font-bold text-white mb-4">Trading Pairs</h3>
                    <div class="space-y-2 custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
                        @foreach($symbols as $symbol)
                        <div class="symbol-item p-3 rounded cursor-pointer hover:bg-gray-700 transition-colors">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $symbol->image }}" alt="{{ $symbol->symbol }}" class="w-8 h-8">
                                <div>
                                    <div class="text-white font-medium">{{ $symbol->symbol }}</div>
                                    <div class="text-gray-400 text-sm">{{ $symbol->name }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Center - Spot Trading Form -->
            <div class="lg:col-span-2">
                <div class="trading-form">
                    <h3 class="text-xl font-bold text-white mb-6">Spot Trading</h3>
                    
                    <!-- Dual Trading Forms -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- BUY FORM -->
                        <div class="p-4 bg-[#181a20] rounded-lg">
                            <h4 class="text-lg font-bold text-white mb-4">Buy {{ $symbols->first()->symbol ?? 'BTC' }}</h4>
                            
                            <form id="buyForm">
                                @csrf
                                <input type="hidden" name="type" value="buy">
                                
                                <!-- Order Type -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Order Type</label>
                                    <select name="order_type" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none">
                                        <option value="market">Market</option>
                                        <option value="limit">Limit</option>
                                    </select>
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Price (USDT)</label>
                                    <input type="number" name="price" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none" placeholder="0.00000000" step="0.00000001">
                                </div>

                                <!-- Quantity -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Quantity</label>
                                    <input type="number" name="quantity" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none" placeholder="0.00000000" step="0.00000001">
                                </div>

                                <!-- Percentage Slider -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Percentage</label>
                                    <div class="relative w-full h-8 flex items-center">
                                        <input type="range" class="w-full h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer slider-buy" min="0" max="100" value="0">
                                        <div class="absolute left-0 top-0 h-2 bg-[#3ddeea] rounded-lg" style="width: 0%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                                        <span>0%</span>
                                        <span>25%</span>
                                        <span>50%</span>
                                        <span>75%</span>
                                        <span>100%</span>
                                    </div>
                                </div>

                                <!-- Trading Info -->
                                <div class="bg-[#101112] rounded-md p-3 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-400 text-sm">Available Balance:</span>
                                        <span class="text-white text-sm">0 USDT</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-400 text-sm">Can Buy:</span>
                                        <span class="text-white text-sm">0 BTC</span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full bg-[#3ddeea] text-[#181a20] py-3 rounded-md font-semibold hover:bg-[#2bb8c4] transition-colors">
                                    Buy {{ $symbols->first()->symbol ?? 'BTC' }}
                                </button>
                            </form>
                        </div>

                        <!-- SELL FORM -->
                        <div class="p-4 bg-[#181a20] rounded-lg">
                            <h4 class="text-lg font-bold text-white mb-4">Sell {{ $symbols->first()->symbol ?? 'BTC' }}</h4>
                            
                            <form id="sellForm">
                                @csrf
                                <input type="hidden" name="type" value="sell">
                                
                                <!-- Order Type -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Order Type</label>
                                    <select name="order_type" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none">
                                        <option value="market">Market</option>
                                        <option value="limit">Limit</option>
                                    </select>
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Price (USDT)</label>
                                    <input type="number" name="price" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none" placeholder="0.00000000" step="0.00000001">
                                </div>

                                <!-- Quantity -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Quantity</label>
                                    <input type="number" name="quantity" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none" placeholder="0.00000000" step="0.00000001">
                                </div>

                                <!-- Percentage Slider -->
                                <div class="mb-4">
                                    <label class="block text-gray-400 text-sm mb-2">Percentage</label>
                                    <div class="relative w-full h-8 flex items-center">
                                        <input type="range" class="w-full h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer slider-sell" min="0" max="100" value="0">
                                        <div class="absolute left-0 top-0 h-2 bg-[#e04b48] rounded-lg" style="width: 0%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                                        <span>0%</span>
                                        <span>25%</span>
                                        <span>50%</span>
                                        <span>75%</span>
                                        <span>100%</span>
                                    </div>
                                </div>

                                <!-- Trading Info -->
                                <div class="bg-[#101112] rounded-md p-3 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-400 text-sm">Available Balance:</span>
                                        <span class="text-white text-sm">0 BTC</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-400 text-sm">Can Sell:</span>
                                        <span class="text-white text-sm">0 USDT</span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full bg-[#e04b48] text-white py-3 rounded-md font-semibold hover:bg-[#c73e3a] transition-colors">
                                    Sell {{ $symbols->first()->symbol ?? 'BTC' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - Recent Trades -->
            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-lg p-4">
                    <h3 class="text-lg font-bold text-white mb-4">Recent Trades</h3>
                    <div class="space-y-2 custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
                        @forelse($spotTrades as $trade)
                        <div class="flex justify-between items-center p-2 bg-gray-700 rounded">
                            <div>
                                <span class="text-sm text-gray-300">{{ $trade->symbol->symbol }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $trade->type }}</span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-white">{{ number_format($trade->price, 8) }}</div>
                                <div class="text-xs text-gray-400">{{ number_format($trade->amount, 8) }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-gray-400 py-4">
                            No trades yet
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Trading Interface -->
    <div class="mobile-trading-interface">
        <!-- Mobile Trading Header -->
        <div class="mobile-trading-header">
            <!-- Current Price Display -->
            <div class="current-price-display">
                <div class="price-main-value">$43,250.50</div>
                <div class="price-change-indicator positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+$1,234.56 (+2.45%)</span>
                </div>
            </div>

            <!-- Stats 24H -->
            <div class="stats-24h">
                <div class="stat-row">
                    <span class="stat-label">24h High</span>
                    <span class="stat-value">$44,100.00</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">24h Low</span>
                    <span class="stat-value">$42,800.00</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">24h Volume</span>
                    <span class="stat-value">$1.2B</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">24h Change</span>
                    <span class="stat-value">+2.45%</span>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="mobile-nav-tabs">
                <div class="tab-item active">Market Transaction</div>
                <div class="tab-item">Limit Trade</div>
            </div>
        </div>

        <!-- Mobile Trading Form -->
        <div class="bg-gray-800 rounded-lg p-4 mb-4">
            <h3 class="text-lg font-bold text-white mb-4">Spot Trading</h3>
            
            <form id="mobileSpotTradingForm">
                @csrf
                
                <!-- Symbol Selection -->
                <div class="mb-4">
                    <label for="mobile_symbol_id">Symbol</label>
                    <select name="symbol_id" id="mobile_symbol_id" class="w-full">
                        @foreach($symbols as $symbol)
                            <option value="{{ $symbol->id }}">{{ $symbol->symbol }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Order Type -->
                <div class="mb-4">
                    <label for="mobile_order_type">Order Type</label>
                    <select name="order_type" id="mobileOrderType" class="w-full">
                        <option value="market">Market</option>
                        <option value="limit">Limit</option>
                    </select>
                </div>
                
                <!-- Price -->
                <div class="mb-4">
                    <label for="mobile_price">Price (USDT)</label>
                    <input type="number" name="price" id="mobile_price" step="0.00000001" placeholder="0.00000000" required>
                </div>
                
                <!-- Quantity -->
                <div class="mb-4">
                    <label for="mobile_quantity">Quantity</label>
                    <input type="number" name="quantity" id="mobile_quantity" step="0.00000001" placeholder="0.00000000" required>
                </div>
                
                <!-- Percentage Slider -->
                <div class="slider-container">
                    <label class="form-label">Percentage</label>
                    <div class="relative">
                        <input type="range" id="mobile-percentage-slider" class="form-slider" min="0" max="100" value="0">
                        <div class="slider-track"></div>
                        <div class="slider-active-track" id="mobile-slider-active-track"></div>
                    </div>
                    <div class="slider-labels">
                        <span>0%</span>
                        <span>25%</span>
                        <span>50%</span>
                        <span>75%</span>
                        <span>100%</span>
                    </div>
                </div>
                
                <!-- Trading Info -->
                <div class="trading-info">
                    <div class="info-row">
                        <span class="info-label">Available Balance:</span>
                        <span class="info-value" id="mobile-available-balance">0 USDT</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Can Buy:</span>
                        <span class="info-value" id="mobile-can-buy">0 BTC</span>
                    </div>
                </div>
                
                <!-- Buy/Sell Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="submit" name="type" value="buy" class="btn-submit btn-buy">
                        <i class="fas fa-arrow-up"></i>
                        <span>Buy</span>
                    </button>
                    <button type="submit" name="type" value="sell" class="btn-submit btn-sell">
                        <i class="fas fa-arrow-down"></i>
                        <span>Sell</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Desktop form handling
document.getElementById('buyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/spot-trading/place-order', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            location.reload();
        } else if (data.errors) {
            alert(Object.values(data.errors)[0]);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra');
    });
});

document.getElementById('sellForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/spot-trading/place-order', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            location.reload();
        } else if (data.errors) {
            alert(Object.values(data.errors)[0]);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra');
    });
});

// Mobile form handling
document.getElementById('mobileSpotTradingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const type = e.submitter.value;
    formData.set('type', type);
    
    fetch('/spot-trading/place-order', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            location.reload();
        } else if (data.errors) {
            alert(Object.values(data.errors)[0]);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra');
    });
});

// Percentage slider functionality
document.querySelectorAll('.slider-buy, .slider-sell').forEach(slider => {
    slider.addEventListener('input', function() {
        const percentage = this.value;
        const track = this.nextElementSibling;
        track.style.width = percentage + '%';
        
        // Update quantity based on percentage
        const availableBalance = 1000; // Example balance
        const currentPrice = 43250.50; // Example price
        const maxQuantity = availableBalance / currentPrice;
        const quantity = (maxQuantity * percentage) / 100;
        
        const quantityInput = this.closest('form').querySelector('input[name="quantity"]');
        if (quantityInput) {
            quantityInput.value = quantity.toFixed(8);
        }
    });
});

// Mobile percentage slider
document.getElementById('mobile-percentage-slider').addEventListener('input', function() {
    const percentage = this.value;
    const availableBalance = 1000; // Example balance
    const currentPrice = parseFloat(document.getElementById('mobile_price').value) || 43250.50;
    
    const maxQuantity = availableBalance / currentPrice;
    const quantity = (maxQuantity * percentage) / 100;
    
    document.getElementById('mobile_quantity').value = quantity.toFixed(8);
    document.getElementById('mobile-slider-active-track').style.width = percentage + '%';
});
</script>
@endsection