<?php

declare(strict_types=1);

namespace App\Permissions;

class MediaPermissions
{
    public const VIEW = [
        'name' => 'view Media',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Media',
    ];

    public const CREATE = [
        'name' => 'create Media',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to create Media',
    ];

    public const EDIT = [
        'name' => 'edit Media',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to edit Media',
    ];

    public const DELETE = [
        'name' => 'delete Media',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Media',
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