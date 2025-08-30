<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app_name') }}</title>
    <meta name="description" content="{{ config('app_description') }}">
    <meta name="author" content="{{ config('app_author') }}">
    <meta name="robots" content="noindex, nofollow">
    <!-- <meta property="og:title" content="{{ config('app_name') }}">
    <meta property="og:site_name" content="{{ config('app_name') }}">
    <meta property="og:description" content="{{ config('app_description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="{{ asset('images/app/' . config('app_thumbnail')) }}">
    <link rel="shortcut icon" href="{{ asset('images/app/' . config('app_favicon')) }}"> -->
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('cpanel/assets/css/dashmix.min-3.1.css') }}">
    <script src="{{ asset('cpanel/assets/js/dashmix.core.min-3.1.js') }}"></script>
    <script src="{{ asset('cpanel/assets/js/dashmix.app.min-3.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.min.css" integrity="sha512-gRH0EcIcYBFkQTnbpO8k0WlsD20x5VzjhOA1Og8+ZUAhcMUCvd+APD35FJw3GzHAP3e+mP28YcDJxVr745loHw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('cpanel/assets/css/style.css' ) . '?v=' . $version }}">
    @stack('styles')
    <style>
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

        /* input number loại bỏ số 0 đằng trước */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        

    </style>

</head>

<body>
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed main-content-narrow side-trans-enabled page-header-dark">
        @include('cpanel.includes.nav')
        @include('cpanel.includes.header')
        @yield('content')
        @include('cpanel.includes.footer')
    </div>
    @include('cpanel.includes.loading')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('cpanel/assets/js/core.js') . '?v=' . $version }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    @stack('scripts')

    <script>
         const reloadPage1 = (element, elementReplace) => {
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
        let withdrawAudio = new Audio('/assets/audio/co_lenh_rut_tien.mp3');
        let depositAudio = new Audio('/assets/audio/co_lenh_nap_tien.mp3');
        let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            useTLS: true
        });
        let channelWithdraw = pusher.subscribe('withdraw');
        channelWithdraw.bind('withdraw', function(data) {
            reloadPage1(['.transaction-page', '.withdraw-page'], ['.transaction-page', '.withdraw-page']);
            const text = "{{ __('index.have_request_withdraw') }}";
            showFlyingToast(text);
            withdrawAudio.play();
        });

        let channelDeposit = pusher.subscribe('deposit');
        channelDeposit.bind('deposit', function(data) {
            reloadPage1(['.transaction-page', '.deposit-page'], ['.transaction-page', '.deposit-page']);
            const text = "{{ __('index.have_request_deposit') }}";
            showFlyingToast(text);
            depositAudio.play();
        });
        let kycAudio = new Audio('/assets/audio/xac_thuc_tai_khoan.mp3');
        let channelKyc = pusher.subscribe('kyc');
        channelKyc.bind('kyc', function(data) {
            reloadPage1(['.kyc-page'], ['.kyc-page']);
            const text = "{{ __('index.have_request_kyc') }}";
            showFlyingToast(text);
            kycAudio.play();
        });

        let tradeAudio = new Audio("{{ asset('assets/audio/notification.mp3') }}");
        let channelTrade = pusher.subscribe('trade');
        channelTrade.bind('trade', function(data) {
            reloadPage1(['.order-page'], ['.order-page']);
            const text = "{{ __('index.have_request_trade') }}";
            showFlyingToast(text);
            tradeAudio.play();
        });

        let kyQuyAudio = new Audio('/assets/audio/notification.mp3');
        let channelKyQuy = pusher.subscribe('ky-quy');
        channelKyQuy.bind('ky-quy-created', function(data) {
            reloadPage1(['.ky-quy-users-page'], ['.ky-quy-users-page']);
            const text = "{{ __('index.have_request_ky_quy') }}";
            showFlyingToast(text);
            kyQuyAudio.play();
        });
    </script>
</body>

</html>