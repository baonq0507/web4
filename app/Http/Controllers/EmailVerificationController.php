<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        
        // Lưu mã xác thực vào session để kiểm tra sau
        session(['email_verification_code' => $verificationCode]);
        session(['email_to_verify' => $request->email]);

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

        if (!$storedCode || !$storedEmail) {
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

        // Xóa session sau khi xác thực thành công
        session()->forget(['email_verification_code', 'email_to_verify']);

        return response()->json([
            'status' => true,
            'message' => 'Xác thực email thành công!'
        ]);
    }
}
