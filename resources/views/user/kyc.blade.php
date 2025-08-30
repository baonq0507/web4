@extends('user.layouts.app')
@section('title', 'KYC')

@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 pb-16 px-2 flex flex-col gap-12 mt-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Deposit Form Card -->
        <section class="flex-1 min-w-0 bg-[#181a1d] rounded-2xl border border-[#232425] p-5 md:p-10 flex flex-col gap-10">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">{{ __('index.kyc') }}</h1>
            </div>
            <div class="tab-content">
                <div class="mb-4">
                    @if($kyc && $kyc->status == 'sent_again')
                    <div class="alert alert-danger flex items-center bg-red-500 rounded-lg p-4">
                        <i class="fa fa-sync mr-1"></i>
                        <span>{{ __('index.please_send_again') }}</span>
                    </div>
                    @elseif($kyc && $kyc->status == 'pending')
                    <div class="alert alert-warning flex items-center bg-[#ff622d] rounded-lg p-4">
                        <i class="fa fa-hourglass-half mr-1"></i>
                        <span>{{ __('index.please_wait') }}</span>
                    </div>
                    @elseif($kyc && $kyc->status == 'approved')
                    <div class="alert alert-success flex items-center bg-[#2bc5bb] rounded-lg p-4">
                        <i class="fa fa-check mr-1"></i>
                        <span>{{ __('index.kyc_approvedd') }}</span>
                    </div>
                    @elseif($kyc && $kyc->status == 'rejected')
                    <div class="alert alert-danger flex items-center bg-red-500 rounded-lg p-4">
                        <i class="fa fa-times mr-1"></i>
                        <span>{{ __('index.kyc_rejectedd') }}</span>
                    </div>
                    @endif
                </div>
                <ol class="flex flex-col gap-8">
                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">1</span>
                            {{ __('index.type_identity') }}
                        </span>
                        <div class="mt-4">
                            <select class="w-full bg-[#232425] text-white/90 rounded-lg px-4 py-3 outline-none" id="type_identity">
                                <option value="national_id" {{ $kyc && $kyc->type == 'national_id' ? 'selected' : '' }}>{{ __('index.national_id') }}</option>
                                <option value="driver_license" {{ $kyc && $kyc->type == 'driver_license' ? 'selected' : '' }}>{{ __('index.driver_license') }}</option>
                                <option value="passport" {{ $kyc && $kyc->type == 'passport' ? 'selected' : '' }}>{{ __('index.passport') }}</option>
                            </select>
                        </div>
                    </li>

                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">2</span>
                            {{ __('index.fullname') }}
                        </span>
                        <div class="mt-4">
                            <input class="w-full bg-[#232425] text-white/90 rounded-lg px-4 py-3 outline-none" id="fullname" value="{{ $kyc ? $kyc->fullname : '' }}" />
                        </div>
                    </li>

                    <li>
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">3</span>
                            {{ __('index.identity_front') }}
                        </span>
                        <div class="mt-4">
                            @if($kyc && $kyc->identity_front && $kyc->status != 'sent_again')
                            <img src="{{ $kyc->identity_front }}" alt="identity_front" class="w-full h-60 rounded-lg">
                            @else
                            <div id="front-identity-dropzone" class="w-full h-60 bg-white/10 rounded-lg border border-white/20 cursor-pointer dropzone text-center flex justify-center items-center text-white/70"></div>
                            @endif
                        </div>
                    </li>

                    <li id="back-identity-section" style="display: none;">
                        <span class="font-semibold text-lg flex items-center gap-2 text-white">
                            <span class="flex items-center justify-center bg-[#2bc5bb] text-[#18191d] rounded-full w-7 h-7 mr-2 font-bold">4</span>
                            {{ __('index.identity_back') }}
                        </span>
                        <div class="mt-4">
                            @if($kyc && $kyc->identity_back && $kyc->status != 'sent_again')
                            <img src="{{ $kyc->identity_back }}" alt="identity_back" class="w-full h-60 rounded-lg">
                            @else
                            <div id="back-identity-dropzone" class="w-full h-60 bg-white/10 rounded-lg border border-white/20 cursor-pointer dropzone text-center flex justify-center items-center text-white/70"></div>
                            @endif
                        </div>
                    </li>
                </ol>
            </div>
            @if($kyc && $kyc->status == 'sent_again' || !$kyc)
            <button class="cursor-pointer w-full rounded-full border-2 border-[#fff] py-2.5 font-bold text-white text-lg mt-2 hover:bg-[#ff622d] transition-all duration-300" id="kyc-button">{{ __('index.kyc_send') }}</button>
            @endif
        </section>
    </div>
</main>
@endsection
@section('scripts')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    let frontIdentityDropzone = '';
    let backIdentityDropzone = '';
    let selfieIdentityDropzone = '';
    $(document).ready(function() {
        // Kiểm tra type ban đầu
        checkIdentityType();

        // Xử lý sự kiện change của select
        $('#type_identity').change(function() {
            checkIdentityType();
        });

        function checkIdentityType() {
            const type = $('#type_identity').val();
            if (type === 'passport') {
                $('#back-identity-section').hide();
            } else {
                $('#back-identity-section').show();
            }
        }

        Dropzone.autoDiscover = false;
        Dropzone.options.frontIdentityDropzone = {
            url: "{{ route('upload') }}",
            maxFiles: 1,
            maxFilesize: 2,
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            addRemoveLinks: true,
            dictDefaultMessage: "<div class='flex flex-col items-center'><img src='/assets/images/icon_upload.png?v=4' alt='upload' class='w-12 h-12 mb-2'>" +
                "<span class='text-white/70'>" + "{{ __('index.identity_front') }}" + "</span></div>",
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            },
            success: function(file, response) {
                console.log(response);
                $('#front-identity-dropzone').css({
                    "background": "url('" + response.url + "') center center / cover no-repeat",
                    "border": "none"
                }).html(''); // Xóa nội dung để hiển thị ảnh làm nền
                frontIdentityDropzone = response.url;
            },

            error: function(file, response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                })
            }
        };

        new Dropzone(document.getElementById('front-identity-dropzone'), Dropzone.options.frontIdentityDropzone);

        Dropzone.options.backIdentityDropzone = {
            url: "{{ route('upload') }}",
            maxFiles: 1,
            maxFilesize: 2,
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            addRemoveLinks: true,
            dictDefaultMessage: "<div class='flex flex-col items-center'><img src='/assets/images/icon_upload.png?v=4' alt='upload' class='w-12 h-12 mb-2'>" +
                "<span class='text-white/70'>" + "{{ __('index.identity_back') }}" + "</span></div>",
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            },

            success: function(file, response) {
                console.log(response);
                $('#back-identity-dropzone').css({
                    "background": "url('" + response.url + "') center center / cover no-repeat",
                    "border": "none"
                }).html(''); // Xóa nội dung để hiển thị ảnh làm nền
                backIdentityDropzone = response.url;
            },

            error: function(file, response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                })
            }
        };

        new Dropzone(document.getElementById('back-identity-dropzone'), Dropzone.options.backIdentityDropzone);


        $('#kyc-button').click(function() {
            const type = $('#type_identity').val();
            let data = {
                type: type,
                number_identity: $('#number_identity').val(),
                fullname: $('#fullname').val(),
                front_identity: frontIdentityDropzone,
                back_identity: backIdentityDropzone,
            }

            if (data.fullname == '' || data.front_identity == '') {
                Toastify({
                    text: "{{ __('index.please_fill_all_fields') }}",
                    duration: 3000,
                    gravity: "top",
                    style: {
                        background: "linear-gradient(to right, #e04b48, #CD5C5C)",
                    }
                }).showToast();
            }

            if (type !== 'passport' && data.back_identity == '') {
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

            $('#kyc-button').html("{{ __('index.processing') }}");
            $('#kyc-button').prop('disabled', true);
            const formData = new FormData();
            formData.append('type', data.type);
            formData.append('fullname', data.fullname);
            formData.append('identity_front', data.front_identity);
            formData.append('identity_back', data.back_identity);
            formData.append('_token', "{{ csrf_token() }}");

            console.log(formData);

            $.ajax({
                url: "{{ route('update-kyc') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(response) {
                    Toastify({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.responseJSON.message,
                    })
                },
                complete: function() {
                    $('#kyc-button').html("{{ __('index.submit') }}");
                    $('#kyc-button').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection