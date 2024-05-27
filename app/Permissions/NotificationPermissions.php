<?php

declare(strict_types=1);

namespace App\Permissions;

class NotificationPermissions
{
    public const VIEW = [
        'name' => 'view Notification',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Notification',
    ];

    public const CREATE = [
        'name' => 'create Notification',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to create Notification',
    ];

    public const EDIT = [
        'name' => 'edit Notification',
        'type' => 'companysecretary',
        'description' => 'Allows a user of type `companysecretary` to edit Notification',
    ];

    public const DELETE = [
        'name' => 'delete Notification',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Notification',
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