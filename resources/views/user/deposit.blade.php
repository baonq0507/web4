@extends('user.layouts.app')
@section('title', __('index.deposit'))
@section('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css">
@endsection
@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16 pb-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Deposit Form Card -->
        <section class="flex-1 min-w-0 bg-[#181a1d] rounded-2xl border border-[#232425] p-10 flex flex-col gap-10">
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold mb-2 text-white">{{ __('index.deposit') }}</h1>
                <button class="text-white/70 hover:text-white" onclick="document.getElementById('historyModal').classList.remove('hidden')">
                    <i class="fa-solid fa-history"></i>
                    {{ __('index.history') }}
                </button>
            </div>
            <div class="flex gap-3 mb-2">
                <button id="bankTab" class="cursor-pointer text-sm bg-[#ff622d] rounded px-6 py-2 font-medium text-white" onclick="showTab('bank')">{{ __('index.bank_transfer') }}</button>
                <button id="usdtTab" class="cursor-pointer text-sm bg-[#232425] rounded px-6 py-2 font-medium text-white/80" onclick="showTab('usdt')">{{ __('index.crypto_transfer') }}</button>
            </div>
            <div id="bankContent" class="tab-content">
                <ol class="flex flex-col gap-8">
                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">1</span>
                            {{ __('index.select_bank') }}
                        </span>
                        <div class="mt-4">
                            <select class="w-full bg-[#232425] text-white/70 rounded-lg px-4 py-3 outline-none" id="bank_select">
                                <option value="" disabled selected>Chọn ngân hàng</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bank_name . ' - ' . $bank->bank_number . ' - ' . $bank->bank_owner }}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">2</span>
                            {{ __('index.enter_amount') }}
                        </span>
                        <div class="mt-4">
                            <input class="w-full bg-[#232425] text-white/90 rounded-lg px-4 py-3 outline-none" id="amount_input" />
                            <div class="text-white/70 mt-1" id="amount_result"> = 0₫</div>
                        </div>
                    </li>
                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">3</span>
                            {{ __('index.bill_image') }}
                        </span>
                        <div class="mt-4">
                            <div id="bill-image-dropzone" class="w-full h-40 bg-white/10 rounded-lg border border-white/20 cursor-pointer dropzone text-center flex justify-center items-center text-white/70"></div>
                        </div>
                    </li>

                </ol>
            </div>
            <div id="usdtContent" class="tab-content hidden">
                <ol class="flex flex-col gap-8">
                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">1</span>
                            {{ __('index.select_crypto') }}
                        </span>
                        <div class="mt-4">
                            <select class="w-full bg-[#232425] text-white/70 rounded-lg px-4 py-3 outline-none" id="usdt_wallet_select">
                                <option value="" disabled selected>{{ __('index.select_bank') }}</option>
                                @foreach($usdt_wallets as $usdt_wallet)
                                <option data-usdt-wallet="{{ $usdt_wallet->bank_number }}" value="{{ $usdt_wallet->id }}">{{ $usdt_wallet->bank_number . ' - ' . $usdt_wallet->bank_owner }}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">2</span>
                            {{ __('index.enter_amount') }}
                        </span>
                        <div class="mt-4">
                            <input class="w-full bg-[#232425] text-white/90 rounded-lg px-4 py-3 outline-none" id="amount_input_usdt" />
                        </div>
                    </li>
                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">3</span>
                            {{ __('index.bill_image') }}
                        </span>
                        <div class="mt-4">
                            <div id="bill-image-dropzone-usdt" class="w-full h-40 bg-white/10 rounded-lg border border-white/20 cursor-pointer dropzone text-center flex justify-center items-center text-white/70"></div>
                        </div>
                    </li>
                </ol>
            </div>
            <button class="cursor-pointer w-full rounded-full border-2 border-[#fff] py-2.5 font-bold text-white text-lg mt-2 hover:bg-[#ff622d] transition-all duration-300" id="deposit-button">{{ __('index.deposit') }}</button>
        </section>

        <!-- Sidebar: Mẹo & FAQ -->
        <aside class="w-full max-w-md flex flex-col gap-6">
            <!-- Tips -->
            <div class="bg-[#202226] rounded-2xl p-6">
                <div class="flex items-center"><span class="text-base font-semibold ml-2 text-white">💡 {{ __('index.tips') }}</span></div>
                <ul class="mt-4 space-y-3 text-white/70 text-sm list-disc list-inside text-white/70">
                    <li>{{ __('index.do_not_deposit_other_assets_except_usdt') }}</li>
                    <li>{{ __('index.do_not_deposit_under_minimum_amount') }}</li>
                    <li>{{ __('index.ensure_device_security') }}</li>
                </ul>
            </div>
            <!-- FAQ -->
            <div class="bg-[#181a1d] border border-[#232425] rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-xl text-white">{{ __('index.faq') }}</span>
                    <!-- <span class="text-xs text-white/50 cursor-pointer">Thêm &gt;</span> -->
                </div>
                <ul class="mt-4 divide-y divide-[#232425]">
                    <li class="py-3 flex justify-between items-center cursor-pointer hover:bg-[#232425] rounded-lg text-white/70" onclick="$(this).next().slideToggle();">
                        <span class="ml-2">{{ __('index.how_to_handle_deposit_error') }}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </li>
                    <div class="hidden text-white/70 text-sm">
                        {{ __('index.bixnex_supports_users_to_recover_lost_money_due_to_incorrect_deposit_by_verification_processes') }}
                        {{ __('index.when_depositing_assets_on_the_bixnex_exchange', ['app_name' => config('app_name')]) }}
                    </div>
                    <li class="py-3 flex justify-between items-center cursor-pointer hover:bg-[#232425] rounded-lg text-white/70" onclick="$(this).next().slideToggle();">
                        <span class="ml-2">{{ __('index.how_to_handle_deposit_error') }}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </li>
                    <div class="hidden text-white/70 text-sm">
                        {{ __('index.when_the_deposit_order_is_sent_to_the_bixnex_exchange_the_exchange_checks_and_verifies_the_deposit_order_the_amount_is_credited_to_the_user_s_account') }}
                        {{ __('index.if_the_deposit_order_is_approved_late_than_expected_the_user_can_click_on_customer_support_to_approve_the_order_faster') }}
                        {{ __('index.all_cases_of_user_will_be_supported_by_customer_support_staff') }}
                        {{ __('index.the_user_needs_to_provide_the_deposit_information_and_the_history_for_the_check_to_be_easy') }}
                    </div>
                    <li class="py-3 flex justify-between items-center cursor-pointer hover:bg-[#232425] rounded-lg text-white/70" onclick="$(this).next().slideToggle();">
                        <span class="ml-2">{{ __('index.how_to_deposit_crypto_to_bixnex_account', ['app_name' => config('app_name')]) }}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </li>
                    <div class="hidden text-white/70 text-sm ">
                        {{ __('index.before_performing_the_deposit_operation_the_user_needs_to_note_the_following_points') }}
                        <ol class="list-decimal list-inside">
                            <li>{{ __('index.choose_the_correct_network_allowed_to_deposit_into_the_bixnex_exchange') }}</li>
                            <li>{{ __('index.read_the_deposit_notes_carefully') }}</li>
                            <li>{{ __('index.scanning_the_transfer_code_will_be_convenient_for_the_transfer_of_money') }}</li>
                            <li>{{ __('index.copying_the_wallet_address_and_pasting_the_wallet_address_needs_to_be_checked_carefully_before_clicking_the_deposit_command') }}</li>
                            <li>{{ __('index.after_completing_the_deposit_operation_check_the_history_and_wait_for_the_order_to_be_approved') }}</li>
                        </ol>
                    </div>
                </ul>
            </div>
        </aside>
    </div>

</main>

<!-- modal history -->
<div id="historyModal" class="fixed inset-0 z-50 flex mt-16 justify-center hidden bg-opacity-50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#181a1d] rounded-lg shadow-lg md:max-w-[70%] md:max-h-[70%] overflow-y-auto w-[90%]">
        <div class="flex justify-between items-center p-4 border-b border-white/20">
            <h5 class="text-lg font-semibold text-white" id="historyModalLabel">{{ __('index.history') }}</h5>
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
                    <tbody class="divide-y divide-white/20" id="depositHistoryTable">
                        @if($deposit->count() > 0)
                        @foreach($deposit as $item)
                        @include('user.partials.deposit-row', ['item' => $item])
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="px-4 py-4 whitespace-nowrap text-sm text-white text-center">{{ __('index.no_data') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if($deposit->hasMorePages())
                <div class="mt-4 text-center">
                    <button id="loadMoreDeposit" class="cursor-pointer bg-[#ff622d] text-white px-6 py-2 rounded-md hover:bg-[#ff622d]/80 transition-all duration-300" data-page="2">
                        {{ __('index.load_more') }}
                    </button>
                </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4" id="depositHistoryCards">
                @if($deposit->count() > 0)
                @foreach($deposit as $item)
                @include('user.partials.deposit-card', ['item' => $item])
                @endforeach
                @else
                <div class="text-center text-white">{{ __('index.no_data') }}</div>
                @endif
                @if($deposit->hasMorePages())
                <div class="text-center">
                    <button id="loadMoreDepositMobile" class="cursor-pointer bg-[#ff622d] text-white px-6 py-2 rounded-md hover:bg-[#ff622d]/80 transition-all duration-300" data-page="2">
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

    function showTab(tab) {
        document.getElementById('bankContent').classList.add('hidden');
        document.getElementById('usdtContent').classList.add('hidden');
        document.getElementById('bankTab').classList.remove('bg-[#ff622d]');
        document.getElementById('usdtTab').classList.remove('bg-[#ff622d]');
        document.getElementById('bankTab').classList.add('bg-[#232425]');
        document.getElementById('usdtTab').classList.add('bg-[#232425]');

        if (tab === 'bank') {
            document.getElementById('bankContent').classList.remove('hidden');
            document.getElementById('bankTab').classList.add('bg-[#ff622d]');
            depositType = 'bank';
        } else {
            document.getElementById('usdtContent').classList.remove('hidden');
            document.getElementById('usdtTab').classList.add('bg-[#ff622d]');
            depositType = 'usdt';
        }
    }
    showTab(depositType);
    const formatNumber = (number) => {
        return number.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }
    $('#amount_input').on('input', function() {
        const amount = $(this).val();
        const rate = 25000;
        $('#amount_result').text('= ' + formatNumber(amount * rate));
    });
    let billImageDropzone = '';
    let billImageDropzoneUsdt = '';
    Dropzone.autoDiscover = false;
    Dropzone.options.billImageDropzone = {
        url: "{{ route('upload') }}",
        maxFiles: 1,
        maxFilesize: 2,
        acceptedFiles: 'image/*',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
        },
        addRemoveLinks: true,
        dictDefaultMessage: "<div class='flex flex-col items-center'><img src='/assets/images/icon_upload.png?v=4' alt='upload' class='w-12 h-12 mb-2'>" +
            "<span class='text-white/70'>" + "{{ __('index.bill_image') }}" + "</span></div>",
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        },
        success: function(file, response) {
            console.log(response);
            $('#bill-image-dropzone').css({
                "background": "url('" + response.url + "') center center / cover no-repeat",
                "border": "none"
            }).html(''); // Xóa nội dung để hiển thị ảnh làm nền
            billImageDropzone = response.url;
        },

        error: function(file, response) {
            console.log(response);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.message,
            })
        }
    };
    Dropzone.options.billImageDropzoneUsdt = {
        url: "{{ route('upload') }}",
        maxFiles: 1,
        maxFilesize: 2,
        acceptedFiles: 'image/*',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
        },
        addRemoveLinks: true,
        dictDefaultMessage: "<div class='flex flex-col items-center'><img src='/assets/images/icon_upload.png?v=4' alt='upload' class='w-12 h-12 mb-2'>" +
            "<span class='text-white/70'>" + "{{ __('index.bill_image') }}" + "</span></div>",
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        },
        success: function(file, response) {
            console.log(response);
            $('#bill-image-dropzone-usdt').css({
                "background": "url('" + response.url + "') center center / cover no-repeat",
                "border": "none"
            }).html(''); // Xóa nội dung để hiển thị ảnh làm nền
            billImageDropzoneUsdt = response.url;
        },

        error: function(file, response) {
            console.log(response);
            
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.responseJSON.message,
            })
        }
    };

    if (document.getElementById('bill-image-dropzone')) {
        new Dropzone(document.getElementById('bill-image-dropzone'), Dropzone.options.billImageDropzone);
    }
    new Dropzone(document.getElementById('bill-image-dropzone-usdt'), Dropzone.options.billImageDropzoneUsdt);

    $('#usdt_wallet_select').on('change', function() {
        const usdt_wallet_id = $(this).val();
        const usdt_wallet = $('#usdt_wallet_select option:selected').data('usdt-wallet');
        console.log(usdt_wallet);
        navigator.clipboard.writeText(usdt_wallet);
        Toastify({
            text: "{{ __('index.usdt_wallet_copied') }}",
            duration: 3000,
            gravity: "top",
            position: "center",
            style: {
                background: "linear-gradient(to right, #e04b48, #CD5C5C)",
            }
        }).showToast();
    });

    $('#deposit-button').on('click', function() {
        let amount = 0;
        let billImage = '';
        let bankId = '';
        if (depositType === 'bank') {
            amount = $('#amount_input').val();
            billImage = billImageDropzone;
            bankId = $('#bank_select').val();
        } else {
            amount = $('#amount_input_usdt').val();
            billImage = billImageDropzoneUsdt;
            bankId = $('#usdt_wallet_select').val();
        }

        if (!amount || !billImage || !bankId) {
            Toastify({
                text: "{{ __('index.please_fill_all_fields') }}",
                duration: 3000,
                gravity: "top",
                style: {
                    background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                }
            }).showToast();
            return;
        }
        $('#deposit-button').prop('disabled', true);
        $('#deposit-button').text("{{ __('index.processing') }}");
        $.ajax({
            url: "{{ route('depositPost') }}",
            type: "POST",
            data: {
                amount: amount,
                bill_image: billImage,
                bank_id: bankId,
                payment_type: depositType,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                Toastify({
                    text: response.message,
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                    }
                }).showToast();
                // setTimeout(() => {
                //     window.location.href = "{{ route('deposit') }}";
                // }, 1500);
                reloadPage(['#historyModal', '.balance-value'], ['#historyModal', '.balance-value']);
                $('#historyModal').removeClass('hidden');
            },
            error: function(response) {
                Toastify({
                    text: response.responseJSON.message,
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
            },
            complete: function() {
                $('#deposit-button').prop('disabled', false);
                $('#deposit-button').text("{{ __('index.deposit') }}");
            }
        });
    });

    $(document).ready(function() {
        let currentPage = 2;
        let isLoading = false;

        function loadMoreDeposit(isMobile) {
            if (isLoading) return;
            isLoading = true;

            const button = isMobile ? $('#loadMoreDepositMobile') : $('#loadMoreDeposit');
            button.prop('disabled', true).html("{{ __('index.loading') }}");

            $.ajax({
                url: "{{ route('loadMoreDepositHistory') }}",
                type: 'GET',
                data: {
                    page: currentPage,
                    is_mobile: isMobile
                },
                success: function(response) {
                    if (isMobile) {
                        $('#depositHistoryCards').append(response.html);
                    } else {
                        $('#depositHistoryTable').append(response.html);
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

        $(document).on('click', '#loadMoreDeposit', function() {
            loadMoreDeposit(false);
        });

        $(document).on('click', '#loadMoreDepositMobile', function() {
            loadMoreDeposit(true);
        });
    });
</script>
@endsection