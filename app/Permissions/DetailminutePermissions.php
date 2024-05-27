<?php

declare(strict_types=1);

namespace App\Permissions;

class DetailminutePermissions
{
    public const VIEW = [
        'name' => 'view DetailMinute',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view DetailMinute',
    ];

    public const CREATE = [
        'name' => 'create DetailMinute',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create DetailMinute',
    ];

    public const EDIT = [
        'name' => 'edit DetailMinute',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit DetailMinute',
    ];

    public const DELETE = [
        'name' => 'delete DetailMinute',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete DetailMinute',
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