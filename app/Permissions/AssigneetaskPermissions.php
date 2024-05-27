<?php

declare(strict_types=1);

namespace App\Permissions;

class AssigneetaskPermissions
{
    public const VIEW = [
        'name' => 'view AssigneeTask',
        'type' => 'member',
        'description' => 'Allows a user of type `member` to view AssigneeTask',
    ];

    public const CREATE = [
        'name' => 'create AssigneeTask',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to create AssigneeTask',
    ];

    public const EDIT = [
        'name' => 'edit AssigneeTask',
        'type' => 'secretary',
        'description' => 'Allows a user of type `secretary` to edit AssigneeTask',
    ];

    public const DELETE = [
        'name' => 'delete AssigneeTask',
        'type' => 'system',
        'description' => 'Allows a user of type `system` to delete AssigneeTask',
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