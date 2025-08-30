<!-- Hero Section -->
<div class="relative min-h-screen flex items-center justify-center overflow-hidden mt-0 md:mt-0 lg:mt-0 xl:mt-0 2xl:mt-0 sm:mt-0 mt-20">
    <!-- Background Video -->
    <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0" style="min-width:100%;min-height:100%;">
        <source src="{{ asset('assets/home-banner.mp4') }}" type="video/mp4">
    </video>
    <!-- Optional: Overlay for darkening video and adding color tint -->
    <div class="absolute inset-0  z-0"></div>

    <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
        <!-- Bỏ grid, chỉ giữ nội dung căn giữa -->
        <div class="flex flex-col items-center justify-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left space-y-8 animate__animated animate__fadeInLeft w-full">
                <div class="space-y-6">
                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent">
                            More than
                        </span>
                        <span class="text-white">
                            36 million
                        </span>

                        <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent">
                            users joined
                        </span>
                        <br>
                        <span class="text-white">
                            Web3
                        </span>
                    </h1>
                    
                    <p class="text-base md:text-lg lg:text-xl text-gray-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Safe, Fast, Easy Transactions
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-start">
                    <a href="{{ route('trading') }}" class="group bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-base transition-all duration-300 ease-in-out hover:scale-105 shadow-2xl hover:shadow-cyan-500/25 transform hover:-translate-y-1">
                        <span class="flex items-center justify-center space-x-3">
                            <i class="fas fa-rocket text-lg group-hover:animate-bounce"></i>
                            <span>Start Trading Now</span>
                        </span>
                    </a>
                    
                    @if (!auth()->check())
                    <a href="{{ route('register') }}" class="group bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-4 rounded-2xl font-bold text-base transition-all duration-300 ease-in-out hover:scale-105 shadow-2xl hover:shadow-purple-500/25 transform hover:-translate-y-1">
                        <span class="flex items-center justify-center space-x-3">
                            <i class="fas fa-user-plus text-lg group-hover:animate-pulse"></i>
                            <span>Register Now</span>
                        </span>
                    </a>
                    @endif
                </div>

                <!-- Statistics -->
                <div class="flex flex-col md:flex-row gap-8 pt-2 justify-center">
                    <div class="text-center group flex-1">
                        <div class="bg-gradient-to-r from-cyan-500/20 to-blue-500/20 p-6 rounded-2xl border border-cyan-500/30 hover:border-cyan-400/50 transition-all duration-300 group-hover:scale-105">
                            <div class="text-xl md:text-2xl font-bold text-cyan-400 mb-2 group-hover:text-cyan-300 transition-colors duration-300">
                                $75,311.00M
                            </div>
                            <div class="text-gray-400 text-xs md:text-sm">
                                Total Volume
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center group flex-1">
                        <div class="bg-gradient-to-r from-purple-500/20 to-pink-500/20 p-6 rounded-2xl border border-purple-500/30 hover:border-purple-400/50 transition-all duration-300 group-hover:scale-105">
                            <div class="text-xl md:text-2xl font-bold text-purple-400 mb-2 group-hover:text-purple-300 transition-colors duration-300">
                                100+
                            </div>
                            <div class="text-gray-400 text-xs md:text-sm">
                                Countries
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center group flex-1">
                        <div class="bg-gradient-to-r from-green-500/20 to-teal-500/20 p-6 rounded-2xl border border-green-500/30 hover:border-green-400/50 transition-all duration-300 group-hover:scale-105">
                            <div class="text-xl md:text-2xl font-bold text-green-400 mb-2 group-hover:text-green-300 transition-colors duration-300">
                                20M+
                            </div>
                            <div class="text-gray-400 text-xs md:text-sm">
                                Active Users
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
