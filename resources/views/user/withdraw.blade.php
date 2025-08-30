@extends('user.layouts.app')
@section('title', __('index.withdraw'))
@section('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css">
@endsection
@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Deposit Form Card -->
        <section class="flex-1 min-w-0 bg-[#181a1d] rounded-2xl border border-[#232425] p-10 flex flex-col gap-10">
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold mb-2 text-white">{{ __('index.withdraw') }}</h1>
                <button class="text-white/70 hover:text-white" onclick="document.getElementById('historyModal').classList.remove('hidden')">
                    <i class="fa-solid fa-history"></i>
                    {{ __('index.history_withdraw') }}
                </button>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-white/70 text-sm">
                    {{ __('index.available_balance') }}: {{ number_format($user->balance, 2, ',', '.') }} USDT
                </div>
            </div>
            <form id="withdrawForm" action="{{ route('withdrawPost') }}" method="POST">
                @csrf
                <input type="hidden" name="withdraw_type" value="bank">
                <div>
                    <ol class="flex flex-col gap-8">
                        <li>
                            <span class="font-semibold text-lg flex items-center gap-2 text-white">
                                <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">1</span>
                                {{ __('index.select_bank') }}
                            </span>
                            <div class="mt-4">
                                <select name="bank_id" class="w-full bg-[#232425] text-white/70 rounded-lg px-4 py-3 outline-none" id="bank_id" required>
                                    @foreach($banks as $bank)
                                    <option class="w-full" value="{{ $bank->id }}">{{ $bank->bank_name . ' - ' . $bank->bank_owner }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>

                        <li>
                            <span class="font-semibold text-lg flex items-center gap-2 text-white">
                                <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">2</span>
                                {{ __('index.enter_amount_withdraw') }}
                            </span>
                            <div class="flex items-center w-full rounded-lg bg-[#232425] mt-4">
                                <input type="text" name="amount" class="flex-1 text-white/70 rounded-lg px-4 py-3 outline-none" id="amount" required />
                                <span class="px-4 py-2 text-white">USDT</span>
                            </div>
                        </li>
                        @if(config('on_security_withdraw') == 'on')
                        <li>
                            <span class="font-semibold text-lg flex items-center gap-2 text-white">
                                <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">3</span>
                                {{ __('index.enter_password_withdraw') }}
                            </span>
                            <div class="mt-4">
                                <input type="password" name="password" class="w-full bg-[#232425] text-white/70 rounded-lg px-4 py-3 outline-none" id="password" required />
                            </div>
                        </li>
                        @endif
                    </ol>
                </div>
                <button type="submit" class="cursor-pointer w-full rounded-full border-2 border-[#fff] py-2.5 font-bold text-white text-lg mt-8 hover:bg-[#ff622d] transition-all duration-300" id="withdraw-button">{{ __('index.withdraw') }}</button>
            </form>
        </section>

    </div>

</main>

<!-- modal history -->
<div id="historyModal" class="fixed inset-0 z-50 flex mt-16 justify-center hidden bg-opacity-50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#181a1d] rounded-lg shadow-lg md:max-w-[70%] md:max-h-[70%] overflow-y-auto w-[90%]">
        <div class="flex justify-between items-center p-4 border-b border-white/20">
            <h5 class="text-lg font-semibold text-white" id="historyModalLabel">{{ __('index.history_withdraw') }}</h5>
            <button type="button" class="cursor-pointer hover:text-white text-white/70" onclick="document.getElementById('historyModal').classList.add('hidden')">
                <span class="sr-only">{{ __('index.close') }}</span>
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-4">
            <!-- Desktop Table View -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.code') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.phone') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.method') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.date') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.amount') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/20" id="withdrawHistoryTable">
                        @if($withdraw->count() > 0)
                        @foreach($withdraw as $item)
                        @include('user.partials.withdraw-row', ['item' => $item])
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="px-4 py-4 whitespace-nowrap text-sm text-white text-center">{{ __('index.no_data') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if($withdraw->hasMorePages())
                <div class="mt-4 text-center">
                    <button id="loadMoreWithdraw" class="cursor-pointer bg-[#ff622d] text-white px-6 py-2 rounded-md hover:bg-[#ff622d]/80 transition-all duration-300" data-page="2">
                        {{ __('index.load_more') }}
                    </button>
                </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4" id="withdrawHistoryCards">
                @if($withdraw->count() > 0)
                @foreach($withdraw as $item)
                @include('user.partials.withdraw-card', ['item' => $item])
                @endforeach
                @else
                <div class="text-center text-white">{{ __('index.no_data') }}</div>
                @endif
                @if($withdraw->hasMorePages())
                <div class="text-center">
                    <button id="loadMoreWithdrawMobile" class="cursor-pointer bg-[#ff622d] text-white px-6 py-2 rounded-md hover:bg-[#ff622d]/80 transition-all duration-300" data-page="2">
                        {{ __('index.load_more') }}
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    let depositType = 'bank';

    $(document).ready(function() {
        const btn = $('#withdraw-button');
        $('#withdrawForm').submit(function(e) {
            e.preventDefault();
            btn.prop('disabled', true);
            btn.html("{{ __('index.loading') }}");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                    reloadPage(['#historyModal', '.balance-value'], ['#historyModal', '.balance-value']);
                    $('#historyModal').removeClass('hidden');
                },
                error: function(response) {
                    if (response.responseJSON.message === "{{ __('index.verify_kyc_required') }}") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message,
                            confirmButtonText: "{{ __('index.kyc') }}",
                            confirmButtonColor: "#3ddeea",
                        }).then(function() {
                            window.location.href = "{{ route('kyc') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message,
                        });
                    }
                },
                complete: function() {
                    btn.prop('disabled', false);
                    btn.html("{{ __('index.withdraw') }}");
                }
            });
        });

        let currentPage = 2;
        let isLoading = false;

        function loadMoreWithdraw(isMobile) {
            if (isLoading) return;
            isLoading = true;

            const button = isMobile ? $('#loadMoreWithdrawMobile') : $('#loadMoreWithdraw');
            button.prop('disabled', true).html("{{ __('index.loading') }}");

            $.ajax({
                url: "{{ route('loadMoreWithdrawHistory') }}",
                type: 'GET',
                data: {
                    page: currentPage,
                    is_mobile: isMobile
                },
                success: function(response) {
                    if (isMobile) {
                        $('#withdrawHistoryCards').append(response.html);
                    } else {
                        $('#withdrawHistoryTable').append(response.html);
                    }

                    if (!response.hasMorePages) {
                        button.remove();
                    } else {
                        currentPage = response.nextPage;
                        button.prop('disabled', false).html("{{ __('index.load_more') }}");
                    }
                },
                error: function() {
                    button.prop('disabled', false).html("{{ __('index.load_more') }}");
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }
        $(document).on('click', '#loadMoreWithdraw', function() {
            loadMoreWithdraw(false);
        });

        $(document).on('click', '#loadMoreWithdrawMobile', function() {
            loadMoreWithdraw(true);
        });
    });
</script>
@endsection