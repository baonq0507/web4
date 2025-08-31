@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/video-banner.css') }}">
@endpush

<div class="video-banner-container">
    <div class="video-banner">
        <video 
            class="banner-video" 
            autoplay 
            muted 
            loop 
            playsinline
            poster="{{ asset('assets/images/banner-poster.jpg') }}"
        >
            <source src="{{ asset('assets/home-banner.mp4') }}" type="video/mp4">
            <source src="{{ asset('assets/home-banner.webm') }}" type="video/webm">
            <!-- Fallback cho trình duyệt không hỗ trợ video -->
            <div class="video-fallback">
                <img src="{{ asset('assets/images/banner-poster.jpg') }}" alt="Banner Image">
            </div>
        </video>
        
        <!-- Overlay nội dung -->
        <div class="video-overlay">
            <div class="overlay-content">
                <h1 class="banner-title">Chào mừng đến với Sanmoi</h1>
                <p class="banner-subtitle">Nền tảng đầu tư và giao dịch tiền điện tử hàng đầu</p>
                <div class="banner-buttons">
                    <a href="#get-started" class="btn btn-primary">Bắt đầu ngay</a>
                    <a href="#learn-more" class="btn btn-secondary">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
        
        <!-- Controls -->
        <div class="video-controls">
            <button class="control-btn play-pause" onclick="toggleVideo()">
                <i class="fas fa-pause"></i>
            </button>
            <button class="control-btn mute" onclick="toggleMute()">
                <i class="fas fa-volume-up"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/video-banner.js') }}"></script>
@endpush
