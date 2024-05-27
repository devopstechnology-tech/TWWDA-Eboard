<?php

declare(strict_types=1);

namespace App\Permissions;

class SettingPermissions
{
    public const VIEW = [
        'name' => 'view Setting',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Setting',
    ];

    public const CREATE = [
        'name' => 'create Setting',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to create Setting',
    ];

    public const EDIT = [
        'name' => 'edit Setting',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Setting',
    ];

    public const DELETE = [
        'name' => 'delete Setting',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Setting',
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