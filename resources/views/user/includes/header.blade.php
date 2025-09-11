<header class="text-white w-full shadow fixed top-0 z-50 bg-black">
    <div class="container mx-auto px-4 md:px-6 lg:px-8 flex items-center justify-between h-16">
        <!-- Left Side - Menu Button and Trading/NFT Buttons -->
        <div class="flex items-center space-x-6">
            <!-- Menu Button (Mobile Only) -->
            <button id="menuDrawerBtn" class="lg:hidden flex items-center justify-center w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Trading/NFT Buttons (Desktop Only) -->
            <div class="hidden lg:flex items-center bg-gray-800 rounded-lg p-1">
                <a href="{{ route('trading') }}" class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition-all duration-300">
                    Trading
                </a>
                <a href="{{ route('nft') }}" class="px-4 py-2 text-sm font-medium text-white bg-gray-700 rounded-md transition-all duration-300">
                    NFT
                </a>
            </div>
        </div>

        <!-- Center - Navigation Menu (Desktop Only) -->
        <nav class="hidden lg:flex items-center space-x-8 text-white">
            <!-- Trade Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-1 hover:text-gray-300 transition-colors duration-300">
                    <span>{{ __('index.trade_center') }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute top-full left-0 mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-[320px]">
                    <a href="{{ route('trading') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-list-alt text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">{{ __('index.feature') }}</span>
                            <div class="text-xs text-gray-400">Futures contract trading, high leverage</div>
                        </div>
                    </a>
                    <a href="{{ route('spot-trading') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-chart-line text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">{{ __('index.spot_trading') }}</span>
                            <div class="text-xs text-gray-400">Buy and sell cryptocurrencies instantly</div>
                        </div>
                    </a>
                    <a href="{{ route('market') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-chart-bar text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">{{ __('index.market.title') }}</span>
                            <div class="text-xs text-gray-400">View market prices, latest fluctuations</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Finance Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-1 hover:text-gray-300 transition-colors duration-300">
                    <span>Finance</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute top-full left-0 mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-[280px]">
                    <a href="{{ route('deposit') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-arrow-up text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">{{ __('index.deposit') }}</span>
                            <div class="text-xs text-gray-400">Deposit funds to your account quickly</div>
                        </div>
                    </a>
                    <a href="{{ route('withdraw') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-arrow-down text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">{{ __('index.withdraw') }}</span>
                            <div class="text-xs text-gray-400">Withdraw to your wallet or bank</div>
                        </div>
                    </a>
                    <a href="{{ route('wallet') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-bank text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">{{ __('index.wallet') }}</span>
                            <div class="text-xs text-gray-400">Manage your assets and balances</div>
                        </div>
                    </a>
                    <a href="{{ route('transfer') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fas fa-exchange-alt text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">Transfer</span>
                            <div class="text-xs text-gray-400">Chuyển đổi giữa Spot và Wallet</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Discover Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-1 hover:text-gray-300 transition-colors duration-300">
                    <span>Discover</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute top-full left-0 mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-[280px]">
                    <a href="{{ route('market') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-arrow-up text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">Market Trend</span>
                            <div class="text-xs text-gray-400">Update the latest market trends</div>
                        </div>
                    </a>
                    <a href="{{ route('news') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-newspaper text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">Tin Tức</span>
                            <div class="text-xs text-gray-400">Tin tức và sự kiện crypto nổi bật</div>
                        </div>
                    </a>
                    <a href="/" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-bank text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">Charity</span>
                            <div class="text-xs text-gray-400">Charity activities, community contributions</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Event hail Dropdown -->
            <div class="relative group">
                <button class="flex items-center space-x-1 hover:text-gray-300 transition-colors duration-300">
                    <span>Event hail</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute top-full left-0 mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-[240px]">
                    <a href="{{ route('invitation') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-share text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">Share</span>
                            <div class="text-xs text-gray-400">Share events, receive attractive rewards</div>
                        </div>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-4">
            @if(Auth::check())
            <!-- User Profile -->
            <div class="relative inline-block">
                <button type="button" id="profileDrawerBtn" class="flex items-center justify-center rounded-full bg-gray-800 text-white hover:bg-gray-700 focus:outline-none w-10 h-10 transition-colors duration-300">
                    <img src="{{ Auth::user()->avatar }}" alt="{{ __('index.avatar') }}" class="rounded-full w-full h-full object-cover">
                </button>
            </div>
            @else
            <!-- Login/Register Buttons -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}" class="bg-transparent border border-white text-white px-2 py-2 rounded-lg font-medium hover:bg-white hover:text-black transition-all duration-300 text-sm md:text-base md:px-4 md:py-2">
                    {{ __('index.login') }}
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 rounded-lg font-medium transition-colors duration-300 text-sm md:text-base md:px-4 md:py-2">
                    {{ __('index.register') }}
                </a>
            </div>
            @endif

            <!-- Customer Service Dropdown -->
            <div class="relative group">
                <button id="customerServiceBtn" class="cursor-pointer inline-flex items-center justify-center rounded-full bg-gray-800 text-white hover:bg-gray-700 focus:outline-none w-10 h-10 transition-colors duration-300">
                    <i class="fa fa-headset text-lg"></i>
                </button>
                <div id="customerServiceDropdown" class="absolute top-full right-0 mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-48 z-50">
                    <a href="{{ config('telegram_url') }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fab fa-telegram text-cyan-400"></i>
                        <span>Telegram</span>
                    </a>
                    <a href="{{ config('whatsapp_url') }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fab fa-whatsapp text-green-400"></i>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
            <div class="relative group">
                <button id="walletBtn" class="cursor-pointer inline-flex items-center justify-center rounded-full bg-gray-800 text-white hover:bg-gray-700 focus:outline-none w-10 h-10 transition-colors duration-300">
                    <i class="fa fa-wallet text-lg"></i>
                </button>

                <!-- //dropdown nạp tiền, rút tiền, chuyển đổi tiền tệ -->
                <div id="walletDropdown" class="absolute top-full right-0 mt-2 bg-gray-900 border border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-48 z-50">
                    <a href="{{ route('deposit') }}" class="flex items-center space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-wallet text-cyan-400 mt-1"></i>
                        <span>{{ __('index.deposit') }}</span>
                    </a>
                    <a href="{{ route('withdraw') }}" class="flex items-center space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fa fa-wallet text-cyan-400 mt-1"></i>
                        <span>{{ __('index.withdraw') }}</span>
                    </a>
                    <a href="{{ route('transfer') }}" class="flex items-start space-x-2 px-4 py-2 text-sm hover:bg-gray-800 transition-colors duration-300">
                        <i class="fas fa-exchange-alt text-cyan-400 mt-1"></i>
                        <div>
                            <span class="font-medium">Transfer</span>
                            <div class="text-xs text-gray-400">Chuyển đổi giữa Spot và Wallet</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Language Dropdown -->
            <div class="relative hidden md:block">
                <button type="button" id="dropdownBtn" class="cursor-pointer flex items-center justify-center rounded-full bg-gray-800 text-white hover:bg-gray-700 focus:outline-none w-10 h-10 transition-colors duration-300">
                    <i class="fa fa-globe text-lg"></i>
                </button>

                <div id="dropdownMenu" class="hidden absolute right-0 z-10 mt-2 origin-top-right rounded-lg bg-gray-900 shadow-lg ring-1 ring-gray-700 w-48 border border-gray-700">
                    <div class="py-2">
                        <a href="{{ route('change-language', 'en') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/en.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.english') }}
                        </a>
                        <a href="{{ route('change-language', 'vi') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/vi.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.vietnamese') }}
                        </a>
                        <a href="{{ route('change-language', 'de') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/de.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.germany') }}
                        </a>
                        <a href="{{ route('change-language', 'id') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/id.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.indonesian') }}
                        </a>
                        <a href="{{ route('change-language', 'th') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/th.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.thai') }}
                        </a>
                        <a href="{{ route('change-language', 'ja') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/ja.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.japanese') }}
                        </a>
                        <a href="{{ route('change-language', 'ko') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/ko.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.korean') }}
                        </a>
                        <a href="{{ route('change-language', 'zh') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-gray-800 text-white transition-colors duration-300">
                            <img src="/assets/images/flags/zh.png" class="w-6 h-4 mr-3 rounded"> {{ __('index.chinese') }}
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Menu Drawer (Mobile Only) -->
    <div id="menuDrawer" class="lg:hidden fixed top-0 left-0 h-full bg-[#000000] text-white shadow-2xl transform -translate-x-full transition-transform duration-300 overflow-y-auto border-r " style="z-index: 1000; width: 350px;">
        <div class="p-6 flex justify-between items-center  ">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/app/' . config('app_logo')) }}" alt="{{ config('app_name') }}" class="h-8 w-auto">
                <!-- <span class="text-xl font-bold text-cyan-400">{{ config('app_name') }}</span> -->
            </div>
            <button id="closeMenuDrawerBtn" class="text-cyan-400 hover:text-red-500 text-2xl leading-none transition-colors duration-300">&times;</button>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Trading/NFT Buttons (Mobile) -->
            @php
                $routeName = \Request::route() ? \Request::route()->getName() : '';
            @endphp
            <div class="flex items-center bg-gray-800 rounded-lg p-1 mb-4">
                <a href="{{ route('trading') }}"
                   class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-300 text-center
                   {{ $routeName === 'trading' ? 'text-white bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    Trading
                </a>
                <a href="{{ route('nft') }}"
                   class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-300 text-center
                   {{ $routeName === 'nft' ? 'text-white bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    NFT
                </a>
            </div>
            
            <!-- Mobile Navigation Links -->
            <div class="space-y-4 pt-4 border-t ">
                <h3 class="text-lg font-bold text-white   pb-2">Quick Access</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-home text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.home.home') }}</span>
                    </a>
                    <a href="{{ route('spot-trading') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-chart-line text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.spot_trading') }}</span>
                    </a>
                    {{-- <a href="{{ route('trading-contracts') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-file-contract text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Trading Contracts</span>
                    </a> --}}
                    <a href="{{ route('market') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-chart-bar text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.market.title') }}</span>
                    </a>
                    <a href="{{ route('news') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-newspaper text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Tin Tức</span>
                    </a>
                    <a href="{{ route('trading') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        {{-- <img src="{{ asset('images/app/' . config('app_logo')) }}" class="w-5 h-5 rounded-full"> --}}
                        <i class="fa fa-list-alt text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">features</span>
                    </a>
                    <a href="#"  class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-bank text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.wallet') }}</span>
                    </a>
                    @if(config('disabled_referal') == 'on')
                    <a href="{{ route('invitation') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-gift text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Invitation</span>
                    </a>
                    @endif
                    <a href="{{ route('vip.index') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-crown text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">VIP Welfare</span>
                    </a>
                    <a href="#" id="languageBtn1" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-globe text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.language') }}</span>
                    </a>
                </div>
            </div>

            <!-- Additional Links -->
            <div class="space-y-4 pt-4 border-t ">
                <h3 class="text-lg font-bold text-white   pb-2">Support & Info</h3>
                
                <div class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-headset text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Help Center</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-envelope text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Contact Us</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-shield-alt text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Security</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-file-text text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Terms of Service</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-cyan-500/10 transition-colors duration-300 group">
                        <i class="fa fa-user-secret text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Privacy Policy</span>
                    </a>
                </div>
            </div>

            <!-- Social Media -->
            <div class="space-y-4 pt-4 border-t ">
                <h3 class="text-lg font-bold text-white   pb-2">Follow Us</h3>
                
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

            <!-- Copyright -->
            <div class="pt-4 border-t ">
                <p class="text-gray-400 text-sm text-center">
                    Copyright © 2017-{{ date('Y') }} {{ config('app_name') }}. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Profile Drawer (Keep existing code) -->
    @if(Auth::check())
    <div id="profileDrawer" class="fixed top-0 right-[-12px] h-full bg-gradient-to-b from-[#1a1a2e] to-[#0f0f23] text-white shadow-2xl transform translate-x-full transition-transform duration-300 overflow-y-auto border-l " style="z-index: 1000; width: 350px;">
        <div class="px-6 py-3 flex justify-between items-center  ">
            <span class="text-xl font-bold text-cyan-400">{{ Auth::user()->name }}</span>
            <button id="closeDrawerBtn" class="text-cyan-400 hover:text-red-500 text-2xl leading-none transition-colors duration-300">&times;</button>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- User Info Card -->
            <div class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 border  p-6 rounded-2xl shadow-lg">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img src="{{ Auth::user()->avatar }}" alt="{{ __('index.avatar') }}" class="w-16 h-16 rounded-full border-2 border-cyan-400">
                        <label for="avatar-upload" class="absolute text-white rounded-full p-2 cursor-pointer hover:bg-cyan-600 text-xs bg-cyan-500 transition-colors duration-300" style="bottom: -5px; right:-5px;">
                            <i class="fa fa-camera"></i>
                        </label>
                        <input type="file" id="avatar-upload" class="hidden" accept="image/*">
                    </div>
                    <div class="flex-1">
                        <p class="text-xl font-bold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-cyan-400">UID: {{ Auth::user()->id }}</p>
                        <p class="text-sm text-gray-300">{{ __('index.balance') }}: {{ number_format(Auth::user()->balance, 2, ',', '.') }}$</p>
                    </div>
                </div>
                
                <!-- KYC Status -->
                <div class="mt-4 p-3 bg-gradient-to-r from-gray-800/50 to-gray-700/50 rounded-xl">
                    @if(Auth::user()->verifyUserKyc() && Auth::user()->verifyUserKyc()->status == 'approved')
                    <div class="flex items-center text-green-400">
                        <i class="fa fa-check-circle text-xl mr-3"></i>
                        <span class="font-semibold">{{ __('index.verified') }}</span>
                    </div>
                    @elseif(Auth::user()->verifyUserKyc() && Auth::user()->verifyUserKyc()->status == 'pending')
                    <div class="flex items-center text-yellow-400">
                        <i class="fa fa-clock-o text-xl mr-3"></i>
                        <span class="font-semibold">{{ __('index.pending_verification') }}</span>
                    </div>
                    @else
                    <div class="flex items-center text-red-400">
                        <i class="fa fa-times-circle text-xl mr-3"></i>
                        <span class="font-semibold">{{ __('index.not_verified') }}</span>
                    </div>
                    @endif
                </div>

                @if(config('disabled_referal') == 'on')
                <!-- Referral Code -->
                <div class="mt-4 p-3 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 rounded-xl">
                    <div class="flex items-center justify-between">
                        <span class="text-cyan-400 text-sm font-medium">{{ __('index.referral_code') }}:</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-white font-mono">{{ Auth::user()->referral }}</span>
                            <button onclick="copyToClipboard('{{ Auth::user()->referral }}')" class="text-cyan-400 hover:text-cyan-300 transition-colors duration-300">
                                <i class="fa fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4">
                @if(config('on_security_deposit') == 'off')
                <a href="{{ route('deposit') }}" class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-4 py-3 rounded-xl text-center font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg">
                    <i class="fa fa-arrow-up mr-2"></i>{{ __('index.deposit') }}
                </a>
                @else
                <button class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-4 py-3 rounded-xl text-center font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg on_security_deposit">
                    <i class="fa fa-arrow-up mr-2"></i>{{ __('index.deposit') }}
                </button>
                @endif

                <a href="{{ route('withdraw') }}" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-4 py-3 rounded-xl text-center font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg">
                    <i class="fa fa-arrow-down mr-2"></i>{{ __('index.withdraw') }}
                </a>
            </div>

            <!-- Menu Items -->
            <div class="space-y-3">
                <a href="{{ route('password.change') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-lock text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.change_password') }}</span>
                </a>
                
                <a href="{{ route('password-withdraw') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-lock text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.change_password_withdraw') }}</span>
                </a>
                
                <a href="{{ route('kyc') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-user-check text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.kyc') }}</span>
                </a>
                
                @if(config('disabled_referal') == 'on')
                <a href="{{ route('invitation') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-gift text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">Invitation</span>
                </a>
                <a href="{{ route('referred-users') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-user-friends text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.referral_users') }}</span>
                </a>
                @endif
                
                <a href="{{ route('banklist') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-bank text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.bank_list') }}</span>
                </a>
                
                <a href="{{ route('notifications.index') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group" id="notificationsBtn">
                    <i class="fa fa-bell text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.notifications') }}</span>
                    @php
                    $unreadCount = Auth::user()->unreadNotifications->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </a>
                
                <a href="{{ route('about.me') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-info-circle text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.about_me.title') }}</span>
                </a>
                
                <a href="{{ route('msb') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group">
                    <i class="fa fa-check-circle text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.msb.title') }}</span>
                </a>
                
                <a class="flex items-center space-x-3 p-3 rounded-xl hover:bg-cyan-500/10 transition-colors duration-300 group" id="languageBtn">
                    <i class="fa fa-language text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"></i>
                    <span class="text-white group-hover:text-cyan-300 transition-colors duration-300">{{ __('index.language') }}</span>
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full space-x-3 p-3 rounded-xl hover:bg-red-500/10 transition-colors duration-300 group text-left">
                        <i class="fa fa-sign-out text-red-400 group-hover:text-red-300 transition-colors duration-300"></i>
                        <span class="text-white group-hover:text-red-300 transition-colors duration-300">{{ __('index.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Mobile Navigation -->
    <nav class="text-xl md:hidden fixed bottom-0 left-0 right-0 bg-black text-white flex justify-between items-center py-3 z-50 border-t border-gray-700">
        <a href="{{ route('home') }}" class="hover:text-gray-300 text-center flex flex-col items-center w-1/6 transition-colors duration-300">
            <i class="fa fa-home mb-1 text-lg"></i>
            <span class="text-xs">{{ __('index.home.home') }}</span>
        </a>
        <a href="{{ route('market') }}" class="hover:text-gray-300 text-center flex flex-col items-center w-1/6 transition-colors duration-300">
            <i class="fa fa-chart-line mb-1 text-lg"></i>
            <span class="text-xs">{{ __('index.market.title') }}</span>
        </a>
        <a href="{{ route('trading') }}" class="hover:text-gray-300 text-center flex flex-col items-center w-1/6 transition-colors duration-300">
            <div class="flex items-center justify-center space-x-2 flex-col">
                <img src="{{ asset('images/app/' . config('app_logo')) }}" class="h-8 rounded-full">
                <span class="text-xs">{{ __('index.trade') }}</span>
            </div>
        </a>
        <a href="{{ route('wallet') }}" class="hover:text-gray-300 text-center flex flex-col items-center w-1/6 transition-colors duration-300">
            <i class="fa fa-bank mb-1 text-lg"></i>
            <span class="text-xs">{{ __('index.wallet') }}</span>
        </a>
        <a href="{{ route('transfer') }}" class="hover:text-gray-300 text-center flex flex-col items-center w-1/6 transition-colors duration-300">
            <i class="fas fa-exchange-alt mb-1 text-lg"></i>
            <span class="text-xs">Transfer</span>
        </a>
        <a href="#" class="hover:text-gray-300 text-center flex flex-col items-center w-1/6 transition-colors duration-300" id="profileDrawerBtn1">
            <i class="fa fa-user mb-1 text-lg"></i>
            <span class="text-xs">{{ __('index.profile') }}</span>
        </a>
    </nav>
</header>

@if(!Auth::check())
<!-- Modal Đăng Nhập -->
<div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#0f0f23] rounded-2xl p-8 w-full max-w-md relative border  shadow-2xl">
        <button id="btnCloseLogin" class="cursor-pointer absolute top-4 right-4 text-gray-400 hover:text-red-400 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </svg>
        </button>
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white mb-2">{{ __('index.login') }}</h2>
            <p class="text-cyan-400">Chào mừng bạn trở lại {{ config('app_name') }}</p>
        </div>
        
        <form action="{{ route('loginPost') }}" method="post" id="formLogin" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block mb-2 text-white font-medium">{{ __('index.email') }}</label>
                <input type="email" name="email" placeholder="{{ __('index.email') }}" class="w-full p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
            </div>
            
            <div>
                <label for="password" class="block mb-2 text-white font-medium">{{ __('index.password') }}</label>
                <input type="password" name="password" placeholder="{{ __('index.password') }}" class="w-full p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-4 rounded-xl font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg">
                {{ __('index.login') }}
            </button>
        </form>
    </div>
</div>

<!-- Modal Đăng Ký -->
{{-- <div id="registerModal" class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#0f0f23] rounded-2xl p-8 w-full max-w-md relative border  shadow-2xl">
        <button id="btnCloseRegister" class="absolute top-4 right-4 text-gray-400 hover:text-red-400 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </svg>
        </button>
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white mb-2">{{ __('index.register') }}</h2>
            <p class="text-cyan-400">Tham gia {{ config('app_name') }} ngay hôm nay</p>
        </div>
        
        <form action="{{ route('registerPost') }}" method="post" id="formRegister" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block mb-2 text-white font-medium">{{ __('index.fullname') }}</label>
                <input type="text" name="name" placeholder="{{ __('index.fullname') }}" class="w-full p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
            </div>
            
            <div>
                <label for="phone" class="block mb-2 text-white font-medium">{{ __('index.phone') }}</label>
                <input type="text" name="phone" placeholder="{{ __('index.phone') }}" class="w-full p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
            </div>
            
            <div>
                <label for="email" class="block mb-2 text-white font-medium">Email</label>
                <div class="flex space-x-2">
                    <input type="email" name="email" id="email" placeholder="Nhập email của bạn" class="flex-1 p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                    <button type="button" id="sendVerificationBtn" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-xl font-medium transition-colors duration-300 whitespace-nowrap">
                        Gửi mã
                    </button>
                </div>
            </div>
            
            <div id="verificationSection" class="hidden">
                <label for="verification_code" class="block mb-2 text-white font-medium">Mã xác thực</label>
                <div class="flex space-x-2">
                    <input type="text" name="verification_code" id="verification_code" placeholder="Nhập mã 6 số" maxlength="6" class="flex-1 p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                    <button type="button" id="verifyCodeBtn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-medium transition-colors duration-300 whitespace-nowrap">
                        Xác thực
                    </button>
                </div>
                <div id="verificationStatus" class="mt-2 text-sm"></div>
            </div>
            
            <div>
                <label for="password" class="block mb-2 text-white font-medium">{{ __('index.password') }}</label>
                <input type="password" name="password" placeholder="{{ __('index.password') }}" class="w-full p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
            </div>
            
            @if(config('disabled_referal') == 'on')
            <div>
                <label for="referral_code" class="block mb-2 text-white font-medium">{{ __('index.referral_code') }}</label>
                <input type="text" name="referral_code" placeholder="{{ __('index.enter_referral_code') }}" class="w-full p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
            </div>
            @endif
            
            <div>
                <label for="captcha" class="block mb-2 text-white font-medium">{{ __('index.captcha') }}</label>
                <div class="flex items-center space-x-3">
                    <input type="text" name="captcha" placeholder="{{ __('index.enter_captcha') }}" class="flex-1 p-2 border  rounded-xl bg-[#0f0f23] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300">
                    <img src="{{ captcha_src() }}" alt="captcha" class="captcha-img cursor-pointer rounded-lg" style="height: 40px;">
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="agree_terms" id="agree_terms" class="w-5 h-5 text-cyan-500 bg-[#0f0f23]  rounded focus:ring-cyan-500 focus:ring-2">
                <label for="agree_terms" class="text-sm text-gray-300">{{ __('index.agree_terms', ['app_name' => config('app_name')]) }}</label>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white py-4 rounded-xl font-semibold transition-all duration-300 ease-in-out hover:scale-105 shadow-lg">
                {{ __('index.register') }}
            </button>
        </form>
    </div>
</div> --}}
@endif

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        if (typeof Toastify !== 'undefined') {
            Toastify({
                text: "{{ __('index.copied_to_clipboard') }}",
                duration: 3000,
                gravity: "top",
                style: {
                    background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                }
            }).showToast();
        } else {
            alert("{{ __('index.copied_to_clipboard') }}");
        }
    }

    // Menu Drawer functionality
    document.addEventListener('DOMContentLoaded', function() {
        const menuDrawerBtn = document.getElementById('menuDrawerBtn');
        const closeMenuDrawerBtn = document.getElementById('closeMenuDrawerBtn');
        const menuDrawer = document.getElementById('menuDrawer');
        const profileDrawerBtn = document.getElementById('profileDrawerBtn');
        const profileDrawerBtn1 = document.getElementById('profileDrawerBtn1');
        const closeDrawerBtn = document.getElementById('closeDrawerBtn');
        const profileDrawer = document.getElementById('profileDrawer');
        const walletBtn = document.getElementById('walletBtn');
        const walletDropdown = document.getElementById('walletDropdown');
        // Trading/NFT Button functionality
        function initTradingNftButtons() {
            // Desktop buttons
            const desktopTradingBtn = document.querySelector('.hidden.lg\\:flex a[href="{{ route('trading') }}"]');
            const desktopNftBtn = document.querySelector('.hidden.lg\\:flex a[href="#"]');
            
            // Mobile buttons
            const mobileTradingBtn = document.querySelector('.flex.items-center.bg-gray-800 a[href="{{ route('trading') }}"]');
            const mobileNftBtn = document.querySelector('.flex.items-center.bg-gray-800 a[href="#"]');
            
            function setActiveButton(activeBtn, inactiveBtn) {
                // Set active button
                activeBtn.classList.remove('text-gray-300', 'hover:bg-gray-700');
                activeBtn.classList.add('text-white', 'bg-gray-700');
                
                // Set inactive button
                inactiveBtn.classList.remove('text-white', 'bg-gray-700');
                inactiveBtn.classList.add('text-gray-300', 'hover:bg-gray-700');
            }
            
            // Desktop button events
            if (desktopTradingBtn && desktopNftBtn) {
                desktopTradingBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    setActiveButton(desktopTradingBtn, desktopNftBtn);
                    // Also update mobile buttons
                    if (mobileTradingBtn && mobileNftBtn) {
                        setActiveButton(mobileTradingBtn, mobileNftBtn);
                    }
                });
                
                desktopNftBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    setActiveButton(desktopNftBtn, desktopTradingBtn);
                    // Also update mobile buttons
                    if (mobileTradingBtn && mobileNftBtn) {
                        setActiveButton(mobileNftBtn, mobileTradingBtn);
                    }
                });
            }
            
            // Mobile button events
            if (mobileTradingBtn && mobileNftBtn) {
                mobileTradingBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    setActiveButton(mobileTradingBtn, mobileNftBtn);
                    // Also update desktop buttons
                    if (desktopTradingBtn && desktopNftBtn) {
                        setActiveButton(desktopTradingBtn, desktopNftBtn);
                    }
                });
                
                mobileNftBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    setActiveButton(mobileNftBtn, mobileTradingBtn);
                    // Also update desktop buttons
                    if (desktopTradingBtn && desktopNftBtn) {
                        setActiveButton(desktopNftBtn, desktopTradingBtn);
                    }
                });
            }
        }
        
        // Initialize trading/NFT buttons
        initTradingNftButtons();
        
        // Customer Service Dropdown functionality
        const customerServiceBtn = document.getElementById('customerServiceBtn');
        const customerServiceDropdown = document.getElementById('customerServiceDropdown');

        // Toggle customer service dropdown
        if (customerServiceBtn && customerServiceDropdown) {
            customerServiceBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isVisible = customerServiceDropdown.classList.contains('opacity-100');
                
                if (isVisible) {
                    customerServiceDropdown.classList.remove('opacity-100', 'visible');
                    customerServiceDropdown.classList.add('opacity-0', 'invisible');
                } else {
                    customerServiceDropdown.classList.remove('opacity-0', 'invisible');
                    customerServiceDropdown.classList.add('opacity-100', 'visible');
                }
            });
        }

        // Close customer service dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (customerServiceDropdown && customerServiceBtn && 
                !customerServiceDropdown.contains(event.target) && 
                !customerServiceBtn.contains(event.target)) {
                customerServiceDropdown.classList.remove('opacity-100', 'visible');
                customerServiceDropdown.classList.add('opacity-0', 'invisible');
            }
        });

        // Open menu drawer
        if (menuDrawerBtn) {
            menuDrawerBtn.addEventListener('click', function() {
                menuDrawer.classList.remove('-translate-x-full');
                menuDrawer.classList.add('translate-x-0');
            });
        }

        // Close menu drawer
        if (closeMenuDrawerBtn) {
            closeMenuDrawerBtn.addEventListener('click', function() {
                menuDrawer.classList.remove('translate-x-0');
                menuDrawer.classList.add('-translate-x-full');
            });
        }

        // Close menu drawer when clicking outside
        document.addEventListener('click', function(event) {
            if (menuDrawer && !menuDrawer.contains(event.target) && !menuDrawerBtn.contains(event.target)) {
                if (menuDrawer.classList.contains('translate-x-0')) {
                    menuDrawer.classList.remove('translate-x-0');
                    menuDrawer.classList.add('-translate-x-full');
                }
            }
        });

        // Profile drawer functionality
        if (profileDrawerBtn) {
            profileDrawerBtn.addEventListener('click', function() {
                profileDrawer.classList.remove('translate-x-full');
                profileDrawer.classList.add('translate-x-0');
            });
        }

        if (profileDrawerBtn1) {
            profileDrawerBtn1.addEventListener('click', function() {
                profileDrawer.classList.remove('translate-x-full');
                profileDrawer.classList.add('translate-x-0');
            });
        }

        if (closeDrawerBtn) {
            closeDrawerBtn.addEventListener('click', function() {
                profileDrawer.classList.remove('translate-x-0');
                profileDrawer.classList.add('translate-x-full');
            });
        }

        // Close profile drawer when clicking outside
        document.addEventListener('click', function(event) {
            if (profileDrawer && !profileDrawer.contains(event.target) && !profileDrawerBtn.contains(event.target) && !profileDrawerBtn1.contains(event.target)) {
                if (profileDrawer.classList.contains('translate-x-0')) {
                    profileDrawer.classList.remove('translate-x-0');
                    profileDrawer.classList.add('translate-x-full');
                }
            }
        });


        // Wallet dropdown functionality
        if (walletBtn) {
            walletBtn.addEventListener('click', function() {
                walletDropdown.classList.remove('translate-x-full');
                walletDropdown.classList.add('translate-x-0');
            });
        }
    });
</script>