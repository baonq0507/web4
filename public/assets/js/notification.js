function showNotification(message) {
    // Tạo element thông báo
    const notification = document.createElement('div');
    notification.className = 'notification-slide';
    notification.textContent = message;
    
    // Thêm vào body
    document.body.appendChild(notification);
    
    // Xóa sau khi animation kết thúc
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Xử lý thông báo nạp tiền
function handleDepositNotification(data) {
    const message = `Nạp tiền thành công: ${data.amount} USDT`;
    showNotification(message);
}

// Xử lý thông báo rút tiền  
function handleWithdrawNotification(data) {
    const message = `Rút tiền thành công: ${data.amount} USDT`;
    showNotification(message);
} 