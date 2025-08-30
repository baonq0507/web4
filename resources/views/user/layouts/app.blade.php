<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app_name') }} - @yield('title')</title>
    <meta name="robots" content="noindex, nofollow">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <meta name="description" content="{{ config('app_description') }}">
    <meta name="author" content="{{ config('app_author') }}">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="{{ config('app_name') }}">
    <meta property="og:site_name" content="{{ config('app_name') }}">
    <meta property="og:description" content="{{ config('app_description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/app/' . config('app_thumbnail')) }}">
    <link rel="shortcut icon" href="{{ asset('images/app/' . config('app_favicon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <link rel="stylesheet" href="{{ asset('build/assets/app-CdhP63Du.css') }}"> -->
    <!-- <script src="{{ asset('build/assets/app-DEIRNVKy.js') }}"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/notification.css') }}" rel="stylesheet">
    @yield('css')
    <script>
        window.__lc = window.__lc || {};
        window.__lc.license = "{{ config('live_chat_id') }}";
        (function(n, t, c) {
            function i(n) {
                return e._h ? e._h.apply(null, n) : e._q.push(n)
            }
            var e = {
                _q: [],
                _h: null,
                _v: "2.0",
                on: function() {
                    i(["on", c.call(arguments)])
                },
                once: function() {
                    i(["once", c.call(arguments)])
                },
                off: function() {
                    i(["off", c.call(arguments)])
                },
                get: function() {
                    if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                    return i(["get", c.call(arguments)])
                },
                call: function() {
                    i(["call", c.call(arguments)])
                },
                init: function() {
                    var n = t.createElement("script");
                    n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
                }
            };
            !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
        }(window, document, [].slice))
    </script>
    <script>
        LiveChatWidget.call("hide");

        LiveChatWidget.on('visibility_changed', onVisibilityChanged)
        const openLiveChat = () => {
            LiveChatWidget.call('maximize')
        }

        function onVisibilityChanged(data) {
            switch (data.visibility) {
                case "maximized":
                    break;
                case "minimized":
                    LiveChatWidget.call('hide')
                    break;
                case "hidden":
                    break;
            }
        }
    </script>

    <style>
        body {
            font-family: 'Roboto', sans-serif !important;
        }

        @keyframes slideFromRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .sm\:block {
                display: block;
            }
            .sm\:hidden {
                display: none;
            }
        }
        /* .animate-slide {
            animation: slideFromRight 0.5s ease-out forwards;
        } */

        .btn-buy.trade-active {
            background-color: #3ddeea;
            color: #181a20;
        }

        .btn-sell.trade-active {
            background-color: #e04b48;
            color: #181a20;
        }

        .btn-amount.active {
            border: 2px solid #fff;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            height: 16px;
            width: 16px;
            background-color: #1890ff;
            border-radius: 9999px;
            border: 2px solid white;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            /* margin-top: -6px; */
            /* Align thumb vertically */
        }

        input[type="range"]::-moz-range-thumb {
            height: 16px;
            width: 16px;
            background-color: #1890ff;
            border-radius: 9999px;
            border: 2px solid white;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        body {
            overflow-x: hidden;
            background-color: #000;
            color: #fff;
        }

        .modal-open {
            transform: translateY(35%);
        }

        /* select:focus {
            width: auto;
            min-width: 100%;
        } */

        /* css scrollbar */
        /* ::-webkit-scrollbar {
            width: 0px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #1890ff;
            border-radius: 9999px;
            width: 0px;
        }

        ::-webkit-scrollbar-track {
            background-color: #181a20;
            width: 0px;
        } */
        .md\:table-cell {
            display: table-cell;
        }

        @media (max-width: 768px) {
            .xs\:hidden {
                display: none;
            }
            .img-kyquy {
                width: 100px;
                height: 146px;
                object-fit: cover;
            }
            select option {
                background-color: #1e2124;
                color: #fff;
            }
            /* //khi option được select */
            select option:selected {
                background-color: #3ddeea;
                color: #181a20;
            }

        }

        @media (min-width: 768px) {
            .md\:container {
                width: 80%;
                margin: 0 auto;
            }
        }


        ::-webkit-scrollbar {
            display: none;
        }
        @keyframes slideRightToLeft {
            0% {
                right: -100%;
                opacity: 1;
            }
            100% {
                right: 100%;
                opacity: 0;
            }
        }

        .toastify-fly {
            position: fixed !important;
            top: 70px !important;
            white-space: nowrap;
            z-index: 9999;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-family: sans-serif;
            font-size: 16px;
            opacity: 0;
            width: auto; /* Đảm bảo background bao phủ hết chữ */
            max-width: 2000px; /* Giới hạn chiều rộng tối đa trên di động */
        }

        .toast-animate {
            animation: slideRightToLeft 25s linear forwards;
            opacity: 1 !important;
        }

        /* select option khi mở */
        select:focus {
            width: auto;
            min-width: 100%;
            max-width: 100%;
            background-color: #1e2124;
            border: 1px solid #3ddeea;
            color: #fff;
        }



    </style>
    @yield('style')
</head>

<body class="min-h-screen">
    @include('user.includes.header')
    @yield('content')
    @include('user.includes.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @yield('scripts')
    <!-- Modal Chọn Ngôn Ngữ -->
    <div id="languageModal" class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="bg-[#1f2023] rounded-lg p-6 w-full max-w-sm relative border border-gray-700">
            <button id="btnCloseLanguage" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                </svg>
            </button>
            <h2 class="text-xl font-bold mb-4 text-center text-white">{{ __('index.language') }}</h2>
            <div class="space-y-2">
                <a href="{{ route('change-language', 'en') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/en.png" class="w-6 h-4 mr-2"> {{ __('index.english') }}
                </a>
                <a href="{{ route('change-language', 'vi') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/vi.png" class="w-6 h-4 mr-2"> {{ __('index.vietnamese') }}
                </a>
                <a href="{{ route('change-language', 'de') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/de.png" class="w-6 h-4 mr-2"> {{ __('index.de') }}
                </a>
                <a href="{{ route('change-language', 'id') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/id.png" class="w-6 h-4 mr-2"> {{ __('index.indonesian') }}
                </a>
                <a href="{{ route('change-language', 'th') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/th.png" class="w-6 h-4 mr-2"> {{ __('index.thai') }}
                </a>
                <a href="{{ route('change-language', 'ja') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/ja.png" class="w-6 h-4 mr-2"> {{ __('index.japanese') }}
                </a>
                <a href="{{ route('change-language', 'ko') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/ko.png" class="w-6 h-4 mr-2"> {{ __('index.korean') }}
                </a>
                <a href="{{ route('change-language', 'zh') }}" class="cursor-pointer flex items-center w-full px-4 py-2 text-sm font-medium hover:bg-cyan-900 text-cyan-400 rounded-lg">
                    <img src="/assets/images/flags/zh.png" class="w-6 h-4 mr-2"> {{ __('index.chinese') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        const reloadPage = (element, elementReplace) => {
            $.get(window.location.href, function(data) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');

                if (Array.isArray(element)) {
                    element.forEach((el, index) => {
                        const foundElement = doc.querySelector(el);
                        if (!foundElement) {
                            console.warn(`Element ${el} not found in loaded content`);
                            return;
                        }
                        const newContent = foundElement.innerHTML || '';

                        const replaceEl = Array.isArray(elementReplace) ? elementReplace[index] : elementReplace;
                        if (replaceEl) {
                            const targetElement = document.querySelector(replaceEl);
                            if (!targetElement) {
                                console.warn(`Target element ${replaceEl} not found in document`);
                                return;
                            }
                            targetElement.innerHTML = newContent;
                        }
                    });
                } else {
                    const foundElement = doc.querySelector(element);
                    if (!foundElement) {
                        console.warn(`Element ${element} not found in loaded content`);
                        return;
                    }
                    const newContent = foundElement.innerHTML || '';

                    if (elementReplace) {
                        const targetElement = document.querySelector(elementReplace);
                        if (!targetElement) {
                            console.warn(`Target element ${elementReplace} not found in document`);
                            return;
                        }
                        targetElement.innerHTML = newContent;
                    }
                }
            });
        }
        $(document).ready(function() {
            $('#dropdownBtn').on('click', function() {
                $('#dropdownMenu').toggleClass('hidden');
            });

            window.setLanguage = function(lang) {
                // Do something with selected lang
                console.log('Language selected:', lang);
                $('#dropdownMenu').addClass('hidden');
            };

            var swiper = new Swiper(".swiper", {
                slidesPerView: 1,
                spaceBetween: 30,
                grabCursor: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3
                    }
                }
            });

            $('.tab-btn').on('click', function() {
                // Xóa active và đổi màu các nút
                $('.tab-btn').removeClass('bg-cyan-500 active').addClass('bg-[#1f2023]');
                $(this).removeClass('bg-[#1f2023]').addClass('bg-cyan-500 active');

                // Hiển thị đúng tab
                var target = $(this).data('tab');
                $('.tab-content').addClass('hidden');
                $('#' + target).removeClass('hidden');
            });

            $('#btnLogin, .btn-login').on('click', function() {
                console.log('click');
                $('#loginModal').removeClass('hidden');
            });

            $('#btnRegister, .btn-register').on('click', function() {
                $('.captcha-img').attr('src', '{{ captcha_src() }}' + '?' + Math.random());
                $('#registerModal').removeClass('hidden');
            });

            $('#btnCloseLogin').on('click', function() {
                $('#loginModal').addClass('hidden');
            });

            $('#btnCloseRegister').on('click', function() {
                $('#registerModal').addClass('hidden');
            });

            // Xử lý sự kiện click cho languageBtn
            $('#languageBtn').on('click', function() {
                $('#languageModal').removeClass('hidden');
            });

            $('#btnCloseLanguage').on('click', function() {
                $('#languageModal').addClass('hidden');
            });

            $('#formRegister').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                form.find('button[type="submit"]').prop('disabled', true);
                form.find('button[type="submit"]').html("<i class='fa fa-spinner fa-spin'></i> {{ __('index.loading') }}");

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status) {
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: "{{ __('index.register_success') }}",
                            //     text: response.message,
                            //     showConfirmButton: false,
                            //     timer: 1500
                            // }).then(function() {
                            //     window.location.reload();
                            // });
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                gravity: "top",
                                style: {
                                    background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                                }
                            }).showToast();
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                gravity: "top",
                                style: {
                                    background: "linear-gradient(to right, #ff0000, #ff0000)",
                                }
                            }).showToast();
                        }
                    },
                    error: function(response) {
                        Toastify({
                            text: response.responseJSON.message,
                            duration: 3000,
                            gravity: "top",
                            style: {
                                background: "linear-gradient(to right, #ff0000, #ff0000)",
                            }
                        }).showToast();
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false);
                        form.find('button[type="submit"]').html("{{ __('index.register') }}");
                    }
                });
            });

            $('#formLogin').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                form.find('button[type="submit"]').prop('disabled', true);
                form.find('button[type="submit"]').html("<i class='fa fa-spinner fa-spin'></i> {{ __('index.loading') }}");

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status) {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                gravity: "top",
                                style: {
                                    background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                                }
                            }).showToast();
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                gravity: "top",
                                style: {
                                    background: "linear-gradient(to right, #ff0000, #ff0000)",
                                }
                            }).showToast();
                        }
                    },
                    error: function(response) {
                        Toastify({
                            text: response.responseJSON.message,
                            duration: 3000,
                            gravity: "top",
                            style: {
                                background: "linear-gradient(to right, #ff0000, #ff0000)",
                            }
                        }).showToast();
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false);
                        form.find('button[type="submit"]').html("{{ __('index.login') }}");
                    }
                });
            });

            $('#profileDrawerBtn, #profileDrawerBtn1').on('click', function() {
                $('#profileDrawer').removeClass('translate-x-full').addClass('translate-x-0');
            });

            $('#closeDrawerBtn').on('click', function() {
                $('#profileDrawer').removeClass('translate-x-0').addClass('translate-x-full');
            });

            $('.on_security_deposit').on('click', function() {
                Swal.fire({
                    icon: 'error',
                    text: "{{ __('index.deposit_security_on') }}",
                    showConfirmButton: true,
                    confirmButtonText: "{{ __('index.CSKH') }}",
                    cancelButtonText: "{{ __('index.cancel') }}",
                    showCancelButton: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        openLiveChat()
                    }
                });
            });

            // Handle avatar upload

            // Refresh captcha when clicking on image
            $('.captcha-img').on('click', function() {
                $(this).attr('src', '{{ captcha_src() }}' + '?' + Math.random());
            });
        });
    </script>

    @if(auth()->check())
    <script>
        $('#avatar-upload').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('file', file);

                // Show loading state
                const avatarImg = $(this).siblings('img');
                const originalSrc = avatarImg.attr('src');
                avatarImg.attr('src', '{{ asset("assets/images/loading.gif") }}');

                // Upload avatar
                $.ajax({
                    url: '{{ route("upload-avatar") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Update avatar image
                        avatarImg.attr('src', '{{ Auth::user()->avatar }}');
                        // Update avatar in header button
                        $('#profileDrawerBtn img').attr('src', '{{ Auth::user()->avatar }}');
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("index.success") }}',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        // Restore original avatar
                        avatarImg.attr('src', originalSrc);
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("index.error") }}',
                            text: xhr.responseJSON?.message || '{{ __("index.upload_failed") }}'
                        });
                    }
                });
            }
        });
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link href="{{ asset('assets/css/notification.css') }}" rel="stylesheet">
    <script>
        function showFlyingToast(data) {
            const toast = Toastify({
                text: data,
                className: "toastify-fly",
                duration: 25000,
                gravity: "top",
                stopOnFocus: false,
                close: false,
                callback: function() {}
            });

            toast.showToast();

            // Force animation bắt đầu NGAY sau khi render
            requestAnimationFrame(() => {
                const toastEl = document.querySelector('.toastify-fly');
                if (toastEl) {
                    toastEl.classList.add("toast-animate");
                }
            });
        }
        const formatNumber1 = (number) => {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            useTLS: true
        });

        const channel = pusher.subscribe('logout-channel.{{ Auth::user()->id }}');
        channel.bind('logout', function(data) {
            window.location.reload();
        });
        const channelTransaction = pusher.subscribe('transaction-channel.{{ Auth::user()->id }}');
        channelTransaction.bind('deposit_success', function(data) {
            console.log(data);
            const text = `{{ __('index.deposit_success_channel', ['name' => Auth::user()->name, 'amount' => 100]) }}`;
            const message = text.replace('100', formatNumber1(data.amount));
            showFlyingToast(message);
            reloadPage(['.balance-value', '#historyModal'], ['.balance-value', '#historyModal']);
        });
        channelTransaction.bind('withdraw_success', function(data) {
            const text = `{{ __('index.withdraw_success_channel', ['name' => Auth::user()->name, 'amount' => 100]) }}`;
            const message = text.replace('100', formatNumber1(data.amount));
            showFlyingToast(message);
            reloadPage(['.balance-value', '#historyModal'], ['.balance-value', '#historyModal']);
        });

        const channelPost = pusher.subscribe('post-channel');
        channelPost.bind('post-event', function(data) {
            const text = `{{ __('index.new_post_published', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            reloadPage(['#notificationsBtn', '#notifications-container'], ['#notificationsBtn', '#notifications-container']);
        });

        const channelPostUser = pusher.subscribe('post-channel_'+{{ Auth::user()->id }});
        channelPostUser.bind('post-event', function(data) {
            const message = `{{ __('index.new_post_published', ['name' => Auth::user()->name]) }}`;
            showFlyingToast(message);
            reloadPage(['#notificationsBtn', '#notifications-container'], ['#notificationsBtn', '#notifications-container']);
        });


        const channelKyc = pusher.subscribe('kyc-channel');
        channelKyc.bind('kyc-approved', function(data) {
            const text = `{{ __('index.kyc_approved', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        });
        channelKyc.bind('kyc-rejected', function(data) {
            const text = `{{ __('index.kyc_rejected', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        });

        channelKyc.bind('kyc-sent-again', function(data) {
            const text = `{{ __('index.kyc_sent_again', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        });

        const channelKyQuyApprove = pusher.subscribe('ky-quy-approve-channel');
        channelKyQuyApprove.bind(`ky-quy-approve-event_{{{ Auth::user()->id }}}`, function(data) {
            const text = `{{ __('index.kyc_approve_success', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            reloadPage(['.balance-value', '#historyModal'], ['.balance-value', '#historyModal']);
        });

        const channelKyQuyFinish = pusher.subscribe('ky-quy-finish-channel');
        channelKyQuyFinish.bind(`ky-quy-finish-event_{{{ Auth::user()->id }}}`, function(data) {
            const text = `{{ __('index.kyc_finish_success', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            reloadPage(['.balance-value', '#historyModal', '.ky-quy-users-page'], ['.balance-value', '#historyModal', '.ky-quy-users-page']);
        });

        const channelKyQuyReject = pusher.subscribe('ky-quy-reject-channel');
        channelKyQuyReject.bind(`ky-quy-reject-event_{{{ Auth::user()->id }}}`, function(data) {
            const text = `{{ __('index.kyc_reject_success', ['name' => Auth::user()->name]) }}`;
            const message = text.replace('Auth::user()->name', "{{ Auth::user()->name }}");
            showFlyingToast(message);
            reloadPage(['.balance-value', '#historyModal', '.ky-quy-users-page'], ['.balance-value', '#historyModal', '.ky-quy-users-page']);
        });
    </script>
    @endif
    @yield('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.cskh', function() {
                openLiveChat();
            });
        });
    </script>

    <!-- Email Verification Script -->
    <script>
        // Email verification functionality
        let emailVerified = false;
        let verifiedEmail = '';

        // Đảm bảo DOM đã load trước khi chạy JavaScript
        $(document).ready(function() {
            // Send verification code
            $('#sendVerificationBtn').on('click', function() {
                const email = $('#email').val();
                if (!email) {
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: "Vui lòng nhập email trước",
                            duration: 3000,
                            gravity: "top",
                            style: {
                                background: "linear-gradient(to right, #ff0000, #ff0000)",
                            }
                        }).showToast();
                    } else {
                        alert("Vui lòng nhập email trước");
                    }
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true);
                btn.html("<i class='fa fa-spinner fa-spin'></i> Đang gửi...");

                $.ajax({
                    url: "{{ route('send.verification.code') }}",
                    type: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            if (typeof Toastify !== 'undefined') {
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top",
                                    style: {
                                        background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                                    }
                                }).showToast();
                            } else {
                                alert(response.message);
                            }
                            
                            $('#verificationSection').removeClass('hidden');
                            $('#verificationStatus').html('<span class="text-cyan-400">Mã xác thực đã được gửi đến email của bạn</span>');
                        } else {
                            if (typeof Toastify !== 'undefined') {
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top",
                                    style: {
                                        background: "linear-gradient(to right, #ff0000, #ff0000)",
                                    }
                                }).showToast();
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(response) {
                        const message = response.responseJSON?.message || 'Có lỗi xảy ra';
                        if (typeof Toastify !== 'undefined') {
                            Toastify({
                                text: message,
                                duration: 3000,
                                gravity: "top",
                                style: {
                                    background: "linear-gradient(to right, #ff0000, #ff0000)",
                                }
                            }).showToast();
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.html("Gửi mã");
                    }
                });
            });

            // Verify code
            $('#verifyCodeBtn').on('click', function() {
                const email = $('#email').val();
                const code = $('#verification_code').val();
                
                if (!code) {
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: "Vui lòng nhập mã xác thực",
                            duration: 3000,
                            gravity: "top",
                            style: {
                                background: "linear-gradient(to right, #ff0000, #ff0000)",
                            }
                        }).showToast();
                    } else {
                        alert("Vui lòng nhập mã xác thực");
                    }
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true);
                btn.html("<i class='fa fa-spinner fa-spin'></i> Đang xác thực...");

                $.ajax({
                    url: "{{ route('verify.email.code') }}",
                    type: 'POST',
                    data: {
                        email: email,
                        verification_code: code,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            if (typeof Toastify !== 'undefined') {
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top",
                                    style: {
                                        background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                                    }
                                }).showToast();
                            } else {
                                alert(response.message);
                            }
                            
                            emailVerified = true;
                            verifiedEmail = email;
                            $('#verificationStatus').html('<span class="text-green-400"><i class="fa fa-check-circle"></i> Email đã được xác thực thành công!</span>');
                            $('#email').prop('readonly', true);
                            $('#sendVerificationBtn').prop('disabled', true);
                            $('#verification_code').prop('readonly', true);
                            $('#verifyCodeBtn').prop('disabled', true);
                        } else {
                            if (typeof Toastify !== 'undefined') {
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top",
                                    style: {
                                        background: "linear-gradient(to right, #ff0000, #ff0000)",
                                    }
                                }).showToast();
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(response) {
                        const message = response.responseJSON?.message || 'Có lỗi xảy ra';
                        if (typeof Toastify !== 'undefined') {
                            Toastify({
                                text: message,
                                duration: 3000,
                                gravity: "top",
                                style: {
                                    background: "linear-gradient(to right, #ff0000, #ff0000)",
                                }
                            }).showToast();
                        } else {
                            alert(message);
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.html("Xác thực");
                    }
                });
            });

            // Prevent form submission if email not verified
            $('#formRegister').on('submit', function(e) {
                if (!emailVerified) {
                    e.preventDefault();
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: "Vui lòng xác thực email trước khi đăng ký",
                            duration: 3000,
                            gravity: "top",
                            style: {
                                background: "linear-gradient(to right, #ff0000, #ff0000)",
                            }
                        }).showToast();
                    } else {
                        alert("Vui lòng xác thực email trước khi đăng ký");
                    }
                    return false;
                }
                
                if ($('#email').val() !== verifiedEmail) {
                    e.preventDefault();
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: "Email không khớp với email đã xác thực",
                            duration: 3000,
                            gravity: "top",
                            style: {
                                background: "linear-gradient(to right, #ff0000, #ff0000)",
                            }
                        }).showToast();
                    } else {
                        alert("Email không khớp với email đã xác thực");
                    }
                    return false;
                }
            });

            // Debug: Kiểm tra xem button có được tìm thấy không
            console.log('Email verification script loaded');
            console.log('sendVerificationBtn found:', $('#sendVerificationBtn').length);
            console.log('verifyCodeBtn found:', $('#verifyCodeBtn').length);
        });
    </script>

</body>

</html>