# Hướng dẫn cấu hình Email cho chức năng xác thực

## 1. Cấu hình trong file .env

Để sử dụng chức năng gửi email thực tế, bạn cần cấu hình các thông số sau trong file `.env`:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 2. Các dịch vụ email phổ biến

### Gmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

**Lưu ý:** Đối với Gmail, bạn cần:
1. Bật "2-Step Verification"
2. Tạo "App Password" thay vì sử dụng mật khẩu thông thường

### Outlook/Hotmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### Yahoo
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yahoo.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## 3. Kiểm tra cấu hình

Sau khi cấu hình, bạn có thể kiểm tra bằng cách:

1. Chạy migration để thêm cột email:
```bash
php artisan migrate
```

2. Kiểm tra chức năng gửi email:
- Mở form đăng ký
- Nhập email hợp lệ
- Click "Gửi mã"
- Kiểm tra email hoặc log

## 4. Troubleshooting

### Email không được gửi
1. Kiểm tra cấu hình SMTP trong .env
2. Kiểm tra firewall/antivirus
3. Kiểm tra log Laravel: `storage/logs/laravel.log`

### Lỗi authentication
1. Kiểm tra username/password
2. Đối với Gmail: sử dụng App Password
3. Kiểm tra 2FA có được bật không

### Lỗi connection
1. Kiểm tra port có bị chặn không
2. Kiểm tra host SMTP có đúng không
3. Thử sử dụng port 465 với SSL thay vì 587 với TLS

## 5. Môi trường Development

Để test mà không cần gửi email thực, bạn có thể:

1. Sử dụng cấu hình log (mặc định):
```env
MAIL_MAILER=log
```

2. Sử dụng Mailtrap (dịch vụ test email):
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

## 6. Bảo mật

- Không commit file .env vào git
- Sử dụng App Password thay vì mật khẩu chính
- Bật 2FA cho tài khoản email
- Sử dụng HTTPS cho production
