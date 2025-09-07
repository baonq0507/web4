// Wallet Management JavaScript
class WalletManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadWalletData();
    }

    bindEvents() {
        // Refresh wallet data
        $(document).on('click', '.refresh-wallet', () => {
            this.loadWalletData();
        });

        // View wallet details
        $(document).on('click', '.view-wallet-details', (e) => {
            const symbolId = $(e.currentTarget).data('symbol-id');
            this.getWalletDetails(symbolId);
        });
    }

    loadWalletData() {
        $.ajax({
            url: '/wallet/assets/total',
            method: 'GET',
            success: (response) => {
                this.updateWalletDisplay(response);
            },
            error: (xhr) => {
                console.error('Error loading wallet data:', xhr);
            }
        });
    }

    updateWalletDisplay(data) {
        // Update total assets
        $('.total-assets-value').text('$' + parseFloat(data.total_assets).toFixed(2));
        
        // Update individual wallet values
        Object.keys(data.assets).forEach(symbol => {
            const asset = data.assets[symbol];
            const element = $(`#wallet-value-${symbol}`);
            if (element.length) {
                element.text('$' + parseFloat(asset.value_usdt).toFixed(2));
            }
        });
    }

    getWalletDetails(symbolId) {
        $.ajax({
            url: `/wallet/${symbolId}`,
            method: 'GET',
            success: (response) => {
                this.showWalletDetailsModal(response);
            },
            error: (xhr) => {
                console.error('Error loading wallet details:', xhr);
            }
        });
    }

    showWalletDetailsModal(data) {
        const modal = `
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-[#181a1d] rounded-lg p-6 max-w-md w-full mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-white">${data.wallet.symbol.symbol} Wallet</h3>
                        <button class="text-gray-400 hover:text-white close-modal">&times;</button>
                    </div>
                    
                    <div class="space-y-3 text-white">
                        <div class="flex justify-between">
                            <span>Available Balance:</span>
                            <span class="font-semibold">${parseFloat(data.wallet.balance).toFixed(8)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Frozen Balance:</span>
                            <span class="font-semibold">${parseFloat(data.wallet.frozen_balance).toFixed(8)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Bought:</span>
                            <span class="font-semibold">${parseFloat(data.wallet.total_bought).toFixed(8)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Sold:</span>
                            <span class="font-semibold">${parseFloat(data.wallet.total_sold).toFixed(8)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Average Buy Price:</span>
                            <span class="font-semibold">$${parseFloat(data.wallet.average_buy_price).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Current Price:</span>
                            <span class="font-semibold">$${parseFloat(data.current_price).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Value (USDT):</span>
                            <span class="font-semibold text-[#3ddeea]">$${(parseFloat(data.wallet.balance) * parseFloat(data.current_price)).toFixed(2)}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="text-white font-semibold mb-2">Recent Trades</h4>
                        <div class="max-h-40 overflow-y-auto">
                            ${this.renderTradeHistory(data.trades)}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modal);
        
        // Bind close event
        $(document).on('click', '.close-modal', () => {
            $('.fixed.inset-0').remove();
        });
    }

    renderTradeHistory(trades) {
        if (trades.length === 0) {
            return '<p class="text-gray-400 text-center">No trades yet</p>';
        }
        
        return trades.map(trade => `
            <div class="flex justify-between items-center py-1 border-b border-gray-700">
                <div class="text-sm">
                    <span class="${trade.type === 'buy' ? 'text-green-400' : 'text-red-400'}">${trade.type.toUpperCase()}</span>
                    <span class="text-gray-300">${parseFloat(trade.amount).toFixed(6)} ${trade.symbol.symbol}</span>
                </div>
                <div class="text-xs text-gray-400">
                    $${parseFloat(trade.price).toFixed(2)}
                </div>
            </div>
        `).join('');
    }
}

// Initialize wallet manager when document is ready
$(document).ready(() => {
    new WalletManager();
});
