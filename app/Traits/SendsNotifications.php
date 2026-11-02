<?php

namespace App\Traits;

use App\Models\Notification;

trait SendsNotifications
{
    /**
     * Send notification to a user
     */
    public static function sendNotification(
        int $userId,
        string $type,
        string $title,
        string $message,
        ?string $relatedModel = null,
        ?int $relatedId = null,
        ?array $data = null
    ): Notification {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'related_model' => $relatedModel,
            'related_id' => $relatedId,
            'data' => $data,
        ]);
    }

    /**
     * Send notification to multiple users
     */
    public static function sendNotificationToMany(
        array $userIds,
        string $type,
        string $title,
        string $message,
        ?string $relatedModel = null,
        ?int $relatedId = null,
        ?array $data = null
    ): int {
        $count = 0;
        foreach ($userIds as $userId) {
            self::sendNotification(
                $userId,
                $type,
                $title,
                $message,
                $relatedModel,
                $relatedId,
                $data
            );
            $count++;
        }
        return $count;
    }

    /**
     * Send notification to all users of a specific role
     */
    public static function sendNotificationToRole(
        string $role,
        string $type,
        string $title,
        string $message,
        ?string $relatedModel = null,
        ?int $relatedId = null,
        ?array $data = null
    ): int {
        $users = \App\Models\User::where('role', $role)->pluck('id');
        return self::sendNotificationToMany(
            $users->toArray(),
            $type,
            $title,
            $message,
            $relatedModel,
            $relatedId,
            $data
        );
    }
}
