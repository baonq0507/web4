@extends('user.layouts.app')
@section('title', __('index.spot_trading'))
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

    /* Modern spot trading interface */
    .spot-trading-container {
        background: linear-gradient(135deg, #1a1d29 0%, #2a2d38 100%);
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(61, 222, 234, 0.3);
    }

    .spot-trading-card {
        background: rgba(26, 29, 41, 0.9);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(61, 222, 234, 0.2);
        border-radius: 16px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .spot-trading-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #3ddeea, #00d4aa, #3ddeea);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .spot-trading-card:hover {
        border-color: rgba(61, 222, 234, 0.5);
        box-shadow: 0 8px 30px rgba(61, 222, 234, 0.15);
        transform: translateY(-2px);
    }

    .spot-price-display {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        font-size: 24px;
        text-shadow: 0 0 15px rgba(61, 222, 234, 0.6);
        background: linear-gradient(45deg, #3ddeea, #00d4aa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .spot-trading-button {
        background: linear-gradient(45deg, #3ddeea, #2bb8c4);
        border: none;
        border-radius: 12px;
        padding: 16px 32px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(61, 222, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .spot-trading-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .spot-trading-button:hover::before {
        left: 100%;
    }

    .spot-trading-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(61, 222, 234, 0.5);
    }

    .spot-trading-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .spot-buy-button {
        background: linear-gradient(45deg, #00d4aa, #00b894);
        box-shadow: 0 6px 20px rgba(0, 212, 170, 0.4);
    }

    .spot-sell-button {
        background: linear-gradient(45deg, #e04b48, #c0392b);
        box-shadow: 0 6px 20px rgba(224, 75, 72, 0.4);
    }

    .spot-input-field {
        background: rgba(26, 29, 41, 0.9);
        border: 2px solid rgba(61, 222, 234, 0.3);
        border-radius: 12px;
        padding: 16px 20px;
        color: #ffffff;
        font-size: 18px;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .spot-input-field:focus {
        outline: none;
        border-color: #3ddeea;
        box-shadow: 0 0 0 4px rgba(61, 222, 234, 0.15);
        background: rgba(26, 29, 41, 1);
    }

    .spot-input-field::placeholder {
        color: rgba(255, 255, 255, 0.5);
        font-weight: 400;
    }

    .wallet-balance-card {
        background: rgba(26, 29, 41, 0.8);
        border: 1px solid rgba(61, 222, 234, 0.2);
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .wallet-balance-card:hover {
        border-color: rgba(61, 222, 234, 0.4);
        box-shadow: 0 4px 20px rgba(61, 222, 234, 0.1);
    }

    .balance-amount {
        font-size: 20px;
        font-weight: 700;
        color: #3ddeea;
        text-shadow: 0 0 10px rgba(61, 222, 234, 0.5);
    }

    .balance-label {
        font-size: 14px;
        color: #8b949e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .spot-trade-history {
        background: rgba(26, 29, 41, 0.9);
        border-radius: 12px;
        border: 1px solid rgba(61, 222, 234, 0.2);
        max-height: 400px;
        overflow-y: auto;
    }

    .spot-trade-item {
        padding: 16px;
        border-bottom: 1px solid rgba(61, 222, 234, 0.1);
        transition: all 0.3s ease;
    }

    .spot-trade-item:hover {
        background: rgba(61, 222, 234, 0.05);
    }

    .spot-trade-item:last-child {
        border-bottom: none;
    }

    .trade-type-buy {
        color: #00d4aa;
        font-weight: 700;
    }

    .trade-type-sell {
        color: #e04b48;
        font-weight: 700;
    }

    .spot-status-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .spot-status-online {
        background: #00d4aa;
        box-shadow: 0 0 15px rgba(0, 212, 170, 0.6);
        animation: pulse 2s infinite;
    }

    .spot-status-offline {
        background: #e04b48;
        box-shadow: 0 0 15px rgba(224, 75, 72, 0.6);
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* Spot trading price update animation */
    .spot-price-update-animation {
        animation: spotPriceUpdate 1.2s ease-in-out;
    }

    @keyframes spotPriceUpdate {
        0% { transform: scale(1); }
        25% { transform: scale(1.08); background-color: rgba(61, 222, 234, 0.3); }
        50% { transform: scale(1.05); background-color: rgba(0, 212, 170, 0.3); }
        75% { transform: scale(1.02); background-color: rgba(61, 222, 234, 0.2); }
        100% { transform: scale(1); }
    }

    /* Enhanced spot trading interface */
    .spot-trading-interface {
        background: linear-gradient(135deg, #1a1d29 0%, #2a2d38 100%);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(61, 222, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .spot-trading-interface::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 80%, rgba(61, 222, 234, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(0, 212, 170, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .spot-order-form {
        background: rgba(26, 29, 41, 0.9);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(61, 222, 234, 0.2);
        backdrop-filter: blur(10px);
    }

    .spot-market-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .spot-market-item {
        text-align: center;
        padding: 16px;
        background: rgba(26, 29, 41, 0.6);
        border-radius: 12px;
        border: 1px solid rgba(61, 222, 234, 0.2);
        transition: all 0.3s ease;
    }

    .spot-market-item:hover {
        border-color: rgba(61, 222, 234, 0.4);
        box-shadow: 0 4px 20px rgba(61, 222, 234, 0.1);
    }

    .spot-market-value {
        font-size: 20px;
        font-weight: 700;
        color: #3ddeea;
        margin-bottom: 8px;
        text-shadow: 0 0 10px rgba(61, 222, 234, 0.5);
    }

    .spot-market-label {
        font-size: 12px;
        color: #8b949e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .spot-trade-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 24px;
    }

    .spot-action-button {
        padding: 18px 24px;
        border-radius: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .spot-action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .spot-action-button:hover::before {
        left: 100%;
    }

    .spot-buy-action {
        background: linear-gradient(45deg, #00d4aa, #00b894);
        box-shadow: 0 6px 20px rgba(0, 212, 170, 0.4);
    }

    .spot-sell-action {
        background: linear-gradient(45deg, #e04b48, #c0392b);
        box-shadow: 0 6px 20px rgba(224, 75, 72, 0.4);
    }

    .spot-action-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
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

    /* Debug info */
    .symbols-debug {
        background: rgba(61, 222, 234, 0.1);
        border: 1px solid #3ddeea;
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 4px;
        font-size: 12px;
        color: #3ddeea;
    }

    /* Symbol Tabs Styling */
    .symbol-tab-btn {
        color: #9ca3af;
        background: transparent;
    }

    .symbol-tab-btn.active {
        color: #ffffff;
        background: #3ddeea;
    }

    .symbol-tab-btn:hover {
        color: #ffffff;
        background: rgba(61, 222, 234, 0.2);
    }

    .symbol-tab-content {
        display: block;
    }

    .symbol-tab-content.hidden {
        display: none;
    }

    /* Mobile Symbol Tabs Styling */
    .mobile-symbol-tab-btn {
        color: #9ca3af;
        background: transparent;
    }

    .mobile-symbol-tab-btn.active {
        color: #ffffff;
        background: #3ddeea;
    }

    .mobile-symbol-tab-btn:hover {
        color: #ffffff;
        background: rgba(61, 222, 234, 0.2);
    }

    .mobile-currency-tab-content {
        display: block;
    }

    .mobile-currency-tab-content.hidden {
        display: none;
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
        /* background: #181a20; */
        border-radius: 0.375rem;
        /* padding: 0.25rem; */
        margin-bottom: 1rem;
    }

    .order-book-tabs .order-tab-item {
        /* flex: 1; */
        text-align: center;
        /* padding: 0.5rem 0.75rem; */
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
        /* background: #3ddeea; */
        color: #181a20;
        transform: scale(1.05);
        animation: tabActivate 0.3s ease-out;
    }

    .order-book-tabs .order-tab-item:not(.active):hover {
        color: white;
    }

    .order-book-content {
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(-10px);
    }

    .order-book-content.active {
        max-height: 200px;
        opacity: 1;
        transform: translateY(0);
    }

    /* Latest Transaction Container */
    .mobile-latest-transaction-container {
        background: #101112;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        min-height: 250px;
        border: 1px solid #232428;
    }

    .latest-transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .latest-transaction-header h3 {
        color: white;
        font-size: 1rem;
        font-weight: 600;
    }

    .refresh-latest-transaction {
        background: #3ddeea;
        color: #181a20;
        border: none;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .refresh-latest-transaction:hover {
        background: #2bb8c4;
    }

    .refresh-latest-transaction:active {
        transform: scale(0.95);
    }

    .latest-transaction-item {
        transition: all 0.2s ease;
        animation: fadeInUp 0.3s ease-out;
    }

    .latest-transaction-item:hover {
        transform: translateX(4px);
        background: #2a2d38 !important;
    }

    /* Animation cho order book items */
    .order-book-item {
        transition: all 0.2s ease;
        animation: slideInRight 0.3s ease-out;
    }

    .order-book-item:hover {
        background: #2a2d38 !important;
        transform: translateX(2px);
    }

    /* Keyframes cho animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes tabActivate {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1.05);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .latest-transaction-empty {
        text-align: center;
        padding: 2rem 1rem;
    }

    .latest-transaction-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .latest-transaction-empty p {
        margin-bottom: 0.5rem;
    }

    .latest-transaction-empty .text-sm {
        opacity: 0.7;
    }

    .latest-transaction-header-info {
        background: #181a20;
        border: 1px solid #232428;
        border-radius: 0.5rem;
        padding: 0.5rem;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: #6b7280;
    }

    .latest-transaction-header-info .transaction-count {
        font-weight: 500;
        color: #3ddeea;
    }

    .latest-transaction-header-info .update-time {
        color: #6b7280;
    }

    /* Action Buttons */
    .mobile-action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .btn-buy-up,
    .btn-buy-down {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-buy-up {
        background: #3ddeea;
        color: #181a20;
    }

    .btn-buy-up:hover {
        background: #2bb8c4;
    }

    .btn-buy-down {
        background: #e04b48;
        color: white;
    }

    .btn-buy-down:hover {
        background: #c73e3a;
    }

    /* Currency Dropdown */
    .currency-selector-mobile .currency-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #101112;
        border: 1px solid #232428;
        border-radius: 0.5rem;
        max-height: 300px;
        overflow-y: auto;
        display: none;
        visibility: hidden;
        opacity: 0;
        z-index: 1000;
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        transform: translateY(-10px);
        margin-top: 8px;
    }

    .currency-selector-mobile .currency-dropdown.show {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    .currency-selector-mobile .currency-dropdown:not(.show) {
        pointer-events: none;
    }

    /* Make currency-selector-mobile relative positioned */
    .currency-selector-mobile {
        position: relative;
    }

    /* Make mobile-trading-header relative positioned for dropdown positioning */
    .mobile-trading-header {
        position: relative;
    }

    /* Ensure currency-pair has proper positioning */
    .currency-selector-mobile .currency-pair {
        position: relative;
        z-index: 10;
    }

    /* Style for currency-pair selector */
    .currency-selector-mobile .currency-pair {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 8px 12px;
        background: #181a20;
        border: 1px solid #232428;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .currency-selector-mobile .currency-pair:hover {
        background: #2a2d38;
        border-color: #3ddeea;
    }

    .currency-selector-mobile .currency-pair img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }

    .currency-selector-mobile .currency-pair span {
        color: white;
        font-weight: 500;
        font-size: 14px;
    }

    .currency-selector-mobile .dropdown-icon {
        color: #6b7280;
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .currency-selector-mobile .dropdown-icon.rotated {
        transform: rotate(180deg);
    }

    /* Search Box Styles */
    .currency-search-box {
        padding: 12px;
        border-bottom: 1px solid #232428;
        background: #181a20;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        color: #6b7280;
        font-size: 14px;
        z-index: 1;
    }

    .currency-search-input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        background: #101112;
        border: 1px solid #232428;
        border-radius: 6px;
        color: white;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
    }

    .currency-search-input:focus {
        border-color: #3ddeea;
        box-shadow: 0 0 0 2px rgba(61, 222, 234, 0.1);
    }

    .currency-search-input::placeholder {
        color: #6b7280;
    }

    .clear-search-btn {
        position: absolute;
        right: 8px;
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 4px;
        border-radius: 50%;
        transition: all 0.2s ease;
    }

    .clear-search-btn:hover {
        background: #232428;
        color: white;
    }

    /* Currency Options Container */
    .currency-options-container {
        max-height: 250px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #3ddeea #181a20;
    }

    .currency-options-container::-webkit-scrollbar {
        width: 6px;
    }

    .currency-options-container::-webkit-scrollbar-track {
        background: #181a20;
        border-radius: 3px;
    }

    .currency-options-container::-webkit-scrollbar-thumb {
        background: #3ddeea;
        border-radius: 3px;
    }

    .currency-options-container::-webkit-scrollbar-thumb:hover {
        background: #2bb8c4;
    }

    /* Responsive fixes for mobile */
    @media (max-width: 768px) {
        .currency-selector-mobile .currency-dropdown {
            position: absolute;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            transform: none !important;
            max-height: 60vh;
            z-index: 9999;
            width: 100% !important;
            margin-top: 8px;
        }
        
        .currency-selector-mobile .currency-dropdown.show {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            transform: translateY(0) !important;
            animation: slideDown 0.3s ease-out;
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Loading state for currency options */
    .currency-option.loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* No results message */
    .no-results {
        text-align: center;
        padding: 20px;
        color: #6b7280;
        font-style: italic;
    }

    .currency-selector-mobile .currency-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #232428;
        position: relative;
    }

    .currency-selector-mobile .currency-option:hover {
        background: #2a2d38;
        transform: translateX(4px);
    }

    .currency-selector-mobile .currency-option:last-child {
        border-bottom: none;
    }

    .currency-selector-mobile .currency-option:hover {
        background: #2a2d38;
    }

    .currency-selector-mobile .currency-option.active {
        background: #2a2d38;
        border-left: 3px solid #3ddeea;
        position: relative;
    }

    .currency-selector-mobile .currency-option.active::before {
        content: '✓';
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #3ddeea;
        font-weight: bold;
        font-size: 14px;
    }

    .currency-selector-mobile .currency-option img {
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    .currency-selector-mobile .currency-option .currency-info {
        flex: 1;
    }

    .currency-selector-mobile .currency-option .currency-name {
        color: white;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .currency-selector-mobile .currency-option .currency-symbol {
        color: #6b7280;
        font-size: 0.75rem;
    }

    .currency-selector-mobile .currency-option .currency-price {
        text-align: right;
    }

    .currency-selector-mobile .currency-option .current-price {
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .currency-selector-mobile .currency-option .price-change {
        font-size: 0.75rem;
        font-weight: 500;
    }

    .currency-selector-mobile .currency-option .price-change.positive {
        color: #3ddeea;
    }

    .currency-selector-mobile .currency-option .currency-option .price-change.negative {
        color: #e04b48;
    }

    /* Mobile Trading Modal Styles */
    .mobile-trading-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        display: flex;
        align-items: flex-end;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-trading-modal.translate-y-full {
        transform: translateY(100%);
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .mobile-trading-modal:not(.translate-y-full) .modal-backdrop {
        opacity: 1;
    }

    .modal-content {
        position: relative;
        background: #101112;
        border-radius: 1rem 1rem 0 0;
        width: 100%;
        max-height: 100vh;
        overflow-y: auto;
        transform: translateY(0);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-trading-modal.translate-y-full .modal-content {
        transform: translateY(100%);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 1.5rem 1rem;
        border-bottom: 1px solid #232428;
        position: sticky;
        top: 0;
        background: #101112;
        z-index: 10;
    }

    .modal-title {
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        color: #6b7280;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
    }

    .modal-close:hover {
        background: #2a2d38;
        color: white;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-select,
    .form-input {
        width: 100%;
        background: #181a20;
        border: 1px solid #232428;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        color: white;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-select:focus,
    .form-input:focus {
        outline: none;
        border-color: #3ddeea;
        box-shadow: 0 0 0 3px rgba(61, 222, 234, 0.1);
    }

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

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .modal-content {
            max-height: 100vh;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-header {
            padding: 1rem 1rem 0.75rem;
        }
    }
    #mobile-percentage-slider {
        top: 20px;
    }

    /* Spot Trading History Styles */
    .spot-trade-item {
        transition: all 0.3s ease;
        border-left-width: 4px;
    }

    .spot-trade-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .spot-order-filters {
        transition: all 0.3s ease;
    }

    .spot-order-filters:hover {
        border-color: #3ddeea;
    }

    .filter-select, .filter-input {
        transition: all 0.2s ease;
    }

    .filter-select:focus, .filter-input:focus {
        border-color: #3ddeea;
        box-shadow: 0 0 0 3px rgba(61, 222, 234, 0.1);
    }

    .trading-stats-item {
        transition: all 0.3s ease;
    }

    .trading-stats-item:hover {
        transform: scale(1.05);
        background-color: #2a2d38;
    }

    /* Tab Management Styles */
    .active-tab {
        transition: all 0.3s ease;
    }

    .active-tab:hover {
        background-color: rgba(61, 222, 234, 0.1);
    }

    .tab-content {
        transition: all 0.3s ease;
    }

    /* Load More Button Animation */
    .load-more-spot-orders {
        transition: all 0.3s ease;
    }

    .load-more-spot-orders:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(61, 222, 234, 0.3);
    }

    /* Cancel Order Button */
    .cancel-order-btn {
        transition: all 0.2s ease;
    }

    .cancel-order-btn:hover {
        transform: scale(1.05);
    }

    /* Export and Refresh Buttons */
    #export-orders, #refresh-orders {
        transition: all 0.2s ease;
    }

    #export-orders:hover, #refresh-orders:hover {
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<!-- Hidden inputs for JavaScript data -->
<input type="hidden" id="symbol-active-data" value="{{ $symbolActive->symbol }}">
<input type="hidden" id="symbols-data" value="{{ json_encode($symbols) }}">

<!-- TICKER DẢI GIÁ COIN -->
<section class="w-full bg-[#191a1d] py-2 px-6 flex space-x-6 overflow-x-auto text-xs border-b border-[#232428] pt-20 hidden lg:flex">
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M11.3211 6.42547C11.0608 5.83944 10.6824 5.31342 10.2096 4.88031L9.81911 4.52222C9.80588 4.51031 9.78992 4.50184 9.77263 4.49756C9.75535 4.49329 9.73728 4.49333 9.72002 4.49769C9.70276 4.50206 9.68683 4.51061 9.67366 4.52258C9.66049 4.53456 9.65047 4.5496 9.64448 4.56637L9.47035 5.06671C9.36194 5.38064 9.1618 5.70096 8.87877 6.01637C8.86446 6.03182 8.84483 6.04128 8.82383 6.04286C8.81334 6.04389 8.80275 6.04268 8.79277 6.03929C8.78279 6.03591 8.77364 6.03044 8.76595 6.02324C8.75683 6.01523 8.74969 6.00521 8.74509 5.99398C8.74049 5.98274 8.73857 5.97059 8.73946 5.95849C8.78851 5.15108 8.54766 4.24017 8.01887 3.2493C7.58181 2.42521 6.97405 1.78311 6.2152 1.33526L5.66091 1.00906C5.64418 0.999618 5.62524 0.99481 5.60604 0.995132C5.58684 0.995455 5.56807 1.0009 5.55167 1.01089C5.53527 1.02089 5.52184 1.03509 5.51276 1.05201C5.50368 1.06893 5.49928 1.08797 5.50001 1.10717L5.52945 1.75074C5.54956 2.19074C5.49854 2.57973 5.37787 2.90348C5.22971 3.30016 5.01671 3.66948 4.74754 3.99637C4.55722 4.22692 4.34384 4.43491 4.11035 4.61444C3.5448 5.04938 3.08498 5.60663 2.76532 6.24446C2.46683 6.84684 2.30207 7.50663 2.28234 8.17862C2.26262 8.85061 2.38838 9.51893 2.65103 10.1378C3.13378 11.2625 4.03518 12.1553 5.16449 12.6272C5.74594 12.8713 6.37042 12.9964 7.00103 12.9951C7.63131 12.9962 8.25549 12.8716 8.83707 12.6287C9.39771 12.3954 9.90754 12.0552 10.3381 11.627C10.7771 11.1945 11.1256 10.6788 11.3633 10.1102C11.6009 9.54156 11.723 8.93129 11.7224 8.31498C11.7224 7.66062 11.5884 7.02489 11.3211 6.42547Z" fill="url(#paint0_linear_6455_70835)"></path>
            <defs>
                <linearGradient id="paint0_linear_6455_70835" x1="7.00135" y1="0.995117" x2="7.00135" y2="12.9951" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#F45F4F"></stop>
                    <stop offset="1" stop-color="#F1493F"></stop>
                </linearGradient>
            </defs>
        </svg>
    </span>
    @foreach ($symbols->take(10) as $item)
    <span class="text-white font-semibold">
        {{ $item->name }}
        <span class="text-[#3ddeea] font-semibold price-change" id="price-change-{{ $item->symbol }}">{{ $item->price_change }}%</span>
    </span>
    @endforeach
</section>

<!-- MOBILE CURRENCY SELECTOR -->
<div class="currency-selector-mobile mobile-trading-interface ">
    <!-- Header với giá hiện tại -->
    <div class="mobile-trading-header ">
        <div class="flex items-center justify-between sm:pt-14 pt-14">
            <div class="currency-pair"  data-id="{{ $symbolActive->id }}" id="mobile-currency-selector"  onclick="forceShowDropdown()">
                <img src="{{ $symbolActive->image }}" alt="{{ $symbolActive->name }}" id="mobile-active-icon">
                <span id="mobile-active-symbol">{{ $symbolActive->name }}</span>
                <i class="fas fa-chevron-down dropdown-icon" id="mobile-dropdown-icon"></i>
            </div>
            <!-- Test button -->
            <!-- <button style="background: #3ddeea; color: #101112; padding: 4px 8px; margin-left: 8px; border-radius: 4px; border: none; cursor: pointer;">Force Show</button> -->
            <div class="current-price-display">
                <div class="price-main-value" id="mobile-current-price">--</div>
                <div class="price-change-indicator {{ $symbolActive->price_change >= 0 ? 'positive' : 'negative' }}" id="mobile-current-price-change">
                    <i class="fas fa-arrow-{{ $symbolActive->price_change >= 0 ? 'up' : 'down' }}"></i>
                    {{ $symbolActive->price_change >= 0 ? '+' : '' }}{{ $symbolActive->price_change }}%
                </div>
            </div>
        </div>
        
        <!-- Currency Dropdown -->
        <div class="currency-dropdown" id="mobile-currency-dropdown">
            <!-- Search Box -->
            <div class="currency-search-box">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="currency-search-input" placeholder="Tìm kiếm symbol..." class="currency-search-input">
                    <button id="clear-search" class="clear-search-btn" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Symbol Tabs -->
            <div class="mobile-symbol-tabs">
                <div class="flex bg-[#181a20] rounded-lg p-1 mb-3">
                    <button class="mobile-symbol-tab-btn flex-1 py-2 px-2 text-xs font-medium rounded-md transition-colors active" data-tab="crypto">
                        <i class="fab fa-bitcoin mr-1"></i>Crypto
                    </button>
                    <button class="mobile-symbol-tab-btn flex-1 py-2 px-2 text-xs font-medium rounded-md transition-colors" data-tab="usa">
                        <i class="fas fa-chart-line mr-1"></i>USA
                    </button>
                    <button class="mobile-symbol-tab-btn flex-1 py-2 px-2 text-xs font-medium rounded-md transition-colors" data-tab="forex">
                        <i class="fas fa-exchange-alt mr-1"></i>Forex
                    </button>
                </div>
            </div>

            <!-- Currency Options Container -->
            <div class="currency-options-container">
                <!-- Crypto Options -->
                <div class="mobile-currency-tab-content" id="mobile-crypto-tab">
                    @foreach ($cryptoSymbols as $item)
                    <div class="currency-option {{ $item->id == $symbolActive->id ? 'active' : '' }}"
                        data-symbol="{{ $item->symbol }}"
                        data-name="{{ $item->name }}"
                        data-icon="{{ $item->image }}"
                        data-type="{{ $item->category }}"
                        data-id="{{ $item->id }}">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                        <div class="currency-info">
                            <div class="currency-name">{{ $item->name }}</div>
                            <div class="stat-symbol">{{ $item->symbol }}</div>
                        </div>
                        <div class="currency-price">
                            <div class="current-price" id="mobile-price-{{ $item->symbol }}">--</div>
                            <div class="price-change {{ $item->price_change >= 0 ? 'positive' : 'negative' }}" id="mobile-price-change-{{ $item->symbol }}">
                                {{ $item->price_change >= 0 ? '+' : '' }}{{ $item->price_change }}%
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- USA Options -->
                <div class="mobile-currency-tab-content hidden" id="mobile-usa-tab">
                    @foreach ($usaSymbols as $item)
                    <div class="currency-option {{ $item->id == $symbolActive->id ? 'active' : '' }}"
                        data-symbol="{{ $item->symbol }}"
                        data-name="{{ $item->name }}"
                        data-icon="{{ $item->image }}"
                        data-type="{{ $item->category }}"
                        data-id="{{ $item->id }}">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                        <div class="currency-info">
                            <div class="currency-name">{{ $item->name }}</div>
                            <div class="stat-symbol">{{ $item->symbol }}</div>
                        </div>
                        <div class="currency-price">
                            <div class="current-price" id="mobile-price-{{ $item->symbol }}">--</div>
                            <div class="price-change {{ $item->price_change >= 0 ? 'positive' : 'negative' }}" id="mobile-price-change-{{ $item->symbol }}">
                                {{ $item->price_change >= 0 ? '+' : '' }}{{ $item->price_change }}%
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Forex Options -->
                <div class="mobile-currency-tab-content hidden" id="mobile-forex-tab">
                    @foreach ($forexSymbols as $item)
                    <div class="currency-option {{ $item->id == $symbolActive->id ? 'active' : '' }}"
                        data-symbol="{{ $item->symbol }}"
                        data-name="{{ $item->name }}"
                        data-icon="{{ $item->image }}"
                        data-type="{{ $item->category }}"
                        data-id="{{ $item->id }}">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                        <div class="currency-info">
                            <div class="currency-name">{{ $item->name }}</div>
                            <div class="stat-symbol">{{ $item->symbol }}</div>
                        </div>
                        <div class="currency-price">
                            <div class="current-price" id="mobile-price-{{ $item->symbol }}">--</div>
                            <div class="price-change {{ $item->price_change >= 0 ? 'positive' : 'negative' }}" id="mobile-price-change-{{ $item->symbol }}">
                                {{ $item->price_change >= 0 ? '+' : '' }}{{ $item->price_change }}%
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="stats-24h">
            <div class="stat-row">
                <span class="stat-label">24H High</span>
                <span class="stat-value" id="mobile-high-price">--</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">24H Low</span>
                <span class="stat-value" id="mobile-low-price">--</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">24H Volume</span>
                <span class="stat-value" id="mobile-volume">--</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">24H Amount</span>
                <span class="stat-value" id="mobile-amount">--</span>
            </div>
        </div>

    </div>

    <!-- Navigation Tabs -->
    <div class="mobile-nav-tabs">
        <div class="tab-item active" data-tab="chart">
            <span>Chart</span>
        </div>
        <div class="tab-item" data-tab="entrusted">
            <span>Entrusted Order</span>
        </div>
        <div class="tab-item" data-tab="latest">
            <span>Latest Transaction</span>
        </div>
    </div>


    <!-- Chart Container -->
    <div class="mobile-chart-container" id="mobile-chart">
        <iframe
            src="https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22{{ $symbolActive->symbol }}%22%2C%22interval%22%3A%225%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D{{ $symbolActive->symbol }}%22%7D"
            frameborder="0"
            allowfullscreen="true"
            scrolling="no"
            style="height: 300px; width: 100%;">
        </iframe>
    </div>

    <!-- Order Book Container -->
    <div class="mobile-order-book-container hidden" id="mobile-order-book">
        <div class="order-book-header">
            <h3 class="text-white font-semibold mb-3">Order Book</h3>
        </div>

        <!-- Order Book Tabs -->
        <div class="order-book-tabs">
            <div class="order-tab-item active" data-tab="buy">
                <img src="{{ asset('assets/images/close.svg') }}" alt="Buy">
            </div>
            <div class="order-tab-item" data-tab="sell">
                <img src="{{ asset('assets/images/ban.svg') }}" alt="Sell">
            </div>
        </div>

        <!-- Order book headers -->
        <div class="flex text-sm mb-2 text-gray-400">
            <span class="w-1/3">Price (USDT)</span>
            <span class="w-1/3">Quantity (BTC)</span>
            <span class="w-1/3 text-right">Volume</span>
        </div>

        <!-- Buy Orders Content -->
        <div class="order-book-content buy-orders active" id="mobile-buy-orders">
            <!-- Buy orders will be loaded here -->
        </div>

        <!-- Sell Orders Content -->
        <div class="order-book-content sell-orders" id="mobile-sell-orders">
            <!-- Sell orders will be loaded here -->
        </div>
    </div>

    <!-- Latest Transaction Container -->
    <div class="mobile-latest-transaction-container hidden" id="mobile-latest-transaction">
        <div class="latest-transaction-header">
            <h3 class="text-white font-semibold">Latest Transaction</h3>
            <button class="refresh-latest-transaction" id="refresh-latest-transaction" title="Làm mới dữ liệu">
                <i class="fas fa-sync-alt"></i>
                <span>Làm mới</span>
            </button>
        </div>

        <div class="latest-transaction-content" id="mobile-latest-transaction-content">
            <!-- Giao diện lịch sử mới cho spot trading -->
            <div class="block md:hidden history-card" id="history-card">

                
                {{-- @if(auth()->check() && $history->hasMorePages())
                <div class="text-center mt-6">
                    <button id="load-more-mobile" class="bg-[#3ddeea] text-[#181a20] py-3 px-6 rounded-lg font-semibold hover:bg-[#2bb8c4] transition-colors duration-300" data-page="2">
                        <i class="fas fa-sync-alt mr-2"></i>{{ __('index.load_more') }}
                    </button>
                </div>
                @endif --}}
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mobile-action-buttons">
        <button class="btn-buy-up" id="mobile-buy-up">
            <span>Buy Up</span>
        </button>
        <button class="btn-buy-down" id="mobile-buy-down">
            <span>Buy Down</span>
        </button>
    </div>

    <!-- Mobile Trading Modal -->
    <div id="mobile-trading-modal" class="mobile-trading-modal translate-y-full">
        <div class="modal-backdrop" id="mobile-modal-backdrop"></div>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title" id="mobile-modal-title">Trading Form</h3>
                <button class="modal-close" id="mobile-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Transaction Amount -->
                <div class="form-group">
                    <label class="form-label">Transaction Amount (USDT)</label>
                    <input type="text" class="form-input" id="mobile-transaction-amount" placeholder="Enter transaction amount">
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="text" class="form-input" id="mobile-quantity" placeholder="Enter quantity">
                </div>

                <!-- Percentage Slider -->
                <div class="form-group">
                    <label class="form-label">Percentage of Balance</label>
                    <div class="slider-container">
                        <input type="range" min="0" max="100" value="0" step="1" class="form-slider" id="mobile-percentage-slider">
                        <div class="slider-track">
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
                </div>

                <!-- Trading Info -->
                <div class="trading-info">
                    <div class="info-row">
                        <span class="info-label">Balance:</span>
                        <span class="info-value">{{auth()->check() ? number_format(Auth::user()->balance, 2) : '0'}} USDT</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Can Sell:</span>
                        <span class="info-value" id="mobile-can-sell-amount">
                            @if(isset($userWallet) && $userWallet)
                                {{ number_format($userWallet->balance, 6) }} {{ $symbolActive->symbol }}
                            @else
                                -- {{ $symbolActive->symbol }}
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Direction:</span>
                        <span class="info-value" id="mobile-trading-direction">Buy Up</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Investment Amount:</span>
                        <span class="info-value" id="mobile-trading-amount">$0</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Transaction Amount:</span>
                        <span class="info-value" id="mobile-transaction-amount-display">$0</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Quantity:</span>
                        <span class="info-value" id="mobile-quality-display">--</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Yield:</span>
                        <span class="info-value" id="mobile-trading-yield">50%</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    @if (!auth()->check())
                    <button class="btn-submit btn-login" onclick="window.location.href='{{ route('login') }}'">
                        Login to Trade
                    </button>
                    @else
                    <button class="btn-submit" id="mobile-submit-trade" data-type="buy">
                        <span class="btn-text">Buy Up</span>
                        <i class="fas fa-spinner fa-spin hidden"></i>
                    </button>
                    @endif
                </div>

                <!-- Investment Limits -->
                <div class="investment-limits">
                    <span>Min: 2000 USDT</span>
                    <span>Max: 999999 USDT</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN TRADING LAYOUT -->
<div class="flex flex-col lg:flex-row w-full px-3 pt-3 gap-3 h-auto main-trading-layout">

    <!-- LEFT COLUMN: COIN LIST -->
    <div class="w-full lg:w-64 flex-shrink-0 trading-pairs-desktop">
        <div class="bg-[#101112] rounded-md p-3 h-full">
            <h3 class="text-white font-semibold mb-3">{{ __('index.trading_pairs') }}</h3>

            <!-- Debug info -->
            <!-- <div class="symbols-debug">
                <strong>Debug:</strong> Có {{ $symbols ? count($symbols) : 0 }} symbols
                @if($symbols)
                <br>Active: {{ $symbolActive->name ?? 'N/A' }}
                @endif
            </div> -->

            <!-- Symbol Tabs -->
            <div class="mb-4">
                <div class="flex bg-[#181a20] rounded-lg p-1">
                    <button class="symbol-tab-btn flex-1 py-2 px-2 text-xs font-medium rounded-md transition-colors active" data-tab="crypto">
                        <i class="fab fa-bitcoin mr-1"></i>Crypto
                    </button>
                    <button class="symbol-tab-btn flex-1 py-2 px-2 text-xs font-medium rounded-md transition-colors" data-tab="usa">
                        <i class="fas fa-chart-line mr-1"></i>USA
                    </button>
                    <button class="symbol-tab-btn flex-1 py-2 px-2 text-xs font-medium rounded-md transition-colors" data-tab="forex">
                        <i class="fas fa-exchange-alt mr-1"></i>Forex
                    </button>
                </div>
            </div>

            <!-- Crypto Symbols List -->
            <div class="space-y-2 mb-4 flex-1 overflow-y-auto pb-4 custom-scrollbar symbol-tab-content" id="crypto-tab" style="min-height: 300px; max-height: 400px;">
                @if($cryptoSymbols && count($cryptoSymbols) > 0)
                @foreach ($cryptoSymbols as $item)
                <div class="flex items-center gap-3 p-3 rounded-md cursor-pointer symbol-item hover:bg-[#2a2d38] transition-colors {{ $item->id == $symbolActive->id ? 'symbol-active' : 'bg-[#181a20]' }}"
                    data-symbol="{{ $item->symbol }}"
                    data-icon="{{ $item->image }}"
                    data-type="{{ $item->category }}"
                    data-id="{{ $item->id }}">
                    <img src="{{ $item->image }}" class="w-6 h-6 flex-shrink-0" alt="{{ $item->name }}">
                    <div class="flex-1 min-w-0">
                        <div class="text-white text-sm font-medium truncate">{{ $item->name }}</div>
                        <div class="text-gray-400 text-xs truncate">{{ $item->symbol }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-white text-sm font-semibold price-display" id="price-{{ $item->symbol }}">--</div>
                        <div class="text-xs price-change-display {{ $item->price_change >= 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}" id="price-change-display-{{ $item->symbol }}">
                            <span class="price-change {{ $item->price_change >= 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}" id="price-change-{{ $item->symbol }}">{{ $item->price_change }}%</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="text-center text-gray-400 py-4">
                    <p>Không có symbols Crypto nào</p>
                </div>
                @endif
            </div>

            <!-- USA Symbols List -->
            <div class="space-y-2 mb-4 flex-1 overflow-y-auto pb-4 custom-scrollbar symbol-tab-content hidden" id="usa-tab" style="min-height: 300px; max-height: 400px;">
                @if($usaSymbols && count($usaSymbols) > 0)
                @foreach ($usaSymbols as $item)
                <div class="flex items-center gap-3 p-3 rounded-md cursor-pointer symbol-item hover:bg-[#2a2d38] transition-colors {{ $item->id == $symbolActive->id ? 'symbol-active' : 'bg-[#181a20]' }}"
                    data-symbol="{{ $item->symbol }}"
                    data-icon="{{ $item->image }}"
                    data-type="{{ $item->category }}"
                    data-id="{{ $item->id }}">
                    <img src="{{ $item->image }}" class="w-6 h-6 flex-shrink-0" alt="{{ $item->name }}">
                    <div class="flex-1 min-w-0">
                        <div class="text-white text-sm font-medium truncate">{{ $item->name }}</div>
                        <div class="text-gray-400 text-xs truncate">{{ $item->symbol }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-white text-sm font-semibold price-display" id="price-{{ $item->symbol }}">--</div>
                        <div class="text-xs price-change-display {{ $item->price_change >= 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}" id="price-change-display-{{ $item->symbol }}">
                            <span class="price-change {{ $item->price_change >= 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}" id="price-change-{{ $item->symbol }}">{{ $item->price_change }}%</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="text-center text-gray-400 py-4">
                    <p>Không có symbols USA nào</p>
                </div>
                @endif
            </div>

            <!-- Forex Symbols List -->
            <div class="space-y-2 mb-4 flex-1 overflow-y-auto pb-4 custom-scrollbar symbol-tab-content hidden" id="forex-tab" style="min-height: 300px; max-height: 400px;">
                @if($forexSymbols && count($forexSymbols) > 0)
                @foreach ($forexSymbols as $item)
                <div class="flex items-center gap-3 p-3 rounded-md cursor-pointer symbol-item hover:bg-[#2a2d38] transition-colors {{ $item->id == $symbolActive->id ? 'symbol-active' : 'bg-[#181a20]' }}"
                    data-symbol="{{ $item->symbol }}"
                    data-icon="{{ $item->image }}"
                    data-type="{{ $item->category }}"
                    data-id="{{ $item->id }}">
                    <img src="{{ $item->image }}" class="w-6 h-6 flex-shrink-0" alt="{{ $item->name }}">
                    <div class="flex-1 min-w-0">
                        <div class="text-white text-sm font-medium truncate">{{ $item->name }}</div>
                        <div class="text-gray-400 text-xs truncate">{{ $item->symbol }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-white text-sm font-semibold price-display" id="price-{{ $item->symbol }}">--</div>
                        <div class="text-xs price-change-display {{ $item->price_change >= 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}" id="price-change-display-{{ $item->symbol }}">
                            <span class="price-change {{ $item->price_change >= 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]' }}" id="price-change-{{ $item->symbol }}">{{ $item->price_change }}%</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="text-center text-gray-400 py-4">
                    <p>Không có symbols Forex nào</p>
                </div>
                @endif
            </div>

            <!-- Current price info -->
            <div class="space-y-2 mb-4 bg-[#181a20] rounded-md p-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">{{ __('index.current_price') }}</span>
                    <span class="text-[#e04b48] font-semibold text-lg" id="current-price">--</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">{{ __('index.change_24h') }}</span>
                    <span class="text-[#e04b48] text-sm" id="current-price-change">--</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">{{ __('index.high_price_24h') }}</span>
                    <span class="text-white text-sm" id="high-price">--</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">{{ __('index.low_price_24h') }}</span>
                    <span class="text-white text-sm" id="low-price">--</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">{{ __('index.volume_24h') }}</span>
                    <span class="text-white text-sm" id="volume-usdt">--</span>
                </div>
            </div>

            <!-- Available balance -->
            <div class="bg-[#181a20] rounded-md p-3">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-white text-sm">{{ __('index.available_balance') }}</span>
                    <div class="flex gap-1">
                        <button class="rounded-full w-5 h-5 bg-[#3ddeea] text-[#181a20] border flex items-center justify-center text-xs">+</button>
                        <button class="rounded-full w-5 h-5 bg-[#3ddeea] text-[#181a20] border flex items-center justify-center text-xs">-</button>
                    </div>
                </div>
                <span class="text-[#3ddeea] text-lg font-bold balance-value">
                    {{auth()->check() ? number_format(Auth::user()->balance, 2) : '--'}}$
                </span>
            </div>

            <!-- User Wallets -->
            @if(isset($userWallets) && count($userWallets) > 0)
                <div class="bg-[#181a20] rounded-md p-3 mt-3">
                    <div class="text-white text-sm mb-2">Your Coins</div>
                    @foreach($userWallets as $wallet)
                        <div class="flex justify-between items-center text-xs text-gray-300 mb-1">
                            <span>{{ $wallet->symbol->symbol }}</span>
                            <span>{{ number_format($wallet->balance, 6) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- CENTER COLUMN: CHART -->
    <div class="flex-1 min-h-[600px]">
        <div class="bg-[#101113] rounded-md w-full" id="trading_view">
            <iframe
                src="https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22{{ $symbolActive->symbol }}%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D{{ $symbolActive->symbol }}%22%7D"
                frameborder="0"
                allowfullscreen="true"
                scrolling="no"
                style="height: 500px"
                class="w-full">
            </iframe>
        </div>

        <!-- TRADING FORM BELOW CHART -->
        <div class="bg-[#101112] rounded-md p-4 mt-3">
            <!-- Current Symbol Display -->
            <div class="mb-4 p-3 bg-[#181a20] rounded-md border border-[#3ddeea]">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">Current Trading Pair:</span>
                    <div class="flex items-center gap-2">
                        <img id="current-trading-symbol-image" src="{{ $symbolActive->image }}" alt="{{ $symbolActive->name }}" class="w-5 h-5 rounded-full">
                        <span class="text-white font-semibold" id="current-trading-symbol">{{ $symbolActive->name }}</span>
                        <span class="text-[#3ddeea] text-sm" id="current-trading-symbol-code">{{ $symbolActive->symbol }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Trading Type Tabs -->
            <!-- <div class="flex gap-1 mb-6 bg-[#181a20] rounded-lg p-1">
                <button class="flex-1 py-2 px-4 rounded-md bg-[#3ddeea] text-[#181a20] font-semibold text-sm transition-colors" data-tab="now">Now</button>
                <button class="flex-1 py-2 px-4 rounded-md text-gray-400 font-semibold text-sm transition-colors hover:text-white" data-tab="timed">Timed</button>
            </div> -->

            <!-- Dual Trading Forms -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 form-trading">
                <!-- BUY UP FORM -->
                <div class="p-2">
                    <!-- Trading Range -->

                    <!-- Investment Amount -->
                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm mb-2">Transaction Amount (USDT)</label>
                        <input type="text" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none amount-buy-up" placeholder="Please enter">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm mb-2">Quantity</label>
                        <input type="text" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none quantity-buy-up" placeholder="Please enter">
                    </div>

                    <!-- Percentage Slider -->
                    <div class="mb-4">
                        <div class="relative w-full h-8 flex items-center">
                            <input
                                type="range"
                                min="0"
                                max="100"
                                value="0"
                                step="1"
                                class="w-full h-2 bg-transparent appearance-none slider-buy-up"
                                id="slider-buy-up"
                                style="z-index: 10; position: absolute; left: 0; right: 0; top: 15px; transform: translateY(-50%);">
                            <!-- Track background -->
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-2 bg-[#181a20] rounded-full z-0"></div>
                            <!-- Active track -->
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-2 bg-[#3ddeea] rounded-full z-0 transition-all duration-200" id="slider-buy-up-active-track" style="width: 0%;"></div>
                            <!-- Ticks -->
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 flex justify-between z-10 pointer-events-none" style="width: 100%;">
                                <span class="w-2 h-2 bg-[#3ddeea] rounded-full" style="margin-left: -4px;"></span>
                                <span class="w-2 h-2 bg-[#3ddeea] rounded-full"></span>
                                <span class="w-2 h-2 bg-[#3ddeea] rounded-full"></span>
                                <span class="w-2 h-2 bg-[#3ddeea] rounded-full"></span>
                                <span class="w-2 h-2 bg-[#3ddeea] rounded-full" style="margin-right: -4px;"></span>
                            </div>
                            <!-- Labels -->
                            <div class="absolute w-full left-0 top-full mt-1 flex justify-between px-0.5 pointer-events-none z-20">
                                <span class="text-xs text-white">0%</span>
                                <span class="text-xs text-white">25%</span>
                                <span class="text-xs text-white">50%</span>
                                <span class="text-xs text-gray-400">75%</span>
                                <span class="text-xs text-gray-400">100%</span>
                            </div>
                        </div>
                    </div>


                    <!-- Crypto Investment Info -->
                    <div class="bg-[#101112] rounded-md p-3 mb-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Balance:</span>
                            <span class="text-white balance-value">{{auth()->check() ? number_format(Auth::user()->balance, 2) : '0'}} USDT</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Can buy:</span>
                            <span class="text-[#3ddeea] font-semibold" id="can-buy-amount-buy-up">--</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Investment Direction:</span>
                            <span class="text-[#3ddeea] font-semibold">Buy Up</span>
                        </div>
                    </div>

                    <!-- Buy Up Button -->
                    @if (!auth()->check())
                    <button class="w-full bg-[#3ddeea] text-[#181a20] py-3 rounded-lg font-semibold btn-login hover:bg-[#2bb8c4] transition-colors">Buy Up</button>
                    @else
                    <button class="w-full bg-[#3ddeea] text-[#181a20] py-3 mt-3 rounded-lg font-semibold submit-order-buy-up hover:bg-[#2bb8c4] transition-colors" data-type="buy">Buy Up</button>
                    @endif

                    <!-- Investment Limits -->
                    <div class="flex justify-between text-xs text-gray-400 mt-2">
                        <span>Minimum 2000 USDT</span>
                        <span>Maximum 999999 USDT</span>
                    </div>
                </div>

                <!-- BUY DOWN FORM -->
                <div class=" p-2 ">
                    <!-- Trading Range -->

                    <!-- Investment Amount -->
                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm mb-2">Transaction Amount (USDT)</label>
                        <input type="text" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#e04b48] focus:outline-none amount-buy-down" placeholder="Please enter">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm mb-2">Quantity</label>
                        <input type="text" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#e04b48] focus:outline-none quantity-buy-down" placeholder="Please enter">
                    </div>

                    <!-- Percentage Slider -->
                    <div class="mb-4">
                        <div class="relative w-full h-8 flex items-center">
                            <input
                                type="range"
                                min="0"
                                max="100"
                                value="0"
                                step="1"
                                class="w-full h-2 bg-transparent appearance-none slider-buy-down"
                                id="slider-buy-down"
                                style="z-index: 10; position: absolute; left: 0; right: 0; top: 15px; transform: translateY(-50%);">
                            <!-- Track background -->
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-2 bg-[#181a20] rounded-full z-0"></div>
                            <!-- Active track -->
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-2 bg-[#e04b48] rounded-full z-0 transition-all duration-200" id="slider-buy-down-active-track" style="width: 0%;"></div>
                            <!-- Ticks -->
                            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 flex justify-between z-10 pointer-events-none" style="width: 100%;">
                                <span class="w-2 h-2 bg-[#e04b48] rounded-full" style="margin-left: -4px;"></span>
                                <span class="w-2 h-2 bg-[#e04b48] rounded-full"></span>
                                <span class="w-2 h-2 bg-[#e04b48] rounded-full"></span>
                                <span class="w-2 h-2 bg-[#e04b48] rounded-full"></span>
                                <span class="w-2 h-2 bg-[#e04b48] rounded-full" style="margin-right: -4px;"></span>
                            </div>
                            <!-- Labels -->
                            <div class="absolute w-full left-0 top-full mt-1 flex justify-between px-0.5 pointer-events-none z-20">
                                <span class="text-xs text-white">0%</span>
                                <span class="text-xs text-white">25%</span>
                                <span class="text-xs text-white">50%</span>
                                <span class="text-xs text-gray-400">75%</span>
                                <span class="text-xs text-gray-400">100%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Balance -->


                    <!-- Crypto Investment Info -->
                    <div class="bg-[#101112] rounded-md p-3 mb-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Balance:</span>
                            <span class="text-white balance-value">{{auth()->check() ? number_format(Auth::user()->balance, 2) : '0'}} USDT</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Can sell:</span>
                            <span class="text-[#e04b48] font-semibold" id="can-sell-amount">
                                @if(isset($userWallet) && $userWallet)
                                    {{ number_format($userWallet->balance, 6) }} {{ $symbolActive->symbol }}
                                @else
                                    -- {{ $symbolActive->symbol }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Investment Direction:</span>
                            <span class="text-[#e04b48] font-semibold">Buy Down</span>
                        </div>
                    </div>

                    <!-- Buy Down Button -->
                    @if (!auth()->check())
                    <button class="w-full bg-[#e04b48] text-white py-3 mt-3 rounded-lg font-semibold btn-login hover:bg-[#c73e3a] transition-colors">Buy Down</button>
                    @else
                    <button class="w-full bg-[#e04b48] text-white py-3 mt-3 rounded-lg font-semibold submit-order-buy-down hover:bg-[#c73e3a] transition-colors" data-type="sell">Buy Down</button>
                    @endif

                    <!-- Investment Limits -->
                    <div class="flex justify-between text-xs text-gray-400 mt-2">
                        <span>Minimum 10 USDT</span>
                        <span>Maximum 99999 USDT</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: ORDER BOOK & TRADING INFO -->
    <div class="w-full lg:w-80 flex-shrink-0">
        <div class="bg-[#101112] rounded-md p-3 h-full">
            <div class="flex gap-3 mb-3">
                <div class="tab-header text-gray-400 pb-1 cursor-pointer change-tab border-[#3ddeea] border-b-2 text-[#3ddeea] active-tab" data-tab="order-book">{{ __('index.order_book') }}</div>
                <div class="tab-header text-gray-400 pb-1 cursor-pointer change-tab" data-tab="chart">{{ __('index.chart') }}</div>
            </div>

            <hr class="border-[#232428] mb-3">

            <!-- Tab Content -->
            <div class="tab-content hidden" id="chart">
                <div class="h-full text-gray-400" id="chart-content">
                    <iframe
                        src="https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22{{ $symbolActive->symbol }}%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D{{ $symbolActive->symbol }}%22%7D"
                        frameborder="0"
                        allowfullscreen="true"
                        scrolling="no"
                        style="height: 400px;"
                        class="w-full">
                    </iframe>
                </div>
            </div>

            <div class="tab-content block" id="order-book">
                <!-- Order book headers -->
                <div class="flex text-sm mb-2">
                    <span class="w-1/3 text-gray-400">{{ __('index.price') }} (USDT)</span>
                    <span class="w-1/3 text-gray-400">{{ __('index.quantity') }} (BTC)</span>
                    <span class="w-1/3 text-gray-400 text-right">{{ __('index.volume') }}</span>
                </div>

                <!-- Order book content -->
                <div class=" overflow-y-auto text-xs" id="order-book-content">
                    <!-- Order book content will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Trading Modal -->
<div class="bg-[#101112] rounded-md p-2 lg:hidden block fixed inset-x-0 bottom-0 z-50 transition-transform transform translate-y-full border border-gray-700" id="mobile-modal">
    <div class="w-full flex flex-col gap-2">
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
            </div>
            <div class="flex items-center w-full rounded-full bg-[#181a20] mt-4">
                <input type="text" name="amount-mobile" class="flex-1 rounded-full px-4 py-2 bg-[#181a20] text-white focus:outline-none amount-mobile" placeholder="{{ __('index.enter_amount_trading') }}">
                <span class="px-4 py-2 text-white">USDT</span>
            </div>

            @if (!auth()->check())
            <button class="cursor-pointer mt-2 w-full bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold btn-login mb-4">{{ __('index.login') }}</button>
            @else
            <button class="transition-all duration-300 cursor-pointer w-full bg-[#3ddeea] text-[#181a20] py-2 rounded-full font-semibold submit-order mb-4">{{ __('index.buy') }}</button>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Trading Button -->
<div class="lg:hidden block fixed bottom-4 right-4 z-40">
    <button class="btn-trading bg-[#3ddeea] text-[#181a20] p-4 rounded-full shadow-lg">
        <i class="fa-solid fa-chart-line text-xl"></i>
    </button>
</div>

<!-- SPOT TRADING ORDER HISTORY -->
<section class="mt-2 px-6 pb-2">
    <div class="flex gap-8 border-b border-[#232428]">
        <div class="border-b-2 border-[#3ddeea] pb-1 font-semibold text-[#3ddeea] cursor-pointer active-tab" data-tab="spot-history">Spot Trading History</div>
        <div class="border-b-2 border-transparent pb-1 font-semibold text-gray-400 cursor-pointer" data-tab="futures-history">{{ __('index.history_order') }}</div>
    </div>
    
    <!-- Spot Trading History Tab -->
    <div class="tab-content block" id="spot-history">
        {{-- @include('user.partials.spot-order-filters', ['symbols' => $symbols]) --}}
        
        <!-- <div class="bg-[#101112] rounded-md min-h-24 p-4">
            <div id="spot-order-history-content">
                {{-- @include('user.partials.spot-order-history', ['history' => $spotTrades]) --}}
            </div>
        </div> -->
    </div>
    
    <!-- Futures Trading History Tab -->
    <div class="tab-content hidden" id="futures-history">
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
                        {{-- @if ($history->count() > 0)
                        @foreach ($history as $item)
                        @include('user.partials.trade-row', ['item' => $item])
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center text-white">{{ __('index.no_data') }}</td>
                        </tr>
                        @endif --}}
                    </tbody>
                </table>

                {{-- @if(auth()->check() && $history->hasMorePages())
                <div class="text-center mt-4">
                    <button id="load-more-desktop" class="bg-[#3ddeea] text-[#181a20] py-2 px-4 rounded-full font-semibold" data-page="2">
                        {{ __('index.load_more') }}
                    </button>
                </div>
                @endif --}}
            </div>
        </div>
    </div>
</section>
<!-- Card view for mobile -->

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
        // Symbol Tabs Functionality
        $('.symbol-tab-btn').click(function() {
            const tab = $(this).data('tab');
            
            // Remove active class from all tabs
            $('.symbol-tab-btn').removeClass('active');
            // Add active class to clicked tab
            $(this).addClass('active');
            
            // Hide all tab contents
            $('.symbol-tab-content').addClass('hidden');
            // Show selected tab content
            $('#' + tab + '-tab').removeClass('hidden');
        });

        // Mobile Symbol Tabs Functionality
        $('.mobile-symbol-tab-btn').click(function() {
            const tab = $(this).data('tab');
            
            // Remove active class from all mobile tabs
            $('.mobile-symbol-tab-btn').removeClass('active');
            // Add active class to clicked tab
            $(this).addClass('active');
            
            // Hide all mobile tab contents
            $('.mobile-currency-tab-content').addClass('hidden');
            // Show selected tab content
            $('#mobile-' + tab + '-tab').removeClass('hidden');
        });

        // Auto-select correct tab based on active symbol
        function selectTabForActiveSymbol() {
            const activeSymbol = $('.symbol-item.symbol-active');
            if (activeSymbol.length > 0) {
                const symbolType = activeSymbol.data('type');
                let targetTab = 'crypto'; // default
                
                if (symbolType === 'usa' || symbolType === 'stock') {
                    targetTab = 'usa';
                } else if (symbolType === 'forex') {
                    targetTab = 'forex';
                }
                
                // Update desktop tabs
                $('.symbol-tab-btn').removeClass('active');
                $(`.symbol-tab-btn[data-tab="${targetTab}"]`).addClass('active');
                $('.symbol-tab-content').addClass('hidden');
                $(`#${targetTab}-tab`).removeClass('hidden');
                
                // Update mobile tabs
                $('.mobile-symbol-tab-btn').removeClass('active');
                $(`.mobile-symbol-tab-btn[data-tab="${targetTab}"]`).addClass('active');
                $('.mobile-currency-tab-content').addClass('hidden');
                $(`#mobile-${targetTab}-tab`).removeClass('hidden');
            }
        }

        // Initialize tab selection
        selectTabForActiveSymbol();

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
                    user_id: @json(auth()->user()->id ?? 0),
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
                                "linear-gradient(to right, #3ddeea, #3ddeea)" : "linear-gradient(to right, #e04b48, #CD5C5C)",
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

                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            };

            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
            };
        }



        // Helper function to escape symbol for CSS selector
        function escapeSymbolForSelector(symbol) {
            return symbol.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, '\\$&');
        }

        // Initial connections
        connectWebSocket();

        // Test function to force show dropdown
        window.forceShowDropdown = function() {
            console.log('Force show dropdown called');
            const dropdown = $('#mobile-currency-dropdown');
            const icon = $('#mobile-dropdown-icon');
            
            console.log('Dropdown before force show:', dropdown);
            
            // Toggle dropdown
            if (dropdown.hasClass('show')) {
                closeMobileDropdown();
                console.log('Closing dropdown');
            } else {
                dropdown.addClass('show');
                icon.addClass('rotated');
                console.log('Opening dropdown');
                
                // Focus on search input when opening
                setTimeout(() => {
                    $('#currency-search-input').focus();
                }, 100);
            }
            
            console.log('Dropdown after force show:', dropdown);
        };

        // Function to update current price display
        function updateCurrentPriceDisplay(symbol) {
            // Update current price from symbol data
            const symbolElement = $(`.symbol-item[data-symbol="${symbol}"]`);
            if (symbolElement.length > 0) {
                const priceText = symbolElement.find('.price-display').text();
                const changeText = symbolElement.find('.price-change').text();
                
                // Update mobile current price
                $('#mobile-current-price').text(priceText);
                
                // Update mobile price change
                const priceChangeElement = $('#mobile-current-price-change');
                priceChangeElement.text(changeText);
                
                // Update price change indicator color
                if (changeText.includes('+')) {
                    priceChangeElement.removeClass('negative').addClass('positive');
                } else {
                    priceChangeElement.removeClass('positive').addClass('negative');
                }
                
                // Update main current price
                $('#current-price').text(priceText);
                $('#current-price-change').text(changeText);
            }
        }



        // Mobile Currency Selector
        $(document).on('click', '#mobile-currency-selector', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Mobile currency selector clicked!');
            
            const dropdown = $('#mobile-currency-dropdown');
            const icon = $('#mobile-dropdown-icon');
            
            console.log('Dropdown element:', dropdown);
            console.log('Dropdown length:', dropdown.length);
            console.log('Dropdown HTML:', dropdown.html());
            console.log('Dropdown classes:', dropdown.attr('class'));
            console.log('Dropdown CSS display:', dropdown.css('display'));
            console.log('Dropdown CSS visibility:', dropdown.css('visibility'));
            
            if (dropdown.hasClass('show')) {
                closeMobileDropdown();
                console.log('Closing dropdown');
            } else {
                dropdown.addClass('show');
                icon.addClass('rotated');
                console.log('Opening dropdown');
                console.log('After adding show class:', dropdown.hasClass('show'));
                console.log('After adding show class CSS display:', dropdown.css('display'));
                
                // Add show class to display dropdown
                dropdown.addClass('show');
                
                // Focus on search input when opening
                setTimeout(() => {
                    $('#currency-search-input').focus();
                }, 100);
            }
        });

        // Currency Search Functionality
        $(document).on('input', '#currency-search-input', function() {
            const searchTerm = $(this).val().toLowerCase();
            const clearBtn = $('#clear-search');
            let visibleCount = 0;
            
            if (searchTerm.length > 0) {
                clearBtn.show();
            } else {
                clearBtn.hide();
            }
            
            $('.currency-option').each(function() {
                const symbol = $(this).data('symbol').toLowerCase();
                const name = $(this).data('name').toLowerCase();
                
                if (symbol.includes(searchTerm) || name.includes(searchTerm)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
            
            // Show/hide no results message
            let noResultsMsg = $('.no-results');
            if (noResultsMsg.length === 0) {
                noResultsMsg = $('<div class="no-results">Không tìm thấy symbol nào</div>');
                $('.currency-options-container').append(noResultsMsg);
            }
            
            if (visibleCount === 0 && searchTerm.length > 0) {
                noResultsMsg.show();
            } else {
                noResultsMsg.hide();
            }
        });

        // Clear Search Button
        $(document).on('click', '#clear-search', function() {
            $('#currency-search-input').val('');
            $('.currency-option').show();
            $(this).hide();
            $('#currency-search-input').focus();
        });

        // Handle currency option selection in mobile dropdown
        $(document).on('click', '.currency-option', function() {
            const symbol = $(this).data('symbol');
            const icon = $(this).data('icon');
            const id = $(this).data('id');
            
            console.log('Currency option clicked:', { symbol, icon, id });
            
            // Update symbolActive
            symbolActive = symbol.toLowerCase();
            
            // Update mobile display
            $('#mobile-active-icon').attr('src', icon);
            $('#mobile-active-symbol').text($(this).find('.currency-name').text());
            $('#mobile-currency-selector').attr('data-id', id);
            
            // Update active state in dropdown
            $('.currency-option').removeClass('active');
            $(this).addClass('active');
            
            // Update active state in desktop symbol list
            $('.symbol-item').removeClass('symbol-active').addClass('bg-[#181a20]');
            $(`.symbol-item[data-symbol="${symbol}"]`).removeClass('bg-[#181a20]').addClass('symbol-active');
            
            // Close mobile dropdown
            closeMobileDropdown();
            
            // Update charts
            const randomParam = Math.random().toString(36).substring(7);
            const newSrc = 'https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22' + symbol + '%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D' + symbol + '%22%7D';

            // Update main chart
            $('#trading_view').find('iframe').remove();
            $('#trading_view').append('<iframe src="' + newSrc + '" frameborder="0" allowfullscreen="true" scrolling="no" class="w-full" style="height: 480px;"></iframe>');
            
            // Update chart content
            $('#chart-conten').find('iframe').remove();
            $('#chart-content').html('<iframe src="' + newSrc + '" frameborder="0" allowfullscreen="true" scrolling="no" class="w-full h-full" style="height: 380px;"></iframe>');
            
            // Update mobile chart
            const mobileChartSrc = `https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22${symbol}%22%2C%22interval%22%3A%225%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D${symbol}%22%7D`;
            $('#mobile-chart iframe').attr('src', mobileChartSrc);
            
            // Reconnect depth socket for new symbol
            if (socket) {
                socket.close();
            }
            connectDepthSocket();
            
            // Fetch new order book data
            fetchOrderBook(symbolActive);
            
            // Update current price display
            updateCurrentPriceDisplay(symbol);
            
            // Update can sell amount for new symbol
            setTimeout(() => {
                updateCanSellAmount();
            }, 500);
        });

        // Mobile Navigation Tabs
        $('.tab-item').click(function() {
            $('.tab-item').removeClass('active');
            $(this).addClass('active');

            const tab = $(this).data('tab');

            // Ẩn tất cả các container
            $('#mobile-chart').addClass('hidden');
            $('#mobile-order-book').addClass('hidden');
            $('#mobile-latest-transaction').addClass('hidden');

            // Hiển thị container tương ứng với tab được chọn
            if (tab === 'chart') {
                $('#mobile-chart').removeClass('hidden');
            } else if (tab === 'entrusted') {
                $('#mobile-order-book').removeClass('hidden');
                // Load order book data nếu chưa có
                if ($('#mobile-buy-orders').is(':empty') && $('#mobile-sell-orders').is(':empty')) {
                    loadMobileOrderBook();
                }
            } else if (tab === 'latest') {
                $('#mobile-latest-transaction').removeClass('hidden');
                // Load latest transaction data nếu chưa có
                if ($('#mobile-latest-transaction-content').is(':empty')) {
                    loadMobileLatestTransaction();
                }
            }
        });

        // Order Book Tabs
        $(document).on('click', '.order-book-tabs .order-tab-item', function() {
            $('.order-book-tabs .order-tab-item').removeClass('active');
            $(this).addClass('active');

            const tab = $(this).data('tab');

            // Ẩn tất cả order book content
            $('.order-book-content').removeClass('active');

            // Hiển thị content tương ứng
            if (tab === 'buy') {
                $('#mobile-buy-orders').addClass('active');
            } else if (tab === 'sell') {
                $('#mobile-sell-orders').addClass('active');
            }
        });

        // Mobile Timeframe Selector
        $('.timeframe-item').click(function() {
            $('.timeframe-item').removeClass('active');
            $(this).addClass('active');

            const timeframe = $(this).data('timeframe');
            // Cập nhật biểu đồ với timeframe mới
            updateChartTimeframe(timeframe);
        });

        // Function to update chart timeframe
        function updateChartTimeframe(timeframe) {
            const symbol = symbolActive;
            const newSrc = `https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22${symbol}%22%2C%22interval%22%3A%22${timeframe}%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D${symbol}%22%7D`;

            $('#mobile-chart iframe').attr('src', newSrc);
        }

        // Function to load mobile order book
        function loadMobileOrderBook() {
            $.ajax({
                url: `{{env('API_URL')}}/binance/depth/${symbolActive.toUpperCase()}`,
                method: 'GET',
                success: function(data) {
                    updateMobileOrderBook(data);
                },
                error: function(error) {
                    console.error('Error fetching mobile order book:', error);
                    $('#mobile-buy-orders').html('<div class="text-gray-400 text-center py-4">Không thể tải dữ liệu</div>');
                    $('#mobile-sell-orders').html('<div class="text-gray-400 text-center py-4">Không thể tải dữ liệu</div>');
                }
            });
        }

        // Function to update mobile order book
        function updateMobileOrderBook(data) {
            // Kiểm tra data và các thuộc tính cần thiết
            if (!data || !data.bids || !data.asks) {
                console.warn('Invalid data for mobile order book:', data);
                $('#mobile-buy-orders').html('<div class="text-gray-400 text-center py-4">Không có dữ liệu order book</div>');
                $('#mobile-sell-orders').html('<div class="text-gray-400 text-center py-4">Không có dữ liệu order book</div>');
                return;
            }

            // Kiểm tra xem bids và asks có phải là array không
            if (!Array.isArray(data.bids) || !Array.isArray(data.asks)) {
                console.warn('Bids or asks is not an array:', {
                    bids: data.bids,
                    asks: data.asks
                });
                $('#mobile-buy-orders').html('<div class="text-gray-400 text-center py-4">Dữ liệu không hợp lệ</div>');
                $('#mobile-sell-orders').html('<div class="text-gray-400 text-center py-4">Dữ liệu không hợp lệ</div>');
                return;
            }

            const bids = data.bids.slice(0, 8).map(bid => ({
                price: parseFloat(bid[0]),
                quantity: parseFloat(bid[1])
            })) || [];
            const asks = data.asks.slice(0, 8).map(ask => ({
                price: parseFloat(ask[0]),
                quantity: parseFloat(ask[1])
            })) || [];

            // Kiểm tra nếu không có dữ liệu
            if (bids.length === 0 && asks.length === 0) {
                $('#mobile-buy-orders').html('<div class="text-gray-400 text-center py-4">Không có dữ liệu order book</div>');
                $('#mobile-sell-orders').html('<div class="text-gray-400 text-center py-4">Không có dữ liệu order book</div>');
                return;
            }

            const maxVolume = Math.max(
                ...asks.map(ask => ask.quantity),
                ...bids.map(bid => bid.quantity)
            );

            // Update Buy Orders (Bids)
            let buyOrdersHtml = '';
            if (bids.length > 0) {
                bids.forEach(bid => {
                    const volume = bid.quantity;
                    const widthPercent = (volume / maxVolume) * 100;

                    buyOrdersHtml += `
                        <div class="flex mb-2 rounded-md relative overflow-hidden">
                            <span class="w-1/3 text-[#3ddeea] z-10 text-xs">${bid.price.toFixed(2)}</span>
                            <span class="w-1/3 z-10 text-xs text-white">${volume.toFixed(6)}</span>
                            <span class="w-1/3 z-10 text-xs text-white text-right">${(bid.price * volume).toFixed(2)}</span>
                            <div class="absolute top-0 right-0 h-full bg-gradient-to-r from-[#3ddeea]/50 to-[#3ddeea]/50 rounded-md z-0" style="width: ${widthPercent}%;"></div>
                        </div>
                    `;
                });
            } else {
                buyOrdersHtml = '<div class="text-gray-400 text-center py-4">Không có lệnh mua</div>';
            }

            // Update Sell Orders (Asks)
            let sellOrdersHtml = '';
            if (asks.length > 0) {
                asks.forEach(ask => {
                    const volume = ask.quantity;
                    const widthPercent = (volume / maxVolume) * 100;
                    const price = ask.price;
                    if (isNaN(price)) return;

                    sellOrdersHtml += `
                        <div class="flex mb-2 rounded-md relative overflow-hidden">
                            <span class="w-1/3 text-[#e04b48] z-10 text-xs">${price.toFixed(2)}</span>
                            <span class="w-1/3 z-10 text-xs text-white">${volume.toFixed(6)}</span>
                            <span class="w-1/3 z-10 text-xs text-white text-right">${(price * volume).toFixed(2)}</span>
                            <div class="absolute top-0 right-0 h-full bg-gradient-to-r from-[#CD5C5C]/50 to-[#e04b48]/50 rounded-md z-0" style="width: ${widthPercent}%;"></div>
                        </div>
                    `;
                });
            } else {
                sellOrdersHtml = '<div class="text-gray-400 text-center py-4">Không có lệnh bán</div>';
            }

            // Add current price info to both tabs
            const currentPriceHtml = `
                <div class="font-bold text-sm my-2 border-t border-gray-700 pt-2">
                    <span class="w-1/3 text-gray-400">Giá hiện tại:</span>
                    <span class="w-1/3 text-center text-white font-semibold">${data.currentPrice ? data.currentPrice.toFixed(2) : (lastPrice || 0).toFixed(2)}</span>
                    <span class="w-1/3 text-right text-gray-400" id="mobile-icon-arrow">
                        <i class="fa-solid fa-arrow-up"></i>
                    </span>
                </div>
            `;

            try {
                $('#mobile-buy-orders').html(buyOrdersHtml + currentPriceHtml);
                $('#mobile-sell-orders').html(sellOrdersHtml + currentPriceHtml);
            } catch (error) {
                console.error('Error updating mobile order book content:', error);
            }
        }

        // Function to load mobile latest transaction
        function loadMobileLatestTransaction() {
            // Hiển thị loading
            $('#mobile-latest-transaction-content').html(`
                <div class="latest-transaction-empty">
                    <i class="fas fa-spinner fa-spin text-[#3ddeea]"></i>
                    <p class="text-white">Đang tải dữ liệu...</p>
                    <p class="text-sm text-gray-400">Vui lòng chờ trong giây lát</p>
                </div>
            `);

            // Fetch latest transactions from API
            $.ajax({
                url: "{{ route('loadMoreTrades') }}",
                type: "GET",
                data: {
                    page: 1,
                    is_mobile: true,
                    limit: 20 // Giới hạn 20 giao dịch gần nhất
                },
                success: function(response) {
                    if (response.html) {
                        // Parse HTML và tạo giao diện latest transaction
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = response.html;
                        const tradeCards = tempDiv.querySelectorAll('.view-detail');

                        let latestTransactionHtml = '';

                        if (tradeCards.length > 0) {
                            // Thêm header cho danh sách
                            latestTransactionHtml += `
                                <div class="flex items-center justify-between p-2 bg-[#181a20] rounded-lg mb-3 border border-[#232428]">
                                    <span class="text-gray-400 text-xs font-medium">Tổng cộng: ${tradeCards.length} giao dịch</span>
                                    <span class="text-gray-400 text-xs">Cập nhật: ${new Date().toLocaleTimeString('vi-VN')}</span>
                                </div>
                            `;

                            tradeCards.forEach((card, index) => {
                                const tradeData = card.dataset;
                                const tradeTime = new Date(tradeData.openTime);
                                const formattedTime = tradeTime.toLocaleTimeString('vi-VN', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });

                                const orderType = tradeData.type === 'buy' ? 'Mua' : 'Bán';
                                const orderTypeClass = tradeData.type === 'buy' ? 'text-[#3ddeea]' : 'text-[#e04b48]';
                                const orderTypeBg = tradeData.type === 'buy' ? 'bg-[#3ddeea]/20' : 'bg-[#e04b48]/20';

                                const price = parseFloat(tradeData.openPrice).toFixed(2);
                                const amount = parseFloat(tradeData.amount).toFixed(2);

                                latestTransactionHtml += `
                                    <div class="latest-transaction-item flex items-center justify-between p-3 bg-[#181a20] rounded-lg mb-2 border-l-4 ${tradeData.type === 'buy' ? 'border-[#3ddeea]' : 'border-[#e04b48]'}">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-white text-sm font-medium">${orderType}</span>
                                                <span class="text-gray-400 text-xs">${formattedTime}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-400">Giá: <span class="text-white">${price}</span></span>
                                                <span class="text-gray-400">Số lượng: <span class="text-white">${amount}</span></span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="w-3 h-3 rounded-full ${orderTypeBg} flex items-center justify-center">
                                                <i class="fas fa-${tradeData.type === 'buy' ? 'arrow-up' : 'arrow-down'} text-xs ${orderTypeClass}"></i>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            latestTransactionHtml = `
                                <div class="latest-transaction-empty">
                                    <i class="fas fa-chart-line text-gray-400"></i>
                                    <p class="text-white">Không có giao dịch nào</p>
                                    <p class="text-sm text-gray-400">Chưa có lịch sử giao dịch</p>
                                </div>
                            `;
                        }

                        $('#mobile-latest-transaction-content').html(latestTransactionHtml);
                    } else {
                        $('#mobile-latest-transaction-content').html(`
                            <div class="latest-transaction-empty">
                                <i class="fas fa-exclamation-triangle text-[#e04b48]"></i>
                                <p class="text-white">Không thể tải dữ liệu</p>
                                <p class="text-sm text-gray-400">Vui lòng thử lại sau</p>
                            </div>
                        `);
                    }
                },
                error: function(error) {
                    console.error('Error fetching latest transactions:', error);
                    $('#mobile-latest-transaction-content').html(`
                        <div class="latest-transaction-empty">
                            <i class="fas fa-exclamation-triangle text-[#e04b48]"></i>
                            <p class="text-white">Lỗi khi tải dữ liệu</p>
                            <p class="text-sm text-gray-400">Vui lòng thử lại sau</p>
                        </div>
                    `);
                }
            });
        }

        // Mobile Action Buttons - Prevent duplicate calls
        $(document).off('click', '#mobile-buy-up').on('click', '#mobile-buy-up', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Mở modal trading mobile
            $('#mobile-trading-modal').removeClass('translate-y-full');
            // Set type trade là buy
            $('#mobile-trading-direction').text('Buy Up');
            $('#mobile-submit-trade').data('type', 'buy');
            $('#mobile-submit-trade .btn-text').text('Buy Up');
            $('#mobile-submit-trade').removeClass('btn-sell').addClass('btn-buy');
            
            // Reset form state
            $('#mobile-transaction-amount').val('');
            $('#mobile-quantity').val('');
            $('#mobile-percentage-slider').val(0);
            $('#mobile-slider-active-track').css('width', '0%');
            $('#mobile-trading-amount').text('$0');
            $('#mobile-transaction-amount-display').text('$0');
            $('#mobile-quality-display').text('--');
            
            // Reset processing flag when opening modal
            isProcessingMobileTrade = false;
            
            // Update quantity display when opening modal
            if (lastPrice > 0) {
                $('#mobile-quality-display').text('--');
            }
        });

        $(document).off('click', '#mobile-buy-down').on('click', '#mobile-buy-down', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Mở modal trading mobile
            $('#mobile-trading-modal').removeClass('translate-y-full');
            // Set type trade là sell
            $('#mobile-submit-trade').data('type', 'sell');
            $('#mobile-submit-trade').removeClass('btn-buy').addClass('btn-sell');
            $('#mobile-submit-trade .btn-text').text('Buy Down');
            
            // Reset form state
            $('#mobile-transaction-amount').val('');
            $('#mobile-quantity').val('');
            $('#mobile-percentage-slider').val(0);
            $('#mobile-slider-active-track').css('width', '0%');
            $('#mobile-trading-amount').text('$0');
            $('#mobile-transaction-amount-display').text('$0');
            $('#mobile-quality-display').text('--');
            
            // Reset processing flag when opening modal
            isProcessingMobileTrade = false;
            
            // Update quantity display when opening modal
            if (lastPrice > 0) {
                $('#mobile-quality-display').text('--');
            }
        });

        // Close modal
        $('#mobile-modal-close, #mobile-modal-backdrop').click(function() {
            $('#mobile-trading-modal').addClass('translate-y-full');
            
            // Reset form state and processing flag
            isProcessingMobileTrade = false;
            $('#mobile-transaction-amount').val('');
            $('#mobile-quantity').val('');
            $('#mobile-percentage-slider').val(0);
            $('#mobile-slider-active-track').css('width', '0%');
            $('#mobile-trading-amount').text('$0');
            $('#mobile-transaction-amount-display').text('$0');
            $('#mobile-quality-display').text('--');
        });
        
        // Prevent form submission on other modal elements
        $('#mobile-trading-modal').on('click', function(e) {
            if ($(e.target).closest('#mobile-submit-trade').length === 0 && 
                $(e.target).closest('#mobile-modal-close').length === 0 && 
                $(e.target).closest('#mobile-modal-backdrop').length === 0) {
                // Prevent any form submission when clicking on other elements
                e.preventDefault();
                e.stopPropagation();
            }
        });

        // Handle percentage slider
        $('#mobile-percentage-slider').on('input', function() {
            const percentage = $(this).val();
            const balance = parseFloat('{{ auth()->check() ? Auth::user()->balance : 0 }}') || 0;
            const amount = (balance * percentage) / 100;
            
            $('#mobile-slider-active-track').css('width', percentage + '%');
            $('#mobile-trading-amount').text('$' + amount.toFixed(2));
            
            // Auto-calculate quantity based on current symbol price
            if (amount > 0 && lastPrice > 0) {
                const quantity = amount / lastPrice;
                $('#mobile-quantity').val(quantity.toFixed(6));
                $('#mobile-quality-display').text(quantity.toFixed(6));
            } else {
                $('#mobile-quantity').val('');
                $('#mobile-quality-display').text('--');
            }
        });
        
        // Prevent form submission on slider interaction
        $('#mobile-percentage-slider').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });


        // Handle transaction amount input
        $('#mobile-transaction-amount').on('input', function() {
            let amount = parseFloat($(this).val()) || 0;
            const balance = parseFloat('{{ auth()->check() ? Auth::user()->balance : 0 }}') || 0;
            
            // Check if amount exceeds balance and adjust to max balance
            if (amount > balance) {
                amount = balance;
                $(this).val(amount.toFixed(2));
            }
            
            $('#mobile-transaction-amount-display').text('$' + amount.toFixed(2));
            
            // Auto-calculate quantity based on current symbol price
            if (amount > 0 && lastPrice > 0) {
                const quantity = amount / lastPrice;
                $('#mobile-quantity').val(quantity.toFixed(6));
                $('#mobile-quality-display').text(quantity.toFixed(6));
            } else {
                $('#mobile-quantity').val('');
                $('#mobile-quality-display').text('--');
            }
            
            // Update percentage slider
            if (balance > 0) {
                const percentage = Math.min((amount / balance) * 100, 100);
                $('#mobile-percentage-slider').val(percentage);
                $('#mobile-slider-active-track').css('width', percentage + '%');
                $('#mobile-trading-amount').text('$' + amount.toFixed(2));
            }
        });

        // Handle quantity input for mobile form
        $('#mobile-quantity').on('input', function() {
            const quantity = parseFloat($(this).val()) || 0;
            
            // Auto-calculate transaction amount based on current symbol price
            if (quantity > 0 && lastPrice > 0) {
                let amount = quantity * lastPrice;
                const balance = parseFloat('{{ auth()->check() ? Auth::user()->balance : 0 }}') || 0;
                
                // Check if calculated amount exceeds balance and adjust
                if (amount > balance) {
                    amount = balance;
                    // Recalculate quantity based on adjusted amount
                    const adjustedQuantity = balance / lastPrice;
                    $(this).val(adjustedQuantity.toFixed(6));
                    $('#mobile-quality-display').text(adjustedQuantity.toFixed(6));
                }
                
                $('#mobile-transaction-amount').val(amount.toFixed(2));
                $('#mobile-transaction-amount-display').text('$' + amount.toFixed(2));
                
                // Update percentage slider if balance is available
                if (balance > 0) {
                    const percentage = Math.min((amount / balance) * 100, 100);
                    $('#mobile-percentage-slider').val(percentage);
                    $('#mobile-slider-active-track').css('width', percentage + '%');
                    $('#mobile-trading-amount').text('$' + amount.toFixed(2));
                }
            } else {
                $('#mobile-transaction-amount').val('');
                $('#mobile-transaction-amount-display').text('$0');
                $('#mobile-percentage-slider').val(0);
                $('#mobile-slider-active-track').css('width', '0%');
                $('#mobile-trading-amount').text('$0');
            }
        });

        // Handle quality selection
        $('#mobile-quality').on('change', function() {
            const quality = $(this).val();
            $('#mobile-quality-display').text(quality || '--');
        });

        // Handle trading range change
        $('#mobile-trading-range').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const winRate = selectedOption.data('win-rate');
            $('#mobile-trading-yield').text(winRate + '%');
        });
        
        // Prevent form submission on select change
        $('#mobile-trading-range').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });

        // Handle form submission - Prevent duplicate calls
        $(document).off('click', '#mobile-submit-trade').on('click', '#mobile-submit-trade', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const button = $(this);
            
            // Prevent multiple clicks and duplicate processing
            if (button.prop('disabled') || isProcessingMobileTrade) {
                return;
            }
            
            // Set processing flag
            isProcessingMobileTrade = true;
            
            const buttonText = button.find('.btn-text');
            const spinner = button.find('i');
            const type = button.data('type');
            const timeId = $('#mobile-trading-range').val();

            // Lấy symbol cho mobile
            let symbol = null;
            // Lấy symbol từ input hidden hoặc từ symbol item đang active
            symbol = $('#symbol-active-data').val();
            if (!symbol) {
                const activeSymbolItem = $('.symbol-item.symbol-active');
                if (activeSymbolItem.length) {
                    symbol = activeSymbolItem.data('symbol');
                }
            }
            // Fallback: lấy từ mobile currency selector
            if (!symbol && $('.currency-selector-mobile .currency-pair').length) {
                symbol = $('.currency-selector-mobile .currency-pair').first().data('id');
            }

            // Validate inputs
            if (!amount || amount <= 0) {
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

            const transactionAmount = parseFloat($('#mobile-transaction-amount').val()) || 0;
            if (!transactionAmount || transactionAmount <= 0) {
                Toastify({
                    text: "Vui lòng nhập Transaction Amount",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return;
            }

            const quality = $('#mobile-quality').val();
            if (!quality) {
                Toastify({
                    text: "Vui lòng chọn Quality",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return;
            }

            if (!timeId) {
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

            if (!type) {
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

            if (!symbol) {
                Toastify({
                    text: "Vui lòng chọn cặp giao dịch",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return;
            }

            // Show loading state and disable button
            button.prop('disabled', true);
            buttonText.text("{{ __('index.processing') }}...");
            spinner.removeClass('hidden');

            // Make API call
            $.ajax({
                url: "{{ route('spot-trading.place-spot-order') }}",
                type: "POST",
                dataType: "json",
                data: {
                    amount: transactionAmount,
                    type: type,
                    symbol_id: symbol,
                    last_price: lastPrice,
                    quantity: quality,
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
                    
                    // Close modal
                    $('#mobile-trading-modal').addClass('translate-y-full');
                    
                    // Update balance display
                    if (response.new_balance !== undefined) {
                        $('.balance-value').text(formatAmount(response.new_balance));
                    }
                    
                    // Show success notification
                    Toastify({
                        text: `Giao dịch ${response.trade.type === 'buy' ? 'mua' : 'bán'} ${response.trade.amount} ${response.trade.symbol.symbol} thành công!`,
                        duration: 5000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();

                    // Reload page data
                    reloadPage(['.balance-value', '.history-card', '#history-table', '#history-card-body'], ['.balance-value', '.history-card', '#history-table', '#history-card-body']);
                },
                error: function(response) {
                    Toastify({
                        text: response.responseJSON && response.responseJSON.message ? response.responseJSON.message : 'Có lỗi xảy ra',
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();
                },
                complete: function() {
                    // Reset button state and processing flag
                    button.prop('disabled', false);
                    buttonText.text(type === 'buy' ? 'Buy Up' : 'Buy Down');
                    spinner.addClass('hidden');
                    isProcessingMobileTrade = false;
                }
            });
        });

        // Refresh Latest Transaction Button
        $('#refresh-latest-transaction').click(function() {
            const button = $(this);
            const icon = button.find('i');
            const text = button.find('span');

            // Disable button và hiển thị loading
            button.prop('disabled', true);
            icon.removeClass('fa-sync-alt').addClass('fa-spinner fa-spin');
            text.text('Đang tải...');

            // Reload latest transaction data
            loadMobileLatestTransaction();

            // Re-enable button sau 2 giây
            setTimeout(function() {
                button.prop('disabled', false);
                icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
                text.text('Làm mới');
            }, 2000);
        });



        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.currency-selector-mobile').length) {
                closeMobileDropdown();
            }
            
            // Close mobile trading modal when clicking outside
            if (!$(e.target).closest('#mobile-trading-modal').length && !$(e.target).closest('#mobile-buy-up').length && !$(e.target).closest('#mobile-buy-down').length) {
                if (!$('#mobile-trading-modal').hasClass('translate-y-full')) {
                    $('#mobile-trading-modal').addClass('translate-y-full');
                    
                    // Reset form state and processing flag
                    isProcessingMobileTrade = false;
                    $('#mobile-transaction-amount').val('');
                    $('#mobile-quantity').val('');
                    $('#mobile-percentage-slider').val(0);
                    $('#mobile-slider-active-track').css('width', '0%');
                    $('#mobile-trading-amount').text('$0');
                    $('#mobile-transaction-amount-display').text('$0');
                    $('#mobile-quality-display').text('--');
                }
            }
        });

        // Function to close mobile dropdown
        function closeMobileDropdown() {
            const dropdown = $('#mobile-currency-dropdown');
            const icon = $('#mobile-dropdown-icon');
            
            dropdown.removeClass('show');
            icon.removeClass('rotated');
            
            // Clear search
            $('#currency-search-input').val('');
            $('.currency-option').show();
            $('#clear-search').hide();
        }

        // Close dropdown with ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#mobile-currency-dropdown').hasClass('show')) {
                closeMobileDropdown();
            }
        });

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
        let isProcessingMobileTrade = false; // Prevent duplicate mobile trade calls
        
        // Initialize timeout array for managing reconnect timeouts
        window.tickerReconnectTimeouts = [];
        
        // Forex symbols will use static data only (no API polling needed)
        
        // Function to check websocket health
        function checkWebsocketHealth() {
            let healthyCount = 0;
            let totalCount = 0;
            
            if (socket && socket.readyState === WebSocket.OPEN) {
                healthyCount++;
            }
            totalCount++;
            
            socketTickerMap.forEach((ws, symbol) => {
                totalCount++;
                if (ws && ws.readyState === WebSocket.OPEN) {
                    healthyCount++;
                }
            });
            
            console.log(`📊 Websocket Health: ${healthyCount}/${totalCount} connections healthy`);
            return healthyCount === totalCount;
        }

        // Helper function to close all websockets cleanly
        function closeAllWebsockets() {
            console.log('🔄 Closing all websocket connections...');
            
            // Set flag to prevent new connections while closing
            window.isClosingWebsockets = true;
            
            // Close depth socket
            if (socket && socket.readyState === WebSocket.OPEN) {
                console.log('📡 Closing depth socket...');
                socket.close();
                socket = null;
            }
            
            // Close all ticker websockets
            let closedCount = 0;
            socketTickerMap.forEach((ws, symbolKey) => {
                if (ws && ws.readyState === WebSocket.OPEN) {
                    console.log(`📡 Closing ticker socket for ${symbolKey}...`);
                    ws.close();
                    closedCount++;
                }
            });
            socketTickerMap.clear();
            console.log(`✅ Closed ${closedCount} ticker websockets`);
            
            
            // Stop all forex API polling
            stopAllForexApiPolling();
            
            // Clear all reconnect timeouts
            if (window.tickerReconnectTimeouts && window.tickerReconnectTimeouts.length > 0) {
                console.log(`⏰ Clearing ${window.tickerReconnectTimeouts.length} reconnect timeouts...`);
                window.tickerReconnectTimeouts.forEach(timeoutId => {
                    clearTimeout(timeoutId);
                });
                window.tickerReconnectTimeouts = [];
            }
            
            // Wait a bit before allowing new connections
            setTimeout(() => {
                window.isClosingWebsockets = false;
                console.log('⏳ Ready for new websocket connections');
            }, 500);
            
            console.log('✅ All websocket connections closed successfully');
        }

        // Function to handle forex symbols (no API polling)
        function startForexApiPolling(symbol) {
            console.log(`🌍 Symbol ${symbol} is forex - no API polling needed`);
            // Forex symbols will use static data only
            // No real-time updates or API calls
        }

        // Function to handle forex symbols (no polling to stop)
        function stopForexApiPolling(symbol) {
            console.log(`🌍 Symbol ${symbol} is forex - no polling to stop`);
            // No polling to stop for forex symbols
        }

        // Function to handle forex symbols (no polling to stop)
        function stopAllForexApiPolling() {
            console.log(`🌍 All forex symbols - no polling to stop`);
            // No polling to stop for forex symbols
        }

        // Function to handle forex data (no API calls)
        function fetchForexData(symbol) {
            console.log(`🌍 Symbol ${symbol} is forex - using static data only`);
            // Forex symbols will use static data from the initial page load
            // No real-time updates for forex symbols
        }

        // Function to handle forex data processing (no real-time updates)
        function processForexData(symbol, data) {
            console.log(`🌍 Processing forex data for ${symbol} - static mode`);
            // No real-time processing for forex symbols
            // Data will remain static from initial page load
        }

        function connectDepthSocket() {
            // Check if we're in the middle of closing websockets
            if (window.isClosingWebsockets) {
                console.log('⏳ Skipping depth socket connection - websockets are being closed');
                return;
            }

            console.log('🔌 Creating depth websocket for symbol:', symbolActive);
            socket = new WebSocket("{{env('WEBSOCKET_URL')}}?symbols=" + JSON.stringify([symbolActive]) + "&depth=true");

            socket.onmessage = handleOrderBookMessage;

            socket.onclose = function() {
                console.log('Depth WebSocket closed');
                // Only reconnect if we're not closing websockets
                if (!window.isClosingWebsockets) {
                    setTimeout(connectDepthSocket, 1000);
                }
            };

            socket.onerror = function(error) {
                console.error('Depth WebSocket error:', error);
            };
        }

        function connectTickerSocket(symbol) {
            // Check if we're in the middle of closing websockets
            if (window.isClosingWebsockets) {
                console.log(`⏳ Skipping connection for ${symbol} - websockets are being closed`);
                return;
            }

            // Close existing websocket if it exists
            if (socketTickerMap.has(symbol)) {
                const existingWs = socketTickerMap.get(symbol);
                if (existingWs && existingWs.readyState === WebSocket.OPEN) {
                    console.log(`🔄 Closing existing websocket for ${symbol}`);
                    existingWs.close();
                }
                socketTickerMap.delete(symbol);
            }

            // Add a small delay to ensure previous connection is fully closed
            setTimeout(() => {
                if (window.isClosingWebsockets) {
                    console.log(`⏳ Skipping connection for ${symbol} - websockets are being closed`);
                    return;
                }

                console.log(`🔌 Creating new websocket for ${symbol}`);
                const ws = new WebSocket(`{{env('WEBSOCKET_URL')}}?symbols=${JSON.stringify([symbol.toLowerCase()])}`);

                ws.onmessage = (event) => {
                    let data = JSON.parse(event.data);
                    if (data.type == 'marketData') {
                        data = data.data;

                        // Debug logging
                        console.log(`📊 Received data for ${symbol}:`, data);

                        // Update price change for symbol
                        const priceChangeElement = $('#price-change-' + symbol);
                        if (priceChangeElement.length > 0) {
                            priceChangeElement.text(data.P + '%');
                            priceChangeElement.removeClass('text-[#3ddeea] text-[#e04b48]');
                            priceChangeElement.addClass(parseFloat(data.P) > 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]');
                            console.log(`✅ Updated price change for ${symbol}: ${data.P}%`);
                        } else {
                            console.warn(`⚠️ Price change element not found for ${symbol}: #price-change-${symbol}`);
                        }

                        // Update price display for symbol
                        $('#price-' + symbol).text(parseFloat(data.c).toFixed(2));

                        // Update mobile price display
                        $('#mobile-price-' + symbol).text(parseFloat(data.c).toFixed(2));
                        $('#mobile-price-change-' + symbol).text((data.P > 0 ? '+' : '') + data.P + '%');
                        $('#mobile-price-change-' + symbol).removeClass('positive negative').addClass(data.P > 0 ? 'positive' : 'negative');

                        if (symbol.toLowerCase() == symbolActive) {
                            handleTickerMessage(data);
                            lastPrice = parseFloat(data.c);
                            let difference = parseFloat(data.c) - parseFloat(data.o);
                            let percentage = (difference / parseFloat(data.o)) * 100;
                            lastPriceChange = percentage;
                        }

                        $(`.last-price-${symbol}`).each(function() {
                            let symbol1 = $(this).data('symbol');
                            if (symbol1 == symbol) {
                                const closePrice = parseFloat(data.c);
                                const openPrice = parseFloat($('.open-price-' + symbol).text().replace(/,/g, ''));
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
                    // Only reconnect if the symbol is still in the map and we're not closing
                    if (socketTickerMap.has(symbol) && !window.isClosingWebsockets) {
                        const timeoutId = setTimeout(() => connectTickerSocket(symbol), 1000);
                        if (!window.tickerReconnectTimeouts) {
                            window.tickerReconnectTimeouts = [];
                        }
                        window.tickerReconnectTimeouts.push(timeoutId);
                    }
                };

                ws.onerror = function(error) {
                    console.error(`Ticker WebSocket error for ${symbol}:`, error);
                    // Close the websocket on error to prevent hanging connections
                    if (ws.readyState === WebSocket.OPEN) {
                        ws.close();
                    }
                };

                socketTickerMap.set(symbol, ws);
            }, 100);
        }

        // Function to update initial price change data
        function updateInitialPriceChangeData() {
            const symbols = JSON.parse(document.getElementById('symbols-data').value);
            symbols.forEach(symbolData => {
                const priceChangeElement = $('#price-change-' + symbolData.symbol);
                if (priceChangeElement.length > 0) {
                    // Update with initial data from server
                    priceChangeElement.text(symbolData.price_change + '%');
                    priceChangeElement.removeClass('text-[#3ddeea] text-[#e04b48]');
                    priceChangeElement.addClass(parseFloat(symbolData.price_change) > 0 ? 'text-[#3ddeea]' : 'text-[#e04b48]');
                    console.log(`📊 Initial price change for ${symbolData.symbol}: ${symbolData.price_change}%`);
                }
            });
        }

        // Initialize connections
        connectDepthSocket();
        const symbols = JSON.parse(document.getElementById('symbols-data').value);
        console.log('📋 Symbols data:', symbols);
        
        // Update initial price change data
        updateInitialPriceChangeData();
        
        for (const symbolData of symbols) {
            console.log(`🔌 Connecting ticker socket for: ${symbolData.symbol}`);
            connectTickerSocket(symbolData.symbol);
        }
        
        // Check websocket health every 30 seconds
        setInterval(checkWebsocketHealth, 30000);

        // Update symbol selection handler with debounce
        let symbolChangeTimeout = null;
        $('.symbol-item').click(function() {
            const symbol = $(this).data('symbol');
            const icon = $(this).data('icon');
            const id = $(this).data('id');
            
            // Clear previous timeout if exists
            if (symbolChangeTimeout) {
                clearTimeout(symbolChangeTimeout);
            }
            
            // Debounce symbol change to prevent rapid switching
            symbolChangeTimeout = setTimeout(() => {
                // Check if symbol is already active
                if (symbolActive === symbol.toLowerCase()) {
                    console.log('Symbol already active, skipping change');
                    return;
                }
                
                console.log(`🔄 Changing to symbol: ${symbol}`);
                symbolActive = symbol.toLowerCase();

                // Update active symbol styling
                $('.symbol-item').removeClass('symbol-active').addClass('bg-[#181a20]');
                $(this).removeClass('bg-[#181a20]').addClass('symbol-active');

                // Update mobile display
                $('#mobile-active-icon').attr('src', icon);
                $('#mobile-active-symbol').text($(this).find('.text-white').first().text());
                $('.currency-option').removeClass('active');
                $(`.currency-option[data-symbol="${symbol}"]`).addClass('active');
                
                // Update current trading symbol display
                $('#current-trading-symbol').text($(this).find('.text-white').first().text());
                $('#current-trading-symbol-image').attr('src', icon);
                $('#current-trading-symbol-code').text(symbol);
                
                // Update hidden input for symbol data
                $('#symbol-active-data').val(symbol);
                $('#symbol-active-data').attr('data-id', id);

                const randomParam = Math.random().toString(36).substring(7);
                const newSrc = 'https://www.tradingview-widget.com/embed-widget/advanced-chart/?locale=vi_VN#%7B%22autosize%22%3Atrue%2C%22symbol%22%3A%22' + symbol + '%22%2C%22interval%22%3A%2215%22%2C%22timezone%22%3A%22Etc%2FUTC%22%2C%22theme%22%3A%22dark%22%2C%22style%22%3A%221%22%2C%22allow_symbol_change%22%3Afalse%2C%22container_id%22%3A%22tradingview_widget_container%22%2C%22support_host%22%3A%22https%3A%2F%2Fwww.tradingview.com%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22utm_source%22%3A%22binex.baonq.dev%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22advanced-chart%22%2C%22page-uri%22%3A%22binex.baonq.dev%2Ftrading-future%3Fsymbol%3D' + symbol + '%22%7D';

                $('#trading_view').find('iframe').remove();
                $('#trading_view').append('<iframe src="' + newSrc + '" frameborder="0" allowfullscreen="true" scrolling="no" class="w-full" style="height: 480px;"></iframe>');
                $('#chart-conten').find('iframe').remove();
                $('#chart-content').html('<iframe src="' + newSrc + '" frameborder="0" allowfullscreen="true" scrolling="no" class="w-full h-full" style="height: 380px;"></iframe>');

                // Close all existing websocket connections
                closeAllWebsockets();

                // Wait for websockets to close before reconnecting
                setTimeout(() => {
                    // Reconnect depth socket for new symbol
                    console.log(`🔄 Reconnecting websockets for symbol: ${symbol}`);
                    connectDepthSocket();

                    // Reconnect ticker sockets for all symbols
                    const symbols = JSON.parse(document.getElementById('symbols-data').value);
                    console.log(`📡 Reconnecting ${symbols.length} ticker websockets...`);
                    for (const symbolData of symbols) {
                        connectTickerSocket(symbolData.symbol);
                    }

                                    // Fetch new order book data
                fetchOrderBook(symbolActive);
                
                // Update quantity for all forms when symbol changes
                setTimeout(() => {
                    updateQuantityOnPriceChange();
                    // Update can sell amount when symbol changes
                    updateCanSellAmount();
                }, 1000); // Wait for new price data to arrive
                }, 600); // Wait 600ms to ensure previous connections are closed
            }, 300); // 300ms debounce delay
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

        // Handle amount input for Buy Up form
        $('.amount-buy-up').on('input', function() {
            let amount = parseFloat($(this).val()) || 0;
            const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
            
            // Check if amount exceeds balance and adjust to max balance
            if (amount > balance) {
                amount = balance;
                $(this).val(amount.toFixed(2));
            }
            
            $('#investment-amount-buy-up').text('$' + amount.toFixed(2));

            // Auto-calculate quantity based on current symbol price
            if (amount > 0 && lastPrice > 0) {
                const quantity = amount / lastPrice;
                $('.quantity-buy-up').val(quantity.toFixed(6));
                $('#quantity-buy-up').text(quantity.toFixed(6));
            } else {
                $('.quantity-buy-up').val('');
                $('#quantity-buy-up').text('--');
            }
            
            // Update percentage slider
            if (balance > 0) {
                const percentage = Math.min((amount / balance) * 100, 100);
                $('#slider-buy-up').val(percentage);
                $('#slider-buy-up-active-track').css('width', percentage + '%');
                updateSliderLabels('buy-up', percentage);
            }

            // Update yield based on selected trading range
            const selectedOption = $('#trading-range-buy-up option:selected');
            const winRate = selectedOption.data('win-rate');
            $('#yield-buy-up').text(winRate + '%');
        });

        // Handle quantity input for Buy Up form
        $('.quantity-buy-up').on('input', function() {
            const quantity = parseFloat($(this).val()) || 0;
            
            // Auto-calculate transaction amount based on current symbol price
            if (quantity > 0 && lastPrice > 0) {
                let amount = quantity * lastPrice;
                const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
                
                // Check if calculated amount exceeds balance and adjust
                if (amount > balance) {
                    amount = balance;
                    // Recalculate quantity based on adjusted amount
                    const adjustedQuantity = balance / lastPrice;
                    $(this).val(adjustedQuantity.toFixed(6));
                    $('#quantity-buy-up').text(adjustedQuantity.toFixed(6));
                }
                
                $('.amount-buy-up').val(amount.toFixed(2));
                $('#investment-amount-buy-up').text('$' + amount.toFixed(2));
                
                // Update percentage slider if balance is available
                if (balance > 0) {
                    const percentage = Math.min((amount / balance) * 100, 100);
                    $('#slider-buy-up').val(percentage);
                    $('#slider-buy-up-active-track').css('width', percentage + '%');
                    updateSliderLabels('buy-up', percentage);
                }
            } else {
                $('.amount-buy-up').val('');
                $('#investment-amount-buy-up').text('$0');
                $('#slider-buy-up').val(0);
                $('#slider-buy-up-active-track').css('width', '0%');
                updateSliderLabels('buy-up', 0);
            }
        });

        // Handle amount input for Buy Down form
        $('.amount-buy-down').on('input', function() {
            let amount = parseFloat($(this).val()) || 0;
            const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
            
            // Check if amount exceeds balance and adjust to max balance
            if (amount > balance) {
                amount = balance;
                $(this).val(amount.toFixed(2));
                
                // Show notification for balance limit
                Toastify({
                    text: `Số tiền vượt quá số dư USDT. Đã điều chỉnh về $${amount.toFixed(2)}`,
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
            }
            
            $('#transaction-amount-buy-down').text('$' + amount.toFixed(2));

            // Auto-calculate quantity based on current symbol price
            if (amount > 0 && lastPrice > 0) {
                const quantity = amount / lastPrice;
                
                // Get user's wallet balance for current symbol
                const currentSymbol = symbolActive.toUpperCase();
                const userWallets = @json(isset($userWallets) ? $userWallets : collect());
                const currentWallet = userWallets.find(wallet => 
                    wallet.symbol && wallet.symbol.symbol === currentSymbol
                );
                const maxQuantity = currentWallet && currentWallet.balance ? parseFloat(currentWallet.balance) : 0;
                
                // Check if calculated quantity exceeds user's wallet balance
                let adjustedQuantity = quantity;
                let adjustedAmount = amount;
                let needsAdjustment = false;
                
                if (quantity > maxQuantity && maxQuantity > 0) {
                    adjustedQuantity = maxQuantity;
                    adjustedAmount = maxQuantity * lastPrice;
                    needsAdjustment = true;
                    
                    // Show notification
                    Toastify({
                        text: `Số lượng vượt quá số dư trong wallet. Đã điều chỉnh về ${maxQuantity.toFixed(6)} ${currentSymbol}`,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();
                }
                
                // Update both amount and quantity fields
                if (needsAdjustment) {
                    $(this).val(adjustedAmount.toFixed(2));
                    $('#transaction-amount-buy-down').text('$' + adjustedAmount.toFixed(2));
                }
                
                $('.quantity-buy-down').val(adjustedQuantity.toFixed(6));
                $('#quantity-buy-down').text(adjustedQuantity.toFixed(6));
            } else {
                $('.quantity-buy-down').val('');
                $('#quantity-buy-down').text('--');
            }
            
            // Update percentage slider
            if (balance > 0) {
                const finalAmount = parseFloat($(this).val()) || 0;
                const percentage = Math.min((finalAmount / balance) * 100, 100);
                $('#slider-buy-down').val(percentage);
                $('#slider-buy-down-active-track').css('width', percentage + '%');
                updateSliderLabels('buy-down', percentage);
            }

            // Update yield based on selected trading range
            const selectedOption = $('#trading-range-buy-down option:selected');
            const winRate = selectedOption.data('win-rate');
            $('#yield-buy-down').text(winRate + '%');
        });

        // Handle quantity input for Buy Down form
        $('.quantity-buy-down').on('input', function() {
            const quantity = parseFloat($(this).val()) || 0;
            
            // Get user's wallet balance for current symbol
            const currentSymbol = symbolActive.toUpperCase();
            const userWallets = @json(isset($userWallets) ? $userWallets : collect());
            const currentWallet = userWallets.find(wallet => 
                wallet.symbol && wallet.symbol.symbol === currentSymbol
            );
            const maxQuantity = currentWallet && currentWallet.balance ? parseFloat(currentWallet.balance) : 0;
            
            // Check if quantity exceeds user's wallet balance
            let adjustedQuantity = quantity;
            if (quantity > maxQuantity && maxQuantity > 0) {
                adjustedQuantity = maxQuantity;
                $(this).val(maxQuantity.toFixed(6));
                $('#quantity-buy-down').text(maxQuantity.toFixed(6));
                
                // Show notification
                Toastify({
                    text: `Số lượng vượt quá số dư trong wallet. Đã điều chỉnh về ${maxQuantity.toFixed(6)} ${currentSymbol}`,
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
            }
            
            // Auto-calculate transaction amount based on adjusted quantity and current symbol price
            if (adjustedQuantity > 0 && lastPrice > 0) {
                const amount = adjustedQuantity * lastPrice;
                
                $('.amount-buy-down').val(amount.toFixed(2));
                $('#transaction-amount-buy-down').text('$' + amount.toFixed(2));
                
                // Update percentage slider if balance is available
                const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
                if (balance > 0) {
                    const percentage = Math.min((amount / balance) * 100, 100);
                    $('#slider-buy-down').val(percentage);
                    $('#slider-buy-down-active-track').css('width', percentage + '%');
                    updateSliderLabels('buy-down', percentage);
                }
            } else {
                $('.amount-buy-down').val('');
                $('#transaction-amount-buy-down').text('$0');
                $('#slider-buy-down').val(0);
                $('#slider-buy-down-active-track').css('width', '0%');
                updateSliderLabels('buy-down', 0);
            }
        });

        // Handle trading range changes for Buy Up
        $('#trading-range-buy-up').change(function() {
            const selectedOption = $(this).find('option:selected');
            const winRate = selectedOption.data('win-rate');
            $('#yield-buy-up').text(winRate + '%');
        });

        // Handle trading range changes for Buy Down
        $('#trading-range-buy-down').change(function() {
            const selectedOption = $(this).find('option:selected');
            const winRate = selectedOption.data('win-rate');
            $('#yield-buy-down').text(winRate + '%');
        });

        // Handle slider for Buy Up
        $('#slider-buy-up').on('input', function() {
            const percentage = $(this).val();
            const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
            const amount = (balance * percentage / 100).toFixed(2);
            $('.amount-buy-up').val(amount);
            $('#investment-amount-buy-up').text('$' + amount);

            // Auto-calculate quantity based on current symbol price
            if (amount > 0 && lastPrice > 0) {
                const quantity = amount / lastPrice;
                $('.quantity-buy-up').val(quantity.toFixed(6));
                $('#quantity-buy-up').text(quantity.toFixed(6));
            } else {
                $('.quantity-buy-up').val('');
                $('#quantity-buy-up').text('--');
            }

            // Update active track width
            $('#slider-buy-up-active-track').css('width', percentage + '%');

            // Update label colors based on percentage
            updateSliderLabels('buy-up', percentage);
        });

        // Handle slider for Buy Down
        $('#slider-buy-down').on('input', function() {
            const percentage = $(this).val();
            const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
            const amount = (balance * percentage / 100).toFixed(2);
            $('.amount-buy-down').val(amount);
            $('#transaction-amount-buy-down').text('$' + amount);

            // Auto-calculate quantity based on current symbol price
            if (amount > 0 && lastPrice > 0) {
                const quantity = amount / lastPrice;
                
                // Get user's wallet balance for current symbol
                const currentSymbol = symbolActive.toUpperCase();
                const userWallets = @json(isset($userWallets) ? $userWallets : collect());
                const currentWallet = userWallets.find(wallet => 
                    wallet.symbol && wallet.symbol.symbol === currentSymbol
                );
                const maxQuantity = currentWallet && currentWallet.balance ? parseFloat(currentWallet.balance) : 0;
                
                // Check if calculated quantity exceeds user's wallet balance
                let adjustedQuantity = quantity;
                let adjustedAmount = amount;
                let needsAdjustment = false;
                
                if (quantity > maxQuantity && maxQuantity > 0) {
                    adjustedQuantity = maxQuantity;
                    adjustedAmount = maxQuantity * lastPrice;
                    needsAdjustment = true;
                    
                    // Show notification
                    Toastify({
                        text: `Số lượng vượt quá số dư trong wallet. Đã điều chỉnh về ${maxQuantity.toFixed(6)} ${currentSymbol}`,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();
                }
                
                // Update both amount and quantity fields if adjustment needed
                if (needsAdjustment) {
                    $('.amount-buy-down').val(adjustedAmount.toFixed(2));
                    $('#transaction-amount-buy-down').text('$' + adjustedAmount.toFixed(2));
                    
                    // Adjust slider to match adjusted amount
                    const adjustedPercentage = Math.min((adjustedAmount / balance) * 100, 100);
                    $(this).val(adjustedPercentage);
                    $('#slider-buy-down-active-track').css('width', adjustedPercentage + '%');
                    updateSliderLabels('buy-down', adjustedPercentage);
                }
                
                $('.quantity-buy-down').val(adjustedQuantity.toFixed(6));
                $('#quantity-buy-down').text(adjustedQuantity.toFixed(6));
            } else {
                $('.quantity-buy-down').val('');
                $('#quantity-buy-down').text('--');
            }

            // Update active track width
            $('#slider-buy-down-active-track').css('width', percentage + '%');

            // Update label colors based on percentage
            updateSliderLabels('buy-down', percentage);
        });

        // Function to update slider label colors
        function updateSliderLabels(sliderType, percentage) {
            const labels = sliderType === 'buy-up' ?
                $('#slider-buy-up').closest('.mb-4').find('.absolute.w-full span') :
                $('#slider-buy-down').closest('.mb-4').find('.absolute.w-full span');

            labels.each(function(index) {
                const labelValue = index * 25;
                if (labelValue <= percentage) {
                    $(this).removeClass('text-gray-400').addClass('text-white');
                } else {
                    $(this).removeClass('text-white').addClass('text-gray-400');
                }
            });
        }

        // Handle Buy Up form submission
        $('.submit-order-buy-up').click(function() {
            const amount = $('.amount-buy-up').val();
            const type = 'buy';
            // Lấy symbol từ input hidden hoặc từ symbol item đang active
            let symbol = $('#symbol-active-data').val();
            if (!symbol) {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbol = activeSymbolItem.data('id');
                }
            }

            // Debug: log symbol để kiểm tra
            console.log('Buy Up - Symbol:', symbol);
            console.log('Buy Up - Symbol from input:', $('#symbol-active-data').val());
            console.log('Buy Up - Active symbol item:', $('.symbol-item.symbol-active').length);

            if (!validateSpotOrder(amount, type, symbol)) return;

            submitSpotOrder(amount, type, symbol);
        });

        // Handle Buy Down form submission
        $('.submit-order-buy-down').click(function() {
            const amount = $('.amount-buy-down').val();
            const type = 'sell';
            // Lấy symbol từ input hidden hoặc từ symbol item đang active
            let symbol = $('#symbol-active-data').data('id');
            if (!symbol) {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbol = activeSymbolItem.data('id');
                }
            }

            // Debug: log symbol để kiểm tra
            console.log('Buy Down - Symbol:', symbol);
            console.log('Buy Down - Symbol from input:', $('#symbol-active-data').val());
            console.log('Buy Down - Active symbol item:', $('.symbol-item.symbol-active').length);

            if (!validateSpotOrder(amount, type, symbol)) return;

            submitSpotOrder(amount, type, symbol);
        });

        // Validation function for spot trading
        function validateSpotOrder(amount, type, symbol) {
            if (!amount || amount <= 0) {
                Toastify({
                    text: "{{ __('index.please_enter_amount') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return false;
            }

            // Kiểm tra symbol
            if (!symbol) {
                Toastify({
                    text: "Vui lòng chọn cặp giao dịch",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return false;
            }

            return true;
        }

        // Validation function for old trading (keep for compatibility)
        function validateOrder(timeId, amount, type) {
            if (!amount || amount <= 0) {
                Toastify({
                    text: "{{ __('index.please_enter_amount') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return false;
            }

            if (!timeId) {
                Toastify({
                    text: "{{ __('index.please_select_time') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return false;
            }

            // Kiểm tra symbol
            let symbol = $('#symbol-active-data').val();
            if (!symbol) {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbol = activeSymbolItem.data('id');
                }
            }
            
            if (!symbol) {
                Toastify({
                    text: "Vui lòng chọn cặp giao dịch",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
                return false;
            }

            return true;
        }

        // Submit spot order function
        function submitSpotOrder(amount, type, symbol) {
            // Show confirmation modal
            $('#confirm-order-modal').removeClass('hidden');
            $('#confirm-balance').text(formatAmount(parseFloat($('.balance-value').text().replace(/[^\d.-]/g, ''))));
            
            // Lấy tên symbol từ input hidden hoặc từ symbol item đang active
            let symbolName = $('#symbol-active-data').val();
            if (symbolName) {
                symbolName = symbolName.toUpperCase();
            } else {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbolName = activeSymbolItem.data('symbol').toUpperCase();
                }
            }
            
            $('#confirm-symbol-name').text((symbolName || 'UNKNOWN') + '/USDT');
            $('#confirm-trade-type').text(type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('#confirm-trade-type').removeClass('text-red-500 text-cyan-500 text-white')
                .addClass(type === 'buy' ? 'text-cyan-500' : 'text-red-500');
            $('#confirm-trade-type-1').text(type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('#confirm-trade-type-1').removeClass('text-red-500 text-cyan-500 text-white')
                .addClass(type === 'buy' ? 'text-cyan-500' : 'text-red-500');
            $('#confirm-current-price').text(formatAmount(lastPrice));
            $('#confirm-trade-amount').text(formatAmount(parseFloat(amount)));

            // Calculate quantity
            const quantity = parseFloat(amount) / lastPrice;
            $('#confirm-expected-profit').text(quantity.toFixed(6) + ' ' + symbolName);
        }

        // Submit order function (keep for compatibility)
        function submitOrder(timeId, amount, type, symbol) {
            // Show confirmation modal
            $('#confirm-order-modal').removeClass('hidden');
            $('#confirm-balance').text(formatAmount(parseFloat($('.balance-value').text().replace(/[^\d.-]/g, ''))));
            // Lấy tên symbol từ input hidden hoặc từ symbol item đang active
            let symbolName = $('#symbol-active-data').val();
            if (symbolName) {
                symbolName = symbolName.toUpperCase();
            } else {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbolName = activeSymbolItem.data('id').toUpperCase();
                }
            }
            $('#confirm-symbol-name').text((symbolName || 'UNKNOWN') + 'USDT');
            $('#confirm-trade-type').text(type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('#confirm-trade-type').removeClass('text-red-500 text-cyan-500 text-white')
                .addClass(type === 'buy' ? 'text-cyan-500' : 'text-red-500');
            $('#confirm-trade-type-1').text(type === 'buy' ? "{{ __('index.buy') }}" : "{{ __('index.sell') }}");
            $('#confirm-trade-type-1').removeClass('text-red-500 text-cyan-500 text-white')
                .addClass(type === 'buy' ? 'text-cyan-500' : 'text-red-500');
            $('#confirm-current-price').text(formatAmount(lastPrice));
            $('#confirm-trade-amount').text(formatAmount(parseFloat(amount)));

            // Calculate expected profit
            const selectedOption = type === 'buy' ? $('#trading-range-buy-up option:selected') : $('#trading-range-buy-down option:selected');
            const winRate = selectedOption.data('win-rate');
            const profit = (parseFloat(amount) * winRate) / 100;
            $('#confirm-expected-profit').text(formatAmount(profit));
        }

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

        function formatAmount(amount) {
            return amount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        $('.submit-order').click(function() {
            const time = $('.btn-time.active').data('time-id');
            const amount = window.innerWidth > 768 ? $('.amount').val() : $('.amount-mobile').val();
            const type = typeTrade;
            // Lấy symbol từ input hidden hoặc từ symbol item đang active
            let symbol = $('#symbol-active-data').val();
            if (!symbol) {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbol = activeSymbolItem.data('id');
                }
            }

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

            // Kiểm tra symbol
            let symbolCheck = $('#symbol-active-data').val();
            if (!symbolCheck) {
                const activeSymbolItem = $('.symbol-item.active');
                if (activeSymbolItem.length) {
                    symbolCheck = activeSymbolItem.data('id');
                }
            }
            
            if (!symbolCheck) {
                Toastify({
                    text: "Vui lòng chọn cặp giao dịch",
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
            // Lấy tên symbol từ input hidden hoặc từ symbol item đang active
            let symbolName = $('#symbol-active-data').val();
            if (symbolName) {
                symbolName = symbolName.toUpperCase();
            } else {
                const activeSymbolItem = $('.symbol-item.symbol-active');
                if (activeSymbolItem.length) {
                    symbolName = activeSymbolItem.data('symbol').toUpperCase();
                }
            }
            $('#confirm-symbol-name').text((symbolName || 'UNKNOWN') + 'USDT');
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
        // Prevent duplicate API calls with flag
        let isProcessingConfirmOrder = false;
        
        // Remove existing handlers and bind new one to prevent duplicates
        $(document).off('click', '#confirm-order').on('click', '#confirm-order', function() {
            // Prevent duplicate calls
            if (isProcessingConfirmOrder) {
                return;
            }
            
            // Set processing flag
            isProcessingConfirmOrder = true;
            
            // Get data from the form that was submitted
            let time, amount, type, symbol;

            // Check which form was used
            if ($('.amount-buy-up').val()) {
                time = $('#trading-range-buy-up').val();
                amount = $('.amount-buy-up').val();
                type = 'buy';
            } else if ($('.amount-buy-down').val()) {
                time = $('#trading-range-buy-down').val();
                amount = $('.amount-buy-down').val();
                type = 'sell';
            } else {
                // Fallback to old form
                time = $('.btn-time.active').data('time-id');
                amount = window.innerWidth > 768 ? $('.amount').val() : $('.amount-mobile').val();
                type = typeTrade;
            }

            // Lấy symbol từ input hidden hoặc từ symbol item đang active
            symbol = $('.symbol-item.symbol-active').data('id');
            console.log('Symbol:', symbol);

            // Hide confirmation modal
            $('#confirm-order-modal').addClass('hidden');

            // Disable button and show loading
            $('.submit-order').prop('disabled', true);
            $('.submit-order').html("<i class='fa-solid fa-spinner fa-spin'></i> {{ __('index.processing') }}...");
            $('#cancel-confirm-order').prop('disabled', true);
            $('#confirm-order').prop('disabled', true);
            $('#confirm-order').html('<i class="fa-solid fa-spinner fa-spin"></i> {{ __("index.processing") }}...');
            
            // Make API call
            $.ajax({
                url: "{{ route('spot-trading.place-spot-order') }}",
                type: "POST",
                data: {
                    amount: amount,
                    type: type,
                    symbol_id: symbol,
                    last_price: lastPrice,
                    quantity: parseFloat(amount) / lastPrice,
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
                    
                    // Close modal
                    $('#mobile-trading-modal').addClass('translate-y-full');
                    
                    // Update balance display
                    if (response.new_balance !== undefined) {
                        $('.balance-value').text(formatAmount(response.new_balance));
                    }
                    
                    // Show success notification
                    Toastify({
                        text: `Giao dịch ${response.trade.type === 'buy' ? 'mua' : 'bán'} ${response.trade.amount} ${response.trade.symbol.symbol} thành công!`,
                        duration: 5000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();

                    // Clear form inputs after successful submission
                    $('.amount-buy-up').val('');
                    $('.amount-buy-down').val('');
                    $('#slider-buy-up').val(0);
                    $('#slider-buy-down').val(0);
                    $('#investment-amount-buy-up').text('$0');
                    $('#transaction-amount-buy-down').text('$0');
                    
                    // Reset quantity fields
                    $('.quantity-buy-up').val('');
                    $('#quantity-buy-up').text('--');
                    $('.quantity-buy-down').val('');
                    $('#quantity-buy-down').text('--');

                    // Reset slider tracks and labels
                    $('#slider-buy-up-active-track').css('width', '0%');
                    $('#slider-buy-down-active-track').css('width', '0%');
                    updateSliderLabels('buy-up', 0);
                    updateSliderLabels('buy-down', 0);

                    reloadPage(['.balance-value', '.history-card', '#history-table', '#history-card-body', '.form-trading'], ['.balance-value', '.history-card', '#history-table', '#history-card-body', '.form-trading']);
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
                    // Reset processing flag
                    isProcessingConfirmOrder = false;
                    
                    $('.submit-order').prop('disabled', false);
                    $('.submit-order').html("{{ __('index.buy') }}");
                    $('#confirm-order').prop('disabled', false);
                    $('#confirm-order').html("{{ __('index.confirm') }}");
                    $('#cancel-confirm-order').prop('disabled', false);
                    $('#cancel-confirm-order').html("{{ __('index.cancel') }}");
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
                        if (window.innerWidth > 768) {
                            column.html('<span class="text-white text-1xl">' + column.data('profit') + '</span>');
                        } else {
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
                if (seconds < 0 || seconds == null || seconds == undefined) {
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

            // Update mobile display
            $('#mobile-current-price').text(parseFloat(data.c).toFixed(2));
            $('#mobile-current-price').css('color', data.P > 0 ? '#3ddeea' : '#e04b48');
            $('#mobile-current-price-change').text((data.P > 0 ? '+' : '') + data.P + '%');
            $('#mobile-current-price-change').removeClass('positive negative').addClass(data.P > 0 ? 'positive' : 'negative');
            $('#mobile-current-price-change i').removeClass('fa-arrow-up fa-arrow-down').addClass(data.P > 0 ? 'fa-arrow-up' : 'fa-arrow-down');
            $('#mobile-high-price').text(parseFloat(data.h).toFixed(2));
            $('#mobile-low-price').text(parseFloat(data.l).toFixed(2));
            $('#mobile-volume').text(formatNumber(data.v));
            $('#mobile-amount').text(formatNumber(data.q));
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

            const bids = data.bids.slice(0, 10).map(bid => ({
                price: parseFloat(bid[0]),
                quantity: parseFloat(bid[1])
            })) || [];
            const asks = data.asks.slice(0, 10).map(ask => ({
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
            if (!data || !data.b || !data.a) return;
            const bids = data?.b.slice(0, 10).map(bid => ({
                price: parseFloat(bid[0]),
                quantity: parseFloat(bid[1])
            })) || [];
            const asks = data?.a.slice(0, 10).map(ask => ({
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

            // Cập nhật mobile order book nếu đang hiển thị
            if (!$('#mobile-order-book').hasClass('hidden')) {
                // Chuyển đổi format data để phù hợp với mobile order book
                const mobileData = {
                    bids: data.b || [],
                    asks: data.a || [],
                    currentPrice: data.currentPrice
                };
                updateMobileOrderBook(mobileData);
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
                            
                            // Reinitialize progress bars for new items
                            updateBetStatus();
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
                                        if (window.innerWidth > 768) {
                                            column.html('<span class="text-[#3ddeea] text-1xl">' + column.data('profit') + '</span>');
                                        } else {
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

        // Function to update crypto investment info
        function updateCryptoInvestmentInfo() {
            // Try to get balance from multiple sources
            let balance = 0;
            
            // Try desktop balance first
            const desktopBalance = $('.balance-value').text();
            if (desktopBalance) {
                balance = parseFloat(desktopBalance.replace(/[^\d.-]/g, '')) || 0;
            }
            
            // If no desktop balance, try mobile balance
            if (balance === 0) {
                const mobileBalance = $('.balance-value').text();
                if (mobileBalance) {
                    balance = parseFloat(mobileBalance.replace(/[^\d.-]/g, '')) || 0;
                }
            }
            
            // Fallback to Laravel variable if still no balance
            if (balance === 0) {
                balance = parseFloat('{{ auth()->check() ? Auth::user()->balance : 0 }}') || 0;
            }
            
            if (balance > 0 && lastPrice > 0) {
                // Calculate how much cryptocurrency can be bought with current balance
                const canBuyAmount = balance / lastPrice;
                
                // Update Buy Up form
                $('#can-buy-amount-buy-up').text(canBuyAmount.toFixed(6) + ' ' + getCurrentSymbolName());
            } else {
                $('#can-buy-amount-buy-up').text('--');
            }
            
            // Update Can Sell amount based on user's wallet balance for current symbol
            updateCanSellAmount();
        }
        
        // Function to update can sell amount based on user's wallet
        function updateCanSellAmount() {
            const currentSymbol = symbolActive.toUpperCase();
            const userWallets = @json(isset($userWallets) ? $userWallets : collect());
            
            // Find wallet for current symbol
            const currentWallet = userWallets.find(wallet => 
                wallet.symbol && wallet.symbol.symbol === currentSymbol
            );
            
            if (currentWallet && currentWallet.balance && parseFloat(currentWallet.balance) > 0) {
                const balance = parseFloat(currentWallet.balance);
                $('#can-sell-amount').text(safeToFixed(balance, 6) + ' ' + currentSymbol);
                $('#mobile-can-sell-amount').text(safeToFixed(balance, 6) + ' ' + currentSymbol);
            } else {
                $('#can-sell-amount').text('-- ' + currentSymbol);
                $('#mobile-can-sell-amount').text('-- ' + currentSymbol);
            }
        }
        
        // Helper function to check and adjust quantity based on wallet balance
        function checkAndAdjustQuantity(quantity, symbol) {
            const userWallets = @json(isset($userWallets) ? $userWallets : collect());
            const currentWallet = userWallets.find(wallet => 
                wallet.symbol && wallet.symbol.symbol === symbol
            );
            const maxQuantity = currentWallet && currentWallet.balance ? parseFloat(currentWallet.balance) : 0;
            
            if (quantity > maxQuantity && maxQuantity > 0) {
                return {
                    adjusted: true,
                    quantity: maxQuantity,
                    message: `Số lượng vượt quá số dư trong wallet. Đã điều chỉnh về ${safeToFixed(maxQuantity, 6)} ${symbol}`
                };
            }
            
            return {
                adjusted: false,
                quantity: quantity,
                message: ''
            };
        }
        
        // Function to get current symbol name
        function getCurrentSymbolName() {
            const symbolElement = $('#current-trading-symbol');
            if (symbolElement.length) {
                return symbolElement.text();
            }
            // Fallback to symbol code
            const symbolCodeElement = $('#current-trading-symbol-code');
            if (symbolCodeElement.length) {
                return symbolElement.text();
            }
            return 'BTC'; // Default fallback
        }

        // Helper function to safely format numbers
        function safeToFixed(value, decimals = 6) {
            if (value === null || value === undefined || isNaN(value)) {
                return '0'.repeat(decimals === 0 ? 1 : decimals + 1);
            }
            const num = parseFloat(value);
            if (isNaN(num)) {
                return '0'.repeat(decimals === 0 ? 1 : decimals + 1);
            }
            return num.toFixed(decimals);
        }

        // Function to update slider labels
        function updateSliderLabels(type, percentage) {
            if (type === 'buy-up') {
                // Update Buy Up slider labels based on percentage
                if (percentage <= 25) {
                    $('#slider-buy-up').siblings().find('.text-xs').removeClass('text-white').addClass('text-gray-400');
                    $('#slider-buy-up').siblings().find('.text-xs').first().removeClass('text-gray-400').addClass('text-white');
                } else if (percentage <= 50) {
                    $('#slider-buy-up').siblings().find('.text-xs').removeClass('text-white').addClass('text-gray-400');
                    $('#slider-buy-up').siblings().find('.text-xs').eq(0).removeClass('text-gray-400').addClass('text-white');
                    $('#slider-buy-up').siblings().find('.text-xs').eq(1).removeClass('text-gray-400').addClass('text-white');
                } else if (percentage <= 75) {
                    $('#slider-buy-up').siblings().find('.text-xs').removeClass('text-white').addClass('text-gray-400');
                    $('#slider-buy-up').siblings().find('.text-xs').eq(0).removeClass('text-gray-400').addClass('text-white');
                    $('#slider-buy-up').siblings().find('.text-xs').eq(1).removeClass('text-gray-400').addClass('text-white');
                    $('#slider-buy-up').siblings().find('.text-xs').eq(2).removeClass('text-gray-400').addClass('text-white');
                } else {
                    $('#slider-buy-up').siblings().find('.text-xs').removeClass('text-gray-400').addClass('text-white');
                }
            } else if (type === 'buy-down') {
                // Update Buy Down slider labels based on percentage
                if (percentage <= 25) {
                    $('#slider-buy-down').siblings().find('.text-xs').removeClass('text-white').addClass('text-gray-400');
                    $('#slider-buy-down').siblings().find('.text-xs').first().removeClass('text-gray-400').addClass('text-white');
                } else if (percentage <= 50) {
                    $('#slider-buy-down').siblings().find('.text-xs').removeClass('text-white').addClass('text-gray-400');
                    $('#slider-buy-down').siblings().find('.text-xs').eq(0).removeClass('text-gray-400').addClass('text-white');
                    $('#slider-buy-down').siblings().find('.text-xs').eq(1).removeClass('text-gray-400').addClass('text-white');
                } else if (percentage <= 75) {
                    $('#slider-buy-down').siblings().find('.text-xs').removeClass('text-white').addClass('text-gray-400');
                    $('#slider-buy-down').siblings().find('.text-xs').eq(0).removeClass('text-gray-400').addClass('text-white');
                    $('#slider-buy-down').siblings().find('.text-xs').eq(1).removeClass('text-gray-400').addClass('text-white');
                    $('#slider-buy-down').siblings().find('.text-xs').eq(2).removeClass('text-gray-400').addClass('text-white');
                } else {
                    $('#slider-buy-down').siblings().find('.text-xs').removeClass('text-gray-400').addClass('text-white');
                }
            }
        }

        // Function to update quantity when price changes
        function updateQuantityOnPriceChange() {
            // Update mobile form quantity
            const mobileAmount = parseFloat($('#mobile-transaction-amount').val()) || 0;
            if (mobileAmount > 0 && lastPrice > 0) {
                const quantity = mobileAmount / lastPrice;
                $('#mobile-quantity').val(quantity.toFixed(6));
                $('#mobile-quality-display').text(quantity.toFixed(6));
            }
            
            // Update desktop Buy Up form quantity
            const buyUpAmount = parseFloat($('.amount-buy-up').val()) || 0;
            if (buyUpAmount > 0 && lastPrice > 0) {
                const quantity = buyUpAmount / lastPrice;
                $('.quantity-buy-up').val(quantity.toFixed(6));
                $('#quantity-buy-up').text(quantity.toFixed(6));
            }
            
            // Update desktop Buy Down form quantity with wallet limit check
            const buyDownAmount = parseFloat($('.amount-buy-down').val()) || 0;
            if (buyDownAmount > 0 && lastPrice > 0) {
                const quantity = buyDownAmount / lastPrice;
                
                // Get user's wallet balance for current symbol
                const currentSymbol = symbolActive.toUpperCase();
                const userWallets = @json(isset($userWallets) ? $userWallets : collect());
                const currentWallet = userWallets.find(wallet => 
                    wallet.symbol && wallet.symbol.symbol === currentSymbol
                );
                const maxQuantity = currentWallet && currentWallet.balance ? parseFloat(currentWallet.balance) : 0;
                
                // Check if calculated quantity exceeds user's wallet balance
                let adjustedQuantity = quantity;
                let adjustedAmount = buyDownAmount;
                let needsAdjustment = false;
                
                if (quantity > maxQuantity && maxQuantity > 0) {
                    adjustedQuantity = maxQuantity;
                    adjustedAmount = maxQuantity * lastPrice;
                    needsAdjustment = true;
                    
                    // Show notification
                    Toastify({
                        text: `Số lượng vượt quá số dư trong wallet. Đã điều chỉnh về ${maxQuantity.toFixed(6)} ${currentSymbol}`,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();
                }
                
                // Update both amount and quantity fields if adjustment needed
                if (needsAdjustment) {
                    $('.amount-buy-down').val(adjustedAmount.toFixed(2));
                    $('#transaction-amount-buy-down').text('$' + adjustedAmount.toFixed(2));
                    
                    // Adjust slider if needed
                    const balance = parseFloat($('.balance-value').text().replace(/[^\d.-]/g, '')) || 0;
                    if (balance > 0) {
                        const adjustedPercentage = Math.min((adjustedAmount / balance) * 100, 100);
                        $('#slider-buy-down').val(adjustedPercentage);
                        $('#slider-buy-down-active-track').css('width', adjustedPercentage + '%');
                        updateSliderLabels('buy-down', adjustedPercentage);
                    }
                }
                
                $('.quantity-buy-down').val(adjustedQuantity.toFixed(6));
                $('#quantity-buy-down').text(adjustedQuantity.toFixed(6));
            }
            
            // Also update transaction amount when quantity changes due to price change
            // Mobile form
            const mobileQuantity = parseFloat($('#mobile-quantity').val()) || 0;
            if (mobileQuantity > 0 && lastPrice > 0) {
                const amount = mobileQuantity * lastPrice;
                $('#mobile-transaction-amount').val(amount.toFixed(2));
                $('#mobile-transaction-amount-display').text('$' + amount.toFixed(2));
            }
            
            // Desktop Buy Up form
            const buyUpQuantity = parseFloat($('.quantity-buy-up').val()) || 0;
            if (buyUpQuantity > 0 && lastPrice > 0) {
                const amount = buyUpQuantity * lastPrice;
                $('.amount-buy-up').val(amount.toFixed(2));
                $('#investment-amount-buy-up').text('$' + amount.toFixed(2));
            }
            
            // Desktop Buy Down form - no need to recalculate here as it's already handled above
            
            // Update crypto investment info when price changes
            updateCryptoInvestmentInfo();
        }

        // Spot Trading History Tab Management
        $('.active-tab').click(function() {
            const tab = $(this).data('tab');
            
            // Update tab styling
            $('.active-tab').removeClass('border-[#3ddeea] text-[#3ddeea]').addClass('border-transparent text-gray-400');
            $(this).removeClass('border-transparent text-gray-400').addClass('border-[#3ddeea] text-[#3ddeea]');
            
            // Show/hide tab content
            $('.tab-content').addClass('hidden').removeClass('block');
            $('#' + tab).removeClass('hidden').addClass('block');
            
            // Load data for the selected tab
            if (tab === 'spot-history') {
                loadSpotOrderHistory();
                loadTradingStats();
            }
        });

        // Load Spot Order History
        function loadSpotOrderHistory(filters = {}) {
            $.ajax({
                url: "{{ route('spot-trading.get-order-history') }}",
                type: "GET",
                data: filters,
                success: function(response) {
                    if (response.html) {
                        $('#spot-order-history-content').html(response.html);
                    }
                },
                error: function(error) {
                    console.error('Error loading spot order history:', error);
                    $('#spot-order-history-content').html(`
                        <div class="text-center py-8">
                            <p class="text-red-400">Error loading order history</p>
                        </div>
                    `);
                }
            });
        }

        // Load Trading Statistics
        function loadTradingStats() {
            $.ajax({
                url: "{{ route('spot-trading.get-trading-stats') }}",
                type: "GET",
                success: function(response) {
                    $('#stat-total-orders').text(response.total_trades || 0);
                    $('#stat-completed-orders').text(response.completed_trades || 0);
                    $('#stat-total-volume').text('$' + (response.total_volume || 0).toFixed(2));
                    $('#stat-total-commission').text('$' + (response.total_commission || 0).toFixed(2));
                },
                error: function(error) {
                    console.error('Error loading trading stats:', error);
                }
            });
        }

        // Apply Filters
        $('#apply-filters').click(function() {
            const filters = {
                status: $('#filter-status').val(),
                type: $('#filter-type').val(),
                symbol_id: $('#filter-symbol').val(),
                date_from: $('#filter-date-from').val(),
                date_to: $('#filter-date-to').val(),
                search: $('#filter-search').val()
            };
            
            loadSpotOrderHistory(filters);
        });

        // Clear Filters
        $('#clear-filters').click(function() {
            $('#filter-status').val('all');
            $('#filter-type').val('all');
            $('#filter-symbol').val('all');
            $('#filter-date-from').val('');
            $('#filter-date-to').val('');
            $('#filter-search').val('');
            
            loadSpotOrderHistory();
        });

        // Export Orders
        $('#export-orders').click(function() {
            const filters = {
                status: $('#filter-status').val(),
                type: $('#filter-type').val(),
                symbol_id: $('#filter-symbol').val(),
                date_from: $('#filter-date-from').val(),
                date_to: $('#filter-date-to').val(),
                search: $('#filter-search').val()
            };
            
            // Create download link
            const queryString = new URLSearchParams(filters).toString();
            const downloadUrl = "{{ route('spot-trading.export-order-history') }}?" + queryString;
            
            // Trigger download
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = 'spot_trading_history.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Refresh Orders
        $('#refresh-orders').click(function() {
            const button = $(this);
            const icon = button.find('i');
            
            // Show loading state
            button.prop('disabled', true);
            icon.removeClass('fa-sync-alt').addClass('fa-spinner fa-spin');
            
            // Reload data
            loadSpotOrderHistory();
            loadTradingStats();
            
            // Reset button state
            setTimeout(() => {
                button.prop('disabled', false);
                icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
            }, 1000);
        });

        // Load More Orders
        $(document).on('click', '.load-more-spot-orders', function() {
            const button = $(this);
            const page = button.data('page');
            
            // Show loading state
            button.prop('disabled', true);
            button.html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');
            
            // Get current filters
            const filters = {
                status: $('#filter-status').val(),
                type: $('#filter-type').val(),
                symbol_id: $('#filter-symbol').val(),
                date_from: $('#filter-date-from').val(),
                date_to: $('#filter-date-to').val(),
                search: $('#filter-search').val(),
                page: page
            };
            
            $.ajax({
                url: "{{ route('spot-trading.get-order-history') }}",
                type: "GET",
                data: filters,
                success: function(response) {
                    if (response.html) {
                        // Append new orders
                        $('#spot-order-history-content .spot-trade-item').last().after(response.html);
                        
                        // Update load more button
                        if (response.hasMorePages) {
                            button.data('page', response.nextPage);
                            button.prop('disabled', false);
                            button.html('<i class="fas fa-sync-alt mr-2"></i>Load More Orders');
                        } else {
                            button.hide();
                        }
                    }
                },
                error: function(error) {
                    console.error('Error loading more orders:', error);
                    button.prop('disabled', false);
                    button.html('<i class="fas fa-sync-alt mr-2"></i>Load More Orders');
                }
            });
        });

        // Cancel Order
        $(document).on('click', '.cancel-order-btn', function() {
            const button = $(this);
            const orderId = button.data('order-id');
            
            if (!confirm('Are you sure you want to cancel this order?')) {
                return;
            }
            
            // Show loading state
            button.prop('disabled', true);
            button.html('<i class="fas fa-spinner fa-spin"></i> Cancelling...');
            
        });

        // Call updateQuantityOnPriceChange when price changes
        // This will be called from handleTickerMessage function
        const originalHandleTickerMessage = handleTickerMessage;
        handleTickerMessage = function(data) {
            originalHandleTickerMessage(data);
            updateQuantityOnPriceChange();
        };

        // Initialize crypto investment info when page loads
        $(document).ready(function() {
            // Wait a bit for initial data to load
            setTimeout(() => {
                updateCryptoInvestmentInfo();
                updateCanSellAmount();
            }, 2000);
        });


    });
</script>
@endsection
<!-- End of Selection -->