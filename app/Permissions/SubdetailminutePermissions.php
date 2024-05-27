<?php

declare(strict_types=1);

namespace App\Permissions;

class SubdetailminutePermissions
{
    public const VIEW = [
        'name' => 'view SubDetailMinute',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view SubDetailMinute',
    ];

    public const CREATE = [
        'name' => 'create SubDetailMinute',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create SubDetailMinute',
    ];

    public const EDIT = [
        'name' => 'edit SubDetailMinute',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit SubDetailMinute',
    ];

    public const DELETE = [
        'name' => 'delete SubDetailMinute',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete SubDetailMinute',
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