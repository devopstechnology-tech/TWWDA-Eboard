<?php

declare(strict_types=1);

namespace App\Permissions;

class SettingPermissions
{
    public const CREATE = [
        'name' => 'create settings',
        'type' => ['system'],
        'description' => 'Allows a user to create settings',
    ];

    public const UPDATE = [
        'name' => 'update settings',
        'type' => ['system'],
        'description' => 'Allows a user to update settings',
    ];

    public const VIEW = [
        'name' => 'view settings',
        'type' => ['system'],
        'description' => 'Allows a user to view settings',
    ];

    public static function allPermissions(): array
    {
        return [
            self::CREATE,
            self::UPDATE,
            self::VIEW,
        ];
    }
}