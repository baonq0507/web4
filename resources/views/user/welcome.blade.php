@extends('user.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <!-- Logo và tiêu đề -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/logo.png') }}" alt="MEXC Logo" class="w-24 h-24 mx-auto mb-6">
        <h1 class="text-3xl font-bold text-yellow-500 mb-4">Chào mừng đến với MEXC</h1>
        <p class="text-gray-300 max-w-3xl mx-auto">
            MEXC là một trong những sàn giao dịch tài sản số hàng đầu thế giới, phục vụ hơn 20 triệu người dùng tại hơn 170 quốc gia. Thành lập từ năm 2018, MEXC mang đến nền tảng giao dịch toàn diện, bao gồm "giao ngay, hợp đồng tương lai, phái sinh", cùng nhiều sản phẩm tài chính sáng tạo khác, giúp người dùng tối ưu hóa trải nghiệm và lợi nhuận.
        </p>
    </div>

    <!-- Grid các tính năng -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Phí giao dịch thấp -->
        <div class="bg-[#1f2023] p-6 rounded-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white ml-4">Phí giao dịch thấp</h2>
            </div>
            <p class="text-gray-400">MEXC cung cấp mức phí giao dịch cạnh tranh nhất thị trường, giúp bạn tiết kiệm chi phí tối đa.</p>
        </div>

        <!-- Bảo mật cao -->
        <div class="bg-[#1f2023] p-6 rounded-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white ml-4">Bảo mật cao</h2>
            </div>
            <p class="text-gray-400">Hệ thống bảo mật tiên tiến với công nghệ mã hóa nhiều lớp giúp bảo vệ tài khoản của bạn an toàn tuyệt đối.</p>
        </div>

        <!-- Tốc độ giao dịch nhanh -->
        <div class="bg-[#1f2023] p-6 rounded-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white ml-4">Tốc độ giao dịch nhanh</h2>
            </div>
            <p class="text-gray-400">Công nghệ tiên tiến cho phép khớp lệnh cực nhanh, đảm bảo giao dịch không bị trì hoãn.</p>
        </div>

        <!-- Hỗ trợ toàn cầu -->
        <div class="bg-[#1f2023] p-6 rounded-lg">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white ml-4">Hỗ trợ toàn cầu</h2>
            </div>
            <p class="text-gray-400">MEXC có mặt trên toàn cầu với đội ngũ hỗ trợ chuyên nghiệp, sẵn sàng giúp đỡ 24/7.</p>
        </div>
    </div>

    <!-- Nút kết nối -->
    <div class="text-center mt-12">
        <h2 class="text-2xl font-bold text-yellow-500 mb-6">Kết nối với MEXC</h2>
        <a href="{{ route('register') }}" class="inline-block bg-yellow-500 text-black font-bold py-3 px-8 rounded-lg hover:bg-yellow-400 transition-colors">
            Bắt đầu ngay
        </a>
    </div>
</div>
@endsection 