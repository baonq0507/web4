# Hướng dẫn sử dụng Finnhub Integration

## Tổng quan
Hệ thống đã được tích hợp hoàn toàn với Finnhub WebSocket API để cung cấp dữ liệu real-time cho trading platform.

## Cài đặt nhanh

### 1. Cấu hình API Key
```bash
cd /www/wwwroot/web3/nodejs
cp .env.example .env
# Chỉnh sửa .env và thêm FINNHUB_API_KEY
```

### 2. Khởi động hệ thống
```bash
# Cách 1: Sử dụng script tự động
./start-finnhub-integration.sh

# Cách 2: Khởi động thủ công
npm install
npm start
```

## Cách sử dụng

### 1. Frontend Integration
Hệ thống tự động kết nối và nhận dữ liệu real-time:

```javascript
// WebSocket tự động kết nối khi load trang
ws = new WebSocket("{{env('WEBSOCKET_URL')}}");

// Tự động subscribe symbols
ws.send(JSON.stringify({
    type: 'subscribe_symbols',
    symbols: ['BINANCE:BTCUSDT', 'BINANCE:ETHUSDT']
}));

// Nhận dữ liệu real-time
ws.onmessage = function(event) {
    const data = JSON.parse(event.data);
    if (data.type === 'finnhubTrade') {
        // Cập nhật giá real-time
        updatePrice(data.symbol, data.price);
    }
};
```

### 2. Dữ liệu nhận được
```json
{
    "type": "finnhubTrade",
    "symbol": "BINANCE:BTCUSDT",
    "price": 43250.50,
    "volume": 0.001,
    "exchange": "BINANCE",
    "timestamp": "2024-01-15T10:30:00.000Z"
}
```

### 3. Symbols được hỗ trợ
- **Crypto**: BINANCE:BTCUSDT, BINANCE:ETHUSDT, BINANCE:ADAUSDT
- **Stocks**: AAPL, GOOGL, MSFT, TSLA
- **Forex**: OANDA:EUR_USD, OANDA:GBP_USD

## Testing

### 1. Test API cơ bản
```bash
npm run test:finnhub
```

### 2. Test WebSocket
```bash
npm run test:websocket
```

### 3. Test Frontend Integration
```bash
# Terminal 1
npm start

# Terminal 2
npm run test:frontend
```

## Monitoring

### 1. Logs
```bash
# Xem logs real-time
tail -f websocket.log

# Xem logs console
npm start
```

### 2. Health Check
```bash
# Kiểm tra API
curl http://localhost:8386/finnhub/price/BINANCE:BTCUSDT

# Kiểm tra WebSocket
curl -i -N -H "Connection: Upgrade" -H "Upgrade: websocket" -H "Sec-WebSocket-Key: test" -H "Sec-WebSocket-Version: 13" http://localhost:8386/
```

## Troubleshooting

### 1. Lỗi kết nối WebSocket
```bash
# Kiểm tra port
netstat -tlnp | grep 8386

# Kiểm tra firewall
ufw status
```

### 2. Không nhận được dữ liệu
- Kiểm tra API key trong .env
- Kiểm tra symbols có đúng format không
- Kiểm tra console logs

### 3. Lỗi API Key
```bash
# Test API key
curl "https://finnhub.io/api/v1/quote?symbol=AAPL&token=YOUR_API_KEY"
```

## Cấu hình nâng cao

### 1. Thay đổi port
```bash
# Trong .env
WEBSOCKET_PORT=8386
```

### 2. Thêm symbols mới
```javascript
// Trong frontend
const symbols = ['BINANCE:BTCUSDT', 'BINANCE:ETHUSDT', 'NEW_SYMBOL'];
ws.send(JSON.stringify({
    type: 'subscribe_symbols',
    symbols: symbols
}));
```

### 3. Xử lý lỗi
```javascript
ws.onerror = function(error) {
    console.error('WebSocket error:', error);
    // Tự động reconnect
    setTimeout(connectWebSocket, 5000);
};
```

## Performance

### 1. Rate Limits
- **Free Plan**: 60 calls/minute
- **Paid Plans**: Higher limits

### 2. WebSocket Connections
- **Free Plan**: 1 connection
- **Paid Plans**: Multiple connections

### 3. Data Frequency
- Trade data: Real-time
- Price updates: Every trade
- Order book: Mock data (có thể nâng cấp)

## Support

### 1. Finnhub Documentation
- [WebSocket API](https://finnhub.io/docs/api/websocket-trades)
- [REST API](https://finnhub.io/docs/api)

### 2. Contact
- Finnhub Support: support@finnhub.io
- Project Issues: Tạo issue trong repository

## Changelog

### v1.0.0 (2024-01-15)
- ✅ Tích hợp Finnhub WebSocket API
- ✅ Frontend integration hoàn chỉnh
- ✅ Test scripts
- ✅ Documentation
- ✅ Error handling
- ✅ Auto-reconnection
