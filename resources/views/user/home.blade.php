@extends('user.layouts.app')

@section('title', __('index.home.home'))
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .gradient-text {
        background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(6, 182, 212, 0.3);
    }
    
    .feature-card {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
        border: 1px solid rgba(6, 182, 212, 0.2);
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.2) 0%, rgba(59, 130, 246, 0.2) 100%);
        border-color: rgba(6, 182, 212, 0.4);
        transform: translateY(-5px);
    }
    
    /* Ticker Animation */
    .ticker-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    
    .ticker-track {
        display: flex;
        animation: marquee 60s linear infinite;
        width: max-content;
    }
    
    .ticker-track:hover {
        animation-play-state: paused;
    }
    
    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    
    .ticker-item {
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        min-width: 200px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .ticker-item:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    /* Price ticker specific styles */
    .price-ticker {
        background: linear-gradient(to right, #1a1a1a, #0f0f0f);
        border-top: 1px solid #333;
        border-bottom: 1px solid #333;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }
    
    .price-ticker::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, #06b6d4, transparent);
        animation: shimmer 2s ease-in-out infinite;
    }
    
    .price-ticker::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, #3b82f6, transparent);
        animation: shimmer 2s ease-in-out infinite reverse;
    }
    
    @keyframes shimmer {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }
    
    .price-ticker .ticker-item {
        background: transparent;
        border: none;
        padding: 8px 16px;
        min-width: auto;
        margin-right: 24px;
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        white-space: nowrap;
    }
    
    .price-ticker .ticker-item:hover {
        background: rgba(6, 182, 212, 0.1);
        transform: translateY(-2px);
        border-radius: 8px;
    }
    
    .price-ticker .ticker-item img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .price-ticker .ticker-item:hover img {
        transform: scale(1.1);
        border-color: rgba(6, 182, 212, 0.5);
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.3);
    }
    
    /* Responsive design for mobile */
    @media (max-width: 768px) {
        .price-ticker .ticker-item {
            padding: 6px 12px;
            margin-right: 16px;
            gap: 8px;
        }
        
        .price-ticker .ticker-item img {
            width: 20px;
            height: 20px;
        }
        
        .price-ticker .ticker-item span {
            font-size: 12px;
        }
    }
    
    @media (max-width: 480px) {
        .price-ticker .ticker-item {
            padding: 4px 8px;
            margin-right: 12px;
            gap: 6px;
        }
        
        .price-ticker .ticker-item img {
            width: 18px;
            height: 18px;
        }
        
        .price-ticker .ticker-item span {
            font-size: 11px;
        }
    }
    
    .price-ticker .ticker-item span:first-child {
        font-weight: 600;
        color: #fff;
        font-size: 14px;
    }
    
    .price-ticker .ticker-item span:nth-child(2) {
        color: #fff;
        font-size: 14px;
        font-family: 'Courier New', monospace;
    }
    
    .price-ticker .ticker-item span:last-child {
        font-weight: 500;
        font-size: 14px;
        position: relative;
    }
    
    .price-ticker .ticker-item .text-cyan-400 {
        color: #06b6d4 !important;
    }
    
    .price-ticker .ticker-item .text-red-400 {
        color: #ef4444 !important;
    }
    
    /* Price change indicators with arrows */
    .price-change-up {
        color: #10b981 !important;
    }
    
    .price-change-up::before {
        content: "▲";
        margin-right: 4px;
        font-size: 10px;
    }
    
    .price-change-down::before {
        content: "▼";
        margin-right: 4px;
        font-size: 10px;
    }
    
    /* Smooth transitions for price changes */
    .ticker-item span {
        transition: all 0.3s ease;
    }
    
    /* Trend Analysis Chart Styles */
    .crypto-pair-item {
        /* transition: all 0.3s ease; */
        min-width: 200px;
    }
    
    .time-range-btn {
        transition: all 0.3s ease;
    }
    
    .time-range-btn.active {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.3) 0%, rgba(59, 130, 246, 0.3) 100%);
        color: #06b6d4;
        border: 1px solid rgba(6, 182, 212, 0.5);
    }
    
    .time-range-btn:hover:not(.active) {
        background: rgba(107, 114, 128, 0.3);
    }
    
    /* Chart container styles */
    #trend-chart {
        background: transparent;
    }
    
    /* Scrollbar hiding and smooth scrolling */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
        scrollbar-width: none;  /* Firefox */
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;  /* Safari and Chrome */
    }
    
    /* Touch-friendly scrolling for mobile */
    #crypto-pairs-container {
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;
        cursor: grab !important;
        user-select: none !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        pointer-events: auto !important;
        overflow-x: auto !important;
        scroll-behavior: smooth !important;
    }
    
    #crypto-pairs-container:active {
        cursor: grabbing !important;
    }
    
    #crypto-pairs-container:hover {
        cursor: grab !important;
    }
    
    /* Ensure parent container allows scrolling */
    .overflow-x-auto {
        overflow-x: auto !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
        cursor: grab !important;
        user-select: none !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        display: none !important;
    }
    
    .overflow-x-auto:active {
        cursor: grabbing !important;
    }
    
    .overflow-x-auto:hover {
        cursor: grab !important;
    }
    
    .crypto-pair-item {
        scroll-snap-align: start;
        cursor: pointer;
        pointer-events: auto;
        transition: all 0.3s ease;
    }
    
    .crypto-pair-item.active {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.6) 0%, rgba(59, 130, 246, 0.6) 100%) !important;
        border-color: rgba(6, 182, 212, 1) !important;
        /* transform: scale(1.02) !important; */
        box-shadow: 0 8px 25px rgba(6, 182, 212, 0.6) !important;
        position: relative;
        z-index: 10;
    }
    
    /* .crypto-pair-item:hover:not(.active) {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(59, 130, 246, 0.15) 100%);
        border-color: rgba(6, 182, 212, 0.4);
        transform: scale(1.01);
    } */
    
    .crypto-pair-item.active .active-indicator {
        opacity: 1 !important;
        animation: pulse 2s infinite;
    }
    
    /* .crypto-pair-item.active::after {
        content: '';
        position: absolute;
        inset: -2px;
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.8), rgba(59, 130, 246, 0.8));
        border-radius: inherit;
        z-index: -1;
        animation: glow 2s ease-in-out infinite alternate;
    } */
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    @keyframes glow {
        0% { opacity: 0.6; }
        100% { opacity: 1; }
    }
    
    /* Chart overlay improvements */
    #trend-chart {
        position: relative;
    }
    
    .chart-overlay {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .price-display {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    /* Chart Y-axis improvements */
    .chartjs-chart {
        position: relative;
    }
    
    .chartjs-chart canvas {
        border-radius: 8px;
    }
    
    .loading-price {
        opacity: 0.6;
        font-style: italic;
    }
    
    /* Scroll indicator hover effects */
    .scroll-indicator:hover {
        background: rgba(6, 182, 212, 0.4) !important;
        border-color: rgba(6, 182, 212, 0.6) !important;
        transform: translateY(-50%) scale(1.1) !important;
    }
    
    .scroll-indicator i {
        color: white;
        font-size: 16px;
    }
    
    /* Responsive design for trend analysis */
    @media (max-width: 768px) {
        .crypto-pair-item {
            min-width: 160px;
            padding: 0.75rem;
        }
        
        .crypto-pair-item .text-2xl {
            font-size: 1.25rem;
        }
        
        .time-range-btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
    }
    
    @media (max-width: 480px) {
        .crypto-pair-item {
            min-width: 140px;
            padding: 0.5rem;
        }
        
        .crypto-pair-item .text-2xl {
            font-size: 1.125rem;
        }
        
        .time-range-btn {
            padding: 0.375rem 0.5rem;
            font-size: 0.75rem;
        }
    }
    
    /* Mobile responsive for trend chart */
    @media (max-width: 768px) {
        .py-20 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
        
        .mb-16 {
            margin-bottom: 2rem;
        }
        
        .text-4xl {
            font-size: 2rem;
        }
        
        .text-xl {
            font-size: 1rem;
        }
        
        .mb-8 {
            margin-bottom: 1.5rem;
        }
        
        .gap-4 {
            gap: 0.75rem;
        }
        
        .min-w-\[260px\] {
            min-width: 200px;
        }
        
        .p-4 {
            padding: 0.75rem;
        }
        
        .p-8 {
            padding: 1.5rem;
        }
        
        .h-96 {
            height: 20rem;
        }
        
        .text-2xl {
            font-size: 1.25rem;
        }
        
        .text-lg {
            font-size: 1rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .space-x-2 {
            column-gap: 0.5rem;
        }
        
        .space-x-4 {
            column-gap: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .py-20 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .mb-16 {
            margin-bottom: 1.5rem;
        }
        
        .text-4xl {
            font-size: 1.75rem;
        }
        
        .text-xl {
            font-size: 0.875rem;
        }
        
        .mb-8 {
            margin-bottom: 1rem;
        }
        
        .gap-4 {
            gap: 0.5rem;
        }
        
        .min-w-\[260px\] {
            min-width: 160px;
        }
        
        .p-4 {
            padding: 0.5rem;
        }
        
        .p-8 {
            padding: 1rem;
        }
        
        .h-96 {
            height: 16rem;
        }
        
        .text-2xl {
            font-size: 1.125rem;
        }
        
        .text-lg {
            font-size: 0.875rem;
        }
        
        .text-sm {
            font-size: 0.75rem;
        }
        
        .space-x-2 {
            column-gap: 0.375rem;
        }
        
        .space-x-4 {
            column-gap: 0.75rem;
        }
        
        .top-4 {
            top: 0.5rem;
        }
        
        .left-4 {
            left: 0.5rem;
        }
        
        .right-4 {
            right: 0.5rem;
        }
        
        .bottom-4 {
            bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
@include('user.includes.banner')
<!-- Banner Slider -->

<!-- Realtime Price Ticker -->
<div class="price-ticker py-4 overflow-hidden">
    <div class="ticker-container">
        <div class="ticker-track flex animate-marquee whitespace-nowrap" id="price-ticker-track">
            <!-- Loading state -->
            <div class="ticker-item flex items-center space-x-3 text-gray-400" id="ticker-loading">
                <span class="text-gray-400">Loading...</span>
            </div>
        </div>
    </div>
    <!-- Connection status indicator -->
    <div class="absolute top-2 right-4 flex items-center space-x-2">
        <div class="w-2 h-2 rounded-full bg-gray-400" id="connection-status"></div>
        <span class="text-xs text-gray-400" id="connection-text">Connecting...</span>
    </div>
</div>

<!-- Hidden data container for symbols -->
<div id="symbols-data" style="display: none;" 
     data-symbols='@if(isset($symbols) && $symbols->count() > 0){{ json_encode($symbols->map(function($symbol) { return ["symbol" => $symbol->symbol ?? "", "price" => $symbol->price ?? 0, "change" => $symbol->priceChange ?? 0, "image" => $symbol->image ?? null]; })->toArray()) }}@else[]@endif'>
</div>
<style>
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-marquee {
    animation: marquee 40s linear infinite;
}
</style>

<!-- Promotional Cards Section -->
<div class="py-20">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Exclusive <span class="gradient-text">Promotions</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Discover amazing opportunities and rewards designed to enhance your trading experience
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Super Airdrop Card -->
            <div class="feature-card rounded-3xl p-8 text-center hover-lift group" style="background-image: url('{{ asset('assets/images/1.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 200px;">
                
            </div>
            
            <!-- Gate Card Lucky Draw -->
            <div class="feature-card rounded-3xl p-8 text-center hover-lift group" style="background-image: url('{{ asset('assets/images/2.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 200px;">
            </div>
            
            <!-- Special Bonus -->
            <div class="feature-card rounded-3xl p-8 text-center hover-lift group" style="background-image: url('{{ asset('assets/images/3.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 200px;">
                
            </div>
        </div>
    </div>
</div>

<!-- Exchange Overview Section -->
<div class=" py-20" style="background-image: url('{{ asset('assets/images/bg1.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                A cryptocurrency exchange for <span class="gradient-text">Everyone</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                From beginners to professionals, we provide the tools and features you need to succeed in the crypto market
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center group">
                <div class="w-32 h-32 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full mx-auto mb-6 flex items-center justify-center border-2 border-cyan-500/30 group-hover:border-cyan-400/50 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-users text-cyan-400 text-4xl group-hover:text-cyan-300 transition-colors duration-300"></i>
                </div>
                <div class="text-5xl font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors duration-300">9M+</div>
                <div class="text-xl text-gray-400">Clients</div>
            </div>
            
            <div class="text-center group">
                <div class="w-32 h-32 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-full mx-auto mb-6 flex items-center justify-center border-2 border-purple-500/30 group-hover:border-purple-400/50 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-globe text-purple-400 text-4xl group-hover:text-purple-300 transition-colors duration-300"></i>
                </div>
                <div class="text-5xl font-bold text-white mb-2 group-hover:text-purple-400 transition-colors duration-300">190+</div>
                <div class="text-xl text-gray-400">Cryptos Supported</div>
            </div>
            
            <div class="text-center group">
                <div class="w-32 h-32 bg-gradient-to-r from-green-500/20 to-teal-500/20 rounded-full mx-auto mb-6 flex items-center justify-center border-2 border-green-500/30 group-hover:border-green-400/50 transition-all duration-300 group-hover:scale-110">
                    <i class="fas fa-chart-line text-green-400 text-4xl group-hover:text-green-300 transition-colors duration-300"></i>
                </div>
                <div class="text-5xl font-bold text-white mb-2 group-hover:text-green-400 transition-colors duration-300">$207B+</div>
                <div class="text-xl text-gray-400">Trading Volume</div>
            </div>
        </div>
    </div>
</div>

<!-- Coins Table Section -->
<div class=" py-20">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Web3 journey starts from <span class="gradient-text">here!</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Track real-time cryptocurrency prices and market movements
            </p>
        </div>
        
        <div class="overflow-hidden rounded-2xl border border-cyan-500/20">
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="coins-table">
                    <thead>
                        <tr class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 border-b border-cyan-500/20">
                            <th class="text-left font-bold p-6 text-cyan-400 text-lg">{{ __('index.home.trading_pair') }}</th>
                            <th class="text-center font-bold p-6 text-cyan-400 text-lg">{{ __('index.home.last_price') }}</th>
                            <th class="text-center font-bold p-6 text-cyan-400 text-lg">{{ __('index.home.fluctuation') }}</th>
                            <th class="text-center font-bold p-6 text-cyan-400 text-lg xs:hidden md:table-cell">{{ __('index.home.volume_24h') }}</th>
                            <th class="text-center font-bold p-6 text-cyan-400 text-lg xs:hidden md:table-cell" style="width: 150px;">{{ __('index.home.activity') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($symbols->take(10) as $symbol)
                        <tr class="border-b border-cyan-500/10 hover:bg-cyan-500/5 transition-colors duration-300" id="row-{{$symbol->symbol}}">
                            <td class="p-6">
                                <div class="flex items-center space-x-4">
                                    <img src="{{$symbol->image}}" alt="{{$symbol->name}}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <div class="text-white font-semibold text-lg">{{$symbol->name}}</div>
                                        <div class="text-cyan-400 text-sm">{{$symbol->symbol}}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center p-6">
                                <div class="price-value text-xl font-bold" id="price-{{$symbol->symbol}}">--</div>
                            </td>
                            <td class="text-center p-6">
                                <div class="change-value text-lg font-semibold" id="change-{{$symbol->symbol}}">--</div>
                            </td>
                            <td class="text-center p-6 xs:hidden md:table-cell">
                                <div class="volume-value text-lg" id="volume-{{$symbol->symbol}}">--</div>
                            </td>
                            <td class="text-center p-6 xs:hidden md:table-cell">
                                <canvas id="chart-{{$symbol->symbol}}" width="60" height="24" class="rounded-xl shadow"></canvas>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('market') }}" class="inline-flex items-center space-x-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 hover:scale-105 shadow-lg">
                <span>{{ __('index.home.view_more') }}</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>
    </div>
</div>
<!-- Trend Analysis Chart Section -->
<div class="py-20 md:py-20">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-16 md:mb-16">
            <h2 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                <span class="gradient-text">Trend Analysis</span>
            </h2>
            <p class="text-base md:text-xl text-gray-400 max-w-3xl mx-auto px-4">
                Track real-time cryptocurrency trends and market movements
            </p>
        </div>
        
        <!-- Crypto Pairs Selection -->
        <div class="overflow-x-auto mb-8 scrollbar-hide" style="position: relative; cursor: grab; max-width: 100%;">
            <div class="flex flex-nowrap gap-2 md:gap-4" id="crypto-pairs-container" style="min-width: max-content; scroll-behavior: smooth; user-select: none;">
                @foreach($symbols->take(8) as $index => $symbol)
                <div class="crypto-pair-item {{ $index === 0 ? 'bg-gradient-to-r from-gray-500/10 to-gray-600/10 border-2 border-gray-400/30 active' : 'bg-gradient-to-r from-gray-500/10 to-gray-600/10 border-2 border-gray-400/30' }} rounded-xl p-3 md:p-4 transition-all duration-300 min-w-[200px] md:min-w-[260px]" data-symbol="{{ $symbol->symbol }}" data-symbol-id="{{ $symbol->id }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm overflow-hidden">
                            @if($symbol->image)
                                <img src="{{ $symbol->image }}" alt="{{ $symbol->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center">
                                    {{ strtoupper(substr($symbol->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="text-white font-semibold">{{ $symbol->name }}</div>
                            <div class="text-2xl font-bold text-white crypto-price" id="trend-price-{{ $symbol->symbol }}">
                                <span class="loading-price">Loading...</span>
                            </div>
                            <div class="absolute top-2 right-2 w-3 h-3 rounded-full bg-cyan-400 opacity-0 transition-opacity duration-300 active-indicator"></div>
                            <div class="text-sm crypto-change" id="trend-change-{{ $symbol->symbol }}">
                                <span class="change-value {{ ($symbol->priceChange ?? 0) >= 0 ? 'text-cyan-400' : 'text-red-400' }}">
                                    {{ ($symbol->priceChange ?? 0) >= 0 ? '+' : '' }}{{ number_format($symbol->priceChange ?? 0, 4) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Time Range Selection -->
        <div class="flex justify-center mb-8">
            <div class="bg-gray-800/50 rounded-xl p-1 md:p-2 flex flex-wrap justify-center gap-1 md:gap-2">
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 text-xs md:text-sm" data-range="1min">1min</button>
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 text-xs md:text-sm" data-range="5min">5min</button>
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 text-xs md:text-sm" data-range="15min">15min</button>
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 text-xs md:text-sm" data-range="30min">30min</button>
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 active text-xs md:text-sm" data-range="1day">1day</button>
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 text-xs md:text-sm" data-range="1week">1week</button>
                <button class="time-range-btn px-2 md:px-4 py-1 md:py-2 rounded-lg text-white hover:bg-gray-700/50 transition-all duration-300 text-xs md:text-sm" data-range="1mon">1mon</button>
            </div>
        </div>
        
        <!-- Main Chart Area -->
        <div class="bg-gradient-to-b from-gray-900/50 to-gray-800/30 rounded-2xl md:rounded-3xl p-4 md:p-8 border border-cyan-500/20">
            <div class="w-full h-64 md:h-96 relative">
                <canvas id="trend-chart" class="w-full h-full"></canvas>
                <!-- Chart overlay for better visual appeal -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-2 md:top-4 left-2 md:left-4 text-white text-xs md:text-sm opacity-60">
                        <div class="font-semibold text-xs md:text-sm">24h Change</div>
                        <div class="text-base md:text-lg font-bold text-cyan-400" id="current-change">+0.5101%</div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy Trading Section -->

<!-- Trading Platform Section -->


@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Initialize symbols data safely
    @if(isset($symbols) && $symbols->count() > 0)
        const symbols = @json($symbols->pluck('symbol'));
    @else
        const symbols = [];
    @endif
    
    let ws = null;
    let charts = {};
    let priceHistory = {};

    function connectWebSocket() {
        const wsUrl = `{{env('WEBSOCKET_URL')}}?symbols=${JSON.stringify(symbols)}`;
        
        try {
            ws = new WebSocket(wsUrl);

            ws.onopen = () => {
                console.log('Connected to WebSocket server');
                updateConnectionStatus('connected');
            };

            ws.onmessage = (event) => {
                try {
                    const data = JSON.parse(event.data);
                    
                    if (data.type === 'marketData') {
                        updateMarketData(data.data1);
                        
                        // Update ticker with realtime data
                        if (data.data1 && data.data1.symbol && data.data1.price !== undefined) {
                            updateTickerFromWebSocket(
                                data.data1.symbol,
                                data.data1.price,
                                data.data1.priceChange || 0,
                                data.data1.image || null
                            );
                            
                            // Update trend chart data if it's the currently selected symbol
                            updateTrendChartFromWebSocket(data.data1);
                        }
                    }
                } catch (error) {
                    console.error('Error parsing WebSocket message:', error);
                }
            };

            ws.onerror = (error) => {
                console.error('WebSocket error:', error);
                updateConnectionStatus('error');
                // Fallback to polling if WebSocket fails
                startPollingFallback();
            };

            ws.onclose = () => {
                console.log('WebSocket connection closed. Reconnecting...');
                updateConnectionStatus('reconnecting');
                setTimeout(connectWebSocket, 3000);
            };
        } catch (error) {
            console.error('WebSocket connection failed:', error);
            // Fallback to polling
            startPollingFallback();
        }
    }

    // Update connection status indicator
    function updateConnectionStatus(status) {
        const statusElement = document.getElementById('connection-status');
        const textElement = document.getElementById('connection-text');
        
        if (statusElement && textElement) {
            switch (status) {
                case 'connected':
                    statusElement.className = 'w-2 h-2 rounded-full bg-green-400';
                    textElement.textContent = 'Connected';
                    textElement.className = 'text-xs text-green-400';
                    break;
                case 'error':
                    statusElement.className = 'w-2 h-2 rounded-full bg-red-400';
                    textElement.textContent = 'Error';
                    textElement.className = 'text-xs text-red-400';
                    break;
                case 'reconnecting':
                    statusElement.className = 'w-2 h-2 rounded-full bg-yellow-400';
                    textElement.textContent = 'Reconnecting...';
                    textElement.className = 'text-xs text-yellow-400';
                    break;
                default:
                    statusElement.className = 'w-2 h-2 rounded-full bg-gray-400';
                    textElement.textContent = 'Connecting...';
                    textElement.className = 'text-xs text-gray-400';
            }
        }
    }

    // Fallback polling method if WebSocket is not available
    function startPollingFallback() {
        console.log('Starting fallback polling for price updates');
        updateConnectionStatus('error');
        setInterval(() => {
            // Simulate small price changes for demo purposes
            tickerData.forEach(item => {
                const changePercent = (Math.random() - 0.5) * 0.1; // ±0.05%
                item.change += changePercent;
                const priceChange = item.price * (changePercent / 100);
                item.price += priceChange;
                if (item.price < 0) item.price = Math.abs(item.price);
            });
            updatePriceTicker();
            
            // Also update trend chart if available
            if (trendChart && currentSymbol) {
                const symbolData = tickerData.find(t => t.symbol === currentSymbol);
                if (symbolData) {
                    addDataPointToChart(currentSymbol, symbolData.price, currentTimeRange);
                }
            }
        }, 10000); // Update every 10 seconds
    }

    function updateMarketData(data) {
        const { price, priceChange, volume, high, low, volumeUsdt, symbol } = data;

        // Update price with animation
        const priceElement = document.getElementById(`price-${symbol}`);
        if (priceElement) {
            const oldPrice = parseFloat(priceElement.textContent.replace(/[^0-9.-]+/g, ''));
            const newPrice = parseFloat(price);
            
            priceElement.textContent = formatPrice(price);
            
            // Add animation class based on price change
            if (oldPrice && oldPrice !== newPrice) {
                priceElement.classList.remove('price-up', 'price-down');
                priceElement.classList.add(newPrice > oldPrice ? 'price-up' : 'price-down');
                setTimeout(() => {
                    priceElement.classList.remove('price-up', 'price-down');
                }, 1000);
            }
        }

        // Update price change with color
        const changeElement = document.getElementById(`change-${symbol}`);
        if (changeElement) {
            const changeText = `${priceChange >= 0 ? '+' : ''}${priceChange.toFixed(2)}%`;
            changeElement.textContent = changeText;
            changeElement.className = `change-value text-lg font-semibold ${priceChange >= 0 ? 'text-green-400' : 'text-red-400'}`;
        }

        // Update volume
        const volumeElement = document.getElementById(`volume-${symbol}`);
        if (volumeElement) {
            volumeElement.textContent = formatVolume(volume);
        }

        // Update chart
        updateChart(symbol, price);
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 8
        }).format(price);
    }

    function formatVolume(volume) {
        return new Intl.NumberFormat('en-US', {
            notation: 'compact',
            maximumFractionDigits: 2
        }).format(volume);
    }

    function updateChart(symbol, price) {
        if (!priceHistory[symbol]) {
            priceHistory[symbol] = [];
        }

        // Keep only last 30 points
        if (priceHistory[symbol].length > 30) {
            priceHistory[symbol].shift();
        }
        priceHistory[symbol].push(price);

        if (charts[symbol]) {
            charts[symbol].data.datasets[0].data = priceHistory[symbol];
            charts[symbol].update('none');
        }
    }

    function initCharts() {
        symbols.forEach(symbol => {
            const ctx = document.getElementById(`chart-${symbol}`);
            if (ctx) {
                priceHistory[symbol] = Array(30).fill(0);
                
                charts[symbol] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Array(30).fill(''),
                        datasets: [{
                            data: priceHistory[symbol],
                            borderColor: '#06b6d4',
                            borderWidth: 3,
                            pointRadius: 0,
                            tension: 0.4,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0
                        },
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
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }
        });
    }

    // Add CSS for price animations
    const style = document.createElement('style');
    style.textContent = `
        .price-up {
            color: #10B981 !important;
            transition: all 0.3s ease;
        }
        .price-down {
            color: #EF4444 !important;
            transition: all 0.3s ease;
        }
        .ticker-item {
            transition: all 0.3s ease;
        }
        .ticker-item:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* Loading animation for chart */
        .chart-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #06b6d4;
            font-size: 18px;
        }
        
        .chart-loading::after {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #06b6d4;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);

    // Price ticker data and functions - Realtime from WebSocket
    let tickerData = [];
    let tickerUpdateQueue = [];

    function updatePriceTicker() {
        const track = document.getElementById('price-ticker-track');
        if (!track || tickerData.length === 0) return;

        // Clear existing content
        track.innerHTML = '';

        // Add items twice for seamless loop
        for (let i = 0; i < 2; i++) {
            tickerData.forEach(item => {
                const tickerItem = document.createElement('div');
                tickerItem.className = 'ticker-item flex items-center space-x-3';
                tickerItem.setAttribute('data-symbol', item.symbol);
                
                // Create image element
                const image = document.createElement('img');
                image.className = 'w-6 h-6 rounded-full flex-shrink-0';
                image.alt = `${item.symbol} logo`;
                image.loading = 'lazy';
                
                // Set image source based on symbol
                if (item.image) {
                    image.src = item.image;
                } else {
                    // Fallback to default image or generate from symbol
                    image.src = `https://cryptologos.cc/logos/${item.symbol.toLowerCase()}-logo.png`;
                }
                
                // Handle image loading errors with multiple fallbacks
                image.onerror = function() {
                    // Try alternative crypto logo source
                    if (this.src.includes('cryptologos.cc')) {
                        this.src = `https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/color/${item.symbol.toLowerCase()}.png`;
                    } else if (this.src.includes('githubusercontent.com')) {
                        // Final fallback to placeholder with symbol initial
                        this.src = `https://via.placeholder.com/24x24/06b6d4/ffffff?text=${item.symbol.charAt(0)}`;
                    }
                };
                
                // Add loading state
                image.onload = function() {
                    this.style.opacity = '1';
                };
                image.style.opacity = '0.7';
                image.style.transition = 'opacity 0.3s ease';
                
                const symbol = document.createElement('span');
                symbol.className = 'text-white font-semibold';
                symbol.textContent = item.symbol;
                
                const price = document.createElement('span');
                price.className = 'text-white';
                price.textContent = `$${item.price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 8 })}`;
                
                const change = document.createElement('span');
                change.className = item.change >= 0 ? 'text-cyan-400' : 'text-red-400';
                change.textContent = `(${item.change >= 0 ? '+' : ''}${item.change.toFixed(4)}%)`;
                
                tickerItem.appendChild(image);
                tickerItem.appendChild(symbol);
                tickerItem.appendChild(price);
                tickerItem.appendChild(change);
                
                track.appendChild(tickerItem);
            });
        }
    }

    function updateTickerFromWebSocket(symbol, price, priceChange, image = null) {
        // Find existing ticker item
        let tickerItem = tickerData.find(item => item.symbol === symbol);
        
        if (tickerItem) {
            // Update existing item with animation
            const oldPrice = tickerItem.price;
            const oldChange = tickerItem.change;
            
            tickerItem.price = parseFloat(price);
            tickerItem.change = parseFloat(priceChange);
            
            // Update image if provided
            if (image) {
                tickerItem.image = image;
            }
            
            // Add to update queue for smooth updates
            tickerUpdateQueue.push({
                symbol: symbol,
                oldPrice: oldPrice,
                newPrice: tickerItem.price,
                oldChange: oldChange,
                newChange: tickerItem.change
            });
        } else {
            // Add new item
            tickerData.push({
                symbol: symbol,
                price: parseFloat(price),
                change: parseFloat(priceChange),
                image: image
            });
        }
        
        // Limit ticker data to prevent memory issues
        if (tickerData.length > 20) {
            tickerData = tickerData.slice(-20);
        }
        
        // Update ticker display
        updatePriceTicker();
    }

    function processTickerUpdates() {
        if (tickerUpdateQueue.length === 0) return;
        
        tickerUpdateQueue.forEach(update => {
            // Find ticker item in DOM and add animation
            const tickerItems = document.querySelectorAll(`[data-symbol="${update.symbol}"]`);
            tickerItems.forEach(item => {
                if (update.newPrice > update.oldPrice) {
                    item.classList.add('price-up');
                    setTimeout(() => item.classList.remove('price-up'), 1000);
                } else if (update.newPrice < update.oldPrice) {
                    item.classList.add('price-down');
                    setTimeout(() => item.classList.remove('price-down'), 1000);
                }
            });
        });
        
        // Clear queue
        tickerUpdateQueue = [];
    }

        // Initialize ticker data from symbols
    function initializeTickerData() {
        try {
            // Get symbols data from hidden data container
            const symbolsDataElement = document.getElementById('symbols-data');
            if (symbolsDataElement) {
                const symbolsData = symbolsDataElement.getAttribute('data-symbols');
                if (symbolsData && symbolsData !== '[]') {
                    tickerData = JSON.parse(symbolsData);
                } else {
                    tickerData = [];
                }
            } else {
                tickerData = [];
            }
            
            // If no data from server, create some demo data with images
            if (!tickerData || tickerData.length === 0) {
                tickerData = [
                    { symbol: 'BTC', price: 43521.67, change: 2.1234, image: 'https://cryptologos.cc/logos/bitcoin-btc-logo.png' },
                    { symbol: 'ETH', price: 2654.89, change: -1.2345, image: 'https://cryptologos.cc/logos/ethereum-eth-logo.png' },
                    { symbol: 'BNB', price: 312.45, change: 0.8765, image: 'https://cryptologos.cc/logos/bnb-bnb-logo.png' },
                    { symbol: 'XRP', price: 0.5678, change: -0.9876, image: 'https://cryptologos.cc/logos/xrp-xrp-logo.png' },
                    { symbol: 'SOL', price: 213.52, change: 3.8555, image: 'https://cryptologos.cc/logos/solana-sol-logo.png' },
                    { symbol: 'ADA', price: 0.8504, change: -0.5424, image: 'https://cryptologos.cc/logos/cardano-ada-logo.png' }
                ];
            }
            
            updatePriceTicker();
        } catch (error) {
            console.error('Error initializing ticker data:', error);
            // Fallback to demo data
            tickerData = [
                { symbol: 'BTC', price: 43521.67, change: 2.1234, image: 'https://cryptologos.cc/logos/bitcoin-btc-logo.png' },
                { symbol: 'ETH', price: 2654.89, change: -1.2345, image: 'https://cryptologos.cc/logos/ethereum-eth-logo.png' },
                { symbol: 'BNB', price: 312.45, change: 0.8765, image: 'https://cryptologos.cc/logos/bnb-bnb-logo.png' },
                { symbol: 'XRP', price: 0.5678, change: -0.9876, image: 'https://cryptologos.cc/logos/xrp-xrp-logo.png' },
                { symbol: 'SOL', price: 213.52, change: 3.8555, image: 'https://cryptologos.cc/logos/solana-sol-logo.png' },
                { symbol: 'ADA', price: 0.8504, change: -0.5424, image: 'https://cryptologos.cc/logos/cardano-ada-logo.png' }
            ];
            updatePriceTicker();
        }
    }

    // Trend Analysis Chart Functions
    let trendChart = null;
    let currentSymbol = 'BTC/USDT';
    let currentTimeRange = '1day';

    function initTrendChart() {
        const ctx = document.getElementById('trend-chart');
        if (!ctx) return;

        // Initialize with first symbol from database
        const firstSymbol = document.querySelector('.crypto-pair-item.active');
        if (firstSymbol) {
            currentSymbol = firstSymbol.getAttribute('data-symbol');
        }

        // Initialize chart data storage
        window.trendChartData = {};
        window.trendChartLabels = {};

        // Generate initial data for the chart
        const initialData = generateInitialChartData(currentSymbol, currentTimeRange);
        const initialLabels = generateLabels(currentTimeRange);

        // Create chart with initial data
        trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: initialLabels,
                datasets: [{
                    label: currentSymbol,
                    data: initialData,
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 3,
                    pointRadius: 0,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                layout: {
                    padding: {
                        right: 20
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#06b6d4',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        display: true,
                        position: 'bottom',
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#fff',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        display: true,
                        position: 'right',
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#06b6d4',
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            },
                            padding: 8
                        },
                        border: {
                            color: 'rgba(6, 182, 212, 0.3)',
                            width: 1
                        }
                    }
                }
            }
        });

        // Add event listeners
        setupTrendChartEvents();
        
        // Initialize chart overlay
        updateChartOverlay(currentSymbol, currentTimeRange);
        
        // Load initial data
        loadTrendChartData(currentSymbol, currentTimeRange);
        
        // Set up error handling and retry mechanism
        setupErrorHandling();
        
        // Connect to Binance WebSocket for real-time updates
        setTimeout(() => {
            connectBinanceWebSocket();
        }, 1000);
        
        // Cleanup WebSocket when page is unloaded
        window.addEventListener('beforeunload', () => {
            if (window.binanceWebSocket) {
                window.binanceWebSocket.close();
            }
        });
        
        // Initialize enhanced scrolling for crypto pairs
        initEnhancedScrolling();
        
        // Test simple drag functionality
        testSimpleDrag();
        
        // Initialize real-time price updates
        initRealTimePrices();
        
        // Test drag functionality after a short delay
        setTimeout(() => {
            console.log('Testing drag functionality...');
            testDragFunctionality();
        }, 1000);
        
        // Test active state functionality
        setTimeout(() => {
            console.log('Testing active state functionality...');
            testActiveState();
        }, 1500);
    }
    
    // Test simple drag functionality
    function testSimpleDrag() {
        // Get both containers
        const outerContainer = document.querySelector('.overflow-x-auto');
        const innerContainer = document.getElementById('crypto-pairs-container');
        
        if (!outerContainer || !innerContainer) {
            console.error('Containers not found');
            return;
        }
        
        console.log('Testing drag for both containers:', { outerContainer, innerContainer });
        
        let isDragging = false;
        let startX = 0;
        let scrollLeft = 0;
        
        // Remove any existing event listeners
        outerContainer.onmousedown = null;
        innerContainer.onmousedown = null;
        
        // Function to handle mouse down on either container
        function handleMouseDown(e) {
            console.log('Mouse down detected on container');
            e.preventDefault();
            e.stopPropagation();
            
            isDragging = true;
            startX = e.pageX - outerContainer.offsetLeft;
            scrollLeft = outerContainer.scrollLeft;
            
            // Update cursor on both containers
            outerContainer.style.cursor = 'grabbing';
            innerContainer.style.cursor = 'grabbing';
            
            // Add event listeners to document for better tracking
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);
        }
        
        function handleMouseMove(e) {
            if (!isDragging) return;
            e.preventDefault();
            
            const x = e.pageX - outerContainer.offsetLeft;
            const walk = (x - startX) * 2;
            outerContainer.scrollLeft = scrollLeft - walk;
        }
        
        function handleMouseUp(e) {
            if (!isDragging) return;
            console.log('Mouse up detected');
            
            isDragging = false;
            
            // Reset cursor on both containers
            outerContainer.style.cursor = 'grab';
            innerContainer.style.cursor = 'grab';
            
            // Remove document event listeners
            document.removeEventListener('mousemove', handleMouseMove);
            document.removeEventListener('mouseup', handleMouseUp);
        }
        
        // Add event listeners to both containers
        outerContainer.onmousedown = handleMouseDown;
        innerContainer.onmousedown = handleMouseDown;
        
        // Touch events for mobile
        outerContainer.ontouchstart = function(e) {
            console.log('Touch start detected on outer container');
            const touch = e.touches[0];
            startX = touch.pageX - outerContainer.offsetLeft;
            scrollLeft = outerContainer.scrollLeft;
        };
        
        outerContainer.ontouchmove = function(e) {
            e.preventDefault();
            const touch = e.touches[0];
            const x = touch.pageX - outerContainer.offsetLeft;
            const walk = (x - startX) * 2;
            outerContainer.scrollLeft = scrollLeft - walk;
        };
        
        // Set initial cursor and prevent text selection on both containers
        outerContainer.style.cursor = 'grab';
        innerContainer.style.cursor = 'grab';
        
        // Test if containers are scrollable
        console.log('Outer container scrollable:', outerContainer.scrollWidth > outerContainer.clientWidth);
        console.log('Outer scroll width:', outerContainer.scrollWidth);
        console.log('Outer client width:', outerContainer.clientWidth);
        console.log('Inner container scrollable:', innerContainer.scrollWidth > innerContainer.clientWidth);
        console.log('Inner scroll width:', innerContainer.scrollWidth);
        console.log('Inner client width:', innerContainer.clientWidth);
        
        console.log('Enhanced drag test initialized for both containers');
        
        // Test scrolling manually
        setTimeout(() => {
            console.log('Testing manual scroll...');
            if (outerContainer.scrollWidth > outerContainer.clientWidth) {
                const originalScroll = outerContainer.scrollLeft;
                outerContainer.scrollLeft += 200;
                console.log('Manual scroll test:', originalScroll, '→', outerContainer.scrollLeft);
                setTimeout(() => {
                    outerContainer.scrollLeft = originalScroll;
                    console.log('Reset scroll position');
                }, 1000);
            }
        }, 500);
    }
    
    // Test active state functionality
    function testActiveState() {
        console.log('=== ACTIVE STATE TEST ===');
        
        const cryptoItems = document.querySelectorAll('.crypto-pair-item');
        console.log('Found crypto items:', cryptoItems.length);
        
        // Check initial state
        const activeItems = document.querySelectorAll('.crypto-pair-item.active');
        console.log('Initial active items:', activeItems.length);
        
        if (activeItems.length > 0) {
            console.log('✅ Initial active state working');
            console.log('Active item:', activeItems[0].getAttribute('data-symbol'));
        } else {
            console.log('❌ No initial active state found');
        }
        
        // Test click functionality
        if (cryptoItems.length > 1) {
            const secondItem = cryptoItems[1];
            const secondSymbol = secondItem.getAttribute('data-symbol');
            
            console.log('Testing click on second item:', secondSymbol);
            
            // Simulate click
            secondItem.click();
            
            setTimeout(() => {
                const newActiveItems = document.querySelectorAll('.crypto-pair-item.active');
                console.log('Active items after click:', newActiveItems.length);
                
                if (newActiveItems.length === 1 && newActiveItems[0].getAttribute('data-symbol') === secondSymbol) {
                    console.log('✅ Click to change active state working');
                } else {
                    console.log('❌ Click to change active state not working');
                }
                
                // Reset to first item
                setTimeout(() => {
                    cryptoItems[0].click();
                    console.log('Reset to first item');
                }, 500);
                
            }, 100);
        }
        
        console.log('=== END ACTIVE STATE TEST ===');
        
        // Visual test - highlight active item
        const activeItem = document.querySelector('.crypto-pair-item.active');
        if (activeItem) {
            console.log('Active item found:', activeItem.getAttribute('data-symbol'));
            console.log('Active item background:', window.getComputedStyle(activeItem).background);
            console.log('Active item border:', window.getComputedStyle(activeItem).border);
            
            // Add extra visual feedback
            activeItem.style.outline = '3px solid rgba(6, 182, 212, 0.8)';
            activeItem.style.outlineOffset = '2px';
            
            setTimeout(() => {
                activeItem.style.outline = '';
                activeItem.style.outlineOffset = '';
            }, 2000);
        }
    }
    
    // Test drag functionality
    function testDragFunctionality() {
        const container = document.getElementById('crypto-pairs-container');
        if (!container) {
            console.error('Container not found for drag test');
            return;
        }
        
        console.log('=== DRAG FUNCTIONALITY TEST ===');
        console.log('Container:', container);
        console.log('Container scrollable:', container.scrollWidth > container.clientWidth);
        console.log('Scroll width:', container.scrollWidth);
        console.log('Client width:', container.clientWidth);
        console.log('Current scroll left:', container.scrollLeft);
        console.log('Container cursor:', container.style.cursor);
        console.log('Container user-select:', container.style.userSelect);
        
        // Test if container has content to scroll
        const items = container.querySelectorAll('.crypto-pair-item');
        console.log('Number of crypto items:', items.length);
        console.log('Total items width:', items.length * 260); // 260px per item
        
        // Test scroll behavior
        if (container.scrollWidth > container.clientWidth) {
            console.log('✅ Container is scrollable');
            
            // Test manual scroll
            const originalScrollLeft = container.scrollLeft;
            container.scrollLeft += 100;
            console.log('Manual scroll test:', originalScrollLeft, '→', container.scrollLeft);
            
            // Reset scroll position
            container.scrollLeft = originalScrollLeft;
        } else {
            console.log('❌ Container is NOT scrollable - need more items or wider container');
        }
        
        console.log('=== END DRAG TEST ===');
    }

// Function to fetch and update real-time crypto prices
function updateCryptoPrices() {
    console.log('Updating crypto prices...');
    
    // Get all crypto pair items
    const cryptoItems = document.querySelectorAll('.crypto-pair-item');
    
    cryptoItems.forEach(item => {
        const symbol = item.getAttribute('data-symbol');
        if (symbol) {
            // Fetch real-time price from Binance API
            fetch(`https://api.binance.com/api/v3/ticker/24hr?symbol=${symbol}`)
                .then(response => response.json())
                .then(data => {
                    if (data.lastPrice && data.priceChangePercent) {
                        const price = parseFloat(data.lastPrice);
                        const change = parseFloat(data.priceChangePercent);
                        
                        // Update price display
                        const priceElement = item.querySelector('.crypto-price');
                        if (priceElement) {
                            priceElement.innerHTML = `$${formatPrice(price)}`;
                            priceElement.classList.remove('loading');
                        }
                        
                        // Update change display
                        const changeElement = item.querySelector('.crypto-change .change-value');
                        if (changeElement) {
                            const changeText = change >= 0 ? `+${change.toFixed(4)}%` : `${change.toFixed(4)}%`;
                            changeElement.textContent = changeText;
                            changeElement.className = `change-value ${change >= 0 ? 'text-cyan-400' : 'text-red-400'}`;
                        }
                        
                        // Store real-time data for chart
                        if (!window.symbolRealTimeData) {
                            window.symbolRealTimeData = {};
                        }
                        window.symbolRealTimeData[symbol] = {
                            price: price,
                            change: change
                        };
                        
                        console.log(`Updated ${symbol}: $${price} (${change}%)`);
                    }
                })
                .catch(error => {
                    console.error(`Error fetching data for ${symbol}:`, error);
                });
        }
    });
}

// Initialize real-time price updates
function initRealTimePrices() {
    console.log('Initializing real-time price updates...');
    
    // Update prices immediately
    updateCryptoPrices();
    
    // Update prices every 10 seconds
    setInterval(updateCryptoPrices, 10000);
    
    // Also update when user switches between symbols
    document.addEventListener('symbolSelected', () => {
        updateCryptoPrices();
    });
    
    console.log('Real-time price updates initialized');
}

// Format price with proper decimal places
function formatPrice(price) {
    if (price >= 1000) {
        return price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    } else if (price >= 1) {
        return price.toFixed(2);
    } else if (price >= 0.01) {
        return price.toFixed(4);
    } else {
        return price.toFixed(8);
    }
}
    
    // Initialize enhanced scrolling functionality
    function initEnhancedScrolling() {
        const container = document.getElementById('crypto-pairs-container');
        if (!container) return;
        
        let isScrolling = false;
        let startX = 0;
        let scrollLeft = 0;
        
        // Mouse events for desktop
        container.addEventListener('mousedown', (e) => {
            isScrolling = true;
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
            container.style.cursor = 'grabbing';
            container.style.userSelect = 'none';
        });
        
        container.addEventListener('mousemove', (e) => {
            if (!isScrolling) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            container.scrollLeft = scrollLeft - walk;
        });
        
        container.addEventListener('mouseup', () => {
            isScrolling = false;
            container.style.cursor = 'grab';
            container.style.removeProperty('user-select');
        });
        
        container.addEventListener('mouseleave', () => {
            isScrolling = false;
            container.style.cursor = 'grab';
            container.style.removeProperty('user-select');
        });
        
        // Touch events for mobile
        container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });
        
        container.addEventListener('touchmove', (e) => {
            if (!startX) return;
            e.preventDefault();
            const x = e.touches[0].pageX - container.offsetLeft;
            const walk = (x - startX) * 2;
            container.scrollLeft = scrollLeft - walk;
        });
        
        container.addEventListener('touchend', () => {
            startX = 0;
        });
        
        // Set initial cursor style
        container.style.cursor = 'grab';
        
        // Add smooth scroll indicators
        addScrollIndicators();
    }
    
    // Add scroll indicators to show scrollable content
    function addScrollIndicators() {
        const container = document.getElementById('crypto-pairs-container');
        if (!container) return;
        
        // Create left indicator
        const leftIndicator = document.createElement('div');
        leftIndicator.className = 'scroll-indicator left-indicator';
        leftIndicator.innerHTML = '<i class="fas fa-chevron-left"></i>';
        leftIndicator.style.cssText = `
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(6, 182, 212, 0.2);
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            backdrop-filter: blur(10px);
            opacity: 0;
            pointer-events: none;
        `;
        
        // Create right indicator
        const rightIndicator = document.createElement('div');
        rightIndicator.className = 'scroll-indicator right-indicator';
        rightIndicator.innerHTML = '<i class="fas fa-chevron-right"></i>';
        rightIndicator.style.cssText = `
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(6, 182, 212, 0.2);
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            backdrop-filter: blur(10px);
            opacity: 0;
            pointer-events: none;
        `;
        
        // Add indicators to container
        container.parentElement.style.position = 'relative';
        container.parentElement.appendChild(leftIndicator);
        container.parentElement.appendChild(rightIndicator);
        
        // Add click events
        leftIndicator.addEventListener('click', () => {
            container.scrollBy({ left: -300, behavior: 'smooth' });
        });
        
        rightIndicator.addEventListener('click', () => {
            container.scrollBy({ left: 300, behavior: 'smooth' });
        });
        
        // Update indicators on scroll
        container.addEventListener('scroll', () => {
            updateScrollIndicators(container, leftIndicator, rightIndicator);
        });
        
        // Initial update
        updateScrollIndicators(container, leftIndicator, rightIndicator);
        
        // Update on window resize
        window.addEventListener('resize', () => {
            updateScrollIndicators(container, leftIndicator, rightIndicator);
        });
    }
    
    // Update scroll indicators visibility
    function updateScrollIndicators(container, leftIndicator, rightIndicator) {
        const { scrollLeft, scrollWidth, clientWidth } = container;
        
        // Show/hide left indicator
        if (scrollLeft <= 0) {
            leftIndicator.style.opacity = '0';
            leftIndicator.style.pointerEvents = 'none';
        } else {
            leftIndicator.style.opacity = '1';
            leftIndicator.style.pointerEvents = 'auto';
        }
        
        // Show/hide right indicator
        if (scrollLeft >= scrollWidth - clientWidth - 5) {
            rightIndicator.style.opacity = '0';
            rightIndicator.style.pointerEvents = 'none';
        } else {
            rightIndicator.style.opacity = '1';
            rightIndicator.style.pointerEvents = 'auto';
        }
    }
    
    // Get Binance API parameters based on time range
    function getBinanceParams(timeRange) {
        const params = {
            '1min': { interval: '1m', limit: 60 },
            '5min': { interval: '5m', limit: 60 },
            '15min': { interval: '15m', limit: 60 },
            '30min': { interval: '30m', limit: 60 },
            '1day': { interval: '15m', limit: 96 }, // 15-minute intervals for 1 day
            '1week': { interval: '1h', limit: 168 }, // 1-hour intervals for 1 week
            '1mon': { interval: '4h', limit: 180 } // 4-hour intervals for 1 month
        };
        
        return params[timeRange] || { interval: '15m', limit: 96 };
    }
    
    // Transform Binance klines data to chart format
    function transformBinanceData(binanceData, timeRange) {
        if (!Array.isArray(binanceData) || binanceData.length === 0) {
            console.warn('Invalid Binance data received');
            return [];
        }
        
        const chartData = [];
        const chartLabels = [];
        
        binanceData.forEach((candle, index) => {
            // Binance klines format: [openTime, open, high, low, close, volume, closeTime, ...]
            const [openTime, open, high, low, close, volume] = candle;
            
            // Use close price for chart
            chartData.push(parseFloat(close));
            
            // Generate label based on time range
            const timestamp = parseInt(openTime);
            const date = new Date(timestamp);
            
            let label;
            if (timeRange === '1min' || timeRange === '5min' || timeRange === '15min' || timeRange === '30min') {
                label = date.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
            } else if (timeRange === '1day') {
                label = date.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' });
            } else if (timeRange === '1week') {
                label = date.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' });
            } else {
                label = date.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' });
            }
            
            chartLabels.push(label);
        });
        
        console.log(`Transformed ${chartData.length} data points from Binance API`);
        
        return {
            prices: chartData,
            labels: chartLabels,
            volume: binanceData.map(candle => parseFloat(candle[5])),
            high: binanceData.map(candle => parseFloat(candle[2])),
            low: binanceData.map(candle => parseFloat(candle[3])),
            open: binanceData.map(candle => parseFloat(candle[1]))
        };
    }
    
    // Generate initial chart data for display
    function generateInitialChartData(symbol, timeRange) {
        // Get current price from DOM or use default
        const currentPrice = getCurrentSymbolPrice(symbol) || 50000;
        
        // Generate realistic data based on current price
        const points = getDataPointsForTimeRange(timeRange);
        const data = [];
        let price = currentPrice;
        
        // Generate data points going backwards in time
        for (let i = points - 1; i >= 0; i--) {
            // Add some realistic volatility
            const volatility = getVolatilityForTimeRange(timeRange);
            const change = (Math.random() - 0.5) * volatility * price;
            price -= change; // Go backwards in time
            
            // Ensure price doesn't go too low
            price = Math.max(price, currentPrice * 0.5);
            
            data.push(parseFloat(price.toFixed(6)));
        }
        
        // Reverse to show correct time progression
        return data.reverse();
    }
    
    // Setup error handling and retry mechanism
    function setupErrorHandling() {
        // Handle chart loading errors
        window.addEventListener('error', function(e) {
            if (e.target && e.target.id === 'trend-chart') {
                console.error('Chart error:', e);
                // Retry loading chart data
                setTimeout(() => {
                    if (currentSymbol && currentTimeRange) {
                        loadTrendChartData(currentSymbol, currentTimeRange);
                    }
                }, 5000);
            }
        });
        
        // Handle network errors
        window.addEventListener('offline', function() {
            console.log('Network is offline, using fallback data');
            updateConnectionStatus('error');
        });
        
        window.addEventListener('online', function() {
            console.log('Network is back online');
            updateConnectionStatus('connected');
            // Retry loading data
            if (currentSymbol && currentTimeRange) {
                loadTrendChartData(currentSymbol, currentTimeRange);
            }
        });
    }
    
    // Load real-time chart data from Binance API
    async function loadTrendChartData(symbol, timeRange) {
        try {
            // Show loading state
            if (trendChart) {
                console.log(`Loading Binance chart data for ${symbol} - ${timeRange}`);
            }
            
            // Convert symbol format from BTC/USDT to BTCUSDT for Binance API
            const binanceSymbol = symbol.replace('/', '');
            
            // Get interval and limit based on time range
            const { interval, limit } = getBinanceParams(timeRange);
            
            // Binance API endpoint
            const apiUrl = `https://api.binance.com/api/v3/klines?symbol=${binanceSymbol}&interval=${interval}&limit=${limit}`;
            
            console.log(`Calling Binance API: ${apiUrl}`);
            
            // Fetch data from Binance API
            const response = await fetch(apiUrl);
            if (response.ok) {
                const binanceData = await response.json();
                console.log(`Binance API response:`, binanceData);
                
                // Transform Binance data to chart format
                const chartData = transformBinanceData(binanceData, timeRange);
                updateChartWithRealData(symbol, timeRange, chartData);
                return;
            } else {
                console.error(`Binance API error: ${response.status} - ${response.statusText}`);
                throw new Error(`Binance API error: ${response.status}`);
            }
            
            // Fallback: generate sample data based on current symbol price
            const currentPrice = getCurrentSymbolPrice(symbol);
            if (currentPrice) {
                const fallbackData = generateRealisticData(timeRange, currentPrice);
                updateChartWithRealData(symbol, timeRange, fallbackData);
            } else {
                // If no current price, generate default data
                const defaultData = generateInitialChartData(symbol, timeRange);
                updateChartWithRealData(symbol, timeRange, defaultData);
            }
            
        } catch (error) {
            console.error('Error loading chart data:', error);
            
            // Fallback to sample data
            const currentPrice = getCurrentSymbolPrice(symbol);
            if (currentPrice) {
                const fallbackData = generateRealisticData(timeRange, currentPrice);
                updateChartWithRealData(symbol, timeRange, fallbackData);
            } else {
                // If no current price, generate default data
                const defaultData = generateInitialChartData(symbol, timeRange);
                updateChartWithRealData(symbol, timeRange, defaultData);
            }
        }
    }
    
    function updateChartWithRealData(symbol, timeRange, data) {
        if (!trendChart) return;
        
        console.log(`Updating chart with data for ${symbol} - ${timeRange}:`, data);
        
        // Store data for future use
        if (!window.trendChartData[symbol]) {
            window.trendChartData[symbol] = {};
        }
        if (!window.trendChartLabels[symbol]) {
            window.trendChartLabels[symbol] = {};
        }
        
        // Handle different data formats
        let chartData, chartLabels;
        
        if (data && typeof data === 'object' && data.prices) {
            // Binance API response format
            chartData = data.prices;
            chartLabels = data.labels || generateLabels(timeRange);
        } else if (Array.isArray(data)) {
            // Direct array format
            chartData = data;
            chartLabels = generateLabels(timeRange);
        } else {
            // Fallback to empty data
            chartData = [];
            chartLabels = [];
        }
        
        // Ensure we have valid data
        if (chartData.length === 0) {
            console.warn(`No valid data for ${symbol} - ${timeRange}, generating fallback data`);
            chartData = generateInitialChartData(symbol, timeRange);
            chartLabels = generateLabels(timeRange);
        }
        
        window.trendChartData[symbol][timeRange] = chartData;
        window.trendChartLabels[symbol][timeRange] = chartLabels;
        
        // Update chart
        trendChart.data.labels = chartLabels;
        trendChart.data.datasets[0].data = chartData;
        trendChart.data.datasets[0].label = symbol;
        
        console.log(`Chart updated with ${chartData.length} data points`);
        trendChart.update();
    }
    
    function getCurrentSymbolPrice(symbol) {
        const priceElement = document.getElementById(`trend-price-${symbol}`);
        if (priceElement) {
            const priceText = priceElement.textContent;
            return parseFloat(priceText.replace(/[^0-9.-]+/g, ''));
        }
        return null;
    }
    
    function generateRealisticData(timeRange, currentPrice) {
        const points = getDataPointsForTimeRange(timeRange);
        const data = [];
        let price = currentPrice;
        
        // Generate realistic price movement
        for (let i = 0; i < points; i++) {
            // Add volatility based on time range
            const volatility = getVolatilityForTimeRange(timeRange);
            const change = (Math.random() - 0.5) * volatility * price;
            price += change;
            
            // Ensure price doesn't go negative
            price = Math.max(price, currentPrice * 0.1);
            
            data.push(parseFloat(price.toFixed(6)));
        }
        
        return data;
    }
    
    function getDataPointsForTimeRange(timeRange) {
        const points = {
            '1min': 60,
            '5min': 60,
            '15min': 60,
            '30min': 60,
            '1day': 96, // 15-minute intervals
            '1week': 168, // 1-hour intervals
            '1mon': 720 // 1-hour intervals
        };
        return points[timeRange] || 60;
    }
    
    function getVolatilityForTimeRange(timeRange) {
        const volatility = {
            '1min': 0.001, // 0.1%
            '5min': 0.002, // 0.2%
            '15min': 0.003, // 0.3%
            '30min': 0.005, // 0.5%
            '1day': 0.02, // 2%
            '1week': 0.05, // 5%
            '1mon': 0.15 // 15%
        };
        return volatility[timeRange] || 0.01;
    }

    function generateSampleData(points, minValue, maxValue) {
        const data = [];
        let currentValue = minValue + (maxValue - minValue) * 0.5;
        
        for (let i = 0; i < points; i++) {
            // Add some realistic volatility
            const volatility = (maxValue - minValue) * 0.1;
            const change = (Math.random() - 0.5) * volatility;
            currentValue += change;
            
            // Keep within bounds
            currentValue = Math.max(minValue, Math.min(maxValue, currentValue));
            
            data.push(parseFloat(currentValue.toFixed(2)));
        }
        
        return data;
    }

    function generateLabels(timeRange) {
        const labels = [];
        const now = new Date();
        
        switch(timeRange) {
            case '1min':
                for (let i = 59; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 60000);
                    labels.push(time.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }));
                }
                break;
            case '5min':
                for (let i = 59; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 300000);
                    labels.push(time.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }));
                }
                break;
            case '15min':
                for (let i = 59; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 900000);
                    labels.push(time.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }));
                }
                break;
            case '30min':
                for (let i = 59; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 1800000);
                    labels.push(time.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }));
                }
                break;
            case '1day':
                for (let i = 89; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 960000); // 16 minutes intervals
                    labels.push(time.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' }));
                }
                break;
            case '1week':
                for (let i = 51; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 2016000); // ~40 minutes intervals
                    labels.push(time.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' }));
                }
                break;
            case '1mon':
                for (let i = 29; i >= 0; i--) {
                    const time = new Date(now.getTime() - i * 2880000); // ~1 hour intervals
                    labels.push(time.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' }));
                }
                break;
        }
        
        return labels;
    }

    function setupTrendChartEvents() {
        // Crypto pair selection
        document.querySelectorAll('.crypto-pair-item').forEach(item => {
            item.addEventListener('click', function() {
                const symbol = this.getAttribute('data-symbol');
                
                // Update active state
                document.querySelectorAll('.crypto-pair-item').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                
                // Update chart data
                updateTrendChart(symbol, currentTimeRange);
                
                // Connect to Binance WebSocket for new symbol
                connectBinanceWebSocket();
            });
        });

        // Time range selection
        document.querySelectorAll('.time-range-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const range = this.getAttribute('data-range');
                
                // Update active state
                document.querySelectorAll('.time-range-btn').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                
                // Update chart data
                updateTrendChart(currentSymbol, range);
            });
        });
    }

    function updateTrendChart(symbol, timeRange) {
        if (!trendChart) return;
        
        console.log(`Updating trend chart: ${symbol} - ${timeRange}`);
        
        currentSymbol = symbol;
        currentTimeRange = timeRange;
        
        // Check if we already have data for this symbol and time range
        if (window.trendChartData[symbol] && window.trendChartData[symbol][timeRange]) {
            // Use cached data
            updateChartWithRealData(symbol, timeRange, window.trendChartData[symbol][timeRange]);
        } else {
            // Load new data from API
            loadTrendChartData(symbol, timeRange);
        }
        
        // Update crypto pair display
        updateCryptoPairDisplay(symbol);
        
            // Update chart overlay information
    updateChartOverlay(symbol, timeRange);
}

    function getSymbolPriceRange(symbol) {
        const ranges = {
            'BTC/USDT': [95000, 125000],
            'ETH/USDT': [4200, 4800],
            'ATOM/USDT': [4.4, 5.0],
            'BCH/USDT': [530, 590]
        };
        return ranges[symbol] || [100, 1000];
    }

    function updateCryptoPairDisplay(symbol) {
        // Update the active crypto pair display with real data from WebSocket
        const activeItem = document.querySelector(`[data-symbol="${symbol}"]`);
        if (activeItem) {
            // Get real-time data from WebSocket if available
            const realTimeData = getRealTimeSymbolData(symbol);
            
            if (realTimeData) {
                // Update price display with real data
                const priceElement = activeItem.querySelector('.text-2xl');
                if (priceElement) {
                    priceElement.textContent = '$' + formatPrice(realTimeData.price);
                }
                
                // Update change display with real data
                const changeElement = activeItem.querySelector('.text-sm .change-value');
                if (changeElement) {
                    const changeText = `${realTimeData.change >= 0 ? '+' : ''}${realTimeData.change.toFixed(4)}%`;
                    changeElement.textContent = changeText;
                    
                    // Update colors
                    if (realTimeData.change >= 0) {
                        changeElement.classList.remove('text-red-400');
                        changeElement.classList.add('text-cyan-400');
                    } else {
                        changeElement.classList.remove('text-cyan-400');
                        changeElement.classList.add('text-red-400');
                    }
                }
            }
        }
    }
    
    function getRealTimeSymbolData(symbol) {
        // Try to get data from WebSocket connection
        if (window.symbolRealTimeData && window.symbolRealTimeData[symbol]) {
            return window.symbolRealTimeData[symbol];
        }
        
        // Fallback to DOM data
        const priceElement = document.getElementById(`trend-price-${symbol}`);
        const changeElement = document.getElementById(`trend-change-${symbol}`);
        
        if (priceElement && changeElement) {
            const price = parseFloat(priceElement.textContent.replace(/[^0-9.-]+/g, ''));
            const change = parseFloat(changeElement.querySelector('.change-value').textContent.replace(/[^0-9.-]+/g, ''));
            
            return { price, change };
        }
        
        return null;
    }
    
    function updateChartOverlay(symbol, timeRange) {
        // Update 24h change display on chart with real data
        const currentChangeElement = document.getElementById('current-change');
        
        if (currentChangeElement) {
            // Get real-time data
            const realTimeData = getRealTimeSymbolData(symbol);
            
            if (realTimeData) {
                // Update change with real data
                const changeText = `${realTimeData.change >= 0 ? '+' : ''}${realTimeData.change.toFixed(4)}%`;
                currentChangeElement.textContent = changeText;
                
                // Update colors
                if (realTimeData.change >= 0) {
                    currentChangeElement.classList.remove('text-red-400');
                    currentChangeElement.classList.add('text-cyan-400');
                } else {
                    currentChangeElement.classList.remove('text-cyan-400');
                    currentChangeElement.classList.add('text-red-400');
                }
            } else {
                // Fallback to current display data
                const changeElement = document.getElementById(`trend-change-${symbol}`);
                
                if (changeElement) {
                    currentChangeElement.textContent = changeElement.querySelector('.change-value').textContent;
                    
                    const changeValue = parseFloat(changeElement.querySelector('.change-value').textContent.replace(/[^0-9.-]+/g, ''));
                    if (changeValue >= 0) {
                        currentChangeElement.classList.remove('text-red-400');
                        currentChangeElement.classList.add('text-cyan-400');
                    } else {
                        currentChangeElement.classList.remove('text-cyan-400');
                        currentChangeElement.classList.add('text-red-400');
                    }
                }
            }
        }
    }
    

    
    $(document).ready(function() {
        console.log('Document ready, initializing components...');
        
        // Initialize Copy Trading Swiper
        const copyTradingSwiper = new Swiper('.copy-trading-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            grabCursor: true,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });

        // Initialize Trend Analysis Chart
        console.log('Initializing trend chart...');
        initTrendChart();
        
        // Initialize charts and connect to WebSocket
        initCharts();
        connectWebSocket();
        
        // Initialize price ticker with real data
        initializeTickerData();
        
        // Process ticker updates every 100ms for smooth animations
        setInterval(processTickerUpdates, 100);
        
        // Initialize real-time data storage
        window.symbolRealTimeData = {};
        
        console.log('All components initialized');
        
        // Debug: Check chart status after a short delay
        setTimeout(() => {
            console.log('Chart status check:');
            console.log('- Trend chart object:', trendChart);
            console.log('- Current symbol:', currentSymbol);
            console.log('- Current time range:', currentTimeRange);
            console.log('- Chart data:', window.trendChartData);
            
            if (trendChart) {
                console.log('- Chart data length:', trendChart.data.datasets[0].data.length);
                console.log('- Chart labels length:', trendChart.data.labels.length);
                
                // Force refresh if chart is empty
                if (trendChart.data.datasets[0].data.length === 0) {
                    console.log('Chart is empty, forcing refresh...');
                    loadTrendChartData(currentSymbol, currentTimeRange);
                }
            } else {
                console.error('Trend chart not initialized!');
            }
        }, 2000);
    });
    
    // Update trend chart from WebSocket data
    function updateTrendChartFromWebSocket(webSocketData) {
        const { symbol, price, priceChange } = webSocketData;
        
        // Store real-time data
        if (!window.symbolRealTimeData[symbol]) {
            window.symbolRealTimeData[symbol] = {};
        }
        
        window.symbolRealTimeData[symbol] = {
            price: parseFloat(price),
            change: parseFloat(priceChange || 0),
            timestamp: Date.now()
        };
        
        // Update trend chart if this symbol is currently selected
        if (currentSymbol === symbol && trendChart) {
            // Add new data point to chart
            addDataPointToChart(symbol, price, currentTimeRange);
            
            // Update overlay information
            updateChartOverlay(symbol, currentTimeRange);
        }
        
        // Update crypto pair display
        updateCryptoPairDisplay(symbol);
    }
    
    // Connect to Binance WebSocket for real-time price updates
    function connectBinanceWebSocket() {
        try {
            // Close existing WebSocket connection if any
            if (window.binanceWebSocket) {
                console.log('Closing existing Binance WebSocket connection');
                window.binanceWebSocket.close();
                window.binanceWebSocket = null;
            }
            
            // Get current active symbol
            const activeSymbol = document.querySelector('.crypto-pair-item.active');
            if (!activeSymbol) return;
            
            const symbol = activeSymbol.getAttribute('data-symbol');
            const binanceSymbol = symbol.replace('/', '').toLowerCase();
            
            // Binance WebSocket endpoint for kline data
            const wsUrl = `wss://stream.binance.com:9443/ws/${binanceSymbol}@kline_1m`;
            
            console.log(`Connecting to Binance WebSocket: ${wsUrl}`);
            
            // Create WebSocket connection
            const binanceWs = new WebSocket(wsUrl);
            
            binanceWs.onopen = () => {
                console.log(`Connected to Binance WebSocket for ${symbol}`);
            };
            
            binanceWs.onmessage = (event) => {
                try {
                    const data = JSON.parse(event.data);
                    
                    if (data.e === 'kline') {
                        const kline = data.k;
                        const { s: symbolName, c: closePrice, o: openPrice, h: highPrice, l: lowPrice, v: volume, t: openTime } = kline;
                        
                        // Update real-time data
                        const price = parseFloat(closePrice);
                        const priceChange = ((price - parseFloat(openPrice)) / parseFloat(openPrice)) * 100;
                        
                        // Update trend chart with real-time data
                        if (currentSymbol === symbol && trendChart) {
                            addDataPointToChart(symbol, price, currentTimeRange);
                            updateChartOverlay(symbol, currentTimeRange);
                        }
                        
                        // Update crypto pair display
                        updateCryptoPairDisplay(symbol);
                        
                        console.log(`Real-time update for ${symbol}: $${price} (${priceChange.toFixed(4)}%)`);
                    }
                } catch (error) {
                    console.error('Error parsing Binance WebSocket message:', error);
                }
            };
            
            binanceWs.onerror = (error) => {
                console.error('Binance WebSocket error:', error);
            };
            
            binanceWs.onclose = () => {
                console.log('Binance WebSocket connection closed');
                // Reconnect after 5 seconds
                setTimeout(connectBinanceWebSocket, 5000);
            };
            
            // Store WebSocket reference
            window.binanceWebSocket = binanceWs;
            
        } catch (error) {
            console.error('Failed to connect to Binance WebSocket:', error);
        }
    }
    
    // Add new data point to trend chart
    function addDataPointToChart(symbol, price, timeRange) {
        if (!trendChart || !window.trendChartData[symbol] || !window.trendChartData[symbol][timeRange]) {
            return;
        }
        
        const data = window.trendChartData[symbol][timeRange];
        const labels = window.trendChartLabels[symbol][timeRange];
        
        // Add new data point
        data.push(parseFloat(price));
        labels.push(new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }));
        
        // Keep only the last N points based on time range
        const maxPoints = getDataPointsForTimeRange(timeRange);
        if (data.length > maxPoints) {
            data.shift();
            labels.shift();
        }
        
        // Update chart
        trendChart.data.labels = labels;
        trendChart.data.datasets[0].data = data;
        trendChart.update('none');
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Banner Swiper
    const bannerSwiper = new Swiper('.banner-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });
});
</script>
@endsection