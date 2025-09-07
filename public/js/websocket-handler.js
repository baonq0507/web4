/**
 * WebSocket Data Handler for Trading
 * Xử lý dữ liệu real-time từ WebSocket
 */

// Kiểm tra xem class đã được khai báo chưa
if (typeof window.WebSocketHandler === 'undefined') {
    window.WebSocketHandler = class WebSocketHandler {
    constructor() {
        this.previousPrices = {};
        this.spotPreviousPrices = {};
        this.isConnected = false;
        this.reconnectAttempts = 0;
        this.maxReconnectAttempts = 5;
        this.reconnectDelay = 3000;
    }

    /**
     * Xử lý dữ liệu từ WebSocket
     */
    handleWebSocketMessage(data) {
        try {
            console.log('📨 WebSocket message received:', data);
            
            if (data.type === 'finnhubTrade' && data.symbol && data.price) {
                this.handleFinnhubTrade(data);
            } else if (data.type === 'finnhubWsMessage') {
                this.handleRawFinnhubMessage(data.data);
            } else if (data.type === 'finnhubWsError') {
                this.handleError(data.data);
            } else if (data.type === 'finnhubWsClose') {
                this.handleClose(data.data);
            } else {
                console.log('📨 Unknown message type:', data.type);
            }
        } catch (error) {
            console.error('❌ Error handling WebSocket message:', error);
        }
    }

    /**
     * Xử lý dữ liệu trade từ Finnhub
     */
    handleFinnhubTrade(data) {
        console.log(`💰 Finnhub trade: ${data.symbol} = $${data.price}`);
        
        const price = parseFloat(data.price);
        if (isNaN(price) || price <= 0) {
            console.warn('⚠️ Invalid price data:', data.price);
            return;
        }
        
        const cleanSymbol = data.symbol.includes(':') ? data.symbol.split(':')[1] : data.symbol;
        
        // Cập nhật UI cho trading page
        if (typeof updatePriceDisplay === 'function') {
            updatePriceDisplay(cleanSymbol, price, data.timestamp);
        }
        if (typeof updateSymbolUI === 'function') {
            updateSymbolUI(cleanSymbol, price, data);
        }
        
        // Cập nhật UI cho spot trading page
        if (typeof updateSpotPriceDisplay === 'function') {
            updateSpotPriceDisplay(cleanSymbol, price, data.timestamp);
        }
        if (typeof updateSpotSymbolUI === 'function') {
            updateSpotSymbolUI(cleanSymbol, price, data);
        }
    }

    /**
     * Xử lý dữ liệu raw từ Finnhub WebSocket
     */
    handleRawFinnhubMessage(rawData) {
        try {
            const finnhubData = JSON.parse(rawData);
            
            if (finnubData.type === 'trade' && finnhubData.data && Array.isArray(finnubData.data)) {
                // Xử lý array of trades
                finnhubData.data.forEach(trade => {
                    if (trade.s && trade.p) {
                        const symbol = trade.s;
                        const price = parseFloat(trade.p);
                        if (!isNaN(price) && price > 0) {
                            const cleanSymbol = symbol.includes(':') ? symbol.split(':')[1] : symbol;
                            console.log(`💰 Raw Finnhub price for ${cleanSymbol}: $${price}`);
                            
                            // Cập nhật UI cho trading page
                            if (typeof updatePriceDisplay === 'function') {
                                updatePriceDisplay(cleanSymbol, price, Date.now());
                            }
                            if (typeof updateSymbolUI === 'function') {
                                updateSymbolUI(cleanSymbol, price, trade);
                            }
                            
                            // Cập nhật UI cho spot trading page
                            if (typeof updateSpotPriceDisplay === 'function') {
                                updateSpotPriceDisplay(cleanSymbol, price, Date.now());
                            }
                            if (typeof updateSpotSymbolUI === 'function') {
                                updateSpotSymbolUI(cleanSymbol, price, trade);
                            }
                        }
                    }
                });
            } else if (finnubData.s && finnhubData.p) {
                // Xử lý single trade
                const symbol = finnhubData.s;
                const price = parseFloat(finnubData.p);
                if (!isNaN(price) && price > 0) {
                    const cleanSymbol = symbol.includes(':') ? symbol.split(':')[1] : symbol;
                    console.log(`💰 Raw Finnhub price for ${cleanSymbol}: $${price}`);
                    
                    // Cập nhật UI cho trading page
                    if (typeof updatePriceDisplay === 'function') {
                        updatePriceDisplay(cleanSymbol, price, Date.now());
                    }
                    if (typeof updateSymbolUI === 'function') {
                        updateSymbolUI(cleanSymbol, price, finnhubData);
                    }
                    
                    // Cập nhật UI cho spot trading page
                    if (typeof updateSpotPriceDisplay === 'function') {
                        updateSpotPriceDisplay(cleanSymbol, price, Date.now());
                    }
                    if (typeof updateSpotSymbolUI === 'function') {
                        updateSpotSymbolUI(cleanSymbol, price, finnhubData);
                    }
                }
            }
        } catch (parseError) {
            console.error('❌ Error parsing raw Finnhub data:', parseError);
        }
    }

    /**
     * Xử lý lỗi WebSocket
     */
    handleError(errorData) {
        console.error('❌ Finnhub WebSocket error:', errorData);
        
        if (errorData && errorData.message) {
            this.showNotification(`Finnhub Error: ${errorData.message}`, 'error');
        }
    }

    /**
     * Xử lý đóng kết nối WebSocket
     */
    handleClose(closeData) {
        console.warn('⚠️ Finnhub WebSocket closed:', closeData);
        
        if (closeData && closeData.reason) {
            this.showNotification(`Connection closed: ${closeData.reason}`, 'warning');
        }
    }

    /**
     * Hiển thị thông báo
     */
    showNotification(message, type = 'info') {
        if (typeof Toastify !== 'undefined') {
            const colors = {
                error: "linear-gradient(to right, #e04b48, #CD5C5C)",
                warning: "linear-gradient(to right, #ff9800, #f57c00)",
                info: "linear-gradient(to right, #2196F3, #1976D2)",
                success: "linear-gradient(to right, #4CAF50, #388E3C)"
            };
            
            Toastify({
                text: message,
                duration: type === 'error' ? 5000 : 3000,
                gravity: "top",
                style: {
                    background: colors[type] || colors.info,
                }
            }).showToast();
        }
    }

    /**
     * Tính toán thay đổi giá
     */
    calculatePriceChange(symbol, currentPrice, isSpot = false) {
        const priceKey = isSpot ? 'spotPreviousPrices' : 'previousPrices';
        const previousPrice = this[priceKey][symbol];
        
        if (previousPrice && previousPrice > 0) {
            const change = ((currentPrice - previousPrice) / previousPrice) * 100;
            return parseFloat(change.toFixed(2));
        }
        
        return 0;
    }

    /**
     * Lưu trữ giá hiện tại
     */
    storeCurrentPrice(symbol, price, isSpot = false) {
        const priceKey = isSpot ? 'spotPreviousPrices' : 'previousPrices';
        this[priceKey][symbol] = price;
    }

    /**
     * Cập nhật trạng thái kết nối
     */
    updateConnectionStatus(isConnected) {
        this.isConnected = isConnected;
        
        // Cập nhật UI status nếu có
        if (typeof updateConnectionStatus === 'function') {
            updateConnectionStatus('finnhub', isConnected);
        }
        if (typeof updateSpotConnectionStatus === 'function') {
            updateSpotConnectionStatus('finnhub', isConnected);
        }
    }
    }

// Tạo instance global
window.websocketHandler = new window.WebSocketHandler();

// Export cho module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = window.WebSocketHandler;
}
}
