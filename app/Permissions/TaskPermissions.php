<?php

declare(strict_types=1);

namespace App\Permissions;

class TaskPermissions
{
    public const VIEW = [
        'name' => 'view Task',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view Task',
    ];

    public const CREATE = [
        'name' => 'create Task',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create Task',
    ];

    public const EDIT = [
        'name' => 'edit Task',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit Task',
    ];

    public const DELETE = [
        'name' => 'delete Task',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete Task',
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