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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'notification_type' => 'nullable|in:all,selected',
            'selected_users' => 'required_if:notification_type,selected|array',
        ], [
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max'),
            'content.required' => __('index.content_required'),
            'image.image' => __('index.image_image'),
            'image.mimes' => __('index.image_mimes'),
            'image.max' => __('index.image_max'),
            'status.required' => __('index.status_required'),
            'selected_users.required_if' => __('index.selected_users_required'),
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $imageName);
            $data['image'] = 'uploads/posts/' . $imageName;
        } else {
            $data['image'] = null;
        }

        $post = Post::create($data);

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);
        // Send notification based on notification type
        if ($post->status === 'published') {
            if ($request->notification_type === 'selected' && !empty($request->selected_users)) {
                $users = User::whereIn('id', $request->selected_users)->where('status', 'active')->get();
                foreach ($users as $user) {
                    $pusher->trigger('post-channel_'.$user->id, 'post-event', ['message' => __('index.new_post_published', ['name' => $user->name]) . $post->title]);
                }
                // $pusher->trigger('post-channel_'.auth()->user()->id, 'post-event', ['message' => __('index.new_post_published', ['name' => auth()->user()->name]) . $post->title]);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $imageName);
            $data['image'] = 'uploads/posts/' . $imageName;
        }

        $post->update($data);

        // Send notification if post status changed to published
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

        $post->delete();

        //delete notification
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