<?php

declare(strict_types=1);

namespace App\Permissions;

class ConflictPermissions
{
    public const VIEW = [
        'name' => 'view Conflict',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Conflict',
    ];

    public const CREATE = [
        'name' => 'create Conflict',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to create Conflict',
    ];

    public const EDIT = [
        'name' => 'edit Conflict',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to edit Conflict',
    ];

    public const DELETE = [
        'name' => 'delete Conflict',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Conflict',
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