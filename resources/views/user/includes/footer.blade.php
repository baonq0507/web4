<footer class=" text-white py-16 border-t border-cyan-500/30">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/app/' . config('app_logo')) }}" alt="{{ config('app_name') }}" class="h-12 w-auto">
                    <!-- <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                        {{ config('app_name') }}
                    </span> -->
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed max-w-md">
                    {{ config('app_name') }} is a leading cryptocurrency exchange platform that provides secure, fast, and easy trading services to millions of users worldwide.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fab fa-twitter text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fab fa-telegram text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fab fa-discord text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fab fa-facebook text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Trading Market -->
            <div>
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-chart-line text-cyan-400 mr-3"></i>
                    Trading Market
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('trading') }}" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Spot Trading
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Margin Trading
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Futures Trading
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('overview') }}" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Copy Trading
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Asset & Products -->
            <div>
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-coins text-cyan-400 mr-3"></i>
                    Asset & Products
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('bitget.earning') }}" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Earn
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Launchpad
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            API
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Fees
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-headset text-cyan-400 mr-3"></i>
                    Support
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Help Center
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Contact Us
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Trading Rules
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-circle text-xs mr-3 group-hover:text-cyan-400 transition-colors duration-300"></i>
                            Security
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Additional Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 p-6 rounded-2xl border border-cyan-500/30 hover:border-cyan-400/50 transition-all duration-300 group">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-white">Security First</h4>
                        <p class="text-gray-400 text-sm">Enterprise-grade security</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    Your assets are protected with multi-layer security protocols and cold storage solutions.
                </p>
            </div>

            <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 p-6 rounded-2xl border border-purple-500/30 hover:border-purple-400/50 transition-all duration-300 group">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-globe text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-white">Global Access</h4>
                        <p class="text-gray-400 text-sm">Available worldwide</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    Trade from anywhere in the world with our mobile apps and web platform.
                </p>
            </div>

            <div class="bg-gradient-to-r from-green-500/10 to-teal-500/10 p-6 rounded-2xl border border-green-500/30 hover:border-green-400/50 transition-all duration-300 group">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-white">24/7 Support</h4>
                        <p class="text-gray-400 text-sm">Always here for you</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    Our customer support team is available 24/7 to help you with any questions.
                </p>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-cyan-500/30 pt-8 pb-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-sm">
                        Copyright © 2017-{{ date('Y') }} {{ config('app_name') }}. All Rights Reserved.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6 mt-2">
                        <!-- <span class="text-gray-400 text-sm">
                            <i class="fas fa-envelope mr-2 text-cyan-400"></i>
                            support@{{ strtolower(str_replace(' ', '', config('app_name'))) }}.com
                        </span> -->
                        <span class="text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt mr-2 text-cyan-400"></i>
                            Global Headquarters
                        </span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 text-sm">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 text-sm">
                        Terms of Service
                    </a>
                    <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors duration-300 text-sm">
                        Cookie Policy
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Support Button -->
    <!-- <div class="fixed bottom-6 right-6 z-50">
        <button class="w-14 h-14 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white rounded-full shadow-2xl hover:shadow-cyan-500/25 transition-all duration-300 ease-in-out hover:scale-110 group">
            <i class="fas fa-comments text-xl group-hover:animate-bounce"></i>
        </button>
    </div> -->
</footer>