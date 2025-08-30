@extends('user.layouts.app')
@section('title', __('index.bank_list'))

@section('content')
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <section class="flex-1 min-w-0 bg-[#181a1d] rounded-2xl border border-[#232425] p-6 md:p-10 flex flex-col gap-6 md:gap-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ __('index.bank_list') }}</h1>

                <button class="text-white bg-cyan-500 px-4 py-2 md:px-6 md:py-3 rounded-full hover:bg-cyan-600 transition duration-300 ease-in-out text-center flex items-center gap-2" id="btnAddBank">
                    <i class="fa fa-plus"></i>
                    {{ __('index.add_bank') }}
                </button>
            </div>

            <!-- Bank cards grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($banks as $bank)
                <div class="bg-[#232425] rounded-2xl border border-[#2c2e30] p-6 hover:border-cyan-500 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-12 rounded-full bg-cyan-500/20 flex items-center justify-center">
                                <i class="fa fa-bank text-cyan-500 text-xl"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">{{ $bank->bank_name }}</h2>
                        </div>
                        <button class="text-red-500 hover:text-red-600 transition-colors cursor-pointer delete-bank" data-id="{{ $bank->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <i class="fa fa-credit-card text-gray-400"></i>
                            <p class="text-white">{{ $bank->bank_number }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa fa-user text-gray-400"></i>
                            <p class="text-white">{{ $bank->bank_owner }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</main>

<!-- modal add bank -->
<div id="addBankModal" class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="bg-[#1f2023] rounded-lg p-6 w-full max-w-sm relative">
        <button id="btnCloseAddBank" class=" cursor-pointer absolute top-2 right-2 text-gray-500 hover:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4 text-center text-white">{{ __('index.add_bank') }}</h2>
        <form action="{{ route('addBank') }}" method="post" id="formAddBank">
            @csrf
            <label for="bank_name" class="block mb-2 text-white">{{ __('index.bank_name') }}</label>
            <input type="text" name="bank_name" placeholder="{{ __('index.bank_name') }}" class="w-full mb-3 p-2 border rounded-xl border-white focus:outline-none focus:ring-2 focus:ring-cyan-500 text-white">
            <label for="bank_account" class="block mb-2 text-white">{{ __('index.bank_account') }}</label>
            <input type="text" name="bank_account" placeholder="{{ __('index.bank_account') }}" class="w-full mb-3 p-2 border rounded-xl border-white focus:outline-none focus:ring-2 focus:ring-cyan-500 text-white">
            <label for="bank_account_name" class="block mb-2 text-white">{{ __('index.bank_account_name') }}</label>
            <input type="text" name="bank_account_name" placeholder="{{ __('index.bank_account_name') }}" class="w-full mb-3 p-2 border rounded-xl border-white focus:outline-none focus:ring-2 focus:ring-cyan-500 text-white">
            <button type="submit" id="btnAddBank" class="cursor-pointer w-full bg-cyan-500 text-white py-2 rounded-xl hover:bg-cyan-600 hover:scale-105 transition duration-300 ease-in-out">{{ __('index.add_bank') }}</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#btnAddBank').on('click', function() {
            $('#addBankModal').removeClass('hidden');
        });

        $('#btnCloseAddBank').on('click', function() {
            $('#addBankModal').addClass('hidden');
        });

        $('#formAddBank').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            btn.html("<i class='fa fa-spinner fa-spin'></i> {{ __('index.loading') }}");
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        stopOnFocus: false,

                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(response) {
                    Toastify({
                        text: response.responseJSON.message,
                        duration: 25000,
                        gravity: "top",
                        stopOnFocus: false,
                        close: false,
                        style: {
                            background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                        }
                    }).showToast();
                },
                complete: function() {
                    btn.prop('disabled', false);
                    btn.html("{{ __('index.add_bank') }}");
                }
            });
        });

        $('.delete-bank').on('click', function() {
            const id = $(this).data('id');
            Swal.fire({
                icon: 'warning',
                title: "{{ __('index.delete_bank') }}",
                text: "{{ __('index.delete_bank_text') }}",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('index.delete_bank_confirm') }}",
                cancelButtonText: "{{ __('index.delete_bank_cancel') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteBank') }}",
                        type: "DELETE",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Toastify({
                                text: response.message,
                                duration: 25000,
                                gravity: "top",
                                stopOnFocus: false,
                                close: false,
                                style: {
                                    background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                                }
                            }).showToast();
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(response) {
                            Toastify({
                                text: response.responseJSON.message,
                                duration: 25000,
                                gravity: "top",
                                stopOnFocus: false,
                                close: false,
                                style: {
                                    background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                                }
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection