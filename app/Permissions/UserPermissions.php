<?php

declare(strict_types=1);

namespace App\Permissions;

class UserPermissions
{
    public const VIEW = [
        'name' => 'view User',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view User',
    ];

    public const CREATE = [
        'name' => 'create User',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to create User',
    ];

    public const EDIT = [
        'name' => 'edit User',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit User',
    ];

    public const DELETE = [
        'name' => 'delete User',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete User',
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