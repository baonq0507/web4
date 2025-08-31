document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('.banner-video');
    const playPauseBtn = document.querySelector('.play-pause');
    const muteBtn = document.querySelector('.mute');
    
    if (!video) return;
    
    // Auto-pause video khi không visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                video.play().catch(e => console.log('Auto-play failed:', e));
            } else {
                video.pause();
            }
        });
    }, { threshold: 0.5 });
    
    observer.observe(video);
    
    // Cập nhật trạng thái button khi video thay đổi
    video.addEventListener('play', () => {
        if (playPauseBtn) {
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        }
    });
    
    video.addEventListener('pause', () => {
        if (playPauseBtn) {
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        }
    });
    
    video.addEventListener('volumechange', () => {
        if (muteBtn) {
            if (video.muted) {
                muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            } else {
                muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
            }
        }
    });
    
    // Xử lý lỗi video
    video.addEventListener('error', (e) => {
        console.error('Video error:', e);
        // Hiển thị fallback image
        const fallback = document.querySelector('.video-fallback');
        if (fallback) {
            fallback.style.display = 'flex';
        }
    });
    
    // Preload video
    video.preload = 'metadata';
});

// Toggle play/pause video
function toggleVideo() {
    const video = document.querySelector('.banner-video');
    if (!video) return;
    
    if (video.paused) {
        video.play().catch(e => console.log('Play failed:', e));
    } else {
        video.pause();
    }
}

// Toggle mute video
function toggleMute() {
    const video = document.querySelector('.banner-video');
    if (!video) return;
    
    video.muted = !video.muted;
}

// Pause video khi user scroll
let scrollTimeout;
window.addEventListener('scroll', () => {
    const video = document.querySelector('.banner-video');
    if (video && !video.paused) {
        video.pause();
        
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            if (isElementInViewport(video)) {
                video.play().catch(e => console.log('Auto-play after scroll failed:', e));
            }
        }, 1000);
    }
});

// Kiểm tra element có trong viewport không
function isElementInViewport(el) {
    if (!el) return false;
    
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Pause video khi tab không active
document.addEventListener('visibilitychange', () => {
    const video = document.querySelector('.banner-video');
    if (!video) return;
    
    if (document.hidden) {
        video.pause();
    } else {
        // Chỉ play nếu video đang trong viewport
        if (isElementInViewport(video)) {
            video.play().catch(e => console.log('Auto-play after visibility change failed:', e));
        }
    }
});

// Xử lý touch events cho mobile
let touchStartY = 0;
let touchEndY = 0;

document.addEventListener('touchstart', (e) => {
    touchStartY = e.changedTouches[0].screenY;
});

document.addEventListener('touchend', (e) => {
    touchEndY = e.changedTouches[0].screenY;
    handleSwipe();
});

function handleSwipe() {
    const video = document.querySelector('.banner-video');
    if (!video) return;
    
    const swipeThreshold = 50;
    const diff = touchStartY - touchEndY;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe up - có thể pause video
            if (!video.paused) {
                video.pause();
            }
        } else {
            // Swipe down - có thể play video
            if (video.paused && isElementInViewport(video)) {
                video.play().catch(e => console.log('Play after swipe failed:', e));
            }
        }
    }
}

// Lazy loading cho video
function lazyLoadVideo() {
    const video = document.querySelector('.banner-video');
    if (!video) return;
    
    const videoSrc = video.querySelector('source[src*=".mp4"]');
    if (videoSrc && !videoSrc.src) {
        videoSrc.src = videoSrc.dataset.src;
        video.load();
    }
}

// Intersection Observer cho lazy loading
const lazyObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            lazyLoadVideo();
            lazyObserver.unobserve(entry.target);
        }
    });
});

// Observe video container cho lazy loading
const videoContainer = document.querySelector('.video-banner-container');
if (videoContainer) {
    lazyObserver.observe(videoContainer);
}
