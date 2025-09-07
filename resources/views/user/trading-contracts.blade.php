@extends('user.layouts.app')
@section('title', 'Trading Contracts')
@section('style')
<style>
    .contract-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border: 1px solid #3ddeea;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .contract-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(61, 222, 234, 0.15);
    }

    .position-long {
        border-left: 4px solid #52c41a;
    }

    .position-short {
        border-left: 4px solid #ff4d4f;
    }

    .pnl-positive {
        color: #52c41a;
    }

    .pnl-negative {
        color: #ff4d4f;
    }

    .leverage-badge {
        background: linear-gradient(45deg, #3ddeea, #2bb8c4);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-open {
        background: rgba(82, 196, 26, 0.2);
        color: #52c41a;
        border: 1px solid #52c41a;
    }

    .status-closed {
        background: rgba(255, 77, 79, 0.2);
        color: #ff4d4f;
        border: 1px solid #ff4d4f;
    }

    .status-liquidated {
        background: rgba(250, 173, 20, 0.2);
        color: #faad14;
        border: 1px solid #faad14;
    }

    .filter-section {
        background: rgba(26, 26, 46, 0.8);
        border: 1px solid #3ddeea;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border: 1px solid #3ddeea;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #3ddeea;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 14px;
        color: #8c8c8c;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-close {
        background: linear-gradient(45deg, #ff4d4f, #ff7875);
        border: none;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-close:hover {
        transform: scale(1.05);
    }

    .btn-edit {
        background: linear-gradient(45deg, #3ddeea, #2bb8c4);
        border: none;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        transform: scale(1.05);
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border: 1px solid #3ddeea;
        border-radius: 12px;
        padding: 24px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #3ddeea;
        font-weight: 600;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #3ddeea;
        border-radius: 6px;
        background: rgba(26, 26, 46, 0.8);
        color: white;
        font-size: 14px;
    }

    .form-input:focus {
        outline: none;
        border-color: #2bb8c4;
        box-shadow: 0 0 0 2px rgba(43, 184, 196, 0.2);
    }

    .form-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #3ddeea;
        border-radius: 6px;
        background: rgba(26, 26, 46, 0.8);
        color: white;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #3ddeea, #2bb8c4);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(61, 222, 234, 0.3);
    }

    .btn-secondary {
        background: rgba(140, 140, 140, 0.2);
        border: 1px solid #8c8c8c;
        color: #8c8c8c;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 8px;
    }

    .btn-secondary:hover {
        background: rgba(140, 140, 140, 0.3);
    }

    .loading {
        display: none;
        text-align: center;
        padding: 20px;
        color: #3ddeea;
    }

    .spinner {
        border: 2px solid rgba(61, 222, 234, 0.3);
        border-top: 2px solid #3ddeea;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        margin: 0 auto 8px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #8c8c8c;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
        color: #3ddeea;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .modal-content {
            width: 95%;
            margin: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Trading Contracts</h1>
        <p class="text-gray-400">Quản lý các hợp đồng giao dịch futures, options và margin trading</p>
    </div>

    <!-- Stats Section -->
    <div class="stats-grid" id="statsSection">
        <div class="stat-card">
            <div class="stat-value" id="totalContracts">0</div>
            <div class="stat-label">Tổng Contracts</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" id="openContracts">0</div>
            <div class="stat-label">Contracts Mở</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" id="totalUnrealizedPnl">$0.00</div>
            <div class="stat-label">Unrealized PnL</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" id="totalRealizedPnl">$0.00</div>
            <div class="stat-label">Realized PnL</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" id="totalMarginUsed">$0.00</div>
            <div class="stat-label">Margin Đã Sử Dụng</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" id="longPositions">0</div>
            <div class="stat-label">Long Positions</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-4">
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" id="statusFilter">
                        <option value="all">Tất cả</option>
                        <option value="open">Mở</option>
                        <option value="closed">Đóng</option>
                        <option value="liquidated">Liquidated</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Loại Contract</label>
                    <select class="form-select" id="contractTypeFilter">
                        <option value="all">Tất cả</option>
                        <option value="futures">Futures</option>
                        <option value="options">Options</option>
                        <option value="perpetual">Perpetual</option>
                        <option value="margin">Margin</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Position Type</label>
                    <select class="form-select" id="positionTypeFilter">
                        <option value="all">Tất cả</option>
                        <option value="long">Long</option>
                        <option value="short">Short</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Symbol</label>
                    <select class="form-select" id="symbolFilter">
                        <option value="all">Tất cả</option>
                        @foreach($symbols as $symbol)
                            <option value="{{ $symbol->id }}">{{ $symbol->symbol }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="btn-primary" onclick="applyFilters()">Áp dụng</button>
                <button class="btn-secondary" onclick="resetFilters()">Reset</button>
                <button class="btn-primary" onclick="openCreateModal()">Tạo Contract</button>
            </div>
        </div>
    </div>

    <!-- Contracts List -->
    <div id="contractsList" class="space-y-4">
        <!-- Contracts will be loaded here -->
    </div>

    <!-- Loading -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
        <div>Đang tải...</div>
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="emptyState" style="display: none;">
        <div class="empty-state-icon">📊</div>
        <h3 class="text-xl font-semibold mb-2">Chưa có contracts nào</h3>
        <p class="mb-4">Bắt đầu tạo contract đầu tiên để bắt đầu giao dịch</p>
        <button class="btn-primary" onclick="openCreateModal()">Tạo Contract</button>
    </div>
</div>

<!-- Create Contract Modal -->
<div class="modal-overlay" id="createModal">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-white mb-4">Tạo Contract Mới</h2>
        <form id="createContractForm">
            <div class="form-group">
                <label class="form-label">Symbol</label>
                <select class="form-select" name="symbol_id" required>
                    <option value="">Chọn Symbol</option>
                    @foreach($symbols as $symbol)
                        <option value="{{ $symbol->id }}">{{ $symbol->symbol }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Loại Contract</label>
                <select class="form-select" name="contract_type" required>
                    <option value="">Chọn loại</option>
                    <option value="futures">Futures</option>
                    <option value="options">Options</option>
                    <option value="perpetual">Perpetual</option>
                    <option value="margin">Margin</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Position Type</label>
                <select class="form-select" name="position_type" required>
                    <option value="">Chọn position</option>
                    <option value="long">Long</option>
                    <option value="short">Short</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Số lượng</label>
                <input type="number" class="form-input" name="quantity" step="0.00000001" min="0.00000001" required>
            </div>
            <div class="form-group">
                <label class="form-label">Leverage</label>
                <input type="number" class="form-input" name="leverage" min="1" max="125" value="10" required>
            </div>
            <div class="form-group">
                <label class="form-label">Entry Price</label>
                <input type="number" class="form-input" name="entry_price" step="0.00000001" min="0.00000001" required>
            </div>
            <div class="form-group">
                <label class="form-label">Stop Loss (tùy chọn)</label>
                <input type="number" class="form-input" name="stop_loss" step="0.00000001" min="0.00000001">
            </div>
            <div class="form-group">
                <label class="form-label">Take Profit (tùy chọn)</label>
                <input type="number" class="form-input" name="take_profit" step="0.00000001" min="0.00000001">
            </div>
            <div class="form-group">
                <label class="form-label">Ghi chú (tùy chọn)</label>
                <textarea class="form-input" name="notes" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary">Tạo Contract</button>
            <button type="button" class="btn-secondary" onclick="closeCreateModal()">Hủy</button>
        </form>
    </div>
</div>

<!-- Close Position Modal -->
<div class="modal-overlay" id="closeModal">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-white mb-4">Đóng Position</h2>
        <form id="closePositionForm">
            <input type="hidden" name="contract_id" id="closeContractId">
            <div class="form-group">
                <label class="form-label">Số lượng đóng</label>
                <input type="number" class="form-input" name="quantity" id="closeQuantity" step="0.00000001" min="0.00000001" required>
            </div>
            <div class="form-group">
                <label class="form-label">Exit Price</label>
                <input type="number" class="form-input" name="exit_price" id="closeExitPrice" step="0.00000001" min="0.00000001" required>
            </div>
            <button type="submit" class="btn-primary">Đóng Position</button>
            <button type="button" class="btn-secondary" onclick="closeCloseModal()">Hủy</button>
        </form>
    </div>
</div>

<!-- Edit SL/TP Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-white mb-4">Cập nhật Stop Loss & Take Profit</h2>
        <form id="editSlTpForm">
            <input type="hidden" name="contract_id" id="editContractId">
            <div class="form-group">
                <label class="form-label">Stop Loss</label>
                <input type="number" class="form-input" name="stop_loss" id="editStopLoss" step="0.00000001" min="0.00000001">
            </div>
            <div class="form-group">
                <label class="form-label">Take Profit</label>
                <input type="number" class="form-input" name="take_profit" id="editTakeProfit" step="0.00000001" min="0.00000001">
            </div>
            <button type="submit" class="btn-primary">Cập nhật</button>
            <button type="button" class="btn-secondary" onclick="closeEditModal()">Hủy</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
let currentPage = 1;
let hasMorePages = false;

// Load initial data
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    loadContracts();
});

// Load statistics
function loadStats() {
    fetch('{{ route("trading-contracts.get-stats") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalContracts').textContent = data.total_contracts;
            document.getElementById('openContracts').textContent = data.open_contracts;
            document.getElementById('totalUnrealizedPnl').textContent = formatCurrency(data.total_unrealized_pnl);
            document.getElementById('totalRealizedPnl').textContent = formatCurrency(data.total_realized_pnl);
            document.getElementById('totalMarginUsed').textContent = formatCurrency(data.total_margin_used);
            document.getElementById('longPositions').textContent = data.long_positions;
        })
        .catch(error => console.error('Error loading stats:', error));
}

// Load contracts
function loadContracts(page = 1) {
    showLoading();
    
    const params = new URLSearchParams({
        page: page,
        status: document.getElementById('statusFilter').value,
        contract_type: document.getElementById('contractTypeFilter').value,
        position_type: document.getElementById('positionTypeFilter').value,
        symbol_id: document.getElementById('symbolFilter').value
    });

    fetch(`{{ route("trading-contracts.get-contracts") }}?${params}`)
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (page === 1) {
                document.getElementById('contractsList').innerHTML = data.html;
            } else {
                document.getElementById('contractsList').innerHTML += data.html;
            }
            
            currentPage = data.nextPage;
            hasMorePages = data.hasMorePages;
            
            if (data.total === 0) {
                showEmptyState();
            } else {
                hideEmptyState();
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error loading contracts:', error);
        });
}

// Apply filters
function applyFilters() {
    currentPage = 1;
    loadContracts();
    loadStats();
}

// Reset filters
function resetFilters() {
    document.getElementById('statusFilter').value = 'all';
    document.getElementById('contractTypeFilter').value = 'all';
    document.getElementById('positionTypeFilter').value = 'all';
    document.getElementById('symbolFilter').value = 'all';
    applyFilters();
}

// Create contract
document.getElementById('createContractForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("trading-contracts.create") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            if (data.message.includes('thành công')) {
                closeCreateModal();
                loadContracts();
                loadStats();
            }
        }
    })
    .catch(error => console.error('Error creating contract:', error));
});

// Close position
function openCloseModal(contractId, quantity, currentPrice) {
    document.getElementById('closeContractId').value = contractId;
    document.getElementById('closeQuantity').value = quantity;
    document.getElementById('closeExitPrice').value = currentPrice;
    document.getElementById('closeModal').style.display = 'flex';
}

document.getElementById('closePositionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    const contractId = data.contract_id;
    
    fetch(`{{ route("trading-contracts.close", ["id" => ":id"]) }}`.replace(':id', contractId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            if (data.message.includes('thành công')) {
                closeCloseModal();
                loadContracts();
                loadStats();
            }
        }
    })
    .catch(error => console.error('Error closing position:', error));
});

// Edit SL/TP
function openEditModal(contractId, stopLoss, takeProfit) {
    document.getElementById('editContractId').value = contractId;
    document.getElementById('editStopLoss').value = stopLoss || '';
    document.getElementById('editTakeProfit').value = takeProfit || '';
    document.getElementById('editModal').style.display = 'flex';
}

document.getElementById('editSlTpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    const contractId = data.contract_id;
    
    fetch(`{{ route("trading-contracts.update-sl-tp", ["id" => ":id"]) }}`.replace(':id', contractId), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            if (data.message.includes('thành công')) {
                closeEditModal();
                loadContracts();
            }
        }
    })
    .catch(error => console.error('Error updating SL/TP:', error));
});

// Modal functions
function openCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.getElementById('createContractForm').reset();
}

function closeCloseModal() {
    document.getElementById('closeModal').style.display = 'none';
    document.getElementById('closePositionForm').reset();
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editSlTpForm').reset();
}

// Close modals when clicking outside
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });
});

// Utility functions
function showLoading() {
    document.getElementById('loading').style.display = 'block';
    document.getElementById('contractsList').style.display = 'none';
}

function hideLoading() {
    document.getElementById('loading').style.display = 'none';
    document.getElementById('contractsList').style.display = 'block';
}

function showEmptyState() {
    document.getElementById('emptyState').style.display = 'block';
    document.getElementById('contractsList').style.display = 'none';
}

function hideEmptyState() {
    document.getElementById('emptyState').style.display = 'none';
    document.getElementById('contractsList').style.display = 'block';
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 8
    }).format(amount);
}

function formatNumber(number, decimals = 8) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: decimals
    }).format(number);
}
</script>
@endsection
