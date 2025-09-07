@extends('layouts.app')

@section('title', 'Đăng ký bằng Email')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-[#1a1a2e] to-[#0f0f23] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full flex">
        <!-- Left side - Abstract graphic -->
        <div class="hidden lg:flex lg:w-2/5 items-center justify-center">
            <div class="relative w-full h-full">
                <!-- Abstract 3D graphic -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative w-80 h-80">
                        <!-- Main 3D structure -->
                        <div class="absolute inset-0 transform rotate-12">
                            <div class="w-full h-full bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-lg border border-purple-400/30 shadow-2xl"></div>
                        </div>
                        <div class="absolute inset-0 transform -rotate-6 translate-x-4 translate-y-4">
                            <div class="w-full h-full bg-gradient-to-br from-cyan-500/20 to-purple-500/20 rounded-lg border border-cyan-400/30 shadow-2xl"></div>
                        </div>
                        <div class="absolute inset-0 transform rotate-3 -translate-x-2 -translate-y-2">
                            <div class="w-full h-full bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-lg border border-blue-400/30 shadow-2xl"></div>
                        </div>
                        
                        <!-- Floating elements -->
                        <div class="absolute top-10 left-10 w-8 h-8 bg-cyan-400/40 rounded-full animate-pulse"></div>
                        <div class="absolute bottom-16 right-12 w-6 h-6 bg-purple-400/40 rounded-full animate-pulse delay-1000"></div>
                        <div class="absolute top-32 right-8 w-4 h-4 bg-blue-400/40 rounded-full animate-pulse delay-500"></div>
                    </div>
                </div>
                
                <!-- Background pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="w-full h-full" style="background-image: radial-gradient(circle at 25% 25%, #3b82f6 1px, transparent 1px), radial-gradient(circle at 75% 75%, #8b5cf6 1px, transparent 1px); background-size: 50px 50px;"></div>
                </div>
            </div>
        </div>
        
        <!-- Right side - Registration form -->
        <div class="w-full lg:w-3/5 flex items-center justify-center">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-cyan-400 mb-8">Đăng ký bằng Email</h2>
                </div>
                
                <div class="bg-gradient-to-b from-[#1a1a2e] to-[#0f0f23] rounded-2xl p-8 border border-gray-700 shadow-2xl">
                    <!-- Tab navigation -->
                    <div class="flex border-b border-gray-700 mb-6">
                        <a href="{{ route('register') }}" class="flex-1 py-3 px-4 text-center text-gray-400 hover:text-cyan-400 font-medium transition-colors duration-300">
                            Đăng ký bằng điện thoại
                        </a>
                        <div class="flex-1 py-3 px-4 text-center text-cyan-400 border-b-2 border-cyan-400 font-medium transition-colors duration-300">
                            Đăng ký bằng email
                        </div>
                    </div>
                    
                    <!-- Email Registration Form -->
                    <form action="{{ route('registerEmailPost') }}" method="post" id="emailForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="registration_type" value="email">
                        
                        @if($errors->any())
                        <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                            <div class="flex">
                                <i class="fa fa-exclamation-triangle text-red-400 mt-1 mr-3"></i>
                                <div>
                                    <h3 class="text-sm font-medium text-red-400">Có lỗi xảy ra:</h3>
                                    <div class="mt-2 text-sm text-red-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div>
                            <label for="name" class="block mb-2 text-white font-medium">{{ __('index.fullname') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('index.fullname') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div>
                            <label for="email" class="block mb-2 text-white font-medium">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div>
                            <label for="verification_code" class="block mb-2 text-white font-medium">Mã xác thực</label>
                            <div class="flex space-x-2">
                                <input type="text" name="verification_code" id="verification_code" placeholder="Nhập mã 6 số" maxlength="6" class="flex-1 p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                                <button type="button" id="sendEmailCodeBtn" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-3 rounded-xl font-medium transition-colors duration-300 whitespace-nowrap">
                                    Gửi mã
                                </button>
                            </div>
                            <div id="emailVerificationStatus" class="mt-2 text-sm"></div>
                        </div>
                        
                        <div>
                            <label for="password" class="block mb-2 text-white font-medium">{{ __('index.password') }}</label>
                            <input type="password" name="password" id="password" placeholder="{{ __('index.password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-white font-medium">{{ __('index.confirm_password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('index.confirm_password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        
                        @if(config('disabled_referal') == 'on')
                        <div>
                            <label for="referral_code" class="block mb-2 text-white font-medium">{{ __('index.referral_code') }}</label>
                            <input type="text" name="referral_code" id="referral_code" value="{{ old('referral_code') }}" placeholder="{{ __('index.enter_referral_code') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        @endif
                        
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="agree_terms" id="agree_terms" class="w-5 h-5 text-cyan-500 bg-[#0f0f23] border-gray-600 rounded focus:ring-cyan-500 focus:ring-2">
                            <label for="agree_terms" class="text-sm text-gray-300">
                                Vui lòng đảm bảo bảo mật tài khoản của bạn. Khi bạn nhấp vào xác nhận và đăng nhập, bạn đồng ý sử dụng 
                                <a href="#" class="text-cyan-400 hover:text-cyan-300">《Điều khoản dịch vụ》</a>
                                <a href="#" class="text-cyan-400 hover:text-cyan-300">《Thỏa thuận bảo mật》</a>
                                <a href="#" class="text-cyan-400 hover:text-cyan-300">《Thỏa thuận chống rửa tiền》</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-4 rounded-xl font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg">
                            Xác nhận và đăng nhập
                        </button>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <p class="text-gray-400">
                            Đã có tài khoản? 
                            <a href="{{ route('login') }}" class="text-cyan-400 hover:text-cyan-300 transition-colors duration-300 font-medium">
                                Đăng nhập ngay
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background: linear-gradient(135deg, #1a1a2e 0%, #0f0f23 100%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendEmailCodeBtn = document.getElementById('sendEmailCodeBtn');
    const emailVerificationStatus = document.getElementById('emailVerificationStatus');
    const emailInput = document.getElementById('email');

    // Send email verification code
    if (sendEmailCodeBtn) {
        sendEmailCodeBtn.addEventListener('click', function() {
            const email = emailInput.value;
            if (!email) {
                alert('Vui lòng nhập email trước khi gửi mã xác thực');
                return;
            }

            // Disable button and show loading
            sendEmailCodeBtn.disabled = true;
            sendEmailCodeBtn.textContent = 'Đang gửi...';
            sendEmailCodeBtn.classList.add('opacity-50');

            // Send AJAX request to send verification code
            fetch('{{ route("send.verification.code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    emailVerificationStatus.innerHTML = '<span class="text-green-400">Mã xác thực đã được gửi đến email của bạn</span>';
                } else {
                    emailVerificationStatus.innerHTML = '<span class="text-red-400">' + data.message + '</span>';
                }
            })
            .catch(error => {
                emailVerificationStatus.innerHTML = '<span class="text-red-400">Có lỗi xảy ra, vui lòng thử lại</span>';
            })
            .finally(() => {
                // Re-enable button
                sendEmailCodeBtn.disabled = false;
                sendEmailCodeBtn.textContent = 'Gửi mã';
                sendEmailCodeBtn.classList.remove('opacity-50');
            });
        });
    }
});
</script>
@endsection
