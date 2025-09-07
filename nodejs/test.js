require('dotenv').config();
const finnhubApiKey = process.env.FINNHUB_API_KEY || 'd2s2fuhr01qv11lgr3e0d2s2fuhr01qv11lgr3eg';

const socket = new WebSocket('wss://ws.finnhub.io?token=' + finnhubApiKey);

// Connection opened -> Subscribe
socket.addEventListener('open', function (event) {
        // Subscribe Forex
        socket.send(JSON.stringify({'type':'subscribe', 'symbol': 'BINANCE:BTCUSDT'}));

        // Subscribe Crypto
        // socket.send(JSON.stringify({'type':'subscribe', 'symbol': 'ACN'}));
    
        // Subscribe US Stock
        // socket.send(JSON.stringify({'type':'subscribe', 'symbol': 'AAPL'}));
});

// Listen for messages
socket.addEventListener('message', function (event) {
    console.log('Message from server ', event.data);
});

socket.addEventListener('error', function (event) {
    console.log('Error from server ', event);
});

socket.addEventListener('close', function (event) {
    console.log('Close from server ', event);
});
// Unsubscribe
var unsubscribe = function(symbol) {
    socket.send(JSON.stringify({'type':'unsubscribe-news','symbol': symbol}))
}

// unsubscribe("BINANCE:BTCUSDT");
