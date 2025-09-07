@extends('user.layouts.app')

@section('title', 'Tin Tức - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-black text-white">
    <div class="py-16 px-2 sm:px-4 min-h-[400px] md:min-h-[400px]" style="background-image: url('{{ asset('assets/images/new.png') }}'); background-size: contain; background-position: right;background-repeat: no-repeat;">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div class="w-full lg:w-2/3">
                    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">News</h1>
                    <p class="text-base sm:text-lg md:text-xl text-white/80 max-w-2xl">Pay attention to market trends in the currency circle to make more informed trading and investment decisions.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- News Content -->
    <div class="py-10 sm:py-16 px-2 sm:px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse($posts as $post)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 border border-white/10 flex flex-col h-full">
                    <div class="p-4 border-b border-white/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center space-x-3">
                            <img src="https://via.placeholder.com/40x40/667eea/ffffff?text={{ substr($post->title, 0, 1) }}" alt="Author" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <div class="text-white font-semibold text-sm">{{ $post->user->name ?? 'Author' }}</div>
                                <div class="text-gray-400 text-xs">{{ $post->created_at->format('Y-m-d H:i:s') }}</div>
                            </div>
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-colors mt-2 sm:mt-0">Follow</button>
                    </div>
                    
                    <div class="relative h-40 sm:h-48 overflow-hidden">
                        @if($post->image)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-newspaper text-white text-4xl sm:text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4 sm:p-5 flex flex-col flex-1">
                        <h5 class="text-base sm:text-lg font-semibold text-white mb-2 sm:mb-3 line-clamp-2">
                            <a href="{{ route('news.show', $post->slug) }}" class="hover:text-blue-400 transition-colors">{{ $post->title }}</a>
                        </h5>
                        <p class="text-gray-300 text-xs sm:text-sm leading-relaxed mb-2 sm:mb-4 flex-1 line-clamp-3">
                            {{ $post->excerpt }}
                        </p>
                        
                        <div class="flex space-x-3 sm:space-x-5 mb-2 sm:mb-4">
                            <div class="flex items-center space-x-1 text-gray-400 text-xs sm:text-sm">
                                <i class="fas fa-heart text-blue-400"></i>
                                <span>{{ rand(100, 2000) }}</span>
                            </div>
                            <div class="flex items-center space-x-1 text-gray-400 text-xs sm:text-sm">
                                <i class="fas fa-comment text-blue-400"></i>
                                <span>{{ rand(50, 1000) }}</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-1 sm:gap-2">
                            <div class="bg-blue-500/10 border border-blue-500/30 rounded-full px-2 sm:px-3 py-1 flex items-center space-x-1 text-xs">
                                <span class="text-white font-semibold">ETH</span>
                                <span class="text-green-400">+0.00%</span>
                            </div>
                            <div class="bg-blue-500/10 border border-blue-500/30 rounded-full px-2 sm:px-3 py-1 flex items-center space-x-1 text-xs">
                                <span class="text-white font-semibold">SOL</span>
                                <span class="text-green-400">+2.15%</span>
                            </div>
                            <div class="bg-blue-500/10 border border-blue-500/30 rounded-full px-2 sm:px-3 py-1 flex items-center space-x-1 text-xs">
                                <span class="text-white font-semibold">BTC</span>
                                <span class="text-red-400">-1.23%</span>
                            </div>
                            <div class="bg-blue-500/10 border border-blue-500/30 rounded-full px-2 sm:px-3 py-1 flex items-center space-x-1 text-xs">
                                <span class="text-white font-semibold">ADA</span>
                                <span class="text-green-400">+3.45%</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-newspaper text-4xl sm:text-6xl"></i>
                        </div>
                        <h4 class="text-white text-lg sm:text-xl mb-2">Chưa có tin tức nào</h4>
                        <p class="text-gray-400">Hiện tại chưa có tin tức nào được xuất bản.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="mt-8 sm:mt-12 flex justify-center">
                <nav class="bg-gray-800 rounded-lg p-2 sm:p-3 shadow-lg border border-white/10">
                    <ul class="flex flex-wrap space-x-1 sm:space-x-2">
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 text-white hover:bg-blue-500 rounded-md transition-colors">
                                <span>&laquo;</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 bg-blue-500 text-white rounded-md">1</a>
                        </li>
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 text-white hover:bg-blue-500 rounded-md transition-colors">2</a>
                        </li>
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 text-white hover:bg-blue-500 rounded-md transition-colors">3</a>
                        </li>
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 text-white hover:bg-blue-500 rounded-md transition-colors">4</a>
                        </li>
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 text-white hover:bg-blue-500 rounded-md transition-colors">5</a>
                        </li>
                        <li>
                            <a href="#" class="px-2 sm:px-3 py-2 text-white hover:bg-blue-500 rounded-md transition-colors">
                                <span>&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
