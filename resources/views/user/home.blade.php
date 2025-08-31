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
    
    /* Table Realtime Styles */
    .price-change-indicator {
        transition: all 0.3s ease;
    }
    
    .price-change-indicator.price-up {
        background-color: #10b981;
        opacity: 1;
        animation: pulse-green 1s ease-in-out;
    }
    
    .price-change-indicator.price-down {
        background-color: #ef4444;
        opacity: 1;
        animation: pulse-red 1s ease-in-out;
    }
    
    .change-arrow.price-up::before {
        content: "▲";
        color: #10b981;
        opacity: 1;
    }
    
    .change-arrow.price-down::before {
        content: "▼";
        color: #ef4444;
        opacity: 1;
    }
    
    @keyframes pulse-green {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.7; }
    }
    
    @keyframes pulse-red {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.7; }
    }
    
    .price-display, .change-display {
        transition: all 0.3s ease;
    }
    
    .price-display.price-up {
        color: #10b981;
        transform: scale(1.05);
    }
    
    .price-display.price-down {
        color: #ef4444;
        transform: scale(1.05);
    }
    
    .change-display.price-up {
        color: #10b981;
    }
    
    .change-display.price-down {
        color: #ef4444;
    }
    
    /* Chart loading animation */
    .chart-loading.show {
        opacity: 1;
    }
    
    /* Mini Chart Styles - Matching the image exactly */
    .chart-container {
        border-radius: 8px;
        padding: 4px;
        position: relative;
        overflow: hidden;
        width: 60px;
        height: 24px;
    }
    
    .chart-container canvas {
        border-radius: 6px;
        background: transparent;
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Mini chart specific styling for table */
    #coins-table .chart-container {
        /* background: #0f172a !important; */
        border: none !important;
        box-shadow: none !important;
        margin: 0 auto;
    }
    
    #coins-table .chart-container canvas {
        /* background: #0f172a !important; */
        border: none !important;
        box-shadow: none !important;
        display: block !important;
    }
    
    /* Ensure chart colors are visible */
    #coins-table .chart-container canvas {
        filter: none !important;
        -webkit-filter: none !important;
    }
    
    /* Chart color indicators */
    .chart-green {
        border-color: #10b981 !important;
    }
    
    .chart-red {
        border-color: #ef4444 !important;
    }
    
    .chart-gray {
        border-color: #6b7280 !important;
    }
    
    /* Ensure chart fits perfectly in table cell */
    #coins-table td:last-child {
        padding: 0.75rem !important;
        text-align: center !important;
    }
    
    /* Table row hover effects */
    #coins-table tbody tr:hover {
        background: rgba(6, 182, 212, 0.1) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(6, 182, 212, 0.2);
    }
    
    #coins-table tbody tr {
        transition: all 0.3s ease;
    }
    
    /* Responsive table improvements */
    @media (max-width: 768px) {
        #coins-table th,
        #coins-table td {
            padding: 0.75rem 0.5rem;
        }
        
        #coins-table th {
            font-size: 0.875rem;
        }
        
        .price-value .text-xl {
            font-size: 1rem;
        }
        
        .change-value .text-lg {
            font-size: 0.875rem;
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
            padding: 1rem;
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
<div class="price-ticker py-4 overflow-hidden mt-10">
    <div class="ticker-container">
        <div class="ticker-track flex animate-marquee whitespace-nowrap" id="price-ticker-track">
            <!-- Loading state -->
            <div class="ticker-item flex items-center space-x-3 text-gray-400" id="ticker-loading">
                <span class="text-gray-400">Loading...</span>
            </div>
        </div>
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
                        <tr class="border-b border-cyan-500/10 hover:bg-cyan-500/5 transition-colors duration-300" id="row-{{$symbol->symbol}}" data-symbol="{{$symbol->symbol}}">
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
                                <div class="price-value text-xl font-bold relative" id="price-{{$symbol->symbol}}">
                                    <span class="price-display">--</span>
                                    <div class="price-change-indicator absolute -top-1 -right-1 w-2 h-2 rounded-full opacity-0 transition-all duration-300"></div>
                                </div>
                            </td>
                            <td class="text-center p-6">
                                <div class="change-value text-lg font-semibold relative" id="change-{{$symbol->symbol}}">
                                    <span class="change-display">--</span>
                                    <div class="change-arrow text-xs ml-1 opacity-0 transition-opacity duration-300"></div>
                                </div>
                            </td>
                            <td class="text-center p-6 xs:hidden md:table-cell">
                                <div class="volume-value text-lg" id="volume-{{$symbol->symbol}}">--</div>
                            </td>
                            <td class="text-center p-6 xs:hidden md:table-cell">
                                <div class="chart-container relative">
                                    <canvas id="chart-{{$symbol->symbol}}" width="60" height="24" class="rounded-xl shadow"></canvas>
                                    <div class="chart-loading absolute inset-0 flex items-center justify-center bg-gray-800/50 rounded-xl opacity-0 transition-opacity duration-300">
                                        <div class="w-4 h-4 border-2 border-cyan-400 border-t-transparent rounded-full animate-spin"></div>
                                    </div>
                                </div>
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
        <div class="relative mb-8">
            <!-- Navigation Buttons -->
            <button id="crypto-prev-btn" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-20 w-10 h-10 bg-black/60 hover:bg-black/80 text-white rounded-full flex items-center justify-center transition-all duration-300 shadow-lg backdrop-blur-sm border border-gray-600/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <button id="crypto-next-btn" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-20 w-10 h-10 bg-black/60 hover:bg-black/80 text-white rounded-full flex items-center justify-center transition-all duration-300 shadow-lg backdrop-blur-sm border border-gray-600/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <!-- Scrollable Container -->
            <div class="overflow-x-auto scrollbar-hide" style="position: relative; cursor: grab; max-width: 100%;" id="crypto-scroll-container">
                <div class="flex flex-nowrap gap-2 md:gap-4 px-12" id="crypto-pairs-container" style="min-width: max-content; scroll-behavior: smooth; user-select: none;">
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
        <div class="flex justify-center my-8">
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

    // Legacy WebSocket connection (kept for compatibility)
    function connectWebSocket() {
        console.log('🔌 Connecting to legacy WebSocket server...');
        const wsUrl = `{{env('WEBSOCKET_URL')}}?symbols=${JSON.stringify(symbols)}`;
        
        try {
            ws = new WebSocket(wsUrl);

            ws.onopen = () => {
                console.log('✅ Connected to legacy WebSocket server');
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
                    console.error('❌ Error parsing legacy WebSocket message:', error);
                }
            };

            ws.onerror = (error) => {
                console.error('❌ Legacy WebSocket error:', error);
                updateConnectionStatus('error');
                // Fallback to polling if WebSocket fails
                startPollingFallback();
            };

            ws.onclose = () => {
                console.log('🔌 Legacy WebSocket connection closed. Reconnecting...');
                updateConnectionStatus('reconnecting');
                setTimeout(connectWebSocket, 3000);
            };
        } catch (error) {
            console.error('❌ Legacy WebSocket connection failed:', error);
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

        // Update table row with realtime data
        updateTableRowRealtime(symbol, price, priceChange, volume);
        
        // Only update chart if it's already initialized, using safe update
        if (charts[symbol] && charts[symbol].isInitialized) {
            safeChartUpdate(symbol, price);
        } else {
            console.log(`⏳ Chart for ${symbol} not yet initialized, skipping chart update in updateMarketData`);
        }
    }
    
    // Enhanced realtime table update function
    function updateTableRowRealtime(symbol, price, priceChange, volume) {
        try {
            // Always ensure table gets updated first (this is critical for realtime)
            const tableUpdated = ensureTableRealtimeUpdates(symbol, price, priceChange, volume);
            
            if (!tableUpdated) {
                console.error(`❌ Failed to update table for ${symbol}`);
                return;
            }
            
            // Now try to update chart (this is secondary and can fail)
            if (charts[symbol]) {
                // Check if we should protect API data
                if (protectApiData(symbol)) {
                    console.log(`🔒 API data protected for ${symbol}, only adding new data point`);
                    // Only add new data point, don't reinitialize
                    if (priceHistory[symbol] && priceHistory[symbol].length > 0) {
                        const lastPrice = priceHistory[symbol][priceHistory[symbol].length - 1];
                        if (lastPrice !== price) {
                            priceHistory[symbol].push(price);
                            if (priceHistory[symbol].length > 30) {
                                priceHistory[symbol].shift();
                            }
                            charts[symbol].data.datasets[0].data = priceHistory[symbol];
                            charts[symbol].update('none');
                            console.log(`📊 Added new data point for ${symbol}: $${price}`);
                        }
                    }
                } else if (charts[symbol].isInitialized) {
                    updateMiniChartWith24hChange(symbol, price, priceChange);
                } else {
                    // Try to initialize chart if not yet initialized
                    console.log(`🔄 Attempting to initialize chart for ${symbol} with real-time data`);
                    initializeChartWithRealData(symbol, price, priceChange);
                }
            } else {
                console.log(`⚠️ Chart for ${symbol} not found, skipping chart update`);
            }
            
        } catch (error) {
            console.error(`❌ Error in updateTableRowRealtime for ${symbol}:`, error);
            
            // Even if chart update fails, ensure table gets updated
            ensureTableRealtimeUpdates(symbol, price, priceChange, volume);
        }
    }
    
    // Update mini chart in table with dynamic colors based on price trend
    function updateMiniChart(symbol, price) {
        if (!charts[symbol]) return;
        
        try {
            // Check if chart is already initialized
            if (!charts[symbol].isInitialized) {
                console.log(`🔄 Chart for ${symbol} not initialized, attempting to initialize with current data`);
                
                // Try to get current data from symbolRealTimeData
                if (window.symbolRealTimeData && window.symbolRealTimeData[symbol]) {
                    const data = window.symbolRealTimeData[symbol];
                    initializeChartWithRealData(symbol, data.price, data.change);
                    return;
                } else {
                    console.log(`⚠️ No data available for ${symbol}, skipping chart update`);
                    return;
                }
            }
            
            // Add new price to history
            if (!priceHistory[symbol]) {
                priceHistory[symbol] = [];
            }
            
            // Add new price point
            priceHistory[symbol].push(price);
            
            // Keep only last 30 points for mini chart
            if (priceHistory[symbol].length > 30) {
                priceHistory[symbol].shift();
            }
            
            // Update chart data with new point
            charts[symbol].data.datasets[0].data = priceHistory[symbol];
            
            // Update chart smoothly without full re-render
            charts[symbol].update('none');
            
            console.log(`📊 Added new data point for ${symbol}: $${price} (Total: ${priceHistory[symbol].length} points)`);
            
        } catch (error) {
            console.error(`❌ Error updating mini chart for ${symbol}:`, error);
        }
    }
    
    // Update mini chart with color based on 24h price change
    function updateMiniChartWith24hChange(symbol, price, priceChange) {
        if (!charts[symbol]) return;
        
        try {
            // Check if chart is already initialized
            if (!charts[symbol].isInitialized) {
                console.log(`🔄 Chart for ${symbol} not initialized, attempting to initialize with current data`);
                
                // Try to get current data from symbolRealTimeData
                if (window.symbolRealTimeData && window.symbolRealTimeData[symbol]) {
                    const data = window.symbolRealTimeData[symbol];
                    initializeChartWithRealData(symbol, data.price, data.change);
                    return;
                } else {
                    console.log(`⚠️ No data available for ${symbol}, skipping chart update`);
                    return;
                }
            }
            
            // First update the chart data
            updateMiniChart(symbol, price);
            
            // Determine color based on 24h price change
            let chartColor;
            if (priceChange > 0) {
                chartColor = '#10b981'; // Green for price increase
            } else if (priceChange < 0) {
                chartColor = '#ef4444'; // Red for price decrease
            } else {
                chartColor = '#6b7280'; // Gray for no change
            }
            
            // Update chart color and ensure it's applied
            charts[symbol].data.datasets[0].borderColor = chartColor;
            
            // Force chart update to apply color change
            charts[symbol].update('none');
            
            // Log color change for debugging
            console.log(`🎨 Chart color updated for ${symbol}: ${chartColor} (${priceChange >= 0 ? '+' : ''}${priceChange}%)`);
            
        } catch (error) {
            console.error(`❌ Error updating mini chart color for ${symbol}:`, error);
        }
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

    // Legacy chart update function (kept for compatibility)
    function updateChart(symbol, price) {
        // Skip if chart is not initialized yet
        if (!charts[symbol] || !charts[symbol].isInitialized) {
            console.log(`⏳ Chart for ${symbol} not yet initialized, skipping legacy update`);
            return;
        }

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
                // Initialize price history with some sample data
                priceHistory[symbol] = generateSamplePriceData(30);
                
                charts[symbol] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Array(30).fill(''),
                        datasets: [{
                            data: priceHistory[symbol],
                            borderColor: '#10b981', // Default green color
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointRadius: 0,
                            tension: 0.4,
                            fill: false,
                            pointHoverRadius: 0,
                            pointHoverBackgroundColor: 'transparent',
                            pointHoverBorderColor: 'transparent'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0, // No animation for mini charts
                            easing: 'linear'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false // No tooltip for mini charts
                            }
                        },
                        scales: {
                            x: {
                                display: false,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                display: false,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest'
                        },
                        elements: {
                            point: {
                                radius: 0,
                                hoverRadius: 0
                            },
                            line: {
                                borderWidth: 2,
                                tension: 0.4
                            }
                        },
                        layout: {
                            padding: 0
                        }
                    }
                });
                
                // Add hover effects
                ctx.addEventListener('mouseenter', () => {
                    ctx.style.cursor = 'pointer';
                });
                
                ctx.addEventListener('mouseleave', () => {
                    ctx.style.cursor = 'default';
                });
                
                // Mark chart as not yet initialized
                charts[symbol].isInitialized = false;
                charts[symbol].hasApiData = false;
                charts[symbol].apiDataTimestamp = null;
            }
        });
    }
    
    // Generate sample price data for charts - matching the image trend
    function generateSamplePriceData(points) {
        const data = [];
        let price = 45000 + Math.random() * 5000; // Start around $45k-50k
        
        for (let i = 0; i < points; i++) {
            // Create a downward trend with some volatility like in the image
            let change;
            
            if (i < points * 0.3) {
                // First 30%: Some initial volatility
                change = (Math.random() - 0.5) * 0.015 * price;
            } else if (i < points * 0.7) {
                // Middle 40%: Strong downward trend
                change = -0.008 * price + (Math.random() - 0.5) * 0.01 * price;
            } else {
                // Last 30%: Moderate recovery
                change = 0.005 * price + (Math.random() - 0.5) * 0.008 * price;
            }
            
            price += change;
            price = Math.max(price, 35000); // Don't go below $35k
            
            data.push(parseFloat(price.toFixed(2)));
        }
        
        return data;
    }
    
    // Initialize chart with real data from Binance API
    function initializeChartWithRealData(symbol, currentPrice, priceChange) {
        if (!charts[symbol]) return;
        
        try {
            // Check if chart is already initialized with API data
            if (charts[symbol].isInitialized && charts[symbol].hasApiData) {
                console.log(`✅ Chart for ${symbol} already initialized with API data, skipping reinitialization`);
                return;
            }
            
            console.log(`🔄 Initializing chart for ${symbol} with real data: $${currentPrice} (${priceChange}%)`);
            
            // Generate realistic price history based on current price and change
            const priceHistoryData = generateRealisticPriceHistory(currentPrice, priceChange, 30);
            
            // Update chart data
            charts[symbol].data.datasets[0].data = priceHistoryData;
            
            // Set initial color based on price change
            let chartColor;
            if (priceChange > 0) {
                chartColor = '#10b981'; // Green for price increase
            } else if (priceChange < 0) {
                chartColor = '#ef4444'; // Red for price decrease
            } else {
                chartColor = '#6b7280'; // Gray for no change
            }
            
            charts[symbol].data.datasets[0].borderColor = chartColor;
            
            // Update chart
            charts[symbol].update('none');
            
            // Store price history for future updates
            priceHistory[symbol] = priceHistoryData;
            
            // Mark chart as initialized with API data
            charts[symbol].isInitialized = true;
            charts[symbol].hasApiData = true;
            charts[symbol].apiDataTimestamp = Date.now();
            
            console.log(`✅ Chart initialized for ${symbol} with ${priceHistoryData.length} data points from API`);
            
        } catch (error) {
            console.error(`❌ Error initializing chart for ${symbol}:`, error);
        }
    }
    
    // Generate realistic price history based on current price and 24h change
    function generateRealisticPriceHistory(currentPrice, priceChange, points) {
        const data = [];
        let price = currentPrice;
        
        // Calculate the starting price based on 24h change
        const totalChange = priceChange / 100; // Convert percentage to decimal
        const startingPrice = currentPrice / (1 + totalChange); // Reverse calculate starting price
        
        // Generate data points going backwards in time
        for (let i = points - 1; i >= 0; i--) {
            // Add realistic volatility
            const volatility = 0.002; // 0.2% volatility per point
            const randomChange = (Math.random() - 0.5) * volatility * price;
            
            // Add trend component (gradual change over time)
            const trendComponent = (totalChange / points) * price * (points - i) / points;
            
            // Calculate price for this point
            price = startingPrice + trendComponent + randomChange;
            
            // Ensure price doesn't go negative
            price = Math.max(price, currentPrice * 0.1);
            
            data.push(parseFloat(price.toFixed(6)));
        }
        
        // Reverse to show correct time progression
        return data.reverse();
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
        
        /* Crypto scroll container styles */
        #crypto-scroll-container {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
            scroll-behavior: smooth;
        }
        
        #crypto-scroll-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        #crypto-scroll-container.dragging {
            cursor: grabbing !important;
            user-select: none;
        }
        
        #crypto-scroll-container.dragging * {
            pointer-events: none;
        }
        
        /* Navigation buttons */
        #crypto-prev-btn,
        #crypto-next-btn {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        #crypto-prev-btn:hover,
        #crypto-next-btn:hover {
            transform: scale(1.1);
            background: rgba(0, 0, 0, 0.8) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        #crypto-prev-btn:active,
        #crypto-next-btn:active {
            transform: scale(0.95);
        }
        
        /* Disabled state for buttons */
        #crypto-prev-btn[style*="opacity: 0.3"],
        #crypto-next-btn[style*="opacity: 0.3"] {
            cursor: not-allowed;
        }
        
        /* Crypto pair items hover effect */
        .crypto-pair-item {
            transition: all 0.3s ease;
        }
        
        .crypto-pair-item:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        /* Smooth scroll animation */
        .crypto-pairs-container {
            transition: scroll-left 0.3s ease;
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

    // Initialize drag and scroll functionality for crypto pairs
    function initializeCryptoScroll() {
        const container = document.getElementById('crypto-scroll-container');
        const content = document.getElementById('crypto-pairs-container');
        
        if (!container || !content) return;
        
        let isDragging = false;
        let startX = 0;
        let scrollLeft = 0;
        let dragStartTime = 0;
        
        // Mouse events
        container.addEventListener('mousedown', (e) => {
            // Don't start dragging if clicking on buttons
            if (e.target.closest('#crypto-prev-btn, #crypto-next-btn')) return;
            
            isDragging = true;
            dragStartTime = Date.now();
            container.classList.add('dragging');
            container.style.cursor = 'grabbing';
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
            
            // Prevent text selection
            e.preventDefault();
        });
        
        container.addEventListener('mouseleave', () => {
            if (isDragging) {
                isDragging = false;
                container.classList.remove('dragging');
                container.style.cursor = 'grab';
            }
        });
        
        container.addEventListener('mouseup', (e) => {
            if (isDragging) {
                isDragging = false;
                container.classList.remove('dragging');
                container.style.cursor = 'grab';
                
                // Check if it was a quick click (not drag)
                const dragDuration = Date.now() - dragStartTime;
                if (dragDuration < 200) {
                    // It was a click, not a drag
                    console.log('Quick click detected, not dragging');
                }
            }
        });
        
        container.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 1.5; // Smooth scroll speed
            container.scrollLeft = scrollLeft - walk;
        });
        
        // Touch events for mobile
        let touchStartX = 0;
        let touchScrollLeft = 0;
        let touchStartTime = 0;
        
        container.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].pageX - container.offsetLeft;
            touchScrollLeft = container.scrollLeft;
            touchStartTime = Date.now();
        });
        
        container.addEventListener('touchmove', (e) => {
            if (!touchStartX) return;
            
            e.preventDefault();
            const x = e.touches[0].pageX - container.offsetLeft;
            const walk = (x - touchStartX) * 1.5;
            container.scrollLeft = touchScrollLeft - walk;
        });
        
        container.addEventListener('touchend', (e) => {
            const touchDuration = Date.now() - touchStartTime;
            if (touchDuration < 200) {
                // Quick touch, might be a tap
                console.log('Quick touch detected');
            }
            touchStartX = 0;
        });
        
        // Add scroll indicators
        addScrollIndicators();
        
        // Add smooth scroll behavior
        container.style.scrollBehavior = 'smooth';
        
        console.log('✅ Enhanced crypto scroll functionality initialized');
    }
    
    // Add scroll indicators (left/right arrows)
    function addScrollIndicators() {
        const container = document.getElementById('crypto-scroll-container');
        const prevBtn = document.getElementById('crypto-prev-btn');
        const nextBtn = document.getElementById('crypto-next-btn');
        
        if (!container || !prevBtn || !nextBtn) return;
        
        // Previous button click
        prevBtn.addEventListener('click', () => {
            container.scrollBy({ left: -300, behavior: 'smooth' });
        });
        
        // Next button click
        nextBtn.addEventListener('click', () => {
            container.scrollBy({ left: 300, behavior: 'smooth' });
        });
        
        // Show/hide buttons based on scroll position
        const updateButtonVisibility = () => {
            const scrollLeft = container.scrollLeft;
            const maxScrollLeft = container.scrollWidth - container.clientWidth;
            
            // Show/hide prev button
            if (scrollLeft > 0) {
                prevBtn.style.opacity = '1';
                prevBtn.style.pointerEvents = 'auto';
            } else {
                prevBtn.style.opacity = '0.3';
                prevBtn.style.pointerEvents = 'none';
            }
            
            // Show/hide next button
            if (scrollLeft < maxScrollLeft - 1) {
                nextBtn.style.opacity = '1';
                nextBtn.style.pointerEvents = 'auto';
            } else {
                nextBtn.style.opacity = '0.3';
                nextBtn.style.pointerEvents = 'none';
            }
        };
        
        // Listen for scroll events
        container.addEventListener('scroll', updateButtonVisibility);
        
        // Initial check
        setTimeout(updateButtonVisibility, 100);
        
        // Add keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevBtn.click();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextBtn.click();
            }
        });
        
        console.log('✅ Scroll indicators initialized with next/prev buttons');
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
            
            // Initialize table with real data
            initializeTableData();
            
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
            initializeTableData();
        }
    }
    
    // Initialize table with real data from Binance API
    async function initializeTableData() {
        console.log('Initializing table with real data from Binance API...');
        
        // Get all symbols from table
        const tableRows = document.querySelectorAll('#coins-table tbody tr');
        const symbolsToFetch = [];
        
        // Collect all symbols first
        tableRows.forEach(row => {
            const symbol = row.getAttribute('data-symbol');
            if (symbol) {
                symbolsToFetch.push(symbol);
            }
        });
        
        console.log(`Found ${symbolsToFetch.length} symbols to fetch data for`);
        
        // Fetch data for all symbols in parallel with rate limiting
        const batchSize = 5; // Process 5 symbols at a time to avoid rate limiting
        const delay = 200; // 200ms delay between batches
        
        for (let i = 0; i < symbolsToFetch.length; i += batchSize) {
            const batch = symbolsToFetch.slice(i, i + batchSize);
            
            // Process batch in parallel
            const batchPromises = batch.map(async (symbol) => {
                try {
                    const binanceSymbol = symbol.replace('/', '');
                    const apiUrl = `https://api.binance.com/api/v3/ticker/24hr?symbol=${binanceSymbol}`;
                    
                    console.log(`Fetching data for ${symbol} from: ${apiUrl}`);
                    
                    const response = await fetch(apiUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'User-Agent': 'Mozilla/5.0 (compatible; CryptoApp/1.0)'
                        },
                        timeout: 10000
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        
                        // Validate data
                        if (data.lastPrice && data.priceChangePercent && data.volume) {
                            const price = parseFloat(data.lastPrice);
                            const priceChange = parseFloat(data.priceChangePercent);
                            const volume = parseFloat(data.volume);
                            
                            // Update table row with real data
                            updateTableRowRealtime(symbol, price, priceChange, volume);
                            
                            // Store data for future updates
                            if (!window.symbolRealTimeData) {
                                window.symbolRealTimeData = {};
                            }
                            window.symbolRealTimeData[symbol] = {
                                price: price,
                                change: priceChange,
                                volume: volume,
                                timestamp: Date.now(),
                                lastApiUpdate: Date.now()
                            };
                            
                            console.log(`✅ Successfully updated ${symbol}: $${price} (${priceChange}%)`);
                            
                            // Initialize chart with real data
                            initializeChartWithRealData(symbol, price, priceChange);
                            
                        } else {
                            console.warn(`⚠️ Invalid data received for ${symbol}:`, data);
                        }
                    } else {
                        console.warn(`⚠️ API error for ${symbol}: ${response.status} - ${response.statusText}`);
                    }
                } catch (error) {
                    console.error(`❌ Error fetching data for ${symbol}:`, error);
                }
            });
            
            // Wait for batch to complete
            await Promise.all(batchPromises);
            
            // Delay before next batch to avoid rate limiting
            if (i + batchSize < symbolsToFetch.length) {
                console.log(`Waiting ${delay}ms before next batch...`);
                await new Promise(resolve => setTimeout(resolve, delay));
            }
        }
        
        console.log('✅ Table initialization completed with Binance API data');
        
        // Check initialization status
        checkChartsInitializationStatus();
        
        // After API initialization, start WebSocket connection
        setTimeout(() => {
            console.log('🚀 Starting WebSocket connection for real-time updates...');
            startWebSocketUpdates();
        }, 1000);
    }
    
    // Check and log charts initialization status
    function checkChartsInitializationStatus() {
        console.log('📊 Checking charts initialization status...');
        
        let initializedCount = 0;
        let totalCount = 0;
        
        Object.keys(charts).forEach(symbol => {
            totalCount++;
            if (charts[symbol].isInitialized) {
                initializedCount++;
                console.log(`✅ ${symbol}: Initialized`);
            } else {
                console.log(`⏳ ${symbol}: Not yet initialized`);
            }
        });
        
        console.log(`📈 Charts initialization summary: ${initializedCount}/${totalCount} initialized`);
        
        if (initializedCount === totalCount) {
            console.log('🎉 All charts are ready for real-time updates!');
        } else {
            console.log('⏳ Some charts still initializing, real-time updates will be delayed...');
        }
    }
    
    // Log detailed chart status for debugging
    function logChartStatus() {
        console.log('📊 Detailed Chart Status:');
        
        Object.keys(charts).forEach(symbol => {
            const chart = charts[symbol];
            if (chart) {
                const dataLength = chart.data.datasets[0].data.length;
                const hasData = dataLength > 0 && chart.data.datasets[0].data.some(price => price > 0);
                const priceHistoryLength = priceHistory[symbol] ? priceHistory[symbol].length : 0;
                const hasApiData = chart.hasApiData || false;
                const apiDataAge = chart.apiDataTimestamp ? Math.round((Date.now() - chart.apiDataTimestamp) / 1000) : 'N/A';
                
                console.log(`- ${symbol}: Initialized=${chart.isInitialized}, API Data=${hasApiData}, API Age=${apiDataAge}s, Chart Data=${dataLength}, Price History=${priceHistoryLength}, Has Valid Data=${hasData}`);
                
                if (chart.isInitialized && !hasData) {
                    console.warn(`⚠️ WARNING: ${symbol} is initialized but has no valid data!`);
                }
                
                if (chart.hasApiData && chart.apiDataTimestamp) {
                    console.log(`  📡 API data timestamp: ${new Date(chart.apiDataTimestamp).toLocaleTimeString()}`);
                }
            }
        });
    }
    
    // Force initialize chart if needed (for fallback scenarios)
    function forceInitializeChart(symbol, price, priceChange) {
        if (!charts[symbol]) {
            console.warn(`⚠️ Chart for ${symbol} not found, cannot force initialize`);
            return;
        }
        
        if (charts[symbol].isInitialized) {
            console.log(`✅ Chart for ${symbol} already initialized, skipping`);
            return;
        }
        
        console.log(`🔄 Force initializing chart for ${symbol} with fallback data`);
        initializeChartWithRealData(symbol, price, priceChange);
    }
    
    // Recover chart data if it was lost
    function recoverChartData(symbol) {
        if (!charts[symbol] || !charts[symbol].isInitialized) {
            console.log(`⏳ Chart for ${symbol} not initialized, cannot recover`);
            return false;
        }
        
        // Check if chart data is missing or corrupted
        const chartData = charts[symbol].data.datasets[0].data;
        const hasValidData = chartData && chartData.length > 0 && chartData.some(price => price > 0);
        
        if (!hasValidData && priceHistory[symbol] && priceHistory[symbol].length > 0) {
            console.log(`🔄 Recovering chart data for ${symbol} from price history`);
            charts[symbol].data.datasets[0].data = priceHistory[symbol];
            charts[symbol].update('none');
            return true;
        }
        
        return false;
    }
    
    // Enhanced protection for chart data
    function enhancedProtectChartData(symbol) {
        if (!charts[symbol] || !charts[symbol].isInitialized) {
            return false;
        }
        
        // Special protection for API data
        if (charts[symbol].hasApiData) {
            console.log(`🔒 Chart for ${symbol} has API data, protecting from reset`);
            
            // Check if API data is still valid (not too old)
            const dataAge = Date.now() - charts[symbol].apiDataTimestamp;
            if (dataAge > 300000) { // 5 minutes
                console.warn(`⚠️ API data for ${symbol} is old (${Math.round(dataAge/1000)}s), allowing refresh`);
                return false;
            }
            
            return true;
        }
        
        // Try to recover data if needed
        if (!recoverChartData(symbol)) {
            // Check if chart has meaningful data
            const chartData = charts[symbol].data.datasets[0].data;
            const hasData = chartData && chartData.length > 0 && chartData.some(price => price > 0);
            
            if (!hasData) {
                console.warn(`⚠️ Chart for ${symbol} has no meaningful data, allowing reset`);
                return false;
            }
        }
        
        return true;
    }
    
    // Protect API data from being overwritten
    function protectApiData(symbol) {
        if (!charts[symbol]) return false;
        
        if (charts[symbol].hasApiData && charts[symbol].isInitialized) {
            const dataAge = Date.now() - charts[symbol].apiDataTimestamp;
            if (dataAge < 300000) { // Less than 5 minutes
                console.log(`🔒 Protecting API data for ${symbol} (age: ${Math.round(dataAge/1000)}s)`);
                return true;
            } else {
                console.log(`⚠️ API data for ${symbol} is old (${Math.round(dataAge/1000)}s), allowing refresh`);
                return false;
            }
        }
        
        return false;
    }
    
    // Ensure table always gets realtime updates regardless of chart status
    function ensureTableRealtimeUpdates(symbol, price, priceChange, volume) {
        try {
            // Always update table data first (this should never fail)
            const row = document.getElementById(`row-${symbol}`);
            if (!row) {
                console.warn(`⚠️ Table row not found for ${symbol}`);
                return false;
            }
            
            // Update price display
            const priceElement = row.querySelector('.price-display');
            if (priceElement) {
                const oldPrice = parseFloat(priceElement.textContent.replace(/[^0-9.-]+/g, ''));
                const newPrice = parseFloat(price);
                
                priceElement.textContent = formatPrice(price);
                
                // Add animation if price changed
                if (oldPrice && oldPrice !== newPrice) {
                    priceElement.classList.remove('price-up', 'price-down');
                    priceElement.classList.add(newPrice > oldPrice ? 'price-up' : 'price-down');
                    setTimeout(() => priceElement.classList.remove('price-up', 'price-down'), 1000);
                }
            }
            
            // Update price change display
            const changeElement = row.querySelector('.change-display');
            if (changeElement) {
                const changeText = `${priceChange >= 0 ? '+' : ''}${priceChange.toFixed(4)}%`;
                changeElement.textContent = changeText;
                
                changeElement.classList.remove('price-up', 'price-down');
                changeElement.classList.add(priceChange >= 0 ? 'price-up' : 'price-down');
            }
            
            // Update volume
            const volumeElement = row.querySelector('.volume-value');
            if (volumeElement) {
                volumeElement.textContent = formatVolume(volume);
            }
            
            // Update price indicator
            const priceIndicator = row.querySelector('.price-change-indicator');
            if (priceIndicator) {
                priceIndicator.classList.remove('price-up', 'price-down');
                priceIndicator.classList.add(priceChange >= 0 ? 'price-up' : 'price-down');
                setTimeout(() => priceIndicator.classList.remove('price-up', 'price-down'), 1000);
            }
            
            // Update change arrow
            const changeArrow = row.querySelector('.change-arrow');
            if (changeArrow) {
                changeArrow.classList.remove('price-up', 'price-down');
                changeArrow.classList.add(priceChange >= 0 ? 'price-up' : 'price-down');
                changeArrow.style.opacity = '1';
                setTimeout(() => changeArrow.style.opacity = '0', 1000);
            }
            
            console.log(`✅ Table updated for ${symbol}: $${price} (${priceChange}%)`);
            return true;
            
        } catch (error) {
            console.error(`❌ Error updating table for ${symbol}:`, error);
            return false;
        }
    }
    
    // Protect chart from being reset
    function protectChartData(symbol) {
        return enhancedProtectChartData(symbol);
    }
    
    // Safe chart update that preserves existing data
    function safeChartUpdate(symbol, price) {
        if (!protectChartData(symbol)) {
            console.log(`⏳ Chart for ${symbol} not protected, allowing update`);
            return updateChart(symbol, price);
        }
        
        // Only add new data point, don't reset
        if (!priceHistory[symbol]) {
            console.warn(`⚠️ Price history for ${symbol} is missing, this should not happen!`);
            return;
        }
        
        // Check if we already have this price to avoid duplicates
        const lastPrice = priceHistory[symbol][priceHistory[symbol].length - 1];
        if (lastPrice === price) {
            console.log(`🔄 Price for ${symbol} unchanged: $${price}, skipping update`);
            return;
        }
        
        // Add new price point
        priceHistory[symbol].push(price);
        
        // Keep only last 30 points
        if (priceHistory[symbol].length > 30) {
            priceHistory[symbol].shift();
        }
        
        // Update chart with new data
        charts[symbol].data.datasets[0].data = priceHistory[symbol];
        charts[symbol].update('none');
        
        console.log(`🔒 Safe update for ${symbol}: Added $${price}, total points: ${priceHistory[symbol].length}`);
    }
    
    // Start WebSocket updates for real-time data
    function startWebSocketUpdates() {
        console.log('🚀 Starting WebSocket updates for real-time data...');
        
        // Initialize WebSocket connection
        initializeWebSocketConnection();
        
        // Set up fallback polling if WebSocket fails
        setupFallbackPolling();
        
        // Also update when WebSocket data is received
        if (window.symbolRealTimeData) {
            Object.keys(window.symbolRealTimeData).forEach(symbol => {
                const data = window.symbolRealTimeData[symbol];
                if (data && data.timestamp && (Date.now() - data.timestamp) < 10000) {
                    // Data is fresh, update table
                    updateTableRowRealtime(symbol, data.price, data.change, data.volume);
                }
            });
        }
    }
    
    // Initialize WebSocket connection for real-time updates
    function initializeWebSocketConnection() {
        try {
            // Log chart status before WebSocket connection
            console.log('📊 Chart status BEFORE WebSocket connection:');
            logChartStatus();
            
            // Get all symbols for WebSocket subscription
            const symbols = Array.from(document.querySelectorAll('#coins-table tbody tr'))
                .map(row => row.getAttribute('data-symbol'))
                .filter(symbol => symbol)
                .map(symbol => symbol.replace('/', '').toLowerCase());
            
            if (symbols.length === 0) {
                console.warn('⚠️ No symbols found for WebSocket connection');
                return;
            }
            
            console.log(`🔌 Connecting WebSocket for ${symbols.length} symbols:`, symbols);
            
            // Create WebSocket connection to Binance
            const wsUrl = `wss://stream.binance.com:9443/ws/!ticker@arr`;
            const ws = new WebSocket(wsUrl);
            
            ws.onopen = () => {
                console.log('✅ WebSocket connected to Binance');
                updateConnectionStatus('connected');
                
                // Log chart status after WebSocket connection
                setTimeout(() => {
                    console.log('📊 Chart status AFTER WebSocket connection:');
                    logChartStatus();
                }, 1000);
            };
            
            ws.onmessage = (event) => {
                try {
                    const data = JSON.parse(event.data);
                    
                    if (Array.isArray(data)) {
                        // Process all ticker data
                        data.forEach(ticker => {
                            const symbol = ticker.s;
                            const price = parseFloat(ticker.c); // Current price
                            const priceChange = parseFloat(ticker.P); // 24h price change %
                            const volume = parseFloat(ticker.v); // 24h volume
                            
                            // Check if this symbol is in our table
                            const tableSymbol = `${symbol.slice(0, -4)}/${symbol.slice(-4)}`; // Convert BTCUSDT to BTC/USDT
                            
                            if (window.symbolRealTimeData && window.symbolRealTimeData[tableSymbol]) {
                                // Update stored data
                                window.symbolRealTimeData[tableSymbol] = {
                                    price: price,
                                    change: priceChange,
                                    volume: volume,
                                    timestamp: Date.now(),
                                    lastWebSocketUpdate: Date.now()
                                };
                                
                                // Update table row (chart update will be handled by updateTableRowRealtime)
                                updateTableRowRealtime(tableSymbol, price, priceChange, volume);
                                
                                // Auto-recover chart data if needed
                                if (charts[tableSymbol] && charts[tableSymbol].isInitialized) {
                                    recoverChartData(tableSymbol);
                                }
                                
                                console.log(`📊 WebSocket update for ${tableSymbol}: $${price} (${priceChange}%)`);
                            }
                        });
                    }
                } catch (error) {
                    console.error('❌ Error parsing WebSocket message:', error);
                }
            };
            
            ws.onerror = (error) => {
                console.error('❌ WebSocket error:', error);
                updateConnectionStatus('error');
            };
            
            ws.onclose = () => {
                console.log('🔌 WebSocket connection closed, attempting to reconnect...');
                updateConnectionStatus('reconnecting');
                
                // Reconnect after 5 seconds
                setTimeout(() => {
                    initializeWebSocketConnection();
                }, 5000);
            };
            
            // Store WebSocket reference
            window.binanceWebSocket = ws;
            
        } catch (error) {
            console.error('❌ Failed to initialize WebSocket:', error);
            updateConnectionStatus('error');
        }
    }
    
    // Setup fallback polling if WebSocket fails
    function setupFallbackPolling() {
        console.log('🔄 Setting up fallback polling as backup...');
        
        // Update table every 30 seconds as fallback
        setInterval(async () => {
            // Only poll if WebSocket is not working
            if (!window.binanceWebSocket || window.binanceWebSocket.readyState !== WebSocket.OPEN) {
                console.log('🔄 WebSocket not available, using fallback polling...');
                await updateTableRealtime();
            }
        }, 30000); // 30 seconds interval
        
        // Also add a more frequent health check for realtime updates
        setInterval(() => {
            console.log('💓 Realtime health check...');
            
            // Check if any symbols need realtime updates
            if (window.symbolRealTimeData) {
                Object.keys(window.symbolRealTimeData).forEach(symbol => {
                    const data = window.symbolRealTimeData[symbol];
                    if (data && data.timestamp && (Date.now() - data.timestamp) > 15000) {
                        console.log(`⚠️ ${symbol} data is stale (${Math.round((Date.now() - data.timestamp) / 1000)}s old), triggering update`);
                        
                        // Force update with current data
                        if (charts[symbol] && charts[symbol].isInitialized) {
                            updateMiniChartWith24hChange(symbol, data.price, data.change);
                        }
                    }
                });
            }
        }, 15000); // 15 seconds interval
    }
    
    // Update table with real-time data
    async function updateTableRealtime() {
        const tableRows = document.querySelectorAll('#coins-table tbody tr');
        
        for (const row of tableRows) {
            const symbol = row.getAttribute('data-symbol');
            if (symbol) {
                try {
                    const binanceSymbol = symbol.replace('/', '');
                    const response = await fetch(`https://api.binance.com/api/v3/ticker/24hr?symbol=${binanceSymbol}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'User-Agent': 'Mozilla/5.0 (compatible; CryptoApp/1.0)'
                        },
                        timeout: 5000
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        const price = parseFloat(data.lastPrice);
                        const priceChange = parseFloat(data.priceChangePercent);
                        const volume = parseFloat(data.volume);
                        
                        // Validate data
                        if (price > 0 && !isNaN(price) && !isNaN(priceChange)) {
                            // Update table row
                            updateTableRowRealtime(symbol, price, priceChange, volume);
                            
                            // Update stored data
                            if (!window.symbolRealTimeData) {
                                window.symbolRealTimeData = {};
                            }
                            window.symbolRealTimeData[symbol] = {
                                price: price,
                                change: priceChange,
                                volume: volume,
                                timestamp: Date.now()
                            };
                        } else {
                            console.warn(`Invalid data received for ${symbol}:`, data);
                        }
                    } else {
                        console.warn(`API error for ${symbol}: ${response.status} - ${response.statusText}`);
                        // Use fallback data if available
                        useFallbackData(symbol);
                    }
                } catch (error) {
                    console.error(`Error updating ${symbol}:`, error);
                    // Use fallback data on error
                    useFallbackData(symbol);
                }
                
                // Small delay to avoid overwhelming the API
                await new Promise(resolve => setTimeout(resolve, 100));
            }
        }
    }
    
    // Use fallback data when API fails
    function useFallbackData(symbol) {
        if (window.symbolRealTimeData && window.symbolRealTimeData[symbol]) {
            const fallbackData = window.symbolRealTimeData[symbol];
            // Add small random variation to simulate real-time updates
            const variation = (Math.random() - 0.5) * 0.001; // ±0.05%
            const newPrice = fallbackData.price * (1 + variation);
            const newChange = fallbackData.change + (Math.random() - 0.5) * 0.1; // ±0.05%
            
            updateTableRowRealtime(symbol, newPrice, newChange, fallbackData.volume);
            
            // Update stored data
            window.symbolRealTimeData[symbol] = {
                price: newPrice,
                change: newChange,
                volume: fallbackData.volume,
                timestamp: Date.now()
            };
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
        
        // Initialize charts first
        initCharts();
        
        // Initialize crypto scroll functionality
        initializeCryptoScroll();
        
        // Initialize price ticker with real data
        initializeTickerData();
        
        // Process ticker updates every 100ms for smooth animations
        setInterval(processTickerUpdates, 100);
        
        // Initialize real-time data storage
        window.symbolRealTimeData = {};
        
        // Connect to legacy WebSocket for ticker updates (if available)
        if ('{{env('WEBSOCKET_URL')}}' && '{{env('WEBSOCKET_URL')}}' !== '') {
            console.log('🔌 Connecting to legacy WebSocket for ticker updates...');
            connectWebSocket();
        } else {
            console.log('⚠️ No legacy WebSocket URL configured, using Binance API only');
        }
        
        // Add error handling for table updates
        window.addEventListener('error', function(e) {
            if (e.target && e.target.tagName === 'CANVAS') {
                console.error('Chart error:', e);
                // Only retry chart initialization if it's not already initialized
                const symbol = e.target.id?.replace('chart-', '');
                if (symbol && charts[symbol] && !charts[symbol].isInitialized) {
                    console.log(`🔄 Retrying chart initialization for ${symbol} due to error`);
                    setTimeout(() => {
                        // Try to reinitialize only this specific chart
                        if (window.symbolRealTimeData && window.symbolRealTimeData[symbol]) {
                            const data = window.symbolRealTimeData[symbol];
                            initializeChartWithRealData(symbol, data.price, data.change);
                        }
                    }, 2000);
                } else {
                    console.log('⚠️ Chart error occurred but chart is already initialized, skipping reinitialization');
                }
            }
        });
        
        // Add performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', () => {
                setTimeout(() => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    console.log('Page load performance:', {
                        domContentLoaded: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart,
                        loadComplete: perfData.loadEventEnd - perfData.loadEventStart,
                        totalTime: perfData.loadEventEnd - perfData.navigationStart
                    });
                }, 1000);
            });
        }
        
        console.log('All components initialized');
        
        // Debug: Check chart status after a short delay
        setTimeout(() => {
            console.log('Chart status check:');
            console.log('- Trend chart object:', trendChart);
            console.log('- Current symbol:', currentSymbol);
            console.log('- Current time range:', currentTimeRange);
            console.log('- Chart data:', window.trendChartData);
            
            if (trendChart) {
                console.log('- Trend chart data length:', trendChart.data.datasets[0].data.length);
                console.log('- Trend chart labels length:', trendChart.data.labels.length);
                
                // Force refresh if chart is empty
                if (trendChart.data.datasets[0].data.length === 0) {
                    console.log('Trend chart is empty, forcing refresh...');
                    loadTrendChartData(currentSymbol, currentTimeRange);
                }
            } else {
                console.error('Trend chart not initialized!');
            }
            
            // Check mini charts status
            console.log('Mini charts status:');
            Object.keys(charts).forEach(symbol => {
                const chart = charts[symbol];
                if (chart) {
                    console.log(`- ${symbol}: Initialized=${chart.isInitialized}, Data points=${chart.data.datasets[0].data.length}`);
                }
            });
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