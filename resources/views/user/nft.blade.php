@extends('user.layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-black to-gray-800 py-16 sm:py-16 lg:py-20" style="background-image: url('{{ asset('assets/images/nft.png') }}'); background-size: cover; background-position: center;background-repeat: no-repeat;">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6 lg:space-y-8">
                <div class="space-y-3 lg:space-y-4">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                        Mua tác phẩm nghệ thuật NFT
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-300">
                        Hãy đến <span class="bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent font-bold">Giúp đỡ</span> tất cả trẻ em trên thế giới
                    </p>
                </div>

                <!-- Donation Stats -->
                <div class="space-y-4">
                    <h3 class="text-base sm:text-lg font-semibold text-white">Tổng số tiền quyên góp</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="bg-green-600 rounded-lg p-3 sm:p-4 text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-arrow-up text-white text-base sm:text-lg"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-white">1,528</div>
                            <div class="text-xs sm:text-sm text-green-100">Khối lượng giao dịch (USD)</div>
                        </div>
                        <div class="bg-orange-600 rounded-lg p-3 sm:p-4 text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-arrow-up text-white text-base sm:text-lg"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-white">8,001,524</div>
                            <div class="text-xs sm:text-sm text-orange-100">Số tiền giao dịch (USDT)</div>
                        </div>
                        <div class="bg-purple-600 rounded-lg p-3 sm:p-4 text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-arrow-up text-white text-base sm:text-lg"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-white">7,879</div>
                            <div class="text-xs sm:text-sm text-purple-100">Số lượng NFT (Mảnh)</div>
                        </div>
                        <div class="bg-red-600 rounded-lg p-3 sm:p-4 text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-arrow-up text-white text-base sm:text-lg"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-white">1,028,194</div>
                            <div class="text-xs sm:text-sm text-red-100">Người dùng ảnh</div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        Chúng tôi cam kết quyên góp 30% lợi nhuận từ việc bán NFT cho UNICEF để làm từ thiện.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Hot Section -->
<section class="py-12 sm:py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Hot</h2>
            <a href="#" class="text-cyan-400 hover:text-cyan-300 transition-colors duration-300 text-sm sm:text-base">
                Xem thêm <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            <!-- NFT Card 1 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft1.gif') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">Alejandra Cameron #1677</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">Apollonius</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">1238.43</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">25k</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NFT Card 2 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-blue-400 to-cyan-500 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft2.png') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">Creator #2</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">MGLAND</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">856.21</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">18k</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NFT Card 3 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-purple-400 to-pink-500 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft3.png') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">OrionHead #3</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">OrionHeadforOrionde</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">2341.67</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">32k</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NFT Card 4 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-gray-400 to-gray-600 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft4.png') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">TheSandbox #4</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">TheSandbox</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">987.45</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">15k</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NFT Card 5 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-gray-400 to-gray-600 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft5.png') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">Naccy Bass #5</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">Naccy Bass</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">987.45</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">15k</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NFT Card 6 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-gray-400 to-gray-600 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft6.png') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">MGLAND #6</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">MGLAND</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">987.45</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">15k</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NFT Card 7 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="bg-gradient-to-br from-gray-400 to-gray-600 h-40 sm:h-48 flex items-center justify-center">
                    <img src="{{ asset('assets/images/nft7.png') }}" alt="NFT" class="w-full h-full object-cover">
                </div>
                <div class="p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-400 truncate">OrionHeadforOrionde #7</div>
                    <div class="font-semibold text-white mb-2 flex items-center">
                        <span class="truncate">OrionHeadforOrionde</span>
                        <img src="{{ asset('assets/images/tick.svg') }}" alt="NFT" class="w-3 h-3 sm:w-4 sm:h-4 text-cyan-400 ml-2 flex-shrink-0">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-cyan-400 font-bold text-sm sm:text-base">987.45</span>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-heart text-red-500 text-xs sm:text-sm"></i>
                            <span class="text-xs sm:text-sm text-gray-400">15k</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Creator TOP10 Section -->
<section class="py-12 sm:py-16 bg-black">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-6 sm:mb-8">Featured creator TOP10</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Creator List -->
            <div class="space-y-3 sm:space-y-4">
                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">1</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft5.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">Apollonius</div>
                            <div class="text-xs sm:text-sm text-gray-400">2677 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">2</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft6.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">MGLAND</div>
                            <div class="text-xs sm:text-sm text-gray-400">1890 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">3</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft7.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">OrionHeadforOrionde</div>
                            <div class="text-xs sm:text-sm text-gray-400">1456 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">4</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft1.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">TheSanctumNeophytes</div>
                            <div class="text-xs sm:text-sm text-gray-400">1234 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">5</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft2.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">TheSandbox</div>
                            <div class="text-xs sm:text-sm text-gray-400">987 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>
            </div>

            <div class="space-y-3 sm:space-y-4">
                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">6</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft3.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">WolfPageOfficial</div>
                            <div class="text-xs sm:text-sm text-gray-400">876 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">7</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft4.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">KEEPOUTTHEDGRASS</div>
                            <div class="text-xs sm:text-sm text-gray-400">765 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">8</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-pink-400 to-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset('assets/images/nft5.png') }}" alt="NFT" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">ADORBIT</div>
                            <div class="text-xs sm:text-sm text-gray-400">654 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">9</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-bitcoin text-white text-sm sm:text-base"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">BitcoinPunks</div>
                            <div class="text-xs sm:text-sm text-gray-400">543 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>

                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 sm:p-4 hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <span class="text-xl sm:text-2xl font-bold text-cyan-400 flex-shrink-0">10</span>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-cube text-white text-sm sm:text-base"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-white truncate">CUBE</div>
                            <div class="text-xs sm:text-sm text-gray-400">432 Tác phẩm</div>
                        </div>
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-black px-3 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors duration-300 flex-shrink-0 ml-2">
                        Xem portfolio
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Yield Output Section -->
<section class="py-12 sm:py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-6 sm:mb-8">Sản lượng đầu ra</h2>
        
        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px]">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-white">Địa chỉ người dùng</th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-white">Tên NFT</th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-white">Thu nhập</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="randomTableBody">
                        <!-- Dữ liệu sẽ được tạo ngẫu nhiên bằng JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Become Web3 NFT Certified Creator Section -->
<section class="py-12 sm:py-16 bg-black">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-3 sm:mb-4">Trở thành Người sáng tạo NFT Web3 được chứng nhận</h2>
            <p class="text-base sm:text-lg lg:text-xl text-gray-300">Chúng tôi mong đợi những tài năng sử dụng tác phẩm của mình để tạo ra giá trị và hy vọng</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 mb-8 sm:mb-12">
            <!-- Benefit Cards -->
            <div class="bg-gray-800 rounded-lg p-4 sm:p-6 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="fas fa-check text-white text-lg sm:text-2xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2 sm:mb-3">Logo độc quyền</h3>
                <p class="text-xs sm:text-sm text-gray-400">Được chứng nhận là Web3_NFTCreators, nhận logo chứng nhận độc quyền chính thức Web3_NFT, được liên kết vĩnh viễn với tài khoản người sáng tạo và hiển thị đồng bộ với tác phẩm của người sáng tạo.</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-4 sm:p-6 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="fas fa-bullhorn text-white text-lg sm:text-2xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2 sm:mb-3">Tiếp xúc lưu lượng</h3>
                <p class="text-xs sm:text-sm text-gray-400">Các nhà sáng tạo Web3_NFT được chứng nhận sẽ có cơ hội nhận được sự hỗ trợ chính thức vô hạn, bao gồm hiển thị tác phẩm trên trang chủ của trang web chính thức, cơ hội tiếp xúc với hàng triệu lưu lượng nhanh trên các kênh mạng xã hội và cộng đồng chính thức.</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-4 sm:p-6 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-green-400 to-teal-500 rounded-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="fas fa-edit text-white text-lg sm:text-2xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2 sm:mb-3">Tùy chỉnh hoạt động</h3>
                <p class="text-xs sm:text-sm text-gray-400">Web3_NFT cung cấp cho mỗi nhà sáng tạo được chứng nhận một kế hoạch hỗ trợ hoạt động độc quyền, bao gồm hỗ trợ cho các hoạt động hoạt động trực tuyến và ngoại tuyến khác nhau, và cũng sẽ nhận được tư cách độc quyền để tham gia vào các phiên chia sẻ dự án chất lượng cao chính thức được tổ chức thường xuyên.</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-4 sm:p-6 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="fas fa-headset text-white text-lg sm:text-2xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2 sm:mb-3">Dịch vụ khách hàng độc quyền</h3>
                <p class="text-xs sm:text-sm text-gray-400">Tất cả các nhà sáng tạo Web3_NFT được chứng nhận có thể tận hưởng dịch vụ khách hàng độc quyền 7*24 để đáp ứng mọi nhu cầu Web3_NFT của bạn và có quyền ưu tiên trả lời câu hỏi.</p>
            </div>
        </div>

        <div class="text-center">
            <button class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold transition-all duration-300">
                Tìm hiểu thêm
            </button>
        </div>
    </div>
</section>

<!-- Start Web3 NFT Market Trading Journey Section -->
<section class="py-12 sm:py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white text-center mb-8 sm:mb-12">Bắt đầu hành trình giao dịch thị trường NFT Web3</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <!-- Feature Cards -->
            <div class="bg-gray-800 rounded-lg p-6 sm:p-8 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-coins text-white text-2xl sm:text-3xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-3 sm:mb-4">Nền tảng Web3NFT</h3>
                <p class="text-sm sm:text-base text-gray-400 mb-4 sm:mb-6">Cầu nối giữa các nghệ sĩ hàng đầu và Blockchain.</p>
                <div class="text-3xl sm:text-4xl font-bold text-yellow-400">NFT</div>
            </div>

            <div class="bg-gray-800 rounded-lg p-6 sm:p-8 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-crown text-white text-2xl sm:text-3xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-3 sm:mb-4">Web3NFT VIPCLUB</h3>
                <p class="text-sm sm:text-base text-gray-400 mb-4 sm:mb-6">Trở thành VIP độc quyền của VIPCLUB chúng tôi.</p>
                <div class="text-3xl sm:text-4xl font-bold text-purple-400">VIP</div>
            </div>

            <div class="bg-gray-800 rounded-lg p-6 sm:p-8 text-center hover:bg-gray-700 transition-colors duration-300">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-400 to-teal-500 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <i class="fas fa-shield-alt text-white text-2xl sm:text-3xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-3 sm:mb-4">Hỗ trợ kỹ thuật BTFS</h3>
                <p class="text-sm sm:text-base text-gray-400 mb-4 sm:mb-6">Web3 Sử dụng công nghệ lưu trữ tập trung của BTFS để bảo vệ dữ liệu NFT và tài sản luôn an toàn và có tính khả dụng cao.</p>
                <div class="text-3xl sm:text-4xl font-bold text-green-400">BTFS</div>
            </div>
        </div>
    </div>
</section>

<!-- Partner Logos Section -->
{{-- <section class="py-16 bg-black">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h3 class="text-2xl font-semibold text-white mb-8">Đối tác của chúng tôi</h3>
            <div class="flex flex-wrap justify-center items-center gap-8">
                <div class="bg-gray-800 rounded-lg px-6 py-4 hover:bg-gray-700 transition-colors duration-300">
                    <span class="text-white font-semibold">bitpay</span>
                </div>
                <div class="bg-gray-800 rounded-lg px-6 py-4 hover:bg-gray-700 transition-colors duration-300">
                    <span class="text-white font-semibold">SafePal</span>
                </div>
                <div class="bg-gray-800 rounded-lg px-6 py-4 hover:bg-gray-700 transition-colors duration-300">
                    <span class="text-white font-semibold">ONTO</span>
                </div>
                <div class="bg-gray-800 rounded-lg px-6 py-4 hover:bg-gray-700 transition-colors duration-300">
                    <span class="text-white font-semibold">Pillar</span>
                </div>
                <div class="bg-gray-800 rounded-lg px-6 py-4 hover:bg-gray-700 transition-colors duration-300">
                    <span class="text-white font-semibold">Ledger</span>
                </div>
                <div class="bg-gray-800 rounded-lg px-6 py-4 hover:bg-gray-700 transition-colors duration-300">
                    <span class="text-white font-semibold">D'CENT</span>
                </div>
            </div>
        </div>
    </div>
</section> --}}


@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hàm tạo địa chỉ ví ngẫu nhiên
        function generateRandomAddress() {
            const chars = '0123456789abcdef';
            let address = '0x';
            for (let i = 0; i < 8; i++) {
                address += chars[Math.floor(Math.random() * chars.length)];
            }
            address += '....';
            for (let i = 0; i < 8; i++) {
                address += chars[Math.floor(Math.random() * chars.length)];
            }
            return address;
        }
    
        // Hàm tạo tên NFT ngẫu nhiên
        function generateRandomNFTName() {
            const prefixes = ['#', ''];
            const prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
            const number = Math.floor(Math.random() * 999999999) + 1;
            return prefix + number;
        }
    
        // Hàm tạo thu nhập ngẫu nhiên
        function generateRandomEarnings() {
            return (Math.random() * 10000 + 100).toFixed(2);
        }
    
        // Hàm tạo dữ liệu bảng ngẫu nhiên
        function generateRandomTableData() {
            const tbody = document.getElementById('randomTableBody');
            const rowCount = Math.floor(Math.random() * 10) + 5; // 5-15 hàng ngẫu nhiên
            
            tbody.innerHTML = '';
            
            for (let i = 0; i < rowCount; i++) {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-700 transition-colors duration-300';
                
                const addressCell = document.createElement('td');
                addressCell.className = 'px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-300';
                addressCell.textContent = generateRandomAddress();
                
                const nftNameCell = document.createElement('td');
                nftNameCell.className = 'px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-white';
                nftNameCell.textContent = generateRandomNFTName();
                
                const earningsCell = document.createElement('td');
                earningsCell.className = 'px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-green-400 flex items-center';
                earningsCell.innerHTML = `<i class="fas fa-arrow-up mr-1 sm:mr-2 text-xs sm:text-sm"></i>${generateRandomEarnings()}`;
                
                row.appendChild(addressCell);
                row.appendChild(nftNameCell);
                row.appendChild(earningsCell);
                tbody.appendChild(row);
            }
        }
    
        // Tạo dữ liệu ban đầu
        generateRandomTableData();
    
        // Cập nhật dữ liệu mỗi 30 giây
        setInterval(generateRandomTableData, 3000);
    });
    </script>
@endsection