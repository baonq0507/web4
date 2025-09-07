@extends('user.layouts.app')
@section('title', 'Mời bạn bè')
@section('content')
<div class="min-h-screen bg-black pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Section - Title and Illustration -->
            <div class="text-white">
                <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                    Earn money with your friends
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    Share up to 20% commission on transactions from your referees
                </p>
                
                <!-- Illustration Placeholder -->
                <div class="relative">
                    <img src="{{ asset('assets/images/share.png') }}" alt="Invitation" class="w-full h-full object-cover">
                </div>
                
                <div class="mt-6 text-center">
                    <p class="text-white text-lg font-medium">Invitation Record</p>
                </div>
            </div>

            <!-- Right Section - Invitation Panel -->
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
                <!-- Invitation Code -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-medium mb-2">Invitation code</label>
                    <div class="flex items-center space-x-3">
                        <input type="text" 
                               value="{{ Auth::user()->referral }}" 
                               readonly 
                               class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 font-mono">
                        <button onclick="copyToClipboard('{{ Auth::user()->referral }}')" 
                                class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-3 rounded-lg transition-colors duration-300">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- Invite Link -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-medium mb-2">Invite Link</label>
                    <div class="flex items-center space-x-3">
                        <input type="text" 
                               value="{{ url('/register?ref=' . Auth::user()->referral) }}" 
                               readonly 
                               class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm">
                        <button onclick="copyToClipboard('{{ url('/register?ref=' . Auth::user()->referral) }}')" 
                                class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-3 rounded-lg transition-colors duration-300">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- Generate QR Code Button -->
                <button id="generateQRBtn"
                        class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-4 rounded-lg font-semibold transition-colors duration-300 mb-6 flex items-center justify-center space-x-2">
                    <i class="fa fa-qrcode"></i>
                    <span>Generate QR code</span>
                </button>

                <!-- My Invitation Stats -->
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-white text-lg font-semibold mb-4">My invitation</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-cyan-400">{{ $referredUsers->total() }}</div>
                            <div class="text-sm text-gray-300">Number of invitees</div>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-cyan-400">${{ number_format($totalRebate, 2) }}</div>
                            <div class="text-sm text-gray-300">Total rebate</div>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-cyan-400">${{ number_format($todayRebate, 2) }}</div>
                            <div class="text-sm text-gray-300">Today's rebate</div>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-cyan-400">${{ number_format($monthRebate, 2) }}</div>
                            <div class="text-sm text-gray-300">Rebate this month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referred Users Table -->
        <div class="mt-12">
            <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h3 class="text-xl font-semibold text-white">Referred Users</h3>
                </div>
                
                <div class="p-6">
                    @if($referredUsers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email/Phone</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Join Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Commission</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @foreach($referredUsers as $user)
                                        <tr class="hover:bg-gray-700/50 transition-colors duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center mr-3">
                                                        <span class="text-white text-sm font-semibold">{{ substr($user->name ?? $user->email ?? $user->phone, 0, 1) }}</span>
                                                    </div>
                                                    <div class="text-white font-medium">{{ $user->name ?? 'N/A' }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-gray-300">
                                                {{ $user->email ?? $user->phone ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-gray-300">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if($user->email_verified_at)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Verified
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-cyan-400 font-semibold">
                                                ${{ number_format(0, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($referredUsers->hasMorePages())
                            <div class="flex justify-center mt-6">
                                <button id="load-more-btn" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300">
                                    Load More
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa fa-users text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">No referred users yet</h3>
                            <p class="text-gray-400">Start inviting friends to earn commissions!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrCodeModal" class="fixed inset-0 flex items-center justify-center bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#0f0f23] rounded-2xl p-8 w-full max-w-md relative border border-gray-700 shadow-2xl">
        <button id="closeQRModal" class="absolute top-4 right-4 text-gray-400 hover:text-red-400 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </svg>
        </button>
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">QR Code Invitation</h2>
            <p class="text-cyan-400">Scan to join with your referral code</p>
        </div>
        
        <!-- QR Code Display -->
        <div class="text-center mb-6">
            <div class="bg-white p-6 rounded-xl inline-block shadow-lg">
                <div id="qrcode"></div>
            </div>
        </div>
        
        <!-- Invitation Link -->
        <div class="mb-6">
            <label class="block text-white text-sm font-medium mb-2">Invitation Link</label>
            <div class="flex items-center space-x-3">
                <input type="text" 
                       id="modalInviteLink"
                       value="{{ url('/register?ref=' . Auth::user()->referral) }}" 
                       readonly 
                       class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm">
                <button id="copyLinkBtn"
                        class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-3 rounded-lg transition-colors duration-300">
                    <i class="fa fa-copy"></i>
                </button>
            </div>
        </div>
        
        <!-- Invitation Code -->
        <div class="mb-6">
            <label class="block text-white text-sm font-medium mb-2">Invitation Code</label>
            <div class="flex items-center space-x-3">
                <input type="text" 
                       id="modalInviteCode"
                       value="{{ Auth::user()->referral }}" 
                       readonly 
                       class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 font-mono">
                <button id="copyCodeBtn"
                        class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-3 rounded-lg transition-colors duration-300">
                    <i class="fa fa-copy"></i>
                </button>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <button id="shareBtn"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2">
                <i class="fa fa-share"></i>
                <span>Share</span>
            </button>
            <button id="downloadBtn"
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2">
                <i class="fa fa-download"></i>
                <span>Download</span>
            </button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
    // Wait for QRCode library to load
    window.addEventListener('load', function() {
        console.log('Page loaded, QRCode available:', typeof QRCode !== 'undefined');
    });
</script>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            if (typeof Toastify !== 'undefined') {
                Toastify({
                    text: "Copied to clipboard!",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #06b6d4, #3b82f6)",
                    }
                }).showToast();
            } else {
                alert("Copied to clipboard!");
            }
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }

    function showQRCodeModal() {
        console.log('showQRCodeModal called'); // Debug log
        
        const modal = document.getElementById('qrCodeModal');
        const qrDiv = document.getElementById('qrcode');
        const inviteLink = '{{ url('/register?ref=' . Auth::user()->referral) }}';
        
        console.log('Modal:', modal); // Debug log
        console.log('QR Div:', qrDiv); // Debug log
        console.log('Invite Link:', inviteLink); // Debug log
        
        if (!modal) {
            console.error('Modal not found');
            return;
        }
        
        if (!qrDiv) {
            console.error('QR Div not found');
            return;
        }
        
        // Clear previous QR code
        qrDiv.innerHTML = '';
        
        // Check if QRCode library is loaded
        if (typeof QRCode === 'undefined') {
            console.error('QRCode library not loaded');
            // Try alternative method
            generateQRCodeAlternative(qrDiv, inviteLink);
            modal.classList.remove('hidden');
            return;
        }
        
        // Generate QR code
        QRCode.toCanvas(qrDiv, inviteLink, {
            width: 200,
            height: 200,
            color: {
                dark: '#000000',
                light: '#FFFFFF'
            }
        }, function (error) {
            if (error) {
                console.error('QR Code generation error:', error);
                // Try alternative method
                generateQRCodeAlternative(qrDiv, inviteLink);
            } else {
                console.log('QR Code generated successfully');
            }
            modal.classList.remove('hidden');
        });
    }

    function generateQRCodeAlternative(qrDiv, inviteLink) {
        // Alternative method using online QR code service
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(inviteLink)}`;
        qrDiv.innerHTML = `<img src="${qrUrl}" alt="QR Code" style="width: 200px; height: 200px;">`;
        console.log('QR Code generated using alternative method');
    }

    function shareInvitation() {
        const inviteLink = '{{ url('/register?ref=' . Auth::user()->referral) }}';
        const inviteCode = '{{ Auth::user()->referral }}';
        const shareText = `Join me on {{ config('app_name') }}! Use my invitation code: ${inviteCode}\nLink: ${inviteLink}`;
        
        if (navigator.share) {
            navigator.share({
                title: 'Join {{ config('app_name') }}',
                text: shareText,
                url: inviteLink
            }).catch(console.error);
        } else {
            // Fallback: copy to clipboard
            copyToClipboard(shareText);
        }
    }

    function downloadQRCode() {
        const canvas = document.querySelector('#qrcode canvas');
        if (canvas) {
            const link = document.createElement('a');
            link.download = 'invitation-qr-code.png';
            link.href = canvas.toDataURL();
            link.click();
        }
    }

    // Modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('qrCodeModal');
        const closeBtn = document.getElementById('closeQRModal');
        const generateQRBtn = document.getElementById('generateQRBtn');
        const copyLinkBtn = document.getElementById('copyLinkBtn');
        const copyCodeBtn = document.getElementById('copyCodeBtn');
        const shareBtn = document.getElementById('shareBtn');
        const downloadBtn = document.getElementById('downloadBtn');
        
        // Generate QR Code button
        if (generateQRBtn) {
            console.log('Generate QR button found, adding event listener');
            generateQRBtn.addEventListener('click', function(e) {
                console.log('Generate QR button clicked');
                e.preventDefault();
                showQRCodeModal();
            });
        } else {
            console.error('Generate QR button not found');
        }
        
        // Copy Link button
        if (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', function() {
                const linkInput = document.getElementById('modalInviteLink');
                copyToClipboard(linkInput.value);
            });
        }
        
        // Copy Code button
        if (copyCodeBtn) {
            copyCodeBtn.addEventListener('click', function() {
                const codeInput = document.getElementById('modalInviteCode');
                copyToClipboard(codeInput.value);
            });
        }
        
        // Share button
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                shareInvitation();
            });
        }
        
        // Download button
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                downloadQRCode();
            });
        }
        
        // Close modal when clicking close button
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        }
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        });
    });

    // Load more functionality
    let currentPage = 1;
    const loadMoreBtn = document.getElementById('load-more-btn');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            currentPage++;
            fetch(`/load-more-referred-users?page=${currentPage}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        const tbody = document.querySelector('tbody');
                        tbody.insertAdjacentHTML('beforeend', data.html);
                    }
                    if (!data.hasMorePages) {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading more users:', error);
                });
        });
    }
</script>
@endsection

