<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->latest()
            ->paginate(12);
            
        return view('news.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Tăng lượt xem
        $post->incrementViews();
            
        // Lấy các bài viết liên quan (cùng danh mục hoặc mới nhất)
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(4)
            ->get();
            
        return view('news.detail', compact('post', 'relatedPosts'));
    }
}
