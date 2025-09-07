@extends('user.layouts.app')
@section('title', 'Transfer')
@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16 pb-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Transfer Section -->
        <section class="flex-1 min-w-0 rounded-2xl border border-[#232425] px-6 py-6 flex flex-col gap-6 bg-gradient-to-br from-gray-800 to-gray-900">
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-6">Transfer</h2>
                
                <!-- Transfer Form -->
                <form id="transferForm" class="space-y-6">
                    @csrf
                    
                    <!-- Currency Selection -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-300">Select currency</label>
                        <select id="currencySelect" name="currency" class="w-full p-3 bg-[#181a1d] border border-gray-600 rounded-lg text-white focus:border-cyan-400 focus:outline-none">
                            <option value="USDT">USDT</option>
                            @if(isset($wallets) && count($wallets) > 0)
                                @foreach($wallets as $wallet)
                                    <option value="{{ $wallet->symbol->symbol }}">{{ $wallet->symbol->symbol }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Account Selection -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 space-y-2">
                                <label class="text-sm font-medium text-gray-300">From</label>
                                <select id="fromAccount" name="from_account" class="w-full p-3 bg-[#181a1d] border border-gray-600 rounded-lg text-white focus:border-cyan-400 focus:outline-none">
                                    <option value="spot">Spot Account</option>
                                    <option value="wallet">Asset Account</option>
                                </select>
                            </div>
                            
                            <!-- Swap Button -->
                            <div class="flex items-center justify-center px-4">
                                <button type="button" id="swapAccounts" class="p-2 bg-[#181a1d] border border-gray-600 rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-exchange-alt text-cyan-400"></i>
                                </button>
                            </div>
                            
                            <div class="flex-1 space-y-2">
                                <label class="text-sm font-medium text-gray-300">To</label>
                                <select id="toAccount" name="to_account" class="w-full p-3 bg-[#181a1d] border border-gray-600 rounded-lg text-white focus:border-cyan-400 focus:outline-none">
                                    <option value="wallet">Asset Account</option>
                                    <option value="spot">Spot Account</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Amount -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-300">Transfer amount</label>
                        <div class="relative">
                            <input type="number" id="transferAmount" name="amount" step="0.00000001" min="0" placeholder="Please enter" class="w-full p-3 pr-20 bg-[#181a1d] border border-gray-600 rounded-lg text-white focus:border-cyan-400 focus:outline-none">
                            <button type="button" id="transferAll" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 bg-cyan-500 text-white text-xs rounded hover:bg-cyan-600 transition-colors">
                                <i class="fas fa-t"></i> Transfer all
                            </button>
                        </div>
                        <div class="text-sm text-gray-400">
                            Available <span id="availableBalance">0 USDT</span>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <button type="submit" id="confirmTransfer" class="w-full py-3 bg-cyan-500 text-white font-semibold rounded-lg hover:bg-cyan-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirm transfer
                    </button>
                </form>
            </div>
        </section>
        
        <!-- Visual Panel -->
        <div class="flex-1 min-w-0 rounded-2xl overflow-hidden">
            <div class="h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                <div class="text-center text-white p-8">
                    <div class="w-32 h-32 mx-auto mb-4 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-4xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Transfer Assets</h3>
                    <p class="text-gray-400">Chuyển đổi tiền giữa Spot và Wallet một cách dễ dàng</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Transfer Record Section -->
    <div class="mt-8">
        <h3 class="text-xl text-white mb-4">Transfer record</h3>
        <div class="bg-[#181a1d] border border-gray-700 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Currently shared <span id="recordCount">{{ count($transferHistory) }}</span> Records</span>
                </div>
            </div>
            
            <!-- Table Headers -->
            <div class="px-6 py-3 bg-gray-800 border-b border-gray-700">
                <div class="grid grid-cols-5 gap-4 text-sm font-medium text-gray-300">
                    <div>Time of occurrence</div>
                    <div>Crypto</div>
                    <div>Amount</div>
                    <div>From</div>
                    <div>To</div>
                </div>
            </div>
            
            <!-- Transfer Records -->
            <div id="transferRecords">
                @if(isset($transferHistory) && count($transferHistory) > 0)
                    @foreach($transferHistory as $record)
                        <div class="px-6 py-4 border-b border-gray-700 hover:bg-gray-800 transition-colors">
                            <div class="grid grid-cols-5 gap-4 text-sm text-white">
                                <div class="text-gray-400">{{ $record->created_at->format('Y-m-d H:i:s') }}</div>
                                <div class="flex items-center gap-2">
                                    @if($record->symbol)
                                        <img src="{{ $record->symbol->image }}" alt="{{ $record->symbol->symbol }}" class="w-5 h-5 rounded-full">
                                        <span>{{ $record->symbol->symbol }}</span>
                                    @else
                                        <span>USDT</span>
                                    @endif
                                </div>
                                <div>{{ number_format($record->amount, 8, '.', ',') }}</div>
                                <div class="capitalize">{{ $record->note }}</div>
                                <div class="text-green-400">
                                    <i class="fas fa-check-circle"></i> Completed
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-400">Chưa có lịch sử chuyển đổi nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#181a1d] rounded-lg p-6 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-cyan-400 mx-auto mb-4"></div>
        <p class="text-white">Đang xử lý...</p>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#181a1d] rounded-lg p-6 text-center max-w-md">
        <div class="w-16 h-16 mx-auto mb-4 bg-green-500 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-2xl text-white"></i>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">Thành công!</h3>
        <p class="text-gray-400 mb-4" id="successMessage">Chuyển đổi đã được thực hiện thành công</p>
        <button id="closeSuccessModal" class="px-6 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-colors">
            Đóng
        </button>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#181a1d] rounded-lg p-6 text-center max-w-md">
        <div class="w-16 h-16 mx-auto mb-4 bg-red-500 rounded-full flex items-center justify-center">
            <i class="fas fa-times text-2xl text-white"></i>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">Lỗi!</h3>
        <p class="text-gray-400 mb-4" id="errorMessage">Có lỗi xảy ra khi thực hiện chuyển đổi</p>
        <button id="closeErrorModal" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
            Đóng
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currencySelect = document.getElementById('currencySelect');
    const fromAccount = document.getElementById('fromAccount');
    const toAccount = document.getElementById('toAccount');
    const transferAmount = document.getElementById('transferAmount');
    const transferAll = document.getElementById('transferAll');
    const swapAccounts = document.getElementById('swapAccounts');
    const confirmTransfer = document.getElementById('confirmTransfer');
    const availableBalance = document.getElementById('availableBalance');
    const transferForm = document.getElementById('transferForm');
    
    // Load initial balances
    loadBalances();
    
    // Event listeners
    currencySelect.addEventListener('change', loadBalances);
    fromAccount.addEventListener('change', loadBalances);
    toAccount.addEventListener('change', loadBalances);
    
    swapAccounts.addEventListener('click', function() {
        const fromValue = fromAccount.value;
        const toValue = toAccount.value;
        fromAccount.value = toValue;
        toAccount.value = fromValue;
        loadBalances();
    });
    
    transferAll.addEventListener('click', function() {
        const balance = availableBalance.textContent.split(' ')[0];
        transferAmount.value = balance;
    });
    
    transferForm.addEventListener('submit', function(e) {
        e.preventDefault();
        executeTransfer();
    });
    
    // Modal close handlers
    document.getElementById('closeSuccessModal').addEventListener('click', function() {
        document.getElementById('successModal').classList.add('hidden');
    });
    
    document.getElementById('closeErrorModal').addEventListener('click', function() {
        document.getElementById('errorModal').classList.add('hidden');
    });
    
    function loadBalances() {
        const currency = currencySelect.value;
        const from = fromAccount.value;
        
        fetch(`/transfer/balances?currency=${currency}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error loading balances:', data.error);
                    return;
                }
                
                let balance = 0;
                if (from === 'spot') {
                    balance = data.spot_balance || 0;
                } else {
                    balance = data.wallet_balance || 0;
                }
                
                availableBalance.textContent = `${parseFloat(balance).toFixed(8)} ${currency}`;
            })
            .catch(error => {
                console.error('Error loading balances:', error);
            });
    }
    
    function executeTransfer() {
        const formData = new FormData(transferForm);
        
        // Show loading
        document.getElementById('loadingModal').classList.remove('hidden');
        confirmTransfer.disabled = true;
        
        fetch('/transfer/execute', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingModal').classList.add('hidden');
            confirmTransfer.disabled = false;
            
            if (data.success) {
                document.getElementById('successMessage').textContent = data.message;
                document.getElementById('successModal').classList.remove('hidden');
                
                // Reset form
                transferForm.reset();
                loadBalances();
                
                // Reload page after 2 seconds to show updated records
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                document.getElementById('errorMessage').textContent = data.message;
                document.getElementById('errorModal').classList.remove('hidden');
            }
        })
        .catch(error => {
            document.getElementById('loadingModal').classList.add('hidden');
            confirmTransfer.disabled = false;
            document.getElementById('errorMessage').textContent = 'Có lỗi xảy ra khi thực hiện chuyển đổi';
            document.getElementById('errorModal').classList.remove('hidden');
        });
    }
});
</script>
@endpush
