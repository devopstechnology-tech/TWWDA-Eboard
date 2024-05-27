<?php

declare(strict_types=1);

namespace App\Permissions;

class MinutereviewPermissions
{
    public const VIEW = [
        'name' => 'view MinuteReview',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view MinuteReview',
    ];

    public const CREATE = [
        'name' => 'create MinuteReview',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create MinuteReview',
    ];

    public const EDIT = [
        'name' => 'edit MinuteReview',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit MinuteReview',
    ];

    public const DELETE = [
        'name' => 'delete MinuteReview',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete MinuteReview',
    ];
    public static function allPermissions(): array
    {
        return [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,        ];
    }
}