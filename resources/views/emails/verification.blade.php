<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực email - {{ $appName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3ddeea;
        }
        .verification-code {
            background-color: #3ddeea;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 30px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #3ddeea; margin: 0;">{{ $appName }}</h1>
            <p style="margin: 10px 0 0 0; color: #666;">Xác thực email của bạn</p>
        </div>

        <p>Xin chào!</p>
        
        <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>{{ $appName }}</strong>. Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã xác thực dưới đây:</p>

        <div class="verification-code">
            {{ $verificationCode }}
        </div>

        <div class="warning">
            <strong>Lưu ý:</strong> Mã xác thực này có hiệu lực trong 10 phút. Vui lòng không chia sẻ mã này với bất kỳ ai.
        </div>

        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>

        <p>Trân trọng,<br>
        <strong>Đội ngũ {{ $appName }}</strong></p>

        <div class="footer">
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
            <p>&copy; {{ date('Y') }} {{ $appName }}. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
