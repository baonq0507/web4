<div class="spot-order-filters bg-[#181a20] rounded-lg p-4 mb-6 border border-[#232428]">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-white font-semibold text-lg">Order History Filters</h3>
        <div class="flex gap-2">
            <button id="export-orders" class="bg-[#3ddeea] text-[#181a20] px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#2bb8c4] transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>Export CSV
            </button>
            <button id="refresh-orders" class="bg-[#232428] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#2a2d38] transition-colors duration-200">
                <i class="fas fa-sync-alt mr-2"></i>Refresh
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Status Filter -->
        <div>
            <label class="block text-gray-400 text-sm mb-2">Status</label>
            <select id="filter-status" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none">
                <option value="all">All Status</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <!-- Type Filter -->
        <div>
            <label class="block text-gray-400 text-sm mb-2">Type</label>
            <select id="filter-type" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none">
                <option value="all">All Types</option>
                <option value="buy">Buy</option>
                <option value="sell">Sell</option>
            </select>
        </div>

        <!-- Symbol Filter -->
        <div>
            <label class="block text-gray-400 text-sm mb-2">Symbol</label>
            <select id="filter-symbol" class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none">
                <option value="all">All Symbols</option>
                @foreach($symbols ?? [] as $symbol)
                <option value="{{ $symbol->id }}">{{ $symbol->symbol }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date Range Filter -->
        <div>
            <label class="block text-gray-400 text-sm mb-2">Date Range</label>
            <div class="flex gap-2">
                <input type="date" id="filter-date-from" class="flex-1 bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none text-sm">
                <input type="date" id="filter-date-to" class="flex-1 bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none text-sm">
            </div>
        </div>
    </div>

    <!-- Search and Apply Filters -->
    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-[#232428]">
        <div class="flex-1">
            <label class="block text-gray-400 text-sm mb-2">Search Order ID</label>
            <input type="text" id="filter-search" placeholder="Enter order ID..." 
                   class="w-full bg-[#101112] text-white px-3 py-2 rounded-md border border-gray-600 focus:border-[#3ddeea] focus:outline-none">
        </div>
        <div class="flex gap-2 items-end">
            <button id="apply-filters" class="bg-[#3ddeea] text-[#181a20] px-6 py-2 rounded-lg font-medium hover:bg-[#2bb8c4] transition-colors duration-200">
                Apply Filters
            </button>
            <button id="clear-filters" class="bg-[#232428] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#2a2d38] transition-colors duration-200">
                Clear
            </button>
        </div>
    </div>

    <!-- Trading Statistics -->
    <div class="mt-6 pt-4 border-t border-[#232428]">
        <h4 class="text-white font-medium mb-3">Trading Statistics</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="trading-stats">
            <div class="text-center bg-[#101112] rounded-lg p-3">
                <p class="text-gray-400 text-xs mb-1">Total Orders</p>
                <p class="text-white font-semibold text-lg" id="stat-total-orders">--</p>
            </div>
            <div class="text-center bg-[#101112] rounded-lg p-3">
                <p class="text-gray-400 text-xs mb-1">Completed</p>
                <p class="text-green-400 font-semibold text-lg" id="stat-completed-orders">--</p>
            </div>
            <div class="text-center bg-[#101112] rounded-lg p-3">
                <p class="text-gray-400 text-xs mb-1">Total Volume</p>
                <p class="text-white font-semibold text-lg" id="stat-total-volume">--</p>
            </div>
            <div class="text-center bg-[#101112] rounded-lg p-3">
                <p class="text-gray-400 text-xs mb-1">Commission</p>
                <p class="text-yellow-400 font-semibold text-lg" id="stat-total-commission">--</p>
            </div>
        </div>
    </div>
</div>
