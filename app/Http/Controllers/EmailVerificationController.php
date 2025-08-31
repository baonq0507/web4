<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $verificationCode = Str::random(6);
        
        // Lưu mã xác thực vào session với thời gian hết hạn (15 phút)
        session(['email_verification_code' => $verificationCode]);
        session(['email_to_verify' => $request->email]);
        session(['email_verification_expires' => now()->addMinutes(15)->timestamp]);

        // Gửi email xác thực
        try {
            Mail::send('emails.verification', [
                'verificationCode' => $verificationCode,
                'appName' => config('app.name')
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Mã xác thực email - ' . config('app.name'));
            });

            return response()->json([
                'status' => true,
                'message' => 'Mã xác thực đã được gửi đến email của bạn'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể gửi email. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $storedCode = session('email_verification_code');
        $storedEmail = session('email_to_verify');
        $expiresAt = session('email_verification_expires');

        if (!$storedCode || !$storedEmail || !$expiresAt) {
            return response()->json([
                'status' => false,
                'message' => 'Mã xác thực đã hết hạn. Vui lòng gửi lại.'
            ], 422);
        }

        // Kiểm tra thời gian hết hạn
        if (now()->timestamp > $expiresAt) {
            // Xóa session hết hạn
            session()->forget(['email_verification_code', 'email_to_verify', 'email_verification_expires']);
            return response()->json([
                'status' => false,
                'message' => 'Mã xác thực đã hết hạn. Vui lòng gửi lại.'
            ], 422);
        }

        if ($request->email !== $storedEmail) {
            return response()->json([
                'status' => false,
                'message' => 'Email không khớp với email đã gửi mã xác thực.'
            ], 422);
        }

        if ($request->verification_code !== $storedCode) {
            return response()->json([
                'status' => false,
                'message' => 'Mã xác thực không chính xác.'
            ], 422);
        }

        // Không xóa session ở đây, để giữ lại cho việc đăng ký
        // Session sẽ được xóa sau khi đăng ký thành công trong HomeController

        return response()->json([
            'status' => true,
            'message' => 'Xác thực email thành công!'
        ]);
    }
}
