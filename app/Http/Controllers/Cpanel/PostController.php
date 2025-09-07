<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewPostNotification;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('cpanel.posts.index', compact('posts'));
    }

    public function create()
    {
        $users = User::where('status', 'active')->get();
        return view('cpanel.posts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'author' => 'nullable|max:100',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'notification_type' => 'nullable|in:all,selected',
            'selected_users' => 'required_if:notification_type,selected|array',
        ], [
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max'),
            'content.required' => __('index.content_required'),
            'excerpt.max' => 'Tóm tắt không được quá 500 ký tự',
            'image.image' => __('index.image_image'),
            'image.mimes' => __('index.image_mimes'),
            // Sửa lỗi validation.max.file
            'image.max' => __('validation.max.file', ['attribute' => 'ảnh', 'max' => 2048]),
            'featured_image.image' => 'Ảnh nổi bật phải là file hình ảnh',
            'featured_image.mimes' => 'Ảnh nổi bật phải có định dạng jpeg, png, jpg, gif',
            // Sửa lỗi validation.max.file
            'featured_image.max' => __('validation.max.file', ['attribute' => 'ảnh nổi bật', 'max' => 2048]),
            'status.required' => __('index.status_required'),
            'author.max' => 'Tên tác giả không được quá 100 ký tự',
            'selected_users.required_if' => __('index.selected_users_required'),
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Xử lý tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Xử lý is_featured
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        // Xử lý published_at
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $imageName);
            $data['image'] = 'uploads/posts/' . $imageName;
        } else {
            $data['image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $featuredImageName = time() . '_featured.' . $featuredImage->getClientOriginalExtension();
            $featuredImage->move(public_path('uploads/posts'), $featuredImageName);
            $data['featured_image'] = 'uploads/posts/' . $featuredImageName;
        } else {
            $data['featured_image'] = null;
        }

        $post = Post::create($data);

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        // Gửi thông báo dựa trên loại thông báo
        if ($post->status === 'published') {
            if ($request->notification_type === 'selected' && !empty($request->selected_users)) {
                $users = User::whereIn('id', $request->selected_users)->where('status', 'active')->get();
                foreach ($users as $user) {
                    $pusher->trigger('post-channel_'.$user->id, 'post-event', ['message' => __('index.new_post_published', ['name' => $user->name]) . $post->title]);
                }
            } else {
                $users = User::where('status', 'active')->get();
                $pusher->trigger('post-channel', 'post-event', ['message' => __('index.new_post_published', ['name' => auth()->user()->name]) . $post->title]);
            }
            Notification::send($users, new NewPostNotification($post));
        }

        return redirect()->route('cpanel.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('cpanel.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'author' => 'nullable|max:100',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max'),
            'content.required' => __('index.content_required'),
            'excerpt.max' => 'Tóm tắt không được quá 500 ký tự',
            'image.image' => __('index.image_image'),
            'image.mimes' => __('index.image_mimes'),
            // Sửa lỗi validation.max.file
            'image.max' => __('validation.max.file', ['attribute' => 'ảnh', 'max' => 2048]),
            'featured_image.image' => 'Ảnh nổi bật phải là file hình ảnh',
            'featured_image.mimes' => 'Ảnh nổi bật phải có định dạng jpeg, png, jpg, gif',
            // Sửa lỗi validation.max.file
            'featured_image.max' => __('validation.max.file', ['attribute' => 'ảnh nổi bật', 'max' => 2048]),
            'status.required' => __('index.status_required'),
            'author.max' => 'Tên tác giả không được quá 100 ký tự',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Xử lý tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Xử lý is_featured
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        // Xử lý published_at
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $imageName);
            $data['image'] = 'uploads/posts/' . $imageName;
        }

        if ($request->hasFile('featured_image')) {
            // Xóa ảnh nổi bật cũ
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                unlink(public_path($post->featured_image));
            }

            $featuredImage = $request->file('featured_image');
            $featuredImageName = time() . '_featured.' . $featuredImage->getClientOriginalExtension();
            $featuredImage->move(public_path('uploads/posts'), $featuredImageName);
            $data['featured_image'] = 'uploads/posts/' . $featuredImageName;
        }

        $post->update($data);

        // Gửi thông báo nếu trạng thái bài viết chuyển sang published
        if ($post->status === 'published' && $post->wasChanged('status')) {
            $users = User::where('status', 'active')->get();
            Notification::send($users, new NewPostNotification($post));
        }

        return redirect()->route('cpanel.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }

        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            unlink(public_path($post->featured_image));
        }

        $post->delete();

        // Xóa notification liên quan
        $notifications = DB::table('notifications')->whereJsonContains('data', ['post_id' => $post->id])->get();
        foreach ($notifications as $notification) {
            DB::table('notifications')->where('id', $notification->id)->delete();
        }

        return redirect()->route('cpanel.posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function sendNotification(Request $request, Post $post)
    {
        $request->validate([
            'notification_type' => 'required|in:all,selected',
            'selected_users' => 'required_if:notification_type,selected|array',
        ], [
            'notification_type.required' => __('index.notification_type_required'),
            'selected_users.required_if' => __('index.selected_users_required'),
        ]);

        if ($request->notification_type === 'selected' && !empty($request->selected_users)) {
            $users = User::whereIn('id', $request->selected_users)->where('status', 'active')->get();
        } else {
            $users = User::where('status', 'active')->get();
        }

        Notification::send($users, new NewPostNotification($post));

        return redirect()->route('cpanel.posts.index')
            ->with('success', 'Thông báo đã được gửi thành công.');
    }
} 