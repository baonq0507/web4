@extends('user.layouts.app')
@section('title', __('index.msb.title'))
@section('content')
<div class="max-w-7xl mx-auto px-4 py-16 mt-16 pb-16">
    <h1 class="text-2xl font-bold text-white mb-4">{{ __('index.msb.title') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-gray-900 p-6 rounded-lg">
            <img src="{{ asset('assets/images/msb1.jpeg') }}" alt="MSB 1" class="w-full h-auto rounded-lg">
        </div>
        <div class="bg-gray-900 p-6 rounded-lg">
            <img src="{{ asset('assets/images/msb2.jpeg') }}" alt="MSB 2" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>
@endsection