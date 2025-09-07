@extends('user.layouts.app')

@section('title', $post->title . ' - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-black">
    <!-- Breadcrumb -->
    <div class="bg-gray-900 border-b border-gray-700">
        <div class="container mx-auto px-4">
            <nav aria-label="breadcrumb">
                <ol class="flex items-center space-x-2 py-4">
                    <li><a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-300 transition-colors">Trang chủ</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('news') }}" class="text-blue-400 hover:text-blue-300 transition-colors">Tin tức</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-300">{{ Str::limit($post->title, 50) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- News Detail Content -->
    <div class="py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <article class="bg-gray-900 rounded-2xl overflow-hidden shadow-2xl">
                        <!-- Article Header -->
                        <header class="p-8 border-b border-gray-700">
                            <h1 class="text-4xl font-bold text-white mb-6 leading-tight">{{ $post->title }}</h1>
                            <div class="flex flex-wrap gap-6 text-gray-400">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-blue-400"></i>
                                    <span>{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : $post->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2 text-blue-400"></i>
                                    <span>{{ $post->author }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-eye mr-2 text-blue-400"></i>
                                    <span>{{ number_format($post->views) }} lượt xem</span>
                                </div>
                            </div>
                        </header>

                        <!-- Article Image -->
                        <div class="w-full article-image-container">
                            @if($post->image)
                                <div class="relative group">
                                    <img src="{{ $post->image }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-96 md:h-[500px] object-cover transition-all duration-500"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    
                                    <!-- Fallback when image fails to load -->
                                    <div class="w-full h-96 md:h-[500px] image-placeholder flex items-center justify-center hidden">
                                        <div class="relative z-10 text-center">
                                            <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center placeholder-icon">
                                                <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
                                            </div>
                                            <h3 class="text-xl font-semibold text-white mb-2">Lỗi tải hình ảnh</h3>
                                            <p class="text-gray-400 text-sm">Không thể hiển thị hình ảnh</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Image overlay for better text readability if needed -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent group-hover:from-black/30 transition-all duration-300"></div>
                                    
                                    <!-- Image zoom indicator -->
                                    <div class="absolute top-4 right-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <i class="fas fa-search-plus mr-1"></i>
                                        Xem ảnh
                                    </div>
                                </div>
                            @else
                                <!-- Placeholder when no image -->
                                <div class="w-full h-96 md:h-[500px] image-placeholder flex items-center justify-center">
                                    <div class="relative z-10 text-center">
                                        <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center placeholder-icon">
                                            <i class="fas fa-newspaper text-3xl text-white"></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-white mb-2">{{ Str::limit($post->title, 50) }}</h3>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Article Content -->
                        <div class="p-8 text-gray-300 text-lg leading-relaxed prose prose-invert max-w-none">
                            {!! $post->content !!}
                        </div>

                        <!-- Article Footer -->
                        <footer class="p-8 border-t border-gray-700 bg-gray-800">
                            <div class="mb-6">
                                <span class="font-semibold text-white mr-2">Tags:</span>
                                @if($post->tags && count($post->tags) > 0)
                                    @foreach($post->tags as $tag)
                                        <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">Tin tức</span>
                                    <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">Tài chính</span>
                                @endif
                            </div>
                            <div class="flex items-center flex-wrap gap-4">
                                <span class="font-semibold text-white">Chia sẻ:</span>
                                <div class="flex gap-2">
                                    <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors" onclick="shareOnFacebook()">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition-colors" onclick="shareOnTwitter()">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center text-white hover:bg-blue-800 transition-colors" onclick="shareOnLinkedIn()">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="#" class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white hover:bg-gray-700 transition-colors" onclick="copyLink()">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </div>
                            </div>
                        </footer>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        <!-- Related Posts -->
                        @if($relatedPosts->count() > 0)
                        <div class="bg-gray-900 rounded-2xl p-6 shadow-2xl">
                            <h3 class="text-xl font-semibold text-white mb-6 pb-2 border-b-2 border-blue-600">Tin tức liên quan</h3>
                            <div class="space-y-4">
                                @foreach($relatedPosts as $relatedPost)
                                <div class="flex gap-4 p-4 border-b border-gray-700 last:border-b-0">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($relatedPost->image)
                                            <img src="{{ $relatedPost->image }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white text-xl">
                                                <i class="fas fa-newspaper"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-white mb-2 leading-tight">
                                            <a href="{{ route('news.show', $relatedPost->slug) }}" class="hover:text-blue-400 transition-colors">
                                                {{ Str::limit($relatedPost->title, 60) }}
                                            </a>
                                        </h4>
                                        <div class="text-xs text-gray-400">
                                            <span>{{ $relatedPost->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Newsletter Subscription -->
                        <div class="bg-gray-900 rounded-2xl p-6 shadow-2xl">
                            <h3 class="text-xl font-semibold text-white mb-6 pb-2 border-b-2 border-blue-600">Đăng ký nhận tin</h3>
                            <div class="text-center">
                                <p class="text-gray-400 mb-4">Nhận thông báo về tin tức mới nhất</p>
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="email" class="w-full px-4 py-3 rounded-full border border-gray-600 bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500" placeholder="Nhập email của bạn" required>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-full font-semibold hover:bg-blue-700 transition-colors">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Article Image Styles */
.article-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 0 0 1rem 1rem;
}

.article-image-container img {
    transition: all 0.3s ease;
}

.article-image-container:hover img {
    transform: scale(1.05);
}

.image-placeholder {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    position: relative;
    overflow: hidden;
}

.image-placeholder::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.placeholder-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Dark theme styles for article content */
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #ffffff !important;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose p {
    color: #d1d5db !important;
    margin-bottom: 1.5rem;
}

.prose a {
    color: #60a5fa !important;
    text-decoration: none;
}

.prose a:hover {
    color: #93c5fd !important;
    text-decoration: underline;
}

.prose blockquote {
    border-left: 4px solid #3b82f6 !important;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #9ca3af !important;
    background: #1f2937;
    padding: 1rem 1.5rem;
    border-radius: 0 8px 8px 0;
}

.prose ul, .prose ol {
    color: #d1d5db !important;
}

.prose li {
    color: #d1d5db !important;
}

.prose strong {
    color: #ffffff !important;
}

.prose code {
    background: #374151 !important;
    color: #fbbf24 !important;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}

.prose pre {
    background: #1f2937 !important;
    color: #d1d5db !important;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
}

.prose img {
    border-radius: 8px;
    margin: 1rem 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .prose {
        font-size: 1rem;
    }
    
    .prose h1 {
        font-size: 1.875rem;
    }
    
    .prose h2 {
        font-size: 1.5rem;
    }
    
    .prose h3 {
        font-size: 1.25rem;
    }
}
</style>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <div class="absolute bottom-4 left-4 text-white">
            <p id="modalImageTitle" class="text-lg font-semibold"></p>
        </div>
    </div>
</div>

<script>
// Image modal functions
function openImageModal(imageSrc, imageAlt) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalImageTitle = document.getElementById('modalImageTitle');
    
    modalImage.src = imageSrc;
    modalImage.alt = imageAlt;
    modalImageTitle.textContent = imageAlt;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Add click event to article image
document.addEventListener('DOMContentLoaded', function() {
    const articleImage = document.querySelector('.article-image-container img');
    if (articleImage) {
        articleImage.addEventListener('click', function() {
            openImageModal(this.src, this.alt);
        });
        articleImage.style.cursor = 'pointer';
    }
    
    // Close modal when clicking outside
    const modal = document.getElementById('imageModal');
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
});

// Share functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('{{ $post->title }}');
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('{{ $post->title }}');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank', 'width=600,height=400');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('{{ $post->title }}');
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Đã sao chép liên kết!');
    });
}
</script>
@endsection
