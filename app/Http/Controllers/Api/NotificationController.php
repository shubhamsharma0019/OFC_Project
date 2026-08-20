<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Logged-in user ki notifications list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:200'],
            'status' => ['nullable', 'in:read,unread'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $baseQuery = Notification::query()
            ->where('user_id', $user->id);

        $notifications = (clone $baseQuery)
            ->when($validated['search'] ?? null, function ($query, string $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->when(($validated['status'] ?? null) === 'read', function ($query) {
                $query->where('is_read', true);
            })
            ->when(($validated['status'] ?? null) === 'unread', function ($query) {
                $query->where('is_read', false);
            })
            ->latest()
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Notifications fetched successfully.',
            'data' => [
                'notifications' => $notifications,
                'summary' => [
                    'total' => (clone $baseQuery)->count(),
                    'unread' => (clone $baseQuery)
                        ->where('is_read', false)
                        ->count(),
                    'read' => (clone $baseQuery)
                        ->where('is_read', true)
                        ->count(),
                    'filtered' => $notifications->total(),
                ],
            ],
        ]);
    }

    /**
     * Logged-in user ki unread notifications count return karega.
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $user = $request->user();

        $unreadCount = Notification::query()
            ->where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Unread notifications count fetched successfully.',
            'data' => [
                'unread_count' => $unreadCount,
            ],
        ]);
    }

    /**
     * Single notification ko read mark karega.
     */
    public function markAsRead(
        Request $request,
        Notification $notification
    ): JsonResponse {
        $user = $request->user();

        if ($notification->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to update this notification.',
            ], 403);
        }

        if ($notification->is_read) {
            return response()->json([
                'success' => true,
                'message' => 'Notification is already marked as read.',
                'data' => [
                    'notification' => $notification,
                ],
            ]);
        }

        $notification->update([
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read successfully.',
            'data' => [
                'notification' => $notification->fresh(),
            ],
        ]);
    }

    /**
     * Logged-in user ki sabhi notifications ko read mark karega.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = $request->user();

        $updatedCount = Notification::query()
            ->where('user_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read successfully.',
            'data' => [
                'updated_count' => $updatedCount,
            ],
        ]);
    }
}
