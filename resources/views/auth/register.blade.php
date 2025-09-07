@extends('user.layouts.app')

@section('title', __('index.register'))

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
    <div class="w-full flex flex-col lg:flex-row">
        <!-- Left side - Abstract graphic (only show on desktop) -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center">
            <div class="relative w-full h-full flex items-center justify-center">
                <!-- Abstract 3D graphic -->
                <!-- Background pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="w-full h-full">
                        <img src="{{ asset('assets/images/login.png') }}" alt="{{ config('app_name') }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                    </div>
                </div>
            </div>
        </div>
        <!-- Right side - Registration form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center">
            <div class="w-full max-w-xl space-y-8">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-cyan-400 mb-8">{{ __('index.register') }}</h2>
                </div>
                <div class="rounded-2xl p-8 border border-gray-700 shadow-2xl">
                    <!-- Tab navigation -->
                    <div class="flex border-b border-gray-700 mb-6">
                        <button type="button" id="phoneTab" class="flex-1 py-3 px-4 text-center text-cyan-400 border-b-2 border-cyan-400 font-medium text-sm transition-colors duration-300">
                            {{__('index.register_by_phone')}}
                        </button>
                        <button type="button" id="emailTab" class="flex-1 py-3 px-4 text-center text-gray-400 hover:text-cyan-400 font-medium text-sm transition-colors duration-300">
                            {{__('index.register_by_email')}}
                        </button>
                    </div>
                    <!-- Phone Registration Form -->
                    <form action="{{ route('registerPost') }}" method="post" id="phoneForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="registration_type" value="phone">
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
                            <label for="phone" class="block mb-2 text-white font-medium">{{ __('index.phone') }}</label>
                            <div class="flex space-x-2">
                                <select name="country_code" class="w-24 p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                                    <option value="+84">+84</option>
                                    <option value="+1">+1</option>
                                    <option value="+44">+44</option>
                                    <option value="+86">+86</option>
                                </select>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại của bạn" class="flex-1 p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                            </div>
                        </div>
                        <div>
                            <label for="phone_password" class="block mb-2 text-white font-medium">{{ __('index.password') }}</label>
                            <input type="password" name="password" id="password" placeholder="{{ __('index.password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="phone_password_confirmation" class="block mb-2 text-white font-medium">{{ __('index.confirm_password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('index.confirm_password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        @if(config('disabled_referal') == 'on')
                        <div>
                            <label for="phone_referral_code" class="block mb-2 text-white font-medium">{{ __('index.referral_code') }}</label>
                            <input type="text" name="referral_code" id="phone_referral_code" value="{{ $referralCode ?? old('referral_code') }}" placeholder="{{ __('index.enter_referral_code') }}" {{ $referralCode ? 'readonly' : '' }} class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 {{ $referralCode ? 'bg-gray-800 cursor-not-allowed' : '' }}">
                        </div>
                        @endif
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="agree_terms" id="agree_terms" class="w-5 h-5 text-cyan-500 bg-[#0f0f23] border-gray-600 rounded focus:ring-cyan-500 focus:ring-2">
                            <label for="phone_agree_terms" class="text-sm text-gray-300">
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
                    <!-- Email Registration Form -->
                    <form action="{{ route('registerEmailPost') }}" method="post" id="emailForm" class="space-y-6 hidden">
                        @csrf
                        <input type="hidden" name="registration_type" value="email">
                        <div>
                            <label for="email" class="block mb-2 text-white font-medium">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="email_verification_code" class="block mb-2 text-white font-medium">Mã xác thực</label>
                            <div class="flex space-x-2">
                                <input type="text" name="verification_code" id="email_verification_code" placeholder="Nhập mã 6 số" maxlength="6" class="flex-1 p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                                <button type="button" id="sendEmailCodeBtn" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-3 rounded-xl font-medium transition-colors duration-300 whitespace-nowrap">
                                    Gửi mã
                                </button>
                            </div>
                            <div id="emailVerificationStatus" class="mt-2 text-sm"></div>
                        </div>
                        <div>
                            <label for="email_password" class="block mb-2 text-white font-medium">{{ __('index.password') }}</label>
                            <input type="password" name="password" id="email_password" placeholder="{{ __('index.password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="email_password_confirmation" class="block mb-2 text-white font-medium">{{ __('index.confirm_password') }}</label>
                            <input type="password" name="password_confirmation" id="email_password_confirmation" placeholder="{{ __('index.confirm_password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                        </div>
                        @if(config('disabled_referal') == 'on')
                        <div>
                            <label for="email_referral_code" class="block mb-2 text-white font-medium">{{ __('index.referral_code') }}</label>
                            <input type="text" name="referral_code" id="email_referral_code" value="{{ $referralCode ?? old('referral_code') }}" placeholder="{{ __('index.enter_referral_code') }}" {{ $referralCode ? 'readonly' : '' }} class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 {{ $referralCode ? 'bg-gray-800 cursor-not-allowed' : '' }}">
                        </div>
                        @endif
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="agree_terms" id="email_agree_terms" class="w-5 h-5 text-cyan-500 bg-[#0f0f23] border-gray-600 rounded focus:ring-cyan-500 focus:ring-2">
                            <label for="email_agree_terms" class="text-sm text-gray-300">
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prevent duplicate event listeners
    if (window.registerFormInitialized) {
        return;
    }
    window.registerFormInitialized = true;
    
    const phoneTabBtn = document.getElementById('phoneTab');
    const emailTabBtn = document.getElementById('emailTab');
    const phoneForm = document.getElementById('phoneForm');
    const emailForm = document.getElementById('emailForm');

    // Show phone form and hide email form by default
    phoneForm.classList.remove('hidden');
    emailForm.classList.add('hidden');

    // Tab navigation logic
    if (phoneTabBtn) {
        phoneTabBtn.addEventListener('click', function() {
            phoneForm.classList.remove('hidden');
            emailForm.classList.add('hidden');
            phoneTabBtn.classList.add('text-cyan-400', 'border-b-2', 'border-cyan-400');
            phoneTabBtn.classList.remove('text-gray-400');
            emailTabBtn.classList.remove('text-cyan-400', 'border-b-2', 'border-cyan-400');
            emailTabBtn.classList.add('text-gray-400');
        });
    }

    if (emailTabBtn) {
        emailTabBtn.addEventListener('click', function() {
            phoneForm.classList.add('hidden');
            emailForm.classList.remove('hidden');
            emailTabBtn.classList.add('text-cyan-400', 'border-b-2', 'border-cyan-400');
            emailTabBtn.classList.remove('text-gray-400');
            phoneTabBtn.classList.remove('text-cyan-400', 'border-b-2', 'border-cyan-400');
            phoneTabBtn.classList.add('text-gray-400');
        });
    }

    const sendEmailCodeBtn = document.getElementById('sendEmailCodeBtn');
    const emailVerificationStatus = document.getElementById('emailVerificationStatus');
    const emailInput = document.getElementById('email');

    // Send email verification code
    if (sendEmailCodeBtn) {
        sendEmailCodeBtn.addEventListener('click', function() {
            const email = $('#email').val();
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
                    emailVerificationStatus.innerHTML = '<span class="text-green-400">' + data.message + '</span>';
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

    // Submit phone form via AJAX
    if (phoneForm) {
        phoneForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const submitBtn = phoneForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Prevent multiple submissions
            if (submitBtn.disabled) {
                return false;
            }
            
            // Disable submit button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang đăng ký...';
            submitBtn.classList.add('opacity-50');

            // Get form data
            const formData = new FormData(phoneForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            // Send AJAX request
            fetch('{{ route("registerPost") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Success - redirect to dashboard or show success message
                    window.location.href = '{{ route("home") }}';
                } else {
                    // Show error message
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        gravity: 'top',
                        style: {
                            background: 'linear-gradient(to right, #ff0000, #ff0000)',
                        }
                    }).showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: 'Có lỗi xảy ra, vui lòng thử lại',
                    duration: 3000,
                    gravity: 'top',
                    style: {
                        background: 'linear-gradient(to right, #ff0000, #ff0000)',
                    }
                }).showToast();
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-50');
            });
            
            return false;
        });
    }

    // Submit email form via AJAX
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const submitBtn = emailForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Prevent multiple submissions
            if (submitBtn.disabled) {
                return false;
            }
            
            // Disable submit button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang đăng ký...';
            submitBtn.classList.add('opacity-50');

            // Get form data
            const formData = new FormData(emailForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            // Send AJAX request
            fetch('{{ route("registerEmailPost") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Success - redirect to dashboard or show success message
                    window.location.href = '{{ route("home") }}';
                } else {
                    // Show error message
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        gravity: 'top',
                        style: {
                            background: 'linear-gradient(to right, #ff0000, #ff0000)',
                        }
                    }).showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: 'Có lỗi xảy ra, vui lòng thử lại',
                    duration: 3000,
                    gravity: 'top',
                    style: {
                        background: 'linear-gradient(to right, #ff0000, #ff0000)',
                    }
                }).showToast();
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-50');
            });
            
            return false;
        });
    }
});
</script>
@endsection
