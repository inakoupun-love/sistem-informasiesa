<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get unread notifications for the current user
     */
    public function getUnread(): JsonResponse
    {
        $notifications = Auth::user()
            ->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $notifications->count(),
            'notifications' => $notifications->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'type' => $notif->type,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'icon' => $notif->icon,
                    'color' => $notif->color,
                    'action_url' => $notif->action_url,
                    'time_ago' => $notif->created_at->diffForHumans(),
                    'created_at' => $notif->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }

    /**
     * Get all notifications for the current user
     */
    public function getAll(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 20);
        $offset = $request->get('offset', 0);

        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        $total = Auth::user()->notifications()->count();

        return response()->json([
            'success' => true,
            'total' => $total,
            'count' => $notifications->count(),
            'notifications' => $notifications->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'type' => $notif->type,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'icon' => $notif->icon,
                    'color' => $notif->color,
                    'action_url' => $notif->action_url,
                    'is_read' => $notif->isRead(),
                    'time_ago' => $notif->created_at->diffForHumans(),
                    'created_at' => $notif->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        // Check if notification belongs to current user
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        Auth::user()
            ->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Delete notification
     */
    public function delete(Notification $notification): JsonResponse
    {
        // Check if notification belongs to current user
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(): JsonResponse
    {
        $count = Auth::user()
            ->notifications()
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}
