<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Fallback CSS -->
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @endif
        
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/main-content.css') }}">
    </head>
    <body>
        <!-- Video Banner Component -->
        @include('components.video-banner')
        
        <!-- Main Content -->
        <main class="main-content">
            <section id="get-started" class="section">
                <div class="container">
                    <h2>Bắt đầu hành trình đầu tư</h2>
                    <p>Khám phá các cơ hội đầu tư tiền điện tử với Sanmoi</p>
                </div>
            </section>
            
            <section id="learn-more" class="section">
                <div class="container">
                    <h2>Tìm hiểu thêm</h2>
                    <p>Học hỏi về blockchain, tiền điện tử và các chiến lược đầu tư</p>
                </div>
            </section>
        </main>
        
        @stack('scripts')
    </body>
</html>
