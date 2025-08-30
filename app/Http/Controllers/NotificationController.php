<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(5);
        
        // if ($request->ajax()) {
        //     $view = view('notifications.partials.notification-list', compact('notifications'))->render();
        //     return response()->json([
        //         'html' => $view,
        //         'hasMorePages' => $notifications->hasMorePages()
        //     ]);
        // }
        
        return view('notifications.index', compact('notifications'));
    }

    public function loadMoreNotifications(Request $request)
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(5);
        
        return view('notifications.partials.notification-list', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }
} 