<?php

declare(strict_types=1);

namespace App\Permissions;

class PermissionPermissions
{
    public const VIEW = [
        'name' => 'view Permission',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Permission',
    ];

    public const CREATE = [
        'name' => 'create Permission',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to create Permission',
    ];

    public const EDIT = [
        'name' => 'edit Permission',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Permission',
    ];

    public const DELETE = [
        'name' => 'delete Permission',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Permission',
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