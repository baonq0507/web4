@extends('user.layouts.app')
@section('title', __('index.change_password'))
@section('content')
<div class="max-w-7xl mx-auto px-4 pb-16 mt-16">
    <div class="flex justify-center items-center">
        <div class="w-full max-w-md">
            <div class="bg-[#1f2023] shadow-md rounded-lg">
                <div class=" px-4 py-2 font-semibold text-lg">{{ __('index.change_password') }}</div>

                <div class="p-4 mb-4">
                    @if (session('success'))
                        <div class="border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" style="background-color:green;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password-withdraw.update') }}">
                        @csrf
                        @if(Auth::user()->password_withdraw)
                        <div class="mb-4">
                            <label for="old_password" class="block text-white text-sm mb-2">{{ __('index.old_password') }}</label>
                            <input id="old_password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline @error('old_password') border-red-500 @enderror" name="old_password" required>
                            @error('old_password')
                                <span class="text-red-500 text-xs italic">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif
                        <div class="mb-4">
                            <label for="new_password" class="block text-white text-sm mb-2">{{ __('index.new_password') }}</label>
                            <input id="new_password" type="password" class="shadow appearance-none border border-white-700 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline @error('new_password') border-red-500 @enderror" name="new_password" required>
                            @error('new_password')
                                <span class="text-red-500 text-xs italic">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirm" class="block text-white text-sm mb-2">{{ __('index.confirm_new_password') }}</label>
                            <input id="password_confirm" type="password" class="shadow appearance-none border border-white-700 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline @error('password_confirm') border-red-500 @enderror" name="password_confirm" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="cursor-pointer bg-cyan-500 hover:bg-cyan-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('index.change_password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 