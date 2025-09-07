@if($contracts->count() > 0)
    @foreach($contracts as $contract)
        <div class="contract-card p-6 position-{{ $contract->position_type }}">
            <div class="flex flex-wrap items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $contract->symbol->symbol ?? 'N/A' }}</h3>
                        <p class="text-sm text-gray-400">{{ ucfirst($contract->contract_type) }} - {{ ucfirst($contract->position_type) }}</p>
                    </div>
                    <span class="leverage-badge">{{ $contract->leverage }}x</span>
                    <span class="status-badge status-{{ $contract->status }}">
                        @switch($contract->status)
                            @case('open')
                                Mở
                                @break
                            @case('closed')
                                Đóng
                                @break
                            @case('liquidated')
                                Liquidated
                                @break
                            @default
                                {{ ucfirst($contract->status) }}
                        @endswitch
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-400">ID: #{{ $contract->id }}</p>
                    <p class="text-xs text-gray-500">{{ $contract->entry_time->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-400">Số lượng</p>
                    <p class="text-white font-semibold">{{ number_format($contract->quantity, 8) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Entry Price</p>
                    <p class="text-white font-semibold">${{ number_format($contract->entry_price, 8) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Current Price</p>
                    <p class="text-white font-semibold">${{ number_format($contract->current_price, 8) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Margin Used</p>
                    <p class="text-white font-semibold">${{ number_format($contract->margin_used, 2) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-400">Unrealized PnL</p>
                    <p class="font-semibold {{ $contract->unrealized_pnl >= 0 ? 'pnl-positive' : 'pnl-negative' }}">
                        ${{ number_format($contract->unrealized_pnl, 2) }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">ROE</p>
                    <p class="font-semibold {{ $contract->roe >= 0 ? 'pnl-positive' : 'pnl-negative' }}">
                        {{ number_format($contract->roe, 2) }}%
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Liquidation Price</p>
                    <p class="text-white font-semibold">${{ number_format($contract->liquidation_price, 8) }}</p>
                </div>
            </div>

            @if($contract->stop_loss || $contract->take_profit)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    @if($contract->stop_loss)
                        <div>
                            <p class="text-sm text-gray-400">Stop Loss</p>
                            <p class="text-red-400 font-semibold">${{ number_format($contract->stop_loss, 8) }}</p>
                        </div>
                    @endif
                    @if($contract->take_profit)
                        <div>
                            <p class="text-sm text-gray-400">Take Profit</p>
                            <p class="text-green-400 font-semibold">${{ number_format($contract->take_profit, 8) }}</p>
                        </div>
                    @endif
                </div>
            @endif

            @if($contract->status === 'open')
                <div class="action-buttons">
                    <button class="btn-close" onclick="openCloseModal({{ $contract->id }}, {{ $contract->quantity }}, {{ $contract->current_price }})">
                        Đóng Position
                    </button>
                    <button class="btn-edit" onclick="openEditModal({{ $contract->id }}, {{ $contract->stop_loss ?? 'null' }}, {{ $contract->take_profit ?? 'null' }})">
                        Sửa SL/TP
                    </button>
                </div>
            @endif

            @if($contract->notes)
                <div class="mt-4 p-3 bg-gray-800 rounded-lg">
                    <p class="text-sm text-gray-400">Ghi chú:</p>
                    <p class="text-white text-sm">{{ $contract->notes }}</p>
                </div>
            @endif

            @if($contract->strategy)
                <div class="mt-4 p-3 bg-blue-900/20 rounded-lg border border-blue-500/30">
                    <p class="text-sm text-blue-400">Chiến lược: {{ $contract->strategy->name }}</p>
                </div>
            @endif
        </div>
    @endforeach

    @if($contracts->hasMorePages())
        <div class="text-center mt-6">
            <button class="btn-primary" onclick="loadMoreContracts()">
                Tải thêm
            </button>
        </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-icon">📊</div>
        <h3 class="text-xl font-semibold mb-2">Không tìm thấy contracts</h3>
        <p class="mb-4">Thử thay đổi bộ lọc hoặc tạo contract mới</p>
    </div>
@endif
