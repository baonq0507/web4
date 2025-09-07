@extends('user.layouts.app')

@section('title', __('index.login'))

@section('content')
<div class="min-h-screen  flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <img src="{{ asset('images/app/' . config('app_logo')) }}" alt="{{ config('app_name') }}" class="mx-auto h-16 w-auto mb-4">
            <h2 class="text-3xl font-bold text-white mb-2">{{ __('index.login') }}</h2>
            <p class="text-cyan-400">Chào mừng bạn trở lại {{ config('app_name') }}</p>
        </div>
        
        <div class=" rounded-2xl p-8 border shadow-2xl">
            <form action="{{ route('loginPost') }}" method="post" id="formLogin" class="space-y-6">
                @csrf
                
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
                    <label for="email" class="block mb-2 text-white font-medium">{{ __('index.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('index.email') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="password" class="block mb-2 text-white font-medium">{{ __('index.password') }}</label>
                    <input type="password" name="password" id="password" placeholder="{{ __('index.password') }}" class="w-full p-3 border border-gray-600 rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-cyan-500 bg-[#0f0f23] border-gray-600 rounded focus:ring-cyan-500 focus:ring-2">
                        <label for="remember" class="ml-2 text-sm text-gray-300">{{ __('index.remember_me') }}</label>
                    </div>
                    <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors duration-300">
                        {{ __('index.forgot_password') }}
                    </a>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-4 rounded-xl font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg">
                    {{ __('index.login') }}
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    {{ __('index.you_dont_have_account') }} 
                    <a href="{{ route('register') }}" class="text-cyan-400 hover:text-cyan-300 transition-colors duration-300 font-medium">
                        {{ __('index.register') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>

</style>
@endsection
@section('scripts')
@endsection