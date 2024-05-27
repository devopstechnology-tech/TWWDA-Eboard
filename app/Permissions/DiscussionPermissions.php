<?php

declare(strict_types=1);

namespace App\Permissions;

class DiscussionPermissions
{
    public const VIEW = [
        'name' => 'view Discussion',
        'type' => 'observer',
        'description' => 'Allows a user of type `observer` to view Discussion',
    ];

    public const CREATE = [
        'name' => 'create Discussion',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to create Discussion',
    ];

    public const EDIT = [
        'name' => 'edit Discussion',
        'type' => 'admin',
        'description' => 'Allows a user of type `admin` to edit Discussion',
    ];

    public const DELETE = [
        'name' => 'delete Discussion',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Discussion',
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